<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$sql = "TRUNCATE TABLE `fiche_de_stock_matiere_facture`  ;";
			db_query($database_name, $sql);
			
	$user_id = $_REQUEST["user_id"];$achats = $_REQUEST["achats"];$stock_initial = $_REQUEST["stock_initial"];$stock_initial_matiere = $_REQUEST["stock_initial"];
	$matiere = $_REQUEST["matiere"];
	$stock_initial_matiere_pf = $_REQUEST["stock_initial_pf"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$profile_name = "";$to="";$type_a="";$last_name = "";$stock_initial=0;$achats=0;$cout_revient=0;
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM types_matieres WHERE profile_id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "";

		$profile_name = $user_["profile_name"];$to=$user_["to"];$type_a=$user_["type_a"];
		$cout_revient=$user_["cout_revient"];
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
		if(document.getElementById("profile_name").value == "" ) {
			alert("<?php echo "valeurs required !"; ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "matieres.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="matieres.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">

		<tr>
		<td><?php echo "Libelle"; ?></td><td><input type="text" id="profile_name" name="profile_name" style="width:260px" value="<?php echo $profile_name; ?>"></td></tr>
		<tr><td><?php echo "Stock initial"; ?></td><td><?php echo $stock_initial; ?></td></tr>
		<tr><td><?php echo "C.M.U.P"; ?></td><td><input type="text" id="cout_revient" name="cout_revient" style="width:160px" value="<?php echo $cout_revient; ?>"></td></tr>
	</table>

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

<table class="table3"><tr>
<? $em="<tr><td align=\"left\"><a href=\"fiche_matiere.php?stock_initial=$stock_initial&matiere=$profile_name&stock_initial_pf=$stock_initial_matiere_pf&achats=$achats\">Fiche stock - $profile_name - sur Facturation</a></td>";
		print("<font size=\"3\" face=\"Arial\" color=\"#000033\">$em</font>");?>
<? $em="<tr><td align=\"left\"><a href=\"fiche_matiere_production.php?stock_initial=$stock_initial&matiere=$profile_name&stock_initial_pf=$stock_initial_matiere_pf&achats=$achats\">Fiche stock - $profile_name - sur Production</a></td>";
		print("<font size=\"3\" face=\"Arial\" color=\"#000033\">$em</font>");?>

</table>	


</body>

</html>