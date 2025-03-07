<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_name=GetUserName();
	$user_id = $_REQUEST["user_id"];
	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$lp = "";
		$date_tirage=dateUsToFr($_GET["date_tirage"]);
		
		$libelle = "";
		$debit="";
		$credit="";
		$user_open = $user_name;
		$date_open = "";
		$date_dernier_mouvement_mps = "";
		$debit_mps="";
		$credit_mps="";
		
	} else {

		$action_ = "update_user";
		$action1_ = "update_detail";
	
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM etats_erreurs WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "";
		$banque=$user_["banque"];
		$debit=$user_["debit"];$date_tirage=dateUsToFr($user_["date_tirage"]);$credit=$user_["credit"];$libelle=$user_["libelle"];
	
		
		$user_open = $user_name;
		$date_open = "";
		
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
			document.location = "registres_erreurs.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<?		
	
	
?>

<form id="form_user" name="form_user" method="post" action="registres_erreurs.php">

<table class="table2">

		<tr>
		<td><?php echo "Date :"; ?></td><td><input type="text" id="date_tirage" name="date_tirage" value="<?php echo $date_tirage; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Libelle	:"; ?></td><td><input type="text" id="libelle" name="libelle" value="<?php echo $libelle; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Debiteur	:"; ?></td><td><input type="text" id="debit" name="debit" value="<?php echo $debit; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Crediteur	:"; ?></td><td><input type="text" id="credit" name="credit" value="<?php echo $credit; ?>"></td>
		</tr>
	</table>
	


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