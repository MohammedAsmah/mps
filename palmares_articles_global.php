<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
$valeur=3600;
set_time_limit($valeur);
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";

	$error_message = "";$caisse="";$action="Recherche";$date="";$date1="";$du="";$au="";$tg_prix=0;
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	

?>

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
	
			if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="palmares_articles_global.php">
	<td><?php echo "Du : "; ?><input onClick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au : "; ?><input onClick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{
	
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];
	$du=$_POST['date'];$au=$_POST['date1'];$t_prix_p=0;$vide="";$encours="encours";$nqt=0;

	$sql  = "SELECT commande,valeur,produit,sans_remise,quantite,condit,date,sum(quantite*condit*prix_unit) As total_prix,sum(quantite*condit) As total_quantite ,sum(quantite) As t_quantite ";
	$sql .= "FROM detail_commandes where date between '$date' and '$date1' and evaluation<>'$vide' and evaluation<>'$encours' and escompte_exercice=0 GROUP BY produit order by total_prix DESC;";
	$users = db_query($database_name, $sql);
	
	while($users_ = fetch_array($users)) {
		
		$sql  = "SELECT * ";$commande=$users_["commande"];$sr=$users_["sans_remise"];
		$sql .= "FROM commandes WHERE commande = '$commande' ";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];$remise3 = $user_["remise_3"];$sans_remise = $user_["sans_remise"];$client = $user_["client"];
		if ($sans_remise==0)
		
				{
				if ($sr==0){
		
		$r10=$users_["total_prix"]*$remise10/100;$net1=$users_["total_prix"]-$r10;
		$r2=$net1*$remise2/100;$net2=$net1-$r2;
		$r3=$net2*$remise3/100;$net3=$net2-$r3;
		}
		else
		{$net3=$users_["total_prix"];}
		}
		else{$net3=$users_["total_prix"];}
		$net3=$users_["total_prix"];
		$t_prix_p=$t_prix_p+$net3;
		
	}
	$encours="encours";
		$sql  = "SELECT evaluation,valeur,commande,produit,sans_remise,quantite,condit,date,sum(quantite*condit*prix_unit) As total_prix,sum(quantite*condit) As total_quantite ,sum(quantite) As t_quantite ";
	$sql .= "FROM detail_commandes where date between '$date' and '$date1' and evaluation<>'$encours' and evaluation<>'$vide' and escompte_exercice=0 GROUP BY produit order by total_prix DESC;";
	$users = db_query($database_name, $sql);

	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Palmares Articles $du au $au"; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Article";?></th>
	<th></th>
	<th><?php echo "Quantite";?></th>
	<th><?php echo "Condit.";?></th>
	<th><?php echo "Poids Fa";?></th>
	<th><?php echo "Poids Ev";?></th>
	<th><?php echo "Valeur";?></th>
	<th><?php echo "Px Rv Kg";?></th>
	<th><?php echo "%";?></th>
</tr>

<?php $debit=0;$credit=0;$t=0;$s=0;$t_poids=0;$t_prix=0;$t_poids_evaluation=0;
while($users_ = fetch_array($users)) { ?><tr>
<td><?php $p=$users_["produit"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$p </font>");$sr=$users_["sans_remise"];?></td>
<? $bs= "<td><a href=\"palmares_articles_details_bons.php?produit=$p&date=$date&date1=$date1\">- BS -</a>";
print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$bs </font>");?>
<? $v= "<a href=\"palmares_articles_details_vendeurs.php?produit=$p&date=$date&date1=$date1\">- Vendeur -</a>";
print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$v </font>");?>
<? $c= "<a href=\"palmares_articles_details_clients.php?produit=$p&date=$date&date1=$date1\">- Client -</a></td>";
print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$c </font>");?>
<td align="right"><?php $q=$users_["total_quantite"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$q </font>");
$commande=$users_["commande"];?></td>
<td align="right"><?php $c=$users_["t_quantite"]." x ".$users_["condit"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$c </font>");
$commande=$users_["commande"];?></td>



<?
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$p' ";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$poids = $user_["poids"]*$q;$poids_evaluation = $user_["poids_evaluation"]*$q;
		$sql  = "SELECT * ";
		$sql .= "FROM commandes WHERE commande = '$commande' ";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];$remise3 = $user_["remise_3"];$sans_remise = $user_["sans_remise"];
		
		if ($sans_remise==0)
		
				{
				if ($sr==0){
		
		$r10=$users_["total_prix"]*$remise10/100;$net1=$users_["total_prix"]-$r10;
		$r2=$net1*$remise2/100;$net2=$net1-$r2;
		$r3=$net2*$remise3/100;$net3=$net2-$r3;
		}
		else
		{$net3=$users_["total_prix"];}
		}
		else{$net3=$users_["total_prix"];}
		$net=$users_["total_prix"];
		
?>
<td align="right"><?php $pp=number_format($poids/1000,3,',',' ');$t_poids=$t_poids+$poids/1000;print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$pp </font>");?></td>
<td align="right"><?php $pp=$poids_evaluation/1000;$pe= number_format($poids_evaluation/1000,3,',',' ');$t_poids_evaluation=$t_poids_evaluation+$poids_evaluation/1000;print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$pe </font>");?></td>
<td align="right"><?php $nt= number_format($net3,2,',',' ');$t_prix=$t_prix+$net3;$tg_prix=$tg_prix+$net3;print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$nt </font>");?></td>
<td align="right"><?php @$nq= number_format($net3/$pp,2,',',' ');$nqt=$nqt+$nq;print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$nq </font>");?></td>
<td align="right"><?php @$npc= number_format($net/$t_prix_p*100,2,',',' ')." %";print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$npc </font>");?></td>

<?php } ?>
<tr>
<td></td><td></td><td></td><td></td>
<td align="right"><?php $tp= number_format($t_poids,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tp </font>");?></td>
<td align="right"><?php $tpev= number_format($t_poids_evaluation,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tpev </font>");?></td>
<td align="right"><?php $tpr= number_format($tg_prix,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tpr </font>");?></td>
<td align="right"><?php $nqt= number_format($t_prix/$t_poids_evaluation,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$nqt </font>");?></td>

<td></td></tr>
</table>

<?php } ?>

<p style="text-align:center">

</body>

</html>