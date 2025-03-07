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
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$t_reste=0;$t_total_encaisse=0;
	$date1=$_GET['date1'];$total_e=0;$total_c=0;$total_t=0;
	$a="A";$date2=$_GET['date2'];

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(5);
$pdf->SetFont('Arial','B',18);
$pdf->Cell(20,6,'M.P.S',1,0,'L',1);
$pdf->SetX(260);$d=date("d/m/Y");
$pdf->Cell(34,6,$d,1,0,'L',1);
$pdf->SetFont('Arial','B',13);
$pdf->SetY(15);$t_show="FACTURES NON ENCAISSEES DU MOIS  : ".dateUsToFr($date1)."   ".dateUsToFr($date2);
$pdf->SetX(80);
$pdf->Cell(150,6,$t_show,1,0,'C',1);
$pdf->SetFont('Arial','',8);
$pdf->SetY($y_axis_initial);
$pdf->SetX(5);
$pdf->Cell(20,8,'Date',1,0,'C',1);
$pdf->Cell(16,8,'Fact',1,0,'C',1);
$pdf->Cell(20,8,'INPUT',1,0,'C',1);
$pdf->Cell(60,8,'Designation',1,0,'C',1);
$pdf->Cell(27,8,'HTVA',1,0,'C',1);
$pdf->Cell(23,8,'TVA',1,0,'C',1);
$pdf->Cell(27,8,'TTC',1,0,'C',1);
$pdf->Cell(27,8,'Encaisse',1,0,'C',1);
$pdf->Cell(27,8,'Solde',1,0,'C',1);
$pdf->Cell(27,8,'Effet N.Echus',1,0,'C',1);
$y_axis = $y_axis + $row_height;

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select Code,Name,Price from Products ORDER BY Code',$link);*/
	if ($date2>"2016-12-31"){
	$sql  = "SELECT * ";
	$sql .= "FROM factures2018 where (date_f between '$date1' and '$date2') and montant>0 ORDER BY id;";
	}
	else
	{
	$sql  = "SELECT * ";
	$sql .= "FROM factures2016 where (date_f between '$date1' and '$date2') and montant>0 ORDER BY id;";
	}
	$users = db_query($database_name, $sql);
	

//initialize counter
$i = 0;

//Set maximum rows per page
$max = 28;

//Set Row Height
$row_height = 6;$t_cheque=0;$ca=0;$htva_t=0;$tva_t=0;$ttc_t=0;$espece=0;$cheque=0;$effet=0;$tmt_t=0;$t_espece=0;
	$t_cheque_t = 0;
	$t_espece_t = 0;
	$t_effet_t = 0;$t_virement_t = 0;$t_effet_non_u = 0;

/*while($row = mysql_fetch_array($result))*/
while($row = fetch_array($users))
{
	//If the current row is the last one, create new page and print column title
	if ($i == $max)
	{
		$pdf->AddPage();

		//print column titles for the current page
$pdf->SetY(15);$t_show="FACTURES NON ENCAISSEES DU MOIS  : ".dateUsToFr($date1)."   ".dateUsToFr($date2);
$pdf->SetX(80);
$pdf->Cell(150,6,$t_show,1,0,'C',1);
$pdf->SetY($y_axis_initial);
$pdf->SetX(5);
$pdf->Cell(20,8,'Date',1,0,'C',1);
$pdf->Cell(16,8,'Fact',1,0,'C',1);
$pdf->Cell(20,8,'INPUT',1,0,'C',1);
$pdf->Cell(60,8,'Designation',1,0,'C',1);
$pdf->Cell(27,8,'HTVA',1,0,'C',1);
$pdf->Cell(23,8,'TVA',1,0,'C',1);
$pdf->Cell(27,8,'TTC',1,0,'C',1);
$pdf->Cell(27,8,'Encaisse',1,0,'C',1);
$pdf->Cell(27,8,'Solde',1,0,'C',1);
$pdf->Cell(27,8,'Effet N.Echus',1,0,'C',1);
		//Go to next row
		$y_axis = 34;
		
		//Set $i variable to 0 (first row)
		$i = 0;
	}

if ($date2>"2016-12-31"){
$user_id=$row["id"]+0;
if ($user_id<10){$zero="000";}
if ($user_id>=10 and $user_id<100){$zero="00";}
if ($user_id>=100 and $user_id<1000){$zero="0";}
if ($user_id>=1000 and $user_id<10000){$zero="0";}
$facture=$row["id"]+0;$exercice=$row["exercice"];$facture=$zero.$facture."/".$exercice;
}else
{
$facture=$row["id"]+9040;
}
	$client=$row["client"];$id=$row["id"];$f=$row["numero"];$d=$row["date_f"];$client_se=Trim($client);
	$evaluation=$row["evaluation"]; $client=$row["client"];$user_id=$row["id"];	$total_e = 0;
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

	
	$ca=$ca+$row["montant"];$ht=number_format($row["montant"]/1.2,2,',',' ');
	$tva=number_format($row["montant"]/1.2*0.20,2,',',' ');
	$ttc=number_format($row["montant"],2,',',' ');
	$ttc=number_format($row["montant"],2,',',' ');$t_f=$row["montant"];
	/*$pdf->Cell(27,6,$ttc,1,0,'R',1);*/
		$htva_t=$htva_t+$row["montant"]/1.2;
		$tva_t=$tva_t+$row["montant"]/1.2*0.20;
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
		$sql .= "FROM porte_feuilles_factures where m_effet<>0 and facture_n='$facture' and (date_remise_e between '$date1' and '$date2') and (date_echeance <= '$date2') and remise_e=1 Group BY id;";
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
		$sql .= "FROM porte_feuilles_factures where m_virement<>0 and facture_n='$facture' and (date_virement between '$date1' and '$date2') Group BY facture_n;";
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
	
	$total_virement = $row['total_virement'];

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


//effet nechus
		$sql  = "SELECT remise,numero_cheque,facture_n,client,client_tire,v_banque,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece
		, sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
		$sql .= "FROM porte_feuilles_factures where m_effet<>0 and facture_n='$facture' and (date_echeance > '$date2') and (date_enc <='$date2') and id_registre_regl<>0 Group BY facture_n;";
		$users11u = db_query($database_name, $sql);
		$effet_non_u=0;
while($row = fetch_array($users11u))
{
	
	$effet_non_u = $row['total_effet'];
	$t_effet_non_u=$t_effet_non_u+$effet_non_u;
	
	
}
///fin effet


//condition non encaisse
	$reste=$t_f-($total_espece+$total_cheque+$total_virement+$t_effet);
	$total_encaisse=($total_espece+$total_cheque+$total_virement+$t_effet);
	if ($reste<>0){
	$pdf->SetY($y_axis);
	$pdf->SetX(5);$input="";
	$pdf->Cell(20,6,$date,1,0,'L',1);
	$pdf->Cell(16,6,$facture,1,0,'L',1);
	$pdf->Cell(20,6,$inputation,1,0,'R',1);
	$pdf->Cell(60,6,$client,1,0,'L',1);
	$pdf->Cell(27,6,$ht,1,0,'R',1);
	$pdf->Cell(23,6,$tva,1,0,'R',1);
	$pdf->Cell(27,6,$ttc,1,0,'R',1);
	$pdf->Cell(27,6,number_format($total_encaisse,2,',',' '),1,0,'R',1);
	$pdf->Cell(27,6,number_format($reste-$effet_non_u,2,',',' '),1,0,'R',1);
	$pdf->Cell(27,6,number_format($effet_non_u,2,',',' '),1,0,'R',1);
	$t_reste=$t_reste+$reste-$effet_non_u;$t_total_encaisse=$t_total_encaisse+$total_encaisse;
	//Go to next row
	$y_axis = $y_axis + $row_height;
	$i = $i + 1;
	}
}
	$pdf->Ln();	
	$pdf->SetX(198);
	$pdf->Cell(27,6,number_format($t_total_encaisse,2,',',' '),1,0,'R',1);
	$pdf->Cell(27,6,number_format($t_reste,2,',',' '),1,0,'R',1);
	$pdf->Cell(27,6,number_format($t_effet_non_u,2,',',' '),1,0,'R',1);
$pdf->Output();
?>
