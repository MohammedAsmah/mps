<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$du="";$au="";$vendeur="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {$du = $_REQUEST["du"];$au = $_REQUEST["au"];$vendeur = $_REQUEST["vendeur"];
			// prepares data to simplify database insert or update
			$client = $_REQUEST["client"];$evaluation = $_REQUEST["evaluation"];$date = dateFrToUs($_REQUEST["date"]);
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
		$sql  = "SELECT * ";
		$sql .= "FROM clients WHERE client = '$client' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$vendeur = $user_["vendeur"];$remise10 = $user_["remise10"];$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];
			
			}
		if($_REQUEST["action_"] == "update_user"){	
			$remise10 = $_REQUEST["remise10"];$remise2 = $_REQUEST["remise2"];$remise3 = $_REQUEST["remise3"];
			$vendeur = $_REQUEST["vendeur"];}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
				
				$req = mysql_query("SELECT COUNT(*) as cpt FROM commandes"); 
				$row = mysql_fetch_array($req); 
				$nb = $row['cpt']; 
				$id=$nb+800;
				
				
				$sql  = "INSERT INTO commandes ( commande,date_e,client, vendeur, evaluation,remise_10,remise_2,remise_3,sans_remise ) VALUES ( ";
				$sql .= "'" . $id . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $evaluation . "', ";
				$sql .= "'" . $remise10 . "', ";
				$sql .= "'" . $remise2 . "', ";
				$sql .= "'" . $remise3 . "', ";
				$sql .= "'" . $sans_remise . "');";

				db_query($database_name, $sql);
		
			

			break;

			case "update_user":
			$sql = "UPDATE commandes SET ";
			$sql .= "client = '" . $client . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			$sql .= "evaluation = '" . $evaluation . "', ";
			$sql .= "remise_10 = '" . $remise10 . "', ";
			$sql .= "remise_2 = '" . $remise2 . "', ";
			$sql .= "remise_3 = '" . $remise3 . "', ";
			$sql .= "sans_remise = '" . $sans_remise . "' ";
			$sql .= "WHERE commande = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);



			break;
			
			case "delete_user":
			
			break;


		} //switch
	} //if
	
	
	// recherche ville
		?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Evaluations"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "detail_evaluation.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	$action="recherche";
	$date="";$client="";$eva="";
	$vendeur_list = "";
	$sql = "SELECT * FROM  vendeurs ORDER BY ref;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$vendeur_list .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$vendeur_list .= $temp_["vendeur"];
		$vendeur_list .= "</OPTION>";
	}
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "liste Evaluations"; ?></span>
	
	<form id="form" name="form" method="post" action="editer_evaluations.php">
	<td><?php echo "DU : "; ?><input onclick="ds_sh(this);" name="du" readonly="readonly" style="cursor: text" />
	<td><?php echo "AU : "; ?><input onclick="ds_sh(this);" name="au" readonly="readonly" style="cursor: text" />
	<td><?php echo "Vendeur : "; ?></td><td><select id="vendeur" name="vendeur"><?php echo $vendeur_list; ?></select>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>

<?	
	
	if(isset($_REQUEST["action"]))
	{ $du=DateFrToUs($_POST['du']);$au=DateFrToUs($_POST['au']);$vendeur=$_POST['vendeur'];}
	
	$sql  = "SELECT * ";
	$sql .= "FROM commandes where vendeur='$vendeur' and (date_e between '$du' and '$au') ORDER BY date_e;";
	$users = db_query($database_name, $sql);
	

//




?>
<tr>
<td><?php echo $vendeur .":".dateUsToFr($du)." au ".dateUsToFr($au) ;?></td>
</tr><tr><? echo "<td><a href=\"evaluation.php?vendeur=$vendeur&du=$du&au=$au&user_id=0\">Ajout Evaluation</a></td>";?>
</tr>

<table class="table2">

<tr>
	<th><?php echo "Evaluation";?></th>
	<th><?php echo "Màj";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Net";?></th>
</tr>

<?php $total_g=0;while($users_ = fetch_array($users)) { ?><tr>
<? $commande=$users_["commande"];$evaluation=$users_["evaluation"];$client=$users_["client"];$date=dateUsToFr($users_["date_e"]);
$vendeur=$users_["vendeur"];$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];
$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];
echo "<td><a href=\"maj_factures_pro.php?vendeur=$vendeur&du=$du&au=$au&client=$client&commande=$commande\">$evaluation</a></td>";?>
<?php $id=$users_["id"]; echo "<td><a href=\"evaluation.php?vendeur=$vendeur&du=$du&au=$au&client=$client&user_id=$commande\">$id</a></td>";?>
			<? 
			
		/*$sql  = "SELECT * ";
		$sql .= "FROM clients WHERE client = '$client' ";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$login = $user_["ref"];$last_name="";
		$last_name = $user_["client"];$last_name1 = $user_["client"];
		$ville = $user_["ville"];$remise10 = 10;$sans_remise=0;
		$remarks = $user_["adrresse"];$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];
		$sql  = "INSERT INTO factures_pro ( date_f, client,numero, vendeur,remise_10,remise_2,remise_3,sans_remise,evaluation ) VALUES ( ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $commande . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $remise10 . "', ";
				$sql .= "'" . $remise2 . "', ";
				$sql .= "'" . $remise3 . "', ";
				$sql .= "'" . $sans_remise . "', ";
				$sql .= "'" . $evaluation . "');";

				db_query($database_name, $sql);*/
		/*$sql1  = "SELECT * ";$ref=$users_["vendeur"]; 
		$sql1 .= "FROM vendeurs WHERE ref = " . $ref . ";";
		$user1 = db_query($database_name, $sql1); $user1_ = fetch_array($user1);
		$vendeur = $user1_["vendeur"];
			$sql = "UPDATE commandes SET ";
			$sql .= "vendeur = '" . $vendeur . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);*/

			
			?>


<td><?php echo $date; ?></td>
<td><?php echo $users_["client"]; ?></td>

<? ///////////////

	$sql1  = "SELECT * ";$m=0;$total=0;
	$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=0 ORDER BY produit;";
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

		$p=$users1_["prix_unit"];$total=$total+$m;
	}?>

<?
if ($sans_remise==1){$t=$total;$net=$total;} else {$t=$total;$remise_1=0;$remise_2=0;$remise_3=0;
if ($remise10>0){$remise_1=$total*$remise10/100;}?>
<? if ($remise2>0){$remise_2=($total-$remise_1)*$remise2/100;}?>
<? if ($remise3>0){$remise_3=($total-$remise_1-$remise_2)*$remise3/100;} ?>
<? }?>

<?	
	
	$sql1  = "SELECT * ";$total1=0;
	$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=1 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
//
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE ref = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}

$p=$users1_["prix_unit"];$total1=$total1+$m;}?>

<?php $net=$total+$total1-$remise_1-$remise_2-$remise_3; 

/////////////////?>

<td style="text-align:Right"><?php $total_g=$total_g+$net;echo number_format($net,2,',',' '); ?></td>
<?php } ?>
<tr><td></td><td></td><td></td><td></td>
<td style="text-align:Right"><?php echo number_format($total_g,2,',',' '); ?></td>
</tr>

</table>
<tr>
<? echo "<td><a href=\"evaluation.php?vendeur=$vendeur&du=$du&au=$au&user_id=0\">Ajout Evaluation</a></td>";?>
</tr>

<p style="text-align:center">

</body>

</html>