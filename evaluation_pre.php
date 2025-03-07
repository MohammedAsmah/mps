<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
		//sub
	
	
		$id_registre=$_GET['id_registre'];$bon_sortie=$_GET['bon_sortie'];$c=$_GET['observation'];
		$montant=$_GET['montant'];
		$montant=number_format($montant,2,',',' ');$impression=$_GET['impression'];
		$vendeur=$_GET['vendeur'];$date=dateUsToFr($_GET['date']);$service=$_GET['service'];
			
			$sql = "TRUNCATE TABLE `bon_de_sortie`  ;";
			db_query($database_name, $sql);

		$sql  = "SELECT * ";
		$sql .= "FROM commandes WHERE id_registre = " . $id_registre . ";";
		$user = db_query($database_name, $sql); 

		while($user_ = fetch_array($user)) { 
		$date = dateUsToFr($user_["date_e"]);
		$client = $user_["client"];$montant_f = $user_["net"];$numero = $user_["commande"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];

	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$quantite=$users1_["quantite"];$condit=$users1_["condit"];
		$prix_unit=$users1_["prix_unit"];

				$sql  = "INSERT INTO bon_de_sortie ( commande, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $prix_unit . "', ";
				$sql .= "'" . $condit . "');";

				db_query($database_name, $sql);
		}
	}


include 'class.ezpdf.php';	// inclusion du code de la bibliothèque
$pdf = & new Cezpdf();	// constructeur de la classe EZPDF
$pdf->Cezpdf('a4','portrait');
$pdf->selectFont('Helvetica.afm');
$pdf->addText(10,823,8, $impression);
$pdf->addText(10,800,20, ' Evaluation Vendeur');
$pdf->addText(420, 800, 12, 'Marrakech le : '.$date);
$pdf->addText(10, 780, 14, 'Vendeur : '.$vendeur);
$pdf->addText(370, 780, 12, 'Destination : '.$service);
$pdf->addText(210, 740, 14, 'Numero Bon Sortie: ');
$pdf->addText(360, 740, 14, $bon_sortie);

$ligne=670;

$pdf->setLineStyle(1);


$pdf->addText(20, 695, 14, 'Designation Article');
$pdf->addText(260, 695, 14, 'Nbre Paquet');
$pdf->addText(350, 695, 14, '');
$pdf->addText(370, 695, 14, 'Quantite');
$pdf->addText(440, 695, 14, 'Prix Unit');
$pdf->addText(530, 695, 14, 'Total');


		$sql  = "SELECT * ";
		$sql .= "FROM produits order by produit ;";
		$user1 = db_query($database_name, $sql);
	while($users11_ = fetch_array($user1)) { 
		$produit=$users11_["produit"];$condit=$users11_["condit"];$qte=0;

	$sql1  = "SELECT * ";
	$sql1 .= "FROM bon_de_sortie where produit='$produit' and commande='$id_registre' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$qte=$qte+$users1_["quantite"];$prix_unit=$users1_["prix_unit"];
	}	
		if ($qte>0){
   $pdf->addText(8, $ligne, 9.5, $produit);
   $pdf->addText(280, $ligne, 9.5, $qte);
   $pdf->addText(300, $ligne, 9.5, 'X');
   $pdf->addText(325, $ligne, 9.5, $condit);
   $pdf->addText(380, $ligne, 9.5, $qte*$condit);
   $pdf->addText(455, $ligne, 9.5, number_format($prix_unit,2,',',' '));
   $pdf->addText(530, $ligne, 9.5, number_format($qte*$condit*$prix_unit,2,',',' '));

			$ligne=$ligne-14.5;
		 }
  } 
$pdf->line(5, 710, 585, 710);
$pdf->line(5, 690, 585, 690);
$pdf->line(5, 820, 585, 820);
$pdf->line(5, $ligne, 5, 820);
$pdf->line(240, $ligne, 240, 710);
$pdf->line(360, $ligne, 360, 710);
$pdf->line(430, $ligne, 430, 710);
$pdf->line(520, $ligne, 520, 710);
$pdf->line(585, $ligne, 585, 820);
	
	$pdf->line(5, $ligne, 585, $ligne);
$pdf->addText(420, $ligne-14.5, 14, 'Montant : '.$montant);
$pdf->ezStream();		// envoi du fichier au navigateur
