<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_name=GetUserName();
	$user_id = $_REQUEST["user_id"];$net = $_REQUEST["net"];
	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$lp = "";
		$date=dateUsToFr($_GET["date"]);
		$type_service = "SEJOURS ET CIRCUITS";
		$service = "";
		$vendeur =$_GET["vendeur"];
		$statut = "";$valider_caisse=0;
		$user_open = $user_name;
		$date_open = "";
		$observation="";$mode="";$montant_total=0;$date_valeur="";$reference=0;

	} else {

		$action_ = "update_user";
		$action1_ = "update_detail";
	
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM registre_reglements_frs WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "";

		$date=dateUsToFr($user_["date"]);
		$service = $user_["service"];
		$vendeur = $user_["vendeur"];
		$statut = $user_["statut"];
		$user_open = $user_["user_open"];
		$date_open = $user_["date_open"];
		$observation=$user_["observation"];$mode=$user_["mode"];$montant_total=$user_["montant_total"];
		$date_valeur=dateUsToFr($user_["date_valeur"]);$reference=$user_["reference"];
		
	}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
<? require "head_cal.php";?>
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
			document.location = "registres_reglements_frs.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">
<? require "body_cal.php";?>
<?		
	$vendeur_list = "";
	$sql = "SELECT * FROM  rs_data_fournisseurs ORDER BY last_name;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["last_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$vendeur_list .= "<OPTION VALUE=\"" . $temp_["last_name"] . "\"" . $selected . ">";
		$vendeur_list .= $temp_["last_name"];
		$vendeur_list .= "</OPTION>";
	}
	$profiles_list_mode = "";
	$sql4 = "SELECT * FROM rs_data_mode ORDER BY mode;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($mode == $temp_["mode"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_mode .= "<OPTION VALUE=\"" . $temp_["mode"] . "\"" . $selected . ">";
		$profiles_list_mode .= $temp_["mode"];
		$profiles_list_mode .= "</OPTION>";
	}
	
?>

<form id="form_user" name="form_user" method="post" action="registres_reglements_frs.php">

<table class="table2">

		<tr>
		<td><?php echo "Date	:"; ?></td><td><input onClick="ds_sh(this);" name="date" value="<?php echo $date; ?>" readonly="readonly" style="cursor: text" /></td>
		</tr>
		<td>
		<?php echo "Fournisseur		:"; ?></td><td>
		<select id="vendeur" name="vendeur"><?php echo $vendeur_list; ?></select></td>
		<tr>
		<td><?php echo "Obs	:"; ?></td><td><input type="text" id="observation" name="observation" value="<?php echo $observation; ?>"></td>
		</tr>
		<tr><td><?php echo "Mode	:"; ?></td><td>
		<select id="mode" name="mode"><?php echo $profiles_list_mode; ?></select></td>
		<tr><td><?php echo "Montant	:"; ?></td><td><input type="text" id="montant_total" name="montant_total" value="<?php echo $net; ?>"></td>
		<? if ($net<>0){?>
		<tr><td><?php echo "Date_valeur	:"; ?></td><td><input type="text" id="date_valeur" name="date_valeur" value="<?php echo $date_valeur; ?>"></td>
		<tr><td><?php echo "Reference	:"; ?></td><td><input type="text" id="reference" name="reference" value="<?php echo $reference; ?>"></td>
		<? }?>
		
	</table>
	<tr>	

</td></tr></table>



<center>
<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="user_open" name="user_open" value="<?php echo $user_open; ?>">
<input type="hidden" id="date_open" name="date_open" value="<?php echo $date_open; ?>">
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

</body>

</html>