<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$date="";$date_f="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;
		$date="";$action="Recherche";	
	$profiles_list_vendeur = "";$vendeur="";

	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {$date = dateFrToUs($_REQUEST["date"]);$date_f = dateFrToUs($_REQUEST["date"]);
		
			
			// prepares data to simplify database insert or update
			$client = $_REQUEST["client"];$be = $_REQUEST["be"];$net = $_REQUEST["net"];
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
		$sql  = "SELECT * ";
		$sql .= "FROM vendeurs WHERE vendeur = '$client' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);
		
		$vendeur = $user_["vendeur"];
			
			}
		if($_REQUEST["action_"] == "update_user"){	
			
			$client = $_REQUEST["client"];$net = $_REQUEST["net"];
			}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
				
				$encours="encours";
				$sql  = "INSERT INTO avoirs_vendeurs ( commande,date_e,be,net,client, vendeur, sans_remise ) VALUES ( ";
				$sql .= "'" . $cde . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $be . "', ";
				$sql .= "'" . $net . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $sans_remise . "');";

				db_query($database_name, $sql);
		
		
		//retour à liste triée par date
		$date=$_POST['date'];$action="recherche";
					

			break;

			case "update_user":
			$mode=$_POST['mode'];$remise_4=$_POST['remise_4'];$net=$_POST['net'];
			$sql = "UPDATE avoirs_vendeurs SET ";
			$sql .= "client = '" . $client . "', ";
			$sql .= "date_e = '" . $date . "', ";
			$sql .= "be = '" . $be . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			$sql .= "net = '" . $net . "', ";
			$sql .= "mode = '" . $mode . "', ";
			$sql .= "remise_4 = '" . $remise_4 . "', ";
			$sql .= "sans_remise = '" . $sans_remise . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);

			//revenir à liste
			$date=$_POST['date'];$action="recherche";
			


			break;
			
			case "delete_user":
			$sql  = "SELECT * ";
			$sql .= "FROM avoirs_vendeurs WHERE id = " . $_REQUEST["user_id"] . ";";
			$user = db_query($database_name, $sql); $users_ = fetch_array($user);
			$commande=$users_["commande"];
			$sql = "DELETE FROM avoirs_vendeurs WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			$sql = "DELETE FROM detail_avoirs_vendeurs WHERE commande = " . $commande . ";";
			db_query($database_name, $sql);
			
			
			
			break;


		} //switch
	} //if
	

	/*$sql1 = "SELECT * FROM vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_vendeur .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$profiles_list_vendeur .= $temp_["vendeur"];
		$profiles_list_vendeur .= "</OPTION>";
	}*/
	$profiles_list_client;
	$sql1 = "SELECT * FROM vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($client == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_client .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$profiles_list_client .= $temp_["vendeur"];
		$profiles_list_client .= "</OPTION>";
	}
	$destination="";
		if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="avoirs_vendeurs.php">
	<table><td><?php echo "Date: "; ?><input onClick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Client: "; ?></td><td><select id="client" name="client"><?php echo $profiles_list_client; ?></select></td>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{$date=dateFrToUs($_POST['date']);$date_f=dateFrToUs($_POST['date']);$client=$_POST['client'];$destination=$_POST['destination'];
		
		$sql  = "SELECT * ";
		$sql .= "FROM avoirs_vendeurs where client='$client' and date_e='$date' ORDER BY date_e;";
		$users = db_query($database_name, $sql);
		}
		
		else
			
		{
		@$client=$_GET['client'];@$date=$_GET['date'];
		$sql  = "SELECT * ";
		$sql .= "FROM avoirs_vendeurs where client='$client' and date_e='$date' ORDER BY date_e;";
		$users = db_query($database_name, $sql);}
		
	if(isset($_REQUEST["action_"]))
	{$date=dateFrToUs($_POST['date']);$date_f=dateFrToUs($_POST['date']);$client=$_POST['client'];
		
		$sql  = "SELECT * ";
		$sql .= "FROM avoirs_vendeurs where client='$client' and date_e='$date' ORDER BY date_e;";
		$users = db_query($database_name, $sql);
		}
		
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Avoirs"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "avoir_vendeur.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "liste Avoirs"; ?></span>
<tr>
<td><?php echo dateUsToFr($date_f); ;?></td>
</tr><tr><? echo "<td><a href=\"avoir_vendeur.php?client=$client&date=$date_f&user_id=0&be=$destination\">Ajout Avoir</a></td>";?>
</tr>

<table class="table2">

<tr>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "Articles G.";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Net";?></th>
</tr>

<?php 

$total_g=0;
while($users_ = fetch_array($users)) { ?><tr>
<? $commande=$users_["commande"];$evaluation=$users_["be"];$client=$users_["client"];$date_e=dateUsToFr($users_["date_e"]);
$vendeur=$users_["vendeur"];$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];$net1=$users_["net"];
$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$id=$users_["id"]; $date_en=dateFrToUs($users_["date"]);$ev_pre=$users_["ev_pre"];
echo "<td><a href=\"avoir_vendeur.php?date=$date_e&user_id=$id\">$evaluation</a></td>";$ref=$users_["vendeur"];?>
<? echo "<td><a href=\"enregistrer_panier_avoir_vendeur.php?vendeur=$vendeur&client=$client&date=$date_e&numero=$id\">Detail articles</a></td>";?>
<td><?php echo $date_e; ?></td>
<td><?php echo $users_["client"]; ?></td>
<? ///////////////

	$sql1  = "SELECT * ";$m=0;$total=0;
	$sql1 .= "FROM detail_avoirs_vendeurs where commande='$numero' and sans_remise=0 ORDER BY produit;";
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
	$sql1 .= "FROM detail_avoirs_vendeurs where commande='$numero' and sans_remise=1 ORDER BY produit;";
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

<td style="text-align:Right"><?php $total_g=$total_g+$net1;echo number_format($net1,2,',',' '); ?></td>


<?php } ?>
<tr><td></td><td></td><td></td><td></td>
<td style="text-align:Right"><?php echo number_format($total_g,2,',',' '); ?></td>
</tr>

</table>
<tr>
</tr>

<p style="text-align:center">


</body>

</html>