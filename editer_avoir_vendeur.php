<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";require "fpdf.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
	$date=$_GET['date'];$vendeur=$_GET['vendeur'];$montant_f=0;$client=$_GET['client'];
	$bon_e = $_GET['bon_e'];$date_a=dateFrToUs($_GET['date']);


//Create new pdf file
$pdf=new FPDF('P','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;

//print column titles for the actual page
$pdf->SetFillColor(255);$entete=5;
$pdf->SetY($entete);
$pdf->SetFont('arial','B',12);$pdf->SetX(10);$d=" AVOIR  :  ".$vendeur."    Date : ".$date;
$pdf->Cell(70,14,$d,0,0,'L',1);

$pdf->SetFillColor(255);
$pdf->SetFont('Courier','',12);$pdf->SetY(10+$entete);
$pdf->SetX(10);$d="Numero B.E : ".$bon_e;
$pdf->Cell(25,10,$d,0,0,'L',1); 

$pdf->SetY(20+$entete);$pdf->SetX(10);$d="Client : ".$client;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetLineWidth(0.3);
$pdf->Line(3,3,205,3);
$pdf->Line(3,47,205,47);
$pdf->Line(3,60,205,60);
$pdf->Line(3,3,3,60);
$pdf->Line(205,3,205,60);
$pdf->SetFont('arial','',10);
$pdf->SetY(43+$entete);$pdf->SetX(20);$d="  Designation Article  ";
$pdf->Cell(50,10,$d,0,0,'L',1);
$pdf->SetY(43+$entete);$pdf->SetX(124);$d="  Nbre Piece  ";
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetY(43+$entete);$pdf->SetX(155);$d="  Prix Unit.";
$pdf->Cell(15,10,$d,0,0,'L',1);
$pdf->SetY(43+$entete);$pdf->SetX(178);$d="  Total  ";
$pdf->Cell(10,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','',7);
$ligne=47;
	/*$pdf->Line(87,$ligne,87,$ligne+18);*/
	$pdf->Line(117,$ligne,117,$ligne+18);
	$pdf->Line(155,$ligne,155,$ligne+18);
	$pdf->Line(179,$ligne,179,$ligne+18);



$pdf->Line(3,60,3,65);$pdf->Line(205,60,205,65);
	
$ligne=57+$entete;


	$sql1  = "SELECT produit,id,sub,prix_unit,sum(quantite) As quantite,sum(prix_unit*quantite*condit) As m ";$numero=111;
	$sql1 .= "FROM detail_avoirs where date='$date_a' and vendeur='$vendeur' GROUP BY produit ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];
		$sub=$users1_["sub"];$m=$users1_["m"];
		$total=$total+$m;
		$qte=$users1_["quantite"];
		$condit=$users1_["condit"];
		$prix_unit=$users1_["prix_unit"];

		if ($ligne>=250){$pdf->Line(3,$ligne+1,205,$ligne+1);
//Add first page
$pdf->AddPage();

$pdf->Line(3,2,205,2);
$pdf->Line(3,14,205,14);
/*$pdf->Line(3,2,3,14);
$pdf->Line(205,2,205,14);*/
$pdf->SetFont('arial','',10);
$pdf->SetY(3);$pdf->SetX(20);$d="  Designation Article  ";
$pdf->Cell(50,10,$d,0,0,'L',1);
$pdf->SetY(3);$pdf->SetX(124);$d="  Nbre Piece  ";
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetY(3);$pdf->SetX(155);$d="  Prix Unit.";
$pdf->Cell(15,10,$d,0,0,'L',1);
$pdf->SetY(3);$pdf->SetX(178);$d="  Total  ";
$pdf->Cell(10,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','',7);
$ligne=2;
	
	$pdf->Line(117,$ligne,117,$ligne+18);
	$pdf->Line(155,$ligne,155,$ligne+18);
	$pdf->Line(179,$ligne,179,$ligne+18);



$pdf->Line(3,2,3,14);$pdf->Line(205,2,205,14);
	
$ligne=15;

		}
		


		$pdf->SetY($ligne);	
		$pdf->Cell(50,6,$produit,0,0,'L',1);$pdf->SetX(125);
		$pdf->Cell(10,6,$qte,0,0,'L',1);$pdf->SetX(160);
		$d=number_format($prix_unit,2,',',' ');
		$pdf->Cell(30,6,$d,0,0,'L',1);$d=number_format($qte*$condit*$prix_unit,2,',',' ');$pdf->SetX(180);
		$pdf->Cell(30,6,$m,0,0,'L',1);
	   	$pdf->Line(3,$ligne,3,$ligne+4);
		$pdf->Line(117,$ligne,117,$ligne+4);
		$pdf->Line(155,$ligne,155,$ligne+4);
		$pdf->Line(179,$ligne,179,$ligne+4);
		$pdf->Line(205,$ligne,205,$ligne+4);
			$ligne=$ligne+4;$article=$article+1;

		 }
$pdf->Line(3,$ligne+2,205,$ligne+2);
$pdf->Output();	

