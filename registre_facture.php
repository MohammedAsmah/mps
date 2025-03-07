<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_name=GetUserName();
	$user_id = $_REQUEST["user_id"];
	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouvelle LP";

		$lp = "";
		$date=dateUsToFr($_GET["date"]);
		$type_service = "TRANSFERTS";
		$service = "";
		$client = $_GET["client"];
		$statut = "en cours";
		$user_open = $user_name;
		$date_open = "";
		$observation="";
		$motif_cancel="";
		$groupe="";
		$guide="";
	
	} else {

		$action_ = "update_user";
		$action1_ = "update_detail";
	
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM registre_lp_rak WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "";

		$date=dateUsToFr($user_["date"]);
		$code = $user_["code_produit"];
		$service = $user_["service"];
		$client = $user_["client"];
		$statut = $user_["statut"];
		$user_open = $user_["user_open"];
		$date_open = $user_["date_open"];
		$observation=$user_["observation"];
		$type_service="TRANSFERTS";
		$motif_cancel=$user_["motif_cancel"];
		$groupe=$user_["groupe"];
		$guide=$user_["guide"];
		
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
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression de cette lp ?"; ?>")) {
			document.location = "registres_factures.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<?		
	$profiles_list_c = "Selectionez client";
	$sql_client = "SELECT last_name FROM rs_data_clients ORDER BY last_name;";
	$temp_client = db_query($database_name, $sql_client);
	while($temp_client_ = fetch_array($temp_client)) {
		if($client == $temp_client_["last_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_c .= "<OPTION VALUE=\"" . $temp_client_["last_name"] . "\"" . $selected . ">";
		$profiles_list_c .= $temp_client_["last_name"];
		$profiles_list_c .= "</OPTION>";
	}
	
	$profiles_list_p = "Selectionnez Produit";
	$sql_produit = "SELECT * FROM contrats_transferts where last_name='$client' ORDER BY first_name;";
	$temp_produit = db_query($database_name, $sql_produit);
	while($temp_produit_ = fetch_array($temp_produit)) {
		if($service == $temp_produit_["first_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_p .= "<OPTION VALUE=\"" . $temp_produit_["first_name"] . "\"" . $selected . ">";
		$profiles_list_p .= $temp_produit_["first_name"];
		$profiles_list_p .= "</OPTION>";
	}
	
	$type_list = "";
	$sql = "SELECT profile_id, profile_name FROM rs_produits_profiles where type='excursion' ORDER BY display_order;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($groupe == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$type_list .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$type_list .= $temp_["profile_name"];
		$type_list .= "</OPTION>";
	}

	$guide_list = "";
	$sql = "SELECT last_name FROM rs_data_guides ORDER BY last_name;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($guide == $temp_["last_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$guide_list .= "<OPTION VALUE=\"" . $temp_["last_name"] . "\"" . $selected . ">";
		$guide_list .= $temp_["last_name"];
		$guide_list .= "</OPTION>";
	}
	$status = "";
	$sql = "SELECT type FROM status ORDER BY type;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($statut == $temp_["type"]) { $selected = " selected"; } else { $selected = ""; }
		
		$status .= "<OPTION VALUE=\"" . $temp_["type"] . "\"" . $selected . ">";
		$status .= $temp_["type"];
		$status .= "</OPTION>";
	}
	$ty="LP";$ty_list="";
	$sql = "SELECT profile_name,type FROM rs_produits_profiles where type='$ty' ORDER BY profile_name;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($type_service == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$ty_list .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$ty_list .= $temp_["profile_name"];
		$ty_list .= "</OPTION>";
	}
	
	
?>

<form id="form_user" name="form_user" method="post" action="registres_factures.php">

<?

if($user_id == "0") { ?>

<table class="table2"><tr><td style="text-align:center">

		<tr>
		<td><?php echo "Date	:"; ?></td><td><input type="text" id="date" name="date" value="<?php echo $date; ?>"></td>
		</tr>
		<td>
		<?php echo "Client		:"; ?></td><td>
		<select id="client" name="client"><?php echo $profiles_list_c; ?></select></td>
		</tr>
		<td>
		<?php echo "Service		:"; ?></td><td>
		<select id="service" name="service"><?php echo $profiles_list_p; ?></select></td>
		</tr>
		<td>
		<?php echo "Statut		:"; ?></td><td><select id="statut" name="statut"><?php echo $status; ?></select></td>
		<td>
		<?php echo "Observations:"; ?></td><td><input type="text" id="observation" name="observation" style="width:250px" value="<?php echo $observation; ?>"></td>
		</tr>
		<td>
		<?php echo "Type		:"; ?></td><td>
		<select id="groupe" name="groupe"><?php echo $type_list; ?></select></td>
		</tr>
		<td>
		<?php echo "Guide		:"; ?></td><td>
		<select id="guide" name="guide"><?php echo $guide_list; ?></select></td>
		</tr>
		<tr><td><input type="hidden" id="motif_cancel" name="motif_cancel" style="width:250px" value="<?php echo $motif_cancel; ?>"></td>
		</tr>
		</td></tr></table>
		<? }
		else
		{ ?>
		<table class="table2"><tr><td style="text-align:center">

		<tr><td><?php echo "LP N° :"; ?></td><td><?php echo $user_id+200000; ?></td></tr>
		<tr>
		<td><?php echo "Date	:"; ?></td><td><input type="text" id="date" name="date" value="<?php echo $date; ?>"></td>
		</tr>
		<td>
		<?php echo "Client		:"; ?></td><td>
		<select id="client" name="client"><?php echo $profiles_list_c; ?></select></td>
		</tr>
		<td>
		<?php echo "Service		:"; ?></td><td>
		<select id="service" name="service"><?php echo $profiles_list_p; ?></select></td>
		</tr>
		<td>
		<?php echo "Statut		:"; ?></td><td><select id="statut" name="statut"><?php echo $status; ?></select></td>
		<td>
		<?php echo "Observations:"; ?></td><td><input type="text" id="observation" name="observation" style="width:250px" value="<?php echo $observation; ?>"></td>
		</tr>
		<td>
		<?php echo "Type		:"; ?></td><td>
		<select id="groupe" name="groupe"><?php echo $type_list; ?></select></td>
		</tr>
		<td>
		<?php echo "Guide		:"; ?></td><td>
		<select id="guide" name="guide"><?php echo $guide_list; ?></select></td>
		</tr>
		<tr><td><?php echo "Motif Annulation:"; ?></td><td><input type="text" id="motif_cancel" name="motif_cancel" style="width:250px" value="<?php echo $motif_cancel; ?>"></td>
		<td>
		<?php echo "Type service	:"; ?></td><td>
		<select id="type_service" name="type_service"><?php echo $ty_list; ?></select></td>
		
		</tr>
		
</td></tr></table>
<? } ?>



<center>
<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="user_open" name="user_open" value="<?php echo $user_open; ?>">
<input type="hidden" id="date_open" name="date_open" value="<?php echo $date_open; ?>">

<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">

  <table class="table3"><tr>

<?php if($user_id != "0") { ?>
<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td style="width:20px"></td>
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php 
} ?>
</tr></table>
</center>

</form>
<form id="form_user1" name="form_user1" method="post" action="registres_transferts.php">
<? $retour="retour";echo "<td><a href=\"registres_factures.php?action_r=$retour&date=$date&client=$client\">"."Retour"."</a></td>";?>
<input type="hidden" id="action_r" name="action_r" value="<?php echo $retour; ?>">
</form>
</body>

</html>