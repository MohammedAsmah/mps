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
	
	$error_message = "";$caisse="";$action="Recherche";$date="";$date1="";$du="";$au="";
				$sql = "TRUNCATE TABLE `journal_commissions_vendeurs`  ;";
			db_query($database_name, $sql);
	
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
		$sql .= "FROM porte_feuilles_factures where 
		(date_remise between '$date1' and '$date2' and facture_n<>0 and remise=1 and id_registre_regl<>0) 
		or (date_echeance between '$date1' and '$date2' and facture_n<>0 and m_effet<>0 and m_cheque=0 and id_registre_regl<>0)   
		
		or (date_virement between '$date1' and '$date2' and facture_n<>0 and m_virement<>0 and id_registre_regl<>0)
		or (date_enc between '$date1' and '$date2' and facture_n<>0 and m_espece<>0)
		Group BY id order by facture_n;";
		
		
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
	$date_remise_c = $row['date_remise'];$date_e = $row['date_e'];$vendeur = $row['vendeur'];
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
	
	
	
	///insertion
				$sql  = "INSERT INTO journal_commissions_vendeurs ( vendeur,cheque_encompte,espece_encompte,effet_encompte,virement_encompte,facture ) VALUES ( ";
				$sql .= "'".$vendeur . "',";
				$sql .= "'".$cheque . "',";
				$sql .= "'".$espece . "',";
				$sql .= "'".$effet . "',";
				$sql .= "'".$virement . "',";
				$sql .= "'".$facture_n . "');";
				db_query($database_name, $sql);		
	
	
	
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
	
	////////
	

	$pdf->AddPage();

		
$pdf->SetY(15);$t_show="COMMISSIONS VENDEURS SUR ENCOMPTE DU MOIS  : ".dateUsToFr($date1)."   ".dateUsToFr($date2);
$pdf->SetX(80);
$pdf->Cell(170,6,$t_show,1,0,'C',1);
$pdf->SetY($y_axis_initial);
$pdf->SetX(5);
$pdf->Cell(70,8,'Vendeur',1,0,'C',1);
$pdf->Cell(30,8,'Especes',1,0,'C',1);
$pdf->Cell(30,8,'Cheques',1,0,'C',1);
$pdf->Cell(30,8,'Effets',1,0,'C',1);
$pdf->Cell(30,8,'Virmt',1,0,'C',1);
$pdf->Cell(30,8,'Total',1,0,'C',1);	

$y_axis = $y_axis_initial + $row_height;

	$sql  = "SELECT vendeur,sum(cheque_encompte) as total_cheque,sum(espece_encompte) as total_espece, sum(effet_encompte) as total_effet,sum(virement_encompte) as total_virement ";
		$sql .= "FROM journal_commissions_vendeurs Group BY vendeur ;";
	$users13 = db_query($database_name, $sql);


$i = 0;


$max = 28;


$row_height = 6;$t_cheque=0;$ca=0;$htva_t=0;$tva_t=0;$ttc_t=0;$espece=0;$cheque=0;$effet=0;$tmt_t=0;$t_espece=0;
	$t_cheque_t = 0;
	$t_espece_t = 0;
	$t_effet_t = 0;$t_virement_t = 0;


while($row13 = fetch_array($users13))
{

	$vendeur = $row13['vendeur'];$total_espece=$row13['total_espece'];$total_cheque=$row13['total_cheque'];$total_effet=$row13['total_effet'];$total_virement=$row13['total_virement'];
	$pdf->SetY($y_axis);
	$pdf->SetX(5);
	$pdf->Cell(70,5,$vendeur,1,0,'L',1);
	$pdf->Cell(30,5,number_format($total_espece,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($total_cheque,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($total_effet,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($total_virement,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($total_virement+$total_espece+$total_cheque+$total_effet,2,',',' '),1,0,'R',1);
	$t_espece_t=$t_espece_t+$total_espece;
	$t_cheque_t=$t_cheque_t+$total_cheque;
	$t_effet_t=$t_effet_t+$total_effet;
	$t_virement_t=$t_virement_t+$total_virement;
	$y_axis = $y_axis + $row_height;
	$i = $i + 1;
}
	$pdf->Ln();	
	$pdf->SetX(75);
	$pdf->Cell(30,5,number_format($t_espece_t,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($t_cheque_t,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($t_effet_t,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($t_virement_t,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($t_virement_t+$t_effet_t+$t_cheque_t+$t_espece_t,2,',',' '),1,0,'R',1);
	
	
	
	//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;
	$date1=$_GET['date1'];$total_e=0;$total_c=0;$total_t=0;
	$a="A";$date2=$_GET['date2'];

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(5);
$pdf->SetFont('Arial','B',18);
$pdf->Cell(20,6,'M.P.S',1,0,'L',1);
$pdf->SetX(260);$d=date("d/m/Y");
$pdf->Cell(34,6,$d,1,0,'L',1);
$pdf->SetFont('Arial','B',14);
$pdf->SetY(15);$t_show="FACTURATION DU MOIS  : ".dateUsToFr($date1)."   ".dateUsToFr($date2);
$pdf->SetX(80);
$pdf->Cell(150,6,$t_show,1,0,'C',1);
$pdf->SetFont('Arial','B',12);
$pdf->SetY($y_axis_initial);
$pdf->SetX(5);
$pdf->Cell(23,8,'Date',1,0,'C',1);
$pdf->Cell(13,8,'Fact',1,0,'C',1);
$pdf->Cell(20,8,'INPUT',1,0,'C',1);
$pdf->Cell(60,8,'Designation',1,0,'C',1);
$pdf->Cell(27,8,'HTVA',1,0,'C',1);
$pdf->Cell(23,8,'TVA',1,0,'C',1);
$pdf->Cell(27,8,'TTC',1,0,'C',1);
$pdf->Cell(24,8,'Especes',1,0,'C',1);
$pdf->Cell(24,8,'Cheques',1,0,'C',1);
$pdf->Cell(24,8,'Effets',1,0,'C',1);
$pdf->Cell(24,8,'Virmt',1,0,'C',1);
$y_axis = $y_axis + $row_height;

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select Code,Name,Price from Products ORDER BY Code',$link);*/
	$sql  = "SELECT * ";
	$sql .= "FROM factures where (date_f between '$date1' and '$date2') and montant>0 ORDER BY id;";
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
$pdf->SetY(15);$t_show="FACTURATION DU MOIS  : ".dateUsToFr($date1)."   ".dateUsToFr($date2);
$pdf->SetX(80);
$pdf->Cell(150,6,$t_show,1,0,'C',1);
$pdf->SetY($y_axis_initial);
$pdf->SetX(5);
$pdf->Cell(23,8,'Date',1,0,'C',1);
$pdf->Cell(13,8,'Fact',1,0,'C',1);
$pdf->Cell(20,8,'INPUT',1,0,'C',1);
$pdf->Cell(60,8,'Designation',1,0,'C',1);
$pdf->Cell(27,8,'HTVA',1,0,'C',1);
$pdf->Cell(23,8,'TVA',1,0,'C',1);
$pdf->Cell(27,8,'TTC',1,0,'C',1);
$pdf->Cell(24,8,'Especes',1,0,'C',1);
$pdf->Cell(24,8,'Cheques',1,0,'C',1);
$pdf->Cell(24,8,'Effets',1,0,'C',1);
$pdf->Cell(24,8,'Virmt',1,0,'C',1);
		//Go to next row
		$y_axis = 34;
		
		//Set $i variable to 0 (first row)
		$i = 0;
	}

	$numero = $row['id']+9040;$htt=$row["ht"];
	$client=$row["client"];$id=$row["id"];$f=$row["numero"];$d=$row["date_f"];$client_se=Trim($client);$vendeur=$row["vendeur"];
	$evaluation=$row["evaluation"]; $client=$row["client"];$user_id=$row["id"];$facture=$row["id"]+9040;	$total_e = 0;
	$total_avoir = 0;$date=date(dateUsToFr($row["date_f"]));$d=dateUsToFr($row["date_f"]);
	$total_diff_prix = 0;
	$total_cheque = 0;
	$total_espece = 0;
	$total_effet = 0;
	$total_virement = 0;
	
	$sql  = "SELECT * ";
	$sql .= "FROM clients where client='$client' ORDER BY id;";
	$users111 = db_query($database_name, $sql);$user_ = fetch_array($users111);
		$inputation=$user_["inputation"];$patente=$user_["patente"];

	
	
	$ca=$ca+$row["montant"];if ($htt){$ht=number_format($row["montant"],2,',',' ');$htax=$row["montant"];$mtva=0;$tva=number_format(0,2,',',' ');}
	else{$ht=number_format($row["montant"]/1.2,2,',',' ');$htax=$row["montant"]/1.2;$mtva=$row["montant"]/1.2*0.20;$tva=number_format($row["montant"]/1.2*0.20,2,',',' ');}
	
	$ttc=number_format($row["montant"],2,',',' ');
	$ttc=number_format($row["montant"],2,',',' ');
	$pdf->SetY($y_axis);
	$pdf->SetX(5);$input="";
	$pdf->Cell(23,6,$date,1,0,'L',1);
	$pdf->Cell(13,6,$numero,1,0,'L',1);
	$pdf->Cell(20,6,$inputation,1,0,'R',1);
	$pdf->Cell(60,6,$client,1,0,'L',1);
	$pdf->Cell(27,6,$ht,1,0,'R',1);
	$pdf->Cell(23,6,$tva,1,0,'R',1);
	$pdf->Cell(27,6,$ttc,1,0,'R',1);
	/*$pdf->Cell(27,6,$ttc,1,0,'R',1);*/
	/*	if ($htt){$htva_t=$htva_t+$row["montant"]/1.2;
		$tva_t=$tva_t+$row["montant"]/1.2*0.20; }else
		{$htva_t=$htva_t+$row["montant"];
		$tva_t=$tva_t+$row["montant"]; }*/
		
		$htva_t=$htva_t+$htax;
		$tva_t=$tva_t+$mtva;
		$ttc_t=$ttc_t+$row["montant"];
		$tmt_t=$tmt_t+$row["montant"];
		
///cheques		
		
		$sql  = "SELECT numero_cheque,facture_n,client,client_tire,v_banque,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece
		, sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
		$sql .= "FROM porte_feuilles_factures where m_cheque<>0 and remise=1 and facture_n='$facture' and (date_remise between '$date1' and '$date2') Group BY facture_n;";
		$users11 = db_query($database_name, $sql);
		$t_cheque=0;
while($row = fetch_array($users11))
{
	$client = $row['client'];$client_tire=$row['client_tire'];
	$banque=$row['v_banque'];$facture_n=$row['facture_n'];
	$numero_cheque=$row['numero_cheque'];
	$total_e = 0;
	$total_avoir = $row['total_avoir'];
	$total_diff_prix = 0;
	$total_cheque = $row['total_cheque'];
	$t_cheque=$t_cheque+$total_cheque;
	$t_cheque_t=$t_cheque_t+$total_cheque;
}
/////fincheques

//effet
		$sql  = "SELECT remise,numero_cheque,facture_n,client,client_tire,v_banque,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece
		, sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
		$sql .= "FROM porte_feuilles_factures where m_effet<>0 and facture_n='$facture' and (date_enc between '$date1' and '$date2') Group BY facture_n;";
		$users11 = db_query($database_name, $sql);
		$t_effet=0;
while($row = fetch_array($users11))
{
	$client = $row['client'];$client_tire=$row['client_tire'];
	$banque=$row['v_banque'];$facture_n=$row['facture_n'];
	$numero_cheque=$row['numero_cheque'];
	$total_e = 0;
	$total_avoir = $row['total_avoir'];
	$total_diff_prix = 0;
	$total_effet = $row['total_effet'];
	$t_effet=$t_effet+$total_effet;
	$t_effet_t=$t_effet_t+$total_effet;
}
///fin effet

//virment
		$sql  = "SELECT remise,numero_cheque,facture_n,client,client_tire,v_banque,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece
		, sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
		$sql .= "FROM porte_feuilles_factures where m_virement<>0 and facture_n='$facture' and (date_enc between '$date1' and '$date2') Group BY facture_n;";
		$users11 = db_query($database_name, $sql);
		$t_virement=0;
while($row = fetch_array($users11))
{
	$client = $row['client'];$client_tire=$row['client_tire'];
	$banque=$row['v_banque'];$facture_n=$row['facture_n'];
	$numero_cheque=$row['numero_cheque'];
	$total_e = 0;
	$total_avoir = $row['total_avoir'];
	$total_diff_prix = 0;
	/*$total_cheque = $row['total_cheque'];*/
	/*$total_effet = $row['total_effet'];*/
	$total_virement = $row['total_virement'];
	/*$t_cheque=$t_cheque+$total_cheque;*/
	/*$total_effet=$total_effet+$total_effet;*/
	/*$t_cheque_t=$t_cheque_t+$total_cheque;*/
	/*$total_effet_t=$total_effet_t+$total_effet;*/
	$t_virement=$t_virement+$total_virement;
	$t_virement_t=$t_virement_t+$total_virement;
}
///fin virment

		$sql  = "SELECT numero_cheque,facture_n,client,client_tire,v_banque,m_espece,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece
		, sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
		$sql .= "FROM porte_feuilles_factures where facture_n='$facture' and m_espece>0 and date_enc between '$date1' and '$date2' Group BY facture_n;";
		$users11 = db_query($database_name, $sql);
		$t_espece=0;
while($row = fetch_array($users11))
{
	$client = $row['client'];$client_tire=$row['client_tire'];
	$banque=$row['v_banque'];$facture_n=$row['facture_n'];
	$numero_cheque=$row['numero_cheque'];
	$total_e = 0;
	$total_avoir = $row['total_avoir'];
	$total_diff_prix = 0;
	$total_espece = $row['total_espece'];
	/*$total_espece=$total_espece+$total_espece;*/
	$t_espece=$t_espece+$total_espece;
	$t_espece_t=$t_espece_t+$total_espece;
}

	$pdf->Cell(24,6,number_format($total_espece,2,',',' '),1,0,'R',1);
	$pdf->Cell(24,6,number_format($total_cheque,2,',',' '),1,0,'R',1);
	$pdf->Cell(24,6,number_format($total_effet,2,',',' '),1,0,'R',1);
	$pdf->Cell(24,6,number_format($total_virement,2,',',' '),1,0,'R',1);
	//Go to next row
	$y_axis = $y_axis + $row_height;
	$i = $i + 1;
	
					
					
					
	///insertion
				$sql  = "INSERT INTO journal_commissions_vendeurs ( vendeur,cheque,espece,effet,virement,facture ) VALUES ( ";
				$sql .= "'".$vendeur . "',";
				$sql .= "'".$total_cheque . "',";
				$sql .= "'".$total_espece . "',";
				$sql .= "'".$total_effet . "',";
				$sql .= "'".$total_virement . "',";
				$sql .= "'".$facture . "');";
				db_query($database_name, $sql);				
	
}
	$pdf->Ln();	
	$pdf->SetX(121);
	$pdf->Cell(27,5,number_format($htva_t,2,',',' '),1,0,'R',1);
	$pdf->Cell(23,5,number_format($tva_t,2,',',' '),1,0,'R',1);
	$pdf->Cell(27,5,number_format($ttc_t,2,',',' '),1,0,'R',1);
	$pdf->Cell(24,5,number_format($t_espece_t,2,',',' '),1,0,'R',1);
	$pdf->Cell(24,5,number_format($t_cheque_t,2,',',' '),1,0,'R',1);
	$pdf->Cell(24,5,number_format($t_effet_t,2,',',' '),1,0,'R',1);
	$pdf->Cell(24,5,number_format($t_virement_t,2,',',' '),1,0,'R',1);
	$pdf->Ln();	
	$pdf->SetX(198);
	$pdf->Cell(96,5,number_format($t_espece_t+$t_cheque_t+$t_effet_t+$t_virement_t,2,',',' '),1,0,'C',1);
	
	////////
	

	$pdf->AddPage();

		
$pdf->SetY(15);$t_show="COMMISSIONS VENDEURS FACTURATION DU MOIS  : ".dateUsToFr($date1)." au  ".dateUsToFr($date2);
$pdf->SetX(80);
$pdf->Cell(170,6,$t_show,1,0,'C',1);
$pdf->SetY($y_axis_initial);
$pdf->SetX(5);
$pdf->Cell(70,8,'Vendeur',1,0,'C',1);
$pdf->Cell(30,8,'Especes',1,0,'C',1);
$pdf->Cell(30,8,'Cheques',1,0,'C',1);
$pdf->Cell(30,8,'Effets',1,0,'C',1);
$pdf->Cell(30,8,'Virmt',1,0,'C',1);
$pdf->Cell(30,8,'Total',1,0,'C',1);	

$y_axis = $y_axis_initial + $row_height;

	$sql  = "SELECT vendeur,sum(cheque) as total_cheque,sum(espece) as total_espece, sum(effet) as total_effet,sum(virement) as total_virement ";
		$sql .= "FROM journal_commissions_vendeurs Group BY vendeur ;";
	$users14 = db_query($database_name, $sql);


$i = 0;


$max = 28;


$row_height = 6;$t_cheque=0;$ca=0;$htva_t=0;$tva_t=0;$ttc_t=0;$espece=0;$cheque=0;$effet=0;$tmt_t=0;$t_espece=0;
	$t_cheque_t = 0;
	$t_espece_t = 0;
	$t_effet_t = 0;$t_virement_t = 0;


while($row14 = fetch_array($users14))
{

	$vendeur = $row14['vendeur'];$total_espece=$row14['total_espece'];$total_cheque=$row14['total_cheque'];$total_effet=$row14['total_effet'];$total_virement=$row14['total_virement'];
	$pdf->SetY($y_axis);
	$pdf->SetX(5);
	$pdf->Cell(70,5,$vendeur,1,0,'L',1);
	$pdf->Cell(30,5,number_format($total_espece,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($total_cheque,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($total_effet,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($total_virement,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($total_virement+$total_espece+$total_cheque+$total_effet,2,',',' '),1,0,'R',1);
	$t_espece_t=$t_espece_t+$total_espece;
	$t_cheque_t=$t_cheque_t+$total_cheque;
	$t_effet_t=$t_effet_t+$total_effet;
	$t_virement_t=$t_virement_t+$total_virement;
	$y_axis = $y_axis + $row_height;
	$i = $i + 1;
}
	
	$pdf->Ln();	
	$pdf->SetX(75);
	$pdf->Cell(30,5,number_format($t_espece_t,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($t_cheque_t,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($t_effet_t,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($t_virement_t,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($t_virement_t+$t_effet_t+$t_cheque_t+$t_espece_t,2,',',' '),1,0,'R',1);
	
	
		////////
	

	$pdf->AddPage();

		
$pdf->SetY(15);$t_show="COMMISSIONS VENDEURS / FACTURATION DU MOIS  : ".dateUsToFr($date1)." AU  ".dateUsToFr($date2);
$pdf->SetX(80);
$pdf->Cell(170,6,$t_show,1,0,'C',1);
$pdf->SetY($y_axis_initial);
$pdf->SetX(5);
$pdf->Cell(50,8,'Vendeur',1,0,'C',1);
$pdf->Cell(30,8,'Especes',1,0,'C',1);
$pdf->Cell(30,8,'Cheques',1,0,'C',1);
$pdf->Cell(30,8,'Effets',1,0,'C',1);
$pdf->Cell(30,8,'Virmt',1,0,'C',1);
$pdf->Cell(30,8,'Impayés',1,0,'C',1);
$pdf->Cell(30,8,'Enc/compte',1,0,'C',1);
$pdf->Cell(30,8,'Enc/Impayé',1,0,'C',1);
$pdf->Cell(30,8,'Net Enc',1,0,'C',1);	

$y_axis = $y_axis_initial + $row_height;

	$sql  = "SELECT vendeur,sum(cheque) as total_cheque,sum(espece) as total_espece, sum(effet) as total_effet,sum(virement) as total_virement,
	sum(cheque_encompte) as total_cheque_enc,sum(espece_encompte) as total_espece_enc, sum(effet_encompte) as total_effet_enc,sum(virement_encompte) as total_virement_enc ";
		$sql .= "FROM journal_commissions_vendeurs Group BY vendeur ;";
	$users14 = db_query($database_name, $sql);


$i = 0;


$max = 28;


$row_height = 6;$t_cheque=0;$ca=0;$htva_t=0;$tva_t=0;$ttc_t=0;$espece=0;$cheque=0;$effet=0;$tmt_t=0;$t_espece=0;
	$t_cheque_t = 0;
	$t_espece_t = 0;
	$t_effet_t = 0;
	$t_virement_t = 0;
	$t_cheque_te = 0;
	$t_espece_te = 0;
	$t_effet_te = 0;
	$t_virement_te = 0;


while($row14 = fetch_array($users14))
{

	$vendeur = $row14['vendeur'];$total_espece=$row14['total_espece'];$total_cheque=$row14['total_cheque'];$total_effet=$row14['total_effet'];$total_virement=$row14['total_virement'];
	$total_espece_enc=$row14['total_espece_enc'];$total_cheque_enc=$row14['total_cheque_enc'];$total_effet_enc=$row14['total_effet_enc'];$total_virement_enc=$row14['total_virement_enc'];
	$pdf->SetY($y_axis);
	$pdf->SetX(5);
	$pdf->Cell(50,5,$vendeur,1,0,'L',1);
	$pdf->Cell(30,5,number_format($total_espece,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($total_cheque,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($total_effet,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($total_virement,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format(0,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($total_virement_enc+$total_espece_enc+$total_cheque_enc+$total_effet_enc,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format(0,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($total_virement_enc+$total_espece_enc+$total_cheque_enc+$total_effet_enc+$total_virement+$total_espece+$total_cheque+$total_effet,2,',',' '),1,0,'R',1);
	$t_espece_t=$t_espece_t+$total_espece;
	$t_cheque_t=$t_cheque_t+$total_cheque;
	$t_effet_t=$t_effet_t+$total_effet;
	$t_virement_t=$t_virement_t+$total_virement;
	
	$t_espece_te=$t_espece_te+$total_espece_enc;
	$t_cheque_te=$t_cheque_te+$total_cheque_enc;
	$t_effet_te=$t_effet_te+$total_effet_enc;
	$t_virement_te=$t_virement_te+$total_virement_enc;
	
	$y_axis = $y_axis + $row_height;
	$i = $i + 1;
}
	
	$pdf->Ln();	
	$pdf->SetX(55);
	$pdf->Cell(30,5,number_format($t_espece_t,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($t_cheque_t,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($t_effet_t,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($t_virement_t,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format(0,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($t_virement_te+$t_effet_te+$t_cheque_te+$t_espece_te,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format(0,2,',',' '),1,0,'R',1);
	$pdf->Cell(30,5,number_format($t_virement_t+$t_effet_t+$t_cheque_t+$t_espece_t+$t_virement_te+$t_effet_te+$t_cheque_te+$t_espece_te,2,',',' '),1,0,'R',1);
	
	
	$pdf->Output();
?>
