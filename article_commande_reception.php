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
		$date_reception=dateUsToFr($user_["date_reception"]);$statut=$user_["statut"];$confirme=$user_["confirme_code"];
			
			
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
			document.location = "articles_commandes_reception.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">
<? require "body_cal.php";?>
<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="articles_commandes_reception.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table width="671" class="table3">

		<tr>
		<td><?php echo "Article"; ?></td><td><?php echo $produit; ?></td>
		</tr>
        <tr>
		<td><?php echo "Quantite Bon Besoin : "; ?></td><td><?php echo $quantite; ?></td>
		</tr>
        <tr>
		<td><?php echo "Unite"; ?></td><td><?php echo $unite;?></td>
		</tr><tr>
		<td><?php echo "Quantite Reception"; ?></td><td><input type="text" id="quantite_r" name="quantite_r" style="width:140px" value="<?php echo $quantite_r; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Date Reception : "; ?></td><td><input onClick="ds_sh(this);" name="date_reception" value="<?php echo $date_reception; ?>" readonly="readonly" style="cursor: text" /></td>
		</tr>
		<tr>
		<td><?php echo "Ref Reception"; ?></td><td><input type="text" id="ref_r" name="ref_r" style="width:140px" value="<?php echo $ref_r; ?>"></td>
		</tr>
		
		<tr>
		<td><?php echo "Quantite Reception reliquat"; ?></td><td><input type="text" id="quantite_r2" name="quantite_r2" style="width:140px" value="<?php echo $quantite_r2; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Date Reception reliquat : "; ?></td><td><input onClick="ds_sh(this);" name="date_reception2" value="<?php echo $date_reception2; ?>" readonly="readonly" style="cursor: text" /></td>
		</tr>
		<tr>
		<td><?php echo "Ref Reception"; ?></td><td><input type="text" id="ref_r2" name="ref_r2" style="width:140px" value="<?php echo $ref_r2; ?>"></td>
		</tr>
		
		<td><?php echo "Type Reception"; ?></td><td><select id="statut" style="width:250px" name="statut"><?php echo $type_reception; ?></select></td>
		
	</table>

	</center>

</td></tr></table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="confirme" name="confirme" value="<?php echo $confirme; ?>">
<table class="table3"><tr>

<?php if($user_id != "0") { ?>
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