<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_name=GetUserName();
		if(isset($_REQUEST["action_"])) { 
			$date_cheque =dateFrToUs($_REQUEST["date_cheque"]);$client_tire=$_REQUEST["client_tire"];$id_registre=$_REQUEST["id_registre"];
			$client = $_REQUEST["client"];$total_cheque=$_REQUEST["total_cheque"];$id=$_REQUEST["user_id"];$date_remise=$_REQUEST["date_remise"];
			$numero_cheque=$_REQUEST["numero_cheque"];if(isset($_REQUEST["remise"])) { $remise = 1; $id_r=$id_registre;} else { $remise = 0; $id_r=0;}
					
					$sql  = "SELECT * ";
			$sql .= "FROM porte_feuilles_factures where id=$id ORDER BY id;";
			$users13 = db_query($database_name, $sql);$users1_3 = fetch_array($users13);$id_porte_feuille=$users1_3["id_porte_feuille"];
					
					$sql = "UPDATE porte_feuilles_factures SET ";
					$sql .= "numero_remise = '" . $id_r . "', ";
					$sql .= "date_remise = '" . $date_remise . "', ";
					$sql .= "remise = '" . $remise . "' ";
					$sql .= "WHERE id = " . $id . ";";
					db_query($database_name, $sql);
					
					//////////////
					$sql = "UPDATE porte_feuilles SET ";
					$sql .= "numero_remise = '" . $id_r . "', ";
					$sql .= "date_remise = '" . $date_remise . "', ";
					$sql .= "remise = '" . $remise . "' ";
					$sql .= "WHERE id = " . $id_porte_feuille . ";";
					db_query($database_name, $sql);
					
					
					
					
					}else
	{$id_registre = $_REQUEST["id_registre"];$date_remise = $_REQUEST["date_remise"];}

		// gets user infos
		$vide="";
		$sql  = "SELECT id,date_cheque,numero_cheque,facture_n,client,client_tire,v_banque,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as 			
		total_espece , sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
		$sql .= "FROM porte_feuilles_factures where numero_remise=0 and numero_cheque<>'$vide' and m_virement=0 Group BY id order by date_cheque;";
		$users11 = db_query($database_name, $sql);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
			UpdateUser();
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "registres_remises.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">
<table class="table2">
			<td><?php echo "Num Cheque";?></td>
			<td><?php echo "Client"; ?></td>
			<td><?php echo "Banque"; ?></td>
			<td><?php echo "Date Cheque"; ?></td>
			<td align="right"><?php echo "Montant"; ?></td>
			<td><?php echo "Facture"; ?></td>



<? while($users_1 = fetch_array($users11)) { 
			$numero_cheque=$users_1["numero_cheque"];$client_tire=$users_1["client_tire"];$v_banque=$users_1["v_banque"];$facture_n=$users_1["facture_n"];
			$client=$users_1["client"];$total_cheque=$users_1["total_cheque"];$date_cheque=dateUsToFr($users_1["date_cheque"]);$id=$users_1["id"];?>
			<tr>
			<? echo "<td><a href=\"remise1.php?date_remise=$date_remise&id_registre=$id_registre&user_id=$id\">".$numero_cheque."</a></td>";?>
			<td><?php echo $client_tire; ?></td>
			<td><?php echo $v_banque; ?></td>
			<td><?php echo $date_cheque; ?></td>
			<td align="right"><?php echo number_format($total_cheque,2,',',' '); ?></td>
			<td><?php echo $facture_n; ?></td>
<? } ?>
</table>

</center>

</body>

</html>