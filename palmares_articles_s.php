<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";$action="Recherche";$date="";$date1="";$du="";$au="";
	
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
	<form id="form" name="form" method="post" action="palmares_articles_s.php">
	<td><?php echo "Du : "; ?><input onClick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au : "; ?><input onClick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{
	
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];
	$du=$_POST['date'];$au=$_POST['date1'];$t_prix_p=0;$vide="";$encours="encours";

	$sql  = "SELECT commande,valeur,produit,sans_remise,quantite,condit,date,sum(valeur) As total_prix,sum(quantite*condit) As total_quantite ,sum(quantite) As t_quantite ";
	$sql .= "FROM detail_commandes where date between '$date' and '$date1' and evaluation<>'$vide' and evaluation<>'$encours' and bon_sortie<>'$vide' GROUP BY produit order by total_prix DESC;";
	$users = db_query($database_name, $sql);
	
	while($users_ = fetch_array($users)) {
		
		$sql  = "SELECT * ";$commande=$users_["commande"];$sr=$users_["sans_remise"];
		$sql .= "FROM commandes WHERE commande = '$commande' ";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];$remise3 = $user_["remise_3"];$sans_remise = $user_["sans_remise"];
		if ($sans_remise==0)
		
				{
				if ($sr==0){
		/*$prix=$users_["total_prix"]*(1-$remise10/100);*/
		$r10=$users_["total_prix"]*$remise10/100;$net1=$users_["total_prix"]-$r10;
		$r2=$net1*$remise2/100;$net2=$net1-$r2;
		$r3=$net2*$remise3/100;$net3=$net2-$r3;
		/*$prix=$prix*(1-$remise2/100);
		$prix=$prix*(1-$remise3/100);*/}
		else
		{$net3=$users_["total_prix"];}
		}
		else{$net3=$users_["total_prix"];}
		$net3=$users_["total_prix"];
		$t_prix_p=$t_prix_p+$net3;
		
	}
	$encours="encours";
		$sql  = "SELECT valeur,commande,produit,sans_remise,quantite,condit,date,sum(valeur) As total_prix,sum(quantite*condit) As total_quantite ,sum(quantite) As t_quantite ";
	$sql .= "FROM detail_commandes where date between '$date' and '$date1' and evaluation<>'$vide' and evaluation<>'$encours' and bon_sortie<>'$vide' GROUP BY produit order by total_prix DESC;";
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
	<th><?php echo "Valeur";?></th>
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
		/*$prix=$users_["total_prix"]*(1-$remise10/100);*/
		$r10=$users_["total_prix"]*$remise10/100;$net1=$users_["total_prix"]-$r10;
		$r2=$net1*$remise2/100;$net2=$net1-$r2;
		$r3=$net2*$remise3/100;$net3=$net2-$r3;
		/*$prix=$prix*(1-$remise2/100);
		$prix=$prix*(1-$remise3/100);*/}
		else
		{$net3=$users_["total_prix"];}
		}
		else{$net3=$users_["total_prix"];}
		$net=$users_["total_prix"];
		
?>
<td align="right"><?php echo number_format($net,2,',',' ');$t_prix=$t_prix+$net;?></td>
<td align="right"><?php echo number_format($net/$t_prix_p*100,2,',',' ')." %";?></td>

<?php } ?>
<tr>
<td></td><td></td><td></td>
<td align="right"><?php echo number_format($t_prix,2,',',' ');?></td>
</tr>
</table>

<?php } ?>

<p style="text-align:center">

</body>

</html>