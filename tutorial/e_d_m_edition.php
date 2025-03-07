<?php
//PDF USING MULTIPLE PAGES
//CREATED BY: Carlos Vasquez S.
//E-MAIL: cvasquez@cvs.cl
//CVS TECNOLOGIA E INNOVACION
//SANTIAGO, CHILE

require('../fpdf.php');
	require "../config.php";
	require "../connect_db.php";
	require "../functions.php";
//Connect to your database
/*mysql_connect('localhost','root','');
mysql_select_db('mps2008');*/

//Create new pdf file
$pdf=new FPDF('P','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page

	
	$id=$_GET["id"];
	
		$sql  = "SELECT * ";
		$sql .= "FROM e_d_m WHERE id = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$date = dateUsToFr($user_["date_imp"]);$date="MARRAKECH , LE ".$date;
	$choix1=$user_["choix1"];
	$choix2=$user_["choix2"];
	$choix3=$user_["choix3"];
	$importateur1=$user_["importateur1"];
	$importateur2=$user_["importateur2"];
	$importateur3=$user_["importateur3"];
	$numero_rc=$user_["numero_rc"];
	$centre_rc=$user_["centre_rc"];
	$regime_douanier=$user_["regime_douanier"];
	$exp1=$user_["exp1"];
	$exp2=$user_["exp2"];
	$exp3=$user_["exp3"];
	$exp4=$user_["exp4"];
	$montant1=$user_["montant1"];$montant2=$user_["montant2"];$montant3=$user_["montant3"];
	$bureau_douanier=$user_["bureau_douanier"];$nomenclature=$user_["nomenclature"];
	$origine=$user_["origine"];
	$provenance=$user_["provenance"];
	$designation1=$user_["designation1"];
	$designation2=$user_["designation2"];
	$designation3=$user_["designation3"];
	$poids=$user_["poids"];
	$siege_social=$user_["siege_social"];
	$adresse=$user_["adresse"];
	$ville=$user_["ville"];
	$identifiant=$user_["identifiant"];
	$taxe=$user_["taxe"];
	$modalite_paiement1=$user_["modalite_paiement1"];$modalite_paiement2=$user_["modalite_paiement2"];
	

//print column titles for the actual page
$pdf->SetFillColor(255);$pdf->SetFont('Courier','B',12);

//choix
$y=2;
$pdf->SetY($y);$pdf->SetX(108);
$pdf->Cell(20,6,$choix1,0,0,'L',1);
$pdf->SetY($y+9);$pdf->SetX(103);
$pdf->Cell(20,6,$choix2,0,0,'L',1);
$pdf->SetY($y+15);$pdf->SetX(103);
$pdf->Cell(20,6,$choix3,0,0,'L',1);

//importateur
$pdf->SetFont('Courier','B',10);
$pdf->SetY($y+25);$pdf->SetX(15);
$pdf->Cell(20,6,$importateur1,0,0,'L',1);
$pdf->SetY($y+30);$pdf->SetX(15);
$pdf->Cell(20,6,$importateur2,0,0,'L',1);
$pdf->SetY($y+35);$pdf->SetX(51);
$pdf->Cell(20,6,$importateur3,0,0,'L',1);

//siege
$pdf->SetY($y+23);$pdf->SetX(122);
$pdf->Cell(20,6,$siege_social,0,0,'L',1);
$pdf->SetY($y+28);$pdf->SetX(120);
$pdf->Cell(20,6,$adresse,0,0,'L',1);
$pdf->SetY($y+33);$pdf->SetX(152);
$pdf->Cell(20,6,$ville,0,0,'L',1);
$pdf->SetY($y+35);$pdf->SetX(130);
$pdf->Cell(10,6,$identifiant,0,0,'L',1);
$pdf->SetY($y+41);$pdf->SetX(132);
$pdf->Cell(20,6,$taxe,0,0,'L',1);



$pdf->SetFont('Courier','B',10);


//rc
$pdf->SetY($y+36);$pdf->SetX(26);
$pdf->Cell(20,6,$numero_rc,0,0,'L',1);
$pdf->SetY($y+41);$pdf->SetX(30);
$pdf->Cell(20,6,$centre_rc,0,0,'L',1);

//exp
$pdf->SetY($y+48);$pdf->SetX(35);
$pdf->Cell(20,6,$exp1,0,0,'L',1);
$pdf->SetY($y+52);$pdf->SetX(15);
$pdf->Cell(20,6,$exp2,0,0,'L',1);
$pdf->SetY($y+56);$pdf->SetX(15);
$pdf->Cell(20,6,$exp3,0,0,'L',1);
$pdf->SetY($y+61);$pdf->SetX(15);
$pdf->Cell(20,6,$exp4,0,0,'L',1);


//port
$pdf->SetY($y+57);$pdf->SetX(125);
$pdf->Cell(20,6,$bureau_douanier,0,0,'L',1);

//devise
$pdf->SetY($y+70);$pdf->SetX(15);
$pdf->Cell(20,6,$montant1,0,0,'L',1);
$pdf->SetY($y+75);$pdf->SetX(15);
$pdf->Cell(20,6,$montant2,0,0,'L',1);
$pdf->SetY($y+80);$pdf->SetX(15);
$pdf->Cell(20,6,$montant3,0,0,'L',1);




$pdf->SetY($y+87);$pdf->SetX(15);
$pdf->Cell(20,6,$modalite_paiement1,0,0,'L',1);
$pdf->SetY($y+92);$pdf->SetX(15);
$pdf->Cell(20,6,$modalite_paiement2,0,0,'L',1);
//paye
$pdf->SetY($y+70);$pdf->SetX(130);
$pdf->Cell(20,6,$origine,0,0,'L',1);
$pdf->SetY($y+90);$pdf->SetX(130);
$pdf->Cell(20,6,$provenance,0,0,'L',1);

//nomenclature
$pdf->SetY($y+101);$pdf->SetX(120);
$pdf->Cell(20,6,$nomenclature,0,0,'L',1);

//regime
$pdf->SetY($y+110);$pdf->SetX(126);
$pdf->Cell(20,6,$regime_douanier,0,0,'L',1);


//designation
$pdf->SetFont('Courier','B',10);
$pdf->SetY($y+120);$pdf->SetX(15);
$pdf->Cell(20,6,$designation1,0,0,'L',1);
$pdf->SetY($y+125);$pdf->SetX(15);
$pdf->Cell(20,6,$designation2,0,0,'L',1);
$pdf->SetY($y+130);$pdf->SetX(15);
$pdf->Cell(20,6,$designation3,0,0,'L',1);

$pdf->SetFont('Courier','B',12);
//poids
$pdf->SetY($y+116);$pdf->SetX(120);
$pdf->Cell(20,6,$poids,0,0,'L',1);

//date
$pdf->SetY($y+148);$pdf->SetX(60);
$pdf->Cell(20,6,$date,0,0,'L',1);

	
$pdf->Output();
?>
