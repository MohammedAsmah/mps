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
		$date_debut = "";$color="";
		$montant = "";$montant_echeance="";$echeance="";$nbr_echeances="";
		$date_fin = "";
		$banque = "";$av=0;$av_natpet=0;
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM credits WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$designation = $user_["designation"];$date_obtention = dateUsToFr($user_["date_obtention"]);$date_debut = dateUsToFr($user_["date_debut"]);
		$montant_echeance = $user_["montant_echeance"];$echeance = $user_["echeance"];
		$montant = $user_["montant"];$nbr_echeances = $user_["nbr_echeances"];
		$date_fin = dateUsToFr($user_["date_fin"]);$banque = $user_["banque"];$color = $user_["color"];$av = $user_["av"];$av_natpet = $user_["av_natpet"];
		}
		$profiles_list_color = "";
	$sql = "SELECT * FROM colors ORDER BY color;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($color == $temp_["color"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_color .= "<OPTION VALUE=\"" . $temp_["color"] . "\"" . $selected . ">";
		$profiles_list_color .= $temp_["color"];
		$profiles_list_color .= "</OPTION>";
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
		if(document.getElementById("montant_echeance").value == "" || document.getElementById("date_debut").value == "" ) {
			alert("<?php echo Translate("The values for the fields are required !"); ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "effets_aa.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php  ?></span>

<form id="form_user" name="form_user" method="post" action="effets_aa.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
		<tr>
		<td><?php echo "Designation : "; ?></td><td><input type="text" id="designation" name="designation" style="width:860px" value="<?php echo $designation; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Montant Effet"; ?></td><td><input type="text" id="montant_echeance" name="montant_echeance" style="width:260px" value="<?php echo $montant_echeance; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Effet AVAL / ACC "; ?></td><td><input type="checkbox" id="av" name="av"<?php if($av) { echo " checked"; } ?>></td>
		</tr>
		<tr>
		<td><?php echo "Effet NATPET "; ?></td><td><input type="checkbox" id="av_natpet" name="av_natpet"<?php if($av_natpet) { echo " checked"; } ?>></td>
		</tr>
		<tr>
		<td><?php echo "Nombre Fois : "; ?></td><td><input type="text" id="nbr_echeances" name="nbr_echeances" style="width:260px" value="<?php echo $nbr_echeances; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Date Echeance"; ?></td><td><input type="text" id="date_debut" name="date_debut" style="width:260px" value="<?php echo $date_debut; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Nombre jours"; ?></td><td><input type="text" id="echeance" name="echeance" style="width:100px" value="<?php echo $echeance; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Banque"; ?></td><td><input type="text" id="banque" name="banque" style="width:100px" value="<?php echo $banque; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Selection couleur : "; ?></td><td><select id="color" name="color"><?php echo $profiles_list_color; ?></select></td>
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
