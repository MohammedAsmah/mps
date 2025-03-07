<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	require "fpdf.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
	$numero=$_GET['numero'];$client=$_GET['client'];$montant_f=0;
	$bon_sortie = $_GET['bon_sortie'];$destination = $_GET['destination'];
	$id = $numero;
		$sql  = "SELECT * ";
		$sql .= "FROM avoirs WHERE id = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_e"]);
		$client = $user_["client"];$montant_f = $user_["net"];$bon_e = $user_["be"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise_e = $user_["sans_remise"];$remise3 = $user_["remise_3"];$remise4 = $user_["remise_4"];$matricule = $user_["matricule"];
		$mode = $user_["mode"];
		$sql1  = "SELECT * ";
		$sql1 .= "FROM clients WHERE client = '$client' ";
		$user1 = db_query($database_name, $sql1); $user_1 = fetch_array($user1);
		$remise10 = 10;$remise2 = $user_1["remise2"];
		$sans_remise = $user_1["sans_remise"];$remise3 = $user_1["remise3"];$escompte = $user_1["escompte"];
		
		

		$ville = $user_1["ville"];$vendeur = $user_1["vendeur_nom"];



//Create new pdf file
$pdf=new FPDF('P','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;

//print column titles for the actual page
$pdf->SetFillColor(255);$entete=5;

$pdf->SetFont('arial','B',14);
$pdf->SetY(2);
$pdf->SetX(10);
$pdf->Cell(70,14,'M.P.S',0,0,'L',1);
$pdf->SetY(1+$entete);
$pdf->SetX(100);
$pdf->Cell(70,14,'AVOIR',0,0,'L',1);

$pdf->SetFillColor(255);

$pdf->SetFont('Courier','',12);$pdf->SetY(7+$entete);
$pdf->SetX(10);$d="Numero B.E : ".$bon_e;
$pdf->Cell(25,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','',10);$pdf->SetY(2+$entete);
$pdf->SetX(130);$d="Liquidation  Client  -- le :";
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(10+$entete);$pdf->SetX(130);$d="Commercial  -- le :";
$pdf->Cell(40,10,$d,0,0,'L',1);


$pdf->SetY(14+$entete);$pdf->SetX(10);$d="Vendeur : ".$vendeur;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(25+$entete);$pdf->SetX(130);$d="Client : ".$client;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(31+$entete);$pdf->SetX(10);$d="Ville : ".$ville;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(21+$entete);$pdf->SetX(10);$d="Transport : ".$matricule;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(31+$entete);$pdf->SetX(130);$d="Date : ".$date;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetLineWidth(0.3);
/*$pdf->Line(3,3,205,3);*/
$pdf->Line(3,47,205,47);
$pdf->Line(3,60,205,60);
$pdf->Line(3,47,3,60);
$pdf->Line(205,47,205,60);
/*$pdf->Line(3,3,3,60);
$pdf->Line(205,3,205,60);*/
$pdf->SetFont('arial','',10);
$pdf->SetY(43+$entete);$pdf->SetX(20);$d="  Designation Article  ";
$pdf->Cell(50,10,$d,0,0,'L',1);
$pdf->SetY(43+$entete);$pdf->SetX(124);$d="  Nbre Piece  ";
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetY(43+$entete);$pdf->SetX(155);$d="  Prix Unit.";
$pdf->Cell(15,10,$d,0,0,'L',1);
$pdf->SetY(43+$entete);$pdf->SetX(178);$d="  Total  ";
$pdf->Cell(10,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','',8);
$ligne=47;
	/*$pdf->Line(87,$ligne,87,$ligne+18);*/
	$pdf->Line(117,$ligne,117,$ligne+18);
	$pdf->Line(155,$ligne,155,$ligne+18);
	$pdf->Line(179,$ligne,179,$ligne+18);



$pdf->Line(3,60,3,65);$pdf->Line(205,60,205,65);
	
$ligne=57+$entete;


	$sql1  = "SELECT produit,sum(quantite) As qte,condit,prix_unit ";
	$sql1 .= "FROM detail_avoirs where commande='$numero' and sans_remise=0 GROUP BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;$articles=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["qte"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
		$total=$total+$m;
		$qte=$users1_["qte"];
		$condit=$users1_["condit"];
		$prix_unit=$users1_["prix_unit"];
		
		if ($ligne>=250){$pdf->Line(3,$ligne,205,$ligne);
$pdf->SetFont('Courier','',10);$pdf->SetY($ligne+2);
$pdf->SetX(120);$d="Total Brut ".number_format($total-$m,2,',',' ');
$pdf->Cell(40,10,$d,0,0,'L',1);
		//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;

//print column titles for the actual page
$pdf->SetFillColor(255);$entete=5;
$pdf->SetY(1+$entete);
$pdf->SetFont('arial','B',14);$pdf->SetX(100);
$pdf->Cell(70,14,'AVOIR',0,0,'L',1);

$pdf->SetFillColor(255);
$pdf->SetFont('Courier','',12);$pdf->SetY(7+$entete);
$pdf->SetX(10);$d="Numero B.E : ".$bon_e;
$pdf->Cell(25,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','',10);$pdf->SetY(2+$entete);
$pdf->SetX(130);$d="Liquidation  Client  -- le :";
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(10+$entete);$pdf->SetX(130);$d="Commercial  -- le :";
$pdf->Cell(40,10,$d,0,0,'L',1);


$pdf->SetY(14+$entete);$pdf->SetX(10);$d="Vendeur : ".$vendeur;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(23+$entete);$pdf->SetX(130);$d="Client : ".$client;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(30+$entete);$pdf->SetX(10);$d="Ville : ".$ville;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(20+$entete);$pdf->SetX(10);$d="Transport : ".$matricule;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(30+$entete);$pdf->SetX(130);$d="Date : ".$date;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetLineWidth(0.3);
/*$pdf->Line(3,3,205,3);*/
$pdf->Line(3,47,205,47);
$pdf->Line(3,60,205,60);
$pdf->Line(3,47,3,60);
$pdf->Line(205,47,205,60);
/*$pdf->Line(3,3,3,60);
$pdf->Line(205,3,205,60);*/

$pdf->SetFont('arial','',10);
$pdf->SetY(43+$entete);$pdf->SetX(20);$d="  Designation Article  ";
$pdf->Cell(50,10,$d,0,0,'L',1);
$pdf->SetY(43+$entete);$pdf->SetX(124);$d="  Nbre Piece  ";
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetY(43+$entete);$pdf->SetX(155);$d="  Prix Unit.";
$pdf->Cell(15,10,$d,0,0,'L',1);
$pdf->SetY(43+$entete);$pdf->SetX(178);$d="  Total  ";
$pdf->Cell(10,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','',8);
$ligne=47;
	/*$pdf->Line(87,$ligne,87,$ligne+18);*/
	$pdf->Line(117,$ligne,117,$ligne+18);
	$pdf->Line(155,$ligne,155,$ligne+18);
	$pdf->Line(179,$ligne,179,$ligne+18);



$pdf->Line(3,60,3,65);$pdf->Line(205,60,205,65);
	
$ligne=57+$entete;}



		$pdf->SetY($ligne);	
		$pdf->Cell(50,6,$produit,0,0,'L',1);$pdf->SetX(125);
		$pdf->Cell(10,6,$qte,0,0,'L',1);$pdf->SetX(160);
		$d=number_format($prix_unit,2,',',' ');
		$pdf->Cell(30,6,$d,0,0,'L',1);$d=number_format($qte*$condit*$prix_unit,2,',',' ');$pdf->SetX(180);
		$pdf->Cell(30,6,$d,0,0,'L',1);
	   	$pdf->Line(3,$ligne,3,$ligne+5);
		$pdf->Line(117,$ligne,117,$ligne+5);
		$pdf->Line(155,$ligne,155,$ligne+5);
		$pdf->Line(179,$ligne,179,$ligne+5);
		$pdf->Line(205,$ligne,205,$ligne+5);
			$ligne=$ligne+4;$article=$article+1;
			
		 }
$pdf->Line(3,$ligne,205,$ligne);

/////////////////////////////////		 
		
////////////////////////		

/*if ($ligne>=250){$pdf->Line(3,$ligne,205,$ligne);
$pdf->SetFont('Courier','',10);$pdf->SetY($ligne+2);
$pdf->SetX(130);$d="A repporter : ".number_format($m,2,',',' ');
$pdf->Cell(40,10,$d,0,0,'L',1);
	
$pdf->AddPage();}
*/


$x=140;	$h=5;	$pdf->SetFont('Courier','',10);

if ($sans_remise_e==1){
					$d="Net a payer : ". number_format($total,2,',',' ');
					$pdf->SetY($ligne+$h);$pdf->SetX($x);$h=$h+5;
					$pdf->Cell(30,6,$d,0,0,'L',1);
 } 

 else {
					
					$pdf->SetY($ligne+$h);$pdf->SetX($x-5);$h=$h+5;
					$d="Total Brut: ". number_format($total,2,',',' ');
					$pdf->Cell(30,6,$d,0,0,'L',1);
					$remise_1=0;$remise_2=0;$remise_3=0;
					if ($remise10>0){$remise_1=$total*$remise10/100; 
					$pdf->SetY($ligne+$h);$pdf->SetX($x);$h=$h+5;
					$d="Remise 10% : ". number_format($remise_1,2,',',' ');
					$pdf->Cell(30,6,$d,0,0,'L',1);						
					}

					$d="1er Net : ". number_format($total-$remise_1,2,',',' ');
					$pdf->SetY($ligne+$h);$pdf->SetX($x);$h=$h+5;
					$pdf->Cell(30,6,$d,0,0,'L',1);

					if ($remise2>0){
					if ($remise2==2){$remise_2=($total-$remise_1)*$remise2/100;
					$pdf->SetY($ligne+$h);$pdf->SetX($x);$h=$h+5;
					
					$d="Remise 2% : ". number_format($remise_2,2,',',' ');
					$pdf->Cell(30,6,$d,0,0,'L',1);
					}
					
					$d="2eme Net : ". number_format($total-$remise_1-$remise_2,2,',',' ');
					$pdf->SetY($ligne+$h);$pdf->SetX($x);$h=$h+5;
					$pdf->Cell(30,6,$d,0,0,'L',1);
					}
					
					if ($remise3>0){
					if ($remise3==2){$r3="Remise 2% :";
					}else{$r3="Remise 3% :";}
					if ($ville == "OUJDA"){$remise_3=0;}
					else {$remise_3=($total-$remise_1-$remise_2)*$remise3/100;}
					
					$d=$r3." ". number_format($remise_3,2,',',' ');
					$pdf->SetY($ligne+$h);$pdf->SetX($x);$h=$h+5;
					$pdf->Cell(30,6,$d,0,0,'L',1);	
					
					$d="3eme Net : ". number_format($total-$remise_1-$remise_2-$remise_3,2,',',' ');
					$pdf->SetY($ligne+$h);$pdf->SetX($x);$h=$h+5;
					$pdf->Cell(30,6,$d,0,0,'L',1);
					}
					
					if ($escompte>0){$r4="Escompte 2% : ";$remise_4=($total-$remise_1-$remise_2-$remise_3)*$escompte/100;
					$d=$r4." ". number_format($remise_4,2,',',' ');
					$pdf->SetY($ligne+$h);$pdf->SetX($x);$h=$h+5;
					$pdf->Cell(30,6,$d,0,0,'L',1);	
					}
					
					
					
					if ($ligne>=260){$pdf->Line(3,$ligne,205,$ligne);
					$pdf->SetFont('Courier','',10);$pdf->SetY($ligne+2);
					$pdf->SetX(120);$d="A repporter ";
					$pdf->Cell(40,10,$d,0,0,'L',1);
					//Add first page
					$pdf->AddPage();
					$ligne=57+$entete;
					}
					else {
					
					$net=$total-$remise_1-$remise_2-$remise_3-$remise_4;
					$d="Net : ". number_format($net,2,',',' ');
					$pdf->SetY($ligne+$h);$pdf->SetX($x);$h=$h+5;
					$pdf->Cell(30,6,$d,0,0,'L',1);
					}
					
									//////////
						$sql1  = "SELECT * ";$total1=0;
	$sql1 .= "FROM detail_avoirs where commande='$numero' and sans_remise=1 ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	
	if ($ligne>=250){$pdf->Line(3,$ligne,205,$ligne);
					$pdf->SetFont('Courier','',10);$pdf->SetY($ligne+2);
					$pdf->SetX(120);$d="Total brut ";
					$pdf->Cell(40,10,$d,0,0,'L',1);
					//Add first page
					$pdf->AddPage();
					$ligne=57+$entete;
					}else
					{$ligne=$ligne+$h;}
					
	
	$pdf->SetY($ligne+$h+5);	$pdf->SetX(10);$articles_s_r="";
	//$pdf->Cell(50,6,$articles_s_r,0,0,'L',1);$ligne=$ligne+$h+10;
	
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
		$total=$total+$m;
		$qte=$users1_["quantite"];
		$condit=$users1_["condit"];
		$prix_unit=$users1_["prix_unit"];
		$total1=$total1+$m;
	$pdf->SetY($ligne);	
	$pdf->Cell(50,6,$produit,0,0,'L',1);$pdf->SetX(90);
	$pdf->Cell(10,6,$qte,0,0,'L',1);$pdf->SetX(100);
	$pdf->Cell(10,6,' X ',0,0,'L',1);$pdf->SetX(112);
	$pdf->Cell(20,6,$condit,0,0,'L',1);$pdf->SetX(130);
	$pdf->Cell(30,6,$qte*$condit,0,0,'L',1);$d=number_format($prix_unit,2,',',' ');
	$pdf->Cell(30,6,$d,0,0,'L',1);$d=number_format($qte*$condit*$prix_unit,2,',',' ');$pdf->SetX(180);
	$pdf->Cell(30,6,$d,0,0,'L',1);
	
	$ligne=$ligne+5;

		 }
				
					
					if ($ligne>=250)
					
					{$pdf->Line(3,$ligne,205,$ligne);
					$pdf->SetFont('Courier','',10);$pdf->SetY($ligne+2);
					
					
					$pdf->AddPage();
					
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;


$pdf->SetFillColor(255);$entete=5;
$pdf->SetY(1+$entete);
$pdf->SetFont('arial','B',14);$pdf->SetX(100);
$pdf->Cell(70,14,'AVOIR',0,0,'L',1);

$pdf->SetFillColor(255);
$pdf->SetFont('Courier','',12);$pdf->SetY(7+$entete);
$pdf->SetX(10);$d="Numero B.E : ".$bon_e;
$pdf->Cell(25,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','',10);$pdf->SetY(2+$entete);
$pdf->SetX(130);$d="Liquidation  Client  -- le :";
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(10+$entete);$pdf->SetX(130);$d="Commercial  -- le :";
$pdf->Cell(40,10,$d,0,0,'L',1);


$pdf->SetY(14+$entete);$pdf->SetX(10);$d="Vendeur : ".$vendeur;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(23+$entete);$pdf->SetX(130);$d="Client : ".$client;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(30+$entete);$pdf->SetX(10);$d="Ville : ".$ville;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(20+$entete);$pdf->SetX(10);$d="Transport : ".$matricule;
$pdf->Cell(40,10,$d,0,0,'L',1);


$pdf->SetY(30+$entete);$pdf->SetX(130);$d="Date : ".$date;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetLineWidth(0.3);
/*$pdf->Line(3,3,205,3);*/
$pdf->Line(3,47,205,47);
$pdf->Line(3,60,205,60);
$pdf->Line(3,47,3,60);
$pdf->Line(205,47,205,60);
/*$pdf->Line(3,3,3,60);
$pdf->Line(205,3,205,60);*/

$pdf->SetFont('arial','',10);
$pdf->SetY(43+$entete);$pdf->SetX(20);$d="  Designation Article  ";
$pdf->Cell(50,10,$d,0,0,'L',1);
$pdf->SetY(43+$entete);$pdf->SetX(124);$d="  Nbre Piece  ";
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetY(43+$entete);$pdf->SetX(155);$d="  Prix Unit.";
$pdf->Cell(15,10,$d,0,0,'L',1);
$pdf->SetY(43+$entete);$pdf->SetX(178);$d="  Total  ";
$pdf->Cell(10,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','',8);
$ligne=47;
	
	$pdf->Line(117,$ligne,117,$ligne+18);
	$pdf->Line(155,$ligne,155,$ligne+18);
	$pdf->Line(179,$ligne,179,$ligne+18);



$pdf->Line(3,60,3,65);$pdf->Line(205,60,205,65);
					
					
					
					
					$ligne=57+$entete;
					}

	
					$d="Net a payer : ". number_format($net+$total1,2,',',' ');
					$pdf->SetY($ligne+2);$pdf->SetX($x);
					$pdf->Cell(30,6,$d,0,0,'L',1);
						

}
$pdf->Output();	

