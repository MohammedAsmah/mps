<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
		//sub
	
	
		$montant=$_GET['montant'];$destination=$_GET['destination'];
		$montant=number_format($montant,2,',',' ');$m=0;
		$vendeur=$_GET['vendeur'];$date=$_GET['date'];$date_aff=dateUsToFr($_GET['date']);
			
			$sql = "TRUNCATE TABLE `bon_de_entree_avoirs`  ;";
			db_query($database_name, $sql);
		
		$sql2  = "SELECT * FROM avoirs WHERE date_e='$date' and vendeur='$vendeur' and ev_pre=1 ";
		$user2 = db_query($database_name, $sql2); $i=0;

		while($user2_ = fetch_array($user2)) { 
		$date = dateUsToFr($user2_["date_e"]);$i=$i+1;
		$client = $user2_["client"];$montant_f = $user2_["net"];$numero = $user2_["commande"];$m=$m+$user2_["net"];
		$vendeur = $user2_["vendeur"];$remise10 = $user2_["remise_10"];$remise2 = $user2_["remise_2"];
		$evaluation = $user2_["evaluation"];$sans_remise = $user2_["sans_remise"];$remise3 = $user2_["remise_3"];
	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_avoirs where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$quantite=$users1_["quantite"];$condit=$users1_["condit"];
		$prix_unit=$users1_["prix_unit"];

				$sql  = "INSERT INTO bon_de_entree_avoirs ( produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $prix_unit . "', ";
				$sql .= "'" . $condit . "');";

				db_query($database_name, $sql);
		}
	}

if ($i>1){$client="Divers clients";}
include 'class.ezpdf.php';	// inclusion du code de la bibliothèque
$pdf = & new Cezpdf();	// constructeur de la classe EZPDF
$pdf->Cezpdf('a4','portrait');
$pdf->selectFont('Helvetica.afm');

$pdf->addText(10,800,20, ' Etat Avoirs Journaliere');
$pdf->addText(420, 800, 12, 'Marrakech le : '.$date_aff);
$pdf->addText(10, 785, 14, 'Vendeur : '.$vendeur);
$pdf->addText(350, 780, 14, 'Bon Entree : '.$destination);
$ligne=730;

$pdf->setLineStyle(1);


$pdf->addText(20, 750, 14, 'Designation Article');
$pdf->addText(260, 750, 14, 'Nbre Paquet');
$pdf->addText(350, 750, 14, '');
$pdf->addText(370, 750, 14, 'Quantite');
$pdf->addText(440, 750, 14, 'Prix Unit');
$pdf->addText(530, 750, 14, 'Total');


		$sql  = "SELECT * ";
		$sql .= "FROM produits order by produit ;";
		$user1 = db_query($database_name, $sql);
	while($users11_ = fetch_array($user1)) { 
		$produit=$users11_["produit"];$condit=$users11_["condit"];$qte=0;

	$sql1  = "SELECT * ";
	$sql1 .= "FROM bon_de_entree_avoirs where produit='$produit' ORDER BY produit;";
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
$pdf->line(5, 765, 585, 765);
$pdf->line(5, 745, 585, 745);
$pdf->line(5, 820, 585, 820);
$pdf->line(5, $ligne, 5, 820);
$pdf->line(240, $ligne, 240, 765);
$pdf->line(360, $ligne, 360, 765);
$pdf->line(430, $ligne, 430, 765);
$pdf->line(520, $ligne, 520, 765);
$pdf->line(585, $ligne, 585, 820);
	
	$pdf->line(5, $ligne, 585, $ligne);
$pdf->addText(420, $ligne-15, 14, 'Montant : '.number_format($m,2,',',' '));

$pdf->ezStream();		// envoi du fichier au navigateur
