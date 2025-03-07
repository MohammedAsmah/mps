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
	


	if($user_id == "0") {

		$action_ = "insert_new_user";
		$date_creation="";

		$title = "Nouveau Produit";

		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM dossiers_importations WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date_creation=$user_["date_creation"];
		
			
	}
	
	$profiles_list_type = "";
	$sql1 = "SELECT * FROM types_articles ORDER BY profile_name;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($type == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_type .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$profiles_list_type .= $temp_["profile_name"];
		$profiles_list_type .= "</OPTION>";
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
		if(document.getElementById("produit").value == "" ) {
			alert("<?php echo "Nom Produit !"; ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression  ?"; ?>")) {
			document.location = "dossiers_importations.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="dossiers_importations.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table width="671" class="table3">

		<tr>
		<td><?php echo "Designation"; ?></td><td><input type="text" id="produit" name="produit" style="width:260px" value="<?php echo $produit; ?>"></td>
		</tr>
        </td>
		<tr>
		<td><?php echo "Type : "; ?></td><td><select id="type" name="type"><?php echo $profiles_list_type; ?></select></td>
		</tr>
		<tr>
		<td><?php echo "Famille : "; ?></td><td><select id="famille" name="famille"><?php echo $profiles_list_famille; ?></select></td>
		</tr>
        <tr>
		<td><?php echo "Conditionnement"; ?></td><td><input type="text" id="condit" name="condit" style="width:240px" value="<?php echo $condit; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Prix Unitaire"; ?></td><td><input type="text" id="prix" name="prix" style="width:140px" value="<?php echo $prix; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Stock Alarme"; ?></td><td><input type="text" id="seuil_critique" name="seuil_critique" style="width:80px" value="<?php echo $seuil_critique; ?>"></td>
		</tr>
		
		</tr><tr>
		<? if ($login=="admin"){?><td><?php echo ""; ?></td><td><input type="text" id="stock_ini_exe" name="stock_ini_exe" style="width:140px" value="<?php echo $stock_ini_exe; ?>"></td>
		<tr>
		<td><?php echo "Nombre Equipes"; ?></td><td><input type="text" id="equipes" name="equipes" style="width:80px" value="<?php echo $equipes; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Stock Comptable"; ?></td><td><input type="text" id="stock_comptable" name="stock_comptable" style="width:80px" value="<?php echo $stock_comptable; ?>"></td>
		</tr>
		<? }?>
		</tr>		
		
		<tr><td><input type="checkbox" id="dispo" name="dispo"<?php if($dispo) { echo " checked"; } ?>></td><td>Article disponible</td>

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


</body>

</html>