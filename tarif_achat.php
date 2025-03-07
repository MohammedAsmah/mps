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
				


	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Produit";

		$produit = "";$favoris = 0;$non_favoris = 0;$colorant="";$qte_colorant=0;$dispo=0;
		$condit = "";$poids_evaluation="";
		$non_disponible="";$seuil_critique=0;$type="";$stock_controle="";
		$accessoire_1="";$qte_ac_1="";$poids_ac_1="";$mat_ac_1="";
		$accessoire_2="";$qte_ac_2="";$poids_ac_2="";$mat_ac_2="";
		$accessoire_3="";$qte_ac_3="";$poids_ac_3="";$mat_ac_3="";$famille="";

		$prix = "";$en_cours_final=0;$prix_revient_final=0;$production=0;$stock_ini_exe=0;
		$poids = "";$stock_initial = 0;$encours = 0;$stock_final = 0;$prix_revient =0;
		$tige="";$qte_tige=1;$emballage="";$qte_emballage=1;$matiere="";$qte_matiere=1;$etiquette="";$qte_etiquette=1;
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM tarifs_achats WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$article=$user_["article"];$fournisseur=$user_["fournisseur"];
		$unite=$user_["unite"];$prix_unitaire=$user_["prix_unitaire"];
			
			
	}
	
	$profiles_list_article = "";
	$sql1 = "SELECT * FROM articles_commandes ORDER BY produit;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($article == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article .= $temp_["produit"];
		$profiles_list_article .= "</OPTION>";
	}
	$profiles_list_frs = "";
	$sql1 = "SELECT * FROM rs_data_fournisseurs ORDER BY last_name;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($fournisseur == $temp_["last_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_frs .= "<OPTION VALUE=\"" . $temp_["last_name"] . "\"" . $selected . ">";
		$profiles_list_frs .= $temp_["last_name"];
		$profiles_list_frs .= "</OPTION>";
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
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression de ce produit ?"; ?>")) {
			document.location = "tarifs_achats.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="tarifs_achats.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table width="671" class="table3">

		
        <tr>
		<td><?php echo "Article : "; ?></td><td><select id="produit" name="produit"><?php echo $profiles_list_article; ?></select></td>
		</tr>
		<tr>
		<td><?php echo "Fournisseur : "; ?></td><td><select id="fournisseur" name="fournisseur"><?php echo $profiles_list_frs; ?></select></td>
		</tr>
        <tr>
		<td><?php echo "Prix Unitaire : "; ?></td><td><input type="text" id="prix_unitaire" name="prix_unitaire" value="<?php echo $prix_unitaire; ?>"></td>
		</tr>
		
		
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