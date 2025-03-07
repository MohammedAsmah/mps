<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Client";

		$login = "";
		$last_name = "";
		$first_name = "";$ville="";$vendeur="";
		$email = "";
		$locked = "";
		$profile_id = 0;
		$remarks = "";
		$remise2=0;
		$remise3=0;
		$com_debiteur_to_a=0;
		$com_debiteur_to_e=0;
		$com_cash_rep_a=0;
		$com_cash_rep_e=0;
		$com_cash_ag_a=0;
		$com_cash_ag_e=0;$statut=0;$categorie="";
		
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM contacts WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$login = $user_["ref"];$categorie = $user_["categorie"];$statut = $user_["statut"];
		$last_name = $user_["client"];$last_name1 = $user_["client"];
		$vendeur = $user_["vendeur"];$ville = $user_["ville"];
		$remarks = $user_["adrresse"];$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];
		}
	$profiles_list_cat = "";
	$sql1 = "SELECT * FROM categories_contacts ORDER BY id;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($categorie == $temp_["categorie"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_cat .= "<OPTION VALUE=\"" . $temp_["categorie"] . "\"" . $selected . ">";
		$profiles_list_cat .= $temp_["categorie"];
		$profiles_list_cat .= "</OPTION>";
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
		if(document.getElementById("last_name").value == "" ) {
			alert("<?php echo Translate("The values for the fields are required !"); ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression de ce client ?"; ?>")) {
			document.location = "contacts.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

	function Editcontrat(user_id) { document.location = "contrats_sejours.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="contacts_c.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table width="476" class="table3">
		<tr>
		<td><?php echo "Nom ou Raison sociale"; ?></td><td><input type="text" id="last_name" name="last_name" style="width:260px" value="<?php echo $last_name; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Contact"; ?></td><td><input type="text" id="login" name="login" style="width:260px" value="<?php echo $login; ?>"></td>
		</tr>
		
		<tr>
		<td><?php echo "Telephone"; ?></td><td><input type="text" id="remise2" name="remise2" style="width:360px" value="<?php echo $remise2; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Fax/Telephone"; ?></td><td><input type="text" id="remise3" name="remise3" style="width:360px" value="<?php echo $remise3; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Categorie : "; ?></td><td><select id="categorie" name="categorie"><?php echo $profiles_list_cat; ?></select></td>
		</tr>
		<tr>
		<td><?php echo "Adresse"; ?></td><td><input type="text" id="remarks" name="remarks" style="width:260px" value="<?php echo $remarks; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Email : "; ?></td><td><input type="text" id="ville" name="ville" style="width:260px" value="<?php echo $ville; ?>"></td>
		</tr>
		<tr><td><input type="checkbox" id="statut" name="statut"<?php if($statut) { echo " checked"; } ?>></td><td>Non utilisé</td>
		
	  </table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="last_name1" name="last_name1" value="<?php echo $last_name1; ?>">
<table class="table3"><tr>

<?php if($user_id != "0") { ?>
<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td style="width:20px"></td>
<?php } else { ?>

<?php 
} ?>
</tr></table>

</center>

</form>

</body>

</html>