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
		$vendeur=$_GET['vendeur'];$date1=dateUsToFr($_GET['date']);$service=$_GET['service'];
			
			$sql = "TRUNCATE TABLE `bon_de_sortie`  ;";
			db_query($database_name, $sql);
			$sql = "TRUNCATE TABLE `bon_de_sortie_pro`  ;";
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
		

				$sql  = "INSERT INTO bon_de_sortie ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $condit . "');";

				db_query($database_name, $sql);
		}
		
		//sortie promotions
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes_pro where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$quantite=$users1_["quantite"];$condit=$users1_["condit"];
		

				$sql  = "INSERT INTO bon_de_sortie_pro ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $condit . "');";

				db_query($database_name, $sql);
		}
		
		
		
	}


include 'class.ezpdf.php';	// inclusion du code de la bibliothèque
$pdf = & new Cezpdf();	// constructeur de la classe EZPDF
$pdf->Cezpdf('a4','portrait');
/*$pdf->selectFont('Helvetica.afm');*/

$pdf->addText(10,800,20, ' Bon de Sortie');
$pdf->addText(420, 800, 12, 'Marrakech le : '.$date1);
$pdf->addText(10, 780, 12, 'Vendeur : '.$vendeur);
$pdf->addText(340, 780, 12, 'Destination : '.$service);
$pdf->addText(10, 760, 12, 'Client : '.$c);
$pdf->addText(210, 740, 14, 'Numero : ');
$pdf->addText(310, 740, 14, $bon_sortie);
$pdf->addText(420, 740, 12, 'Montant : '.$montant);

$ligne=670;

$pdf->setLineStyle(1);


$pdf->addText(20, 695, 14, 'Designation Article');
$pdf->addText(260, 695, 14, 'Nbre Paquet');
$pdf->addText(350, 695, 14, '');
$pdf->addText(370, 695, 14, 'Quantite');
$pdf->addText(470, 695, 14, 'Observation');


		$sql  = "SELECT * ";
		$sql .= "FROM produits order by produit ;";
		$user1 = db_query($database_name, $sql);
	while($users11_ = fetch_array($user1)) { 
		$produit=$users11_["produit"];$condit=$users11_["condit"];$qte=0;

	$sql1  = "SELECT * ";
	$sql1 .= "FROM bon_de_sortie where produit='$produit' and commande='$id_registre' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$qte=$qte+$users1_["quantite"];
	}	
		if ($qte>0){
   $pdf->addText(8, $ligne, 10, $produit);
   $pdf->addText(280, $ligne, 10, $qte);
   $pdf->addText(300, $ligne, 10, '  X ');
   $pdf->addText(325, $ligne, 10, $condit);
   $pdf->addText(380, $ligne, 10, $qte*$condit);
			if ($ligne<20)
			{
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
			$pdf->ezNewPage();
			$page=$pdf->ezGetCurrentPageNumber();
			$pdf->addText(520, 830, 10, ' Page  :  '.$page);
			$pdf->addText(10,800,20, ' Bon de Sortie');
$pdf->addText(420, 800, 12, 'Marrakech le : '.$date1);
$pdf->addText(10, 780, 12, 'Vendeur : '.$vendeur);
$pdf->addText(340, 780, 12, 'Destination : '.$service);
$pdf->addText(10, 760, 12, 'Client : '.$c);
$pdf->addText(210, 740, 14, 'Numero : ');
$pdf->addText(310, 740, 14, $bon_sortie);
$pdf->addText(420, 740, 12, 'Montant : '.$montant);

$ligne=670;

$pdf->setLineStyle(1);


$pdf->addText(20, 695, 14, 'Designation Article');
$pdf->addText(260, 695, 14, 'Nbre Paquet');
$pdf->addText(350, 695, 14, '');
$pdf->addText(370, 695, 14, 'Quantite');
$pdf->addText(470, 695, 14, 'Observation');
			
			
			
			}else{
			$ligne=$ligne-15;}
		 }
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

//sortie promotions
				$req = mysql_query("SELECT COUNT(*) as cpt FROM bon_de_sortie_pro"); 
				$row = mysql_fetch_array($req); 
				$nb = $row['cpt']; 
				if ($nb>0){

$ligne=$ligne-60;
$pdf->addText(5, $ligne, 14, 'Promotions :');
$ligne=$ligne-20;
		$sql  = "SELECT * ";
		$sql .= "FROM produits order by produit ;";
		$user1 = db_query($database_name, $sql);
	while($users11_ = fetch_array($user1)) { 
		$produit=$users11_["produit"];$condit=$users11_["condit"];$qte1=0;

	$sql1  = "SELECT * ";
	$sql1 .= "FROM bon_de_sortie_pro where produit='$produit' and commande='$id_registre' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$qte1=$qte1+$users1_["quantite"];
	}	
		if ($qte1>0){
   $pdf->addText(8, $ligne, 10, $produit);
   $pdf->addText(280, $ligne, 10, $qte1);
   $pdf->addText(300, $ligne, 10, '  X ');
   $pdf->addText(325, $ligne, 10, $condit);
   $pdf->addText(380, $ligne, 10, $qte1*$condit);
			$ligne=$ligne-15;
		 }
  } 
  
///////////////////////////

	
$pdf->line(5, $ligne, 585, $ligne);
}
$pdf->addText(10, $ligne-20, 14, 'Magasignier :');
$pdf->addText(280, $ligne-20, 14, 'Controle :');
$pdf->addText(470, $ligne-20, 14, 'Visa :');

$pdf->ezStream();		// envoi du fichier au navigateur
