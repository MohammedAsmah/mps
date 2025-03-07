<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_name=GetUserName();
	$user_id = $_REQUEST["user_id"];
	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Dossier";

		$lp = "";
		$date="";
		$type_service = "";
		$service = "";
		$client = "";
		$statut = "En cours";
		$user_open = $user_name;
		$date_open = "";
		$observation="";
	
	} else {

		$action_ = "update_user";
		$action1_ = "update_detail";
	
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM registre_sans_lp WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "";

		$date=dateUsToFr($user_["date"]);
		$service = $user_["service"];
		$client = $user_["client"];
		$statut = $user_["statut"];
		$user_open = $user_["user_open"];
		$date_open = $user_["date_open"];
		$observation=$user_["observation"];
		
		/*$du_a1_value=dateUsToFr($user_['du_a1']);$au_a1_value=dateUsToFr($user_['au_a1']);$du_b1_value=dateUsToFr($user_['du_b1']);$au_b1_value=dateUsToFr($user_['au_b1']);
		$du_c1_value=dateUsToFr($user_['du_c1']);$au_c1_value=dateUsToFr($user_['au_c1']);$du_d1_value=dateUsToFr($user_['du_d1']);$au_d1_value=dateUsToFr($user_['au_d1']);
		$du_e1_value=dateUsToFr($user_['du_e1']);$au_e1_value=dateUsToFr($user_['au_e1']);*/

		/*$date_fr = '24-11-2003 11:03:56';
		$date_us = dateFrToUs ($date_fr);
		echo $date_us;*/
		
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
		if(document.getElementById("service").value == "" ) {
			alert("<?php echo "service obligatoire !"; ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression de cette lp ?"; ?>")) {
			document.location = "registres_sans.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
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
	$sql_produit = "SELECT last_name FROM rs_data_produits where profile_id=1 or profile_id=2 ORDER BY last_name;";
	$temp_produit = db_query($database_name, $sql_produit);
	while($temp_produit_ = fetch_array($temp_produit)) {
		if($service == $temp_produit_["last_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_p .= "<OPTION VALUE=\"" . $temp_produit_["last_name"] . "\"" . $selected . ">";
		$profiles_list_p .= $temp_produit_["last_name"];
		$profiles_list_p .= "</OPTION>";
	}
?>

<form id="form_user" name="form_user" method="post" action="registres_sans.php">

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
		<?php echo "Statut		:"; ?></td><td><input type="text" id="statut" name="statut"  value="<?php echo $statut; ?>"></td>
		<td>
		<?php echo "Observations:"; ?></td><td><input type="text" id="observation" name="observation" style="width:250px" value="<?php echo $observation; ?>"></td>
		</tr>
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
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php 
} ?>
</tr></table>
</center>

</form>

</body>

</html>