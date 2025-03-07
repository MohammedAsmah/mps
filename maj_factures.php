<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];$date_ajout=date("Y-m-d");$matiere="";$poids="";$time_ajout=date("Y-m-d H:i:s");
	$mois=$_GET['mois'];
		//sub
		
		if(isset($_REQUEST["action_1"])){
			$produit=$_REQUEST["produit"];$produit1=$_REQUEST["produit1"];$numero=$_REQUEST["numero"];$favoris11=1;
			$quantite=$_REQUEST["quantite"];$prix_unit=$_REQUEST["prix_unit"];$condit=$_REQUEST["condit"];$sub=1;

			$sql = "DELETE FROM detail_factures2016 WHERE facture='$numero' and produit='$produit'" ;
			db_query($database_name, $sql);
			
			$sql15  = "SELECT * ";
			$sql15 .= "FROM produits where produit='$produit1' ORDER BY produit;";
			$users115 = db_query($database_name, $sql15);
			$users115_ = fetch_array($users115);$matiere="";$poids="";
			$matiere=$users115_["matiere"];$poids=$users115_["poids"];if ($prix_unit<>""){$prix_unit=$_REQUEST["prix_unit"];}else{$prix_unit=$users115_["prix"];}
			$condit=$users115_["condit"];
			
			
			$id = $numero-9040;
		$sql  = "SELECT * ";
		$sql .= "FROM factures2016 WHERE id = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_f"]);$date_f = $user_["date_f"];
		$client = $user_["client"];$montant_f = $user_["montant"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
		
				$sql  = "INSERT INTO detail_factures2016 ( date_ajout,time_ajout,user,facture,date_f, produit, matiere,poids,favoris,quantite,prix_unit,sub,sub_article,condit ) VALUES ( ";
				$sql .= "'" . $date_ajout . "', ";
				$sql .= "'" . $time_ajout . "', ";
				$sql .= "'" . $login . "', ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $date_f . "', ";
				$sql .= "'" . $produit1 . "', ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $poids . "', ";
				$sql .= "'" . $favoris11 . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $prix_unit . "', ";
				$sql .= "'" . $sub . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $condit . "');";

				db_query($database_name, $sql);
		
				
				
		}
		
		
		
		
		
		
		if(isset($_REQUEST["action1_"])){
			$produit=$_REQUEST["produit"];$produit1=$_REQUEST["produit1"];$numero=$_REQUEST["numero"];
			$quantite=$_REQUEST["quantite"];$prix_unit=$_REQUEST["prix_unit"];$condit=$_REQUEST["condit"];$sub=1;

			$sql = "DELETE FROM detail_factures2016 WHERE facture='$numero' and produit='$produit'" ;
			db_query($database_name, $sql);
			$sql15  = "SELECT * ";
			$sql15 .= "FROM produits where produit='$produit1' ORDER BY produit;";
			$users115 = db_query($database_name, $sql15);
			$users115_ = fetch_array($users115);
			$matiere=$users115_["matiere"];$poids=$users115_["poids"];if ($prix_unit<>""){$prix_unit=$_REQUEST["prix_unit"];}else{$prix_unit=$users115_["prix"];}
			$condit=$users115_["condit"];
			
			$id = $numero-9040;
		$sql  = "SELECT * ";
		$sql .= "FROM factures2016 WHERE id = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_f"]);$date_f = $user_["date_f"];
		$client = $user_["client"];$montant_f = $user_["montant"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
			
				$sql  = "INSERT INTO detail_factures2016 ( date_ajout,time_ajout,user,facture,date_f, produit,matiere,poids, quantite,prix_unit,sub,sub_article,condit ) VALUES ( ";
				$sql .= "'" . $date_ajout . "', ";
				$sql .= "'" . $time_ajout . "', ";
				$sql .= "'" . $login . "', ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $date_f . "', ";
				$sql .= "'" . $produit1 . "', ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $poids . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $prix_unit . "', ";
				$sql .= "'" . $sub . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $condit . "');";

				db_query($database_name, $sql);
		
				
		}
	
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 
		
		if($_REQUEST["action_"] != "delete_user") {$numero =$_REQUEST["numero"];$client =$_REQUEST["client"];
		$id = $_REQUEST["numero"];
		$sql  = "SELECT * ";
		$sql .= "FROM factures2016 WHERE numero = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_f"]);$montant_f=$user_["montant"];$date_f=$user_["date_f"];
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
			$sql15  = "SELECT * ";
			$sql15 .= "FROM produits where produit='$produit' ORDER BY produit;";
			$users115 = db_query($database_name, $sql15);
			$users115_ = fetch_array($users115);
			$matiere=$users115_["matiere"];$poids=$users115_["poids"];if ($prix_unit<>""){$prix_unit=$_REQUEST["prix_unit"];}else{$prix_unit=$users115_["prix"];}
			$condit=$users115_["condit"];
			
			
			
				$sql  = "INSERT INTO detail_factures2016 ( date_ajout,time_ajout,user,facture,date_f, produit,matiere,poids, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $date_ajout . "', ";
				$sql .= "'" . $time_ajout . "', ";
				$sql .= "'" . $login . "', ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $date_f . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $poids . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $prix_unit . "', ";
				$sql .= "'" . $condit . "');";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
			
			$sql15  = "SELECT * ";
			$sql15 .= "FROM produits where produit='$produit' ORDER BY produit;";
			$users115 = db_query($database_name, $sql15);
			$users115_ = fetch_array($users115);
			$matiere=$users115_["matiere"];$poids=$users115_["poids"];if ($prix_unit<>""){$prix_unit=$_REQUEST["prix_unit"];}else{$prix_unit=$users115_["prix"];}
			$condit=$users115_["condit"];
			
			$sql = "UPDATE detail_factures2016 SET ";
			$sql .= "produit = '" . $produit . "', ";
			$sql .= "matiere = '" . $matiere . "', ";
			$sql .= "poids = '" . $poids . "', ";
			$sql .= "time_ajout = '" . $time_ajout . "', ";
			$sql .= "date_ajout = '" . $date_ajout . "', ";
			$sql .= "user = '" . $login . "', ";
			$sql .= "quantite = '" . $quantite . "', ";
			$sql .= "prix_unit = '" . $prix_unit . "', ";
			$sql .= "sans_remise = '" . $sans_remise . "', ";
			$sql .= "condit = '" . $condit . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
		
			break;
			
			case "delete_user":
		$mois=	$_REQUEST["mois"];
		$sql  = "SELECT * ";
		$sql .= "FROM detail_factures2016 WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$numero = $user_["facture"];
		

			$sql = "DELETE FROM detail_factures2016 WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
		$id = $numero-9040;
		$sql  = "SELECT * ";
		$sql .= "FROM factures2016 WHERE id = " . $id . ";";
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
	
	$numero=$_GET['numero'];$client=$_GET['client'];$montant_f=$_GET['montant'];$mois=$_GET['mois'];
	$id = $numero;
		$sql  = "SELECT * ";
		$sql .= "FROM factures2016 WHERE numero = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_f"]);
		$client = $user_["client"];$montant_f = $user_["montant"];$cloture = $user_["cloture"];
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
	$sql1 .= "FROM detail_factures2016 where facture='$numero' and sans_remise=0 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
//
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];$dispo_g = $user_["dispo_g"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}

if ($dispo_g==0){

echo "<td><a href=\"detail_facture.php?numero=$numero&user_id=$id&client=$client&montant=$m&mois=$mois\">$id</a></td>";

echo "<td>$produit</td>";
?>
<td align="center" bgcolor="#FF3300"><?php echo $users1_["quantite"]; ?></td>
<td align="center" bgcolor="#FF3300"><?php echo $users1_["condit"]; ?></td>
<td align="right" bgcolor="#FF3300"><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<td align="right" bgcolor="#FF3300"><?php $total=$total+$m;echo number_format($m,2,',',' '); ?></td>
</tr>
<? } else { 
echo "<td><a href=\"detail_facture.php?numero=$numero&user_id=$id&client=$client&montant=$m&mt=$montant_f&mois=$mois\">$id</a></td>";
echo "<td>$produit</td>";
?>
<td align="center"><?php echo $users1_["quantite"]; ?></td>
<td align="center"><?php echo $users1_["condit"]; ?></td>
<td align="right"><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<td align="right"><?php $total=$total+$m;echo number_format($m,2,',',' '); ?></td>
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
	$sql1 .= "FROM detail_factures2016 where facture='$numero' and sans_remise=1 ORDER BY produit;";
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

echo "<tr><td><a href=\"detail_facture.php?numero=$numero&user_id=$id&client=$client&montant=$m&mois=$mois\">$id</a></td>";

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
echo "<tr><td><a href=\"detail_facture.php?numero=$numero&user_id=$id&client=$client&montant=$m&mt=$montant_f&mois=$mois\">$id</a></td>";
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
<td align="right"><?php $diff=$net-$montant_f; echo number_format($diff,2,',',' ');?></td>

<tr>
<td></td>
<td></td>
<td></td><td></td>
<td>Diff. Brut</td>
<td align="right"><?php $diff=$net-$montant_f;

$diff = $diff/0.90;
if ($remise2>0){
$diff = $diff/(1-($remise2/100));
}
if ($remise3>0){
$diff = $diff/(1-($remise3/100));
}
 echo number_format($diff,2,',',' ');?></td>

<? }?>

</table>
<table>
<tr>
<? echo "<td><a href=\"detail_facture.php?numero=$numero&user_id=0&client=$client&mois=$mois\">Ajout Article dans facture</a></td>";?>
</tr>
<? $action_22="update_user";echo "<td><a href=\"edition_factures.php?numero=$numero&action_22=$action_22&mois=$mois\">Facture Controlée</a></td>";?>
<tr>
<? $non_favoris_f= number_format($non_favoris,2,',',' ');$diff=$net-$montant_f;?>
</tr>

<tr><td><? echo "non favoris : $non_favoris_f";?></td></tr>
<tr><td><? $non_favoris=$non_favoris+$diff;$non_favoris_f= number_format($non_favoris,2,',',' ');
$m2=$montant_f-$net+$non_favoris;?></td></tr>

</table>



<table class="table2">
<?

$sql  = "SELECT * ";$article="article";
		$sql .= "FROM produits WHERE dispo_f = 1 and famille='$article' and dispo_g = 1 order by produit ;";
		$userss = db_query($database_name, $sql);
while($users_s = fetch_array($userss)) {$produit=$users_s["produit"];$id_v=$users_s["id"];$palmares=$users_s["palmares"];	?>

<tr>

	<td><? echo $produit;?>
	<td><? $px=number_format($users_s["prix"]*$users_s["condit"],2,',',' ');echo "<a href=\"detail_facture.php?numero=$numero&user_id=0&client=$client&produit=$produit&qte=1\">$px</a>";?></td>
	<td><? $px=number_format($users_s["prix"]*$users_s["condit"]*2,2,',',' ');echo "<a href=\"detail_facture.php?numero=$numero&user_id=0&client=$client&produit=$produit&qte=2\">$px</a>";?></td>
	<td><? $px=number_format($users_s["prix"]*$users_s["condit"]*3,2,',',' ');echo "<a href=\"detail_facture.php?numero=$numero&user_id=0&client=$client&produit=$produit&qte=3\">$px</a>";?></td>
	<td><? $px=number_format($users_s["prix"]*$users_s["condit"]*4,2,',',' ');echo "<a href=\"detail_facture.php?numero=$numero&user_id=0&client=$client&produit=$produit&qte=4\">$px</a>";?></td>
	<td><? $px=number_format($users_s["prix"]*$users_s["condit"]*5,2,',',' ');echo "<a href=\"detail_facture.php?numero=$numero&user_id=0&client=$client&produit=$produit&qte=5\">$px</a>";?></td>
	<td><? $px=number_format($users_s["prix"]*$users_s["condit"]*6,2,',',' ');echo "<a href=\"detail_facture.php?numero=$numero&user_id=0&client=$client&produit=$produit&qte=6\">$px</a>";?></td>
	<td><? $px=number_format($users_s["prix"]*$users_s["condit"]*7,2,',',' ');echo "<a href=\"detail_facture.php?numero=$numero&user_id=0&client=$client&produit=$produit&qte=7\">$px</a>";?></td>
	<td><? $px=number_format($users_s["prix"]*$users_s["condit"]*8,2,',',' ');echo "<a href=\"detail_facture.php?numero=$numero&user_id=0&client=$client&produit=$produit&qte=8\">$px</a>";?></td>
	<td><? $px=number_format($users_s["prix"]*$users_s["condit"]*9,2,',',' ');echo "<a href=\"detail_facture.php?numero=$numero&user_id=0&client=$client&produit=$produit&qte=9\">$px</a>";?></td>
	<td><? $px=number_format($users_s["prix"]*$users_s["condit"]*10,2,',',' ');echo "<a href=\"detail_facture.php?numero=$numero&user_id=0&client=$client&produit=$produit&qte=10\">$px</a>";?></td>
</tr>	
<?	
}
?>
</table>



<p style="text-align:center">


</body>

</html>