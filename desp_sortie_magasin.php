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


$pdf->addText(10,800,20, ' Bon de Sortie');
$pdf->addText(420, 800, 12, 'Marrakech le : '.$date);
$pdf->addText(10, 780, 14, 'Vendeur : '.$vendeur);
$pdf->addText(370, 780, 14, 'Destination : '.$service);
$pdf->addText(10, 760, 14, 'Client : '.$c);
$pdf->addText(210, 740, 14, 'Numero : ');
$pdf->addText(310, 740, 14, $bon_sortie);
$pdf->addText(420, 740, 17, 'Montant : '.$montant);

$ligne=670;

$pdf->setLineStyle(1);


$pdf->addText(20, 695, 14, 'Designation Article');
$pdf->addText(260, 695, 14, 'Nbre Paquet');
$pdf->addText(350, 695, 14, '');
$pdf->addText(370, 695, 14, 'Quantite');
$pdf->addText(470, 695, 14, 'Observation');



	$sql1  = "SELECT * ";
	$sql1 .= "FROM bon_de_sortie_magasin where id_registre='$id_registre' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
	$produit=$users1_["produit"]; $depot_a=$users1_["depot_a"];$condit=$users1_["condit"];
   $pdf->addText(8, $ligne, 10, $produit);
   $pdf->addText(280, $ligne, 10, $depot_a);
   $pdf->addText(300, $ligne, 10, 'X');
   $pdf->addText(325, $ligne, 10, $condit);
   $pdf->addText(380, $ligne, 10, $depot_a*$condit);
			$ligne=$ligne-15;
		 }
		 
$pdf->line(5, 710, 585, 710);
$pdf->line(5, 690, 585, 690);
$pdf->line(5, 820, 585, 820);
$pdf->line(5, $ligne, 5, 820);
$pdf->line(240, $ligne, 240, 710);
/*$pdf->line(340, $ligne, 340, 710);*/
$pdf->line(360, $ligne, 360, 710);
$pdf->line(455, $ligne, 455, 710);
$pdf->line(585, $ligne, 585, 820);
	
	$pdf->line(5, $ligne, 585, $ligne);
$pdf->addText(10, $ligne-20, 14, 'Magasignier :');
$pdf->addText(280, $ligne-20, 14, 'Controle :');
$pdf->addText(470, $ligne-20, 14, 'Visa :');

$pdf->ezStream();		// envoi du fichier au navigateur
