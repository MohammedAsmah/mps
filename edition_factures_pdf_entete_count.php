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
	require "chiffres_lettres.php";
	require "numbers2letters.php";
//Connect to your database
/*mysql_connect('localhost','root','');
mysql_select_db('mps2008');*/

//Create new pdf file
//$pdf=new FPDF('P','mm','A4');


//Create new pdf file
$pdf=new FPDF('P','mm','A4');


//Disable automatic page break
$pdf->SetAutoPageBreak(false);
$pdf->SetFont('Times','',12);
//Add first page
/*$pdf->AddPage();*/

//set initial y axis position per page


/*$y_axis_initial = 25;$y_axis = 25;le 12/12/2011*/
//Add first page
$pdf->AddPage();
$y_axis_initial = 5;$y_axis = 5;
$factures_sur_deux_pages = 0;

$row_height=4;
	$date1=$_GET['date1'];$total_e=0;$total_c=0;$total_t=0;
	$a="A";$date2=$_GET['date2'];
	$du=dateUsToFr($row["date1"]);
	$au=dateUsToFr($row["date2"]);
	
	
	if ($date2>="2018-01-01" and $date2<"2019-01-01"){$factures="factures2018";$exe="/18";$detail_factures="detail_factures2018";}
	if ($date2>="2017-01-01" and $date2<"2018-01-01"){$factures="factures";$exe="/17";$detail_factures="detail_factures2017";}
	if ($date2>="2019-01-01" and $date2<"2020-01-01"){$factures="factures2019";$exe="/19";$detail_factures="detail_factures2019";}
	if ($date2>="2020-01-01" and $date2<"2021-01-01"){$factures="factures2020";$exe="/20";$detail_factures="detail_factures2020";}
	if ($date2>="2021-01-01" and $date2<"2022-01-01"){$factures="factures2021";$exe="/21";$detail_factures="detail_factures2021";}
	if ($date2>="2022-01-01" and $date2<"2023-01-01"){$factures="factures2022";$exe="/22";$detail_factures="detail_factures2022";}
	if ($date2>="2023-01-01" and $date2<"2024-01-01"){$factures="factures2023";$exe="/23";$detail_factures="detail_factures2023";}
	if ($date2>="2024-01-01" and $date2<"2025-01-01"){$factures="factures2024";$exe="/24";$detail_factures="detail_factures2024";}
	if ($date2>="2025-01-01" and $date2<"2026-01-01"){$factures="factures2025";$exe="/25";$detail_factures="detail_factures2025";}
	if ($date2>="2026-01-01" and $date2<"2027-01-01"){$factures="factures2026";$exe="/26";$detail_factures="detail_factures2026";}
	
	

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(5);
$y_axis = $y_axis + $row_height;

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select Code,Name,Price from Products ORDER BY Code',$link);*/
	$sql  = "SELECT * ";$iks="ATELIER IKS";
	$sql .= "FROM ".$factures." where (date_f between '$date1' and '$date2') and montant>0 and client<>'$iks' ORDER BY id;";
	$users = db_query($database_name, $sql);

//initialize counter
$i = 0;$t=0;

//Set maximum rows per page
$max = 28;

//Set Row Height
$row_height = 5;



$t_cheque=0;$ca=0;$htva_t=0;$tva_t=0;$ttc_t=0;$espece=0;$cheque=0;$effet=0;$tmt_t=0;$t_espece=0;
	$t_cheque_t = 0;
	$t_espece_t = 0;
	$t_effet_t = 0;$t_virement_t = 0;
	
	$y_axis_d=10;

/*while($row = mysql_fetch_array($result))*/
while($row = fetch_array($users))
{
	//If the current row is the last one, create new page and print column title
	$ville="";$client=$row["client"];$id=$row["id"];$f=$row["numero"];$dfff=$row["date_f"];$m=$row["montant"];$mm=number_format($m,2,'.',' ');
	$lettres=int2str($m)." Dhs";$ff=$row["numero_facture"];
	
	
	$facture=$row["id"]+0;
if ($facture<10){$zero="000";}
if ($facture>=10 and $facture<100){$zero="00";}
if ($facture>=100 and $facture<1000){$zero="0";}
if ($facture>=1000 and $facture<10000){$zero="";}
$exercice=$row["exercice"];$facture=$zero.$facture."/".$exercice;
	
	
	//$lettres=chifre_en_lettre($mm, '', '');
	$net=$row["montant"];
		$sql  = "SELECT * ";
		$sql .= "FROM clients WHERE client = '" . $client . "';";
		$user_c = db_query($database_name, $sql); $user_cc = fetch_array($user_c);
		$adr = substr($user_cc["adrresse"],0,35);$ville = $user_cc["ville"];
		if ($adr==$ville){$adr="";}
		if ($user_cc["patente"]<>""){$patente = "Patente : ".$user_cc["patente"];}else{$patente="";}
		

$pdf->SetFont('Arial','B',14);
		//Go to next row
		$y_axis = 34;
		
		//Set $i variable to 0 (first row)
		$i = 0;

	$numero = $row['id']+9040;$htt=$row["ht"];
	$client=$row["client"];$id=$row["id"];$f=$row["numero"];$d=$row["date_f"];$client_se=Trim($client);
	$evaluation=$row["evaluation"]; $client=$row["client"];$user_id=$row["id"];
	$total_e = 0;$total_avoir = 0;$date=dateUsToFr($row["date_f"]);$d=dateUsToFr($row["date_f"]);
	$brut=0;$brut_sans=0;
	$remise10 = $row["remise_10"];$remise2 = $row["remise_2"];
	$sans_remise = $row["sans_remise"];$remise3 = $row["remise_3"];
	
	//PARAM LQ2080
	//$y_axis_d=47;
	
	//PARAM LQ590
	
	
	
	
	$pdf->SetY($y_axis_d);$pdf->SetFont('Times','',10);
	
	$sql  = "SELECT * ";$compteur=0;
	$sql .= "FROM ".$detail_factures. " where facture=$f ORDER BY sans_remise;";
	$users1 = db_query($database_name, $sql);
	while($row1 = fetch_array($users1))
	{
		$compteur++; 
		
	}

	if ($compteur>16){
		if ($y_axis_d<245){
		$pdf->SetY($y_axis_d);
		$pdf->SetX(6);$d="QUANTITE";
		$pdf->Cell(15,6,$f,0,0,'L',1);
		$y_axis_d=$y_axis_d+5;
		}
		else
			{
				$pdf->AddPage();
		$y_axis_d = 5;
		$pdf->SetY($y_axis_d);
		$pdf->SetX(6);$d="QUANTITE";
		$pdf->Cell(15,6,$f,0,0,'L',1);
		$y_axis_d=$y_axis_d+5;
		}
		}
	
		
}
/*$facture="Factures du ".$date1." au ".$date2.".pdf";
$pdf->Output('D', $facture);*/
$pdf->Output();
?>
