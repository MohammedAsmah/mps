<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
	$numero=$_GET['numero'];$nbc=$numero+219;$date_c=$_GET['date_c'];$anc=$_GET['anc'];

		
		
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
		if ($user_["date_e"]<="2012-12-31" and $user_["date_e"]>="2012-01-01"){$annee="/12";}
		if ($user_["date_e"]<="2013-12-31" and $user_["date_e"]>="2013-01-01"){$annee="/13";}
		if ($user_["date_e"]<="2014-12-31" and $user_["date_e"]>="2014-01-01"){$annee="/14";}
		if ($user_["date_e"]<="2015-12-31" and $user_["date_e"]>="2015-01-01"){$annee="/15";}
		if ($user_["date_e"]<="2016-12-31" and $user_["date_e"]>="2016-01-01"){$annee="/16";}
		if ($user_["date_e"]<="2017-12-31" and $user_["date_e"]>="2017-01-01"){$annee="/17";}
		
		$numero_c=$nbc.$annee;


	
require('fpdf.php');

//Create new pdf file
$pdf=new FPDF('P','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=5;$l=25;



/*$pdf->addJpegFromFile("logo_mps.JPG",40,820);*/
$pdf->Image('logo1.jpg',10,10,185,35);


//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(55);
$pdf->SetFont('arial','',14);

$pdf->SetX(15);$d="LE : ".$date;
$pdf->Cell(34,6,$d,0,0,'L',1);
$pdf->SetY(65);
$pdf->SetX(15);$d="A : ".$client;
$pdf->Cell(34,6,$d,0,0,'L',1);
$pdf->SetY(75);
$pdf->SetX(15);$d=$ville;
$pdf->Cell(34,6,$d,0,0,'L',1);

$pdf->SetY(75);
$pdf->SetX(155);$d="Numero : ".$numero_c;
$pdf->Cell(34,6,$d,0,0,'L',1);
$pdf->SetFont('arial','B',22);
$pdf->SetY(45);
$pdf->SetX(135);$d="BON DE ";
$pdf->Cell(34,6,$d,0,0,'L',1);
$pdf->SetY(55);
$pdf->SetX(130);$d="COMMANDE ";
$pdf->Cell(34,6,$d,0,0,'L',1);

$pdf->SetFont('arial','',12);
$pdf->SetLineWidth(0.3);

$pdf->Line(5,85,205,85);
$pdf->Line(5,95,205,95);
$pdf->Line(5,85,5,95);
$pdf->Line(205,85,205,95);

$pdf->Line(5,85,5,205);
$pdf->Line(35,85,35,205);
$pdf->Line(135,85,135,205);
$pdf->Line(165,85,165,205);
$pdf->Line(205,85,205,205);
$pdf->Line(5,205,205,205);

$pdf->Line(165,200,165,240);
$pdf->Line(205,200,205,240);
$pdf->Line(165,240,205,240);
$pdf->Line(5,284,205,284);

$pdf->SetY(88);
$pdf->SetX(6);$d="QUANTITE";
$pdf->Cell(15,6,$d,0,0,'L',1);

$pdf->SetY(88);
$pdf->SetX(50);$d="DESIGNATION ARTICLE ";
$pdf->Cell(34,6,$d,0,0,'L',1);

$pdf->SetY(88);
$pdf->SetX(140);$d="P U";
$pdf->Cell(10,6,$d,0,0,'L',1);

$pdf->SetY(88);
$pdf->SetX(168);$d="MONTANT";
$pdf->Cell(15,6,$d,0,0,'L',1);
$ligne=98;$total=0;

$pdf->SetFont('arial','',9);
	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes_frs where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	
	
	$non_favoris=0;$ht=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"];
		$sub=$users1_["sub"];$reference=$users1_["reference"];$ht=$ht+$m;$reference_l1=$users1_["reference_l1"];$reference_l2=$users1_["reference_l2"];
		$total=$total+$m;$prix_ref=$users1_["prix_ref"];if ($users1_["prix_unit"]==0){$prix=$prix_ref;}else{$prix=number_format($users1_["prix_unit"],2,',',' ');}
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes where produit='$produit' ORDER BY produit;";
		$user1 = db_query($database_name, $sql); $user_1 = fetch_array($user1);

		$unite=$user_1["unite"];
		
		
		
		$qte=$users1_["quantite"];
		
	
		
		$ref="UN ANNEAU AU SOMMET ET 4 CROCHETS A OEIL AVEC LINGUET DE SECURITE";
		/*
		$pdf->addText(15, $ligne, 10, $qte);
		$pdf->addText(80, $ligne, 10, $produit);
		$pdf->addText(90, $ligne-12, 10, $reference);*/
		$pdf->SetY($ligne);
		$pdf->SetX(7);
		$pdf->Cell(15,6,$qte,0,0,'L',1);
		$pdf->SetX(37);
		$pdf->Cell(50,6,$produit,0,0,'L',1);
		if ($reference<>""){
		$pdf->SetY($ligne+5);
		$pdf->SetX(47);
		$pdf->Cell(30,6,$reference,0,0,'L',1);}
		
		if ($reference_l1<>""){$ligne=$ligne+5;
		$pdf->SetY($ligne+5);
		$pdf->SetX(47);
		$pdf->Cell(30,6,$reference_l1,0,0,'L',1);}
		
		if ($reference_l2<>""){$ligne=$ligne+5;
		$pdf->SetY($ligne+5);
		$pdf->SetX(47);
		$pdf->Cell(30,6,$reference_l2,0,0,'L',1);}
		
	    if ($users1_["prix_unit"]==0){$pu="";}else{$pu=number_format($users1_["prix_unit"],2,',',' ');}
		
		/*$pdf->addText(482, $ligne, 10, $pu,right);*/
		$pdf->SetY($ligne);
		$pdf->SetX(140);
		$pdf->Cell(20,6,$prix,0,0,'L',1);
	    if ($m==0){$mt="";}else{$mt=number_format($m,2,',',' ');}
		
	   /*$pdf->addText(530, $ligne, 10, $mt,right);*/
		$pdf->SetY($ligne);
		$pdf->SetX(168);
		$pdf->Cell(30,6,$mt,0,0,'L',1);
			$ligne=$ligne+9;
		 }
		
						
		$pdf->SetY($ligne+20);
		$pdf->SetX(37);
		$pdf->Cell(50,6,$observation,0,0,'L',1);
		
		 
		 $htt=number_format($ht,2,',',' ');
		 $tva=number_format($ht*0.20,2,',',' ');
		 $ttc=number_format($ht*1.20,2,',',' ');
		 
$pdf->SetFont('arial','',11);		 

if ($ht<>0){if ($ttct==1)
{
		$pdf->SetY(210);
		$pdf->SetX(165);$d="Total TTC : ".$htt;
		$pdf->Cell(30,6,$d,0,0,'L',1);
/*$pdf->addText(480, 240, 10, 'Total TTC : '.$htt,'right');*/

}

else{
/*$pdf->addText(480, 280, 10, 'Total HT  : '.$htt,'right');
$pdf->addText(480, 260, 10, 'TVA 20%   : '.$tva,'right');		 
$pdf->addText(480, 240, 10, 'Total TTC : '.$ttc,'right');*/
		
		$pdf->SetY(210);
		$pdf->SetX(166);$d="Total HT : ".$htt;
		$pdf->Cell(30,5,$d,0,0,'L',1);
		
		$pdf->SetY(220);
		$pdf->SetX(166);$d="TVA 20% : ".$tva;
		$pdf->Cell(30,5,$d,0,0,'L',1);
		
		$pdf->SetY(230);
		$pdf->SetX(165);$d="Total TTC : ".$ttc;
		$pdf->Cell(30,5,$d,0,0,'L',1);

}
}
else
{/*$pdf->addText(480, 280, 10, 'Total HT  : ','right');
$pdf->addText(480, 260, 10, 'TVA 20%   : ','right');		 
$pdf->addText(480, 240, 10, 'Total TTC : ','right');*/
		$pdf->SetY(210);
		$pdf->SetX(166);$d="Total HT : ";
		$pdf->Cell(30,6,$d,0,0,'L',1);
		
		$pdf->SetY(220);
		$pdf->SetX(166);$d="TVA 20% : ";
		$pdf->Cell(30,6,$d,0,0,'L',1);
		
		$pdf->SetY(230);
		$pdf->SetX(165);$d="Total TTC : ";
		$pdf->Cell(30,6,$d,0,0,'L',1);
}


		 
/*
$pdf->addText(5, 10, 8, 'Fax : '.$fax);
$pdf->addText(450, 10, 8, 'B N : '.$bb);*/
$pdf->SetY(285);
		$pdf->SetX(10);$d="RC : 10499 - IF : 06580058 - CNSS : 2671164 - TVA : 2244001 - ICE : 001525412000076 - T.P : 64090420 ";
		$pdf->Cell(50,6,$d,0,0,'L',1);
		/*$pdf->SetX(135);$d="B N  : ".$bb;
		$pdf->Cell(50,6,$d,0,0,'L',1);*/

		/*$pdf->addText(500,10, 10, $evaluation);*/
$pdf->Output();		// envoi du fichier au navigateur

