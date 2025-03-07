<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Promotion";

		$date = "";$date_fin = "";
		$article = "";
		$base = "";$promotion="";$active="";
		
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM liste_promotions WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$date = dateUsToFr($user_["date"]);$article = $user_["article"];$base = $user_["base"];
		$promotion = $user_["promotion"];$date_fin = dateUsToFr($user_["date_fin"]);
		$active = $user_["active"];
		}
	$profiles_list_article = "";
	$sql = "SELECT * FROM produits ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($article == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article .= $temp_["produit"];
		$profiles_list_article .= "</OPTION>";
	}

	// extracts profile list
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
		if(document.getElementById("article").value == "" ) {
			alert("<?php echo Translate("The values for the fields are required !"); ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "promotions.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="promotions.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
		<tr>
		<td><?php echo "Date"; ?></td><td><input type="text" id="date" name="date" style="width:260px" value="<?php echo $date; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Article : "; ?></td><td><select id="article" name="article"><?php echo $profiles_list_article; ?></select></td>
		</tr>
		<tr>
		<td><?php echo "Base : "; ?></td><td><input type="text" id="base" name="base" style="width:60px" value="<?php echo $base; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Promotion : "; ?></td><td><input type="text" id="promotion" name="promotion" style="width:60px" value="<?php echo $promotion; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Expire le : "; ?></td><td><input type="text" id="date_fin" name="date_fin" style="width:100px" value="<?php echo $date_fin; ?>"></td>
		</tr>
		</table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<table class="table3"><tr>

<?php if($user_id != "0") { ?>
<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td style="width:20px"></td>
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