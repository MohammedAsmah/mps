<?php
	require('fpdf.php');
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
		//sub
	
	
		$date1=dateUsToFr($_GET['date']);$date=$_GET['date'];
			
			

//Create new pdf file
$pdf=new FPDF('P','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;$hauteur=4.5;

//print column titles for the actual page
$pdf->SetFillColor(195);
$pdf->SetY(5);
$pdf->SetFont('arial','B',18);
$pdf->Cell(60,14,'   RECAP',0,0,'L',1);

$pdf->SetFillColor(255);
$pdf->SetFont('arial','B',14);
$pdf->SetX(130);$d=" le : ".$date1;
$pdf->Cell(25,10,$d,0,0,'L',1);


$pdf->SetLineWidth(0.3);
$pdf->Line(3,3,205,3);
$pdf->Line(3,47,205,47);
$pdf->Line(3,60,205,60);
$pdf->Line(3,3,3,60);
$pdf->Line(205,3,205,60);


$pdf->SetY(48);$pdf->SetX(7);$d="  Designation Article  ";
$pdf->Cell(100,9,$d,0,0,'L',1);
$pdf->SetY(48);$pdf->SetX(110);$d=" MPS  ";
$pdf->Cell(30,9,$d,0,0,'L',1);
$pdf->SetY(48);$pdf->SetX(142);$d=" J.P  ";
$pdf->Cell(30,9,$d,0,0,'L',1);
$pdf->SetY(48);$pdf->SetX(174);$d=" TOTAL  ";
$pdf->Cell(30,9,$d,0,0,'L',1);

$ligne=47;
$pdf->Line(108,$ligne,108,$ligne+18);
$pdf->Line(139,$ligne,139,$ligne+18);
$pdf->Line(170,$ligne,170,$ligne+18);
	


$ligne=65;
$pdf->Line(3,60,3,65);
$pdf->Line(205,60,205,65);
	
$pdf->SetFont('arial','',10);
	
		$sql  = "SELECT produit,condit,sum(depot_a) as qte_a,sum(depot_b) as qte_b ";
		$sql .= "FROM bon_de_sortie_magasin where date='$date' GROUP BY produit;";
		$user1 = db_query($database_name, $sql);
		
		$total=0;
		
		
	while($users11_ = fetch_array($user1)) { 
		$produit=$users11_["produit"];$condit=$users11_["condit"];$qte_a=$users11_["qte_a"];$qte_b=$users11_["qte_b"];
		
		$sql  = "SELECT * ";
		$sql .= "FROM produits where produit='$produit' order BY produit;";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		
				
		if ($ligne<=240){
		
		$pdf->SetY($ligne);$pdf->SetX(5);
	$pdf->Cell(100,6,$produit,0,0,'L',1);$pdf->SetX(109);
	$pdf->Cell(30,6,$qte_a,0,0,'L',1);$pdf->SetX(141);
	$pdf->Cell(30,6,$qte_b,0,0,'L',1);$pdf->SetX(173);
	$pdf->Cell(30,6,$qte_a+$qte_b,0,0,'L',1);
		
	$pdf->Line(3,$ligne,3,$ligne+$hauteur);
	$pdf->Line(108,$ligne,108,$ligne+$hauteur);
	$pdf->Line(139,$ligne,139,$ligne+$hauteur);
	$pdf->Line(170,$ligne,170,$ligne+$hauteur);
	$pdf->Line(205,$ligne,205,$ligne+$hauteur);
	
		
			$ligne=$ligne+$hauteur;
			
		
		 }
		 
		 else{
		$pdf->Line(3,$ligne,3,$ligne+$hauteur);
	$pdf->Line(108,$ligne,108,$ligne+$hauteur);
	$pdf->Line(139,$ligne,139,$ligne+$hauteur);
	$pdf->Line(170,$ligne,170,$ligne+$hauteur);
	$pdf->Line(205,$ligne,205,$ligne+$hauteur);
	
		 $pdf->line(3, $ligne+$hauteur, 205, $ligne+$hauteur);

$pdf->SetY($ligne+10);$pdf->SetX(10);
	$pdf->Cell(50,9,'Magasinier',0,0,'L',1);
$pdf->SetX(90);
	$pdf->Cell(50,9,'Controle',0,0,'L',1);
$pdf->SetX(160);
	$pdf->Cell(50,9,'Visa',0,0,'L',1);
	
		 //nouvelle page
		 //Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;$hauteur=4.5;

//print column titles for the actual page
$pdf->SetFillColor(195);
$pdf->SetY(5);
$pdf->SetFont('arial','B',18);
$pdf->Cell(60,14,'   RECAP',0,0,'L',1);

$pdf->SetFillColor(255);
$pdf->SetFont('arial','B',14);
$pdf->SetX(130);$d=" le : ".$date1;
$pdf->Cell(25,10,$d,0,0,'L',1);



$pdf->SetLineWidth(0.3);
$pdf->Line(3,3,205,3);
$pdf->Line(3,47,205,47);
$pdf->Line(3,60,205,60);
$pdf->Line(3,3,3,60);
$pdf->Line(205,3,205,60);


$pdf->SetY(48);$pdf->SetX(7);$d="  Designation Article  ";
$pdf->Cell(100,9,$d,0,0,'L',1);
$pdf->SetY(48);$pdf->SetX(110);$d=" MPS  ";
$pdf->Cell(30,9,$d,0,0,'L',1);
$pdf->SetY(48);$pdf->SetX(142);$d=" J.P  ";
$pdf->Cell(30,9,$d,0,0,'L',1);
$pdf->SetY(48);$pdf->SetX(174);$d=" TOTAL  ";
$pdf->Cell(30,9,$d,0,0,'L',1);

$ligne=47;
$pdf->Line(108,$ligne,108,$ligne+18);
$pdf->Line(139,$ligne,139,$ligne+18);
$pdf->Line(170,$ligne,170,$ligne+18);
	


$ligne=65;
$pdf->Line(3,60,3,65);
$pdf->Line(205,60,205,65);
	
$pdf->SetFont('arial','',10);

	}
	
	}
	
	// envoi du fichier au navigateur */
//Create file
$pdf->Output();
