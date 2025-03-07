<?php
	require('fpdf.php');
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	
	$stii=0;$ligne=0;

	 $du=dateFrToUs($_GET['du']);$au=dateFrToUs($_GET['au']);$du1=$_GET['du'];$au1=$_GET['au'];
	$debut_exercice=dateFrToUs($_GET['du']);$fin_exercice=dateFrToUs($_GET['au']);

	
//Create new pdf file
$pdf=new FPDF('L','mm','A4');

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 25;$y_axis = 25;$row_height=6;$l=25;$hauteur=4.5;

//print column titles for the actual page
$pdf->SetFillColor(255);
$pdf->SetY(5);
$pdf->SetFont('Times','',10);$jour=date("d/m/Y H:m:s");$d="MATIERES PREMIERES DU ".$du1." au ".$au1;
$pdf->Cell(100,10,$d,1,0,'L',1);
/*
$pdf->SetLineWidth(0.3);
$pdf->Line(3,3,205,3);
$pdf->Line(3,47,205,47);
$pdf->Line(3,60,205,60);
$pdf->Line(3,3,3,60);
$pdf->Line(205,3,205,60);
*/
$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t7=0;$t8=0;$t9=0;
$x1=3;$x2=108;$x3=129;$x4=150;$x5=171;$x6=192;$x7=214;$x8=235;$x9=256;
$pdf->SetY(8);$pdf->SetX(7);$d="  Designation Article  ";
$pdf->Cell(60,9,$d,0,0,'L',1);

$pdf->SetX(87);$d="S.I.M.P ";
$pdf->Cell(20,9,$d,0,0,'L',1);

$pdf->SetY(8);$pdf->SetX(108);$d="S.I.M.P.F";
$pdf->Cell(20,9,$d,0,0,'L',1);

$pdf->SetY(8);$pdf->SetX(129);$d="ACHATS M.P";
$pdf->Cell(20,9,$d,0,0,'L',1);

$pdf->SetY(8);$pdf->SetX(150);$d="CONSOMME M.P";
$pdf->Cell(20,9,$d,0,0,'L',1);

$pdf->SetY(8);$pdf->SetX(171);$d="S.F.P.F";
$pdf->Cell(20,9,$d,0,0,'L',1);

$pdf->SetY(8);$pdf->SetX(192);$d="S.F.M.P";
$pdf->Cell(20,9,$d,0,0,'L',1);

$pdf->SetY(8);$pdf->SetX(214);$d="C.M.U.P";
$pdf->Cell(20,9,$d,0,0,'L',1);

$pdf->SetY(8);$pdf->SetX(235);$d="VALEUR M.P";
$pdf->Cell(20,9,$d,0,0,'L',1);

$ligne=12;

/*$pdf->Line(87,$ligne,87,$ligne+18);
$pdf->Line(97,$ligne,97,$ligne+18);
$pdf->Line(108,$ligne,108,$ligne+18);
$pdf->Line(141,$ligne,141,$ligne+18);
$pdf->Line(164,$ligne,164,$ligne+18);


$ligne=65;$pdf->Line(3,60,3,65);$pdf->Line(205,60,205,65);

*/

	$sql  = "SELECT * ";$vide="";$mt=0;$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t7=0;$t8=0;$t9=0;
	$sql .= "FROM types_matieres where profile_name<>'$vide' and dispo=1 ORDER BY profile_name;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) {

		$stock_final_matiere=0;$stock_encours_final=0;
		$stock_initial_pf=0;$stock_final_pf=0;$stock_final=0;$encours_initial_pf=0;$encours_final_pf=0;$stock_initial=0;
 		$matiere = $users_["profile_name"];$m=0;$vfm=0;
		$pdf->SetY($ligne);$pdf->SetX(7);$pdf->Cell(50,9,$matiere,0,0,'L',1);
		$sql11  = "SELECT * ";
		$sql11 .= "FROM achats_mat where produit='$matiere' and avoir_sur_prix=0 and date between '$debut_exercice' and '$fin_exercice' ORDER BY produit;";
		$users11 = db_query($database_name, $sql11);$achats=0;$prix_revient=0;
		while($users11_ = fetch_array($users11)) { 
			$produit = $users11_["produit"];
			$achats = $achats+$users11_["qte"];$prix_revient=$prix_revient+($users11_["qte"]*$users11_["prix_achat"]);
		}
		$sql1  = "SELECT * ";$d="2015-01-01";$d_exe1="2016-01-01";
		$sql1 .= "FROM report_mat_precedant where date='$d' and produit='$matiere' ORDER BY produit;";
		$users1 = db_query($database_name, $sql1);
		while($users1_ = fetch_array($users1)) { 
			$stock_initial_pf = $stock_initial_pf+$users1_["stock_final_pf"];
			$encours_initial_pf=$encours_initial_pf+$users1_["encours"];
			$stock_initial=$stock_initial+$users1_["stock_final_mp"];
			$vfm=$vfm+$users1_["valeur_final_mp"];
		}
	
	
	///
	@$cout=($vfm+$prix_revient)/($stock_initial+$achats);
	$c=$vfm."+".$prix_revient."/".$stock_initial."+".$achats;
	$production=0;$stock_final_matiere=0;
	$sql1  = "SELECT * ";
	$sql1 .= "FROM produits where matiere='$matiere' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
 		$produit = $users1_["produit"];$condit1 = $users1_["condit"];$qte=0;$poids = $users1_["poids"];$montant=0;$condit=0;
			$ma = $users1_["matiere"];
					
		$stock_final_matiere=$stock_final_matiere+($users1_["stock_final"]*$users1_["poids"]/1000);
		$stock_encours_final = $stock_encours_final+($users1_["en_cours_final"]*$users1_["poids"]/1000);
		
		$sql1  = "SELECT * ";
		$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$debut_exercice' and '$fin_exercice' ) ORDER BY produit;";
		$users11 = db_query($database_name, $sql1);
		while($users11_ = fetch_array($users11)) { 
			$qte=$qte+($users11_["quantite"]*$users11_["condit"]);
							
		}
		
		
		
			$sql1  = "SELECT * ";$pr=0;
			$sql1 .= "FROM entrees_stock_f where produit='$produit' and (date between '$debut_exercice' and '$fin_exercice' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);
			while($users11_ = fetch_array($users11)) { 
			$pr=$pr+($users11_["depot_a"]*$condit);
			}
			$production=$production+($pr*$poids/1000);
		
	if ($qte>0)
	
	{ $m=$m+($qte*$poids/1000);$mt=$mt+$m; ?><? }
	
	}
	$pdf->SetY($ligne);$pdf->SetX($x1);$pdf->Cell(10,9,$matiere,0,0,'R',1);
    $spf=0;$sm=0;$t1=$t1+$stock_initial;$si=number_format($stock_initial,3,',',' ');
	//$x1=3;$x2=108;$x3=129;$x4=150;$x5=171;$x6=192;$x7=214;$x8=235;
	$pdf->SetY($ligne);$pdf->SetX($x2);$pdf->Cell(10,9,$si,0,0,'R',1);
	$t2=$t2+$stock_initial_pf;$sipf=number_format($stock_initial_pf,3,',',' ');
	$pdf->SetY($ligne);$pdf->SetX($x3);$pdf->Cell(10,9,$sipf,0,0,'R',1);
	$ec_i=0;$ec_f=$stock_encours_final;
	/*$t3=$t3+$encours_initial_pf;$ec_i_f=number_format($encours_initial_pf,3,',',' ');
	$pdf->SetY($ligne);$pdf->SetX($x4);$pdf->Cell(10,9,$ec_i_f,0,0,'R',1);*/
	
	$t4=$t4+$achats;$ach=number_format($achats,3,',',' ');
	$pdf->SetY($ligne);$pdf->SetX($x4);$pdf->Cell(10,9,$ach,0,0,'R',1);
	$t5=$t5+$m;$maf=number_format($m,3,',',' ');
	$pdf->SetY($ligne);$pdf->SetX($x5);$pdf->Cell(10,9,$maf,0,0,'R',1);
	$mf=$stock_initial+$ec_i+($stock_initial_pf)+$achats-$m;
	$spf=$stock_final_matiere;
	$t6=$t6+$spf;
	$sm=$stock_initial+$stock_initial_pf+$encours_initial_pf+$achats-$m-$spf-$stock_encours_final;

	$smf=number_format($sm,4,',',' ');
	
	$cout_revient=0;
	
	$spfaf=number_format($spf,3,',',' ');
	$pdf->SetY($ligne);$pdf->SetX($x6);$pdf->Cell(10,9,$spfaf,0,0,'R',1);
	/*$t7=$t7+$ec_f;$ec_f_f=number_format($ec_f,3,',',' ');
	$pdf->SetY($ligne);$pdf->SetX($x8);$pdf->Cell(10,9,$ec_f_f,0,0,'R',1);*/
	$t8=$t8+$sm;$pdf->SetY($ligne);$pdf->SetX($x7);$pdf->Cell(10,9,$smf,0,0,'R',1);
	$cmup1= number_format($cout,4,',',' ');
	$cmup= $cout;$pdf->SetY($ligne);$pdf->SetX($x8);$pdf->Cell(10,9,$cmup1,0,0,'R',1);
	$t9=$t9+($cout*$sm);$coutt=number_format($cmup*$sm,2,',',' ');$v_f_m_p=$cmup*$sm;
	$pdf->SetY($ligne);$pdf->SetX($x9);$pdf->Cell(182,9,$coutt,0,0,'R',1);
			
	$ligne=$ligne+7;
	}
	
/*	
	?>

	
	

	
	
<tr>
<td></td>
	<td align="right" bgcolor="#66FF99"><? $t1= number_format($t1,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t1 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t2= number_format($t2,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t2 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t3= number_format($t3,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t3 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t4= number_format($t4,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t4 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t5= number_format($t5,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t5 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t6= number_format($t6,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t6 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t7= number_format($t7,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t7 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t8= number_format($t8,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t8 </font>");?></td>
	<td></td>
	<td align="right" bgcolor="#66FF99"><? $t_mat=$t9;$t9= number_format($t9,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t9 </font>");?></td>

<tr><td bgcolor="#66FFCC"><? echo "Tiges - Grilles - Inserts decoration";?></td><td bgcolor="#66FFCC"><? echo "Stock initial M.";?></td>
<td bgcolor="#66FFCC"><? echo "Stock initial M.P.F";?></td>
<td bgcolor="#66FFCC"><? echo "Encours 01/01";?></td>
<td bgcolor="#66FFCC"><? echo "Achats Matiere";?></td>
<td bgcolor="#66FFCC"><? echo "Consommé";?></td>
<td bgcolor="#66FFCC"><? echo "Stock final P.Fini";?></td>
<td bgcolor="#66FFCC"><? echo "Encours 31/12";?></td>
<td bgcolor="#66FFCC"><? echo "Stock final M.Prem";?></td>
<td bgcolor="#66FFCC"><? echo "C.M.U.P";?></td>

<td bgcolor="#66FFCC"><? echo "Valeur final M.Prem";?></td>

</tr>


<?	
		if(isset($_REQUEST["action"]))
		
	{

	$sql  = "SELECT * ";$vide="";$mt=0;$unites=1;$poids_unites=1;$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t7=0;$t8=0;$t9=0;
	$sql .= "FROM types_tiges where profile_name<>'$vide' ORDER BY profile_name;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) { $stock_initial_pf=0;$stock_final_pf=0;$stock_encours_final=0;
 		$tige = $users_["profile_name"];$m=0;$stock_initial = $users_["stock_initial"];$unites = $users_["unites"];
		$poids_unites = $users_["poids"];$cout_revient = $users_["cout_revient"];
	
	
	
	echo "<tr><td><a href=\"ca_par_tige_details.php?matiere=$tige&du=$debut_exercice&au=$fin_exercice\">$tige</a></td>";
	
	
	
	
			//achat mat
	$sql1  = "SELECT * ";$achats=0;
	$sql1 .= "FROM achats_mat where produit='$tige' and avoir_sur_prix=0 and date between '$debut_exercice' and '$fin_exercice' ORDER BY produit;";
	$users1e = db_query($database_name, $sql1);$prix_revient=0;
	while($users1_e = fetch_array($users1e)) { 
		$achats = $achats+$users1_e["qte"];$prix_revient=$prix_revient+($users1_e["qte"]*$users1_e["prix_achat"]);
	}

	//stock initial
	 $sql1  = "SELECT * ";$stock_initial_pf=0;$stock_final_pf=0;$stock_initial=0;$vfm=0;
	$sql1 .= "FROM report_mat_precedant where date='$d' and produit='$tige' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
		$stock_initial_pf = $stock_initial_pf+$users1_["stock_final_pf"];
		$encours_initial_pf=$encours_initial_pf+$users1_["encours"];
		$stock_initial=$stock_initial+$users1_["stock_final_mp"];
		$vfm=$vfm+$users1_["valeur_final_mp"];
	}
	///
	@$cout=($vfm+$prix_revient)/($stock_initial+$achats);
	$c=$vfm."+".$prix_revient."/".$stock_initial."+".$achats;

	 $sql1  = "SELECT * ";
	$sql1 .= "FROM produits where tige='$tige' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
 		$produit = $users1_["produit"];$condit1 = $users1_["condit"];$qte=0;$poids = $users1_["poids"];$montant=0;$condit=0;$qte_tige = $users1_["qte_tige"];
		$stock_final_pf = $stock_final_pf+($users1_["stock_final"]);
		$stock_encours_final = $stock_encours_final+($users1_["en_cours_final"]);
		?>
		
		
		
		
		



	<?
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$debut_exercice' and '$fin_exercice' ) ORDER BY produit;";
	$users11 = db_query($database_name, $sql1);
	while($users11_ = fetch_array($users11)) { 
			$qte=$qte+($users11_["quantite"]*$users11_["condit"]*$qte_tige);
	
	}
			$sql1  = "SELECT * ";
			$sql1 .= "FROM entrees_stock_f where produit='$produit' and (date between '$debut_exercice' and '$fin_exercice' ) ORDER BY produit;";
			$users111 = db_query($database_name, $sql1);$production=0;
			while($users111_ = fetch_array($users111)) { 
			$production=$production+($users11_["depot_a"]*$condit);
			}

	if ($qte>0)
	
	{?>	<? $m=$m+($qte);$mt=$mt+$m; ?><? }
	 ?>
	<? }?>
	<td align="right"><? $t1=$t1+$stock_initial;$si=number_format($stock_initial,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$si </font>");?></td>
	<td align="right"><? @$t2=$t2+($stock_initial_pf);@@$sipf=number_format($stock_initial_pf,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$sipf </font>");;?></td>
	<td align="right"><? $t3=$t3+$encours_initial_pf;@$ec_i_f=number_format($encours_initial_pf,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ec_i_f </font>");?></td>
	<td align="right"><? $t4=$t4+$achats;$ach=number_format($achats,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ach </font>");?></td>
	<td align="right"><? @$t5=$t5+(($m/$unites)*$poids_unites);@$maf=number_format(($m/$unites)*$poids_unites,3,',',' ');$mafq=$m;print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$maf </font>");?></td>
	<td align="right"><? $spf=$stock_final_pf;$t6=$t6+$spf;$spfaf=number_format($spf,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$spfaf </font>");;?></td>
	<td align="right"><? @$ec_f=$stock_encours_final/$unites*$poids_unites;$t7=$t7+$ec_f;$ec_f_f=number_format($ec_f,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ec_f_f </font>");;?></td>
	<td align="right"><? @$mf=$stock_initial+$stock_initial_pf+$achats-$ec_f-(($m/$unites)*$poids_unites)-(($stock_final_pf/$unites)*$poids_unites);$t8=$t8+$mf;echo number_format($mf,3,',',' ');?></td>
	<td align="right"><? $t10= number_format($cout,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t10 </font>");?></td>
	<td align="right"><? $t9=$t9+($mf*$cout);echo number_format($mf*$cout,2,',',' ');?></td>
	
	<? ////////////////////////////////////////report à nouveau
				$mat="tig";$frs="report";$p_r=$mf*$cout;
				$sql  = "INSERT INTO report_mat ( produit,type, frs,date,stock_final_pf,stock_final_mp,encours,valeur_final_mp ) VALUES ( ";
				$sql .= "'" . $tige . "', ";
				$sql .= "'" . $mat . "', ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $d_exe1 . "', ";
				$sql .= "'" . $spf . "', ";
				$sql .= "'" . $mf . "', ";
				$sql .= "'" . $ec_f . "', ";
				$sql .= $p_r . ");";

				db_query($database_name, $sql);

	?>
	<? }?>

	<? }?>
	

	
<tr>
<td></td>
	<td align="right" bgcolor="#66FF99"><? $t1= number_format($t1,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t1 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t2= number_format($t2,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t2 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t3= number_format($t3,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t3 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t4= number_format($t4,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t4 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t5= number_format($t5,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t5 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t6= number_format($t6,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t6 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t7= number_format($t7,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t7 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t8= number_format($t8,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t8 </font>");?></td>
	<td></td>

	<td align="right" bgcolor="#66FF99"><? $t_tig=$t9;$t9= number_format($t9,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t9 </font>");?></td>
	
<tr><td bgcolor="#66FFCC"><? echo "Emballages Carton";?></td><td bgcolor="#66FFCC"><? echo "Stock initial M.";?></td>
<td bgcolor="#66FFCC"><? echo "Stock initial M.P.F";?></td>
<td bgcolor="#66FFCC"><? echo "Encours 01/01";?></td>
<td bgcolor="#66FFCC"><? echo "Achats Matiere";?></td>
<td bgcolor="#66FFCC"><? echo "Consommé";?></td>
<td bgcolor="#66FFCC"><? echo "Stock final P.Fini";?></td>
<td bgcolor="#66FFCC"><? echo "Encours 31/12";?></td>
<td bgcolor="#66FFCC"><? echo "Stock final M.Prem";?></td>
<td bgcolor="#66FFCC"><? echo "C.M.U.P";?></td>

<td bgcolor="#66FFCC"><? echo "Valeur final M.Prem";?></td>

</tr>

<?	
		if(isset($_REQUEST["action"]))
		
	{

	$sql  = "SELECT * ";$vide="";$mt=0;$unites=1;$poids_unites=1;$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t7=0;$t8=0;$t9=0;
	$sql .= "FROM types_emballages where profile_name<>'$vide' ORDER BY profile_name;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) { $stock_initial_pf=0;$cout_revient = $users_["cout_revient"];$stock_final_pf=0;
 		$emballage = $users_["profile_name"];$m=0;$md="";$stock_initial = 0;$vfm=0;$stock_encours_final=0;
		$consomme = $users_["consomme"];$mode_consomme = $users_["mode_consomme"];
	echo "<tr><td><a href=\"ca_par_emballage_details.php?matiere=$emballage&du=$debut_exercice&au=$fin_exercice\">$emballage</a></td>";
	
		
	$sql1  = "SELECT * ";$achats=0;
	$sql1 .= "FROM achats_mat where produit='$emballage' and avoir_sur_prix=0 and date between '$debut_exercice' and '$fin_exercice' ORDER BY produit;";
	$users1e = db_query($database_name, $sql1);$prix_revient=0;
	while($users1_e = fetch_array($users1e)) { 
		$achats = $achats+$users1_e["qte"];$prix_revient=$prix_revient+($users1_e["qte"]*$users1_e["prix_achat"]);
	}
	
		
	
	
	$sql1  = "SELECT * ";$stock_initial_pf=0;$stock_initial=0;
	$sql1 .= "FROM report_mat_precedant where date='$d' and produit='$emballage' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
		$stock_initial_pf = $stock_initial_pf+$users1_["stock_final_pf"];
		$encours_initial_pf=$encours_initial_pf+$users1_["encours"];
		$stock_initial=$stock_initial+$users1_["stock_final_mp"];
		$vfm=$vfm+$users1_["valeur_final_mp"];
	}
	
	

	@$cout=($vfm+$prix_revient)/($stock_initial+$achats);
	$c=$vfm."+".$prix_revient."/".$stock_initial."+".$achats;

	
	$sql1  = "SELECT * ";$production=0;$qte_t=0;
	$sql1 .= "FROM produits where emballage='$emballage' or emballage2='$emballage' or emballage3='$emballage' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
 		$produit = $users1_["produit"];$condit1 = $users1_["condit"];$qte=0;$poids = $users1_["poids"];
		$montant=0;$condit=0;
		$emballage1 = $users1_["emballage"];$emballage2 = $users1_["emballage2"];
		$emballage3 = $users1_["emballage3"];$qte_emb=1;
		if ($emballage==$emballage1){$qte_emb=$users1_["qte_emballage"];}
		if ($emballage==$emballage2){$qte_emb=$users1_["qte_emballage2"];}
		if ($emballage==$emballage3){$qte_emb=$users1_["qte_emballage3"];}

		$stock_final_pf = $stock_final_pf+($users1_["stock_final"]/$condit1*$qte_emb);
		$stock_encours_final = $stock_encours_final+($users1_["en_cours_final"]/$condit1*$qte_emb);

	if ($mode_consomme==0){
	$sql1  = "SELECT * ";$mf="";
	$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$debut_exercice' and '$fin_exercice' ) ORDER BY produit;";
	$users11 = db_query($database_name, $sql1);
	while($users11_ = fetch_array($users11)) { 
			$qte=$qte+($users11_["quantite"]*$qte_emb);	
	}
	}else{$m=$consomme;}
	if ($qte>0)
	
	{?>	<? $md.=" / ".$qte; $m=$m+$qte;$mt=$mt+$m;?><? }
	 ?>
	<? 
	
	
	
	}
	
	
	
	?>
	<td align="right"><? $t1=$t1+$stock_initial;$si=number_format($stock_initial,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$stock_initial </font>");?></td>
	<td align="right"><? @$t2=$t2+($stock_initial_pf);@$sipf=number_format($stock_initial_pf,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$sipf </font>");;?></td>
	<td align="right"><? $t3=$t3+$encours_initial_pf;@$ec_i_f=number_format($encours_initial_pf,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$encours_initial_pf </font>");?></td>
	<td align="right"><? $t4=$t4+$achats;$ach=number_format($achats,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$achats </font>");?></td>
	<td align="right"><? if ($mode_consomme==1){$m=$consomme;}@$t5=$t5+$m;print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");?></td>
	<td align="right"><? $spf=$stock_final_pf;$t6=$t6+$spf;$spfaf=number_format($spf,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$spf </font>");;?></td>
	<td align="right"><? $ec_f=$stock_encours_final;$t7=$t7+$ec_f;$ec_f_f=number_format($ec_f,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ec_f </font>");;?></td>
	<td align="right"><? @$mf=$stock_initial+$stock_initial_pf+$achats-$m-$stock_final_pf-$stock_encours_final;$t8=$t8+$mf;echo $mf;?></td>
	<td align="right"><? $t10= number_format($cout,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t10 </font>");?></td>
	<td align="right"><? $t9=$t9+($mf*$cout);echo number_format($mf*$cout,2,',',' ');?></td>
	
	<? ////////////////////////////////////////report à nouveau
				
				
				
				
				$mat="emb";$frs="report";$p_r=$mf*$cout;
				$sql  = "INSERT INTO report_mat ( produit,type, frs,date,stock_final_pf,stock_final_mp,encours,valeur_final_mp ) VALUES ( ";
				$sql .= "'" . $emballage . "', ";
				$sql .= "'" . $mat . "', ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $d_exe1 . "', ";
				$sql .= "'" . $spf . "', ";
				$sql .= "'" . $mf . "', ";
				$sql .= "'" . $ec_f . "', ";
				$sql .= $p_r . ");";

				db_query($database_name, $sql);

	?>
	
	
	<? }?>

	<? }?>
	
		<?  ?>
	
<tr>
<td></td>
	<td align="right" bgcolor="#66FF99"><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t1 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t2 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t3 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t4 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t5 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t6 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t7 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t8 </font>");?></td>
	<td></td>

	<td align="right" bgcolor="#66FF99"><? $t_embc=$t9;$t9= number_format($t9,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t9 </font>");?></td>


	
<tr><td bgcolor="#66FFCC"><? echo "Emballages Sachets";?></td><td bgcolor="#66FFCC"><? echo "Stock initial M.";?></td>
<td bgcolor="#66FFCC"><? echo "Stock initial M.P.F";?></td>
<td bgcolor="#66FFCC"><? echo "Encours 01/01";?></td>
<td bgcolor="#66FFCC"><? echo "Achats Matiere";?></td>
<td bgcolor="#66FFCC"><? echo "Consommé";?></td>
<td bgcolor="#66FFCC"><? echo "Stock final P.Fini";?></td>
<td bgcolor="#66FFCC"><? echo "Encours 31/12";?></td>
<td bgcolor="#66FFCC"><? echo "Stock final M.Prem";?></td>
<td bgcolor="#66FFCC"><? echo "C.M.U.P";?></td>

<td bgcolor="#66FFCC"><? echo "Valeur final M.Prem";?></td>

</tr>

<?	
		if(isset($_REQUEST["action"]))
		
	{

	$sql  = "SELECT * ";$vide="";$mt=0;$unites=1;$poids_unites=1;$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t7=0;$t8=0;$t9=0;$type_emb="sachets";
	$sql .= "FROM types_emballages1 where profile_name<>'$vide' and type='$type_emb' ORDER BY profile_name;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) { $stock_initial_pf=0;$cout_revient = $users_["cout_revient"];$stock_final_pf=0;$poids_sachet = $users_["poids"];
 		$emballage = $users_["profile_name"];$m=0;$md="";$stock_initial = 0;$vfm=0;$stock_encours_final=0;
		$consomme = $users_["consomme"];$mode_consomme = $users_["mode_consomme"];
	echo "<tr><td><a href=\"ca_par_emballage_details.php?matiere=$emballage&du=$debut_exercice&au=$fin_exercice\">$emballage</a></td>";
	
		
	$sql1  = "SELECT * ";$achats=0;
	$sql1 .= "FROM achats_mat where produit='$emballage' and avoir_sur_prix=0 and date between '$debut_exercice' and '$fin_exercice' ORDER BY produit;";
	$users1e = db_query($database_name, $sql1);$prix_revient=0;
	while($users1_e = fetch_array($users1e)) { 
		$achats = $achats+$users1_e["qte"];$prix_revient=$prix_revient+($users1_e["qte"]*$users1_e["prix_achat"]);
	}
	
		
	
	
	$sql1  = "SELECT * ";$stock_initial_pf=0;$stock_initial=0;
	$sql1 .= "FROM report_mat_precedant where date='$d' and produit='$emballage' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
		//$stock_initial_pf = $stock_initial_pf+$users1_["stock_final_pf"];
		$encours_initial_pf=$encours_initial_pf+$users1_["encours"];
		$stock_initial=$stock_initial+$users1_["stock_final_mp"];
		$vfm=$vfm+$users1_["valeur_final_mp"];
	}
	
	

	@$cout=($vfm+$prix_revient)/($stock_initial+$achats);
	$c=$vfm."+".$prix_revient."/".$stock_initial."+".$achats;

	
	$sql1  = "SELECT * ";$production=0;$qte_t=0;
	$sql1 .= "FROM produits where emballage3='$emballage' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
 		$produit = $users1_["produit"];$condit1 = $users1_["condit"];$qte=0;$poids = $users1_["poids"];
		$montant=0;$condit=0;
		
		$emballage3 = $users1_["emballage3"];$qte_emb=0;$qte_emb=$users1_["qte_emballage3"];
		
		if ($emballage==$emballage3){}

		$stock_final_pf = $stock_final_pf+($users1_["stock_final"]/$condit1*$poids_sachet/1000);
		$stock_initial_pf = $stock_initial_pf+($users1_["stock_ini_exe"]/$condit1*$poids_sachet/1000);
		
		$stock_encours_final = 0;

	if ($mode_consomme==0){
	$sql1  = "SELECT * ";$mf="";
	$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$debut_exercice' and '$fin_exercice' ) ORDER BY produit;";
	$users11 = db_query($database_name, $sql1);
	while($users11_ = fetch_array($users11)) { 
			$qte=$qte+($users11_["quantite"]*$poids_sachet/1000);	
	}
	}else{$m=$consomme;}
	if ($qte>0)
	
	{?>	<? $md.=" / ".$qte; $m=$m+$qte;$mt=$mt+$m;?><? }
	 ?>
	<? 
	
	
	
	}
	
	
	
	?>
	<td align="right"><? $t1=$t1+$stock_initial;$si=number_format($stock_initial,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$stock_initial </font>");?></td>
	<td align="right"><? @$t2=$t2+($stock_initial_pf);@$sipf=number_format($stock_initial_pf,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$sipf </font>");;?></td>
	<td align="right"><? $t3=$t3+$encours_initial_pf;@$ec_i_f=number_format($encours_initial_pf,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$encours_initial_pf </font>");?></td>
	<td align="right"><? $t4=$t4+$achats;$ach=number_format($achats,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$achats </font>");?></td>
	<td align="right"><? if ($mode_consomme==1){$m=$consomme;}@$t5=$t5+$m;$m_affiche=number_format($m,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m_affiche </font>");?></td>
	<td align="right"><? $spf=$stock_final_pf;$t6=$t6+$spf;$spfaf=number_format($spf,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$spfaf </font>");;?></td>
	<td align="right"><? $ec_f=$stock_encours_final;$t7=$t7+$ec_f;$ec_f_f=number_format($ec_f,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ec_f </font>");;?></td>
	<td align="right"><? @$mf=$stock_initial+$stock_initial_pf+$achats-$m-$stock_final_pf-$stock_encours_final;$t8=$t8+$mf;echo number_format($mf,3,',',' ');?></td>
	<td align="right"><? $t10= number_format($cout,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t10 </font>");?></td>
	<td align="right"><? $t9=$t9+($mf*$cout);echo number_format($mf*$cout,2,',',' ');?></td>
	
	<? ////////////////////////////////////////report à nouveau
				
				
				
				
				$mat="emb1";$frs="report";$p_r=$mf*$cout;
				$sql  = "INSERT INTO report_mat ( produit,type, frs,date,stock_final_pf,stock_final_mp,encours,valeur_final_mp ) VALUES ( ";
				$sql .= "'" . $emballage . "', ";
				$sql .= "'" . $mat . "', ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $d_exe1 . "', ";
				$sql .= "'" . $spf . "', ";
				$sql .= "'" . $mf . "', ";
				$sql .= "'" . $ec_f . "', ";
				$sql .= $p_r . ");";

				db_query($database_name, $sql);

	?>
	
	
	<? }?>

	<? }?>
	
	<tr>
<td></td>
	<td align="right" bgcolor="#66FF99"><? $tt1= number_format($t1,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tt1 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $tt1= number_format($t2,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tt1 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $tt1= number_format($t3,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tt1 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $tt1= number_format($t4,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tt1 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $tt1= number_format($t5,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tt1 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $tt1= number_format($t6,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tt1 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $tt1= number_format($t7,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tt1 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $tt1= number_format($t8,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tt1 </font>");?></td>
	<td></td>

	<td align="right" bgcolor="#66FF99"><? $t_emb=$t9;$t9= number_format($t9,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t9 </font>");?></td>

	
	
	
	
<tr><td bgcolor="#66FFCC"><? echo "Emballages Divers";?></td><td bgcolor="#66FFCC"><? echo "Stock initial M.";?></td>
<td bgcolor="#66FFCC"><? echo "Stock initial M.P.F";?></td>
<td bgcolor="#66FFCC"><? echo "Encours 01/01";?></td>
<td bgcolor="#66FFCC"><? echo "Achats Matiere";?></td>
<td bgcolor="#66FFCC"><? echo "Consommé";?></td>
<td bgcolor="#66FFCC"><? echo "Stock final P.Fini";?></td>
<td bgcolor="#66FFCC"><? echo "Encours 31/12";?></td>
<td bgcolor="#66FFCC"><? echo "Stock final M.Prem";?></td>
<td bgcolor="#66FFCC"><? echo "C.M.U.P";?></td>

<td bgcolor="#66FFCC"><? echo "Valeur final M.Prem";?></td>

</tr>

<?	
		if(isset($_REQUEST["action"]))
		
	{

	$sql  = "SELECT * ";$vide="";$mt=0;$unites=1;$poids_unites=1;$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t7=0;$t8=0;$t9=0;$type_emb="divers";
	$sql .= "FROM types_emballages1 where profile_name<>'$vide' and type='$type_emb' ORDER BY profile_name;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) { $stock_initial_pf=0;$cout_revient = $users_["cout_revient"];$stock_final_pf=0;
 		$emballage = $users_["profile_name"];$m=0;$md="";$stock_initial = 0;$vfm=0;$stock_encours_final=0;
		$consomme = $users_["consomme"];$mode_consomme = $users_["mode_consomme"];
	echo "<tr><td><a href=\"ca_par_emballage_details.php?matiere=$emballage&du=$debut_exercice&au=$fin_exercice\">$emballage</a></td>";
	
		
	$sql1  = "SELECT * ";$achats=0;
	$sql1 .= "FROM achats_mat where produit='$emballage' and avoir_sur_prix=0 and date between '$debut_exercice' and '$fin_exercice' ORDER BY produit;";
	$users1e = db_query($database_name, $sql1);$prix_revient=0;
	while($users1_e = fetch_array($users1e)) { 
		$achats = $achats+$users1_e["qte"];$prix_revient=$prix_revient+($users1_e["qte"]*$users1_e["prix_achat"]);
	}
	
		
	
	
	$sql1  = "SELECT * ";$stock_initial_pf=0;$stock_initial=0;
	$sql1 .= "FROM report_mat_precedant where date='$d' and produit='$emballage' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
		$stock_initial_pf = $stock_initial_pf+$users1_["stock_final_pf"];
		$encours_initial_pf=$encours_initial_pf+$users1_["encours"];
		$stock_initial=$stock_initial+$users1_["stock_final_mp"];
		$vfm=$vfm+$users1_["valeur_final_mp"];
	}
	
	

	@$cout=($vfm+$prix_revient)/($stock_initial+$achats);
	$c=$vfm."+".$prix_revient."/".$stock_initial."+".$achats;

	
	$sql1  = "SELECT * ";$production=0;$qte_t=0;
	$sql1 .= "FROM produits where emballage3='$emballage' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
 		$produit = $users1_["produit"];$condit1 = $users1_["condit"];$qte=0;$poids = $users1_["poids"];
		$montant=0;$condit=0;
		
		$emballage3 = $users1_["emballage3"];$qte_emb=0;
		
		if ($emballage==$emballage3){$qte_emb=$users1_["qte_emballage3"];}

		
		$stock_final_pf = 0;
		$stock_encours_final = 0;
		

	if ($mode_consomme==0){
	$sql1  = "SELECT * ";$mf="";
	$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$debut_exercice' and '$fin_exercice' ) ORDER BY produit;";
	$users11 = db_query($database_name, $sql1);
	while($users11_ = fetch_array($users11)) { 
			$qte=$qte+($users11_["quantite"]*$qte_emb);	
	}
	}else{$m=$consomme;}
	if ($qte>0)
	
	{?>	<? $md.=" / ".$qte; $m=$m+$qte;$mt=$mt+$m;?><? }
	 ?>
	<? 
	
	
	
	}
	
	
	
	?>
	<td align="right"><? $t1=$t1+$stock_initial;$si=number_format($stock_initial,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$stock_initial </font>");?></td>
	<td align="right"><? @$t2=$t2+($stock_initial_pf);@$sipf=number_format($stock_initial_pf,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$sipf </font>");;?></td>
	<td align="right"><? $t3=$t3+$encours_initial_pf;@$ec_i_f=number_format($encours_initial_pf,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$encours_initial_pf </font>");?></td>
	<td align="right"><? $t4=$t4+$achats;$ach=number_format($achats,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$achats </font>");?></td>
	<td align="right"><? if ($mode_consomme==1){$m=$consomme;}@$t5=$t5+$m;print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");?></td>
	<td align="right"><? $spf=$stock_final_pf;$t6=$t6+$spf;$spfaf=number_format($spf,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$spf </font>");;?></td>
	<td align="right"><? $ec_f=$stock_encours_final;$t7=$t7+$ec_f;$ec_f_f=number_format($ec_f,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ec_f </font>");;?></td>
	<td align="right"><? @$mf=$stock_initial+$stock_initial_pf+$achats-$m-$stock_final_pf-$stock_encours_final;$t8=$t8+$mf;echo $mf;?></td>
	<td align="right"><? $t10= number_format($cout,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t10 </font>");?></td>
	<td align="right"><? $t9=$t9+($mf*$cout);echo number_format($mf*$cout,2,',',' ');?></td>
	
	<? ////////////////////////////////////////report à nouveau
				
				
				
				
				$mat="emb2";$frs="report";$p_r=$mf*$cout;
				$sql  = "INSERT INTO report_mat ( produit,type, frs,date,stock_final_pf,stock_final_mp,encours,valeur_final_mp ) VALUES ( ";
				$sql .= "'" . $emballage . "', ";
				$sql .= "'" . $mat . "', ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $d_exe1 . "', ";
				$sql .= "'" . $spf . "', ";
				$sql .= "'" . $mf . "', ";
				$sql .= "'" . $ec_f . "', ";
				$sql .= $p_r . ");";

				db_query($database_name, $sql);

	?>
	
	
	<? }?>

	<? }?>
	
	
	
	<tr>
<td></td>
	<td align="right" bgcolor="#66FF99"><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t1 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t2 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t3 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t4 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t5 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t6 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t7 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t8 </font>");?></td>
	<td></td>

	<td align="right" bgcolor="#66FF99"><? $t_emb1=$t9;$t9= number_format($t9,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t9 </font>");?></td>

	
	
	
	
	
	
	
	
	<tr><td bgcolor="#66FFCC"><? $vide="";echo "Consommables";?></td></tr>
		<? if(isset($_REQUEST["action"]))
	{	$sql  = "SELECT * ";
	$sql .= "FROM types_consomables where profile_name<>'$vide' ORDER BY profile_name;";
	$users = db_query($database_name, $sql);
	$v1=0;?>
	<tr>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Libelle </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Stock_initial :Kg </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Achats Exercice :Kg </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Consommé Exercice :Kg </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Stock Final :Kg </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">C.M.U.P </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\"> </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\"> </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\"> </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\"> </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Valeur </font>");?></th>

	</tr>

	
	<? while($users_ = fetch_array($users)) { ?><tr>
	
	<? $p= $users_["profile_name"];$st=$users_["stock_initial"];$cr=$users_["cout_revient"];$vfm=$st*$cr;
					//achat mat
	$sql1  = "SELECT * ";$achats=0;$prix_revient=0;
	$sql1 .= "FROM achats_mat where produit='$p' and avoir_sur_prix=0 and date between '$debut_exercice' and '$fin_exercice' ORDER BY produit;";
	$users1e = db_query($database_name, $sql1);$prix_revient=0;
	while($users1_e = fetch_array($users1e)) { 
		$achats = $achats+$users1_e["qte"];$prix_revient=$prix_revient+($users1_e["qte"]*$users1_e["prix_achat"]);
	}

	
	//stock initial
	
	 $sql1  = "SELECT * ";$stock_initial_pf=0;$stock_final_pf=0;$stock_initial=0;$vfm=0;
	$sql1 .= "FROM report_mat_precedant where date='$d' and produit='$p' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$vfm=0;
	while($users1_ = fetch_array($users1)) { 
 		$produit = $users1_["produit"];
		$stock_initial_pf = $stock_initial_pf+$users1_["stock_final_pf"];
		$encours_initial_pf=$encours_initial_pf+$users1_["encours"];
		$stock_initial=$stock_initial+$users1_["stock_final_mp"];
		$vfm=$vfm+$users1_["valeur_final_mp"];
	}
	$st=$stock_initial;
	@$cout=($vfm+$prix_revient)/($st+$achats);
	$c=$vfm."+".$prix_revient."/".$st."+".$achats;
	
	?>

	<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$p </font>");?></td>
	<td align="center"><?php $s1= number_format($st,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$s1 </font>");?></td>
	<td align="center"><?php $s2= number_format($achats,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$s2 </font>");?></td>
	<td align="center"><?php $s3= number_format($users_["consomme"],3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$s3 </font>");?></td>
	<td align="center"><?php $s4= number_format(($st+$achats-$users_["consomme"]),3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$s4 </font>");?></td>
	<td align="center"><?php $s5= number_format($cout,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$s5 </font>");?></td>
	<td></td><td></td><td></td><td></td>
	<td align="right"><?php $v1=$v1+$cout*($st+$achats-$users_["consomme"]);
	$s6= number_format($cout*($st+$achats-$users_["consomme"]),2,',',' ');
	print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$s6 </font>");?></td>
	</tr>
	 
	 <?
	 $mf=$users_["stock_initial"]+$users_["achats"]-$users_["consomme"];
$p_r=($users_["stock_initial"]+$users_["achats"]-$users_["consomme"])*$users_["cout_revient"];

	 ////////////////////////////////////////report à nouveau
				$mat="col";$frs="report";$date=$date_exe_suivant;$spf=0;$ec_f=0;
				$sql  = "INSERT INTO report_mat ( produit,type, frs,date,stock_final_pf,stock_final_mp,encours,valeur_final_mp ) VALUES ( ";
				$sql .= "'" . $p . "', ";
				$sql .= "'" . $mat . "', ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $d_exe1 . "', ";
				$sql .= "'" . $spf . "', ";
				$sql .= "'" . $mf . "', ";
				$sql .= "'" . $ec_f . "', ";
				$sql .= $p_r . ");";

				db_query($database_name, $sql);?>

<?php } ?>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
	<td align="right"><?php $s7= number_format($v1,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$s7 </font>");?></td>
<? }?>

	
	
	
	
	
	
		<?  ?>
	

	
<tr><td bgcolor="#66FFCC"><? echo "Etiquettes/Unite";?></td><td bgcolor="#66FFCC"><? echo "Stock initial M.";?></td>
<td bgcolor="#66FFCC"><? echo "Stock initial M.P.F";?></td>
<td bgcolor="#66FFCC"><? echo "Encours 01/01";?></td>
<td bgcolor="#66FFCC"><? echo "Achats Matiere";?></td>
<td bgcolor="#66FFCC"><? echo "Consommé";?></td>
<td bgcolor="#66FFCC"><? echo "Stock final P.Fini";?></td>
<td bgcolor="#66FFCC"><? echo "Encours 31/12";?></td>
<td bgcolor="#66FFCC"><? echo "Stock final M.Prem";?></td>
<td bgcolor="#66FFCC"><? echo "C.M.U.P";?></td>

<td bgcolor="#66FFCC"><? echo "Valeur final M.Prem";?></td>

</tr>

<?	
		if(isset($_REQUEST["action"]))
		
	{

	$sql  = "SELECT * ";$vide="";$mt=0;$unites=1;$poids_unites=1;$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t7=0;$t8=0;$t9=0;
	$sql .= "FROM types_etiquettes where profile_name<>'$vide' ORDER BY profile_name;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) { $stock_initial_pf=0;$stock_final_pf=0;$cout_revient = $users_["cout_revient"];$mode_consomme = $users_["mode_consomme"];
 		$etiquette = $users_["profile_name"];$m=0;$stock_initial = $users_["stock_initial"];$vfm=0;$stock_encours_final=0;$consomme = $users_["consomme"];
	echo "<tr><td><a href=\"ca_par_etiquette_details.php?matiere=$etiquette&du=$debut_exercice&au=$fin_exercice\">$etiquette</a></td>";
			
			//achat mat
	$sql1  = "SELECT * ";$achats=0;
	$sql1 .= "FROM achats_mat where produit='$etiquette' and avoir_sur_prix=0 and date between '$debut_exercice' and '$fin_exercice' ORDER BY produit;";
	$users1e = db_query($database_name, $sql1);$prix_revient=0;
	while($users1_e = fetch_array($users1e)) { 
		$achats = $achats+$users1_e["qte"];$prix_revient=$prix_revient+($users1_e["qte"]*$users1_e["prix_achat"]);
	}

	//stock initial
	 $sql1  = "SELECT * ";$stock_initial_pf=0;$stock_final_pf=0;$stock_initial=0;$stock_encours_final=0;
	$sql1 .= "FROM report_mat_precedant where date='$d' and produit='$etiquette' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
 		$produit = $users1_["produit"];
		$stock_initial_pf = $stock_initial_pf+$users1_["stock_final_pf"];
		$encours_initial_pf=$encours_initial_pf+$users1_["encours"];
		$stock_initial=$stock_initial+$users1_["stock_final_mp"];
		$vfm=$vfm+$users1_["valeur_final_mp"];
	}
	///
	@$cout=($vfm+$prix_revient)/($stock_initial+$achats);
	$c=$vfm."+".$prix_revient."/".$stock_initial."+".$achats;
		

	 $sql1  = "SELECT * ";
	$sql1 .= "FROM produits where etiquette='$etiquette' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
 		$produit = $users1_["produit"];$condit1 = $users1_["condit"];$qte=0;$poids = $users1_["poids"];$montant=0;$condit=0;
		$stock_final_pf = $stock_final_pf+($users1_["stock_final"]);
		$stock_encours_final = $stock_encours_final+($users1_["en_cours_final"]);
	

	if ($mode_consomme==0){
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$debut_exercice' and '$fin_exercice' ) ORDER BY produit;";
	$users11 = db_query($database_name, $sql1);
	while($users11_ = fetch_array($users11)) { 
			$qte=$qte+($users11_["quantite"]*$users11_["condit"]);
	
	}
	}else{$m=$consomme;}
	if ($qte>0)
	
	{?>	<? $m=$m+($qte);$mt=$mt+$m; ?><? }
	 ?>
	<? }?>
	
	
	<? ////////////////etiquette range tout  
	if ($etiquette=="RANGE TOUT F21/14") { ?>
	
	<td align="right"><? $t1=$t1+$stock_initial;$si=number_format($stock_initial,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$si </font>");?></td>
	<td align="right"><? $sipf=$stock_initial_pf;@$t2=$t2+($stock_initial_pf);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$sipf </font>");;?></td>
	<td align="right"><? $encours_initial_pf=0;$t3=$t3+$encours_initial_pf;@$ec_i_f=number_format($encours_initial_pf,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ec_i_f </font>");?></td>
	<td align="right"><? $t4=$t4+$achats;$ach=number_format($achats,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ach </font>");?></td>
	<td align="right"><? @$t5=$t5+$stock_initial_pf;$mafq=$stock_initial_pf;print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$stock_initial_pf </font>");?></td>
	<td align="right"><? $spf=0;$t6=$t6+$spf;$spfaf=number_format(0,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$spfaf </font>");;?></td>
	<td align="right"><? $ec_f=$stock_encours_final;$t7=$t7+$ec_f;$ec_f_f=number_format($ec_f,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ec_f_f </font>");;?></td>
	<td align="right"><? @$mf=0;$t8=$t8+$mf;echo number_format(0,0,',',' ');?></td>
	<td align="right"><? $t10= number_format(0,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t10 </font>");?></td>
	<td align="right"><? $t9=$t9+0;echo number_format(0,2,',',' ');?></td>
	
	<? } else { ?>
	<td align="right"><? $t1=$t1+$stock_initial;$si=number_format($stock_initial,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$si </font>");?></td>
	<td align="right"><? $sipf=$stock_initial_pf;@$t2=$t2+($stock_initial_pf);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$sipf </font>");;?></td>
	<td align="right"><? $encours_initial_pf=0;$t3=$t3+$encours_initial_pf;@$ec_i_f=number_format($encours_initial_pf,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ec_i_f </font>");?></td>
	<td align="right"><? $t4=$t4+$achats;$ach=number_format($achats,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ach </font>");?></td>
	<td align="right"><? if ($mode_consomme==1){$m=$consomme;}@$t5=$t5+$m;$mafq=$m;print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");?></td>
	<td align="right"><? $spf=$stock_final_pf;$t6=$t6+$spf;$spfaf=number_format($spf,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$spfaf </font>");;?></td>
	<td align="right"><? $ec_f=$stock_encours_final;$t7=$t7+$ec_f;$ec_f_f=number_format($ec_f,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ec_f_f </font>");;?></td>
	<td align="right"><? @$mf=$stock_initial+$stock_initial_pf+$achats-$m-$stock_final_pf-$ec_f;$t8=$t8+$mf;echo number_format($mf,0,',',' ');?></td>
	<td align="right"><? $t10= number_format($cout,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t10 </font>");?></td>
	<td align="right"><? $t9=$t9+($mf*$cout);echo number_format($mf*$cout,2,',',' ');?></td>
	
	<? }?>
	
	
	
	<? ////////////////////////////////////////report à nouveau
				$mat="eti";$frs="report";$p_r=$mf*$cout;
				$sql  = "INSERT INTO report_mat ( produit,type, frs,date,stock_final_pf,stock_final_mp,encours,valeur_final_mp ) VALUES ( ";
				$sql .= "'" . $etiquette . "', ";
				$sql .= "'" . $mat . "', ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $d_exe1 . "', ";
				$sql .= "'" . $spf . "', ";
				$sql .= "'" . $mf . "', ";
				$sql .= "'" . $ec_f . "', ";
				$sql .= $p_r . ");";

				db_query($database_name, $sql);

	?>
	<? }?>

	<? }?>
<tr>
<td></td>
	<td align="right" bgcolor="#66FF99"><? $t1= number_format($t1,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t1 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t2= number_format($t2,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t2 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t3= number_format($t3,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t3 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t4= number_format($t4,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t4 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t5= number_format($t5,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t5 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t6= number_format($t6,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t6 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t7= number_format($t7,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t7 </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t8= number_format($t8,0,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t8 </font>");?></td>
	<td></td>
	<td align="right" bgcolor="#66FF99"><? $t_etiq=$t9;$t9= number_format($t9,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t9 </font>");?></td>
<tr><td bgcolor="#66FFCC"><? echo "Colorants/kg";?></td></tr>
		<? if(isset($_REQUEST["action"]))
	{	$sql  = "SELECT * ";
	$sql .= "FROM types_colorants ORDER BY profile_name;";
	$users = db_query($database_name, $sql);
	$v=0;?>
	<tr>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Libelle </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Stock_initial :Kg </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Achats Exercice :Kg </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Consommé Exercice :Kg </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Stock Final :Kg </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">C.M.U.P </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\"> </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\"> </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\"> </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\"> </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Valeur </font>");?></th>

	</tr>

	
	<? while($users_ = fetch_array($users)) { ?><tr>
	
	<? $p= $users_["profile_name"];$col="col";$cr=$users_["cout_revient"];
	
					//achat mat
	$sql1  = "SELECT * ";$achats=0;$prix_revient=0;
	$sql1 .= "FROM achats_mat where produit='$p' and avoir_sur_prix=0 and date between '$debut_exercice' and '$fin_exercice' ORDER BY produit;";
	$users1e = db_query($database_name, $sql1);$prix_revient=0;
	while($users1_e = fetch_array($users1e)) { 
		$achats = $achats+$users1_e["qte"];$prix_revient=$prix_revient+($users1_e["qte"]*$users1_e["prix_achat"]);
	}

	
	//stock initial
	 $sql1  = "SELECT * ";$stock_initial_pf=0;$stock_final_pf=0;$stock_initial=0;
	$sql1 .= "FROM report_mat_precedant where date='$d' and produit='$p' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$vfm=0;
	while($users1_ = fetch_array($users1)) { 
 		$produit = $users1_["produit"];
		$stock_initial_pf = $stock_initial_pf+$users1_["stock_final_pf"];
		$encours_initial_pf=$encours_initial_pf+$users1_["encours"];
		$stock_initial=$stock_initial+$users1_["stock_final_mp"];
		$stii=$stii+$users1_["stock_final_mp"];
		$vfm=$vfm+$users1_["valeur_final_mp"];
	}
	@$cout=($vfm+$prix_revient)/($stock_initial+$achats);
	$c=$vfm."+".$prix_revient."/".$stock_initial."+".$achats;
	if ($cr>0){$cout=$cr;}
	
	?>

	<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$p </font>");?></td>
	<td align="center"><?php $s1= number_format($stock_initial,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$s1 </font>");?></td>
	<td align="center"><?php $s2= number_format($achats,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$s2 </font>");?></td>
	<td align="center"><?php $s3= number_format($users_["consomme"],3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$s3 </font>");?></td>
	<td align="center"><?php $sfc=$stock_initial+$achats-$users_["consomme"];$s4= number_format(($stock_initial+$achats-$users_["consomme"]),3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$s4 </font>");?></td>
	<td align="center"><?php $s5= number_format($cout,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$s5 </font>");?></td>
	<td></td><td></td><td></td><td></td>
	<td align="right"><?php $v=$v+$cout*($stock_initial+$achats-$users_["consomme"]);
	$s6= number_format($cout*($stock_initial+$achats-$users_["consomme"]),2,',',' ');$vcol=$cout*($stock_initial+$achats-$users_["consomme"]);
	print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$s6 </font>");?></td>
	</tr>
	 
	 <?
	 $mf=$users_["stock_initial"]+$users_["achats"]-$users_["consomme"];
		$p_r=($users_["stock_initial"]+$users_["achats"]-$users_["consomme"])*$users_["cout_revient"];

	 ////////////////////////////////////////report à nouveau
				$mat="col";$frs="report";$spf=0;$ec_f=0;
				$sql  = "INSERT INTO report_mat ( produit,type, frs,date,stock_final_pf,stock_final_mp,encours,valeur_final_mp ) VALUES ( ";
				$sql .= "'" . $p . "', ";
				$sql .= "'" . $mat . "', ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $d_exe1 . "', ";
				$sql .= "'" . $spf . "', ";
				$sql .= "'" . $sfc . "', ";
				$sql .= "'" . $ec_f . "', ";
				$sql .= $vcol . ");";

				db_query($database_name, $sql);?>

<?php } ?>
<tr><td></td>
	<td align="right"><?php $stiii= number_format($stii,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$stiii </font>");?></td>
<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
	<td align="right"><?php $s7= number_format($v,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$s7 </font>");?></td>
<? }?>




<tr><td></td>
	<td align="right" bgcolor="#66FF99"></td>
	<td align="right" bgcolor="#66FF99"></td>
	<td align="right" bgcolor="#66FF99"></td>
	<td align="right" bgcolor="#66FF99"></td>
	<td align="right" bgcolor="#66FF99"></td>
	<td align="right" bgcolor="#66FF99"></td>
	<td align="right" bgcolor="#66FF99"></td>
	<td align="right" bgcolor="#66FF99"></td>
	<td align="right" bgcolor="#66FF99"><? print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Total General </font>");?></td>
	<td align="right" bgcolor="#66FF99"><? $t_total=$t_mat+$t_embc+$t_emb+$t_emb1+$t_tig+$t_etiq+$v+$v1;
	$t_total= number_format($t_total,2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t_total </font>");?></td>

</table>
<table><tr><? if ($user_login=="admin") {echo "<td><a href=\"\\jp\\tutorial\\ca_matiere.php?du=$debut_exercice&au=$fin_exercice\">Imprimer tableau matiere</a></td>";}?>

*/

$pdf->Output();

?>
