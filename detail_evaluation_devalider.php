<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	$evaluation=$_GET['commande'];$client=$_GET['client'];$facture=$_GET['facture'];$eval=$_GET['eval'];$du=$_GET['du'];$au=$_GET['au'];
		$sql1  = "SELECT * "; 
		$sql1 .= "FROM clients WHERE client = '$client';";
		$user1 = db_query($database_name, $sql1); $user1_ = fetch_array($user1);
		$nom_client = $user1_["client"];$remise2 = $user1_["remise2"];$remise3 = $user1_["remise3"];
	
			$sql = "UPDATE commandes SET ";$valider_f=0;$fv=0;
			$sql .= "facture = '" . $fv . "', ";
			$sql .= "valider_f = '" . $valider_f . "' ";
			$sql .= "WHERE commande = " . $evaluation . ";";
			db_query($database_name, $sql);
			
			$sql = "UPDATE factures SET ";$valider_f=0;$f=$facture-9040;
			$sql .= "valide = '" . $valider_f . "' ";
			$sql .= "WHERE id = " . $f . ";";
			db_query($database_name, $sql);
			
			$sql = "DELETE FROM detail_factures WHERE evaluation='$eval' and facture = " . $facture . ";";
			db_query($database_name, $sql);
			
			
			
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

<span style="font-size:24px"><?php echo ""; ?></span>


<p style="text-align:center">

<? echo "<td><a href=\"factures.php?du=$du&au=$au\">Fermer</a></td>";?>

</body>

</html>