<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$id = $_REQUEST["id"];$user_id = $_REQUEST["user_id"];

	if($id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau ";

		$ref = "";$vendeur = "";
		$com = "";$plafond=0;
		
		
	} else {

		$action_ = "update";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM commandes WHERE id = " . $_REQUEST["id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$net = $user_["net"];
		$client = $user_["client"];$reliquat = $user_["reliquat"];$obs_reliquat = $user_["obs_reliquat"];
		
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

		



--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="compte_client_reliquat.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
		<tr>
		<td><?php echo "Client"; ?></td><td><?php echo $client; ?></td>
		</tr>
		<tr>
		<td><?php echo "Net"; ?></td><td><?php echo $net; ?></td>
		</tr>
		<tr>
		<td><?php echo "Reliquat"; ?></td><td><input type="text" id="reliquat" name="reliquat" style="width:260px" value="<?php echo $reliquat; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Observation"; ?></td><td><input type="text" id="obs_reliquat" name="obs_reliquat" style="width:260px" value="<?php echo $obs_reliquat; ?>"></td>
		</tr>
		</table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="id" name="id" value="<?php echo $_REQUEST["id"]; ?>">
<input type="hidden" id="client" name="client" value="<?php echo $client; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<table class="table3"><tr>

<?php if($user_id != "0") { ?>
<td><button type="button" onClick="UpdateUser()"><?php echo Translate("Update"); ?></button></td>
<td style="width:20px"></td>

<?php } else { ?>
<td><button type="button"  onClick="UpdateUser()"><?php echo Translate("OK"); ?></button></td>
<?php 
} ?>
</tr></table>

</center>

</form>

</body>

</html>