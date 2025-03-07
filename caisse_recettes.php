<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="EXCURSIONS";
		$action="Recherche";$sel=1;$lp="";	
				$sql  = "SELECT * ";$sel=1;$lp="";
		$sql .= "FROM mois_rak WHERE encours = " . $sel . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$mois = $user_["mois"];$montant=0;
		$du = dateUsToFr($user_["du"]);
		$au = dateUsToFr($user_["au"]);$client="";$action="Recherche";

	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_fact_modif"]))
	{$montant_enc=$_REQUEST["montant_enc"];$mode_enc=$_REQUEST["mode_enc"];$ref_enc=$_REQUEST["ref_enc"];
	
			$sql = "UPDATE details_bookings_excursions_rak SET ";
			$sql .= "adultes = '" . $_REQUEST["adultes"] . "', ";
			$sql .= "enfants = '" . $_REQUEST["enfants"] . "', ";
			$sql .= "n_ref = '" . $_REQUEST["n_ref"] . "', ";
			$sql .= "v_ref = '" . $_REQUEST["v_ref"] . "', ";
			$sql .= "noms = '" . $_REQUEST["noms"] . "', ";
			$sql .= "montant_enc = '" . $montant_enc. "', ";
			$sql .= "ref_enc = '" . $ref_enc. "', ";
			$sql .= "mode_enc = '" . $mode_enc. "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			$action="Recherche";
	}	
	else
	{
	if(isset($_REQUEST["action"]))
	{
	 $date1=dateFrToUs($_POST['date1']);$date2=dateFrToUs($_POST['date2']);}
	
	else
	{
	$action="Recherche";$action_t="Par Periode";
	$date1="";$date2="";$client_rech="";$mode1="";$produit="";$lp="";$rep="";
	}

	}
	
	
	if(isset($_REQUEST["action"]))
	{}else {
	?>
	
	<form id="form" name="form" method="post" action="caisse_recettes.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" / value="<?php echo $du; ?>"></td>
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date2" readonly="readonly" style="cursor: text" / value="<?php echo $au; ?>"></td><tr>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	<? }

	if(isset($_REQUEST["action"]))
	{
	 $date1=dateFrToUs($_POST['date1']);$date2=dateFrToUs($_POST['date2']);
	}
	else
	{$date1="";$date2="";}
	$pdu="";$pau="";
	if(isset($_REQUEST["action"]))
	{
	list($annee1,$mois1,$jour1) = explode('-', $date1); 
	$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
	list($annee1,$mois1,$jour1) = explode('-', $date2); 
	$pau = mktime(0,0,0,$mois1,$jour1,$annee1); 
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre_excursion_encaisse.php?user_id=" + user_id; }
--></script>

<style type="text/css">
<!--
.Style1 {color: #CC3300}
-->
</style>
</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?>
<p>

<span style="font-size:24px"><?php echo ""; ?></span>

<? $jour=date("d/m/Y");$net_t=0;echo dateUsToFr($date1)."  au  : ".dateUsToFr($date2)." SITUATION CAISSE RECETTES A CE JOUR : ".$jour;


$net_tt=0;$pax_adt_t=0;$pax_enf_t=0;
	
	if(isset($_REQUEST["action"]))
	{?>
	
	<table class="table2" bordercolordark="#333333">
<tr></tr>
<td width="150"><? echo "Libelle";?></td><td width="150"><? echo "Debit";?></td><td width="150"><? echo "Credit";?></td>
<tr><td width="150"><? echo "Recettes en Espece";?></td>

<?
	$sql  = "SELECT * ";$mode="ESPECE";
	$sql .= "FROM details_bookings_excursions_rak where arrivee between '$date1' and '$date2' and mode_enc='$mode' ORDER BY id;";
	$users1 = db_query($database_name, $sql);
	while($users_b1_ = fetch_array($users1)) {  
	$montant=$montant+$users_b1_["montant_enc"];
	}
	
	?>
	
	<td width="120" align="right">
	<?php $montant1=number_format($montant,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#CC3300\">$montant1 </font>") ; ?></td>
	<td width="120" align="right">
	<tr>

<?

	$sql  = "SELECT * ";$mode="ESPECE";
	$sql .= "FROM banque_rak where date between '$date1' and '$date2' ORDER BY id;";
	$users1 = db_query($database_name, $sql);$montant_v=0;
	while($users_b1_ = fetch_array($users1)) {  
	?><tr><td width="120" align="left">
	<?php $libelle=$users_b1_["libelle"].$users_b1_["ref"];;print("<font size=\"2\" face=\"Comic sans MS\" color=\"#CC3300\">$libelle </font>") ; ?></td>
	<td width="120" align="right"></td>
	<td width="120" align="right">
	<?php $montant1=number_format($users_b1_["debit"],2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#CC3300\">$montant1 </font>") ; ?></td></tr>
<?
	$montant_v=$montant_v+$users_b1_["debit"];
	}
	
	?>
	
	<tr>

<td>Solde Caisse</td><td><?php $solde=number_format($montant-$montant_v,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#CC3300\">$solde </font>") ; ?></td>
</td>

<? }?>

</body>

</html>