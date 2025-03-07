<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$frs = $_REQUEST["frs"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$produit = "";
		$quantite = "";
		$prix = "";$prix1 = "";$prix2 = "";$prix3 = "";$prix4 = "";$prix5 = "";$prix6 = "";$prix7 = "";$prix8 = "";
		$prix9 = "";$prix10 = "";$prix11 = "";$prix12 = "";$prix13 = "";$prix14 = "";$prix15 = "";$prix16 = "";$prix17 = "";
		$prix18 = "";$prix19 = "";$prix20 = "";
		$condit = "";$sans_remise = 0;
		$produit1 = "";
		$quantite1 = "";
		$produit2 = "";
		$quantite2 = "";
		$produit3 = "";
		$quantite3 = "";
		$produit4 = "";
		$quantite4 = "";
		$produit5 = "";
		$quantite5 = "";
		$produit6 = "";
		$quantite6 = "";
		$produit7 = "";
		$quantite7 = "";
		$produit8 = "";
		$quantite8 = "";
		$produit9 = "";
		$quantite9 = "";
		$produit10 = "";
		$quantite10 = "";
		$produit11 = "";$quantite11 = "";
		$produit12 = "";$quantite12 = "";
		$produit13 = "";$quantite13 = "";$produit14 = "";$quantite14 = "";$produit15 = "";$quantite15 = "";
		$produit16 = "";$quantite16 = "";$produit17 = "";$quantite17 = "";$produit18 = "";$quantite18 = "";
		$produit19 = "";$quantite19 = "";$produit20 = "";$quantite20 = "";

		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM detail_produits_frs WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$produit = $user_["produit"];
		$quantite = $user_["quantite"];
		$prix_unit = $user_["prix_unit"];
		$condit = $user_["condit"];$sans_remise = $user_["sans_remise"];
		
		}

	// extracts profile list
	$produit_list = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list .= $temp_["produit"];
		$produit_list .= "</OPTION>";
	}
	
	if($user_id == "0") {
	$produit_list1 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit1 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list1 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list1 .= $temp_["produit"];
		$produit_list1 .= "</OPTION>";
	}
		$produit_list2 = "";
	$sql = "SELECT * FROM  familles_produits ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit2 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list2 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list2 .= $temp_["produit"];
		$produit_list2 .= "</OPTION>";
	}
	$produit_list3 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit3 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list3 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list3 .= $temp_["produit"];
		$produit_list3 .= "</OPTION>";
	}
		$produit_list4 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit4 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list4 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list4 .= $temp_["produit"];
		$produit_list4 .= "</OPTION>";
	}
	$produit_list5 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit5 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list5 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list5 .= $temp_["produit"];
		$produit_list5 .= "</OPTION>";
	}
		$produit_list6 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit6 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list6 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list6 .= $temp_["produit"];
		$produit_list6 .= "</OPTION>";
	}
		$produit_list7 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit7 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list7 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list7 .= $temp_["produit"];
		$produit_list7 .= "</OPTION>";
	}
		$produit_list8 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit8 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list8 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list8 .= $temp_["produit"];
		$produit_list8 .= "</OPTION>";
	}
	$produit_list9 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit9 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list9 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list9 .= $temp_["produit"];
		$produit_list9 .= "</OPTION>";
	}
		$produit_list10 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit10 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list10 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list10 .= $temp_["produit"];
		$produit_list10 .= "</OPTION>";
	}
	
			$produit_list11 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit11 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list11 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list11 .= $temp_["produit"];
		$produit_list11 .= "</OPTION>";
	}
		$produit_list12 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit12 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list12 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list12 .= $temp_["produit"];
		$produit_list12 .= "</OPTION>";
	}
		$produit_list13 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit13 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list13 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list13 .= $temp_["produit"];
		$produit_list13 .= "</OPTION>";
	}
		$produit_list14 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit14 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list14 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list14 .= $temp_["produit"];
		$produit_list14 .= "</OPTION>";
	}
		$produit_list15 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit15 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list15 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list15 .= $temp_["produit"];
		$produit_list15 .= "</OPTION>";
	}
		$produit_list16 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit16 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list16 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list16 .= $temp_["produit"];
		$produit_list16 .= "</OPTION>";
	}
		$produit_list17 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit17 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list17 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list17 .= $temp_["produit"];
		$produit_list17 .= "</OPTION>";
	}
		$produit_list18 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit18 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list18 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list18 .= $temp_["produit"];
		$produit_list18 .= "</OPTION>";
	}
		$produit_list19 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit19 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list19 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list19 .= $temp_["produit"];
		$produit_list19 .= "</OPTION>";
	}

			$produit_list20 = "";
	$sql = "SELECT * FROM  familles_produits  ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit20 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list20 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list20 .= $temp_["produit"];
		$produit_list20 .= "</OPTION>";
	}
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
		if(document.getElementById("produit").value == "" ) {
			alert("<?php echo Translate("champs indispensables !"); ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "enregistrer_panier_frs.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

	
	
--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="enregistrer_panier_frs.php">

	<table class="table2">
		<? if($user_id == "0") {?>
		<tr>
		<td><?php echo "Famille  pour : ".$frs; ?></td>
		
		</tr>
		

		<tr><td><select id="produit" name="produit"><?php echo $produit_list; ?></select></td></tr>
		<tr><td><select id="produit1" name="produit1"><?php echo $produit_list1; ?></select></td></tr>
		<tr><td><select id="produit2" name="produit2"><?php echo $produit_list2; ?></select></td></tr>
		<tr><td><select id="produit3" name="produit3"><?php echo $produit_list3; ?></select></td></tr>
		<tr><td><select id="produit4" name="produit4"><?php echo $produit_list4; ?></select></td></tr>
		<tr><td><select id="produit5" name="produit5"><?php echo $produit_list5; ?></select></td></tr>
		<tr><td><select id="produit6" name="produit6"><?php echo $produit_list6; ?></select></td></tr>
		<tr><td><select id="produit7" name="produit7"><?php echo $produit_list7; ?></select></td></tr>
		<tr><td><select id="produit8" name="produit8"><?php echo $produit_list8; ?></select></td></tr>
		<tr><td><select id="produit9" name="produit9"><?php echo $produit_list9; ?></select></td></tr>
		<tr><td><select id="produit10" name="produit10"><?php echo $produit_list10; ?></select></td></tr>
		<tr><td><select id="produit11" name="produit11"><?php echo $produit_list11; ?></select></td></tr>
		<tr><td><select id="produit12" name="produit12"><?php echo $produit_list12; ?></select></td></tr>
		<tr><td><select id="produit13" name="produit13"><?php echo $produit_list13; ?></select></td></tr>
		<tr><td><select id="produit14" name="produit14"><?php echo $produit_list14; ?></select></td></tr>
		<tr><td><select id="produit15" name="produit15"><?php echo $produit_list15; ?></select></td></tr>
		<tr><td><select id="produit16" name="produit16"><?php echo $produit_list16; ?></select></td></tr>
		<tr><td><select id="produit17" name="produit17"><?php echo $produit_list17; ?></select></td></tr>
		<tr><td><select id="produit18" name="produit18"><?php echo $produit_list18; ?></select></td></tr>
		<tr><td><select id="produit19" name="produit19"><?php echo $produit_list19; ?></select></td></tr>
		<tr><td><select id="produit20" name="produit20"><?php echo $produit_list20; ?></select></td></tr>
		
		
		
		
		
	<? }?>	

	<? if($user_id <> "0") {?>
		<tr>
		<td><?php echo "Famille : "; ?></td>
		<td><select id="produit" name="produit" ><?php echo $produit_list; ?></select></td>
		
		</tr>
		
		<? }?>	

	</table>

<p style="text-align:center">

<center>


<input type="hidden" id="frs" name="frs" value="<?php echo $frs; ?>">
<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<table class="table3"><tr>

<?php if($user_id != "0") { $action_maj="update_user";$action_sup="delete_user";?>

<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td><button type="button" onClick="DeleteUser()"><?php echo Translate("Delete"); ?></button></td>

<?php } else { ?>

<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td> 
<?php 
} ?>
</tr></table>
</center>

</form>

</body>

</html>