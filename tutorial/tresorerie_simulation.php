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
$y_axis_initial = 9;$y_axis = 13;$row_height=8;
	$total_e=0;$total_c=0;$total_t=0;
	$a="A";
$banque=$_GET['banque'];$exe1=dateFrToUs($_GET['date']);$date=$_GET['date'];$du=$_GET['du'];$au=$_GET['au'];$du_fr=dateUsToFr($du);$au_fr=dateUsToFr($au);
		
		$exe="2008-01-01";
			$sql  = "SELECT * ";
			$sql .= "FROM journal_banques_simulation where caisse='$banque' and date>='$exe' and erreur=0 ORDER BY date,id;";
			$users = db_query($database_name, $sql);
	

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(1);
$pdf->SetFont('Arial','B',18);
$pdf->Cell(20,6,'M.P.S',1,0,'L',1);
$pdf->SetFont('Arial','B',14);
$pdf->SetY(1);$t_show="Simulation Banque ";$pdf->SetX(50);
$pdf->Cell(97,6,$t_show,1,0,'L',1);
$pdf->SetFont('Arial','B',12);
$pdf->SetY($y_axis_initial);
$pdf->SetX(3);
$pdf->Cell(25,8,'Date',1,0,'M',1);
$pdf->Cell(175,8,'Libelle',1,0,'M',1);
$pdf->Cell(27,8,'Debit',1,0,'M',1);
$pdf->Cell(27,8,'Credit',1,0,'M',1);
$pdf->Cell(27,8,'Solde',1,0,'M',1);
$y_axis = $y_axis + $row_height;$t=0;

//Select the Products you want to show in your PDF file

//initialize counter
$i = 0;

//Set maximum rows per page
$max = 30;

//Set Row Height
$row_height = 6;$t_cheque=0;$ca=0;$htva_t=0;$tva_t=0;$ttc_t=0;$espece=0;$cheque=0;$effet=0;$tmt_t=0;
	$t_cheque_t = 0;
	$total_espece_t = 0;
	$total_effet_t = 0;$total_cheque_t=0;
	
	$debit=0;$credit=0;$sss=0;$solde=0 ;

/*while($row = mysql_fetch_array($result))*/
while($row = fetch_array($users))
{
$solde=$solde+($row["credit"]-$row["debit"]);

	//If the current row is the last one, create new page and print column title
	if ($i == $max)
	{
		$pdf->AddPage();

		//print column titles for the current page
		$pdf->SetY($y_axis_initial);
		$pdf->SetX(3);
$pdf->Cell(25,8,'Date',1,0,'M',1);
$pdf->Cell(175,8,'Libelle',1,0,'M',1);
$pdf->Cell(27,8,'Debit',1,0,'M',1);
$pdf->Cell(27,8,'Credit',1,0,'M',1);
$pdf->Cell(27,8,'Solde',1,0,'M',1);
		//Go to next row
		$y_axis = 15;
		
		//Set $i variable to 0 (first row)
		$i = 0;
	}
	
	if ($row["date"]>=$du){
	$pdf->SetY($y_axis);$vide="";
	$pdf->SetX(3);$input="";$datefr=dateUsToFr($row["date"]);
	if ($row["color"]=="rouge"){$pdf->SetTextColor(220,50,50);}
	if ($row["color"]=="vert"){$pdf->SetTextColor(24,210,50);}
	if ($row["color"]=="bleu"){$pdf->SetTextColor(14,110,180);}
	
	$pdf->Cell(25,6,$datefr,1,0,'L',1);
	$pdf->Cell(175,6,$row["libelle"],1,0,'L',1);
	$pdf->Cell(27,6,number_format($row["debit"],2,',',' '),1,0,'R',1);$debit=$debit+$row["debit"];
	$pdf->Cell(27,6,number_format($row["credit"],2,',',' '),1,0,'R',1);$credit=$credit+$row["credit"];
	$pdf->SetTextColor(0);
	
	
	
	
	if ($solde<=0){$s1=$solde*-1;$signe="DB";}else {$s1=$solde*1;$signe="CR";$pdf->SetTextColor(220,50,50);}

	$ss=number_format($s1,2,',',' ');
	$pdf->Cell(27,6,number_format($s1,2,',',' '),1,0,'R',1);$pdf->SetTextColor(0);
	//Go to next row
	$y_axis = $y_axis + $row_height;
	$t=$t+$total_cheque;
	$i = $i + 1;
	}
	
}
	$pdf->Ln();	
	
	$pdf->Output();
	

?>
