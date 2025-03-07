<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	$evaluation=$_GET['commande'];$id_registre=$_GET['id_registre'];$date=$_GET['date'];$vendeur=$_GET['vendeur'];$bon_sortie=$_GET['bon_sortie'];$client=$_GET['client'];
	
			$sql = "UPDATE commandes SET ";$valider_f=1;$oui=1;
			$sql .= "id_registre = '" . $id_registre . "', ";
			$sql .= "bondesortie = '" . $bon_sortie . "', ";
			$sql .= "confirmee = '" . $oui . "' ";
			$sql .= "WHERE client='$client' and commande = " . $evaluation . ";";
			db_query($database_name, $sql);
			
			$sql1  = "SELECT * ";$m=0;$total=0;
	$sql1 .= "FROM detail_commandes where commande='$evaluation' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
			$id=$users1_["id"];
			$sql = "UPDATE detail_commandes SET ";
			$sql .= "id_registre = '" . $id_registre . "', ";
			$sql .= "date = '" . $date . "', ";
			$sql .= "bon_sortie = '" . $bon_sortie . "' ";
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
<table>
<? echo "<td><a href=\"evaluations_escomptes.php?date=$date&vendeur=$vendeur&id_registre=$id_registre&bon_sortie=$bon_sortie\">Continuer</a></td>";?>
<? $terminer="terminer";echo "<td><a href=\"registres_vendeurs_escomptes.php?date=$date&vendeur=$vendeur&id_registre=$id_registre&action_=$terminer\">Terminer</a></td>";?>
</table>
</body>

</html>