<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_name=GetUserName();
		
	$id_registre = $_REQUEST["id_registre"];

		// gets user infos
		
		$sql = "SELECT * FROM porte_feuilles where numero_remise_e=$id_registre and m_effet<>0 Group BY id;";
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
			$client=$users_1["client"];$m_effet=$users_1["m_effet"];$date_cheque=dateUsToFr($users_1["date_echeance"]);$type_remise_effet=$users_1["type_remise_effet"];
			$id=$users_1["id"];$tt=$tt+$m_effet;?>
			<tr>
			<? echo "<td>".$numero_cheque."</a></td>";?>
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