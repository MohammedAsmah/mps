<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$id_registre = $_REQUEST["id_registre"];

	if($user_id == "0") {

		
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT numero_effet,date_echeance,id,remise,r_impaye,date_impaye,errone,mode_enc1,encaisse,montant1,date_enc1,ref1,date_cheque,numero_cheque,facture_n,client,client_tire,v_banque,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as			
		total_espece , sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
		$sql .= "FROM porte_feuilles where id='$user_id' Group BY id;";
		$users11 = db_query($database_name, $sql);$users_1 = fetch_array($users11);
			$numero_cheque=$users_1["numero_cheque"];$client_tire=$users_1["client_tire"];$v_banque=$users_1["v_banque"];$remise=$users_1["remise"];$encaisse=$users_1["encaisse"];
			$client=$users_1["client"];$total_cheque=$users_1["total_cheque"];$date_cheque=dateUsToFr($users_1["date_cheque"]);$id=$users_1["id"];
			$r_impaye=$users_1["r_impaye"];$errone=$users_1["errone"];$date_impaye=dateUsToFr($users_1["date_impaye"]);
			$numero_effet=$users_1["numero_effet"];$total_effet=$users_1["total_effet"];$date_echeance=dateUsToFr($users_1["date_echeance"]);
			$mode_enc1=$users_1["mode_enc1"];$montant1=$users_1["montant1"];$date_enc1=dateUsToFr($users_1["date_enc1"]);$ref1=$users_1["ref1"];
			$titre="Cheque";
			if ($total_cheque==0){$total_cheque=$total_effet;$date_cheque=$date_echeance;$titre="Effet";}			
		}


	// extracts profile list
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
		if(document.getElementById("numero_cheque").value == "" ) {
			alert("<?php echo Translate("The values for the fields are required !"); ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression de ce client ?"; ?>")) {
			document.location = "clients.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

	function Editcontrat(user_id) { document.location = "contrats_sejours.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php ?></span>

<form id="form_user" name="form_user" method="post" action="recherche.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
		<tr>
		<td><?php echo "Numero "; ?></td><td><input type="text" id="numero_cheque" name="numero_cheque" style="width:260px" value="<?php echo $numero_cheque.$numero_effet; ?>"></td>
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
		<tr><td><input type="checkbox" id="remise" name="remise"<?php if($remise) { echo " checked"; } ?>></td><td><? echo $titre." remis";?></td></tr>
		<tr><td><input type="checkbox" id="r_impaye" name="r_impaye"<?php if($r_impaye) { echo " checked"; } ?>></td><td><? echo "Retour impaye";?></td></tr>
		<tr>
		<td><?php echo "Date impaye : "; ?></td><td><input type="text" id="date_impaye" name="date_impaye" style="width:100px" value="<?php echo $date_impaye; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Encaissé : "; ?></td><td><input type="checkbox" id="encaisse" name="encaisse"<?php if($encaisse) { echo " checked"; } ?>></td></tr>
		</tr>
		
		</table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="id_registre" name="id_registre" value="<?php echo $id_registre; ?>">
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