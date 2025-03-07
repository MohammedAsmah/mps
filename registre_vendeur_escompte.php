<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$user_login = $user_["login"];

	$user_name=GetUserName();
	$user_id = $_REQUEST["user_id"];$montantev = $_REQUEST["montant"];
	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$lp = "";
		$date=dateUsToFr($_GET["date"]);
		$type_service = "SEJOURS ET CIRCUITS";
		$service = "";$imprimer="";$heure="";$ordre="";$montant="";
		$vendeur = "";
		$statut = "";
		$user_open = $user_name;
		$date_open = "";$valide = 0;
		$observation="";
		$motif_cancel="";$matricule="";
	
	} else {

		$action_ = "update_user";
		$action1_ = "update_detail";
	
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM registre_vendeurs_escomptes WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "";

		$date=dateUsToFr($user_["date"]);
		$service = $user_["service"];
		$vendeur = $user_["vendeur"];$valide = $user_["valide"];
		$statut = $user_["statut"];
		$user_open = $user_["user_open"];
		$date_open = $user_["date_open"];
		$observation=$user_["observation"];
		$type_service="SEJOURS ET CIRCUITS";
		$motif_cancel=$user_["motif_cancel"];$id=$_REQUEST["user_id"];
		$imprimer=$user_["imprimer"];$heure=$user_["heure"];$imprimer1=$user_["imprimer"];$matricule=$user_["matricule"];$obs_c=$user_["obs_c"];
		$ordre=$user_["ordre"];$montant=$user_["montant"];$montantev1=$user_["montant"];$heure1=$user_["heure"];
		
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
			UpdateUser();
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "registres_vendeurs_escomptes.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<?		
	$vendeur_list = "";
	$sql = "SELECT * FROM  vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$vendeur_list .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$vendeur_list .= $temp_["vendeur"];
		$vendeur_list .= "</OPTION>";
	}
	$profiles_list_p = "Selectionnez Produit";
	$sql_produit = "SELECT * FROM rs_data_villes ORDER BY ville;";
	$temp_produit = db_query($database_name, $sql_produit);
	while($temp_produit_ = fetch_array($temp_produit)) {
		if($service == $temp_produit_["ville"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_p .= "<OPTION VALUE=\"" . $temp_produit_["ville"] . "\"" . $selected . ">";
		$profiles_list_p .= $temp_produit_["ville"];
		$profiles_list_p .= "</OPTION>";
	}
	$profiles_list = "";
	$sql = "SELECT profile_id, profile_name FROM rs_statut_profiles ORDER BY profile_id;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($statut == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$profiles_list .= $temp_["profile_name"];
		$profiles_list .= "</OPTION>";
	}
	
?>

<form id="form_user" name="form_user" method="post" action="registres_vendeurs_escomptes.php">

<table class="table2"><tr><td style="text-align:center">

		<tr>
		<td><?php echo "Date	:"; ?></td><td><input type="text" id="date" name="date" value="<?php echo $date; ?>"></td>
		</tr>
		<td>
		<?php echo "Vendeur		:"; ?></td><td>
		<select id="vendeur" name="vendeur"><?php echo $vendeur_list; ?></select></td>
		<tr>
		<td>
		<?php echo "Destination		:"; ?></td><td>
		<select id="service" name="service"><?php echo $profiles_list_p; ?></select></td>
		</tr>
		<? /*<td>
		<?php echo "Bon de Sortie	:"; ?></td><td><input type="text" id="statut" name="statut" value="<?php echo $statut; ?>"></td>
		<td>
		*/ ?>
		<td><?php echo "Observations:"; ?></td><td><input type="text" id="observation" name="observation" style="width:250px" value="<?php echo $observation; ?>"></td>
		</tr>
		<tr><td><input type="hidden" id="motif_cancel" name="motif_cancel" style="width:250px" value="<?php echo $motif_cancel; ?>"></td>
		</tr>
		
		<? if($user_id <> "0" and $imprimer1==0) {?>
		<tr>
		<td><input type="checkbox" id="imprimer" name="imprimer"<?php if($imprimer) { echo " checked"; } ?>></td>
		<td><?php echo "Valider Impression"; ?></td></tr>
		<? }?>
		
		<? if($user_login == "rakia" or $user_login=="admin") {?>
		<tr>
		<td><?php echo "M.C"; ?></td><td><input type="text" id="matricule" name="matricule" value="<?php echo $matricule; ?>"></td>
		<td><?php echo "OBS"; ?></td><td><input type="text" id="obs_c" name="obs_c" value="<?php echo $obs_c; ?>"></td>
		</tr>
		<? }?>
		
		
		
</td></tr></table>

<center>
<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="user_open" name="user_open" value="<?php echo $user_open; ?>">
<input type="hidden" id="date_open" name="date_open" value="<?php echo $date_open; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="montantev" name="montantev" value="<?php echo $montantev; ?>">
<input type="hidden" id="imprimer1" name="imprimer1" value="<?php echo $imprimer1; ?>">
<input type="hidden" id="montantev1" name="montantev1" value="<?php echo $montantev1; ?>">
<input type="hidden" id="heure1" name="heure1" value="<?php echo $heure1; ?>">
  <table class="table3"><tr>

<?php if($user_id != "0") { ?>
<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td style="width:20px"></td>
<? if ($user_login=="admin"){ ?>
<td><button type="button" onClick="DeleteUser()"><?php echo Translate("Delete"); ?></button></td>
<? } ?>
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php 
} ?>
</tr></table>
</center>

</form>

</body>

</html>