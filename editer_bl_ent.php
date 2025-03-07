<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
	$numero=$_GET['numero'];$client=$_GET['client'];$montant_f=0;$bl = $_GET['bc'];$destination = "";
	$bc="";
	$id = $numero;
		$sql  = "SELECT * ";
		$sql .= "FROM commandes WHERE commande = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_e"]);
		$client = $user_["client"];$montant_f = $user_["net"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
		$sql1  = "SELECT * ";
		$sql1 .= "FROM clients WHERE client = '$client' ";
		$user1 = db_query($database_name, $sql1); $user_1 = fetch_array($user1);

		$ville = $user_1["ville"];


include 'class.ezpdf.php';	// inclusion du code de la bibliothèque
$pdf = & new Cezpdf();	// constructeur de la classe EZPDF
$pdf->Cezpdf('a4','portrait');
$pdf->selectFont('Helvetica.afm');

$pdf->addText(10, 740, 12, 'Bon de Livraison Numero : '.$bl);
$pdf->addText(90, 690, 12, ''.$date);
$pdf->addText(420, 740, 13, ''.$client);
$pdf->addText(420, 720, 13, ''.$ville);

$pdf->addText(20, 620, 12, 'Ref : V/Bon de commande Numero '.$bc);
$ligne=600;$total=0;

$pdf->setLineStyle(1);

$nul=0;

	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=0 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
		$total=$total+$m;
		
		$pdf->addText(80, $ligne, 10, $produit);
	   $pdf->addText(200, $ligne, 10, $users1_["quantite"].'      X ');
	   $pdf->addText(370, $ligne, 10, $users1_["condit"]);
	   $pdf->addText(390, $ligne, 10, $users1_["condit"]*$users1_["quantite"]);
	   $pdf->addText(480, $ligne, 10, number_format($nul,2,',',' '));
	   $pdf->addText(540, $ligne, 10, number_format($nul,2,',',' '));

			$ligne=$ligne-15;
		 }
					//////////
						$sql1  = "SELECT * ";$total1=0;$ligne=$ligne-18;
	$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=1 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
		$total1=$total1+$m;
		$pdf->addText(8, $ligne, 10, $produit);
	   $pdf->addText(280, $ligne, 10, $users1_["quantite"].'      X ');
	   $pdf->addText(350, $ligne, 10, $users1_["condit"]);
	   $pdf->addText(390, $ligne, 10, $users1_["condit"]*$users1_["quantite"]);
	   $pdf->addText(480, $ligne, 10, number_format($nul,2,',',' '));
	   $pdf->addText(540, $ligne, 10, number_format($nul,2,',',' '));

			$ligne=$ligne-18;
		 }
		 
$pdf->ezStream();		// envoi du fichier au navigateur

