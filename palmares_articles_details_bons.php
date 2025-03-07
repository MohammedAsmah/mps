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
	$encours="encours";$vide="encours";
	$sql  = "SELECT client,produit,quantite,condit,date,prix_unit,bon_sortie,sum(quantite*condit) As total_quantite ,sum(quantite) As t_quantite ";
	$sql .= "FROM detail_commandes where produit='$produit' and (date between '$date' and '$date1') and evaluation<>'$vide' GROUP BY id order by date;";
	$users = db_query($database_name, $sql);
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Palmares Article par Bon sortie : $produit $du au $au "; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Bon de sortie";?></th>
	<th><?php echo "Date";?></th><th><?php echo "Client";?></th>
	<th><?php echo "Paquets";?></th>
	<th><?php echo "Quantite";?></th>
	<th><?php echo "Valeur";?></th>
</tr>

<?php $debit=0;$credit=0;$t=0;$s=0;$t_q=0;$t_m=0;
while($users_ = fetch_array($users)) { ?><tr>
<td><?php if($users_["bon_sortie"]==""){$bon="encours";}else{$bon=$users_["bon_sortie"];}echo $bon;?></td>
<td><?php echo dateUsToFr($users_["date"]);?></td>
<td><?php echo $users_["client"];?></td>
<td align="right"><?php echo $users_["t_quantite"];?></td>
<td align="right"><?php $q=$users_["total_quantite"];echo $users_["total_quantite"];$t_q=$t_q+$users_["total_quantite"];?></td>
<td align="right"><?php $m=$users_["total_quantite"]*$users_["prix_unit"];$t_m=$t_m+$m;echo number_format($m,2,',',' ');?></td>

<?php } ?>
<tr>
<td></td><td></td><td></td><td></td>
<td align="right"><?php echo $t_q;?></td>
<td align="right"><?php echo number_format($t_m,2,',',' ');?></td>
</tr>
</table>

<p style="text-align:center">

</body>

</html>