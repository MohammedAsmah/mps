<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();$em=0;
	$error_message = "";	$du=$_GET["du"];$au=$_GET["au"];$matiere=$_GET["matiere"];$em=$_GET["em"];
	$du1=dateUsToFr($_GET["du"]);$au1=dateUsToFr($_GET["au"]);$qtes=0;
	
	
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
<span style="font-size:18px"><?php echo " Emballage :  du : $du1 au $au1 : $matiere"; ?></span>

<table class="table2">
<td bgcolor="#66FFCC"><? echo "Article";?></td>
<td bgcolor="#66FFCC"><? echo "Quantite";?></td>
<td bgcolor="#66FFCC"><? echo "X";?></td>
<td bgcolor="#66FFCC"><? echo "Condit";?></td>
<td bgcolor="#66FFCC"><? echo "Poids en Kg";?></td>

<?	

	
	$sql1  = "SELECT * ";$mt=0;$m=0;
	$sql1 .= "FROM produits where emballage='$matiere' or emballage2='$matiere' or emballage3='$matiere' or emballage4='$matiere' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
 		$produit = $users1_["produit"];$condit1 = $users1_["condit"];$qte=0;$poids = $users1_["poids"];
		$montant=0;$condit=0;
		$emballage1 = $users1_["emballage"];$emballage2 = $users1_["emballage2"];
		$emballage3 = $users1_["emballage3"];$qte_emb=1;$emballage4 = $users1_["emballage4"];
		
		if ($matiere==$emballage1){$qte_emb=$users1_["qte_emballage"];$art="emballage paquet";}
		if ($matiere==$emballage2){$qte_emb=$users1_["qte_emballage2"];$art="emballage paquet";}
		if ($matiere==$emballage3){$qte_emb=$users1_["qte_emballage3"];$art="emballage paquet";}
		if ($matiere==$emballage4){$qte_emb=$users1_["qte_emballage4"];$art="emballage piece ou accessoire";}
		
		
		if ($em==1){
		/*---------------------------*/
		$sql  = "SELECT * ";$vide="";$type="sachets";
	$sql .= "FROM types_emballages1 where profile_name='$matiere' ORDER BY profile_name;";
	$usersm = db_query($database_name, $sql);$usersm_ = fetch_array($usersm);$qte_emb = number_format($usersm_["poids"],0,',',' ');
	}
	
		/*---------------------------*/?>
	<?
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_factures2024 where produit='$produit' and (date_f between '$du' and '$au' ) ORDER BY produit;";
	$users11 = db_query($database_name, $sql1);
	while($users11_ = fetch_array($users11)) { 
			$qte=$qte+($users11_["quantite"]*$users11_["condit"]);	
	}
	
	//if ($qte>0)
	
	//{?>	<tr>
	<? $matiere1=$produit; echo "<td><a href=\"ca_par_quantite_details.php?matiere=$matiere1&du=$du&au=$au\">$matiere1 ---> $art</a></td>";?>
	<td align="right"><? $qtes=$qtes+$qte;echo $qte;?></td>
	<td align="right"><? echo $qte_emb;?></td>
	<td align="right"><? echo $condit1;?></td>
	<td align="right"><? echo number_format($qte/$condit1,2,',',' ');?></td>
	</tr>
	
	<? $m=$m+($qte/$condit1);$mt=$mt+$m; ?><? //}
	 ?>
	<? }?>
	<td></td>
<td align="right"><? echo number_format($qtes,0,',',' ');?></td><td></td><td></td>
	<td align="right"><? echo number_format($m,2,',',' ');?></td>

</table>

</body>

</html>