<?php
require('../fpdf.php');
require "..\config.php";
require "..\connect_db.php";
require "..\functions.php";
CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
$profile_id = GetUserProfile();
$user_name=GetUserName();
$error_message = "";
$type_service="SEJOURS ET CIRCUITS";	
$date1=$_GET['date1'];
$date2=$_GET['date2'];
$datej=date("d/m/Y");
class PDF extends FPDF
{
//En-tête
function Header()
{
    //Logo
	$datej=date("d/m/Y");
    $this->Image('logo_pb.png',10,8,33);
    //Police Arial gras 15
    $this->SetFont('Arial','B',15);
	$this->SetFillColor(200,220,255);
    //Décalage à droite
    $this->Cell(80);
    //Titre
    $this->Cell(30,10,'Planning Riad des Oliviers',0,0,'C');
    $this->Cell(120,10,'Edité le : '.$datej,0,0,'C');
	//Saut de ligne
  	$this->Ln(20);
}

//Pied de page
function Footer()
{
    //Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    //Police Arial italique 8
    $this->SetFont('Arial','I',8);
    //Numéro de page
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
function LoadData($file)
{
    //Lecture des lignes du fichier
    $lines=file($file);
    $data=array();
    foreach($lines as $line)
        $data[]=explode(';',chop($line));
    return $data;
}
function FancyTable($header,$data)
{
    //Couleurs, épaisseur du trait et police grasse
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //En-tête
    $w=array(40,35,45,40);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',1);
    $this->Ln();
    //Restauration des couleurs et de la police
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    //Données
    $fill=false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,number_format($row[2],0,',',' '),'LR',0,'R',$fill);
        $this->Cell($w[3],6,number_format($row[3],0,',',' '),'LR',0,'R',$fill);
        $this->Ln();
        $fill=!$fill;
    }
    $this->Cell(array_sum($w),0,'','T');
}
}
$pdf=new FPDF('P','mm','A4');
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
/*$pdf->FancyTable($header,$data);*/
$pdf->setLineWidth(0);
$pdf->line(5, 30, 5, 250);
$colone=40;$num=200;			
$pdf->line(5, 30, 210, 30);$text="test";
$x=GetX();$y=GetY();
$pdf->Cell($x, $y, $text);
			for ($compteur=1;$compteur<=31;$compteur++)
			{ 
				$pdf->line($colone-1, 30, $colone-1, 250);
				$text.=" ".$compteur;
				$colone=$colone+6;
			 } 
			 
			 $pdf->Cell($num, 10, $text);$pdf->Ln();
	
	/*$sql  = "SELECT * ";$x=30;$vide="";
	$sql .= "FROM rs_data_chambres where last_name<>'$vide' ORDER BY tri;";
	$users = db_query($database_name, $sql);$nuites=0;$ligne=20;

	while($users_ = fetch_array($users)) 
		{ 
		 		$chambre=$users_["last_name"];
				$pdf->Cell(15,$ligne,$chambre);
				$pdf->Ln(3);
				$y=100;$ligne=$ligne+5;
				/*$pdf->line(20, $x-5, 563, $x-5);*/
				/*$sql  = "SELECT * ";
				$sql .= "FROM rs_data_plan where chambre='$chambre' and (date between '$date1' and '$date2') ORDER BY date;";
				$users1 = db_query($database_name, $sql);
				while($users1_ = fetch_array($users1)) 
				{ 
				 		list($annee1,$mois1,$jour1) = explode('-', $users1_["date"]);
						$t = mktime(0,0,0,$mois1,$jour1,$annee1); $nuites=$nuites+1;
						$jj=date("d",$t);$client=$users1_["booking"];$etat = $users1_["etat"];
						$sql  = "SELECT * ";
						$sql .= "FROM rs_data_clients where last_name='$client' ORDER BY last_name;";
						$users111 = db_query($database_name, $sql);$user_ = fetch_array($users111);$v = $user_["remarks"];
						
						$long=15;$taille=6;if ($etat=="EN OPTION")
						{$pdf->SetTextColor(255);$taille=6;}
						else
						{$pdf->SetTextColor(0);$taille=6;}
						
						
						if ($jj=="01"){$point=$y;$pdf->Cell($point, $x, $v);}
						if ($jj=="02"){$point=$y+($long*1);$pdf->Cell($point, $x,  $v);}
						if ($jj=="03"){$point=$y+($long*2);$pdf->Cell($point, $x, $v);}
						if ($jj=="04"){$point=$y+($long*3);$pdf->Cell($point, $x,  $v);}
						if ($jj=="05"){$point=$y+($long*4);$pdf->Cell($point, $x,  $v);}
						if ($jj=="06"){$point=$y+($long*5);$pdf->Cell($point, $x,  $v);}
						if ($jj=="07"){$point=$y+($long*6);$pdf->Cell($point, $x,  $v);}
						if ($jj=="08"){$point=$y+($long*7);$pdf->Cell($point, $x,  $v);}
						if ($jj=="09"){$point=$y+($long*8);$pdf->Cell($point, $x,  $v);}
						if ($jj=="10"){$point=$y+($long*9);$pdf->Cell($point, $x,  $v);}

						if ($jj=="11"){$point=$y+($long*10);$pdf->Cell($point, $x,  $v);}
						if ($jj=="12"){$point=$y+($long*11);$pdf->Cell($point, $x,  $v);}
						if ($jj=="13"){$point=$y+($long*12);$pdf->Cell($point, $x,  $v);}
						if ($jj=="14"){$point=$y+($long*13);$pdf->Cell($point, $x,  $v);}
						if ($jj=="15"){$point=$y+($long*14);$pdf->Cell($point, $x,  $v);}
						if ($jj=="16"){$point=$y+($long*15);$pdf->Cell($point, $x,  $v);}
						if ($jj=="17"){$point=$y+($long*16);$pdf->Cell($point, $x,  $v);}
						if ($jj=="18"){$point=$y+($long*17);$pdf->Cell($point, $x,  $v);}
						if ($jj=="19"){$point=$y+($long*18);$pdf->Cell($point, $x,  $v);}
						if ($jj=="20"){$point=$y+($long*19);$pdf->Cell($point, $x,  $v);}

						if ($jj=="21"){$point=$y+($long*20);$pdf->Cell($point, $x,  $v);}
						if ($jj=="22"){$point=$y+($long*21);$pdf->Cell($point, $x,  $v);}
						if ($jj=="23"){$point=$y+($long*22);$pdf->Cell($point, $x,  $v);}
						if ($jj=="24"){$point=$y+($long*23);$pdf->Cell($point, $x,  $v);}
						if ($jj=="25"){$point=$y+($long*24);$pdf->Cell($point, $x,  $v);}
						if ($jj=="26"){$point=$y+($long*25);$pdf->Cell($point, $x,  $v);}
						if ($jj=="27"){$point=$y+($long*26);$pdf->Cell($point, $x,  $v);}
						if ($jj=="28"){$point=$y+($long*27);$pdf->Cell($point, $x,  $v);}
						if ($jj=="29"){$point=$y+($long*28);$pdf->Cell($point, $x,  $v);}
						if ($jj=="30"){$point=$y+($long*29);$pdf->Cell($point, $x,  $v);}
						if ($jj=="31"){$point=$y+($long*30);$pdf->Cell($point, $x,  $v);}

				 }
	 }

			/*$pdf->line(20, 785, 20, $x-10);
			$pdf->line(563, 785, 563, $x-10);*/
			/*for ($compteur=1;$compteur<=31;$compteur++)
			{ 
				/*$pdf->line($y-3, 785, $y-3, $x-10);
				$pdf->Cell($y, 750, 10, $compteur);$y=$y+15;
			 }*/ 
			/*$pdf->line(20, 785, 563, 785);
			$pdf->line(20, $x-10, 563, $x-10);*/	
		
$pdf->Output();
?>
