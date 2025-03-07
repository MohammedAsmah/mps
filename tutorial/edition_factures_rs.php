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
	require "../chiffres_lettres.php";
//Connect to your database
/*mysql_connect('localhost','root','');
mysql_select_db('mps2008');*/

//Create new pdf file
$pdf=new FPDF('P','mm','A4');

/*$dimension = array(210,188);
$dimension = array(210,215);
$pdf=new FPDF('P', 'mm', $dimension);*/


//Disable automatic page break
$pdf->SetAutoPageBreak(false);
$pdf->SetFont('Times','',12);
//Add first page
/*$pdf->AddPage();*/

//set initial y axis position per page
$y_axis_initial = 60;$y_axis = 25;$row_height=4;
	$total_e=0;$total_c=0;$total_t=0;
	$a="A";

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(5);
$y_axis = $y_axis + $row_height;

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select Code,Name,Price from Products ORDER BY Code',$link);*/
	$sql  = "SELECT * ";
	$sql .= "FROM factures_riad  ORDER BY id;";
	$users = db_query($database_name, $sql);

//initialize counter
$i = 0;$t=0;

//Set maximum rows per page
$max = 28;

//Set Row Height
$row_height = 4;$t_cheque=0;$ca=0;$htva_t=0;$tva_t=0;$ttc_t=0;$espece=0;$cheque=0;$effet=0;$tmt_t=0;$t_espece=0;
	$t_cheque_t = 0;
	$t_espece_t = 0;
	$t_effet_t = 0;$t_virement_t = 0;

/*while($row = mysql_fetch_array($result))*/
while($row = fetch_array($users))
{
	//If the current row is the last one, create new page and print column title
	$client=$row["nom"];$id=$row["id"];$f=$row["numero"];$d=$row["date"];$m=$row["montant"];$lettres=int2str($m)." dhs";
	$arrivee=$row["arrivee"];$depart=$row["depart"];
		$pdf->AddPage();$pdf->SetFont('Arial','',26);

		//print column titles for the current page
$pdf->SetY(6);$entete="RIAD SHADEN S.A.R.L ";
$pdf->Cell(80,0,$entete,0,0,'L',0);
$pdf->SetFont('Times','',12);
$pdf->SetY(10);$pdf->SetX(30);
$entete1="222,Derb El Kadi Bab Ailen";
$pdf->Cell(80,10,$entete1,0,0,'L',0);
$pdf->SetY(15);$pdf->SetX(40);
$entete2="Medina Marrakech ";
$pdf->Cell(80,10,$entete2,0,0,'L',0);
$pdf->SetY(20);$pdf->SetX(40);
$entete2="Tel 0524383834 Fax 0524383833 ";
$pdf->Cell(80,10,$entete2,0,0,'L',0);
$pdf->SetY(25);$pdf->SetX(30);
$entete3="Patente :45502275  IF :06510993  RC :28059";
$pdf->Cell(80,10,$entete3,0,0,'L',0);



$pdf->SetFont('Times','',12);
$pdf->SetY(35);$t_show="FACTURE  $f ";
$pdf->SetX(145);
$pdf->SetFont('Arial','B',13);
$pdf->Cell(80,0,$t_show,0,0,'C',0);
$pdf->SetY(55);
$pdf->SetX(15);$d="Marrakech le : $d ";
$pdf->Cell(34,0,$d,0,0,'L',1);
$pdf->SetY(55);$pdf->SetX(140);$client="Client : $client";
$pdf->Cell(90,0,$client,0,0,'L',1);

$pdf->SetY($y_axis_initial);
$pdf->SetX(8);
$pdf->Cell(90,8,'Designation',1,0,'C',1);
$pdf->Cell(30,8,'Nuites',1,0,'C',1);
$pdf->Cell(38,8,'Prix Unitaire',1,0,'C',1);
$pdf->Cell(38,8,'Montant',1,0,'C',1);
$pdf->SetFont('Arial','B',12);

		//Go to next row
		$y_axis = 34;
		
		//Set $i variable to 0 (first row)
		$i = 0;

	$numero = $row['id'];$type=$row["type"];$nuites=$row["nuites"];$pax=$row["pax"];$taxe=$row["taxe"];$prix_unit=$row["prix_unit"];
	$montant=$row["montant"];
	if ($type=="h"){
	$libelle="Habergement du ".$arrivee." au ".$depart;
	$libelle2="Chambre pour ".$pax." personnes";
	$libelle3="Taxe de sejour  ";$ts=number_format($nuites*15*$pax,2,',',' ');
	$libelle4="Taxe de Promotion Touristique";$tp=number_format($nuites*8*$pax,2,',',' ');
	$pax_t=$pax*$nuites;$vide="          ";
	$total=$prix_unit*$nuites;$total=number_format($total,2,',',' ');
	$pdf->SetY($y_axis_initial+10);
	$pdf->SetX(8);
	$pdf->Cell(90,8,$libelle,0,0,'L',1);
	$pdf->Cell(30,8,$nuites,0,0,'C',1);
	$pdf->Cell(38,8,$prix_unit,0,0,'L',1);
	$pdf->Cell(38,8,$total,0,0,'R',1);
	$pdf->SetY($y_axis_initial+17);
	$pdf->SetX(8);
	$pdf->Cell(90,8,$libelle2,0,0,'L',1);
	$pdf->SetY($y_axis_initial+25);
	$pdf->SetX(8);
	$pdf->Cell(90,8,$libelle3,0,0,'L',1);
	$pdf->Cell(30,8,$pax_t,0,0,'C',1);
	$pdf->Cell(38,8,$vide,0,0,'L',1);
	$pdf->Cell(38,8,$ts,0,0,'R',1);
	$pdf->SetY($y_axis_initial+33);
	$pdf->SetX(8);
	$pdf->Cell(90,8,$libelle4,0,0,'L',1);
	$pdf->Cell(30,8,$pax_t,0,0,'C',1);
	$pdf->Cell(38,8,$vide,0,0,'L',1);
	$pdf->Cell(38,8,$tp,0,0,'R',1);

	}
	else {$libelle="Extra et Divers";$libelle2="";$libelle3="";$nuites=1;$prix_unit=$montant;
	$total=$prix_unit*$nuites;$total=number_format($total,2,',',' ');
	$pdf->SetY($y_axis_initial+10);
	$pdf->SetX(8);
	$pdf->Cell(90,8,$libelle,0,0,'L',1);
	$pdf->Cell(30,8,$nuites,0,0,'C',1);
	$pdf->Cell(38,8,$prix_unit,0,0,'L',1);
	$pdf->Cell(38,8,$total,0,0,'L',1);
	}


	
	$pdf->SetY($y_axis_initial+67);
	$pdf->SetX(80);
	$net ="Total TTC : ".$total;
	$pdf->Cell(40,8,$net,0,0,'L',1);
	
	
	
	
	$total_e = 0;$total_avoir = 0;
	$brut=0;$brut_sans=0;
	$y_axis_d=74;$pdf->SetY($y_axis_d);$pdf->SetFont('Times','',8);
		
}

$pdf->Output();
?>
