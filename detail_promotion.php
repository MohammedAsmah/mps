<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
		$numero=$_GET['commande'];
		$sql  = "SELECT * ";
		$sql .= "FROM commandes WHERE commande = " . $numero . ";";
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



$ligne=800;$total=0;

$pdf->setLineStyle(1);


$pdf->addText(20, 820, 12, 'Designation Article');
$pdf->addText(250, 820, 12, 'Nbre Paquet');
$pdf->addText(330, 820, 12, 'Condit.');
$pdf->addText(385, 820, 12, 'Quantite');
$pdf->addText(475, 820, 12, 'Prix Unit');
$pdf->addText(540, 820, 12, 'Total');


	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=0 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
		$total=$total+$m;
		$pdf->addText(8, $ligne, 10, $produit);
	   $pdf->addText(280, $ligne, 10, $users1_["quantite"].'      X ');
	   $pdf->addText(350, $ligne, 10, $users1_["condit"]);
	   $pdf->addText(390, $ligne, 10, $users1_["condit"]*$users1_["quantite"]);
	   $pdf->addText(480, $ligne, 10, number_format($users1_["prix_unit"],2,',',' '));
	   $pdf->addText(540, $ligne, 10, number_format($m,2,',',' '));

			if ($ligne<80)
			{$pdf->ezNewPage();
			$page=$pdf->ezGetCurrentPageNumber();
			$pdf->addText(520, 830, 10, ' Page  :  '.$page);
			$pdf->addText(420, 700, 12, 'Marrakech le : '.$date);
$pdf->addText(10, 690, 14, 'Client : '.$client);
$pdf->addText(250, 690, 14, 'Destination : '.$ville);

$ligne=800;
$pdf->setLineStyle(1);


$pdf->addText(20, 820, 12, 'Designation Article');
$pdf->addText(250, 820, 12, 'Nbre Paquet');
$pdf->addText(330, 820, 12, 'Condit.');
$pdf->addText(385, 820, 12, 'Quantite');
$pdf->addText(475, 820, 12, 'Prix Unit');
$pdf->addText(540, 820, 12, 'Total');
}else{
			$ligne=$ligne-15;}
		 }
	 
		


/*$pdf->line(5, 753, 585, 753);
$pdf->line(5, 730, 585, 730);
$pdf->line(5, 820, 585, 820);
$pdf->line(5, $ligne, 5, 820);
$pdf->line(240, $ligne, 240, 753);
$pdf->line(330, $ligne, 330, 753);
$pdf->line(370, $ligne, 370, 753);
$pdf->line(460, $ligne, 460, 753);
$pdf->line(530, $ligne, 530, 753);
$pdf->line(585, $ligne, 585, 820);
	
	$pdf->line(5, $ligne, 585, $ligne);*/

if ($sans_remise==1){
					$pdf->addText(450, $ligne-20, 12, 'Net a payer : '. number_format($total,2,',',' '));
 } 
 else {
					$pdf->addText(450, $ligne-20, 12, 'Total Brut: '. number_format($total,2,',',' '));
					$remise_1=0;$remise_2=0;$remise_3=0;
					if ($remise10>0){$remise_1=$total*$remise10/100; 
					$pdf->addText(450, $ligne-40, 12, 'Remise 10% :'. number_format($remise_1,2,',',' '));}
					$pdf->addText(450, $ligne-60, 12, '1er Net :'. number_format($total-$remise_1,2,',',' '));
					if ($remise2>0){
					if ($remise2==2){$remise_2=($total-$remise_1)*$remise2/100;
					$pdf->addText(450, $ligne-80, 12, 'Remise 2% :'. number_format($remise_2,2,',',' '));}
					$pdf->addText(450, $ligne-100, 12, '2eme Net :'. number_format($total-$remise_1-$remise_2,2,',',' '));
					}
					
					if ($remise3>0){
					if ($remise3==2){$r3="Remise 2% :";
					}else{$r3="Remise 3% :";}
					$remise_3=($total-$remise_1-$remise_2)*$remise3/100;
					$pdf->addText(450, $ligne-120, 12, $r3.' '. number_format($remise_3,2,',',' '));
					$pdf->addText(450, $ligne-140, 12, '3eme Net :'. number_format($total-$remise_1-$remise_2-$remise_3,2,',',' '));
					}
					$net=$total-$remise_1-$remise_2-$remise_3;$net=$total-$remise_1-$remise_2-$remise_3;
					$pdf->addText(450, $ligne-160, 12, 'Net :'. number_format($net,2,',',' '));
					
					//////////
						$sql1  = "SELECT * ";$total1=0;$ligne=$ligne-180;
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
	   $pdf->addText(480, $ligne, 10, number_format($users1_["prix_unit"],2,',',' '));
	   $pdf->addText(540, $ligne, 10, number_format($m,2,',',' '));

			$ligne=$ligne-18;
		 }
//////
					$pdf->addText(450, $ligne-40, 12, 'Net a payer :'. number_format($net+$total1,2,',',' '));

}


//////
//////////
						$sql1  = "SELECT * ";$total1=0;$ligne=$ligne-180;
	$sql1 .= "FROM detail_commandes_pro where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;$m=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];
		$sub=$users1_["sub"];
		$total1=$total1+$m;
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];$prix_unit = $user_["prix"];
		$pdf->addText(8, $ligne, 10, $produit);$m=$users1_["quantite"]*$prix_unit*$users1_["condit"];
	   $pdf->addText(280, $ligne, 10, $users1_["quantite"].'      X ');
	   $pdf->addText(350, $ligne, 10, $users1_["condit"]);
	   $pdf->addText(390, $ligne, 10, $users1_["condit"]*$users1_["quantite"]);
	   $pdf->addText(480, $ligne, 10, number_format($prix_unit,2,',',' '));
	   $pdf->addText(540, $ligne, 10, number_format($m,2,',',' '));$mt=$mt+$m;

			$ligne=$ligne-18;
		 }
		 $pdf->addText(540, $ligne, 10, number_format($mt,2,',',' '));
//////

		$pdf->addText(500,10, 10, $evaluation);
		
		
		
		
		
$pdf->ezStream();		// envoi du fichier au navigateur

