<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$id_production = $_REQUEST["id_production"];$qte_tige1=0;
		$sql  = "SELECT * ";
		$sql .= "FROM maintenances WHERE id = " . $id_production . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$date = dateUsToFr($user_["date"]);$machine = $user_["machine"];


	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$produit = "";$prod_6_14="";$prod_14_22="";$prod_22_6="";$temps_arret_h="";$rebut="";$poids="";$tc1="";$tc2="";$tc3="";$obs_machine="";$obs="";
		$date=$date;$qte=0;$temps_arret_m="";
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM details_maintenances WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "";

		$intervention = $user_["intervention"];$date = dateUsToFr($user_["date"]);$operateur = $user_["operateur"];
		$compteur = $user_["compteur"];
		$obs = $user_["obs"];
		
		
	}
	$profiles_list_pa = "";
	$sql4 = "SELECT * FROM pannes ORDER BY designation;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($intervention == $temp_["designation"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_pa .= "<OPTION VALUE=\"" . $temp_["designation"] . "\"" . $selected . ">";
		$profiles_list_pa .= $temp_["designation"];
		$profiles_list_pa .= "</OPTION>";
	}
	$profiles_list_op = "";$tec="Techniciens";
	$sql44 = "SELECT * FROM employes where fonction='$tec' and statut=0 ORDER BY employe;";
	$temp = db_query($database_name, $sql44);
	while($temp_ = fetch_array($temp)) {
		if($operateur == $temp_["employe"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_op .= "<OPTION VALUE=\"" . $temp_["employe"] . "\"" . $selected . ">";
		$profiles_list_op .= $temp_["employe"];
		$profiles_list_op .= "</OPTION>";
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
		if(document.getElementById("date").value == "" ) {
			alert("<?php echo "Date !"; ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "maintenances_details.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="maintenances_details.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table width="671" class="table2">
		<tr>
		<td><?php echo "Intervention sur la Machine : "; ?><?php echo $machine; ?></td>

		<tr>
		<td><?php echo "Date Intervention : "; ?><input type="text" id="date" name="date" style="width:100px" value="<?php echo $date; ?>"></td>

        </tr>
		<tr>
		<td><?php echo " Type Intervention : "; ?><input type="text" id="intervention" name="intervention" style="width:200px" value="<?php echo $intervention; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Nom Operateur : "; ?><select id="operateur" style="width:240px" name="operateur"><?php echo $profiles_list_op; ?></select></td>
		</tr>
        <tr>
        <td><?php echo "Compteur Machine : "; ?><input type="text" id="compteur" name="compteur" style="width:100px" value="<?php echo $compteur; ?>"></td>
		</tr>
        <tr>
	    <td><?php echo "Observations :  "; ?><input type="text" id="obs" name="obs" style="width:200px" value="<?php echo $obs; ?>"></td>
    </table>
	</center>



<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="date" name="date" value="<?php echo $date; ?>">
<input type="hidden" id="machine" name="machine" value="<?php echo $machine; ?>">

<input type="hidden" id="id_production" name="id_production" value="<?php echo $id_production; ?>">
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