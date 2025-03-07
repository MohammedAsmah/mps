<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$profile_name = "";$to="";$type_a="";$last_name = "";$stock_initial=0;$achats=0;$unites=0;$poids=0;$cout_revient=0;
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM types_tiges WHERE profile_id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "";

		$profile_name = $user_["profile_name"];$to=$user_["to"];$type_a=$user_["type_a"];$stock_initial=$user_["stock_initial"];
		$achats=$user_["achats"];$unites=$user_["unites"];$poids=$user_["poids"];$cout_revient=$user_["cout_revient"];
		$consomme=$user_["consomme"];$mode_consomme=$user_["mode_consomme"];$consomme1=$user_["consomme1"];
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
		if(document.getElementById("profile_name").value == "" ) {
			alert("<?php echo "valeurs required !"; ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "tiges.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="tiges.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">

		<tr>
		<td><?php echo "Libelle"; ?></td><td><input type="text" id="profile_name" name="profile_name" style="width:260px" value="<?php echo $profile_name; ?>"></td></tr>
		<tr><td><?php echo "Stock initial"; ?></td><td><input type="text" id="stock_initial" name="stock_initial" style="width:160px" value="<?php echo $stock_initial; ?>"></td></tr>
		<tr><td><?php echo "Achats Exercice"; ?></td><td><input type="text" id="achats" name="achats" style="width:160px" value="<?php echo $achats; ?>"></td></tr>
		<tr><td><?php echo "Nbre Unite Mesur�"; ?></td><td><input type="text" id="unites" name="unites" style="width:160px" value="<?php echo $unites; ?>"></td></tr>
		<tr><td><?php echo "Poids"; ?></td><td><input type="text" id="poids" name="poids" style="width:160px" value="<?php echo $poids; ?>"></td></tr>
		<tr><td><?php echo "C.M.U.P"; ?></td><td><input type="text" id="cout_revient" name="cout_revient" style="width:160px" value="<?php echo $cout_revient; ?>"></td></tr>
		<tr><td><?php echo "Consomm� Exercice"; ?></td><td align="right"><input type="text" id="consomme" name="consomme" style="width:160px" value="<?php echo $consomme; ?>"></td></tr>
		<tr><td><?php echo "Consomm� PF"; ?></td><td align="right"><input type="text" id="consomme1" name="consomme1" style="width:160px" value="<?php echo $consomme1; ?>"></td></tr>
		<tr><td><input type="checkbox" id="mode_consomme" name="mode_consomme"<?php if($mode_consomme) { echo " checked"; } ?>></td><td>Consomation Forfitaire</td>
	</table>

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