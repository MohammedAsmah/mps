<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
	$numero=$_GET['numero'];
	
	$sql  = "SELECT * ";
		$sql .= "FROM salaries WHERE id = " . $numero . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$ref = $user_["ref"];$service = $user_["service"];$s_h = $user_["s_h"];$t_h_25 = $user_["t_h_25"];$salaire_net = $user_["salaire_net"];
		$employe = $user_["employe"];$statut=$user_["statut"];$poste=$user_["poste"];$mode=$user_["mode"];$poste1=$user_["fonction"];
		$paie=$user_["paie"];$adresse=$user_["adresse"];$cin=$user_["cin"];$cnss=$user_["cnss"];$date_sortie=dateUsToFr($user_["date_sortie"]);
		$date_entree=dateUsToFr($user_["date_entree"]);$situation_famille=$user_["situation_famille"];$nbre_enfants=$user_["nbre_enfants"];
		$conjoint=$user_["conjoint"];$statut_conjoint=$user_["statut_conjoint"];$photo=$user_["photo"];
		$adresse_cr=$user_["adresse_cr"];$date_cr=dateUsToFr($user_["date_cr"]);$statut_cr=$user_["statut_cr"];
		$casier=$user_["casier"];$date_cj=dateUsToFr($user_["date_cj"]);$statut_cj=$user_["statut_cj"];
		$gsm=$user_["gsm"];$domicile=$user_["domicile"];$date_embauche=dateUsToFr($user_["date_embauche"]);
		$nom1=$user_["nom1"];$nom2=$user_["nom2"];$nom3=$user_["nom3"];$date_cin=dateUsToFr($user_["date_cin"]);
		$tel_nom1=$user_["tel_nom1"];$tel_nom2=$user_["tel_nom2"];$tel_nom3=$user_["tel_nom3"];$date_naissance=dateUsToFr($user_["date_naissance"]);
	
	
require('fpdf.php');

//Create new pdf file
$pdf=new FPDF('P','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;

$imagenurl = "./photos/$photo";//$pdf->Cell(0, 0, $pdf->Image($imagenurl, 1,1,40,30), 0, 0, 'R', false,'');

/*$pdf->addJpegFromFile("logo_mps.JPG",40,820);*/
$pdf->Image($imagenurl,160,10,35,35);


//print column titles for the actual page
$y=45;$li=10;
$pdf->SetFillColor(255);
$pdf->SetY($y);
$pdf->SetFont('arial','',14);

$pdf->SetY(20);
$pdf->SetX(10);$d="Matricule : ";
$pdf->Cell(34,6,$d,0,0,'L',1);
$pdf->SetX(60);$pdf->SetFont('arial','B',15);
$pdf->Cell(60,6,$ref,0,0,'L',1);

$pdf->SetY($y+$li);
$pdf->SetX(10);$d="Nom et Prenom : ";
$pdf->Cell(34,6,$d,0,0,'L',1);
$pdf->SetX(60);$pdf->SetFont('arial','B',15);
$pdf->Cell(120,6,$employe,0,0,'L',1);$li=$li+10;

$pdf->SetY($y+$li);$pdf->SetFont('arial','',14);
$pdf->SetX(10);$d="C.I.N : ";
$pdf->Cell(34,6,$d,0,0,'L',1);
$pdf->SetX(60);$pdf->SetFont('arial','B',15);
$pdf->Cell(120,6,$cin.' Valide au '.$date_cin,0,0,'L',1);$li=$li+10;

$pdf->SetY($y+$li);$pdf->SetFont('arial','',14);
$pdf->SetX(10);$d="Addresse : ";
$pdf->Cell(100,6,$d,0,0,'L',1);
$pdf->SetX(60);$pdf->SetFont('arial','B',15);
$pdf->Cell(120,6,$adresse,0,0,'L',1);$li=$li+10;

$pdf->SetY($y+$li);$pdf->SetFont('arial','',14);
$pdf->SetX(10);$d="Situation Famille : ";
$pdf->Cell(100,6,$d,0,0,'L',1);
$pdf->SetX(60);$pdf->SetFont('arial','B',15);
$pdf->Cell(120,6,$situation_famille,0,0,'L',1);$li=$li+10;

$pdf->SetY($y+$li);$pdf->SetFont('arial','',14);
$pdf->SetX(10);$d="Date Naissance : ";
$pdf->Cell(100,6,$d,0,0,'L',1);
$pdf->SetX(60);$pdf->SetFont('arial','B',15);
$pdf->Cell(120,6,$date_naissance,0,0,'L',1);$li=$li+10;


$pdf->SetY($y+$li);$pdf->SetFont('arial','',14);
$pdf->SetX(10);$d="Numero C.N.S.S : ";
$pdf->Cell(100,6,$d,0,0,'L',1);
$pdf->SetX(60);$pdf->SetFont('arial','B',15);
$pdf->Cell(120,6,$cnss,0,0,'L',1);$li=$li+10;

$pdf->SetY($y+$li);$pdf->SetFont('arial','',14);
$pdf->SetX(10);$d="Contrat type : ";
$pdf->Cell(100,6,$d,0,0,'L',1);
$pdf->SetX(60);$pdf->SetFont('arial','B',15);
$pdf->Cell(120,6,$service,0,0,'L',1);$li=$li+10;

$pdf->SetY($y+$li);$pdf->SetFont('arial','',14);
$pdf->SetX(10);$d="Date Entree : ";
$pdf->Cell(100,6,$d,0,0,'L',1);
$pdf->SetX(60);$pdf->SetFont('arial','B',15);
$pdf->Cell(120,6,$date_entree,0,0,'L',1);$li=$li+10;

$pdf->SetY($y+$li);$pdf->SetFont('arial','',14);
$pdf->SetX(10);$d="Date Embauche : ";
$pdf->Cell(100,6,$d,0,0,'L',1);
$pdf->SetX(60);$pdf->SetFont('arial','B',15);
$pdf->Cell(120,6,$date_embauche,0,0,'L',1);$li=$li+10;


$pdf->SetY($y+$li);$pdf->SetFont('arial','',14);
$pdf->SetX(10);$d="Service : ";
$pdf->Cell(100,6,$d,0,0,'L',1);
$pdf->SetX(60);$pdf->SetFont('arial','B',15);
$pdf->Cell(120,6,$poste,0,0,'L',1);$li=$li+10;

$pdf->SetY($y+$li);$pdf->SetFont('arial','',14);
$pdf->SetX(10);$d="Fonction : ";
$pdf->Cell(100,6,$d,0,0,'L',1);
$pdf->SetX(60);$pdf->SetFont('arial','B',15);
$pdf->Cell(120,6,$poste1,0,0,'L',1);$li=$li+10;

$pdf->SetY($y+$li);$pdf->SetFont('arial','',14);
$pdf->SetX(10);$d="Paie : ";
$pdf->Cell(100,6,$d,0,0,'L',1);
$pdf->SetX(60);$pdf->SetFont('arial','B',15);
$pdf->Cell(120,6,$paie,0,0,'L',1);$li=$li+10;

$pdf->SetY($y+$li);$pdf->SetFont('arial','',14);
$pdf->SetX(10);$d="Mode : ";
$pdf->Cell(100,6,$d,0,0,'L',1);
$pdf->SetX(60);$pdf->SetFont('arial','B',15);
$pdf->Cell(120,6,$mode,0,0,'L',1);$li=$li+10;




/*
$pdf->SetY(95);$pdf->SetFont('arial','',14);
$pdf->SetX(10);$d="Addresse : ".$adresse;
$pdf->Cell(100,6,$d,0,0,'L',1);
$pdf->SetX(30);$pdf->SetFont('arial','B',16);
$pdf->Cell(100,6,$adresse,0,0,'L',1);

$pdf->SetY(95);$pdf->SetFont('arial','',14);
$pdf->SetX(10);$d="Addresse : ".$adresse;
$pdf->Cell(100,6,$d,0,0,'L',1);
$pdf->SetX(30);$pdf->SetFont('arial','B',16);
$pdf->Cell(100,6,$adresse,0,0,'L',1);*/



$pdf->SetFont('arial','',12);
$pdf->SetLineWidth(0.3);

/*$pdf->Line(5,85,205,85);
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
$pdf->Line(5,290,205,290);*/



$pdf->Output();		// envoi du fichier au navigateur

