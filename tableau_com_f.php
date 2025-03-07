<?php
//PDF USING MULTIPLE PAGES
//CREATED BY: Carlos Vasquez S.
//E-MAIL: cvasquez@cvs.cl
//CVS TECNOLOGIA E INNOVACION
//SANTIAGO, CHILE

require('fpdf.php');
	require "config.php";
	require "connect_db.php";
	require "functions.php";
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
$y_axis_initial = 25;$y_axis = 25;$row_height=7;$l=25;
	$du=$_GET['du'];$au=$_GET['au'];

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(5);
$pdf->SetFont('arial','B',18);
$pdf->Cell(20,6,'M.P.S',1,0,'L',1);

$pdf->SetFont('arial','B',14);
$pdf->SetY(15);$pdf->SetX(15);$t_show="Balance Encaissement / Factures $du au $au ";
$pdf->Cell(0,6,$t_show,1,0,'C',1);
$pdf->SetFont('arial','',10);
$pdf->SetY($y_axis_initial);
$pdf->SetX(2);
$pdf->Cell(50,7,'Vendeur',1,0,'C',1);
$pdf->Cell(22,7,'Factures',1,0,'C',1);
$pdf->Cell(22,7,'En compte',1,0,'C',1);
$pdf->Cell(22,7,'Dif/Prix',1,0,'C',1);
$pdf->Cell(22,7,'Impayes',1,0,'C',1);
$pdf->Cell(22,7,'Espece',1,0,'C',1);
$pdf->Cell(22,7,'Cheque',1,0,'C',1);
$pdf->Cell(22,7,'Effet',1,0,'C',1);
$pdf->Cell(22,7,'Virement',1,0,'C',1);
$pdf->Cell(22,7,'Enc/Impayes',1,0,'C',1);
$pdf->Cell(22,7,'Enc/Encompte',1,0,'C',1);
$pdf->Cell(22,7,'Net Enc',1,0,'C',1);


$y_axis = $y_axis + $row_height;

$te=0;$tc=0;$tf=0;$tv=0;$tev=0;$tav=0;$td=0;$tcc=0;$timp=0;$tencompte=0;$tencimp=0;$tenct=0;$t=0;
		$sql  = "SELECT vendeur,sum(espece) as total_espece,sum(cheque) as total_cheque,sum(effet) as total_effet
		,sum(virement) as total_virement,sum(encaiss_imp) as total_encaiss_imp,sum(evaluations) as total_evaluations,
		sum(encaiss_encompte) as total_encaiss_encompte,sum(avoirs) as total_avoirs,sum(differences) 
		as total_differences,sum(impayes) as total_impayes ";
	$sql .= "FROM journal_commissions Group BY vendeur;";
	$users222 = db_query($database_name, $sql);
	while($row222 = fetch_array($users222))
	{	
		$total_evaluations = $row222['total_evaluations'];$tev=$tev+$total_evaluations;
		$total_espece = $row222['total_espece'];$te=$te+$total_espece;
		$total_avoirs = $row222['total_avoirs'];$tav=$tav+$total_avoirs;
		$total_differences = $row222['total_differences'];$td=$td+$total_differences;
		$total_impayes = $row222['total_impayes'];$timp=$timp+$total_impayes;
		$total_cheque = $row222['total_cheque'];$tc=$tc+$total_cheque;
		$total_effet = $row222['total_effet'];$tf=$tf+$total_effet;
		$total_virement = $row222['total_virement'];$tv=$tv+$total_virement;
		$total_encaiss_encompte = $row222['total_encaiss_encompte'];$tencompte=$tencompte+$total_encaiss_encompte;
		$total_encaiss_imp = $row222['total_encaiss_imp'];$tencimp=$tencimp+$total_encaiss_imp;
		$t=$t+$row222['total_encaiss_encompte'];
		$vendeur=$row222['vendeur'];
		$pdf->SetY($y_axis);$total_evaluations1=number_format($total_evaluations,2,',',' ');
		$tcc=$tcc+($total_evaluations-($total_virement+$total_espece+$total_cheque+$total_effet+$total_avoirs+$total_differences));
			$tencompte=number_format($total_evaluations-($total_virement+$total_espece+$total_cheque+$total_effet+$total_avoirs+$total_differences),2,',',' ');
			$total_avoirs1=number_format($total_avoirs+$total_differences,2,',',' ');
			$total_impayes1=number_format($total_impayes,2,',',' ');$total_espece1=number_format($total_espece,2,',',' ');
			$total_cheque1=number_format($total_cheque,2,',',' ');$total_effet1=number_format($total_effet,2,',',' ');
			$total_virement1=number_format($total_virement,2,',',' ');$total_encaiss_imp1=number_format($total_encaiss_imp,2,',',' ');
			$total_encaiss_encompte1=number_format($total_encaiss_encompte,2,',',' ');
			$tenct=$tenct+$total_virement+$total_espece+$total_cheque+$total_effet+$total_encaiss_encompte+$total_encaiss_imp-$total_avoirs-$total_differences-$total_impayes;
			$tenc=number_format($total_virement+$total_espece+$total_cheque+$total_effet+$total_encaiss_encompte+$total_encaiss_imp-$total_avoirs-$total_differences-$total_impayes,2,',',' ');
		$pdf->SetX(2);
	$pdf->Cell(50,7,$vendeur,1,0,'L',1);
	$pdf->Cell(22,7,$total_evaluations1,1,0,'R',1);
	$pdf->Cell(22,7,$tencompte,1,0,'R',1);
	$pdf->Cell(22,7,$total_avoirs1,1,0,'R',1);
	$pdf->Cell(22,7,$total_impayes1,1,0,'R',1);
	$pdf->Cell(22,7,$total_espece1,1,0,'R',1);
	$pdf->Cell(22,7,$total_cheque1,1,0,'R',1);
	$pdf->Cell(22,7,$total_effet1,1,0,'R',1);
	$pdf->Cell(22,7,$total_virement1,1,0,'R',1);
	$pdf->Cell(22,7,$total_encaiss_imp1,1,0,'R',1);
	$pdf->Cell(22,7,$total_encaiss_encompte1,1,0,'R',1);
	$pdf->Cell(22,7,$tenc,1,0,'R',1);
	
	$y_axis = $y_axis + $row_height;$l=$l+5;
	
	
		
	  } 	
	 $tev1=number_format($tev,2,',',' ');
	 $tcc1=number_format($tcc,2,',',' ');
	 $tav1=number_format($tav+$td,2,',',' ');
	 $timp1=number_format($timp,2,',',' ');
	 $te1=number_format($te,2,',',' ');
	 $tc1=number_format($tc,2,',',' ');
	 $tf1=number_format($tf,2,',',' ');
	 $tv1=number_format($tv,2,',',' ');
	 $tencimp1=number_format($tencimp,2,',',' ');
	 $tencompte1=number_format($t,2,',',' ');
	 $tenc1=number_format($tenct,2,',',' ');
	 
	 $pdf->SetY($y_axis);
	 $pdf->SetX(2);
	$pdf->Cell(50,7,'',1,0,'L',1);
	$pdf->Cell(22,7,$tev1,1,0,'R',1);
	$pdf->Cell(22,7,$tcc1,1,0,'R',1);
	$pdf->Cell(22,7,$tav1,1,0,'R',1);
	$pdf->Cell(22,7,$timp1,1,0,'R',1);
	$pdf->Cell(22,7,$te1,1,0,'R',1);
	$pdf->Cell(22,7,$tc1,1,0,'R',1);
	$pdf->Cell(22,7,$tf1,1,0,'R',1);
	$pdf->Cell(22,7,$tv1,1,0,'R',1);
	$pdf->Cell(22,7,$tencimp1,1,0,'R',1);
	$pdf->Cell(22,7,$tencompte1,1,0,'R',1);
	$pdf->Cell(22,7,$tenc1,1,0,'R',1);
	 
			
$pdf->SetY($y_axis+10);

$pdf->SetFont('arial','B',14);
$pdf->SetX(15);$t_show="Details Encaissement sur En compte / Factures $du au $au ";
$pdf->Cell(0,6,$t_show,1,0,'C',1);
$pdf->SetFont('arial','',10);
$pdf->SetY($y_axis+20);
$pdf->SetX(2);
$pdf->Cell(50,7,'Vendeur',1,0,'C',1);
$pdf->Cell(25,7,'Espece',1,0,'C',1);
$pdf->Cell(25,7,'Cheque',1,0,'C',1);
$pdf->Cell(25,7,'Effet',1,0,'C',1);
$pdf->Cell(25,7,'Total Encompte',1,0,'C',1);			

$y_axis=$y_axis+25;

	 
	 $te=0;$tc=0;$tf=0;$tv=0;$tev=0;$tav=0;$td=0;$tcc=0;$timp=0;$tencompte=0;$tencimp=0;$tenct=0;$t=0;
		$sql  = "SELECT vendeur,sum(encompte_espece) as total_espece,sum(encompte_cheque) as total_cheque,
		sum(encompte_effet) as total_effet
		,sum(virement) as total_virement,sum(encaiss_imp) as total_encaiss_imp,sum(evaluations) as total_evaluations,
		sum(encaiss_encompte) as total_encaiss_encompte,sum(avoirs) as total_avoirs,sum(differences) 
		as total_differences,sum(impayes) as total_impayes ";
	$sql .= "FROM journal_commissions Group BY vendeur;";
	$users2222 = db_query($database_name, $sql);
	while($row2222 = fetch_array($users2222))
	{	
		$total_espece = $row2222['total_espece'];$te=$te+$total_espece;
		$total_cheque = $row2222['total_cheque'];$tc=$tc+$total_cheque;
		$total_effet = $row2222['total_effet'];$tf=$tf+$total_effet;
		$total_espece1=number_format($total_espece,2,',',' ');
		$total_cheque1=number_format($total_cheque,2,',',' ');
		$total_effet1=number_format($total_effet,2,',',' ');
		$vendeur=$row2222['vendeur'];$tenc=number_format($total_espece+$total_cheque+$total_effet,2,',',' ');
			$tenct=$tenct+$total_espece+$total_cheque+$total_effet;
		$pdf->SetY($y_axis);
		$pdf->SetX(2);
		$pdf->Cell(50,7,$vendeur,1,0,'L',1);
		$pdf->Cell(25,7,$total_espece1,1,0,'R',1);
		$pdf->Cell(25,7,$total_cheque1,1,0,'R',1);
		$pdf->Cell(25,7,$total_effet1,1,0,'R',1);
		$pdf->Cell(25,7,$tenc,1,0,'R',1);
		$y_axis = $y_axis + $row_height;
		
	  }	
	 
		$pdf->SetY($y_axis);
		$pdf->SetX(2);$te1=number_format($te,2,',',' ');$tc1=number_format($tc,2,',',' ');$tf1=number_format($tf,2,',',' ');$tenc1=number_format($tenct,2,',',' ');
		$pdf->Cell(50,7,'',1,0,'L',1);
		$pdf->Cell(25,7,$te1,1,0,'R',1);
		$pdf->Cell(25,7,$tc1,1,0,'R',1);
		$pdf->Cell(25,7,$tf1,1,0,'R',1);
		$pdf->Cell(25,7,$tenc1,1,0,'R',1);
		
	 
	 
	 

	
	
$pdf->Output();
?>
