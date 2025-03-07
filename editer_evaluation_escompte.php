<?php
	require "fpdf.php";
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
	$numero=$_GET['numero'];$client=$_GET['client'];$montant_f=0;$bon_sortie = $_GET['bon_sortie'];$destination = $_GET['destination'];$escompte = $_GET['escompte'];
	$id = $numero;
		$sql  = "SELECT * ";
		$sql .= "FROM commandes WHERE commande = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_e"]);
		$client = $user_["client"];$montant_f = $user_["net"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];$secteur = $user_["secteur"];
		$sql1  = "SELECT * ";
		$sql1 .= "FROM clients WHERE client = '$client' ";
		$user1 = db_query($database_name, $sql1); $user_1 = fetch_array($user1);

		$ville = $user_1["ville"];


//Create new pdf file
$pdf=new FPDF('P','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=5;$l=25;

//print column titles for the actual page

$pdf->SetFillColor(255);
$pdf->SetFont('Courier','',6);$pdf->SetY(2);
$pdf->SetX(2);$d="+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ ";
$pdf->Cell(250,6,$d,0,0,'L',1);
$pdf->SetY(80);
$pdf->SetX(2);$d="+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ ";
$pdf->Cell(250,6,$d,0,0,'L',1);
//$pdf->Image('ramadan.jpg',135,7,70,52);
$pdf->SetFillColor(255);
$pdf->SetFont('Courier','B',20);$pdf->SetY(10);
$pdf->SetX(20);$d="Le : ".$date;
$pdf->Cell(25,10,$d,0,0,'L',1);

$pdf->SetY(20);$pdf->SetX(20);$d="Destination : ".$ville;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(30);$pdf->SetX(20);$d="Client : ".$client;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(40);$pdf->SetX(20);$d="Evaluation : ".$evaluation;
$pdf->Cell(30,10,$d,0,0,'L',1);


/////////////////////////////////		 
		
////////////////////////

$x=140;	$h=5;	


//////
					
					$d="Net a payer : ". number_format($montant_f,2,',',' ');
					$pdf->SetY(50);$pdf->SetX(20);
					$pdf->Cell(30,10,$d,0,0,'L',1);


$pdf->Output();		// envoi du fichier au navigateur

