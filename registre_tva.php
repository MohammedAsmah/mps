<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$login = "";$patente = "";
		$last_name = "";
		$first_name = "";$ville="";$vendeur="";$inputation="";
		$email = "";
		$locked = "";
		$profile_id = 0;
		$remarks = "";
		$remise2=0;$remise10=0;
		$remise3=0;
		$com_debiteur_to_a=0;
		$com_debiteur_to_e=0;
		$com_cash_rep_a=0;
		$com_cash_rep_e=0;
		$com_cash_ag_a=0;
		$com_cash_ag_e=0;$mend=0;$m_represente=0;
		
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM tva_2024 WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$login = $user_["ref"];$excedents_factures = $user_["excedents_factures"];
		$avance_commande_moisprecedent = $user_["avance_commande_moisprecedent"];
		$avance_commande_moisencours = $user_["avance_commande_moisencours"];
		$tva_a_recuperer = $user_["tva_a_recuperer"];		$arrondi = $user_["arrondi"];$caexonore = $user_["caexonore"];
		$numeroexonore=$user_["numeroexonore"];$mend=$user_["mend"];$m_represente=$user_["m_represente"];
		$credit_mois_precedent = $user_["credit_mois_precedent"];
		}
	

	// extracts profile list
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
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression de ce client ?"; ?>")) {
			document.location = "clients.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

	function Editcontrat(user_id) { document.location = "contrats_sejours.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="registres_tva.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
		
		<tr>
		<td><?php echo "Excedent sur Factures"; ?></td><td><input type="text" id="excedents_factures" name="excedents_factures" style="width:260px" value="<?php echo $excedents_factures; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "C.A EXONORE"; ?></td><td><input type="text" id="caexonore" name="caexonore" style="width:260px" value="<?php echo $caexonore; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "E. N. D."; ?></td><td><input type="text" id="mend" name="mend" style="width:260px" value="<?php echo $mend; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Impayes Representes"; ?></td><td><input type="text" id="m_represente" name="m_represente" style="width:260px" value="<?php echo $m_represente; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Numero Exonoration"; ?></td><td><input type="text" id="numeroexonore" name="numeroexonore" style="width:260px" value="<?php echo $numeroexonore; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Avance sur commande mois precedent : "; ?></td><td><input type="text" id="avance_commande_moisprecedent" name="avance_commande_moisprecedent" style="width:260px" value="<?php echo $avance_commande_moisprecedent; ?>"></td>
		</tr>

		<tr>
		<td><?php echo "Avance sur commande mois en cours : "; ?></td><td><input type="text" id="avance_commande_moisencours" name="avance_commande_moisencours" style="width:260px" value="<?php echo $avance_commande_moisencours; ?>"></td>
		</tr>
		
		<tr>
		<td><?php echo "TVA A RECUPERER : "; ?></td><td><input type="text" id="tva_a_recuperer" name="tva_a_recuperer" style="width:260px" value="<?php echo $tva_a_recuperer; ?>"></td>
		</tr>

		<tr>
		<td><?php echo "CREDIT MOIS PRECEDENTS : "; ?></td><td><input type="text" id="credit_mois_precedent" name="credit_mois_precedent" style="width:260px" value="<?php echo $credit_mois_precedent; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "ARRONDI : "; ?></td><td><input type="text" id="arrondi" name="arrondi" style="width:260px" value="<?php echo $arrondi; ?>"></td>
		</tr>
		</table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">

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