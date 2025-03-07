<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$date=$_GET['date'];$date1=$_GET['date1'];$produit=$_GET['produit'];
	$du=dateUsToFr($_GET['date']);$au=dateUsToFr($_GET['date1']);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
	
	
<?			
	$encours="encours";$vide="";
	$sql  = "SELECT commande,sans_remise,produit,quantite,condit,date,bon_sortie,vendeur,client,sum(quantite*condit*prix_unit) As total_prix,sum(quantite*condit) As total_quantite ,sum(quantite) As t_quantite ";
	$sql .= "FROM detail_commandes where produit='$produit' and (date between '$date' and '$date1') and evaluation<>'$vide' and evaluation<>'$encours' and bon_sortie<>'$vide' GROUP BY client order by total_quantite DESC;";
	$users = db_query($database_name, $sql);
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Palmares Article par Client : $produit $du au $au "; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "Paquets";?></th>
	<th><?php echo "Quantite";?></th>
	<th><?php echo "Valeur";?></th>

</tr>

<?php $debit=0;$credit=0;$t=0;$s=0;$t_q=0;$t_prix_p=0;$t_prix=0;
while($users_ = fetch_array($users)) { ?><tr>
<td><?php echo $users_["client"];$sr=$users_["sans_remise"];?></td>
<td><?php echo $users_["vendeur"];?></td>
<td align="right"><?php echo $users_["t_quantite"];?></td>
<td align="right"><?php $q=$users_["total_quantite"];echo $users_["total_quantite"];$t_q=$t_q+$users_["total_quantite"];
$commande=$users_["commande"];?></td>
<?
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$poids = $user_["poids"]*$q;
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
		
?>
<td align="right"><?php echo number_format($net3,2,',',' ');$t_prix=$t_prix+$net3;?></td>


<?php } ?>
<tr>
<td></td><td></td><td></td>
<td align="right"><?php echo $t_q;?></td>
<td align="right"><?php echo number_format($t_prix,2,',',' ');?></td>
</tr>
</table>

<p style="text-align:center">

</body>

</html>