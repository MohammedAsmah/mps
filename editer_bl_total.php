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
		$client = $user_["client"];$montant_f = $user_["net"];$votre_commande = $user_["votre_commande"];
		$notre_bl = $user_["notre_bl"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
		$sql1  = "SELECT * ";
		$sql1 .= "FROM clients WHERE client = '$client' ";
		$user1 = db_query($database_name, $sql1); $user_1 = fetch_array($user1);

		$ville = $user_1["ville"];
		$page=1;



//Create new pdf file
$pdf=new FPDF('P','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;$ent=60;

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY($ent);
$pdf->SetFont('Courier','B',14);


$pdf->SetFillColor(255);
$pdf->SetFont('Courier','',14);$pdf->SetY($ent+25);
$pdf->SetX(30);$d=$date1;
$pdf->Cell(25,10,$d,0,0,'L',1);
$pdf->SetFont('','',12);


$pdf->SetY($ent+10);$pdf->SetX(130);$d=$client;
$pdf->Cell(40,10,$d,0,0,'L',1);
$pdf->SetY($ent+20);$pdf->SetX(130);$d=$ville;
$pdf->Cell(40,10,$d,0,0,'L',1);
$pdf->SetY($ent+20);$pdf->SetX(130);$d=$ville;
$pdf->Cell(40,10,$d,0,0,'L',1);
$pdf->SetY($ent+10);$pdf->SetX(10);$d="Marrakech le : ".$date;
$pdf->Cell(40,10,$d,0,0,'L',1);
$pdf->SetY($ent+20);$pdf->SetX(10);$d="V/Bon de commande : ".$votre_commande;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY($ent);$pdf->SetX(60);$d="Bon de Livraison Numero :  ".$notre_bl;
$pdf->Cell(30,10,$d,0,0,'L',1);

	$pdf->SetFont('Courier','B',8);
	$pdf->SetY($ent+35);$pdf->SetX(5);
	$pdf->Cell(35,6,'BARCODE',1,0,'C',1);$pdf->SetX(40);	
	$pdf->Cell(90,6,'ARTICLE',1,0,'C',1);$pdf->SetX(130);
	$pdf->Cell(20,6,'QUANT EN UC',1,0,'C',1);$pdf->SetX(150);
	$pdf->Cell(10,6,' X ',1,0,'C',1);$pdf->SetX(160);
	$pdf->Cell(20,6,'UVC/UC',1,0,'C',1);
	$pdf->SetX(180);
	$pdf->Cell(20,6,'QUANTITE',1,0,'C',1);
	


$ligne=$ent+45;
		$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes where commande='$numero' ORDER BY id;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
		$total=$total+$m;$qte=$users1_["quantite"];$prix_unit=$users1_["prix_unit"];$condit=$users1_["condit"];
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$pp = $user_["produit"];$couleurs = $user_["couleurs"];$designation=$user_["designation"];$asswak=$user_["asswak"];
		$barecode_piece=$user_["barecode_piece"];$designation_client=$user_["designation_client"];
		
		


	////////////////////////////// NOUVELLE PAGE

	if ($ligne>=265){$page=$page+1;

	$pdf->SetY($ligne+5);$pdf->SetX(180);
	$pdf->Cell(50,9,'1/2',0,0,'L',1);
	/*$pdf->SetY(195);$pdf->SetX(102);
	$pdf->Cell(50,9,'XXXXXXXXXXXXX 19 000 000.00 DHS',0,0,'L',1);*/

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;$ent=60;

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY($ent);
$pdf->SetFont('Courier','B',10);


$pdf->SetFillColor(255);
$pdf->SetFont('Courier','',10);$pdf->SetY($ent+25);
$pdf->SetX(30);$d=$date1;
$pdf->Cell(25,10,$d,0,0,'L',1);
$pdf->SetFont('','',12);

$pdf->SetY($ent+10);$pdf->SetX(100);$d=$client;
$pdf->Cell(40,10,$d,0,0,'L',1);
$pdf->SetY($ent+20);$pdf->SetX(100);$d=$ville;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY($ent);$pdf->SetX(60);$d="Bon de Livraison Numero :  ".$notre_bl;
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetY($ent+10);$pdf->SetX(10);$d="Marrakech le : ".$date;
$pdf->Cell(40,10,$d,0,0,'L',1);
$pdf->SetY($ent+20);$pdf->SetX(10);$d="V/Bon de commande : ".$votre_commande;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','B',8);
	$pdf->SetY($ent+35);$pdf->SetX(5);
	$pdf->Cell(35,6,'BARCODE',1,0,'C',1);$pdf->SetX(40);	
	$pdf->Cell(90,6,'ARTICLE',1,0,'C',1);$pdf->SetX(130);
	$pdf->Cell(20,6,'QUANT EN UC',1,0,'C',1);$pdf->SetX(150);
	$pdf->Cell(10,6,' X ',1,0,'C',1);$pdf->SetX(160);
	$pdf->Cell(20,6,'UVC/UC',1,0,'C',1);
	$pdf->SetX(180);
	$pdf->Cell(20,6,'QUANTITE',1,0,'C',1);

$ligne=$ent+45;

////////////////////////////////////
}




	$pdf->SetFont('Courier','B',10);
	$pdf->SetY($ligne);$pdf->SetX(5);
	$pdf->Cell(35,6,$designation_client,1,0,'L',1);$pdf->SetX(40);	
	$pdf->Cell(90,6,$produit,1,0,'L',1);$pdf->SetX(130);
	$pdf->Cell(20,6,$qte,1,0,'L',1);$pdf->SetX(150);
	$pdf->Cell(10,6,' X ',1,0,'L',1);$pdf->SetX(160);
	$pdf->Cell(20,6,$condit,1,0,'L',1);//$pdf->SetX(160);$d=number_format($prix_unit,2,',',' ');
	//$pdf->Cell(30,6,$d,0,0,'L',1);
	$pdf->SetX(180);$d=number_format($condit*$qte,0,',',' ');
	$pdf->Cell(20,6,$d,1,0,'R',1);
		
			$ligne=$ligne+5;
		
  } 
  
	$pdf->SetY($ligne+5);$pdf->SetX(180);
	$pdf->Cell(50,9,$page.'/'.$page,0,0,'L',1);
	// envoi du fichier au navigateur */
//Create file
$pdf->Output();
