<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();	$user_name=GetUserName();


	$error_message = "";$date="";$date_f="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;
		$date="";$action="Recherche";	
	$profiles_list_vendeur = "";$vendeur="";

	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {$client = $_REQUEST["frs"];$date = dateFrToUs($_REQUEST["date"]);
		$date_f = dateFrToUs($_REQUEST["date"]);$bb = $_REQUEST["bb"];
		
			
			// prepares data to simplify database insert or update
			$frs = $_REQUEST["frs"];$vendeur = $_REQUEST["vendeur"];$destination = $_REQUEST["destination"];
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
		$sql  = "SELECT * ";
		$sql .= "FROM rs_data_fournisseurs WHERE last_name = '$frs' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$ville=$user_["ville"];$fax=$user_["fax"];
			
			}
		if($_REQUEST["action_"] == "update_user"){	
			$destination = $_REQUEST["destination"];
			$frs = $_REQUEST["frs"];$vendeur = $_REQUEST["vendeur"];$client = $_REQUEST["frs"];
			
			$bl = $_REQUEST["bl"];$bc = $_REQUEST["bc"];$piece = $_REQUEST["piece"];
			}
		
		
	} //if
	

	$sql1 = "SELECT * FROM vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_vendeur .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$profiles_list_vendeur .= $temp_["vendeur"];
		$profiles_list_vendeur .= "</OPTION>";
	}
		$profiles_list_dep = "";$destination="";
	$sql1 = "SELECT * FROM rs_data_dep ORDER BY ville;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($destination == $temp_["ville"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_dep .= "<OPTION VALUE=\"" . $temp_["ville"] . "\"" . $selected . ">";
		$profiles_list_dep .= $temp_["ville"];
		$profiles_list_dep .= "</OPTION>";
	}

		if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="controle_bc_mps.php">
	<table>
	<td><?php echo "Du: "; ?><input onClick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au: "; ?><input onClick="ds_sh(this);" name="date2" readonly="readonly" style="cursor: text" /></td>
	
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{$date=dateFrToUs($_POST['date']);$date2=dateFrToUs($_POST['date2']);
	$date_f=dateFrToUs($_POST['date']);$vendeur=$_POST['vendeur'];$destination=$_POST['destination'];
		
		$sql  = "SELECT * ";
		$sql .= "FROM commandes_frs where date_e between '$date' and '$date2' ORDER BY date_e;";
		$users = db_query($database_name, $sql);
		}
		
		else
			
		{
		@$vendeur=$_GET['vendeur'];@$date=$_GET['date'];@$destination=$_GET['destination'];
		$sql  = "SELECT * ";
		$sql .= "FROM commandes_frs where  date_e between '$date' and '$date2' ORDER BY date_e;";
		$users = db_query($database_name, $sql);}
		
	if(isset($_REQUEST["action_"]))
	{$date=dateFrToUs($_POST['date']);$date_f=dateFrToUs($_POST['date']);$vendeur=$_POST['vendeur'];
		
		$sql  = "SELECT * ";
		$sql .= "FROM commandes_frs where date_e between '$date' and '$date2' ORDER BY date_e;";
		$users = db_query($database_name, $sql);
		}
		
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Commandes"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "bc_mps_details.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "liste Commandes"; ?></span>
<tr>


<table class="table2">

<tr>
	<th><?php echo "partner_id";?></th>
	<th><?php echo "name";?></th>
	<th><?php echo "Articles";?></th>

	
</tr>

<?php 

$total_g=0;
while($users_ = fetch_array($users)) { ?><tr>

<? $commande=$users_["commande"];$bln=$users_["bl"];$bcn=$users_["bc"];$evaluation=$users_["evaluation"];$client=$users_["client"];$date_e=dateUsToFr($users_["date_e"]);
$vendeur=$users_["vendeur"];$numero=$users_["id"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];$date_c=$users_["date_e"];
$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$id=$users_["id"]; $date_en=dateFrToUs($users_["date"]);$ev_pre=$users_["ev_pre"];
$ref=$users_["vendeur"];$anc=$users_["ancien_commande"];
?>


<? $sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes_frs where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { ?>
	<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
?>
<td><?php echo $client; ?></td>
<td><?php echo $produit; ?></td>
<td align="center"><?php echo $users1_["quantite"]; ?></td>
<td align="right"><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>

</tr>

<?	}?>
<? }?>

</table>
<tr>
</tr>

<p style="text-align:center">
</body>

</html>