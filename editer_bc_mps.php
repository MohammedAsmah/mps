<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
	$numero=$_GET['numero'];$nbc=$numero+219;$date_c=$_GET['date_c'];$anc=$_GET['anc'];

	$numero_c=$nbc."/12";	
		
		$sql  = "SELECT * ";
		$sql .= "FROM commandes_frs WHERE id = " . $numero . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		
		$date = dateUsToFr($user_["date_e"]);$client = $user_["client"];$bb = $user_["bb"];$ville = $user_["ville"];
		$client = $user_["client"];$montant_f = $user_["net"];$destination = $user_["destination"];$fax = $user_["fax"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
		$observation = $user_["observation"];$ttct = $user_["ttc"];
		$sql  = "SELECT * ";
		$sql .= "FROM rs_data_fournisseurs where last_name='$client';";
		$user1 = db_query($database_name, $sql); $user_1 = fetch_array($user1);
		$fax = $user_1["fax"];$ville = $user_1["ville"];


include 'class.ezpdf.php';	// inclusion du code de la bibliothèque
$pdf = & new Cezpdf();	// constructeur de la classe EZPDF
$pdf->Cezpdf('a4','portrait');
$pdf->selectFont('Arial.afm');

/*$pdf->addJpegFromFile("logo_mps.JPG",40,820);*/
$pdf->addJpegFromFile('logo1.jpg',10,$pdf->y-120,580,0);

/*$pdf->addText(290, 820, 16, 'Moulage  Plastiques  du  Sud  ');
$pdf->addText(290, 800, 9, '62.Nouvelle Zone industrielle Sidi Ghanem B.P.N 4109 Hay Hassani Marrakech  ');
$pdf->addText(400, 790, 9, 'Tel : 044 33 51 15 / 17 - Fax : 044 33 51 09');
$pdf->addText(410, 780, 9, 'E.mail : mps-contact@menara.ma');

/*$pdf->line(5, 770, 585, 770);*/
/*$pdf->line(6, 710, 585, 710);*/


$pdf->addText(25, 660, 14, 'LE : '.$date);
$pdf->addText(25, 640, 14, 'A : '.$client);
$pdf->addText(30, 620, 12, '    '.$ville);
$pdf->addText(460, 620, 14, 'Numero : '.$numero_c);
$pdf->addText(340, 660, 24, 'BON DE ');$pdf->addText(310, 630, 24, 'COMMANDE ');


$ligne=570;$total=0;

$pdf->setLineStyle(1);

$pdf->line(5, 608, 585, 608);
$pdf->addText(20, 595, 12, 'Quantite');
$pdf->addText(80, 595, 12, '      Designation Article');
$pdf->addText(475, 595, 12, '  P U ');
$pdf->addText(522, 595, 12, 'MONTANT');
$pdf->line(5, 590, 585, 590);

$pdf->line(5, 608, 5, 300);
$pdf->line(75, 608, 75, 300);
$pdf->line(465, 608, 465, 300);
$pdf->line(520, 608, 520, 300);
$pdf->line(585, 608, 585, 300);
/*$pdf->line(5, 200, 585, 200);*/


	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes_frs where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	
	
	$non_favoris=0;$ht=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"];
		$sub=$users1_["sub"];$reference=$users1_["reference"];$ht=$ht+$m;
		$total=$total+$m;
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes where produit='$produit' ORDER BY produit;";
		$user1 = db_query($database_name, $sql); $user_1 = fetch_array($user1);

		$unite=$user_1["unite"];/*$q=number_format($users1_["quantite"],3,',',' ');*/
		/*$pi = $q;
 		$in = intval($pi);
		$virgule = $pi - $in;
		if ($virgule>0){$q=number_format($users1_["quantite"],3,',',' ');}else{$q=number_format($users1_["quantite"],0,',',' ');}
		*/
		
		
		$qte=$users1_["quantite"];
		
	
		/*if ($numero_c==181){$reference2="DIAMETRE ARBE 42mm marque EUROTEMCO";
		}else{$reference2="";}*/
		$ref="UN ANNEAU AU SOMMET ET 4 CROCHETS A OEIL AVEC LINGUET DE SECURITE";
		$pdf->addText(15, $ligne, 10, $qte);
		$pdf->addText(80, $ligne, 10, $produit);
		$pdf->addText(90, $ligne-12, 10, $reference);
		/*$pdf->addText(90, $ligne, 10, $ref);*/
	    if ($users1_["prix_unit"]==0){$pu="";}else{$pu=number_format($users1_["prix_unit"],2,',',' ');}
		if ($date=="07/01/2012" and $client=="YOMAR"){$pu="15.70";}
		$pdf->addText(482, $ligne, 10, $pu,right);
	    if ($m==0){$mt="";}else{$mt=number_format($m,2,',',' ');}if ($date=="07/01/2012" and $client=="YOMAR"){$mt="392 500.00";}
	   $pdf->addText(530, $ligne, 10, $mt,right);

			$ligne=$ligne-30;
		 }
		 ////////////////////////
		 if ($numero_c==574){ $pdf->addText(80, $ligne-10, 10, $ref);$ligne=$ligne-50;}ELSE{
		 
		 $ligne=$ligne-35;}
		 /*$ligne=$ligne-35;*/
		
		$obs1="A L ATTENTION DE MME AMAL : ";
		$obs3="CE BON DE COMMANDE ANNULE ET REMPLACE LE BC Numero 567/12 .";
		$obs2="CETTE COMMANDE EST LIVRABLE A LA SUITE DE NOTRE DEMANDE";
		
		 if ($numero_c==577){$pdf->addText(80, $ligne-15, 8, $obs1);
		 $pdf->addText(80, $ligne-25, 8, $obs3);
		 $pdf->addText(80, $ligne-35, 8, $obs2);
		 
		 }
		 $pdf->addText(80, $ligne-15, 10, $observation);
		 
		 $htt=number_format($ht,2,',',' ');
		 $tva=number_format($ht*0.20,2,',',' ');
		 $ttc=number_format($ht*1.20,2,',',' ');
		 
		 
$pdf->line(5, 300, 585, 300);
$pdf->line(465, 300, 465, 235);
$pdf->line(465, 235, 585, 235);
$pdf->line(585, 300, 585, 235);
if ($ht<>0){if ($ttct==1){$pdf->addText(480, 240, 10, 'Total TTC : '.$htt,'right');}else{
$pdf->addText(480, 280, 10, 'Total HT  : '.$htt,'right');
$pdf->addText(480, 260, 10, 'TVA 20%   : '.$tva,'right');		 
$pdf->addText(480, 240, 10, 'Total TTC : '.$ttc,'right');}
}
else
{$pdf->addText(480, 280, 10, 'Total HT  : ','right');
$pdf->addText(480, 260, 10, 'TVA 20%   : ','right');		 
$pdf->addText(480, 240, 10, 'Total TTC : ','right');
}


		 
$pdf->line(5, 25, 585, 25);
$pdf->addText(5, 10, 8, 'Fax : '.$fax);
$pdf->addText(450, 10, 8, 'B N : '.$bb);

		/*$pdf->addText(500,10, 10, $evaluation);*/
$pdf->ezStream();		// envoi du fichier au navigateur

