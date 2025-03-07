<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$date = "";
		$libelle = "";
		$ref = "";
		$debit = 0;
		$credit = 0;
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM banque_rak WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$libelle = $user_["libelle"];
		$ref = $user_["ref"];
		$date = dateUsTofr($user_["date"]);
		$debit = $user_["debit"];
		$credit = $user_["credit"];
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
		if(document.getElementById("date").value == "" ) {
			alert("<?php echo "The values for the fields required !"; ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression  ?"; ?>")) {
			document.location = "verssements.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="verssements.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">

		<tr>
		<td><?php echo "date"; ?></td><td><input type="text" id="date" name="date" style="width:160px" value="<?php echo $date; ?>"></td>
		</tr><tr>
		<td><?php echo "Libelle"; ?></td><td><input type="text" id="libelle" name="libelle" style="width:160px" value="<?php echo $libelle; ?>"></td>
		</tr><tr><td><?php echo "Reference"; ?></td><td><input type="text" id="ref" name="ref" style="width:160px" value="<?php echo $ref; ?>"></td>
		</tr><tr><td><?php echo "Debit"; ?></td><td><input type="text" id="debit" name="debit" style="width:160px" value="<?php echo $debit; ?>"></td>
		</tr>

		<tr><td><?php echo "Credit"; ?></td><td><input type="text" id="credit" name="credit" style="width:160px" value="<?php echo $credit; ?>"></td>
		</tr>


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
<?php 
} ?>
</tr></table>

</center>

</form>

</body>

</html>