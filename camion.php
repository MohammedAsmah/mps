<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$matricule = "";$longueur="";$chauffeur="";$telephone="";$permis="";
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM rs_data_camions WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "";

		$matricule = $user_["matricule"];
		$chauffeur = $user_["chauffeur"];
		$longueur = $user_["longueur"];
		$telephone = $user_["telephone"];
		$permis = $user_["permis"];
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
		if(document.getElementById("matricule").value == "" ) {
			alert("<?php echo "valeurs required !"; ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "camions.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="camions.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">

		<tr><td><?php echo "Matricule"; ?></td><td><input type="text" id="matricule" name="matricule" style="width:160px" value="<?php echo $matricule; ?>"></td>
		<tr><td><?php echo "Chauffeur"; ?></td><td><input type="text" id="chauffeur" name="chauffeur" style="width:160px" value="<?php echo $chauffeur; ?>"></td>
		<tr><td><?php echo "Permis"; ?></td><td><input type="text" id="permis" name="permis" style="width:160px" value="<?php echo $permis; ?>"></td>
		<tr><td><?php echo "Volume"; ?></td><td><input type="text" id="longueur" name="longueur" style="width:160px" value="<?php echo $longueur; ?>"></td>
		<tr><td><?php echo "Telephone"; ?></td><td><input type="text" id="telephone" name="telephone" style="width:160px" value="<?php echo $telephone; ?>"></td>
		
		<td style="width:10px"></td>

	</tr></table>

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