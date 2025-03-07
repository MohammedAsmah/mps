<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	$evaluation=$_GET['commande'];$id_registre=$_GET['id_registre'];$date=$_GET['date'];$vendeur=$_GET['vendeur'];
	
			$sql = "UPDATE commandes SET ";$valider_f=1;$oui=0;$id_r=0;$bondesortie="";
			$sql .= "id_registre = '" . $id_r . "', ";
			$sql .= "bondesortie = '" . $bondesortie . "', ";
			$sql .= "confirmee = '" . $oui . "' ";
			$sql .= "WHERE commande = " . $evaluation . ";";
			db_query($database_name, $sql);
			$sql1 .= "FROM detail_commandes where commande='$evaluation' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;$vide="";$vide_id=0;$date_vide="0000-00-00";
	while($users1_ = fetch_array($users1)) { 
	$id=$users1_["id"];
			$sql = "UPDATE detail_commandes SET ";
			$sql .= "id_registre = '" . $vide_id . "', ";
			$sql .= "date = '" . $date_vide . "', ";
			$sql .= "bon_sortie = '" . $vide . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
	}
	
			
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Detail Evaluation"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>



<p style="text-align:center">

<? echo "<td><a href=\"evaluations1.php?date=$date&vendeur=$vendeur&id_registre=$id_registre\">Fermer</a></td>";?>

</body>

</html>