<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau ";

		$designation = "";$date_obtention = "";
		$date_debut = "";
		$montant = "";$montant_echeance="";$echeance="";$nbr_echeances="";
		$date_fin = "";
		$banque = "";
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM echeances_credits WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$designation = $user_["designation"];$montant_echeance = $user_["montant_echeance"];$date_echeance = dateUsToFr($user_["date_echeance"]);
		$banque = $user_["banque"];
		}


	// extracts profile list
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php  ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
		if(document.getElementById("montant_echeance").value == "" ) {
			alert("<?php echo Translate("The values for the fields are required !"); ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "maj_echeances.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php  ?></span>

<form id="form_user" name="form_user" method="post" action="maj_echeances.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
		<tr>
		<td><?php echo "Designation : "; ?></td><td><input type="text" id="designation" name="designation" style="width:260px" value="<?php echo $designation; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Montant Echeance"; ?></td><td><input type="text" id="montant_echeance" name="montant_echeance" style="width:260px" value="<?php echo $montant_echeance; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Date Echeance"; ?></td><td><input type="text" id="date_echeance" name="date_echeance" style="width:260px" value="<?php echo $date_echeance; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Banque"; ?></td><td><input type="text" id="banque" name="banque" style="width:100px" value="<?php echo $banque; ?>"></td>
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


</p>
</html>
