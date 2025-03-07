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
$y_axis_initial = 25;$y_axis = 25;$row_height=8;
	$total_e=0;$total_c=0;$total_t=0;
	$a="A";

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(5);
$pdf->SetFont('Arial','B',18);
$pdf->Cell(20,6,'M.P.S',1,0,'L',1);
$pdf->SetFont('Arial','B',20);
$pdf->SetY(5);$t_show="DETAIL PORTE FEUILLE EFFETS ";$pdf->SetX(60);
$pdf->Cell(127,7,$t_show,1,0,'L',1);$pdf->SetY(15);
$pdf->SetX(80);$d="AU : ".date("d/m/Y");
$pdf->Cell(60,6,$d,1,0,'L',1);
$pdf->SetFont('Arial','B',12);
$pdf->SetY($y_axis_initial);
$pdf->SetX(15);
$pdf->Cell(35,8,'Date Echeance',1,0,'M',1);
$pdf->Cell(80,8,'CLIENT',1,0,'M',1);
$pdf->Cell(40,8,'REFERENCE',1,0,'M',1);
$pdf->Cell(30,8,'Montant Total',1,0,'R',1);
		
$y_axis = $y_axis + $row_height;$t=0;

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select Code,Name,Price from Products ORDER BY Code',$link);*/
	$date=dateFrToUs(date("d/m/Y"));$total=0;$dt="2018-12-31";
	
	$sql  = "SELECT id,date_enc,date_cheque,date_echeance,client,client_tire_e,v_banque,numero_effet,sum(m_effet) As total_cheque ";
	$sql .= "FROM porte_feuilles where m_effet<>0 and remise_e=0 and eff_f=1 GROUP BY numero_effet order by date_echeance;";
	$users = db_query($database_name, $sql);

//initialize counter
$i = 0;

//Set maximum rows per page
$max = 38;

//Set Row Height
$row_height = 6;$t_cheque=0;$ca=0;$htva_t=0;$tva_t=0;$ttc_t=0;$espece=0;$cheque=0;$effet=0;$tmt_t=0;
	$t_cheque_t = 0;
	$total_espece_t = 0;
	$total_effet_t = 0;

/*while($row = mysql_fetch_array($result))*/
while($row = fetch_array($users))
{
	//If the current row is the last one, create new page and print column title
	if ($i == $max)
	{
		$pdf->AddPage();

		//print column titles for the current page
		$pdf->SetY($y_axis_initial);
		$pdf->SetX(15);
		$pdf->Cell(35,8,'Date Echeance',1,0,'M',1);
		$pdf->Cell(80,8,'CLIENT',1,0,'M',1);
		$pdf->Cell(40,8,'REFERENCE',1,0,'M',1);
		$pdf->Cell(30,8,'Montant Total',1,0,'R',1);		
		//Go to next row
		$y_axis = 34;
		
		//Set $i variable to 0 (first row)
		$i = 0;
	}
	$date_cheque = $row['date_echeance'];$total_cheque=$row['total_cheque'];$client=$row['client'];
	$pdf->SetY($y_axis);$vide="";$client_tire=$row['client_tire'];$clt=$client." / ".$client_tire_e;
	$pdf->SetX(15);$input="";$date=dateUsToFr($date_cheque);$numero_effet=$row['numero_effet'];
	$pdf->Cell(35,6,$date,1,0,'L',1);
	$pdf->Cell(80,6,$clt,1,0,'L',1);
	$pdf->Cell(40,6,$numero_effet,1,0,'L',1);
	$pdf->Cell(30,6,number_format($total_cheque,2,',',' '),1,0,'R',1);
	//Go to next row
	$y_axis = $y_axis + $row_height;
	$t=$t+$total_cheque;
	$i = $i + 1;
}
	$pdf->Ln();	
	$pdf->SetX(170);
	$pdf->Cell(30,5,number_format($t,2,',',' '),1,0,'R',1);
$pdf->Output();
?>
