<?php
	require "fpdf.php";
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
	$numero=$_GET['numero'];$client=$_GET['client'];$montant_f=0;$bon_sortie = $_GET['bon_sortie'];$destination = $_GET['destination'];
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

		$ville = $user_1["ville"];



//Create new pdf file
$pdf=new FPDF('P','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;

//print column titles for the actual page
$pdf->SetFillColor(255);$entete=30;
$pdf->SetY(5+$entete);
$pdf->SetFont('arial','B',18);
$pdf->Cell(70,14,'',0,0,'L',1);

$pdf->SetFillColor(255);
$pdf->SetFont('arial','B',14);
$pdf->SetX(130);$d="Marrakech le : ".$date;
$pdf->Cell(25,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','',12);
/*$pdf->SetY(20+$entete);$pdf->SetX(10);$d="Vendeur : ".$vendeur;
$pdf->Cell(40,10,$d,0,0,'L',1);*/

$pdf->SetY(15+$entete);$pdf->SetX(100);$d="Destination : ".$ville;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(30+$entete);$pdf->SetX(10);$d="Client : ".$client;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetFont('arial','B',12);
$pdf->SetY(46+$entete);$pdf->SetX(10);$d="  Designation Article  ";
$pdf->Cell(50,10,$d,0,0,'L',1);
$pdf->SetY(46+$entete);$pdf->SetX(85);$d="  Nbre Paquets  ";
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetY(46+$entete);$pdf->SetX(124);$d="  Quantite  ";
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetY(46+$entete);$pdf->SetX(150);$d="  Prix Unit.";
$pdf->Cell(15,10,$d,0,0,'L',1);
$pdf->SetY(46+$entete);$pdf->SetX(178);$d="  Total  ";
$pdf->Cell(10,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','',12);
$ligne=47;
	
$ligne=55+$entete;



	$sql1  = "SELECT produit,designation,id,sum(quantite) as quantite,prix_unit,condit,sub, sum(quantite*prix_unit*condit) as m ";
	$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=0 group by designation ORDER BY designation;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["designation"]; $id=$users1_["id"];$m=$users1_["m"];
		$sub=$users1_["sub"];
		$total=$total+$m;
		$qte=$users1_["quantite"];
		$condit=$users1_["condit"];
		$prix_unit=$users1_["prix_unit"];
		
	$pdf->SetY($ligne);	
	$pdf->Cell(52,6,$produit,0,0,'L',1);$pdf->SetX(94);
	$pdf->Cell(10,6,$qte,0,0,'L',1);$pdf->SetX(105);
	$pdf->Cell(10,6,' X ',0,0,'L',1);$pdf->SetX(116);
	$pdf->Cell(20,6,$condit,0,0,'L',1);$pdf->SetX(130);
	$pdf->Cell(30,6,$qte*$condit,0,0,'L',1);$d=number_format($prix_unit,2,',',' ');$pdf->SetX(150);
	$pdf->Cell(30,6,$d,0,0,'L',1);$d=number_format($qte*$condit*$prix_unit,2,',',' ');$pdf->SetX(180);
	$pdf->Cell(30,6,$d,0,0,'L',1);
	
	
		if ($ligne>=240){$pdf->Line(3,$ligne+5,205,$ligne+5);
$pdf->SetFont('Courier','',10);$pdf->SetY($ligne+7);
$pdf->SetX(130);$d="A repporter";
$pdf->Cell(40,10,$d,0,0,'L',1);
//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;

//print column titles for the actual page
$pdf->SetFillColor(255);$entete=30;
$pdf->SetY(5+$entete);
$pdf->SetFont('arial','B',18);
$pdf->Cell(70,14,'',0,0,'L',1);

$pdf->SetFillColor(255);
$pdf->SetFont('arial','B',14);
$pdf->SetX(130);$d="Marrakech le : ".$date;
$pdf->Cell(25,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','',12);
/*$pdf->SetY(20+$entete);$pdf->SetX(10);$d="Vendeur : ".$vendeur;
$pdf->Cell(40,10,$d,0,0,'L',1);*/

$pdf->SetY(15+$entete);$pdf->SetX(100);$d="Destination : ".$destination;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetY(30+$entete);$pdf->SetX(10);$d="Client : ".$client;
$pdf->Cell(40,10,$d,0,0,'L',1);

$pdf->SetFont('arial','B',12);
$pdf->SetY(46+$entete);$pdf->SetX(10);$d="  Designation Article  ";
$pdf->Cell(50,10,$d,0,0,'L',1);
$pdf->SetY(46+$entete);$pdf->SetX(85);$d="  Nbre Paquets  ";
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetY(46+$entete);$pdf->SetX(124);$d="  Quantite  ";
$pdf->Cell(30,10,$d,0,0,'L',1);
$pdf->SetY(46+$entete);$pdf->SetX(150);$d="  Prix Unit.";
$pdf->Cell(15,10,$d,0,0,'L',1);
$pdf->SetY(46+$entete);$pdf->SetX(178);$d="  Total  ";
$pdf->Cell(10,10,$d,0,0,'L',1);

$pdf->SetFont('Courier','',12);
$ligne=47;
$ligne=55+$entete;
}else{


			$ligne=$ligne+5;
}


			
		 }
/////////////////////////////////		 
		
////////////////////////

$x=140;	$h=5;	$pdf->SetFont('Courier','',11);

if ($sans_remise==1){
					$d="Net a payer : ". number_format($total,2,',',' ');
					$pdf->SetY($ligne+$h);$pdf->SetX($x);$h=$h+5;
					$pdf->Cell(30,6,$d,0,0,'L',1);
 } 

 else {
					
					$pdf->SetY($ligne+$h);$pdf->SetX($x);$h=$h+5;
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
					
					/*if ($remise3>0){
					if ($remise3==2){$r3="Remise 2% :";
					}else{$r3="Remise 3% :";}
					$remise_3=($total-$remise_1-$remise_2)*$remise3/100;
					
					$d=$r3." ". number_format($remise_3,2,',',' ');
					$pdf->SetY($ligne+$h);$pdf->SetX($x);$h=$h+5;
					$pdf->Cell(30,6,$d,0,0,'L',1);	
					
					$d="3eme Net : ". number_format($total-$remise_1-$remise_2-$remise_3,2,',',' ');
					$pdf->SetY($ligne+$h);$pdf->SetX($x);$h=$h+5;
					$pdf->Cell(30,6,$d,0,0,'L',1);
					}*/
					$remise_3=0;
					$net=$total-$remise_1-$remise_2-$remise_3;$net=$total-$remise_1-$remise_2-$remise_3;
					$d="Net : ". number_format($net,2,',',' ');
					$pdf->SetY($ligne+$h);$pdf->SetX($x);$h=$h+5;
					$pdf->Cell(30,6,$d,0,0,'L',1);

	
					
					
					$l=$ligne+$h+20;
					
					
									//////////
						$total1=0;
	$sql1  = "SELECT produit,designation,id,sum(quantite) as quantite,prix_unit,condit,sub, sum(quantite*prix_unit*condit) as m ";
	$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=1 group by designation ORDER BY designation;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 

				$produit=$users1_["designation"]; $id=$users1_["id"];$m=$users1_["m"];
		$sub=$users1_["sub"];
		
		$qte=$users1_["quantite"];
		$condit=$users1_["condit"];
		$prix_unit=$users1_["prix_unit"];
		$total1=$total1+$m;
	$pdf->SetY($l);	
	$pdf->Cell(52,6,$produit,0,0,'L',1);$pdf->SetX(94);
	$pdf->Cell(10,6,$qte,0,0,'L',1);$pdf->SetX(100);
	$pdf->Cell(10,6,' X ',0,0,'L',1);$pdf->SetX(112);
	$pdf->Cell(20,6,$condit,0,0,'L',1);$pdf->SetX(130);
	$pdf->Cell(30,6,$qte*$condit,0,0,'L',1);$d=number_format($prix_unit,2,',',' ');
	$pdf->Cell(30,6,$d,0,0,'L',1);$d=number_format($qte*$condit*$prix_unit,2,',',' ');$pdf->SetX(180);
	$pdf->Cell(30,6,$d,0,0,'L',1);

	$l=$l+5;

		 }
//////
				$d="Net a payer : ". number_format($net+$total1,2,',',' ');
					$pdf->SetY($l+5);$pdf->SetX($x);
					$pdf->Cell(30,6,$d,0,0,'L',1);	

}

					$pdf->SetY(285);$pdf->SetX(180);
					$pdf->Cell(30,6,$evaluation,0,0,'L',1);



$pdf->Output();		// envoi du fichier au navigateur

