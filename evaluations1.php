<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];
	$error_message = "";$du="";$au="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {$date = $_REQUEST["date"];$vendeur = $_REQUEST["vendeur"];
		
		$id_registre = $_REQUEST["id_registre"];
			
			// prepares data to simplify database insert or update
			$client = $_REQUEST["client"];$date = dateFrToUs($_REQUEST["date"]);
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
		$sql  = "SELECT * ";
		$sql .= "FROM clients WHERE client = '$client' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$remise10 = $user_["remise10"];
		$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];
			
			}
		if($_REQUEST["action_"] == "update_user"){	
			$remise10 = $_REQUEST["remise10"];$remise2 = $_REQUEST["remise2"];$remise3 = $_REQUEST["remise3"];
			$vendeur = $_REQUEST["vendeur"];}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			break;
			case "delete_user":
			
			break;


		} //switch
	} //if
		else
	{	$id_registre=$_GET['id_registre'];
		$date=$_GET['date'];$date3=$_GET['date'];$valide=$_GET['valide'];
		$vendeur=$_GET['vendeur'];$bon_sortie=$_GET['bon_sortie'];$destination=$_GET['destination'];
		
	}
	
	$sql  = "SELECT * ";
	$sql .= "FROM commandes where vendeur='$vendeur' and id_registre='$id_registre' ORDER BY date_e;";
	$users = db_query($database_name, $sql);

	
	// recherche ville
		?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Evaluations"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "detail_evaluation.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "liste Evaluations"; ?></span>
<tr>
<td><?php echo $vendeur ." --> ".dateUsToFr($date) ;?></td>
</tr>

<table class="table2">

<tr>
	<th><?php echo "Evaluation";?></th>
	<th><?php echo "M�j";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "N� Eval";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Eval Vendeur";?></th>
	<th><?php echo "Net";?></th>
</tr>

<?php 

$total_g=0;while($users_ = fetch_array($users)) { ?><tr>
<? $client=$users_["client"];$commande=$users_["commande"];$evaluation=$users_["evaluation"];$net_e=$users_["net"];$escompte=$users_["escompte"];
$escompte2=$users_["escompte2"];$esc_plafond=$users_["esc_plafond"];
if ($evaluation<>"encours"){
echo "<td><a href=\"editer_evaluation_vendeur.php?destination=$destination&numero=$commande&client=$client&bon_sortie=$bon_sortie\">etat1  </a>";?>
<? echo "<a href=\"editer_evaluation_vendeur_ent_variante.php?destination=$destination&numero=$commande&client=$client&bon_sortie=$bon_sortie\">--etat2  </a>";?>
<? echo "<a href=\"editer_evaluation_vendeur_ent1.php?destination=$destination&numero=$commande&client=$client&bon_sortie=$bon_sortie\">--etat3 </a>";
//echo "<a href=\"editer_evaluation_vendeur_ent_variante.php?destination=$destination&numero=$commande&client=$client&bon_sortie=$bon_sortie\">--etat4 </a>";
if ($esc_plafond>0){echo "<a href=\"editer_evaluation_escompte.php?escompte=$escompte&escompte2=$escompte2&destination=$destination&numero=$commande&client=$client&bon_sortie=$bon_sortie\">--Escompte </a>";}
if ($esc_plafond>0 ) {if ($login=="admin" or $login=="rakia" or $login=="najat" or $login=="radia" or $login=="Radia" or $login=="NAJAT"){echo "<a href=\"editer_evaluation_vendeur_ent_es.php?escompte=$escompte&escompte2=$escompte2&destination=$destination&numero=$commande&client=$client&bon_sortie=$bon_sortie\">--Imp Ev/esc </a></td>";}}


} else {?>
<td><? $message="N� evaluation � completer avant impression !!";print("<font size=\"1\" face=\"Arial\" color=\"#3366FF\">$message </font>");?></td>
<? } ?>
<? $date=dateUsToFr($users_["date_e"]);
$vendeur=$users_["vendeur"];$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];
$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];?>
<?php $id=$users_["id"]; echo "<td>$id</td>";?>
<td><?php echo $date; ?></td>
<td><?php echo $evaluation; ?></td>
<td><?php echo $users_["client"]; ?></td>
<? if ($valide==0){echo "<td><a href=\"evaluation_vers_vendeur1.php?commande=$commande&id_registre=$id_registre&date=$date3&vendeur=$vendeur\">devalider</a></td>";}else
{echo "<td>Bon sortie valide</td>";}?>
<? ///////////////

	$sql1  = "SELECT * ";$m=0;$total=0;
	$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=0 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
//
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}

		$p=$users1_["prix_unit"];$total=$total+$m;
	}?>

<?
if ($sans_remise==1){$t=$total;$net=$total;} else {$t=$total;$remise_1=0;$remise_2=0;$remise_3=0;
if ($remise10>0){$remise_1=$total*$remise10/100;}?>
<? if ($remise2>0){$remise_2=($total-$remise_1)*$remise2/100;}?>
<? if ($remise3>0){$remise_3=($total-$remise_1-$remise_2)*$remise3/100;} ?>
<? }?>

<?	
	
	$sql1  = "SELECT * ";$total1=0;
	$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=1 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
//
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE ref = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}

$p=$users1_["prix_unit"];$total1=$total1+$m;}?>

<?php $net=$total+$total1-$remise_1-$remise_2-$remise_3; 

/////////////////?>

<td style="text-align:Right"><?php $total_g=$total_g+$net_e;echo number_format($net_e,2,',',' '); ?></td>
<?php } ?>
<tr><td></td><td></td><td></td><td></td><td></td><td></td>
<td style="text-align:Right"><?php echo number_format($total_g,2,',',' '); ?></td>
</tr>

</table>
<tr>
</tr>

<p style="text-align:center">

</body>

</html>