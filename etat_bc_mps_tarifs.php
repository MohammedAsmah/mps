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

	
		
		$sql  = "SELECT * ";
		$sql .= "FROM detail_commandes_frs group by produit ORDER BY produit;";
		$users = db_query($database_name, $sql);
		
		
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Commandes"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "Tarifs Achats"; ?></span>
<tr>


<table class="table2">

<tr>
	
	<th><?php echo "Article";?></th>
	

	
</tr>

<?php 

$total_g=0;
while($users_ = fetch_array($users)) { ?><tr>
<?php $produit=$users_["produit"]; $id=$users_["id"];?>

<? echo "<td><a href=\"etat_bc_mps_tarifs_detail.php?produit=$produit&id=$id\">$produit </a>"; ?></td>

<? }?>

</table>
<tr>
</tr>

<p style="text-align:center">
</body>

</html>