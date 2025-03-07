<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$id_registre = $_REQUEST["id_registre"];$date_remise = $_REQUEST["date_remise"];

	if($user_id == "0") {

		
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT numero_effet,id,remise,type_remise_effet,date_echeance,numero_cheque,facture_n,client,client_tire_e,v_banque_e,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as			
		total_espece , sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
		$sql .= "FROM porte_feuilles_factures where numero_effet='$user_id' Group BY numero_effet;";
		$users11 = db_query($database_name, $sql);$users_1 = fetch_array($users11);
			$numero_cheque=$users_1["numero_effet"];$client_tire=$users_1["client_tire_e"];$v_banque=$users_1["v_banque_e"];
			$remise=$users_1["remise_e"];$client=$users_1["client"];$total_cheque=$users_1["total_effet"];$type_remise_effet=$users_1["type_remise_effet"];
			$date_cheque=dateUsToFr($users_1["date_echeance"]);$id=$users_1["id"];

		}


	// extracts profile list
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $id_registre."-".$id."-".$user_id; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
		
			UpdateUser();
		
	}
	
	

	

--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo "" . $id_registre."-".$id."-".$user_id;?></span>

<form id="form_user" name="form_user" method="post" action="registre_remise_details1_e.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
		<tr>
		<td><?php echo "Numero Effet"; ?></td><td><input type="text" id="numero_cheque" name="numero_cheque" style="width:260px" value="<?php echo $numero_cheque; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Client"; ?></td><td><input type="text" id="client" name="client" style="width:260px" value="<?php echo $client; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Client Tire"; ?></td><td><input type="text" id="client_tire" name="client_tire" style="width:260px" value="<?php echo $client_tire; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Montant"; ?></td><td><input type="text" id="total_cheque" name="total_cheque" style="width:260px" value="<?php echo $total_cheque; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Date remise : "; ?></td><td><input type="text" id="date_cheque" name="date_cheque" style="width:260px" value="<?php echo $date_cheque; ?>"></td>
		</tr>
		<tr><td><input type="checkbox" id="remise" name="remise"<?php if($remise) { echo " checked"; } ?>></td><td><? echo "Remise Effet";?></td></tr>
		<tr><td><input type="checkbox" id="type_remise_effet" name="type_remise_effet"<?php if($type_remise_effet) { echo " checked"; } ?>></td><td><? echo "Remise Escompte";?></td></tr>
		
		</table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="id_registre" name="id_registre" value="<?php echo $id_registre; ?>">
<input type="hidden" id="date_remise" name="date_remise" value="<?php echo $date_remise; ?>">
<table class="table3"><tr>

<?php if($user_id != "0") { ?>
<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td style="width:20px"></td>
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php 
} ?>
</tr></table>

</center>

</form>

</body>

</html>