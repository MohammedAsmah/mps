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
//Connect to your database
/*mysql_connect('localhost','root','');
mysql_select_db('mps2008');*/

//Create new pdf file
//$pdf=new FPDF('P','mm','A4');

/*$dimension = array(210,188);*/
$dimension = array(210,215);
$pdf=new FPDF('P', 'mm', $dimension);



//Disable automatic page break
$pdf->SetAutoPageBreak(false);
$pdf->SetFont('Times','',12);
//Add first page
/*$pdf->AddPage();*/

//set initial y axis position per page


/*$y_axis_initial = 25;$y_axis = 25;le 12/12/2011*/

$y_axis_initial = 5;$y_axis = 5;

$row_height=4;
	$date1=$_GET['date1'];$total_e=0;$total_c=0;$total_t=0;
	$a="A";$date2=$_GET['date2'];

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(5);
$y_axis = $y_axis + $row_height;

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select Code,Name,Price from Products ORDER BY Code',$link);*/
	$sql  = "SELECT * ";$iks="ATELIER IKS";
	$sql .= "FROM factures2016 where (date_f between '$date1' and '$date2') and montant>0 and client='$iks' ORDER BY id;";
	$users = db_query($database_name, $sql);

//initialize counter
$i = 0;$t=0;

//Set maximum rows per page
$max = 28;

//Set Row Height
$row_height = 4;$t_cheque=0;$ca=0;$htva_t=0;$tva_t=0;$ttc_t=0;$espece=0;$cheque=0;$effet=0;$tmt_t=0;$t_espece=0;
	$t_cheque_t = 0;
	$t_espece_t = 0;
	$t_effet_t = 0;$t_virement_t = 0;

/*while($row = mysql_fetch_array($result))*/
while($row = fetch_array($users))
{
	//If the current row is the last one, create new page and print column title
	$ville="";$client=$row["client"];$id=$row["id"];$f=$row["numero"];$d=$row["date_f"];$m=$row["montant"];$mm=number_format($m,2,'.',' ');$dt=$row["date_f"];
	$lettres=int2str($m)." Dhs";
	//$lettres=chifre_en_lettre($mm, '', '');
	$net=$row["montant"];
		$sql  = "SELECT * ";
		$sql .= "FROM clients WHERE client = '" . $client . "';";
		$user_c = db_query($database_name, $sql); $user_cc = fetch_array($user_c);
		$adr = $user_cc["adrresse"];$ville = $user_cc["ville"];
		if ($adr==$ville){$adr="";}
		if ($user_cc["patente"]<>""){$patente = "Patente : ".$user_cc["patente"];}else{$patente="";}
		$pdf->AddPage();$pdf->SetFont('Times','',12);

		//print column titles for the current page

		
// PARAM LQ 2080
/*
$pdf->SetY(5);$t_show="FACTURE  $f ";
$pdf->SetX(70);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,0,$t_show,0,0,'C',0);
$pdf->SetY(27);
$pdf->SetX(38);$d=dateUsToFr($d);
$pdf->Cell(34,0,$d,0,0,'L',1);
$pdf->SetY(7);$pdf->SetX(145);
$pdf->Cell(90,0,$client,0,0,'L',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetY(12);$pdf->SetX(145);
$pdf->Cell(90,0,$adr,0,0,'L',1);
$pdf->SetY(16);$pdf->SetX(145);
$pdf->Cell(90,0,$ville,0,0,'L',1);
$pdf->SetY(20);$pdf->SetX(145);
$pdf->Cell(90,0,$patente,0,0,'L',1);
$pdf->SetFont('Arial','B',13);
*/

// PARAM LQ 590
$pdf->SetY(2);$t_show="FACTURE  $f ";
$pdf->SetX(70);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,0,$t_show,0,0,'C',0);
$pdf->SetY(20);
$pdf->SetX(38);$d=dateUsToFr($d);
$pdf->Cell(34,0,$d,0,0,'L',1);
$pdf->SetY(4);$pdf->SetX(145);
$pdf->Cell(90,0,$client,0,0,'L',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetY(9);$pdf->SetX(145);
$pdf->Cell(90,0,$adr,0,0,'L',1);
$pdf->SetY(13);$pdf->SetX(145);
$pdf->Cell(90,0,$ville,0,0,'L',1);
$pdf->SetY(17);$pdf->SetX(145);
$pdf->Cell(90,0,$patente,0,0,'L',1);
$pdf->SetFont('Arial','B',13);




$pdf->SetY($y_axis_initial);

$pdf->SetFont('Arial','B',14);
		//Go to next row
		$y_axis = 34;
		
		//Set $i variable to 0 (first row)
		$i = 0;

	$numero = $row['id']+9040;$htt=$row["ht"];
	$client=$row["client"];$id=$row["id"];$f=$row["numero"];$d=$row["date_f"];$client_se=Trim($client);
	$evaluation=$row["evaluation"]; $client=$row["client"];$user_id=$row["id"];$facture=$row["id"]+9040;
	$total_e = 0;$total_avoir = 0;$date=dateUsToFr($row["date_f"]);$d=dateUsToFr($row["date_f"]);
	$brut=0;$brut_sans=0;
	$remise10 = $row["remise_10"];$remise2 = $row["remise_2"];
	$sans_remise = $row["sans_remise"];$remise3 = $row["remise_3"];
	
	//PARAM LQ2080
	//$y_axis_d=47;
	
	//PARAM LQ590
	$y_axis_d=40;
	
	//BL
	if ($dt>="2014-01-01" and $dt<="2014-10-15"){$att="ATTESTATION D'EXONORATION N°42/14 DU 06/02/2014 ";}
	if ($dt>="2013-01-01" and $dt<="2013-12-31"){$att="ATTESTATION D'EXONORATION N°89/13 DU 25/02/2013 ";}
	if ($dt>="2014-10-15" and $dt<="2014-12-31"){$att="ATTESTATION D'EXONORATION N°244/14 DU 16/10/2014 ";}
	
	$pdf->SetFont('Times','',14);
	$pdf->SetY($y_axis_d+10);//$y_axis_d=60;
	$pdf->SetX(7);
	$pdf->Cell(25,0,$bl,0,0,'L',1);
	
	
	$pdf->SetY($y_axis_d);$pdf->SetFont('Times','',8);
	
	$sql  = "SELECT * ";
	$sql .= "FROM detail_factures2016 where facture=$f ORDER BY sans_remise;";
	$users1 = db_query($database_name, $sql);
	while($row1 = fetch_array($users1))
	{
		$produit=$row1["produit"]; $id=$row1["id"];$m=$row1["quantite"]*$row1["prix_unit"]*$row1["condit"];
		$quantite=$row1["quantite"];$condit=$row1["condit"];$prix_unit=$row1["prix_unit"];$sans_remise_a=$row1["sans_remise"];
	if (!$sans_remise_a){$brut=$brut+($prix_unit*$quantite*$condit);$input="";}
	else{$brut_sans=$brut_sans+($prix_unit*$quantite*$condit);$input="SR";}
	
	
	//nbr lignes
	
	if ($y_axis_d<116)
	{
	
	$pdf->SetY($y_axis_d);
	$pdf->SetX(7);
	$pdf->Cell(25,0,$input,0,0,'L',1);
	$pdf->Cell(90,0,$produit,0,0,'L',1);
	$pdf->Cell(25,0,$quantite."x".$condit,0,0,'C',1);
	$pdf->Cell(30,0,number_format($prix_unit,2,',',' '),0,0,'R',1);
	$pdf->Cell(30,0,number_format($prix_unit*$quantite*$condit,2,',',' '),0,0,'R',1);
	$y_axis_d = $y_axis_d + $row_height;
	}
	ELSE
	{
	
			$pdf->SetY($y_axis_d);$pdf->SetX(5);
			$pdf->Cell(25,0,$input,0,0,'L',1);
			$pdf->Cell(90,0,$input,0,0,'L',1);
			$pdf->Cell(25,0,$input,0,0,'C',1);$pdf->SetFont('Times','',10);
			$pdf->Cell(30,0,'Total à Repporter',0,0,'R',0);
			$pdf->Cell(30,0,number_format($brut+$brut_sans,2,',',' '),0,0,'R',0);
			$l=155;$pdf->SetY($l);$pdf->SetX(112);
			$pdf->Cell(60,0,'XXXXXXXXXXXXXX   19 000 000.00 DHS ',0,0,'L',1);
			
			$pdf->AddPage();$pdf->SetFont('Times','',12);
			
			$pdf->SetY(2);$t_show="FACTURE  $f ";
			$pdf->SetX(70);
			$pdf->SetFont('Arial','B',6);
			$pdf->Cell(80,0,$t_show,0,0,'C',0);
			$pdf->SetY(6);$t="PAGE 2/2 ";
			$pdf->SetX(72);
			$pdf->Cell(80,0,$t,0,0,'C',0);
			$pdf->SetFont('Arial','B',11);
			$pdf->SetY(20);
			$pdf->SetX(38);
			$pdf->Cell(34,0,$d,0,0,'L',1);
			$pdf->SetY(4);$pdf->SetX(145);
			$pdf->Cell(90,0,$client,0,0,'L',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->SetY(9);$pdf->SetX(145);
			$pdf->Cell(90,0,$adr,0,0,'L',1);
			$pdf->SetY(13);$pdf->SetX(145);
			$pdf->Cell(90,0,$ville,0,0,'L',1);
			$pdf->SetY(17);$pdf->SetX(145);
			$pdf->Cell(90,0,$patente,0,0,'L',1);
			$pdf->SetFont('Arial','B',11);
			
			$y_axis_d=40;$pdf->SetY($y_axis_d);
			$pdf->SetX(5);
			$pdf->Cell(25,0,$input,0,0,'L',1);
			$pdf->Cell(90,0,$input,0,0,'L',1);
			$pdf->Cell(25,0,$input,0,0,'C',1);$pdf->SetFont('Times','',10);	
			$pdf->Cell(30,0,'Repport',0,0,'R',1);
			$pdf->Cell(30,0,number_format($brut+$brut_sans,2,',',' '),0,0,'R',0);
			$y_axis_d = $y_axis_d + $row_height;$pdf->SetFont('Times','',8);
			


			
		}
	
	}


	if ($sans_remise){
	$y=120;
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
 	$pdf->Cell(150,0,'MARCHANDISES VENDUS EN EXONORER DE TVA ',0,0,'L',1);
	$y=$y+10;$pdf->SetY($y);$pdf->SetX(15);
	$pdf->Cell(150,0,$att,0,0,'L',1);
	}
	 else
	  {
	$y=120;
	$pdf->SetY($y);$pdf->SetX(145);
	$pdf->Cell(30,0,'Total Brut',0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut,2,',',' '),0,0,'R',1);
	
	if ($remise10<>0){$y=$y+4;
	$pdf->SetY($y);$pdf->SetX(145);$r10='Remise '.$remise10.' %';
	$pdf->Cell(30,0,$r10,0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut*$remise10/100,2,',',' '),0,0,'R',1);
	$y=$y+4;
	$pdf->SetY($y);$pdf->SetX(145);
	$pdf->Cell(30,0,'1er Net',0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut-($brut*$remise10/100),2,',',' '),0,0,'R',1);
	$brut=$brut-($brut*$remise10/100);
	}
	if ($remise2<>0){$y=$y+4;
	$pdf->SetY($y);$pdf->SetX(145);$r2='Remise '.$remise2.' %';
	$pdf->Cell(30,0,$r2,0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut*$remise2/100,2,',',' '),0,0,'R',1);
	$y=$y+4;
	$pdf->SetY($y);$pdf->SetX(145);
	$pdf->Cell(30,0,'2eme Net',0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut-($brut*$remise2/100),2,',',' '),0,0,'R',1);
	$brut=$brut-($brut*$remise2/100);
	}
	if ($remise3<>0){$y=$y+4;
	$pdf->SetY($y);$pdf->SetX(145);$r3='Remise '.$remise3.' %';
	$pdf->Cell(30,0,$r3,0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut*$remise3/100,2,',',' '),0,0,'R',1);
	$y=$y+4;
	$pdf->SetY($y);$pdf->SetX(145);
	$pdf->Cell(30,0,'3eme Net',0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut-($brut*$remise3/100),2,',',' '),0,0,'R',1);
	}
	$y=$y+4;$pdf->SetY($y);$pdf->SetX(145);
	if ($brut_sans<>0){
	$pdf->Cell(30,0,'Articles Sans Remise',0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut_sans,2,',',' '),0,0,'R',1);
	$y=$y+4;
	}
	$pdf->Cell(30,0,'Total Net',0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut-($brut*$remise3/100)+$brut_sans,2,',',' '),0,0,'R',1);
	$chiffres=$brut-($brut*$remise3/100)+$brut_sans;
	$pdf->SetFont('Times','',12);
	$centimes=substr(number_format($chiffres-floor($chiffres), 2, ',', ' '),-2);
	if ($centimes=="00"){$centimes="";}else {$centimes=$centimes." cts";}
	$pdf->SetY(120);$pdf->SetX(15);$texte="Arretee la presente facture a la somme de : ";
 	$pdf->Cell(150,0,$texte,0,0,'L',1);	$y=$y+4;$pdf->SetY(124);$pdf->SetX(15);
 	$pdf->Cell(150,0,$lettres.' '.$centimes,0,0,'L',1);

	$y=$y+9;$pdf->SetY(130);$pdf->SetX(15);$tva=($brut-($brut*$remise3/100)+$brut_sans)/1.20*0.20;
	$tva=number_format($tva, 2, ',', ' ');
 	$l=155;$pdf->SetY($l);$pdf->SetX(112);
	$pdf->Cell(60,0,'XXXXXXXXXXXXXX   19 000 000.00 DHS ',0,0,'L',1);
	
	}
	
	$l=145;$pdf->SetY($l);$pdf->SetX(10);
	$pdf->Cell(60,0,'MARCHANDISES VENDUS EN EXONORER DE TVA   ',0,0,'L',1);
	$l=140;$pdf->SetY($l);$pdf->SetX(10);
	$pdf->Cell(60,0,$att,0,0,'L',1);
		
}

$pdf->Output();
?>
