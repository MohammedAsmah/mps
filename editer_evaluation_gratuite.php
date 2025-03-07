<?php
	require "fpdf.php";
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
	$numero=$_GET['numero'];$client=$_GET['client'];$montant_f=0;$bon_sortie = $_GET['bon_sortie'];$destination = $_GET['destination'];
	$id = $numero;
		$sql  = "SELECT * ";
		$sql .= "FROM commandes_gratuites WHERE id = " . $id . ";";
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
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;

//print column titles for the actual page
$pdf->SetFillColor(255);$entete=30;
$pdf->SetY(5+$entete);
$pdf->SetFont('arial','B',18);
$pdf->Cell(70,14,'',0,0,'L',1);

$pdf->SetFillColor(255);
$pdf->SetFont('arial','B',14);
$pdf->SetX(130);$d="Marrakech le : ".$date;
$pdf->Cell(25,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','',12);
/*$pdf->SetY(20+$entete);$pdf->SetX(10);$d="Vendeur : ".$vendeur;
$pdf->Cell(40,10,$d,0,0,'L',1);$pdf->SetY(285);$pdf->SetX(180);
					$pdf->Cell(30,6,$evaluation,0,0,'L',1);*/

$pdf->SetY(15+$entete);$pdf->SetX(100);$d="Bon de Sortie : ".$evaluation."  ".$numero."/2015";
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(30+$entete);$pdf->SetX(10);$d="Client : ".$client;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetFont('arial','B',12);
$pdf->SetY(46+$entete);$pdf->SetX(10);$d="  Designation Article  ";
$pdf->Cell(50,10,$d,0,0,'L',1);
$pdf->SetY(46+$entete);$pdf->SetX(85);$d="  Nbre Paquets  ";
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetY(46+$entete);$pdf->SetX(124);$d="  Quantite  ";
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetY(46+$entete);$pdf->SetX(150);$d="  Observation";
$pdf->Cell(15,10,$d,0,0,'L',1);
$pdf->SetY(46+$entete);$pdf->SetX(178);$d="    ";
$pdf->Cell(10,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','',12);
$ligne=47;
	
$ligne=55+$entete;



	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes_gratuites where commande='$numero' and sans_remise=0 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
		$total=$total+$m;
		$qte=$users1_["quantite"];
		$condit=$users1_["condit"];
		$prix_unit=$users1_["prix_unit"];
		
	$pdf->SetY($ligne);	
	$pdf->Cell(50,6,$produit,0,0,'L',1);$pdf->SetX(90);
	$pdf->Cell(10,6,$qte,0,0,'L',1);$pdf->SetX(100);
	$pdf->Cell(10,6,' X ',0,0,'L',1);$pdf->SetX(112);
	$pdf->Cell(20,6,$condit,0,0,'L',1);$pdf->SetX(130);
	$pdf->Cell(30,6,$qte*$condit,0,0,'L',1);$d=number_format($prix_unit,2,',',' ');$pdf->SetX(150);
	$pdf->Cell(30,6,'',0,0,'L',1);$d=number_format($qte*$condit*$prix_unit,2,',',' ');$pdf->SetX(180);
	$pdf->Cell(30,6,'',0,0,'L',1);
	
	
		if ($ligne>=240){$pdf->Line(3,$ligne+5,205,$ligne+5);
$pdf->SetFont('Courier','',10);$pdf->SetY($ligne+7);
$pdf->SetX(130);$d="A repporter";
$pdf->Cell(40,10,$d,0,0,'L',1);
//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;

//print column titles for the actual page
$pdf->SetFillColor(255);$entete=30;
$pdf->SetY(5+$entete);
$pdf->SetFont('arial','B',18);
$pdf->Cell(70,14,'',0,0,'L',1);

$pdf->SetFillColor(255);
$pdf->SetFont('arial','B',14);
$pdf->SetX(130);$d="Marrakech le : ".$date;
$pdf->Cell(25,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','',12);
/*$pdf->SetY(20+$entete);$pdf->SetX(10);$d="Vendeur : ".$vendeur;
$pdf->Cell(40,10,$d,0,0,'L',1);*/

$pdf->SetY(15+$entete);$pdf->SetX(100);$d="Bon de Sortie : ".$evaluation."  ".$numero."/2015";
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(30+$entete);$pdf->SetX(10);$d="Client : ".$client;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetFont('arial','B',12);
$pdf->SetY(46+$entete);$pdf->SetX(10);$d="  Designation Article  ";
$pdf->Cell(50,10,$d,0,0,'L',1);
$pdf->SetY(46+$entete);$pdf->SetX(85);$d="  Nbre Paquets  ";
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetY(46+$entete);$pdf->SetX(124);$d="  Quantite  ";
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetY(46+$entete);$pdf->SetX(150);$d="  Observation";
$pdf->Cell(15,10,$d,0,0,'L',1);
$pdf->SetY(46+$entete);$pdf->SetX(178);$d="    ";
$pdf->Cell(10,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','',12);
$ligne=47;
$ligne=55+$entete;
}else{


			$ligne=$ligne+5;
}


			
		 }
/////////////////////////////////		 
		
////////////////////////

$x=140;	$h=5;	$pdf->SetFont('Courier','',11);
$pdf->SetY($ligne+20);	$pdf->SetX(30);
$pdf->Cell(15,80,'Magasinier',0,0,'L',1);$pdf->SetX(100);
$pdf->Cell(15,80,'Controle',0,0,'L',1);$pdf->SetX(150);
$pdf->Cell(15,80,'Visa',0,0,'L',1);
 
					




$pdf->Output();		// envoi du fichier au navigateur

