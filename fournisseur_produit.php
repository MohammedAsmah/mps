<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Fournisseur";

		$login = "";$ville = "";
		$last_name = "";
		$first_name = "";
		$email = "";
		$locked = "";
		$profile_id = 0;
		$remarks = "";$fax="";$tel="";
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM rs_data_fournisseurs WHERE user_id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$login = $user_["login"];$fax = $user_["fax"];$tel = $user_["tel"];
		$last_name = $user_["last_name"];$ville = $user_["ville"];
		$first_name = $user_["first_name"];
		$email = $user_["email"];
		$locked = $user_["locked"];
		$profile_id = $user_["profile_id"];
		$remarks = $user_["remarks"];$c1 = $user_["c1"];$c2 = $user_["c2"];$c3 = $user_["c3"];
		$c4 = $user_["c4"];$c5 = $user_["c5"];$c6 = $user_["c6"];
	}

	// extracts profile list
	$profiles_list = "";
	$sql = "SELECT profile_id, profile_name FROM rs_fournisseurs_profiles ORDER BY display_order;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($profile_id == $temp_["profile_id"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list .= "<OPTION VALUE=\"" . $temp_["profile_id"] . "\"" . $selected . ">";
		$profiles_list .= $temp_["profile_name"];
		$profiles_list .= "</OPTION>";
	}
	
	$produit_list16 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($c1 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list16 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list16 .= $temp_["produit"];
		$produit_list16 .= "</OPTION>";
	}
		$produit_list17 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($c2 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list17 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list17 .= $temp_["produit"];
		$produit_list17 .= "</OPTION>";
	}
		$produit_list18 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($c3 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list18 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list18 .= $temp_["produit"];
		$produit_list18 .= "</OPTION>";
	}
		$produit_list19 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($c4 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list19 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list19 .= $temp_["produit"];
		$produit_list19 .= "</OPTION>";
	}

			$produit_list20 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($c5 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list20 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list20 .= $temp_["produit"];
		$produit_list20 .= "</OPTION>";
	}
		$produit_list21 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($c6 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list21 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list21 .= $temp_["produit"];
		$produit_list21 .= "</OPTION>";
	}
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
					UpdateUser();
			}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression de ce fournisseur ?"; ?>")) {
			document.location = "fournisseurs_produits.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo "Fiche Fournisseur"; ?></span>

<form id="form_user" name="form_user" method="post" action="fournisseurs_produits.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">

		
		<tr><td><?php echo Translate("Last name"); ?><td><td><?php echo $last_name; ?></td>
		
		<tr><td><?php echo "Adresse"; ?><td><td><?php echo $first_name; ?></td>
		
		
		<tr><td><?php echo "Ville"; ?><td><td><?php echo $ville; ?></td>
		
		
		<tr><td><?php echo Translate("Email"); ?><td><td><?php echo $email; ?></td>
		
		<tr><td><?php echo "Tel"; ?><td><td><?php echo $tel; ?></td>
		
		
		<tr><td><?php echo "Fax"; ?><td><td><?php echo $fax; ?></td>
		
		
		<tr>

		<td colspan="5" style="text-align:center">

		<center>

		<table><tr>

			<td>
			<?php echo "Familles "; ?><br>
			<tr><td><select id="c1" name="c1"><?php echo $produit_list16; ?></select></td></tr>
			<tr><td><select id="c2" name="c2"><?php echo $produit_list17; ?></select></td></tr>
			<tr><td><select id="c3" name="c3"><?php echo $produit_list18; ?></select></td></tr>
			<tr><td><select id="c4" name="c4"><?php echo $produit_list19; ?></select></td></tr>
			<tr><td><select id="c5" name="c5"><?php echo $produit_list20; ?></select></td></tr>
			<tr><td><select id="c6" name="c6"><?php echo $produit_list21; ?></select></td></tr>
			

		</tr></table>

		</center>

	</td></tr></table>

	</center>

</td></tr></table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">

<table class="table3"><tr>

<?php if($user_id != "0") { ?>
<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td style="width:20px"></td>
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php } ?>
</tr></table>

</center>

</form>

</body>

</html>