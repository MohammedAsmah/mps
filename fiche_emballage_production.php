<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	$valeur=3600;
	set_time_limit($valeur);
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$sql = "TRUNCATE TABLE `fiche_de_stock_matiere_facture`  ;";
			db_query($database_name, $sql);
			
	$user_id = $_REQUEST["user_id"];$achats = $_REQUEST["achats"];$stock_initial = $_REQUEST["stock_initial"];$stock_initial_matiere = $_REQUEST["stock_initial"];
	$matiere = $_REQUEST["matiere"];
	$stock_initial_matiere_pf = $_REQUEST["stock_initial_pf"];
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	


--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<table class="table2"><tr>
<tr><td><?php echo "Matiere : ".$matiere; ?></td>
<tr><td><?php echo "Stock I.M : ".$stock_initial; ?></td>
<tr><td><?php echo "Stock I.P.F : ".$stock_initial_matiere_pf; ?></td>
<tr><td><?php echo "Achats Matiere : ".$achats; ?></td>





<table class="table2"><tr>

<? //stock initial

	


	$ref="Stock initial matiere premiere";$date_debut="2012-01-01";
	$sql  = "INSERT INTO fiche_de_stock_matiere_facture ( produit, date, ref,entree ) VALUES ( ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $date_debut . "', ";
				$sql .= "'" . $ref . "', ";
				$sql .= $stock_initial_matiere . ");";
				db_query($database_name, $sql);
				
	/*$ref="Stock initial produits finis";
	$sql  = "INSERT INTO fiche_de_stock_matiere_facture ( produit, date, ref,entree ) VALUES ( ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $date_debut . "', ";
				$sql .= "'" . $ref . "', ";
				$sql .= $stock_initial_matiere_pf . ");";
				db_query($database_name, $sql);*/
				
	$sql1  = "SELECT * ";$achats=0;$prix_revient=0;$du="2012-01-01";$au="2012-12-31";$mc=$users_["mode_consomme"];$consomme=$users_["consomme"];
	$sql1 .= "FROM achats_mat where produit='$matiere' and date between '$du' and '$au' ORDER BY produit;";
	$users1e = db_query($database_name, $sql1);$prix_revient=0;
	while($users1_e = fetch_array($users1e)) { 
		$achats = $achats+$users1_e["qte"];$date=$users1_e["date"];$qte=$users1_e["qte"];
		$achats_t = $achats_t+$users1_e["qte"];
		$prix_revient=$prix_revient+($users1_e["qte"]*$users1_e["prix_achat"]);
		
		
				$ref=$users1_e["frs"]." / ".$users1_e["ref"];
				$sql  = "INSERT INTO fiche_de_stock_matiere_facture ( produit, date, ref,entree ) VALUES ( ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $ref . "', ";
				$sql .= $qte . ");";
				db_query($database_name, $sql);	
		
	}	

	
	
	$sql1  = "SELECT * ";$production=0;$qte_t=0;
	$sql1 .= "FROM produits where emballage='$matiere' or emballage2='$matiere' or emballage3='$matiere' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
 		$produit = $users1_["produit"];$condit1 = $users1_["condit"];$qte=0;$poids = $users1_["poids"];$montant=0;$condit=0;
		$emballage1 = $users1_["emballage"];$emballage2 = $users1_["emballage2"];$emballage3 = $users1_["emballage3"];$qte_emb=1;
		if ($matiere==$emballage1){$qte_emb=$users1_["qte_emballage"];}
		if ($matiere==$emballage2){$qte_emb=$users1_["qte_emballage2"];}
		if ($matiere==$emballage3){$qte_emb=$users1_["qte_emballage3"];}


	$sql1  = "SELECT * ";$mf="";$du="2012-01-01";$au="2012-12-31";$type="production";
	$sql1 .= "FROM entrees_stock_f where type='$type' and produit='$produit' and (date between '$du' and '$au' ) ORDER BY produit;";
	$users11 = db_query($database_name, $sql1);
	while($users11_ = fetch_array($users11)) { 
				
				$qte=$users11_["depot_a"]*$qte_emb;$qte_p=$users11_["depot_a"];
				$dp=dateUsToFr($users11_["date"]);$date=$users11_["date"];
				$ref="Production $qte_p $produit  ";
				$sql  = "INSERT INTO fiche_de_stock_matiere_facture ( produit, date, ref,sortie ) VALUES ( ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $ref . "', ";
				$sql .= $qte . ");";
				db_query($database_name, $sql);	
			
			
			
		}
	}
	
	
	
	$pp=$matiere;
	$sql  = "SELECT * ";
	$sql .= "FROM fiche_de_stock_matiere_facture where produit='$matiere' ORDER BY date;";
	$users5 = db_query($database_name, $sql);
				
?>
<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Reference";?></th>
	<th><?php echo "Entree";?></th>
	<th><?php echo "Sortie";?></th>
	<th><?php echo "Stock  ";?></th>
</tr>

<? while($users_5 = fetch_array($users5)) { ?><tr>
	
		<td><?php $date= dateUsToFr($users_5["date"]);print("<font size=\"2\" face=\"Arial\" color=\"#000033\">$date </font>");?></td>
		<td><?php $ref= $users_5["ref"];print("<font size=\"2\" face=\"Arial\" color=\"#000033\">$ref </font>");?></td>
		<td><?php $entree= number_format($users_5["entree"],0,',',' ');print("<font size=\"2\" face=\"Arial\" color=\"#000033\">$entree </font>");?></td>
		<td><?php $sortie= number_format($users_5["sortie"],0,',',' ');print("<font size=\"2\" face=\"Arial\" color=\"#000033\">$sortie </font>");?></td>
		<td><?php $solde= $solde+$users_5["entree"]-$users_5["sortie"];print("<font size=\"2\" face=\"Arial\" color=\"#000033\">$solde </font>");?></td>
		
	<? }?>
	
	


</table>


</body>

</html>