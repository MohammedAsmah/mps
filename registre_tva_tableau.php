<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	//CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

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
		$com_cash_ag_e=0;$mend=0;
		
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM registres_tva WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

			$du = dateUsToFr($user_["du"]);$au = dateUsToFr($user_["au"]);
			$annee = $user_["annee"];$ca_annee = $user_["ca_annee"];$ca_declare = $user_["ca_declare"];$ca_exonore = $user_["ca_exonore"];
			$clients_n = $user_["clients_n"];
			$effets_recevoir_n = $user_["effets_recevoir_n"];
			$clients_douteux_n = $user_["clients_douteux_n"];
			$a_c_n = $user_["a_c_n"];
			$clients_n_1 = $user_["clients_n_1"];
			$effets_recevoir_n_1 = $user_["effets_recevoir_n_1"];
			$clients_douteux_n_1 = $user_["clients_douteux_n_1"];
			$a_c_n_1 = $user_["a_c_n_1"];
			$ca_a_declare = ($ca_annee-$ca_exonore)*1.20+($clients_n_1+$effets_recevoir_n_1+$clients_douteux_n_1)-($a_c_n_1+$clients_n+$effets_recevoir_n+$clients_douteux_n)+$a_c_n;
			$ttc=($ca_annee-$ca_exonore)*1.20;
		}
	

	// extracts profile list
?>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "MISE A JOUR TVA"; ?></title>

<link rel="stylesheet" type="text/css" href="css/bootstrap.css">

<script type="text/javascript">
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
		
			UpdateUser();
		
	}
</script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="registres_tva_tableau.php">

<table class="table table-striped"><tr>



<td style="text-align:center">

	<center>

	<table class="table3">
		
		<tr>
		<td><?php echo "ANNEE"; ?></td><td><input type="text" id="annee" name="annee" style="width:260px" value="<?php echo $annee; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "DU"; ?></td><td><input type="text" id="du" name="du" style="width:260px" value="<?php echo $du; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "AU"; ?></td><td><input type="text" id="au" name="au" style="width:260px" value="<?php echo $au; ?>"></td>
		</tr>
	
		<tr>
		<td><?php echo "CHIFFRE AFFAIRE EXERCICE EN COURS HT"; ?></td><td><input type="text" name="ca_annee" id="ca_annee" value="<?php echo $ca_annee; ?>"  style="width:260px" ></td>
		</tr>
		<tr>
		<td><?php echo "CHIFFRE AFFAIRE EXONORE"; ?></td><td><input type="text" id="ca_exonore" name="ca_exonore"  style="width:260px" value="<?php echo $ca_exonore; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "CHIFFRE AFFAIRE TTC"; ?></td><td><?php echo number_format($ttc,2,',',' '); ?></td>
		</tr>
		<tr>
		<td><?php echo "CLIENTS N-1"; ?></td><td><input type="text" id="clients_n_1" name="clients_n_1"  style="width:260px" value="<?php echo $clients_n_1; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "EFFETS A RECEVOIR N-1 "; ?></td><td><input type="text" id="effets_recevoir_n_1" name="effets_recevoir_n_1"  style="width:260px" value="<?php echo $effets_recevoir_n_1; ?>"></td>
		</tr>

		<tr>
		<td><?php echo "CLIENTS DOUTEUX N-1 "; ?></td><td ><input type="text" id="clients_douteux_n_1" name="clients_douteux_n_1"  style="width:260px" value="<?php echo $clients_douteux_n_1; ?>"></td>
		</tr>
		
		<tr>
		<td><?php echo "A/C N-1"; ?></td><td ><input type="text" id="a_c_n_1" name="a_c_n_1"  style="width:260px" value="<?php echo $a_c_n_1; ?>"></td>
		</tr>

		
		<tr>
		<td><?php echo "CLIENTS EXERCICE EN COURS"; ?></td><td ><input type="text" id="clients_n" name="clients_n"  style="width:260px" value="<?php echo $clients_n; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "EFFETS A RECEVOIR EXERCICE EN COURS"; ?></td><td><input type="text" id="effets_recevoir_n" name="effets_recevoir_n"  style="width:260px" value="<?php echo $effets_recevoir_n; ?>"></td>
		</tr>

		<tr>
		<td><?php echo "CLIENTS DOUTEUX EXERCICE EN COURS"; ?></td><td ><input type="text" id="clients_douteux_n" name="clients_douteux_n"  style="width:260px" value="<?php echo $clients_douteux_n; ?>"></td>
		</tr>
		
		<tr>
		<td><?php echo "A/C EXERCICE EN COURS"; ?></td><td ><input type="text" id="a_c_n" name="a_c_n"  style="width:260px" value="<?php echo $a_c_n; ?>" ></td>
		</tr>
		<tr>
		<td><?php echo "++++++++++++++++++++++++++++++++++++++++++"; ?></td><td><?php echo "+++++++++++++++++++++++++++++++++"; ?></td>
		</tr>
		<tr>
		<td bgcolor="#3366FF"><?php echo "CHIFFRE AFFAIRE A DECLARE "; ?></td><td><?php echo number_format($ca_a_declare,2,',',' '); ?></td>
		</tr>
		<tr>
		<td bgcolor="#66FFFF"><?php echo "CA DECLARE"; ?></td><td><input type="text" id="ca_declare" name="ca_declare"  style="width:260px" value="<?php echo $ca_declare; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "DIFFERENCE  "; ?></td><td><?php echo number_format($ca_declare-$ca_a_declare,2,',',' '); ?></td>
		
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