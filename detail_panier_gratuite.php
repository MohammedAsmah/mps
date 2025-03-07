<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];$base=0;
	$base1=0;
	$base2=0;
	$base3=0;
	$base4=0;
	$base5=0;
	$base6=0;
	$base7=0;
	$base8=0;
	$base9=0;
	$base10=0;
	$base11=0;
	$base12=0;
	$base13=0;
	$base14=0;
	$base15=0;
	$base16=0;
	$base17=0;
	$base18=0;
	$base19=0;
	$base20=0;
	$base21=0;	
		//sub
	

	$client=$_GET['client'];$du=$_GET['du'];$au=$_GET['au'];
	
		$sql  = "SELECT * ";
		$sql .= "FROM commandes_gratuites WHERE client='$client' and date_e between '$du' and '$au' order by date_e;";
		$user = db_query($database_name, $sql); 

		
	
	
?>
</table>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Client : $client "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<table class="table2">
<td><?php echo $client; ?></td><tr>

<? 
while($user_ = fetch_array($user)) { $date_e = dateUsToFr($user_["date_e"]);
		$client = $user_["client"];$montant_f = $user_["net"];$numero = $user_["id"];
		?><table class="table2"><tr><td><? echo "---->Date : $date_e --->";?></td>


<tr>
	
	<th><?php $total=0;echo "Produit";?></th>
	<th><?php echo "Quantité";?></th>
	<th><?php echo "Condit.";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Total";?></th>
</tr>

<?	
	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes_gratuites where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];

?>
<td><?php echo $produit; ?></td>
<td align="center"><?php echo $users1_["quantite"]; ?></td>
<td align="center"><?php echo $users1_["condit"]; ?></td>
<td align="right"><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<td align="right"><?php $total=$total+$m;echo number_format($m,2,',',' '); ?></td>
</tr>
<?	}?><td></td><td></td><td></td><td></td><td></td>
<td align="right"><?php echo number_format($total,2,',',' '); ?></td>
<p></p>
<?	}?>

</table>
<tr>


<p style="text-align:center">


</body>

</html>