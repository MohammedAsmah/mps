<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];
	$user_id = $_REQUEST["user_id"];$qte_tige1=0;
				$sql = "TRUNCATE TABLE `fiche_stock`  ;";
			db_query($database_name, $sql);


	if($user_id == "0") {

		
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		
		$produit = $user_["produit"];
		$barecode_piece = $user_["barecode_piece"];
		$hauteur=$user_["hauteur"];$longueur=$user_["longueur"];$largeur=$user_["largeur"];
			
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
		
			UpdateUser();
		
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression de ce produit ?"; ?>")) {
			document.location = "produits.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">
<? require "body_cal.php";?>
<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="produits_v.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table width="671" class="table3">

		<tr>
		<td><?php echo "Designation"; ?></td><td><?php echo $produit; ?></td>
		</tr>
		<tr>
		<td><?php echo "Hauteur"; ?></td><td><input type="text" id="hauteur" name="hauteur" style="width:260px" value="<?php echo $hauteur; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Longueur"; ?></td><td><input type="text" id="longueur" name="longueur" style="width:260px" value="<?php echo $longueur; ?>"></td>
		</tr>
        <tr>
		<td><?php echo "Largeur"; ?></td><td><input type="text" id="largeur" name="largeur" style="width:240px" value="<?php echo $largeur; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Barrcode"; ?></td><td><input type="text" id="barecode_piece" name="barecode_piece" style="width:240px" value="<?php echo $barecode_piece; ?>"></td>
		</tr>
		
	</table>

	</center>

</td></tr></table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="stock_final" name="stock_final" value="<?php echo $stock_final; ?>">
<input type="hidden" id="production" name="production" value="<?php echo $production; ?>">
<input type="hidden" id="stock_initial" name="stock_initial" value="<?php echo $stock_ini_exe; ?>">
<input type="hidden" id="qte_vendu" name="qte_vendu" value="<?php echo $qte_vendu; ?>">
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

<table width="671" class="table3">

<?		
		
?>


</table>



</body>

</html>