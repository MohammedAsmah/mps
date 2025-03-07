<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	 
	 
	 
	 $activer=1;
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

	<?$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];$vendeur=$_POST['vendeur'];
	$du=$_POST['date'];$au=$_POST['date1'];$t_prix_p=0;$vide="encours";$encours="encours";
			

	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Palmares Articles / Avoirs $vendeur du $du au $au"; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Article";?></th>
	<th><?php echo "Quantite T";?></th>
	<th><?php echo "Prix Unit.";?></th>
	<th><?php echo "Valeur Avoir";?></th>
	<th><?php echo "Prix Unit. ";?></th>
	<th><?php echo "Valeur Vendeur";?></th>
	<th><?php echo "Difference";?></th>
	
	
</tr>

<?php $debit=0;$credit=0;$t=0;$s=0;$t_poids=0;$t_prix=0;$t_poids_evaluation=0;$n1=0;$n2=0;

$sql  = "SELECT * ";$oui=1;
		$sql .= "FROM produits WHERE couvercle='$oui' and palmares1 = '$activer' ";
		$userp = db_query($database_name, $sql);
	while($users_p = fetch_array($userp)) {$produit=$users_p["produit"];$tarif_base = $users_p["tarif_base"];$prix = $users_p["prix"];$q=0;$net_avoir=0;$net_base=0;
	$sql  = "SELECT client,commande,valeur,produit,sans_remise,quantite,condit,date,sum(quantite*condit*prix_unit) As total_prix,sum(quantite*condit) As total_quantite ,sum(quantite) As t_quantite ";
	$sql .= "FROM detail_avoirs where vendeur='$vendeur' and produit='$produit' and date between '$date' and '$date1' GROUP BY id order by total_prix DESC;";
	$users = db_query($database_name, $sql);

?>
<tr>
<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$produit </font>");?></td>
<? while($users_ = fetch_array($users)) { $q=$q+$users_["total_quantite"];
		$commande=$users_["commande"];$client=$users_["client"];
		$sql  = "SELECT * ";
		$sql .= "FROM clients WHERE client = '$client' ";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$remise10 = $user_["remise10"];$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];
		
					$r10=$users_["total_quantite"]*$prix*$remise10/100;
					$net1=$users_["total_quantite"]*$prix-$r10;
					$r2=$net1*$remise2/100;$net2=$net1-$r2;
					$r3=$net2*$remise3/100;$net3=$net2-$r3;
					
					$r10_1=$users_["total_quantite"]*$tarif_base*$remise10/100;
					$net1_1=$users_["total_quantite"]*$tarif_base-$r10_1;
					$r2_1=$net1_1*$remise2/100;$net2_1=$net1_1-$r2_1;
					$r3_1=$net2_1*$remise3/100;$net3_1=$net2_1-$r3_1;
					$net_avoir=$net_avoir+$net3;$net_base=$net_base+$net3_1;
					
}
						
?>
<td align="right"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$q </font>");?></td>

<td align="right"><?php $pu1=number_format($prix,2,'.',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$pu1 </font>");?></td>
<td align="right"><?php $n_avoir= number_format($net_avoir,2,'.',' ');$n1=$n1+$net_avoir;print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$n_avoir </font>");?></td>
<td align="right"><?php $pu2=number_format($tarif_base,2,'.',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$pu2 </font>");?></td>
<td align="right"><?php $n_base= number_format($net_base,2,'.',' ');$n2=$n2+$net_base;print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$n_base </font>");?></td>
<td align="right"><?php $diff= number_format($net_base-$net_avoir,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$diff </font>");?></td>

<?php } ?>
<tr>
<td></td><td></td>
<td></td>
<td align="right"><?php $v1= number_format($n1,2,'.',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$v1 </font>");?></td>
<td></td>
<td align="right"><?php $v2= number_format($n2,2,'.',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$v2 </font>");?></td>
<td align="right"><?php $v3= number_format($n2-$n1,2,'.',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$v3 </font>");?></td>
</table>


<p style="text-align:center">

</body>

</html>