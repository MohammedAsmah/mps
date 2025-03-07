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
		$remarks = $user_["remarks"];
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
		if(document.getElementById("first_name").value == "" ) {
			alert("<?php echo "Nom Fournisseur et Ville Obligatoires !"; ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression de ce fournisseur ?"; ?>")) {
			document.location = "fiches_fournisseurs.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo "Fiche Fournisseur"; ?></span>

<form id="form_user" name="form_user" method="post" action="fiches_fournisseurs.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">

		<tr>
		<td><?php echo "Inputation"; ?><br><input type="text" id="login" name="login" style="width:160px" value="<?php echo $login; ?>"></td>
		<td style="width:10px"></td>
		</tr><tr>
		<td><?php echo Translate("Last name"); ?><br><input type="text" id="last_name" name="last_name" style="width:160px" value="<?php echo $last_name; ?>"></td>
		<td style="width:10px"></td>
		<td><?php echo "Adresse"; ?><br><input type="text" id="first_name" name="first_name" style="width:360px" value="<?php echo $first_name; ?>"></td>
		
		<tr>
		<td><?php echo "Ville"; ?><br><input type="text" id="ville" name="ville" style="width:160px" value="<?php echo $ville; ?>"></td>
		<td style="width:10px"></td>
		</tr><tr>
		<td><?php echo Translate("Email"); ?><br><input type="text" id="email" name="email" style="width:160px" value="<?php echo $email; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Tel"; ?><br><input type="text" id="tel" name="tel" style="width:160px" value="<?php echo $tel; ?>"></td>
		<td style="width:10px"></td>
		</tr><tr>
		<tr>
		<td><?php echo "Fax"; ?><br><input type="text" id="fax" name="fax" style="width:160px" value="<?php echo $fax; ?>"></td>
		<td style="width:10px"></td>
		</tr><tr>
		<tr><td colspan="5" style="height:10px"></td></tr>

		<tr><td colspan="5"><input type="text" id="remarks" name="remarks" style="width:520px; height:50px" value="<?php echo $remarks; ?>"></td></tr>

		<tr>

		<td colspan="5" style="text-align:center">

		<center>

		<table><tr>

			<td>
			<?php echo "Famille"; ?><br>
			<select id="profile_id" name="profile_id"><?php echo $profiles_list; ?></select></td>
			<td style="width:20px"></td>
			<td><br><input type="checkbox" id="locked" name="locked"<?php if($locked) { echo " checked"; } ?>></td><td><br><?php echo Translate("Locked"); ?></td>

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
<td><button type="button" onClick="DeleteUser()"><?php echo Translate("Delete"); ?></button></td>
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php } ?>
</tr></table>

</center>

</form>

</body>

</html>