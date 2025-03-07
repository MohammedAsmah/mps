<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$qte_tige1=0;$id_registre = $_REQUEST["id_registre"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$produit = "";
		$date="";$qte=0;$depot_a=0;$depot_b=0;$depot_c=0;
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM bon_de_sortie_magasin WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$produit = $user_["produit"];$depot_a = $user_["depot_a"];$depot_b = $user_["depot_b"];$depot_c = $user_["depot_c"];
		$date = dateUsToFr($user_["date"]);
	}
	$profiles_list_article = "";
	$sql4 = "SELECT * FROM produits ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
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
<link href="Templates/css.css" rel="stylesheet" type="text/css">
<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
			UpdateUser();
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression de ce produit ?"; ?>")) {
			document.location = "entrees_stock.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php  ?></span>

<form id="form_user" name="form_user" method="post" action="bon_de_sortie_magasin.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table width="671" class="table3">

		<tr>
		<td><?php echo "Date"; ?></td><td><?php echo $date; ?></td>
		</tr><tr>
		
		
		<tr><td><?php echo "Article : "; ?></td><td><?php echo $produit; ?></td>
		</tr>

		<tr>
		<td bgcolor="#33CCCC"><?php echo "Mps"; ?></td><td><input type="text" id="depot_a" name="depot_a" style="width:140px" value="<?php echo $depot_a; ?>"></td>
		</tr>
		<tr>
		<td bgcolor="#33CCCC"><?php echo "jaouda"; ?></td><td><input type="text" id="depot_b" name="depot_b" style="width:140px" value="<?php echo $depot_b; ?>"></td>
		</tr>

	</table>

	</center>

</td></tr></table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="id_registre" name="id_registre" value="<?php echo $id_registre; ?>">
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