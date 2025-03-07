<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
		$id=$_REQUEST["user_id"];

		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM moules WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$code = $user_["code"];
		$designation = $user_["designation"];
		$ordre = $user_["ordre"];
		$couleur = $user_["couleur"];
		$type_injection = $user_["type_injection"];
		$nbre_noyaux = $user_["nbre_noyaux"];
		$longeur_colonne = $user_["longeur_colonne"];
		$epaisseur = $user_["epaisseur"];
		$hauteur = $user_["hauteur"];
		$cales = $user_["cales"];
		$rondelle = $user_["rondelle"];
		$bague = $user_["bague"];
		$anneaux = $user_["anneaux"];
		$chint = $user_["chint"];
		$flexible = $user_["flexible"];
		$faux_plateau = $user_["faux_plateau"];
		$soufflette = $user_["soufflette"];
		$regulateur_t = $user_["regulateur_t"];
		$t_pneumatique = $user_["t_pneumatique"];


	
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
//$pdf->Image('logo1.jpg',10,10,185,35);


//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(15);
$pdf->SetFont('helvetica','',18);



$pdf->SetX(60);$d="Fiche Technique du Moule";
$pdf->Cell(34,6,$d,0,0,'L',1);

$pdf->SetFont('helvetica','',16);
$pdf->SetY(38);
$pdf->SetX(15);$d="Identification du Moule";
$pdf->Cell(34,6,$d,0,0,'L',1);

$pdf->SetFont('helvetica','',14);
$pdf->SetY(45);$pdf->SetX(15);$d="Numero du Moule ";$pdf->Cell(80,8,$d,1,1,'L',1);
$pdf->SetY(45);$pdf->SetX(95);$pdf->Cell(80,8,$code,1,1,'L',1);

$pdf->SetY(53);$pdf->SetX(15);$d="Code emplacement ";$pdf->Cell(80,8,$d,1,1,'L',1);
$pdf->SetY(53);$pdf->SetX(95);$pdf->Cell(80,8,$ordre,1,1,'L',1);

$pdf->SetY(61);$pdf->SetX(15);$d="Nom du Moule ";$pdf->Cell(80,8,$d,1,1,'L',1);
$pdf->SetY(61);$pdf->SetX(95);$pdf->Cell(80,8,$designation,1,1,'L',1);

$pdf->SetY(69);$pdf->SetX(15);$d="Couleur ";$pdf->Cell(80,8,$d,1,1,'L',1);
$pdf->SetY(69);$pdf->SetX(95);$pdf->Cell(80,8,$couleur,1,1,'L',1);

$pdf->SetY(77);$pdf->SetX(15);$d="Types Injection ";$pdf->Cell(80,8,$d,1,1,'L',1);
$pdf->SetY(77);$pdf->SetX(95);$pdf->Cell(80,8,$type_injection,1,1,'L',1);

$pdf->SetY(85);$pdf->SetX(15);$d="Nombre de noyaux hydrolique ";$pdf->Cell(80,8,$d,1,1,'L',1);
$pdf->SetY(85);$pdf->SetX(95);$pdf->Cell(80,8,$nbre_noyaux,1,1,'L',1);


$pdf->SetFont('helvetica','',16);
$pdf->SetY(110);
$pdf->SetX(15);$d="Caracteristiques du Moule";
$pdf->Cell(34,6,$d,0,0,'L',1);

$pdf->SetFont('helvetica','',14);
$pdf->SetY(118);$pdf->SetX(15);$d="Longueur entre colonne ";$pdf->Cell(80,8,$d,1,1,'L',1);
$pdf->SetY(118);$pdf->SetX(95);$pdf->Cell(80,8,$longeur_colonne,1,1,'L',1);

$pdf->SetY(126);$pdf->SetX(15);$d="Epaisseur ";$pdf->Cell(80,8,$d,1,1,'L',1);
$pdf->SetY(126);$pdf->SetX(95);$pdf->Cell(80,8,$epaisseur,1,1,'L',1);

$pdf->SetY(134);$pdf->SetX(15);$d="Hauteur ";$pdf->Cell(80,8,$d,1,1,'L',1);
$pdf->SetY(134);$pdf->SetX(95);$pdf->Cell(80,8,$hauteur,1,1,'L',1);

$pdf->SetFont('helvetica','',16);
$pdf->SetY(160);
$pdf->SetX(15);$d="Pieces necessaires au montage du Moule";
$pdf->Cell(34,6,$d,0,0,'L',1);


$pdf->SetFont('helvetica','',14);
$pdf->SetY(168);$pdf->SetX(15);$d="Cales ";$pdf->Cell(80,8,$d,1,1,'L',1);
$pdf->SetY(168);$pdf->SetX(95);$pdf->Cell(80,8,$cales,1,1,'L',1);

$pdf->SetY(176);$pdf->SetX(15);$d="Rondelle ";$pdf->Cell(80,8,$d,1,1,'L',1);
$pdf->SetY(176);$pdf->SetX(95);$pdf->Cell(80,8,$rondelle,1,1,'L',1);

$pdf->SetY(184);$pdf->SetX(15);$d="Bague de centrage ";$pdf->Cell(80,8,$d,1,1,'L',1);
$pdf->SetY(184);$pdf->SetX(95);$pdf->Cell(80,8,$bague,1,1,'L',1);

$pdf->SetY(192);$pdf->SetX(15);$d="Anneaux de levage ";$pdf->Cell(80,8,$d,1,1,'L',1);
$pdf->SetY(192);$pdf->SetX(95);$pdf->Cell(80,8,$anneaux,1,1,'L',1);

$pdf->SetY(200);$pdf->SetX(15);$d="Chint ";$pdf->Cell(80,8,$d,1,1,'L',1);
$pdf->SetY(200);$pdf->SetX(95);$pdf->Cell(80,8,$chint,1,1,'L',1);

$pdf->SetY(208);$pdf->SetX(15);$d="Flexible hydrolique ";$pdf->Cell(80,8,$d,1,1,'L',1);
$pdf->SetY(208);$pdf->SetX(95);$pdf->Cell(80,8,$flexible,1,1,'L',1);

$pdf->SetY(216);$pdf->SetX(15);$d="Faux Plateau ";$pdf->Cell(80,8,$d,1,1,'L',1);
$pdf->SetY(216);$pdf->SetX(95);$pdf->Cell(80,8,$faux_plateau,1,1,'L',1);

$pdf->SetY(224);$pdf->SetX(15);$d="Soufflette pneumatique ";$pdf->Cell(80,8,$d,1,1,'L',1);
$pdf->SetY(224);$pdf->SetX(95);$pdf->Cell(80,8,$soufflette,1,1,'L',1);

$pdf->SetY(232);$pdf->SetX(15);$d="Regulateur thermique ";$pdf->Cell(80,8,$d,1,1,'L',1);
$pdf->SetY(232);$pdf->SetX(95);$pdf->Cell(80,8,$regulateur_t,1,1,'L',1);

$pdf->SetY(240);$pdf->SetX(15);$d="T. Pneumatique ";$pdf->Cell(80,8,$d,1,1,'L',1);
$pdf->SetY(240);$pdf->SetX(95);$pdf->Cell(80,8,$t_pneumatique,1,1,'L',1);


$pdf->SetFont('arial','',12);
$pdf->SetLineWidth(0.3);

$pdf->Output();		// envoi du fichier au navigateur

