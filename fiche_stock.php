<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$qte_tige1=0;
				$sql = "TRUNCATE TABLE `fiche_stock`  ;";
			db_query($database_name, $sql);


	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Produit";

		$produit = "";$favoris = 0;$non_favoris = 0;$colorant="";$qte_colorant=0;$dispo=0;
		$condit = "";
		$prix = "";$en_cours_final=0;$prix_revient_final=0;$production=0;
		$poids = "";$stock_initial = 0;$encours = 0;$stock_final = 0;$prix_revient =0;
		$tige="";$qte_tige=1;$emballage="";$qte_emballage=1;$matiere="";$qte_matiere=1;$etiquette="";$qte_etiquette=1;
	
	} else {

		$action_ = "update_user";
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";
		$stock_ini_exe = $user_["stock_ini_exe"];
		$produit = $user_["produit"];$colorant = $user_["colorant"];$dispo = $user_["dispo"];$production=0;$production1 = $user_["production"];
		$condit = $user_["condit"];$qte_colorant=$user_["qte_colorant"];$prix_revient_final = $user_["prix_revient_final"];$en_cours_final = $user_["en_cours_final"];
		$prix = $user_["prix"];$favoris = $user_["favoris"];$non_favoris = $user_["non_favoris"];$encours = $user_["encours"];
		$poids = $user_["poids"];$stock_initial = $user_["stock_ini_exe"];$stock_final = $user_["stock_final"];$prix_revient = $user_["prix_revient"];
		$tige=$user_["tige"];$qte_tige=$user_["qte_tige"];$emballage=$user_["emballage"];$qte_emballage=$user_["qte_emballage"];
		$matiere=$user_["matiere"];$qte_matiere=$user_["qte_matiere"];$etiquette=$user_["etiquette"];$qte_etiquette=$user_["qte_etiquette"];
			$sql1  = "SELECT * ";$du="2009-01-01";$au=$_REQUEST["au"];
			$sql1 .= "FROM productions where produit='$produit' and (date between '$du' and '$au' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);
			while($users11_ = fetch_array($users11)) { 
			
			$production=$production+($users11_["qte"]*$condit);$qte=$users11_["qte"]*$condit;$date=$users11_["date"];$ref="Entree stock";$t1=1;
				$sql  = "INSERT INTO fiche_stock ( produit, date, entree,ref,type ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $qte . "', ";
				$sql .= "'" . $ref . "', ";
				$sql .= $t1 . ");";

				db_query($database_name, $sql);

			}
	}
			$sql1  = "SELECT * ";$qte_vendu=0;$du="2009-01-01";$au=$_REQUEST["au"];
			$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$du' and '$au' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);
			while($users11_ = fetch_array($users11)) { 
			$qte_vendu=$qte_vendu+($users11_["quantite"]*$users11_["condit"]);$numero=$users11_["facture"];
			$qte=$users11_["quantite"]*$users11_["condit"];$date=$users11_["date_f"];$ref="Sortie stock / F $numero";$t2=2;
				$sql  = "INSERT INTO fiche_stock ( produit, date, sortie,ref,type ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $qte . "', ";
				$sql .= "'" . $ref . "', ";
				$sql .= $t2 . ");";

				db_query($database_name, $sql);

			}
			$stock_final=$stock_initial+$production-$qte_vendu;
	
	
	

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">
<link href="Templates/css.css" rel="stylesheet" type="text/css">

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>


<p style="text-align:center">

<center>

<table class="table3"><tr>

</tr></table>

</center>

</form>

<table class="table2">
<TD>DATE</TD>
<td>DESIGNATION</td>
<TD>ENTREE</TD>
<TD>SORTIE</TD>
<TD>STOCK</TD>
</TR>
<td><?php echo dateUsToFr($du); ?></td>
<td><?php echo "Stock Initial"; ?></td>
<td><?php echo $stock_ini_exe; ?></td>
<? 			$sql1  = "SELECT * ";$du="2009-01-01";$au=$_REQUEST["au"];
			$sql1 .= "FROM fiche_stock where produit='$produit' and date between '$du' and '$au' ORDER BY date,type;";
			$users11 = db_query($database_name, $sql1);$e=0;$s=0;
			while($users11_ = fetch_array($users11)) { 
			$date=dateUsToFr($users11_["date"]);$ref=$users11_["ref"];$entree=$users11_["entree"];$sortie=$users11_["sortie"];
			$type=$users11_["type"];
			$e=$e+$entree;$s=$s+$sortie;
	?>
	<tr><td><?php echo $date; ?></td><td><?php echo $ref; ?></td>
	<? if ($type==1){?>
	<td align="right"><?php echo $entree; ?></td><td></td>
	<td align="right"><?php echo $e+$stock_ini_exe-$s; ?></td></tr>
			<? }
			else
			{?>
	<td></td><td align="right"><?php echo $sortie; ?></td><td align="right"><?php echo $e+$stock_ini_exe-$s; ?></td></tr>
			<? } 
			
			}?>
			
	<td></td><td></td>
<TD>ENTREE</TD>
<TD>SORTIE</TD>
<TD>STOCK</TD>
<tr>
	<td></td><td></td>
	<td align="right"><?php echo $e; ?></td>
	<td align="right"><?php echo $s; ?></td>
	<td align="right"><?php echo $e+$stock_ini_exe-$s; ?></td>
	

</tr>

</table>	


</body>

</html>