<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$employe = $_REQUEST["employe"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Client";

		$date_avance = "";$motif="";$date_prelevement="";$montant=0;$montant_prelevement=0;
		
		
		
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM avances_employes WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = $employe;

		$date_avance = dateUsToFr($user_["date_avance"]);$motif = $user_["motif"];$date_prelevement = dateUsToFr($user_["date_prelevement"]);
		$montant = $user_["montant"];$montant_prelevement = $user_["montant_prelevement"];$libelle = $user_["document"];		
		}

		
	
	// extracts profile list
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
		if(document.getElementById("date_avance").value == "" ) {
			alert("<?php echo Translate("The values for the fields are required !"); ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "avances_employes.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" enctype="multipart/form-data" method="post" action="avances_employes.php">


<table class="table2"><tr><td style="text-align:center">

	<center>

		<table class="table3">
		<tr>
		<td>
		<tr><td><?php echo "Date : "; ?><input type="text" id="date_avance" name="date_avance" style="width:160px" value="<?php echo $date_avance; ?>"></td>
		<tr><td><?php echo "Montant : "; ?><input type="text" id="montant" name="montant" style="width:160px" value="<?php echo $montant; ?>"></td>
		<tr><td><?php echo "Motif : "; ?><input type="text" id="motif" name="motif" style="width:160px" value="<?php echo $motif; ?>"></td>
		
		<td>
		<tr><td><?php echo "Image : "; ?><input type="file" name="fichier1" /></td>
		<tr><td><? $w=300;$h=300;print("<img src=\"./avances/$libelle\" border=\"0\" width='$w' height='$h'>"); 
		
		
		?></td>
		</td>
			
		</table>
		
		
		
		


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="id_employe" name="employe" value="<?php echo $employe; ?>">
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