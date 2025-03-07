<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
	$vendeur=$_GET['vendeur'];$montant_f=0;$numero=$_GET['numero'];
	// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM avoirs_vendeurs WHERE id = " . $numero . ";";
		$user = db_query($database_name, $sql); $users_ = fetch_array($user);

		$vendeur=$users_["vendeur"];$be=$users_["be"];
		$date=dateUsToFr($users_["date_e"]);


include 'class.ezpdf.php';

	// inclusion du code de la bibliothèque
$pdf = & new Cezpdf();	// constructeur de la classe EZPDF
$pdf->Cezpdf('a4','portrait');
$pdf->selectFont('Arial.afm');

$page=$pdf->ezGetCurrentPageNumber();
$pdf->addText(520, 830, 10, ' Page  :  '.$page);
$pdf->addText(150, 800, 15, ' BON ENTREE  :  '.$vendeur.'    Date : '.$date);
$pdf->line(5, 790, 585, 790);
$pdf->addText(10,760,12, ' Numero B.E : '.$be);

$pdf->line(5, 735, 585, 735);
$ligne=700;$total=0;
$pdf->setLineStyle(1);

$pdf->line(5, 730, 585, 730);
$pdf->addText(20, 720, 12, 'Designation Article');
//$pdf->line(245, 730, 245, 730);
$pdf->addText(250, 720, 12, 'Nbre Pieces');
//$pdf->line(470, 730, 470, 730);
$pdf->addText(475, 720, 12, 'Prix Unit');
//$pdf->line(5, 730, 585, 730);
$pdf->addText(540, 720, 12, 'Total');
$pdf->line(5, 710, 585, 710);


	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_avoirs_vendeurs where commande='$numero' ORDER BY id;";
	$users1 = db_query($database_name, $sql1);$articles=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];
		
		$sub=$users1_["sub"];
		
		$pdf->addText(8, $ligne, 10, $produit);
		$pdf->addText(280, $ligne, 10, $users1_["quantite"]);
		$pdf->addText(480, $ligne, 10, number_format($users1_["prix_unit"],2,',',' '),right);
		$pdf->addText(540, $ligne, 10, number_format($users1_["quantite"]*$users1_["prix_unit"],2,',',' '),right);
		$ligne1=$ligne-2;$articles=$articles+1;
		/*$pdf->line(5, $ligne1, 585, $ligne1);*/
			if ($ligne<20)
			{$pdf->ezNewPage();
			$page=$pdf->ezGetCurrentPageNumber();
			$pdf->addText(520, 830, 10, ' Page  :  '.$page);
			$pdf->addText(150, 800, 15, ' BON ENTREE  :  '.$vendeur.'    Date : '.$date);
$pdf->line(5, 790, 585, 790);
$pdf->addText(10,760,12, ' Numero B.E : '.$be);

$pdf->line(5, 735, 585, 735);
$ligne=700;$total=0;
$pdf->setLineStyle(1);

$pdf->line(5, 730, 585, 730);
$pdf->addText(20, 720, 12, 'Designation Article');
//$pdf->line(245, 730, 245, 730);
$pdf->addText(250, 720, 12, 'Nbre Pieces');
//$pdf->line(470, 730, 470, 730);
$pdf->addText(475, 720, 12, 'Prix Unit');
//$pdf->line(5, 730, 585, 730);
$pdf->addText(540, 720, 12, 'Total');
$pdf->line(5, 710, 585, 710);

}else{$ligne=$ligne-12;}

		 }
$pdf->addText(20, 10, 12, 'Nombre Articles : '.$articles);
$pdf->ezStream();

