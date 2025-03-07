<?php
	require('fpdf.php');
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	require "chiffres_lettres.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
		//sub
	
	
		$id_registre=$_GET['id_registre'];$bon_sortie=$_GET['bon_sortie'];$c=$_GET['observation'];
		$montant=$_GET['montant'];
		$montant=number_format($montant,2,',',' ');
		$vendeur=$_GET['vendeur'];$date1=dateUsToFr($_GET['date']);$service=$_GET['service'];
			
$sql  = "SELECT * ";
	$sql .= "FROM registre_vendeurs where id='$id_registre' ORDER BY id;";
	//	$sql .= "FROM registre_vendeurs where date between '$d1' and '$d2' ORDER BY id;";
	$users11 = db_query($database_name, $sql);
$user_ = fetch_array($users11);

		$title = "";

		$date=dateUsToFr($user_["date"]);
		$service = $user_["service"];
		$vendeur = $user_["vendeur"];$valide = $user_["valide"];$frais = $user_["frais"];$frais_v = $user_["frais_v"];
		$statut = $user_["statut"];
		$user_open = $user_["user_open"];
		$date_open = $user_["date_open"];
		$observation=$user_["observation"];
		$type_service="SEJOURS ET CIRCUITS";
		$motif_cancel=$user_["motif_cancel"];$id=$_REQUEST["user_id"];
		$imprimer=$user_["imprimer"];$heure=$user_["heure"];$imprimer1=$user_["imprimer"];$matricule=$user_["matricule"];$obs_c=$user_["obs_c"];
		$ordre=$user_["ordre"];$montant=$user_["montant"];$montantev1=$user_["montant"];$heure1=$user_["heure"];$bl_out=$user_["bl_out"];$bl_in=$user_["bl_in"];

$sql = "SELECT matricule,chauffeur FROM rs_data_camions where matricule='$matricule' ORDER BY chauffeur;";
$user1 = db_query($database_name, $sql);
$user_1 = fetch_array($user1);
$chauffeur=$user_1["chauffeur"];


	

//Create new pdf file
$pdf=new FPDF('P','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;

//print column titles for the actual page



//transport

//print column titles for the actual page

$orig = 'Remis a : ';
$a = htmlentities($orig);
$b = html_entity_decode($a);
$b=strtolower($b);

$pdf->SetFillColor(255);
$pdf->SetY(5);$pdf->SetX(80);
$pdf->SetFont('Courier','B',14);$d="B.P DH :  ".$frais;
$pdf->Cell(70,14,$d,0,0,'L',1);

$pdf->SetFont('Courier','',14);
$pdf->SetY(15);$pdf->SetX(70);
$pdf->SetFont('Courier','B',16);$d="PIECE DE CAISSE DEPENSES  ";
$pdf->Cell(100,12,$d,0,0,'L',1);

$pdf->SetFont('Courier','',14);
$pdf->SetY(30);
$pdf->SetX(5);$d=$chauffeur."  ( ".$matricule." )";
$pdf->Cell(25,10,$orig,0,0,'L',1);
$pdf->SetX(35);
$pdf->SetFont('Courier','B',14);
$pdf->Cell(100,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','',14);
$pdf->SetY(40);$lettres=int2str($frais)."Dhs";
$pdf->SetX(5);$d="La somme de  : ";
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetFont('Courier','B',14);
$pdf->SetX(60);$pdf->Cell(125,10,$lettres,0,0,'L',1);

$pdf->SetFont('Courier','',14);
$pdf->SetY(50);
$pdf->SetX(5);$d="Pour Reglt Frais transport chargement : ";
$pdf->Cell(100,10,$d,0,0,'L',1);
$pdf->SetFont('Courier','B',14);
$pdf->SetX(122);$pdf->Cell(125,10,$service,0,0,'L',1);


$pdf->SetFont('Courier','',14);
$pdf->SetY(70);$pdf->SetX(15);$d="Client : ";
$pdf->Cell(20,10,$d,0,0,'L',1);
$pdf->SetFont('Courier','B',14);
$pdf->SetX(60);$pdf->Cell(125,10,$c,0,0,'L',1);


$pdf->SetFont('Courier','',14);
$pdf->SetY(80);$pdf->SetX(15);$d="Bon de sortie : ";
$pdf->Cell(20,10,$d,0,0,'L',1);
$pdf->SetFont('Courier','B',14);
$pdf->SetX(60);$pdf->Cell(125,10,$bon_sortie,0,0,'L',1);


$pdf->SetFont('Courier','',14);
$pdf->SetY(90);$pdf->SetX(15);$d="Vendeur : ";
$pdf->Cell(20,10,$d,0,0,'L',1);
$pdf->SetFont('Courier','B',14);
$pdf->SetX(60);$pdf->Cell(125,10,$vendeur,0,0,'L',1);


$pdf->SetFont('Courier','',14);
$pdf->SetY(130);
$pdf->SetX(130);
$pdf->Cell(50,9,'Marrakech le : '.$date1,0,0,'L',1);

$pdf->SetFont('Courier','',14);
$pdf->SetY(150);
$pdf->SetX(2);
$pdf->Cell(250,5,'-------------------------------------------------------------------------------------------------',0,0,'L',1);




	// envoi du fichier au navigateur */
//Create file
$pdf->Output();
