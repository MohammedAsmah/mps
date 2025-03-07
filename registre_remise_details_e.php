<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_name=GetUserName();
		if(isset($_REQUEST["action_"])) { 
			$date_cheque =dateFrToUs($_REQUEST["date_cheque"]);$client_tire=$_REQUEST["client_tire"];$id_registre=$_REQUEST["id_registre"];
			$client = $_REQUEST["client"];$total_cheque=$_REQUEST["total_cheque"];$id=$_REQUEST["user_id"];
			$numero_cheque=$_REQUEST["numero_cheque"];$date_impaye =dateFrToUs($_REQUEST["date_impaye"]);
			if(isset($_REQUEST["remise"])) { $remise = 1; $id_r=$id_registre;} else { $remise = 0; $id_r=0;}
			if(isset($_REQUEST["type_remise_effet"])) { $type_remise_effet = 1; $id_r=$id_registre;} else { $type_remise_effet = 0; $id_r=0;}
			if(isset($_REQUEST["r_impaye"])) { $r_impaye = 1; } else { $r_impaye = 0; }
					
					$sql  = "SELECT * ";
			$sql .= "FROM porte_feuilles_factures where id=$id ORDER BY id;";
			$users13 = db_query($database_name, $sql);$users1_3 = fetch_array($users13);$id_porte_feuille=$users1_3["id_porte_feuille"];
					
					
					$sql = "UPDATE porte_feuilles_factures SET ";
					$sql .= "numero_remise_e = '" . $id_r . "', ";
					$sql .= "date_impaye_e = '" . $date_impaye . "', ";
					$sql .= "type_remise_effet = '" . $type_remise_effet . "', ";
					$sql .= "r_impaye_e = '" . $r_impaye . "', ";
					$sql .= "remise_e = '" . $remise . "' ";
					$sql .= "WHERE id = " . $id . ";";
					db_query($database_name, $sql);
					
					//////
					$sql = "UPDATE porte_feuilles SET ";
					$sql .= "numero_remise_e = '" . $id_r . "', ";
					$sql .= "date_impaye_e = '" . $date_impaye . "', ";
					$sql .= "r_impaye_e = '" . $r_impaye . "', ";
					$sql .= "remise_e = '" . $remise . "' ";
					$sql .= "WHERE id = " . $id_porte_feuille . ";";
					db_query($database_name, $sql);
					
					///insertion cheque impaye :
					
					
					
					
					
					}else
	{$id_registre = $_REQUEST["id_registre"];}

		// gets user infos
		$sql  = "SELECT m_effet,id,date_echeance,numero_effet,type_remise_effet,facture_n,client,client_tire_e,v_banque_e,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as 			
		total_espece , sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
		$sql .= "FROM porte_feuilles_factures where numero_remise_e='$id_registre' and m_effet<>0 Group BY id;";
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
			<td><?php echo "Num Effet";?></td>
			<td><?php echo "Client"; ?></td>
			<td><?php echo "Banque"; ?></td>
			<td><?php echo "Date Echeance"; ?></td>
			<td align="right"><?php echo "Montant"; ?></td>



<? 
$tt=0;
while($users_1 = fetch_array($users11)) { 
			$numero_cheque=$users_1["numero_effet"];$client_tire=$users_1["client_tire_e"];$v_banque=$users_1["v_banque_e"];
			$client=$users_1["client"];$m_effet=$users_1["total_effet"];$date_cheque=dateUsToFr($users_1["date_echeance"]);$type_remise_effet=$users_1["type_remise_effet"];
			$id=$users_1["id"];$tt=$tt+$m_effet;?>
			<tr>
			<? echo "<td><a href=\"remise_e.php?id_registre=$id_registre&user_id=$id\">".$numero_cheque."</a></td>";?>
			<td><?php echo $client_tire; ?></td>
			<td><?php echo $v_banque; ?></td>
			<td><?php echo $date_cheque; ?></td>
			<? if ($type_remise_effet==1){?>
			<td align="right"><?php echo number_format($m_effet,2,',',' '); ?></td>
			<? } else {?>
			<td align="left"><?php echo number_format($m_effet,2,',',' '); ?></td>
			<? } ?>

<? } ?>
<tr><td></td><td></td><td></td><td></td>
<td align="right"><?php echo number_format($tt,2,',',' ');?></td></tr>
</table>

</center>

</body>

</html>