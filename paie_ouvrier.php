<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Produit";$ferier_1="";$ferier_2="";

		//initialiser champs vides
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM paie_ouvriers WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$encours=$user_["encours"];$du=$user_["du"]; $au=$user_["au"];$avance=$user_["avance"];$ferier_1=$user_["ferier_1"];$ferier_2=$user_["ferier_2"];
			
			
	}
	$profiles_list_jour1 = "";
	$sql1 = "SELECT * FROM jours_semaine ORDER BY id;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($ferier_1 == $temp_["jour"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_jour1 .= "<OPTION VALUE=\"" . $temp_["jour"] . "\"" . $selected . ">";
		$profiles_list_jour1 .= $temp_["jour"];
		$profiles_list_jour1 .= "</OPTION>";
	}
	$profiles_list_jour2 = "";
	$sql1 = "SELECT * FROM jours_semaine ORDER BY id;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($ferier_2 == $temp_["jour"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_jour2 .= "<OPTION VALUE=\"" . $temp_["jour"] . "\"" . $selected . ">";
		$profiles_list_jour2 .= $temp_["jour"];
		$profiles_list_jour2 .= "</OPTION>";
	}
	
	// extracts profile list

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">
<link href="Templates/css.css" rel="stylesheet" type="text/css">
<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
		if(document.getElementById("encours").value == "" ) {
			alert("<?php echo "  !"; ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression  ?"; ?>")) {
			document.location = "pointages.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">
<? require "body_cal.php";?>
<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="paie_ouvriers.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table width="671" class="table3">

		<tr>
		<td><?php echo "Semaine : "; ?></td><td><?php  ?></td>
		</tr>
		<tr><td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="du" readonly="readonly" style="cursor: text" />
		<tr><td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="au" readonly="readonly" style="cursor: text" />
		<tr>
		<td><input type="checkbox" id="encours" name="encours"<?php if($encours) { echo " checked"; } ?>></td><td>Semaine encours</td>
		<td><input type="checkbox" id="avance" name="avance"<?php if($avance) { echo " checked"; } ?>></td><td>retait avance</td>
		</tr>
		<tr>
		<td><?php echo "Ferier 1: "; ?></td><td><select id="ferier_1" name="ferier_1"><?php echo $profiles_list_jour1; ?></select></td>
		</tr>
		<tr>
		<td><?php echo "Ferier 2: "; ?></td><td><select id="ferier_2" name="ferier_2"><?php echo $profiles_list_jour2; ?></select></td>
		</tr>
        <tr>
		

	</table>

	</center>

</td></tr></table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">

<table class="table3"><tr>

<?php if($user_id != "0") { 
?>
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