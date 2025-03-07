<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
		//sub
		
		if(isset($_REQUEST["action_1"])){
			$produit=$_REQUEST["produit"];$produit1=$_REQUEST["produit1"];$numero=$_REQUEST["numero"];$favoris11=1;
			$quantite=$_REQUEST["quantite"];$prix_unit=$_REQUEST["prix_unit"];$condit=$_REQUEST["condit"];$sub=1;

			$sql = "DELETE FROM detail_factures WHERE facture='$numero' and produit='$produit'" ;
			db_query($database_name, $sql);

				$sql  = "INSERT INTO detail_factures ( facture, produit, favoris,quantite,prix_unit,sub,sub_article,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit1 . "', ";
				$sql .= "'" . $favoris11 . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $prix_unit . "', ";
				$sql .= "'" . $sub . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $condit . "');";

				db_query($database_name, $sql);
		$id = $numero-9040;
		$sql  = "SELECT * ";
		$sql .= "FROM factures WHERE id = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_f"]);
		$client = $user_["client"];$montant_f = $user_["montant"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
				
				
		}
		
		
		
		
		
		
		if(isset($_REQUEST["action1_"])){
			$produit=$_REQUEST["produit"];$produit1=$_REQUEST["produit1"];$numero=$_REQUEST["numero"];
			$quantite=$_REQUEST["quantite"];$prix_unit=$_REQUEST["prix_unit"];$condit=$_REQUEST["condit"];$sub=1;

			$sql = "DELETE FROM detail_factures WHERE facture='$numero' and produit='$produit'" ;
			db_query($database_name, $sql);

				$sql  = "INSERT INTO detail_factures ( facture, produit, quantite,prix_unit,sub,sub_article,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit1 . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $prix_unit . "', ";
				$sql .= "'" . $sub . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $condit . "');";

				db_query($database_name, $sql);
		$id = $numero-9040;
		$sql  = "SELECT * ";
		$sql .= "FROM factures WHERE id = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_f"]);
		$client = $user_["client"];$montant_f = $user_["montant"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
				
		}
	
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 
		
		if($_REQUEST["action_"] != "delete_user") {$numero =$_REQUEST["numero"];$client =$_REQUEST["client"];
		$id = $_REQUEST["numero"];
		$sql  = "SELECT * ";
		$sql .= "FROM factures WHERE numero = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_f"]);$montant_f=$user_["montant"];
		$client = $user_["client"];
		$vendeur = $user_["vendeur"];
		$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
			
			// prepares data to simplify database insert or update
			$produit =$_REQUEST["produit"];
			$quantite = $_REQUEST["quantite"];$condit = $_REQUEST["condit"];$prix_unit = $_REQUEST["prix_unit"];
		}	
		
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
		
				$sql  = "INSERT INTO detail_factures ( facture, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $prix_unit . "', ";
				$sql .= "'" . $condit . "');";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
			$sql = "UPDATE detail_factures SET ";
			$sql .= "produit = '" . $produit . "', ";
			$sql .= "quantite = '" . $quantite . "', ";
			$sql .= "prix_unit = '" . $prix_unit . "', ";
			$sql .= "sans_remise = '" . $sans_remise . "', ";
			$sql .= "condit = '" . $condit . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
		
			break;
			
			case "delete_user":
			
		$sql  = "SELECT * ";
		$sql .= "FROM detail_factures WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$numero = $user_["facture"];
		

			$sql = "DELETE FROM detail_factures WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
		$id = $numero-9040;
		$sql  = "SELECT * ";
		$sql .= "FROM factures WHERE id = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_f"]);
		$client = $user_["client"];$montant_f = $user_["montant"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
			
			
			break;


		} //switch
		
	} //if
	else
	{
	
	$numero=$_GET['numero'];$client=$_GET['client'];$montant_f=$_GET['montant'];
	$id = $numero;
		$sql  = "SELECT * ";
		$sql .= "FROM factures WHERE numero = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_f"]);
		$client = $user_["client"];$montant_f = $user_["montant"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
	}
	
	
?>
</table>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Facture Client"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "detail_facture.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<table class="table2">
<td><?php echo $client;?></td><td><?php $montant1=number_format($montant_f,2,',',' ');echo "Facture : ".$numero."---->Montant : $montant1";?></td>
</table>
<tr>
<table class="table2">

<tr>
	<th><?php $total=0;echo "Ref";?></th>
	<th><?php $total=0;echo "Produit";?></th>
	<th><?php echo "Quantité";?></th>
	<th><?php echo "Paquets";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Total";?></th>
</tr>

<?	
	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_factures where facture='$numero' and sans_remise=0 ORDER BY produit;";
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

if ($sub==1){

echo "<td>$id</td>";

echo "<td>$produit</td>";
?>
<td align="center" bgcolor="#FF3300"><?php echo $users1_["quantite"]; ?></td>
<td align="center" bgcolor="#FF3300"><?php echo $users1_["condit"]; ?></td>
<td align="right" bgcolor="#FF3300"><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<? if ($favoris){?>
<td align="right" bgcolor="#FF3300"><?php $total=$total+$m;echo number_format($m,2,',',' '); ?></td>
<? } else {?>
<td bgcolor="#FFFF00" align="right"><?php $total=$total+$m;echo number_format($m,2,',',' '); ?></td>
<? }?>
</tr>
<? } else { 
echo "<td>$id</td>";
echo "<td>$produit</td>";
?>
<td align="center"><?php echo $users1_["quantite"]; ?></td>
<td align="center"><?php echo $users1_["condit"]; ?></td>
<td align="right"><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<? if ($favoris){?>
<td align="right"><?php $total=$total+$m;echo number_format($m,2,',',' '); ?></td>
<? } else {?>
<td bgcolor="#FFFF00" align="right"><?php $total=$total+$m;echo number_format($m,2,',',' '); ?></td>
<? }?>
</tr>
<?	}?>
<?	}?>

<?
if ($sans_remise==1){?>
<td></td><td></td><td></td><td></td>
<td>Net à payer</td>
<td align="right"><?php $t=$total;$net=$total;echo number_format($t,2,',',' '); ?></td>
<? } else {?>

<td></td><td></td><td></td><td></td>
<td>Total</td>
<td align="right"><?php $t=$total;echo number_format($t,2,',',' '); ?></td>
<? 		
		$remise_1=0;$remise_2=0;$remise_3=0;
?>
<tr>
<td></td>
<td></td>
<td></td><td></td>
<? if ($remise10>0){?>
<td>Remise 10%</td>
<td align="right"><?php $remise_1=$total*$remise10/100; echo number_format($remise_1,2,',',' ');?></td>
</tr>
<tr>
<td></td>
<td></td>
<td></td><td></td>
<? }?>
<? if ($remise2>0){?>
<td><? if ($remise2==2){echo "Remise 2%";}?></td>
<td align="right"><?php $remise_2=($total-$remise_1)*$remise2/100; echo number_format($remise_2,2,',',' ');?></td>
</tr>
<tr>
<td></td>
<td></td>
<td></td><td></td>
<? }?>
<? if ($remise3>0){?>
<td><? if ($remise3==2){echo "Remise 2%";}else{echo "Remise 3%";}?></td>
<td align="right"><?php $remise_3=($total-$remise_1-$remise_2)*$remise3/100; echo number_format($remise_3,2,',',' ');?></td>
</tr>
<? }?>

<?	
	
	$sql1  = "SELECT * ";$total1=0;
	$sql1 .= "FROM detail_factures where facture='$numero' and sans_remise=1 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
//
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}

if ($sub==1){

echo "<tr><td>$id</td>";

echo "<td>$produit</td>";
?>
<td align="center" bgcolor="#FF3300"><?php echo $users1_["quantite"]; ?></td>
<td align="center" bgcolor="#FF3300"><?php echo $users1_["condit"]; ?></td>
<td align="right" bgcolor="#FF3300"><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<? if ($favoris){?>
<td align="right" bgcolor="#FF3300"><?php $total1=$total1+$m;echo number_format($m,2,',',' '); ?></td>
<? } else {?>
<td bgcolor="#FFFF00" align="right"><?php $total1=$total1+$m;echo number_format($m,2,',',' '); ?></td>
<? }?>
</tr>
<? } else { 
echo "<tr><td>$id</td>";
echo "<td>$produit</td>";
?>
<td align="center"><?php echo $users1_["quantite"]; ?></td>
<td align="center"><?php echo $users1_["condit"]; ?></td>
<td align="right"><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<? if ($favoris){?>
<td align="right"><?php $total1=$total1+$m;echo number_format($m,2,',',' '); ?></td>
<? } else {?>
<td bgcolor="#FFFF00" align="right"><?php $total1=$total1+$m;echo number_format($m,2,',',' '); ?></td>
<? }?>
</tr>
<?	}?>
<?	}?>

<tr>
<td></td>
<td></td>
<td></td><td></td>

<td>Net à payer</td>
<td align="right"><?php $net=$total+$total1-$remise_1-$remise_2-$remise_3; echo number_format($net,2,',',' ');?></td>

</tr>
<tr>
<td></td>
<td></td>
<td></td><td></td>
<td>Difference</td>
<td align="right"><?php $diff=$net-$montant_f;; echo number_format($diff,2,',',' ');?></td>

<? }?>

</table>
<table>
<tr>
<? echo "<td></td>";?>
</tr>
<tr>
<? $non_favoris_f= number_format($non_favoris,2,',',' ');$diff=$net-$montant_f;?>
</tr>

<tr><td><? echo "non favoris : $non_favoris_f";?></td></tr>
<tr><td><? $non_favoris=$non_favoris+$diff;$non_favoris_f= number_format($non_favoris,2,',',' ');
$m2=$montant_f-$net+$non_favoris;?></td></tr>
<? echo "<td></td>";?>
</table>

<p style="text-align:center">


</body>

</html>