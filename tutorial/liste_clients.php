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
	$total_e=0;$total_c=0;$total_t=0;
	$a="A";
	$date1=$_GET['date1'];$date2=$_GET['date2'];$date11=dateUsToFr($date1);$date22=dateUsToFr($date2);

//print column titles for the actual page
$pdf->SetFillColor(240);
$pdf->SetY(5);
$pdf->SetFont('Arial','B',18);
$pdf->Cell(20,6,'M.P.S',1,0,'L',1);
$pdf->SetX(260);$d=date("d/m/Y");
$pdf->Cell(34,6,$d,1,0,'L',1);
$pdf->SetFont('Arial','B',14);
$pdf->SetY(15);$t_show="C.A PAR CLIENT  $date11 au $date22 ";
$pdf->SetX(80);
$pdf->Cell(150,6,$t_show,1,0,'C',1);
$pdf->SetFont('Arial','B',12);
$pdf->SetY($y_axis_initial);
$pdf->SetX(5);
$pdf->Cell(70,8,'Designation',1,0,'C',1);
$pdf->Cell(30,8,'PATENTE',1,0,'C',1);
$pdf->Cell(30,8,'VILLE',1,0,'C',1);
$pdf->Cell(120,8,'ADRESSE',1,0,'C',1);
$pdf->Cell(40,8,'Montant',1,0,'C',1);
$y_axis = $y_axis + $row_height;

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select Code,Name,Price from Products ORDER BY Code',$link);*/
	$sql  = "SELECT * ";
	$sql .= "FROM clients ORDER BY client;";
	$users = db_query($database_name, $sql);

//initialize counter
$i = 0;

//Set maximum rows per page
$max = 28;

//Set Row Height
$row_height = 6;$t_cheque=0;$ca=0;$htva_t=0;$tva_t=0;$ttc_t=0;$espece=0;$cheque=0;$effet=0;$tmt_t=0;$t_espece=0;
	$t_cheque_t = 0;
	$t_espece_t = 0;
	$t_effet_t = 0;$t_virement_t = 0;

/*while($row = mysql_fetch_array($result))*/
while($row = fetch_array($users))
{
	//If the current row is the last one, create new page and print column title
	if ($i == $max)
	{
		$pdf->AddPage();

		//print column titles for the current page
$pdf->SetY(15);$t_show="C.A PAR CLIENT   $date11 au $date22 ";
$pdf->SetX(80);
$pdf->Cell(150,6,$t_show,1,0,'C',1);
$pdf->SetY($y_axis_initial);
$pdf->SetX(5);
$pdf->Cell(70,8,'Designation',1,0,'C',1);
$pdf->Cell(30,8,'PATENTE',1,0,'C',1);
$pdf->Cell(30,8,'VILLE',1,0,'C',1);
$pdf->Cell(120,8,'ADRESSE',1,0,'C',1);
$pdf->Cell(40,8,'Montant',1,0,'C',1);
		//Go to next row
		$y_axis = 34;
		
		//Set $i variable to 0 (first row)
		$i = 0;
	}

	
	$client=$row["client"];
	$ville=$row["ville"];$adresse=$row["adrresse"];
	$patente=$row["patente"];$tel="";
		$sql  = "SELECT * ";
	$sql .= "FROM factures where client='$client' and date_f between '$date1' and '$date2' ORDER BY id;";
	$users1 = db_query($database_name, $sql);

	 $ca=0;
	 while($users_ = fetch_array($users1)) { 
		$m=$users_["montant"];$ht=$users_["ht"];
		if ($ht){$ca=$ca+$users_["montant"];$total_t=$total_t+$users_["montant"];}else{$ca=$ca+$users_["montant"]/1.20;$total_t=$total_t+$users_["montant"]/1.20;}
	 }
	 
	 $caht=number_format($ca,2,',',' ') ;

	$total_diff_prix = 0;
	$total_cheque = 0;
	$total_espece = 0;
	$total_effet = 0;
	$total_virement = 0;
	if ($ca>0){
	$pdf->SetY($y_axis);
	$pdf->SetX(5);$input="";
	$pdf->Cell(70,6,$client,1,0,'L',1);
	$pdf->Cell(30,6,$patente,1,0,'L',1);
	$pdf->Cell(30,6,$ville,1,0,'L',1);
	$pdf->Cell(120,6,$adresse,1,0,'L',1);
	$pdf->Cell(40,6,$caht,1,0,'R',1);
	$y_axis = $y_axis + $row_height;
	$i = $i + 1;}
}
	$pdf->Ln();	
	$pdf->SetX(255);
	$total_tt=number_format($total_t/1.20,2,',',' ') ;
	$pdf->Cell(40,6,$total_tt,1,0,'R',1);
	$pdf->Output();
?>
