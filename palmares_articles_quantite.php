<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	

	
	//reset 
	$activer=0;
	$sql = "UPDATE produits SET palmares = $activer where palmares=1 ";
	db_query($database_name, $sql);?>
	<table>
	<?
	$t1=$_POST['utilities1'];
	reset($t1);
	while (list($key, $val) = each($t1))
	 {   $val=stripslashes($val); 
	 
	 //
	$activer=1;
	$sql = "UPDATE produits SET palmares = $activer WHERE produit='$val'";
	db_query($database_name, $sql);
	 }
	?>
	</table>
	


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
		<? require "body_cal.php";?>

	<?
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];
	$du=$_POST['date'];$au=$_POST['date1'];$t_prix_p=0;$vide="";$encours="encours";

	$encours="encours";
	$sql2  = "SELECT valeur,commande,produit,sans_remise,quantite,condit,date,sum(valeur) As total_prix,sum(quantite*condit) As total_quantite ,sum(quantite) As t_quantite ";
	$sql2 .= "FROM detail_commandes where date between '$date' and '$date1' and evaluation<>'$vide' and evaluation<>'$encours' and bon_sortie<>'$vide' GROUP BY produit order by total_prix DESC;";
	$users2 = db_query($database_name, $sql2);$q2=0;
	while($users_2 = fetch_array($users2)) { ?><?php $p2=$users_2["produit"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$p2' ";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$palmares2 = $user_2["palmares"];
	if ($palmares2){$q2=$q2+$users_2["total_quantite"];}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	$sql  = "SELECT valeur,commande,produit,sans_remise,quantite,condit,date,sum(valeur) As total_prix,sum(quantite*condit) As total_quantite ,sum(quantite) As t_quantite ";
	$sql .= "FROM detail_commandes where date between '$date' and '$date1' and evaluation<>'$vide' and evaluation<>'$encours' and bon_sortie<>'$vide' GROUP BY produit order by total_quantite DESC;";
	$users = db_query($database_name, $sql);
	
	
	

	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Palmares Articles $du au $au"; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Article";?></th>
	
	
	<th><?php echo "Quantite";?></th>
	<th><?php echo "%";?></th>
</tr>

<?php $debit=0;$credit=0;$t=0;$s=0;$t_poids=0;$t_prix=0;$t_poids_evaluation=0;?>

<? while($users_ = fetch_array($users)) { ?><?php $p=$users_["produit"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$p' ";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$palmares = $user_["palmares"];
if ($palmares){?>
<tr>
<td><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$p </font>");?>
<td align="right"><?php $q=$users_["total_quantite"];
print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$q </font>");
$commande=$users_["commande"];?></td>
<td align="right"><?php $npc= number_format($q/$q2*100,2,',',' ')." %";print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$npc </font>");?></td>
<?php } ?>
<?php } ?>

</table>


<p style="text-align:center">

</body>

</html>