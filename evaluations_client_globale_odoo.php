<?php
set_time_limit(0);
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$date="";$date_f="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;$du1="";$au1="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {$date = dateFrToUs($_REQUEST["date"]);$date_f = dateFrToUs($_REQUEST["date"]);
		
			
			// prepares data to simplify database insert or update
			$client = $_REQUEST["client"];
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
		$sql  = "SELECT * ";
		$sql .= "FROM clients WHERE client = '$client' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$remise10 = $user_["remise10"];$vendeur = $user_["vendeur1"];
		$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];
			
			}
		if($_REQUEST["action_"] == "update_user"){	
			$remise10 = $_REQUEST["remise10"];$remise2 = $_REQUEST["remise2"];$remise3 = $_REQUEST["remise3"];
			$client = $_REQUEST["client"];
			$sql  = "SELECT * ";
			$sql .= "FROM clients WHERE client = '$client' ;";
			$user = db_query($database_name, $sql);
			$user_ = fetch_array($user);$vendeur = $user_["vendeur1"];
			}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
				
				
				$sql  = "INSERT INTO commandes ( date_e,client, vendeur, remise_10,remise_2,remise_3,sans_remise ) VALUES ( ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $remise10 . "', ";
				$sql .= "'" . $remise2 . "', ";
				$sql .= "'" . $remise3 . "', ";
				$sql .= "'" . $sans_remise . "');";

				db_query($database_name, $sql);
		
			

			break;

			case "update_user":
			$sql = "UPDATE commandes SET ";
			$sql .= "client = '" . $client . "', ";
			$sql .= "date = '" . dateFrToUs($date) . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			$sql .= "remise_10 = '" . $remise10 . "', ";
			$sql .= "remise_2 = '" . $remise2 . "', ";
			$sql .= "remise_3 = '" . $remise3 . "', ";
			$sql .= "sans_remise = '" . $sans_remise . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);



			break;
			
			case "delete_user":
			
			break;


		} //switch
	} //if


	$date="";$action="Recherche";$date1="";	
	$profiles_list_vendeur = "";$client="";
	$sql1 = "SELECT * FROM clients ORDER BY client;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_vendeur .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$profiles_list_vendeur .= $temp_["client"];
		$profiles_list_vendeur .= "</OPTION>";
	}
		if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="evaluations_client_globale_odoo.php">
	<td><?php echo "Date : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Date1 : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{$date=dateFrToUs($_POST['date']);$date_f=dateFrToUs($_POST['date']);$date1=dateFrToUs($_POST['date1']);
				$du1=$_POST['date'];$au1=$_POST['date1'];

		/*$sql  = "SELECT * ";
		$sql .= "FROM commandes ORDER BY date_e;";
		$users = db_query($database_name, $sql);*/
		
		$sql  = "SELECT * ";$encours="encours";
		$sql .= "FROM commandes where date_e between '$date' and '$date1' and escompte_exercice=0 and evaluation<>'$encours' ORDER BY date_e,evaluation;";
		$users = db_query($database_name, $sql);
		}
		
		else
		{$sql  = "SELECT * ";$vide="";
		$sql .= "FROM commandes where date_e='$date' and bondesortie<>'$vide' and escompte_exercice=0 and evaluation<>'$encours' ORDER BY date_e,evaluation;";
		$users = db_query($database_name, $sql);}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Evaluations"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "evaluation_client.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<tr>
</tr>

<table class="table2">

<tr>
	<th><?php echo "Name";?></th>
	<th><?php echo "ref";?></th>
	<th><?php echo "Partner_id";?></th>
	<th><?php echo "company_id";?></th>
	<th><?php echo "Date_order";?></th>
	<th><?php echo "client_order_ref";?></th>
	<th><?php echo "user_id";?></th>
	<th><?php echo "remise10";?></th><th><?php echo "remise2";?></th><th><?php echo "remise3";?></th><th><?php echo "escompte 1";?></th><th><?php echo "escompte 2";?></th>
	<th><?php echo "Order_line/product_id";?></th>
	<th><?php echo "Order_line/product_uom_qty";?></th>
	<th><?php echo "Order_line/condit";?></th>
	<th><?php echo "Order_line/price_unit";?></th>
	
	
</tr>

<?php 

$total_g=0;$total_f=0;
while($users_ = fetch_array($users)) { ?><tr>
<? $commande=$users_["commande"];$evaluation=$users_["evaluation"];$client=$users_["client"];$date_e=dateUsToFr($users_["date_e"]);
$vendeur=$users_["vendeur"];$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];$netc=$users_["net"];
$bondesortie=$users_["bondesortie"];$numero_f=$users_["facture"];
$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$id=$users_["id"]; $date_en=dateFrToUs($users_["date"]);
$date_ev=$users_["date_e"];$montant_releve=$users_["montant_releve"];$escompte=$users_["escompte"];$escompte2=$users_["escompte2"];


?>
<td><?php echo $users_["bondesortie"]; ?></td>
<td><?php echo $users_["evaluation"]; ?></td>
<td><?php echo $users_["client"]; ?></td>
<td><?php echo "MPS"; ?></td>
<td><?php echo $date_e; ?></td>
<td><?php echo $users_["net"]; ?></td>
<td><?php echo $vendeur; ?></td>
<td><?php echo $remise10; ?></td>
<td><?php echo $remise2; ?></td>
<td><?php echo $remise3; ?></td>
<td><?php echo $escompte; ?></td>
<td><?php echo $escompte2; ?></td>

<? ///////////////

	$sql1  = "SELECT * ";$m=0;$total=0;
	$sql1 .= "FROM detail_commandes where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	//echo "<td></td><td></td><td></td>";
	
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];$condit=$users1_["condit"];
		$sub=$users1_["sub"];$sr=$users1_["sans_remise"];$qty=$users1_["quantite"];//$price=$users1_["prix_unit"]*$users1_["condit"];
		$price=$users1_["prix_unit"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		
		
		//unit price 
		
		
		if ($sans_remise==0)
		
				{
				if ($sr==0){
		
		$r10=$price*$remise10/100;$net1=$price-$r10;
		$r2=$net1*$remise2/100;$net2=$net1-$r2;
		$r3=$net2*$remise3/100;$net3=$net2-$r3;
		$r4=$net3*$escompte/100;$net3=$net3-$r4;
		$r5=$net3*$escompte2/100;$net3=$net3-$r5;
		}
		else
		{$net3=$price;}
		}
		else{$net3=$price;}
		
		$net3=number_format($net3,2,'.',' ');
		echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>$produit</td><td>$qty</td><td>$condit</td><td>$price</td></tr>";
		
		
		
		
		
		
		
		
		
		if ($favoris==0){$non_favoris=$non_favoris+$m;}
				

		$p=$users1_["prix_unit"];$total=$total+$net3;
			/*$sql = "UPDATE detail_commandes SET ";
			$sql .= "date = '" . $date_ev . "', ";
			$sql .= "evaluation = '" . $evaluation . "', ";
			$sql .= "client = '" . $client . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			$sql .= "ville = '" . $ville . "', ";
			$sql .= "region = '" . $region . "', ";
			$sql .= "valeur = '" . $net3 . "', ";
			$sql .= "bon_sortie = '" . $bondesortie . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);*/
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
		$sub=$users1_["sub"];$sr=$users1_["sans_remise"];
//
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE ref = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];
		if ($favoris==0){$non_favoris=$non_favoris+$m;}
				if ($sans_remise==0)
		
				{
				if ($sr==0){
		/*$prix=$users_["total_prix"]*(1-$remise10/100);*/
		$r10=$m*$remise10/100;$net1=$m-$r10;
		$r2=$net1*$remise2/100;$net2=$net1-$r2;
		$r3=$net2*$remise3/100;$net3=$net2-$r3;
		$r4=$net3*$escompte/100;$net3=$net3-$r4;
		/*$prix=$prix*(1-$remise2/100);
		$prix=$prix*(1-$remise3/100);*/}
		else
		{$net3=$m;}
		}
		else{$net3=$m;}

			$p=$users1_["prix_unit"];$total1=$total1+$net3;
			/*$sql = "UPDATE detail_commandes SET ";
			$sql .= "date = '" . $date_ev . "', ";
			$sql .= "evaluation = '" . $evaluation . "', ";
			$sql .= "client = '" . $client . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			$sql .= "valeur = '" . $net3 . "', ";
			$sql .= "bon_sortie = '" . $bondesortie . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);*/

}?>

<?php $net=$total+$total1; 

/////////////////?>


<?php } ?>


</tr>

</table>
<tr>
</tr>

<p style="text-align:center">

</body>

</html>