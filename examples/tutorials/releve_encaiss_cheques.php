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
	$date1=$_GET['date1'];$total_e=0;$total_c=0;$total_t=0;
	$a="A";$date2=$_GET['date2'];

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(5);
$pdf->SetFont('Arial','',18);
$pdf->Cell(20,6,'M.P.S',1,0,'L',1);
$pdf->SetX(260);$d_j=date("d/m/Y");
$pdf->Cell(34,6,$d_j,1,0,'L',1);
$pdf->SetFont('Arial','',14);
$pdf->SetY(15);$t_show="ENCAISSEMENTS DU MOIS  : ".dateUsToFr($date1)."   ".dateUsToFr($date2);
$pdf->Cell(150,6,$t_show,1,0,'C',1);
$pdf->SetFont('Arial','',12);
$pdf->SetY($y_axis_initial);
$pdf->SetX(5);
$pdf->Cell(23,8,'Date',1,0,'M',1);
$pdf->Cell(15,8,'Fact',1,0,'C',1);
$pdf->Cell(20,8,'INPUT',1,0,'L',1);
$pdf->Cell(68,8,'Designation',1,0,'M',1);
$pdf->Cell(30,8,'Especes',1,0,'R',1);
$pdf->Cell(30,8,'Cheques',1,0,'R',1);
$pdf->Cell(30,8,'Effets',1,0,'R',1);
$pdf->Cell(30,8,'Virement',1,0,'R',1);
$pdf->Cell(30,8,'Remise',1,0,'R',1);
$y_axis = $y_axis + $row_height;$dd="2009-09-30";$hors="hors compte";$hors1="hors";

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select Code,Name,Price from Products ORDER BY Code',$link);*/
		$sql  = "SELECT date_virement,date_remise,date_e,date_echeance,date_enc,numero_cheque,facture_n,client,
		client_tire,v_banque,date_cheque,remise,facture_n,vendeur,
		sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece
		, sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
		$sql .= "FROM porte_feuilles where 
		(date_remise between '$date1' and '$date2' and facture_n<>0 and remise=1 and id_registre_regl<>0) 
		or (date_echeance between '$date1' and '$date2' and facture_n<>0 and m_effet<>0 and m_cheque=0 and id_registre_regl<>0)   
		
		or (date_virement between '$date1' and '$date2' and facture_n<>0 and m_virement<>0 and id_registre_regl<>0)
		or (date_enc between '$date1' and '$date2' and facture_n<>0 and m_espece<>0)
		Group BY id order by facture_n;";
		/*$ccc="BENYAHIYA HAMID";
		$sql  = "SELECT date_virement,date_remise,date_echeance,date_enc,numero_cheque,facture_n,client,client_tire,v_banque,
		sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece
		, sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
		$sql .= "FROM porte_feuilles where client='$ccc' Group BY id order by facture_n;";*/
		
		$users11 = db_query($database_name, $sql);/**/

//initialize counter
$i = 0;

//Set maximum rows per page
$max = 28;

//Set Row Height
$row_height = 6;$t_cheque=0;$ca=0;$htva_t=0;$tva_t=0;$ttc_t=0;$espece=0;$cheque=0;$effet=0;$tmt_t=0;
	$t_cheque_t = 0;
	$total_espece_t = 0;
	$total_effet_t = 0;

/*while($row = mysql_fetch_array($result))*/
		$total_effet=0;$total_espece=0;$total_cheque=0;$total_virement=0;
while($row = fetch_array($users11)){
	//If the current row is the last one, create new page and print column title
	if ($i == $max)
	{
	$pdf->Ln();	
	$pdf->SetX(131);
	$pdf->Cell(30,5,number_format($total_espece,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($total_cheque,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($total_effet,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($total_virement,2,',',' '),1,0,'R',1);
		$pdf->AddPage();
		$pdf->SetFont('Arial','',18);
		$pdf->Cell(20,6,'M.P.S',1,0,'L',1);
		$pdf->SetX(260);$d_j=date("d/m/Y");
		$pdf->Cell(34,6,$d_j,1,0,'L',1);
		$pdf->SetFont('Arial','',14);
		$pdf->SetY(15);$t_show="ENCAISSEMENTS DU MOIS  : ".dateUsToFr($date1)."   ".dateUsToFr($date2);
		$pdf->Cell(150,6,$t_show,1,0,'C',1);
		$pdf->SetFont('Arial','',12);
		$pdf->SetY($y_axis_initial);	

		$pdf->SetX(63);
		$pdf->Cell(68,5,'Repport',1,0,'L',1);
		$pdf->Cell(30,5,number_format($total_espece,2,',',' '),1,0,'R',1);
		$pdf->Cell(30,5,number_format($total_cheque,2,',',' '),1,0,'R',1);
		$pdf->Cell(30,5,number_format($total_effet,2,',',' '),1,0,'R',1);
		$pdf->Cell(30,5,number_format($total_virement,2,',',' '),1,0,'R',1);
		$pdf->SetY($y_axis_initial+4);
		$pdf->SetX(5);
		
		$pdf->Cell(23,6,'Date',1,0,'L',1);
		$pdf->Cell(15,6,'Fact',1,0,'L',1);
		$pdf->Cell(20,6,'INPUT',1,0,'L',1);
		$pdf->Cell(68,6,'Designation',1,0,'L',1);
		$pdf->Cell(30,6,'Especes',1,0,'R',1);
		$pdf->Cell(30,6,'Cheques',1,0,'R',1);
		$pdf->Cell(30,6,'Effets',1,0,'R',1);
		$pdf->Cell(30,6,'Virement',1,0,'R',1);
		$pdf->Cell(30,6,'Remise',1,0,'R',1);
		//Go to next row
		$y_axis = 34;

		
		//Set $i variable to 0 (first row)
		$i = 0;
	}
	$client = $row['client'];$client_tire=$row['client_tire'];$date_remise=dateUsToFr($row['date_remise']);
	$date_remise_c = $row['date_remise'];$date_e = $row['date_e'];
	$banque=$row['v_banque'];$facture_n=$row['facture_n'];$date_enc = $row['date_enc'];$date_enc1 = dateUsToFr($row['date_enc']);
	$numero_cheque=$row['numero_cheque'];$date_virement = $row['date_virement'];$date_v = dateUsToFr($row['date_virement']);
	
				/*$sql = "UPDATE porte_feuilles SET ";
			$sql .= "date_remise = '" . $date_enc . "' ";
			$sql .= "WHERE m_espece<>id = " . $id . ";";
			db_query($database_name, $sql);*/


	
	$total_e = 0;
	$total_avoir = $row['total_avoir'];
	$total_diff_prix = 0;
	$sql  = "SELECT * ";
	$sql .= "FROM factures where numero='$facture_n' ORDER BY id;";
	$users1 = db_query($database_name, $sql);$row1 = fetch_array($users1);$dt=dateUsToFr($row1["date_f"]);
	$d=$row1["date_f"];$ff=$row1["numero"];$aout="2010-08-01";
	if ($d<$date1){
	$pdf->SetY($y_axis);
	$pdf->SetX(5);$input="";
	$cheque = $row['total_cheque'];$date_echeance = $row['date_echeance'];
	$espece = $row['total_espece'];	
	$effet = $row['total_effet'];
	$virement = $row['total_virement'];
	if ($date_remise_c>=$date1 and $date_remise_c<=$date2){
		$total_cheque=$total_cheque+$cheque;}else{$cheque=0;}
		
	if ($date_echeance>=$date1 and $date_echeance<=$date2){
	$total_effet=$total_effet+$effet;}else{$effet=0;}
	
	if ($date_virement>=$date1 and $date_virement<=$date2){
	$total_virement=$total_virement+$virement;$date_remise=$date_v;}else{$virement=0;}
	
	if ($date_enc>=$date1 and $date_enc<=$date2){
	$total_espece=$total_espece+$espece;$date_remise=$date_enc1;}else{$espece=0;}
	
		$sql  = "SELECT * ";$imputation="";$patente="";
	$sql .= "FROM clients where client='$client' ORDER BY id;";
	$users111 = db_query($database_name, $sql);$user_ = fetch_array($users111);
		$inputation=$user_["inputation"];$patente=$user_["patente"];
	
	$pdf->Cell(23,6,$dt,1,0,'L',1);
	$pdf->Cell(15,6,$facture_n,1,0,'L',1);
	$pdf->Cell(20,6,$inputation,1,0,'R',1);
	$pdf->Cell(68,6,$client,1,0,'L',1);
	$pdf->Cell(30,6,number_format($espece,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,6,number_format($cheque,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,6,number_format($effet,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,6,number_format($virement,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,6,$date_remise,1,0,'L',1);
	}
	//Go to next row
	$y_axis = $y_axis + $row_height;
	$i = $i + 1;
	}
	$pdf->Ln();	
	$pdf->SetX(131);
	$pdf->Cell(30,5,number_format($total_espece,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($total_cheque,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($total_effet,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($total_virement,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($total_virement+$total_effet+$total_cheque+$total_espece,2,',',' '),1,0,'R',1);
	$pdf->Output();
?>
