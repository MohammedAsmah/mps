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
		$montant=number_format($montant,2,',',' ');
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

$pdf->addText(10,700,20, ' Evaluation Vendeur');
$pdf->addText(420, 700, 12, 'Marrakech le : '.$date);
$pdf->addText(10, 680, 14, 'Vendeur : '.$vendeur);
$pdf->addText(370, 680, 14, 'Destination : '.$service);
/*$pdf->addText(210, 740, 14, 'Numero Bon Sortie: ');*/
$pdf->addText(360, 740, 14, $bon_sortie);

$ligne=570;

$pdf->setLineStyle(1);


$pdf->addText(20, 595, 14, 'Designation Article');
$pdf->addText(260, 595, 14, 'Nbre Paquet');
$pdf->addText(350, 595, 14, '');
$pdf->addText(370, 595, 14, 'Quantite');
$pdf->addText(440, 595, 14, 'Prix Unit');
$pdf->addText(530, 595, 14, 'Total');


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
   $pdf->addText(8, $ligne, 10, $produit);
   $pdf->addText(280, $ligne, 10, $qte);
   $pdf->addText(300, $ligne, 10, 'X');
   $pdf->addText(325, $ligne, 10, $condit);
   $pdf->addText(380, $ligne, 10, $qte*$condit);
   $pdf->addText(455, $ligne, 10, number_format($prix_unit,2,',',' '));
   $pdf->addText(530, $ligne, 10, number_format($qte*$condit*$prix_unit,2,',',' '));

			$ligne=$ligne-15;
		 }
  } 
$pdf->line(5, 610, 585, 610);
$pdf->line(5, 590, 585, 590);
$pdf->line(5, 720, 585, 720);
$pdf->line(5, $ligne, 5, 720);
$pdf->line(240, $ligne, 240, 610);
$pdf->line(360, $ligne, 360, 610);
$pdf->line(430, $ligne, 430, 610);
$pdf->line(520, $ligne, 520, 610);
$pdf->line(585, $ligne, 585, 720);
	
	$pdf->line(5, $ligne, 585, $ligne);
$pdf->addText(420, $ligne-15, 14, 'Montant : '.$montant);
$pdf->ezStream();		// envoi du fichier au navigateur
