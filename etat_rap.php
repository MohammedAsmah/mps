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
$du="2014-02-01";$au="2014-02-28";
//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page

	$date_tirage=$_GET['date_tirage'];$banque=$_GET['banque'];$id=$_GET['id'];$date_dernier_mvt=$_GET['date_dernier_mvt'];
	$total_e=0;$total_c=0;$total_t=0;

	//initialize counter
$i = 0;
//Set maximum rows per page
$max = 30;
$y_axis_initial = 20;$y_axis = 20;$row_height=6;$l=25;
$pdf->SetLineWidth(0.2);$pdf->SetDrawColor(180);	
//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(2);
$pdf->SetFont('arial','',10);
$pdf->SetX(2);
$pdf->Cell(20,6,'M.P.S',0,0,'L',0);
$pdf->SetY(9);
$pdf->SetX(2);$d="Date Tirage : ".dateUsToFr($date_tirage);
$pdf->Cell(60,6,$d,0,0,'L',0);
$pdf->SetY(13);
$pdf->SetX(2);$d="Banque : ".$banque;
$pdf->Cell(60,6,$d,0,0,'L',0);
$pdf->SetFont('arial','',12);
$pdf->SetY(3);$t_show="ETAT DE RAPPROCHEMENT BANCAIRE ";
$pdf->SetX(130);
$pdf->Cell(0,6,$t_show,0,0,'L',0);
$pdf->SetY(8);$t_show="AUTORISATION : 1 600 000,00 ";
$pdf->SetX(130);
$pdf->Cell(0,6,$t_show,0,0,'L',0);
$pdf->SetFont('arial','',10);
$pdf->SetY($y_axis_initial);
$pdf->SetX(2);
$pdf->Cell(154,8,'BANQUE POPULAIRE',1,0,'C',1);
$pdf->Cell(139,8,'MOULAGE PLASTIQUE DU SUD',1,0,'C',1);

$pdf->SetY($y_axis_initial+9);
$pdf->SetX(2);

$pdf->Cell(17,8,'Date',0,0,'C',1);
$pdf->Cell(70,8,'Libelle',0,0,'C',1);
$pdf->Cell(22,8,'Debit',0,0,'C',1);
$pdf->Cell(22,8,'Credit',0,0,'C',1);
$pdf->Cell(22,8,'Solde',0,0,'C',1);

$y_axis = $y_axis + $row_height;


// solde banque
		$sql  = "SELECT * ";
		$sql .= "FROM etats_rapprochements WHERE id = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "";
		$banque=$user_["banque"];
		$debit=$user_["debit"];$date_dernier_mvt=dateUsToFr($user_["date_dernier_mvt"]);$date_tirage=dateUsToFr($user_["date_tirage"]);
		$credit=$user_["credit"];
		$date_dernier_mvt_mps=dateUsToFr($user_["date_dernier_mvt_mps"]);$debit_mps=$user_["debit_mps"];$credit_mps=$user_["credit_mps"];
		$debit_mps_f=number_format($debit_mps,2,',',' ');
		$credit_mps_f=number_format($credit_mps,2,',',' ');
		if ($debit_mps==0){$debit_mps_f="";}
		if ($credit_mps==0){$credit_mps_f="";}
		
		$debit_sbp=$user_["debit"];
		$credit_sbp=$user_["credit"];
		if ($debit>0){$debit1=number_format($debit,2,',',' ');}
		if ($credit>0){$credit1=number_format($credit,2,',',' ');}
	$pdf->SetY($y_axis+12);$s="";
	$pdf->SetX(2);
	$pdf->SetFont('arial','',8);
	$pdf->Cell(17,4,$s,0,0,'L',0);
	
	$solde_jour="Solde au ".$date_dernier_mvt;
	$pdf->Cell(70,4,$solde_jour,0,0,'L',0);
	$pdf->Cell(22,4,$debit1,0,0,'R',0);
	$pdf->Cell(22,4,$credit1,0,0,'R',0);
	$pdf->Cell(22,4,$s,0,0,'L',0);
$y_axis=$y_axis+8;


///banque debit

		$sql  = "SELECT * ";
	$sql .= "FROM journal_banques where caisse='$banque' and non_pris = 1 and credit>0 and erreur=0 Order BY date;";
$users11 = db_query($database_name, $sql);



//Set Row Height
$row_height = 4;$t_espece=0;$debit_bp=0;
	$credit_bp=0;
/*while($row = mysql_fetch_array($result))*/
while($row = fetch_array($users11))
{
	//If the current row is the last one, create new page and print column title
	if ($i >= $max)
	{
		$pdf->AddPage();

		////////////////////////////////////////
		////////////////////////////////////////
		$y_axis_initial = 20;$y_axis = 20;$row_height=6;$l=25;
$pdf->SetLineWidth(0.2);$pdf->SetDrawColor(180);	
//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(2);
$pdf->SetFont('arial','',10);
$pdf->SetX(2);
$pdf->Cell(20,6,'M.P.S',0,0,'L',0);
$pdf->SetY(9);
$pdf->SetX(2);$d="Date Tirage : ".dateUsToFr($date_tirage);
$pdf->Cell(60,6,$d,0,0,'L',0);
$pdf->SetY(13);
$pdf->SetX(2);$d="Banque : ".$banque;
$pdf->Cell(60,6,$d,0,0,'L',0);
$pdf->SetFont('arial','',12);
$pdf->SetY(3);$t_show="ETAT DE RAPPROCHEMENT BANCAIRE ";
$pdf->SetX(130);
$pdf->Cell(0,6,$t_show,0,0,'L',0);
$pdf->SetY(8);$t_show="AUTORISATION : 1 600 000,00 ";
$pdf->SetX(130);
$pdf->Cell(0,6,$t_show,0,0,'L',0);
$pdf->SetFont('arial','',10);
$pdf->SetY($y_axis_initial);
$pdf->SetX(2);
$pdf->Cell(154,8,'BANQUE POPULAIRE',1,0,'C',1);
$pdf->Cell(139,8,'MOULAGE PLASTIQUE DU SUD',1,0,'C',1);

$pdf->SetY($y_axis_initial+9);
$pdf->SetX(2);

$pdf->Cell(17,8,'Date',0,0,'C',1);
$pdf->Cell(70,8,'Libelle',0,0,'C',1);
$pdf->Cell(22,8,'Debit',0,0,'C',1);
$pdf->Cell(22,8,'Credit',0,0,'C',1);
$pdf->Cell(22,8,'Solde',0,0,'C',1);

$y_axis = $y_axis + $row_height;
$i = 0;
		
		////////////////////////////////////////
		////////////////////////////////////////
		
		
	}

	$date = dateUsToFr($row['date']);
	$libelle = $row['libelle'];
	$debit_bp=$debit_bp+$row['credit'];
	$credit_bp=$credit_bp+$row['debit'];
	$debit = number_format($row['credit'],2,',',' ');
	$credit = number_format($row['debit'],2,',',' ');
	
	
	
	
	
	if ($debit=="0,00"){$debit="";}
	if ($credit=="0,00"){$credit="";}
	$pdf->SetY($y_axis+11);$s="";
	$pdf->SetX(2);
	$pdf->SetFont('arial','',6.5);
	$pdf->Cell(17,3,$date,0,0,'L',0);
	$pdf->Cell(70,3,$libelle,0,0,'L',0);
	$pdf->Cell(22,3,$debit,0,0,'R',0);
	$pdf->Cell(22,3,$credit,0,0,'R',0);
	$pdf->Cell(22,3,$s,0,0,'L',0);
	

	//Go to next row
	$y_axis = $y_axis + $row_height;$l=$l+5;
	$i = $i + 1;
	}
	
	
	
//// credit banque



$sql  = "SELECT type,date,sum(debit) as debit ";
	$sql .= "FROM journal_banques where caisse='$banque' and non_pris = 1 and debit>0 and erreur=0 group by id Order BY date;";
$users111 = db_query($database_name, $sql);	


	
	$y_axis=$y_axis+35;


	
	while($row = fetch_array($users111))
{
	//If the current row is the last one, create new page and print column title
	if ($i >= $max)
	{
		$pdf->AddPage();
		
	}

	$date = dateUsToFr($row['date']);
	$type = $row['type'];
	$debit = number_format($row['credit'],2,',',' ');
	$credit = number_format($row['debit'],2,',',' ');
	if ($debit=="0,00"){$debit="";}
	if ($credit=="0,00"){$credit="";}
	$pdf->SetY($y_axis);$s="";
	$pdf->SetX(2);
	$pdf->Cell(17,4,$date,0,0,'L',1);
	$pdf->Cell(70,4,$type,0,0,'L',1);
	$pdf->Cell(22,4,$debit,0,0,'R',1);
	$pdf->Cell(22,4,$credit,0,0,'R',1);
	$pdf->Cell(22,4,$s,0,0,'R',1);
	$t_credit_non_pris  = $t_credit_non_pris+$row['debit'];

	//Go to next row
	//$y_axis = $y_axis + 4;$l=$l+5;
	$i = $i + 1;
	}
	
	$debit_bp_f = number_format($debit_bp+$debit_sbp,2,',',' ');
	$credit_bp_f = number_format($credit_bp+$credit_sbp+$t_credit_non_pris,2,',',' ');
	$t_debit=$debit_bp+$debit_sbp;
	$t_credit=$credit_bp+$credit_sbp+$t_credit_non_pris;
	
	if (($debit_bp+$debit_sbp)-($credit_bp+$credit_sbp+$t_credit_non_pris)>0){$titre="D";}else{$titre="C";}
	$solde_bp=$t_debit-$t_credit;
	if ($solde_bp<0){$solde_bp=$solde_bp*-1;}
	$solde_bp_f=number_format($solde_bp,2,',',' ');
	
	//banque mps
	$pdf->SetY(29);$y_axis_mps=100;
	$pdf->SetX(156);
	$pdf->Cell(79,8,'Libelle',0,0,'C',1);
	$pdf->Cell(20,8,'Debit',0,0,'C',1);
	$pdf->Cell(20,8,'Credit',0,0,'C',1);
	$pdf->Cell(20,8,'Solde',0,0,'C',1);
	
	//bp
	$pdf->Line(2, 29, 2, $y_axis_mps);
	$pdf->Line(19, 29, 19, $y_axis_mps);
	$pdf->Line(90, 29, 90, $y_axis_mps);
	$pdf->Line(112, 29, 112, $y_axis_mps);
	$pdf->Line(134, 29, 134, $y_axis_mps);
	$pdf->Line(2, 29, 295, 29);//horisontal
	$pdf->Line(2, 37, 295, 37);//horisontal
		
	$pdf->Line(156, 29, 156, $y_axis_mps);
	$pdf->Line(295, 29, 295, $y_axis_mps);
	$pdf->Line(2, $y_axis_mps, 295, $y_axis_mps);//horisontal total
	$pdf->Line(2, $y_axis_mps+8, 295, $y_axis_mps+8);//horisontal total
	$pdf->Line(2, $y_axis_mps, 2, $y_axis_mps+8);
	$pdf->Line(295, $y_axis_mps, 295, $y_axis_mps+8);
	$pdf->SetY($y_axis_mps+1);
	$pdf->SetX(2);
	$pdf->Cell(17,6,$s,0,0,'C',1);
	$pdf->Cell(70,6,'TOTAL',0,0,'C',1);
	$pdf->Cell(22,6,$debit_bp_f,0,0,'R',1);
	$pdf->Cell(22,6,$credit_bp_f,0,0,'R',1);
	$pdf->Cell(22,6,$solde_bp_f,0,0,'R',1);
	$pdf->SetY($y_axis_mps+4);
	$pdf->SetX(134);
	$pdf->Cell(2,6,$titre,0,0,'L',1);
	$pdf->Line(2, $y_axis_mps, 2, $y_axis_mps+8);
	$pdf->Line(19, $y_axis_mps, 19, $y_axis_mps+8);
	$pdf->Line(90, $y_axis_mps, 90, $y_axis_mps+8);
	$pdf->Line(112, $y_axis_mps, 112, $y_axis_mps+8);
	$pdf->Line(134, $y_axis_mps, 134, $y_axis_mps+8);
	$pdf->Line(156, $y_axis_mps, 156, $y_axis_mps+8);
	
	
	
	
	//mps
	$y_axis_mps=39;
	$pdf->SetY($y_axis_mps);$s="";
	$pdf->SetX(162);
	$pdf->SetFont('arial','',8);
	$solde_jour="Solde au ".$date_dernier_mvt_mps;
	$pdf->Cell(70,4,$solde_jour,0,0,'L',0);
	$pdf->Cell(22,4,$debit_mps_f,0,0,'R',0);
	$pdf->Cell(22,4,$credit_mps_f,0,0,'R',0);
	$pdf->Cell(22,4,$s,0,0,'L',0);
	$pdf->SetFont('arial','',8);
	$sql  = "SELECT * ";$t_sur_historique_debit=0;$t_sur_historique_credit=0;
	$sql .= "FROM journal_banques where caisse='$banque' and sur_historique = 1 Order BY date;";
	$users1111 = db_query($database_name, $sql);

	$y_axis_mps=45;	
		while($row = fetch_array($users1111))
	{
	//If the current row is the last one, create new page and print column title
	if ($i >= $max)
	{
		$pdf->AddPage();
		
	}
	$pdf->SetFont('arial','',6.5);
	$date = dateUsToFr($row['date']);
	$libelle = $row['libelle'];
	$debit = number_format($row['debit'],2,',',' ');
	$credit = number_format($row['credit'],2,',',' ');
	if ($debit=="0,00"){$debit="";}
	if ($credit=="0,00"){$credit="";}
	$pdf->SetY($y_axis_mps);$s="";
	$pdf->SetX(157);
	$pdf->Cell(78,4,$libelle,0,0,'L',1);
	$pdf->Cell(20,4,$debit,0,0,'R',1);
	$pdf->Cell(20,4,$credit,0,0,'R',1);
	
	$t_sur_historique_credit  = $t_sur_historique_credit+$row['credit'];
	$t_sur_historique_debit  = $t_sur_historique_debit+$row['debit'];
	//Go to next row
	$y_axis_mps = $y_axis_mps + $row_height;$l=$l+5;
	$i = $i + 1;
	}
	
	
	
	
	$t_credit_mps = number_format($t_sur_historique_credit+$credit_mps,2,',',' ');
	$t_debit_mps = number_format($t_sur_historique_debit+$debit_mps,2,',',' ');
	$t_solde_mps = ($t_sur_historique_debit+$debit_mps)-($t_sur_historique+$credit_mps);
	if ($t_solde_mps<0){$titre="C";$t_solde_mps=number_format($t_solde_mps*-1,2,',',' ');}else{$titre="D";$t_solde_mps=number_format($t_solde_mps,2,',',' ');}
	
	$pdf->SetY($y_axis+1);
	$pdf->SetX(235);
	$pdf->Cell(20,6,$t_debit_mps,0,0,'R',1);
	$pdf->Cell(20,6,$t_credit_mps,0,0,'R',1);
	$pdf->Cell(20,6,$t_solde_mps,0,0,'R',1);
	$pdf->SetY($y_axis+4);
	$pdf->SetX(275);
	$pdf->Cell(2,6,$titre,0,0,'L',1);
	
	
	//colones mps
	$pdf->Line(236, 29, 236, $y_axis+8);
	$pdf->Line(256, 29, 256, $y_axis+8);
	$pdf->Line(276, 29, 276, $y_axis+8);
	
	//cumuls
	$pdf->SetFont('arial','',7.5);
	$y_axis=$y_axis+16;$solde_cumule=0;
	
	$sql  = "SELECT type,caisse,date,debit,credit,sum(debit) As total_debit,sum(credit) As total_credit ";
	$sql .= "FROM journal_banques where date between '$du' and '$au' and caisse='$banque' and debit>0 and erreur=0 GROUP BY type order by total_debit DESC;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) { 
	$type=$users_["type"];
	$total_debit=number_format($users_["total_debit"],2,',',' ');
	$solde_cumule=$solde_cumule+$users_["total_debit"];
	$pdf->SetY($y_axis+1);
	$pdf->SetX(160);
	$pdf->Cell(70,6,$type,0,0,'L',1);
	$pdf->Cell(22,6,$total_debit,0,0,'R',1);
	$y_axis=$y_axis+4;
	
	}
	$y_axis=$y_axis+4;
	$pdf->SetY($y_axis+1);
	$pdf->SetX(160);
	$pdf->Cell(70,6,'TOTAL',0,0,'L',1);
	$pdf->Cell(22,6,number_format($solde_cumule,2,',',' '),0,0,'R',1);
	
	//impayes
	$y_axis=$y_axis+10;$solde_cumule_impayes=0;
	$impayes="IMPAYES";
	$sql  = "SELECT type,caisse,date,debit,credit,sum(debit) As total_debit,sum(credit) As total_credit ";
	$sql .= "FROM journal_banques where date between '$du' and '$au' and caisse='$banque' and type = '$impayes' and erreur=0 GROUP BY type;";
	$users1 = db_query($database_name, $sql);
	while($users_1 = fetch_array($users1)) { 
	$type=$users_1["type"];
	$total_credit=number_format($users_1["total_credit"],2,',',' ');
	$solde_cumule_impayes=$solde_cumule_impayes+$users_1["total_credit"];
	}
	$y_axis=$y_axis+1;
	$pdf->SetY($y_axis+1);
	$pdf->SetX(160);
	$pdf->Cell(70,6,'TOTAL DES IMPAYES',0,0,'L',1);
	$pdf->Cell(22,6,number_format($solde_cumule_impayes,2,',',' '),0,0,'R',1);
	
//Create file
$pdf->Output();
?>
