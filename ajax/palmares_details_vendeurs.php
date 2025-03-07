<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$date=$_GET['date'];$date1=$_GET['date1'];$vendeur=$_GET['vendeur'];
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
	$sql  = "SELECT * ";
	$sql .= "FROM registre_vendeurs where date between '$date' and '$date1' and vendeur='$vendeur' ORDER BY id;";
	$users11 = db_query($database_name, $sql);
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Palmares Vendeur : $vendeur $du au $au "; ?></span>

<p style="text-align:center">
<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Destination";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "B.S Vendeur";?></th>
	
	
</tr>

<?

$compteur1=0;$total_g=0;$t_v=0;
while($users_1 = fetch_array($users11)) { $id_r=$users_1["id"];$date3=$users_1["date"];$vendeur=$users_1["vendeur"];
			$statut=$users_1["statut"];$observation=$users_1["observation"];$valide=$users_1["valide"];$valide_c=$users_1["valide_c"];
			$service=$users_1["service"];$code=$users_1["code_produit"];$lp=$users_1["id"]+100000;$bon=$users_1["statut"];?><tr>
			<td><?php echo dateUsToFr($users_1["date"]); ?></td>			
			<td><?php $destination=$users_1["service"];echo $users_1["service"]; ?></td>

	<? $sql  = "SELECT * ";$encours="encours";$vide="";
	$sql .= "FROM commandes where id_registre=$id_r and evaluation<>'$encours' and evaluation<>'$vide' and escompte_exercice=0 ORDER BY date_e;";
	$users = db_query($database_name, $sql);
	$total_g=0;$t_net=0;
	while($users_ = fetch_array($users)) { 
		$commande=$users_["commande"];$evaluation=$users_["evaluation"];$client=$users_["client"];$date11=dateUsToFr($users_["date_e"]);
		$vendeur=$users_["vendeur"];$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];$net_c=$users_["net"];$t_net=$t_net+$net_c;
		$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];
		$id=$users_["id"];
						
				
			 }
			 ?>
			 <td align="right"><? $t_v=$t_v+$t_net; echo number_format($t_net,2,',',' ')."</td>";?>
 			<td><?php 
			echo "<a href=\"bon_de_sortie5.php?observation=$observation&montant=$total_g&id_registre=$id_r&date=$date3&vendeur=$vendeur&bon_sortie=$bon&service=$service\">".$bon."</a>"; ?></td>
			<? 

 } ?>
 <tr><td></td>
 <td></td>
 			 <td align="right"><? echo number_format($t_v,2,',',' ')."</td>";?>
<td></td></tr></table>

 

<p style="text-align:center">

</body>

</html>