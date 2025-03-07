<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
	$date=$_GET['date'];$vendeur=$_GET['vendeur'];$montant_f=0;$client=$_GET['client'];
	$bon_e = $_GET['bon_e'];$date_a=dateFrToUs($_GET['date']);
	
		
		
include 'class.ezpdf.php';	// inclusion du code de la bibliothèque
$pdf = & new Cezpdf();	// constructeur de la classe EZPDF
$pdf->Cezpdf('a4','portrait');
$pdf->selectFont('Arial.afm');

$pdf->addText(250, 800, 15, 'AVOIR  ');
/*$pdf->addJpegFromFile("logoagence.jpg",10,600);*/
$pdf->line(5, 790, 585, 790);
/*$pdf->line(6, 710, 585, 710);*/


$pdf->addText(10,760,12, ' Numero B.E : '.$bon_e);

$pdf->line(5, 735, 585, 735);

$pdf->addText(10, 720, 12, 'Vendeur : '.$vendeur);
$pdf->addText(250, 700, 12, 'Date : '.$date);
$pdf->addText(250, 720, 12, 'Client : '.$client);

$ligne=660;$total=0;

$pdf->setLineStyle(1);

$pdf->line(5, 692, 585, 692);
$pdf->addText(20, 680, 12, 'Designation Article');
$pdf->addText(250, 680, 12, 'Nbre Pieces');
$pdf->addText(475, 680, 12, 'Prix Unit');
$pdf->addText(540, 680, 12, 'Total');
$pdf->line(5, 675, 585, 675);


	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_avoirs where WHERE date='$date_a' and vendeur = '$vendeur' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
		$total=$total+$m;
		$pdf->addText(8, $ligne, 10, $produit);
	   $pdf->addText(280, $ligne, 10, $users1_["quantite"]);
	   $pdf->addText(480, $ligne, 10, number_format($users1_["prix_unit"],2,',',' '),right);
	   $pdf->addText(540, $ligne, 10, number_format($m,2,',',' '),right);

			$ligne=$ligne-12;
		 }
		
$pdf->ezStream();		// envoi du fichier au navigateur

