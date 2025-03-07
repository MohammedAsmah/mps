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

$pdf->addText(10, 690, 12, 'Bon de Livraison Numero : '.$bl);
$pdf->addText(10, 710, 12, 'Marrakech le : '.$date);
$pdf->addText(420, 700, 13, ''.$client);
$pdf->addText(420, 685, 13, ''.$ville);



$ligne=600;$total=0;

$pdf->setLineStyle(1);

$pdf->addText(40, 620, 14, 'Designation Article');
$pdf->addText(325, 620, 14, 'Paquets');

$pdf->addText(385, 620, 14, 'Quantite');
$pdf->addText(475, 620, 14, 'Prix Unit');
$pdf->addText(535, 620, 14, 'Montant');

/*$pdf->line(5, 635, 587, 635);
$pdf->line(5, 610, 587, 610);*/


/*$pdf->line(5, 610, 587, 610);
$pdf->line(5, 610, 587, 610);
$pdf->line(5, 610, 587, 610);
$pdf->line(5, 610, 587, 610);*/


$nul=0;

	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=0 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
		$total=$total+$m;
		
		$pdf->addText(80, $ligne, 10, $produit);
	   $pdf->addText(330, $ligne, 10, $users1_["quantite"].' X '.$users1_["condit"]);
	   
	   $pdf->addText(390, $ligne, 10, $users1_["condit"]*$users1_["quantite"]);
	   $pdf->addText(480, $ligne, 10, number_format($users1_["prix_unit"],2,',',' '));
	   $pdf->addText(540, $ligne, 10, number_format($m,2,',',' '));

			$ligne=$ligne-15;
		 }
		 
		 if ($numero==17376)
{$pdf->addText(10, $ligne-15, 12, 'Suivant Bon de Commande /Petit Bateau Numero 395694');}

	 /*$pdf->line(5, 635, 5, $ligne);
	 $pdf->line(322, 635, 325, $ligne);
	 $pdf->line(382, 635, 382, $ligne);
	 $pdf->line(472, 635, 472, $ligne);
	 $pdf->line(532, 635, 532, $ligne);
	 $pdf->line(587, 635, 587, $ligne);
	 $pdf->line(5, $ligne, 587, $ligne);*/
		$ligne1=$ligne;
	
	/////////////////////////////////		 
		
////////////////////////		

if ($sans_remise==1){
					$pdf->addText(448, $ligne-20, 11, 'Net a payer : '. number_format($total,2,',',' '));
 } 
 else {
					$pdf->addText(448, $ligne-20, 11, 'Total Brut: '. number_format($total,2,',',' '));
					$remise_1=0;$remise_2=0;$remise_3=0;
					if ($remise10>0){$remise_1=$total*$remise10/100; 
					$pdf->addText(448, $ligne-40, 11, 'Remise .'.$remise10.'% :'. number_format($remise_1,2,',',' '));}
					$pdf->addText(448, $ligne-60, 11, '1er Net :'. number_format($total-$remise_1,2,',',' '));
					if ($remise2>0){
					if ($remise2==2){$remise_2=($total-$remise_1)*$remise2/100;
					$pdf->addText(448, $ligne-80, 11, 'Remise '.$remise2.'% :'. number_format($remise_2,2,',',' '));}
					$pdf->addText(448, $ligne-100, 11, '2eme Net :'. number_format($total-$remise_1-$remise_2,2,',',' '));
					}
					
					if ($remise3>0){
					if ($remise3==2){$r3="Remise 2% :";
					}else{$r3="Remise 3% :";}
					$remise_3=($total-$remise_1-$remise_2)*$remise3/100;
					$pdf->addText(448, $ligne-120, 11, $r3.' '. number_format($remise_3,2,',',' '));
					$pdf->addText(448, $ligne-140, 11, '3eme Net :'. number_format($total-$remise_1-$remise_2-$remise_3,2,',',' '));
					}
					
					$net=$total-$remise_1-$remise_2-$remise_3;$net=$total-$remise_1-$remise_2-$remise_3;
					$pdf->addText(448, $ligne-160, 11, 'Net :'. number_format($net,2,',',' '));
					//////////
						$sql1  = "SELECT * ";$total1=0;$ligne=$ligne-180;
	$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=1 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
		$total1=$total1+$m;
		$pdf->addText(8, $ligne, 10, $produit);
	   $pdf->addText(330, $ligne, 10, $users1_["quantite"].' X '.$users1_["condit"]);
	   
	   $pdf->addText(390, $ligne, 10, $users1_["condit"]*$users1_["quantite"]);
	   $pdf->addText(480, $ligne, 10, number_format($users1_["prix_unit"],2,',',' '));
	   $pdf->addText(540, $ligne, 10, number_format($m,2,',',' '));

			$ligne=$ligne-18;
		 }
		 
		
		 
		 
//////
					$pdf->addText(448, $ligne-40, 11, 'Net a payer :'. number_format($net+$total1,2,',',' '));
		 /*$pdf->line(5, $ligne1, 5, $ligne-50);
		 $pdf->line(587, $ligne1, 587, $ligne-50);
		 $pdf->line(5, $ligne-50, 587, $ligne-50);*/
		 

}
	
$pdf->ezStream();		// envoi du fichier au navigateur

