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
	$numero=$_GET['numero'];$client=$_GET['client'];$montant_f=0;$bl = $_GET['bc'];$destination = "";
	$bc="";
	$id = $numero;
		$sql  = "SELECT * ";
		$sql .= "FROM commandes WHERE commande = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_e"]);
		$client = $user_["client"];$montant_f = $user_["net"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
		$sql1  = "SELECT * ";
		$sql1 .= "FROM clients WHERE client = '$client' ";
		$user1 = db_query($database_name, $sql1); $user_1 = fetch_array($user1);
		$adr = $user_1["adrresse"];$patente = $user_1["patente"];
		$ville = $user_1["ville"];$total_e=0;$total_c=0;$total_t=0;
	$a="A";$date2=$_GET['date2'];

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(5);
$y_axis = $y_axis + $row_height;

//Select the Products you want to show in your PDF file
/*$result=mysql_query('select Code,Name,Price from Products ORDER BY Code',$link);*/
	

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

	//If the current row is the last one, create new page and print column title
	
		
		$pdf->AddPage();$pdf->SetFont('Times','',12);

		//print column titles for the current page
/*$pdf->SetY(28);$t_show="FACTURE  $f ";
$pdf->SetX(70);
$pdf->SetFont('Arial','B',13);
$pdf->Cell(80,0,$t_show,0,0,'C',0);
$pdf->SetY(54);
$pdf->SetX(35);$d=dateUsToFr($d);
$pdf->Cell(34,0,$d,0,0,'L',1);
$pdf->SetY(40);$pdf->SetX(130);
$pdf->Cell(90,0,$client,0,0,'L',1);*/

$pdf->SetY(8);$t_show="BON DE LIVRAISON : $bl ";
$pdf->SetX(50);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(80,0,$t_show,0,0,'C',0);
$pdf->SetY(20);
$pdf->SetX(38);$d=$date;
$pdf->Cell(34,0,$d,0,0,'L',1);
$pdf->SetY(8);$pdf->SetX(145);
$pdf->Cell(90,0,$client,0,0,'L',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetY(12);$pdf->SetX(145);
$pdf->Cell(90,0,$adr,0,0,'L',1);
$pdf->SetY(16);$pdf->SetX(145);
$pdf->Cell(90,0,$ville,0,0,'L',1);
$pdf->SetY(20);$pdf->SetX(145);
$pdf->Cell(90,0,$patente,0,0,'L',1);
$pdf->SetFont('Arial','B',13);




$pdf->SetY($y_axis_initial);

$pdf->SetFont('Arial','B',14);
		//Go to next row
		$y_axis = 34;
		
		//Set $i variable to 0 (first row)
		$i = 0;

	
	
	$sql  = "SELECT * ";/*$y_axis_d=74;12/12/2011*/$y_axis_d=42;$pdf->SetY($y_axis_d);$pdf->SetFont('Times','',8);
	$sql .= "FROM detail_commandes where commande='$numero' ORDER BY sans_remise;";
	$users1 = db_query($database_name, $sql);
	while($row1 = fetch_array($users1))
	{
		$produit=$row1["produit"]; $id=$row1["id"];$m=$row1["quantite"]*$row1["prix_unit"]*$row1["condit"];
		$quantite=$row1["quantite"];$condit=$row1["condit"];$prix_unit=$row1["prix_unit"];$sans_remise_a=$row1["sans_remise"];
	if (!$sans_remise_a){$brut=$brut+($prix_unit*$quantite*$condit);$input="";}
	else{$brut_sans=$brut_sans+($prix_unit*$quantite*$condit);$input="SR";}
	$pdf->SetY($y_axis_d);
	$pdf->SetX(7);
	$pdf->Cell(25,0,$input,0,0,'L',1);
	$pdf->Cell(90,0,$produit,0,0,'L',1);
	$pdf->Cell(25,0,$quantite."x".$condit,0,0,'C',1);
	$pdf->Cell(30,0,number_format($prix_unit,2,',',' '),0,0,'R',1);
	$pdf->Cell(30,0,number_format($prix_unit*$quantite*$condit,2,',',' '),0,0,'R',1);
	$y_axis_d = $y_axis_d + $row_height;
	
	if ($y_axis_d>150)
	{
			$pdf->SetY($y_axis_d);$pdf->SetX(5);
			$pdf->Cell(25,0,$input,0,0,'L',1);
			$pdf->Cell(90,0,$input,0,0,'L',1);
			$pdf->Cell(25,0,$input,0,0,'C',1);$pdf->SetFont('Times','',10);
			$pdf->Cell(30,0,'Total à Repporter',0,0,'R',0);
			$pdf->Cell(30,0,number_format($brut+$brut_sans,2,',',' '),0,0,'R',0);
			$pdf->AddPage();$pdf->SetFont('Times','',12);
			
			////////////////////le12/11/2011
			
			$pdf->SetY(28);$t_show="BON DE LIVRAISON  $bl  ";
			$pdf->SetX(70);
			$pdf->SetFont('Arial','B',14);
			$pdf->Cell(80,0,$t_show,0,0,'C',0);
			$pdf->SetY(54);
			$pdf->SetX(35);
			$pdf->Cell(34,0,$d,0,0,'L',1);
			$pdf->SetY(40);$pdf->SetX(142);
			$pdf->Cell(90,0,$client,0,0,'L',1);
			$pdf->SetY($y_axis_initial);
			$y_axis_d=74;$pdf->SetY($y_axis_d);
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
	/*$y=156;le 12/12/2011*/$y=126;
	$pdf->SetY($y);$pdf->SetX(150);
	$pdf->Cell(30,0,'Total Net',0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut,2,',',' '),0,0,'R',1);
	$chiffres=$brut;
	$pdf->SetFont('Times','',12);
	$centimes=substr(number_format($chiffres-floor($chiffres), 2, ',', ' '),-2);
	if ($centimes=="00"){$centimes="";}else {$centimes=$centimes." cts";}
	$pdf->SetX(15);$texte="Arretee le present Bon de Livraison a la somme de : ";
 	$pdf->Cell(150,0,$texte,0,0,'L',1);	$y=$y+5;$pdf->SetY($y);$pdf->SetX(15);
 	$pdf->Cell(150,0,$lettres.' '.$centimes,0,0,'L',1);
	$y=$y+10;$pdf->SetY($y);$pdf->SetX(15);$tva=($brut-($brut*$remise3/100)+$brut_sans)/1.20*0.20;
	$tva=number_format($tva, 2, ',', ' ');
 	$pdf->Cell(150,0,'Dont TVA 20 % : '.$tva,0,0,'L',1);
	$y=$y+11.5;$pdf->SetY($y);$pdf->SetX(115);
	$pdf->Cell(150,0,'XXXXXXXXXXXXX 19 000 000,00 DHS ',0,0,'L',1);
	}
	 else
	  {
	/*$y=156;le 12/12/2011*/$y=126;
	$pdf->SetY($y);$pdf->SetX(150);
	$pdf->Cell(30,0,'Total Brut',0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut,2,',',' '),0,0,'R',1);
	
	if ($remise10<>0){$y=$y+4;
	$pdf->SetY($y);$pdf->SetX(150);$r10='Remise '.$remise10.' %';
	$pdf->Cell(30,0,$r10,0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut*$remise10/100,2,',',' '),0,0,'R',1);
	$y=$y+4;
	$pdf->SetY($y);$pdf->SetX(150);
	$pdf->Cell(30,0,'1er Net',0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut-($brut*$remise10/100),2,',',' '),0,0,'R',1);
	$brut=$brut-($brut*$remise10/100);
	}
	if ($remise2<>0){$y=$y+4;
	$pdf->SetY($y);$pdf->SetX(150);$r2='Remise '.$remise2.' %';
	$pdf->Cell(30,0,$r2,0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut*$remise2/100,2,',',' '),0,0,'R',1);
	$y=$y+4;
	$pdf->SetY($y);$pdf->SetX(150);
	$pdf->Cell(30,0,'2eme Net',0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut-($brut*$remise2/100),2,',',' '),0,0,'R',1);
	$brut=$brut-($brut*$remise2/100);
	}
	if ($remise3<>0){$y=$y+4;
	$pdf->SetY($y);$pdf->SetX(150);$r3='Remise '.$remise3.' %';
	$pdf->Cell(30,0,$r3,0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut*$remise3/100,2,',',' '),0,0,'R',1);
	$y=$y+4;
	$pdf->SetY($y);$pdf->SetX(150);
	$pdf->Cell(30,0,'3eme Net',0,0,'L',1);
	$pdf->Cell(30,0,number_format($brut-($brut*$remise3/100),2,',',' '),0,0,'R',1);
	}
	$y=$y+4;$pdf->SetY($y);$pdf->SetX(150);
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
	$pdf->SetX(15);$texte="Arretee le present Bon de Livraison a la somme de : ";
 	$pdf->Cell(150,0,$texte,0,0,'L',1);	$y=$y+4;$pdf->SetY($y);$pdf->SetX(15);
 	$pdf->Cell(150,0,$lettres.' '.$centimes,0,0,'L',1);

	$y=$y+9;$pdf->SetY($y);$pdf->SetX(15);$tva=($brut-($brut*$remise3/100)+$brut_sans)/1.20*0.20;
	$tva=number_format($tva, 2, ',', ' ');
 	$pdf->Cell(150,0,'Dont TVA 20 % : '.$tva,0,0,'L',1);
	$y=$y+11.5;$pdf->SetY($y);$pdf->SetX(115);
	$pdf->Cell(150,0,'XXXXXXXXXXXXX 19 000 000,00 DHS ',0,0,'L',1);
	}
	
	
		


$pdf->Output();
?>
