<?php
	require('fpdf.php');
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
		//sub
	
	
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



//Create new pdf file
$pdf=new FPDF('P','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;$ent=25;

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY($ent);
$pdf->SetFont('Times','B',14);


$pdf->SetFillColor(255);
$pdf->SetFont('Times','',14);$pdf->SetY($ent+25);
$pdf->SetX(30);$d=$date1;
$pdf->Cell(25,10,$d,0,0,'L',1);
$pdf->SetFont('','',12);


$pdf->SetY($ent+10);$pdf->SetX(100;$d=$client;
$pdf->Cell(40,10,$d,0,0,'L',1);
$pdf->SetY($ent+20);$pdf->SetX(100);$d=$ville;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY($ent);$pdf->SetX(60);$d="Bon de Livraison Numero :  ".$bl;
$pdf->Cell(30,10,$d,0,0,'L',1);


$ligne=$ent+45;
		$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
		$total=$total+$m;$qte=$users1_["quantite"];$prix_unit=$users1_["prix_unit"];$condit=$users1_["condit"];


	////////////////////////////// NOUVELLE PAGE

	if ($ligne>=200){

	$pdf->SetY($ligne+5);$pdf->SetX(102);
	$pdf->Cell(50,9,'1/2',0,0,'L',1);
	

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;$ent=25;

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY($ent);
$pdf->SetFont('Times','B',14);


$pdf->SetFillColor(255);
$pdf->SetFont('Times','',14);$pdf->SetY($ent+25);
$pdf->SetX(30);$d=$date1;
$pdf->Cell(25,10,$d,0,0,'L',1);
$pdf->SetFont('','',12);

$pdf->SetY($ent+10);$pdf->SetX(100);$d=$client;
$pdf->Cell(40,10,$d,0,0,'L',1);
$pdf->SetY($ent+20);$pdf->SetX(100);$d=$ville;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY($ent);$pdf->SetX(60);$d="Bon de Livraison Numero :  ".$bl;
$pdf->Cell(30,10,$d,0,0,'L',1);

$ligne=$ent+45;

////////////////////////////////////
}




	
		$pdf->SetY($ligne);$pdf->SetX(20);
	$pdf->Cell(50,6,$produit,0,0,'L',1);$pdf->SetX(120);
	$pdf->Cell(10,6,$qte,0,0,'L',1);$pdf->SetX(130);
	$pdf->Cell(10,6,' X ',0,0,'L',1);$pdf->SetX(135);
	$pdf->Cell(20,6,$condit,0,0,'L',1);$pdf->SetX(160);$d=number_format($prix_unit,2,',',' ');
	$pdf->Cell(30,6,$d,0,0,'L',1);$pdf->SetX(185);$d=number_format($condit*$qte,2,',',' ');
	$pdf->Cell(30,6,$d,0,0,'L',1);
		
			$ligne=$ligne+5;
		
  } 
  
 	
$pdf->Output();
