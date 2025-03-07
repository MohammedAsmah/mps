<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$achats = $_REQUEST["achats"];$stock_initial = $_REQUEST["stock_initial"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$profile_name = "";$to="";$type_a="";$last_name = "";
		$stock_initial=0;$achats=0;$unites=0;$poids=0;$cout_revient=0;$mode_consomme=0;
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM report_mat_precedant WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "";

		$produit = $user_["produit"];$stock_final_mp=$user_["stock_final_mp"];$valeur_final_mp=$user_["valeur_final_mp"];
		
	
	}
	
	$profiles_list_article = "";$emb1="emb1";
	$sql4 = "SELECT * FROM report_mat_precedant_2021 where type='$emb1' ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article .= $temp_["produit"];
		$profiles_list_article .= "</OPTION>";
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
			alert("<?php echo "valeurs required !"; ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "emballages_sachets.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="emballages_sachets.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">

		<tr><td><?php echo "Matire : "; ?></td><td><select id="produit" name="produit"><?php echo $profiles_list_article; ?></select>
		</td>
		</tr>
		<tr>
		<td><?php echo "Stock."; ?></td><td><input type="text" id="stock_final_mp" name="stock_final_mp" style="width:160px" value="<?php echo $stock_final_mp; ?>"></td></tr>
		<tr>
		<td><?php echo "Valeur."; ?></td><td><input type="text" id="valeur_final_mp" name="valeur_final_mp" style="width:160px" value="<?php echo $valeur_final_mp; ?>"></td></tr>
	</tr></table>

	</center>

</td></tr></table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="type" name="type" value="<?php $type="sachets";echo $type; ?>">
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