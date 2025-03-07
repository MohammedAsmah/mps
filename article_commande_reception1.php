<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];
	$qte_tige1=0;
				


	if($user_id == "0") {

		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM detail_bon_besoin WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$produit=$user_["produit"];$quantite=$user_["quantite"];$unite=$user_["unite"];$date_b=$user_["date_b"];$quantite_r=$user_["quantite_r"];
		$date_reception=dateUsToFr($user_["date_confirmation"]);$statut=$user_["statut"];$confirme=$statut=$user_["confirme"];$quantite_q=$user_["quantite"];
			
			
	}
	
	$type_reception = "";$vide="";
	$sql = "SELECT * FROM  types_reception ORDER BY type;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($statut == $temp_["type"]) { $selected = " selected"; } else { $selected = ""; }
		
		$type_reception .= "<OPTION VALUE=\"" . $temp_["type"] . "\"" . $selected . ">";
		$type_reception .= $temp_["type"];
		$type_reception .= "</OPTION>";
	}
	
	// extracts profile list

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

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
			document.location = "articles_commandes.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">
<? require "body_cal.php";?>
<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="articles_commandes_reception1.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table width="671" class="table3">

		<tr>
		<td><?php echo "Article"; ?></td><td><?php echo $produit; ?></td>
		</tr>
        <tr>
		<td><?php echo "Quantite Bon Besoin : "; ?></td><td><?php echo $quantite." ".$unite; ?></td>
		</tr>
        
		<td><?php echo "Quantite Confirmée"; ?></td><td><input type="text" id="quantite_q" name="quantite_q" style="width:140px" value="<?php echo $quantite_q; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Date Confirmation : "; ?></td><td><input onClick="ds_sh(this);" name="date_reception" value="<?php echo $date_reception; ?>" readonly="readonly" style="cursor: text" /></td>
		</tr>
		<td><?php echo "Bon Besoin Confirmé"; ?></td><td><input type="checkbox" id="confirme" name="confirme"<?php if($confirme) { echo " checked"; } ?>></td>
		
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

<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php } ?>
</tr></table>

</center>

</form>


</body>

</html>