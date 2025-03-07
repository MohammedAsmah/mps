<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";	$du=$_GET["du"];$au=$_GET["au"];$matiere=$_GET["matiere"];
	$du1=dateUsToFr($_GET["du"]);$au1=dateUsToFr($_GET["au"]);
	
	
?>
</table>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "produit.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:18px"><?php echo " Matieres Premieres :  du : $du1 au $au1 : $matiere"; ?></span>

<table class="table2">
<td bgcolor="#66FFCC"><? echo "Article";?></td>
<td bgcolor="#66FFCC"><? echo "Poids en Kg";?></td>
<?	

	
	$sql1  = "SELECT * ";$mt=0;$m=0;
	$sql1 .= "FROM produits where matiere='$matiere' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
 		$produit = $users1_["produit"];$condit1 = $users1_["condit"];$qte=0;$poids = $users1_["poids"];$montant=0;$condit=0;?>
	<?
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_factures2024 where produit='$produit' and (date_f between '$du' and '$au' ) ORDER BY produit;";
	$users11 = db_query($database_name, $sql1);
	while($users11_ = fetch_array($users11)) { 
			$qte=$qte+($users11_["quantite"]*$users11_["condit"]);
	
	}
	
	if ($qte>0)
	
	{?>	<tr>
	<? $matiere=$produit; echo "<td><a href=\"ca_par_quantite_details.php?matiere=$matiere&du=$du&au=$au\">$matiere</a></td>";?>
	<td align="right"><? echo number_format($qte*$poids/1000,2,',',' ');?></td></tr>
	
	<? $m=$m+($qte*$poids/1000);$mt=$mt+$m; ?><? }
	 ?>
	<? }?>
	<td></td><td align="right"><? echo number_format($m,2,',',' ');?></td>

</table>

</body>

</html>