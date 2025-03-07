<?php
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
$y_axis_initial = 5;$y_axis = 5;$row_height=8;
	$total_e=0;$total_c=0;$total_t=0;
	$a="A";

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(5);
$pdf->SetFont('Arial','B',18);
$pdf->Cell(20,6,'M.P.S',1,0,'L',1);
$pdf->SetFont('Arial','B',20);
$pdf->SetY(5);$t_show="SITUATION PORTE FEUILLE ";$pdf->SetX(60);
$pdf->Cell(97,6,$t_show,1,0,'L',1);$pdf->SetY(15);
$pdf->SetX(80);$d="AU : ".date("d/m/Y");
$pdf->Cell(60,6,$d,1,0,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->SetY($y_axis_initial);
$pdf->SetX(225);
$pdf->Cell(40,8,'Cumul',1,0,'M',1);
$y_axis = $y_axis + $row_height;$t=0;

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select Code,Name,Price from Products ORDER BY Code',$link);*/
	$date=dateFrToUs(date("d/m/Y"));$total=0;$dd="2024-03-30";
	
	$sql  = "SELECT id,date_enc,date_cheque,client,client_tire,v_banque,numero_cheque,sum(m_cheque) As total_cheque ";
	$sql .= "FROM porte_feuilles where m_cheque<>0 and remise=0 and chq_f=1 and date_cheque>'$dd' GROUP BY id order by date_cheque;";
	
	$users = db_query($database_name, $sql);

//initialize counter
$i = 0;

//Set maximum rows per page
$max = 30;

//Set Row Height
$row_height = 6;$t_cheque=0;$ca=0;$htva_t=0;$tva_t=0;$ttc_t=0;$espece=0;$cheque=0;$effet=0;$tmt_t=0;
	$t_cheque_t = 0;
	$total_espece_t = 0;
	$total_effet_t = 0;$total_cheque_t=0;

/*while($row = mysql_fetch_array($result))*/
while($row = fetch_array($users))
{
	//If the current row is the last one, create new page and print column title
	if ($i == $max)
	{
		$pdf->AddPage();

		//print column titles for the current page
		$pdf->SetY($y_axis_initial);
		$pdf->SetX(225);
		$pdf->Cell(40,8,'Cumul',1,0,'R',1);		
		//Go to next row
		$y_axis = 5;
		
		//Set $i variable to 0 (first row)
		$i = 0;
	}
	$date_cheque = $row['date_cheque'];$total_cheque=$row['total_cheque'];
	$pdf->SetY($y_axis);$vide="";$numero_cheque=$row["numero_cheque"];$client=$row["client"];
	
	/*$sql = "UPDATE porte_feuilles SET ";$remise=1;$date_cheque_fin="2024-03-30";$banque="BCP";$date_cheque_fin2="2023-03-30";
					$sql .= "numero_remise = '" . $remise . "', ";
					$sql .= "remise_bq = '" . $banque . "', ";
					$sql .= "date_remise = '" . $date_cheque_fin2 . "', ";
					$sql .= "remise = '" . $remise . "' ";
					
					$sql .= "WHERE remise=0 and date_cheque < " . $date_cheque_fin . ";";
					db_query($database_name, $sql);*/
	
	
	
			$sql  = "SELECT * ";
			$sql .= "FROM porte_feuilles_factures where numero_cheque='$numero_cheque' ;";
			$users111 = db_query($database_name, $sql);$users_111 = fetch_array($users111);
			$remise=$users_111["remise"];$client2=$users_111["client"];
	//if ($remise==0){
		$total_cheque_t=$total_cheque_t+$total_cheque;
	$pdf->SetX(5);$input="";$date=dateUsToFr($date_cheque);
	$pdf->Cell(30,6,$date,1,0,'L',1);
	$pdf->Cell(40,6,$numero_cheque,1,0,'L',1);
	$pdf->Cell(60,6,$client,1,0,'L',1);
	$pdf->Cell(60,6,$client2,1,0,'L',1);
	$pdf->Cell(30,6,number_format($total_cheque,2,',',' '),1,0,'R',1);
	$pdf->Cell(40,6,number_format($total_cheque_t,2,',',' '),1,0,'R',1);
	
	//Go to next row
	$y_axis = $y_axis + $row_height;
	$t=$t+$total_cheque;
	$i = $i + 1;
	//}
}
	
	$pdf->Output();
	/*$alea = time(); 
	header('Location: portefeuillefacture.pdf'.$alea); */
	

?>
