<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$date=$_GET['date'];$date1=$_GET['date1'];$vendeur=$_GET['vendeur'];$ville=$_GET['ville'];
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
	$sql  = "SELECT ville,trimestre,commande,client,vendeur,date,sum(net) As total ";$encours="encours";
	$sql .= "FROM commandes where ville='$ville' and date_e between '$date' and '$date1' and evaluation<>'$encours' GROUP BY client order by total DESC;";
	$users11 = db_query($database_name, $sql);
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Palmares Vendeur : $ville $du au $au "; ?></span>

<p style="text-align:center">
<table class="table2">

<tr>
	
	<th><?php echo "client";?></th>
	<th><?php echo "Montant";?></th>
	
	
	
</tr>

<?

$compteur1=0;$t=0;$t_v=0;
while($users_1 = fetch_array($users11)) { $client=$users_1["client"];$total=$users_1["total"];?><tr>
			<?php echo "<td><a href=\"palmares_clients_par_date.php?vendeur=$vendeur&client=$client&ville=$ville&date=$date&date1=$date1\">$client</a></td>"; ?>			
			<td><?php echo number_format($total,2,',',' ');$t=$t+$total; ?></td>

	<? 

 } ?>
 
<tr><td>Total</td>
<td><?php echo number_format($t,2,',',' '); ?></td>
</tr></table>

 

<p style="text-align:center">

</body>

</html>