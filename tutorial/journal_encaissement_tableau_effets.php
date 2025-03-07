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
$pdf=new FPDF('L','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;
	$tableau=$_GET['tableau'];$total=0;$vendeur=$_GET['vendeur'];$service=$_GET['service'];
	
	/*$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles where id_registre_regl='$tableau' and (m_cheque<>0 or m_effet<>0) ORDER BY id_registre_regl;";
	$users11 = db_query($database_name, $sql);*/
	$sql  = "SELECT numero_effet,v_banque_e,date_enc,facture_n,date_f,exercice,montant_f,client,client_tire,client_tire_e,sum(montant_e) as total_e,
	sum(m_cheque) as total_cheque,sum(m_cheque_g) as total_cheque_g,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix ";
	$sql .= "FROM porte_feuilles_factures where id_registre_regl='$tableau' and m_effet<>0 and facture_n<>0 and impaye<>1 Group BY id;";
	$users11 = db_query($database_name, $sql);
	
	
	$total_e=0;$total_c=0;$total_t=0;
	$a="A";

//print column titles for the actual page
$pdf->SetFillColor(256);
$pdf->SetY(5);$pdf->SetX(5);
$pdf->SetFont('Arial','B',18);
$pdf->Cell(20,6,'M.P.S',0,0,'L',1);
$pdf->SetFont('Arial','B',16);$d=date("d/m/Y");
$pdf->SetY(10);$pdf->SetX(55);$t_show="ETAT ENTREE EFFETS   ".$tableau."/2011   ".$vendeur."     ".$service;
$pdf->Cell(0,6,$t_show,0,0,'L',1);
$pdf->SetFont('Arial','B',12);
$pdf->SetY($y_axis_initial);
$pdf->SetX(5);
$pdf->Cell(23,8,'Date Entree',1,0,'L',1);
$pdf->Cell(49,8,'Client',1,0,'M',1);
$pdf->Cell(49,8,'Client Tire',1,0,'M',1);
$pdf->Cell(65,8,'Libelle',1,0,'M',1);

$pdf->Cell(25,8,'M.T Effet',1,0,'M',1);
$pdf->Cell(25,8,'M.T Fact',1,0,'M',1);
$pdf->Cell(20,8,'N° Fact',1,0,'M',1);
$pdf->Cell(25,8,'M.T Traite',1,0,'M',1);
$y_axis = $y_axis + $row_height;


//initialize counter
$i = 0;

//Set maximum rows per page
$max = 25;

//Set Row Height
$row_height = 6;$t_espece=0;$total_c=0;$total_e=0;$total_ce=0;$total_t=0;
/*while($row = mysql_fetch_array($result))*/
while($users_1 = fetch_array($users11))
{
	//If the current row is the last one, create new page and print column title
	if ($i == $max)
	{
		$pdf->AddPage();

		//print column titles for the current page
$pdf->SetY($y_axis_initial);
$pdf->SetX(5);
$pdf->Cell(23,8,'Date Entree',1,0,'L',1);
$pdf->Cell(49,8,'Client',1,0,'M',1);
$pdf->Cell(49,8,'Client Tire',1,0,'M',1);
$pdf->Cell(65,8,'Libelle',1,0,'M',1);

$pdf->Cell(25,8,'M.T Effet',1,0,'M',1);
$pdf->Cell(25,8,'M.T Fact',1,0,'M',1);
$pdf->Cell(20,8,'N° Fact',1,0,'M',1);
$pdf->Cell(25,8,'M.T Traite',1,0,'M',1);
		
		//Go to next row
		$y_axis = $y_axis + $row_height;
		
		//Set $i variable to 0 (first row)
		$i = 0;
	}

			$date_enc=$users_1["date_enc"];
			$client=$users_1["client"];$facture_n=$users_1["facture_n"];$client_tire=$users_1["client_tire"];
			$total_cheque_g=$users_1["total_cheque_g"];$total_cheque=$users_1["total_cheque"];
			$numero_effet=$users_1["numero_effet"];$total_effet=$users_1["total_effet"];
			$montant_f=$users_1["montant_f"];$client_tire_e=$users_1["client_tire_e"];
			$v_banque=$users_1["v_banque_e"];
			$date_facture_n=$users_1["date_f"];
			if ($date_facture_n>"2016-12-31"){
				if ($facture_n<10){$zero="0000";}
				if ($facture_n>=10 and $facture_n<100){$zero="000";}
				if ($facture_n>=100 and $facture_n<1000){$zero="00";}
				if ($facture_n>=1000 and $facture_n<10000){$zero="0";}
				if ($facture_n>=10000){$zero="";}
				$exercice=$users_1["exercice"];$facture_n=$zero.$facture_n."/".$exercice;
			}
	$pdf->SetY($y_axis);
	$pdf->SetX(5);$lib=$client;$lib1=$client_tire_e;$ref=$numero_effet."/".$v_banque;
	$pdf->Cell(23,6,dateUsToFr($users_1["date_enc"]),1,0,'L',1);
	$pdf->Cell(49,6,$lib,1,0,'L',1);
	$pdf->Cell(49,6,$lib1,1,0,'L',1);
	$pdf->Cell(65,6,$ref,1,0,'M',1);
	$total_c=$total_c+$total_effet;
	$pdf->Cell(25,6,number_format($total_effet,2,',',' '),1,0,'R',1);$total_e=$total_e+$total_effet;
	$pdf->Cell(25,6,number_format($montant_f,2,',',' '),1,0,'R',1);$total_t=$total_t+$montant_f;
	$pdf->Cell(20,6,$facture_n,1,0,'M',1);
	$pdf->Cell(25,6,number_format($total_effet+$total_cheque,2,',',' '),1,0,'R',1);$total_ce=$total_ce+$total_cheque+$total_effet;

	//Go to next row
	$y_axis = $y_axis + $row_height;
	$i = $i + 1;
}

//impayes


	$sql  = "SELECT * ";$t_imp=0;$vide="";
	$sql .= "FROM porte_feuilles_impayes where tableau='$tableau' and m_effet<>0 Group BY id;";
	$users11 = db_query($database_name, $sql);
		

	while($row1 = fetch_array($users11))
	{	$numero_cheque = $row1['numero_cheque'];$libelle = "Encaisst. impayé / ".$row1['client']."/".$row1['numero_cheque_imp'];
	$m_espece_imp = $row1['m_espece'];
	$m_virement_imp = $row1['m_virement'];
	$m_cheque_imp = number_format($row1['m_cheque'],2,',',' ');$t_imp=$t_imp+$row1['m_cheque'];
	$pdf->Ln();	
	$pdf->SetX(5);
	$pdf->Cell(23,6,dateUsToFr($date_enc),1,0,'L',1);
	$pdf->Cell(138,6,$libelle,1,0,'L',1);
	$pdf->Cell(25,6,$m_cheque_imp,1,0,'R',1);
	$pdf->Cell(25,6,$vide,1,0,'R',1);
	$pdf->Cell(25,6,$vide,1,0,'R',1);
	$pdf->Cell(20,6,$vide,1,0,'R',1);
	$pdf->Cell(25,6,$m_cheque_imp,1,0,'R',1);

	}





	$pdf->Ln();	
	$pdf->SetX(191);
	$pdf->Cell(25,6,number_format($total_c+$t_imp,2,',',' '),1,0,'R',1);
	/*$pdf->Cell(25,6,number_format($total_t,2,',',' '),1,0,'R',1);*/
	$pdf->Cell(25,6,'',1,0,'R',1);
	$pdf->Cell(25,6,'',1,0,'R',1);
	$pdf->SetX(261);
	$pdf->Cell(25,6,number_format($total_ce+$t_imp,2,',',' '),1,0,'R',1);
	$pdf->Ln();	
	$pdf->Ln();	
	$pdf->Ln();	
	$pdf->SetX(50);
	$pdf->Cell(25,6,'Commercial',0,0,'M',1);
	$pdf->SetX(220);
	$pdf->Cell(26,6,'Comptabilite',0,0,'M',1);
//Create file
$pdf->Output();
?>
