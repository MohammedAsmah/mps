<?php
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";	
	$date1=$_GET['date1'];
	$date2=$_GET['date2'];

	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	

include 'class.ezpdf.php';	// inclusion du code de la bibliothèque
$pdf = & new Cezpdf();	// constructeur de la classe EZPDF
$pdf->Cezpdf('a4','paysage');
$pdf->selectFont('.\fonts\Helvetica.afm');
$pdf->SetTextColor(220,50,50);
$datej=date("d/m/Y");
$pdf->addText(40,820,14, 'Planning Riad des Oliviers'); 
$pdf->addText(240,820,14, 'Edite le : '.$datej);

$ligne=750;

$pdf->setLineStyle(1);
/*$pdf->line(5, 615, 585, 615);
$pdf->line(5, 635, 585, 635);
$pdf->line(5, 70, 5, 635);
$pdf->line(135, 70, 135, 635);
$pdf->line(420, 70, 420, 635);
$pdf->line(470, 70, 470, 635);
$pdf->line(525, 70, 525, 635);
$pdf->line(585, 70, 585, 635);

$pdf->addText(20, 620, 14, 'Ref');
$pdf->addText(150, 620, 14, 'Noms');
$pdf->addText(255, 620, 14, 'Reservation');
$pdf->addText(420, 620, 14, 'Arrivee');
$pdf->addText(475, 620, 14, 'Depart');
$pdf->addText(530, 620, 14, 'Montant');*/

			$x=750;$y=100;				
			$pdf->line(20, $x+15, 563, $x+15);
			
			/*for ($compteur=1;$compteur<=31;$compteur++)
			{ 
				$pdf->line($y-3, $x+15, $y-3, 90);
				$pdf->addText($y, $x, 10, $compteur);$y=$y+15;
			 }*/ 
	
	
	$sql  = "SELECT * ";$x=750;$vide="";
	$sql .= "FROM rs_data_chambres where last_name<>'$vide' ORDER BY tri;";
	$users = db_query($database_name, $sql);$nuites=0;

	while($users_ = fetch_array($users)) 
		{ 
		 		$chambre=$users_["last_name"];
				$pdf->addText(22, $x-20, 10, $chambre);$y=100;
				$pdf->line(20, $x-5, 563, $x-5);
				$sql  = "SELECT * ";$x=$x-20;
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
						
						/*$v="x";*/$long=15;$taille=6;if ($etat=="EN OPTION"){$pdf->selectFont('calligra.afm');$taille=6;}
						
						
						if ($jj=="01"){$point=$y;$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="02"){$point=$y+($long*1);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="03"){$point=$y+($long*2);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="04"){$point=$y+($long*3);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="05"){$point=$y+($long*4);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="06"){$point=$y+($long*5);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="07"){$point=$y+($long*6);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="08"){$point=$y+($long*7);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="09"){$point=$y+($long*8);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="10"){$point=$y+($long*9);$pdf->addText($point, $x, $taille, $v);}

						if ($jj=="11"){$point=$y+($long*10);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="12"){$point=$y+($long*11);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="13"){$point=$y+($long*12);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="14"){$point=$y+($long*13);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="15"){$point=$y+($long*14);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="16"){$point=$y+($long*15);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="17"){$point=$y+($long*16);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="18"){$point=$y+($long*17);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="19"){$point=$y+($long*18);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="20"){$point=$y+($long*19);$pdf->addText($point, $x, $taille, $v);}

						if ($jj=="21"){$point=$y+($long*20);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="22"){$point=$y+($long*21);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="23"){$point=$y+($long*22);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="24"){$point=$y+($long*23);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="25"){$point=$y+($long*24);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="26"){$point=$y+($long*25);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="27"){$point=$y+($long*26);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="28"){$point=$y+($long*27);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="29"){$point=$y+($long*28);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="30"){$point=$y+($long*29);$pdf->addText($point, $x, $taille, $v);}
						if ($jj=="31"){$point=$y+($long*30);$pdf->addText($point, $x, $taille, $v);}

				 }
	 }

			$pdf->line(20, 785, 20, $x-10);
			$pdf->line(563, 785, 563, $x-10);
			for ($compteur=1;$compteur<=31;$compteur++)
			{ 
				$pdf->line($y-3, 785, $y-3, $x-10);
				$pdf->addText($y, 750, 10, $compteur);$y=$y+15;
			 } 
			$pdf->line(20, 785, 563, 785);
			$pdf->line(20, $x-10, 563, $x-10);
			

				/*$sql  = "SELECT * ";$vide="";
				$sql .= "FROM rs_data_clients where last_name<>'$vide' ORDER BY last_name;";
				$users110 = db_query($database_name, $sql);
				$l=$x-40;
				while($users111_ = fetch_array($users110)) 
				{ 
				$pdf->addText(22, $l, 8, $users111_["last_name"].'--->'.$users111_["remarks"]);
				$l=$l-12;
				}*/
				

$pdf->ezStream();		// envoi du fichier au navigateur


?>
