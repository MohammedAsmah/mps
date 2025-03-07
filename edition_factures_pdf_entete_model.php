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
		
//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=5;$l=25;



/*$pdf->addJpegFromFile("logo_mps.JPG",40,820);*/
$pdf->Image('logo1.jpg',10,10,185,35);


//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(55);
$pdf->SetFont('arial','',14);


$pdf->SetY(74);$t_show="FACTURE : $facture ";
$pdf->SetX(70);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,0,utf8_decode($t_show),0,0,'C',0);
$pdf->SetY(60);
$pdf->SetX(18);$d="Marrakech le : ".dateUsToFr($dfff);
$pdf->Cell(34,0,$d,0,0,'L',1);
$pdf->SetY(48);$pdf->SetX(145);
$pdf->Cell(90,0,$client,0,0,'L',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetY(54);$pdf->SetX(145);
$pdf->Cell(90,0,$adr,0,0,'L',1);
$pdf->SetY(64);$pdf->SetX(145);
$pdf->Cell(90,0,$ville,0,0,'L',1);
$pdf->SetY(74);$pdf->SetX(145);
$pdf->Cell(90,0,$patente,0,0,'L',1);
$pdf->SetFont('Arial','B',13);

$pdf->SetFont('arial','',12);
$pdf->SetLineWidth(0.3);

$pdf->Line(5,85,205,85);
$pdf->Line(5,95,205,95);
$pdf->Line(5,85,5,95);
$pdf->Line(205,85,205,95);

$pdf->Line(5,85,5,220);
$pdf->Line(35,85,35,220);
$pdf->Line(135,85,135,220);
$pdf->Line(165,85,165,220);
$pdf->Line(205,85,205,220);
$pdf->Line(5,220,205,220);

$pdf->Line(165,220,165,260);
$pdf->Line(205,220,205,260);
$pdf->Line(165,260,205,260);
$pdf->Line(5,275,205,275);

$pdf->SetY(88);
$pdf->SetX(6);$d="QUANTITE";
$pdf->Cell(15,6,$d,0,0,'L',1);

$pdf->SetY(88);
$pdf->SetX(50);$d="DESIGNATION ARTICLE ";
$pdf->Cell(34,6,$d,0,0,'L',1);

$pdf->SetY(88);
$pdf->SetX(140);$d="P U";
$pdf->Cell(10,6,$d,0,0,'L',1);

$pdf->SetY(88);
$pdf->SetX(168);$d="MONTANT";
$pdf->Cell(15,6,$d,0,0,'L',1);
$ligne=98;$total=0;

$pdf->SetFont('arial','',9);





$pdf->SetY($y_axis_initial);

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
	$y_axis_d=98;
	
	
	
	$pdf->SetY($y_axis_d);$pdf->SetFont('Times','',10);
	
	$sql  = "SELECT * ";
	$sql .= "FROM ".$detail_factures. " where facture=$f ORDER BY sans_remise;";
	$users1 = db_query($database_name, $sql);
	while($row1 = fetch_array($users1))
	{
		$produit=$row1["produit"]; $id=$row1["id"];$m=$row1["quantite"]*$row1["prix_unit"]*$row1["condit"];
		$quantite=$row1["quantite"];$condit=$row1["condit"];$prix_unit=$row1["prix_unit"];$sans_remise_a=$row1["sans_remise"];
	if (!$sans_remise_a){$brut=$brut+($prix_unit*$quantite*$condit);$input="";}
	else{$brut_sans=$brut_sans+($prix_unit*$quantite*$condit);$input="SR";}
	
	if ($y_axis_d<176)
	{
	
	$pdf->SetY($y_axis_d);
	$pdf->SetX(15);
	$pdf->Cell(25,0,$quantite." x ".$condit,0,0,'L',1);
	$pdf->SetX(37);
	$pdf->Cell(90,0,$produit,0,0,'L',1);
	$pdf->SetX(130);
	$pdf->Cell(30,0,number_format($prix_unit,2,',',' '),0,0,'R',1);
	$pdf->Cell(30,0,number_format($prix_unit*$quantite*$condit,2,',',' '),0,0,'R',1);
	$y_axis_d = $y_axis_d + $row_height;
	}
	ELSE
	{
		
		$factures_sur_deux_pages = $factures_sur_deux_pages+1;
		$pdf->SetY($y_axis_d);
	$pdf->SetX(15);
	$pdf->Cell(25,0,$quantite." x ".$condit,0,0,'L',1);
	$pdf->SetX(37);
	$pdf->Cell(90,0,$produit,0,0,'L',1);
	$pdf->SetX(130);
	$pdf->Cell(30,0,number_format($prix_unit,2,',',' '),0,0,'R',1);
	$pdf->Cell(30,0,number_format($prix_unit*$quantite*$condit,2,',',' '),0,0,'R',1);
	$y_axis_d = $y_axis_d + $row_height;
	
			$pdf->SetY($y_axis_d+5);$pdf->SetX(5);
			$pdf->Cell(25,0,$input,0,0,'L',1);
			$pdf->Cell(90,0,$input,0,0,'L',1);
			$pdf->Cell(25,0,$input,0,0,'C',1);$pdf->SetFont('Times','',10);
			$pdf->Cell(30,0,'Total à Repporter',0,0,'R',0);
			$pdf->Cell(30,0,number_format($brut+$brut_sans,2,',',' '),0,0,'R',0);
			$l=164;$pdf->SetY($l);$pdf->SetX(112);
			//$pdf->Cell(60,0,'XXXXXXXXXXXXXX   19 000 000.00 DHS ',0,0,'L',1);
			
			//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=5;$l=25;



/*$pdf->addJpegFromFile("logo_mps.JPG",40,820);*/
$pdf->Image('logo1.jpg',10,10,185,35);


//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(55);
$pdf->SetFont('arial','',14);


$pdf->SetY(74);$t_show="FACTURE : $facture ";
$pdf->SetX(70);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,0,utf8_decode($t_show),0,0,'C',0);
$pdf->SetY(60);
$pdf->SetX(18);$d="Marrakech le : ".dateUsToFr($dfff);
$pdf->Cell(34,0,$d,0,0,'L',1);
$pdf->SetY(48);$pdf->SetX(145);
$pdf->Cell(90,0,$client,0,0,'L',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetY(54);$pdf->SetX(145);
$pdf->Cell(90,0,$adr,0,0,'L',1);
$pdf->SetY(64);$pdf->SetX(145);
$pdf->Cell(90,0,$ville,0,0,'L',1);
$pdf->SetY(74);$pdf->SetX(145);
$pdf->Cell(90,0,$patente,0,0,'L',1);
$pdf->SetFont('Arial','B',13);

$pdf->SetFont('arial','',12);
$pdf->SetLineWidth(0.3);

$pdf->Line(5,85,205,85);
$pdf->Line(5,95,205,95);
$pdf->Line(5,85,5,95);
$pdf->Line(205,85,205,95);

$pdf->Line(5,85,5,220);
$pdf->Line(35,85,35,220);
$pdf->Line(135,85,135,220);
$pdf->Line(165,85,165,220);
$pdf->Line(205,85,205,220);
$pdf->Line(5,220,205,220);

$pdf->Line(165,220,165,260);
$pdf->Line(205,220,205,260);
$pdf->Line(165,260,205,260);
$pdf->Line(5,275,205,275);

$pdf->SetY(88);
$pdf->SetX(6);$d="QUANTITE";
$pdf->Cell(15,6,$d,0,0,'L',1);

$pdf->SetY(88);
$pdf->SetX(50);$d="DESIGNATION ARTICLE ";
$pdf->Cell(34,6,$d,0,0,'L',1);

$pdf->SetY(88);
$pdf->SetX(140);$d="P U";
$pdf->Cell(10,6,$d,0,0,'L',1);

$pdf->SetY(88);
$pdf->SetX(168);$d="MONTANT";
$pdf->Cell(15,6,$d,0,0,'L',1);
$ligne=98;$total=0;

$pdf->SetFont('arial','',9);


			
			$y_axis_d=98;
	
	$pdf->SetY($y_axis_d);$pdf->SetFont('Times','',10);
			$pdf->SetX(5);
			$pdf->Cell(25,0,$input,0,0,'L',1);
			$pdf->Cell(90,0,$input,0,0,'L',1);
			$pdf->Cell(25,0,$input,0,0,'C',1);$pdf->SetFont('Times','',10);	
			$pdf->Cell(30,0,'Repport',0,0,'R',1);
			$pdf->Cell(30,0,number_format($brut+$brut_sans,2,',',' '),0,0,'R',0);
			$y_axis_d = $y_axis_d + $row_height;$pdf->SetFont('Times','',10);
			


			
		}
	
	}


	if ($sans_remise){
	$y=225;
	$pdf->SetY($y);$pdf->SetX(145);
	$pdf->Cell(30,0,'Total Net',0,0,'R',1);
	$pdf->Cell(30,0,number_format($net,2,',',' '),0,0,'R',1);
	$chiffres=$net;
	$pdf->SetFont('Times','',12);
	$centimes=substr(number_format($chiffres-floor($chiffres), 2, ',', ' '),-2);
	if ($centimes=="00"){$centimes="";}else {$centimes=$centimes." Cts";}
	
	$pdf->SetY($y);$pdf->SetX(15);$texte="Arretee la presente facture a la somme de : ";
	
 	$pdf->Cell(150,0,$texte,0,0,'L',1);	$y=$y+5;$pdf->SetY($y);$pdf->SetX(15);
 	$pdf->Cell(150,0,$lettres.' '.$centimes,0,0,'L',1);
	$y=$y+10;$pdf->SetY($y);$pdf->SetX(15);$tva=$net/1.20*0.20;
	$tva=number_format($tva, 2, ',', ' ');
 	$pdf->Cell(150,0,'Dont TVA 20 % : '.$tva,0,0,'L',1);
	$l=280;$pdf->SetY($l);$pdf->SetX(150);
	$pdf->Cell(60,0,'SARL AU CAPITAL DE 19 000 000.00 DHS ',0,0,'L',1);
	$pdf->SetY($l+5);$pdf->SetX(5);
	$pdf->Cell(60,0,'I.F : 06580058 - R.C : 10499 MARRAKECH - C.N.S.S : 2671164 - T.V.A : 2244001 - Taxe Professionnelle : 64090420 - ICE : 001525412000076 ',0,0,'L',1);
	
	}
	 else
	  {
	$y=225;$pdf->SetFont('Times','',9);
	$pdf->SetY($y);$pdf->SetX(140);
	$pdf->Cell(30,0,'Total Brut',0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut,2,',',' '),0,0,'R',1);
	
	if ($remise10<>0){$y=$y+3.8;
	$pdf->SetY($y);$pdf->SetX(140);$r10='Remise '.$remise10.' %';
	$pdf->Cell(30,0,$r10,0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut*$remise10/100,2,',',' '),0,0,'R',1);
	$y=$y+3.8;
	$pdf->SetY($y);$pdf->SetX(140);
	$pdf->Cell(30,0,'1er Net',0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut-($brut*$remise10/100),2,',',' '),0,0,'R',1);
	$brut=$brut-($brut*$remise10/100);
	}
	if ($remise2<>0){$y=$y+3.8;
	$pdf->SetY($y);$pdf->SetX(140);$r2='Remise '.$remise2.' %';
	$pdf->Cell(30,0,$r2,0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut*$remise2/100,2,',',' '),0,0,'R',1);
	$y=$y+3.8;
	$pdf->SetY($y);$pdf->SetX(140);
	//$pdf->Cell(30,0,'2eme Net',0,0,'L',1);
	//$pdf->Cell(30,0,number_format($brut-($brut*$remise2/100),2,',',' '),0,0,'R',1);
	$brut=$brut-($brut*$remise2/100);
	}
	if ($remise3<>0){$y=$y+3.8;
	$pdf->SetY($y);$pdf->SetX(140);$r3='Remise '.$remise3.' %';
	$pdf->Cell(30,0,$r3,0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut*$remise3/100,2,',',' '),0,0,'R',1);
	$y=$y+3.8;
	$pdf->SetY($y);$pdf->SetX(145);
	//$pdf->Cell(30,0,'3eme Net',0,0,'L',1);
	//$pdf->Cell(30,0,number_format($brut-($brut*$remise3/100),2,',',' '),0,0,'R',1);
	}
	$y=$y+3.8;$pdf->SetY($y);$pdf->SetX(140);
	if ($brut_sans<>0){
	$pdf->Cell(30,0,'Articles Sans Remise',0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut_sans,2,',',' '),0,0,'R',1);
	$y=$y+3.8;
	}
	$pdf->Cell(30,0,'Total Net',0,0,'L',1);
	$pdf->Cell(30,0,number_format($net,2,',',' '),0,0,'R',1);
	$chiffres=$net;
	$y=$y+3.8;
	
	$pdf->SetFont('Times','',12);
	$centimes=substr(number_format($chiffres-floor($chiffres), 2, ',', ' '),-2);
	if ($centimes=="00"){$centimes="";}else {$centimes=$centimes." cts";}
	$pdf->SetY(225);$pdf->SetX(15);$texte="Arretee la presente facture a la somme de : ";
 	$pdf->Cell(150,0,$texte,0,0,'L',1);	$y=$y+4;$pdf->SetY(235);$pdf->SetX(15);
 	$pdf->Cell(150,0,$lettres.' '.$centimes,0,0,'L',1);

	$y=$y+9;$pdf->SetY(245);$pdf->SetX(15);$tva=$net/1.20*0.20;
	$tva=number_format($tva, 2, ',', ' ');
 	$pdf->Cell(150,0,'Dont TVA 20 % : '.$tva,0,0,'L',1);
	$pdf->SetFont('Times','',8);
	$l=280;$pdf->SetY($l);$pdf->SetX(80);
	$pdf->Cell(60,0,'SARL AU CAPITAL DE 19 000 000.00 DHS ',0,0,'L',1);
	$pdf->SetY($l+5);$pdf->SetX(20);
	$pdf->Cell(60,0,'I.F : 06580058 - R.C : 10499 MARRAKECH - C.N.S.S : 2671164 - T.V.A : 2244001 - Taxe Professionnelle : 64090420 - ICE : 001525412000076 ',0,0,'L',1);
	
	}
	
	
		
}
/*$facture="Factures du ".$date1." au ".$date2.".pdf";
$pdf->Output('D', $facture);*/
$pdf->Output();
?>
