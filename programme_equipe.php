<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$qte_tige1=0;$du = $_REQUEST["du"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$produit = "";$machine="";$prod_6_14="";$prod_14_22="";$prod_22_6="";$temps_arret="";$rebut="";$poids="";$tc1="";$tc2="";$tc3="";$obs_machine="";$obs="";
		$du=$du;$qte=0;$au="";
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM registre_programmes_equipes WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$du = dateUsToFr($user_["du"]);$au = dateUsToFr($user_["au"]);
		$obs = $user_["obs"];
		
		
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
		if(document.getElementById("du").value == "" ) {
			alert("<?php echo "Du !"; ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "registre_programmes_equipes.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="registre_programmes_equipes.php">

<table class="table2"><tr><td style="text-align:center">

		<tr>
		<td bgcolor="#FF0000"><?php echo "Du"; ?></td><td><input type="text" id="du" name="du" style="width:100px" value="<?php echo $du; ?>"></td>
		</tr>
		<tr>
		<td bgcolor="#FF0000"><?php echo "au"; ?></td><td><input type="text" id="au" name="au" style="width:100px" value="<?php echo $au; ?>"></td>
		</tr>
		<tr>
		
       <td width="200"><?php echo " Observation "; ?></td>
        <td><input type="text" id="obs" name="obs" style="width:200px" value="<?php echo $obs; ?>"></td>
	</tr>
	</center>

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
<?php } ?>
</tr></table>

</center>

</form>

</body>

</html>