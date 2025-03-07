<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
		$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$user_login = $user_["login"];$stii=0;$ligne=0;

	
	$error_message = "";	$du="";$au="";$action="Recherche";$du1="";$au1="";
			$sql = "TRUNCATE TABLE `report_mat`  ;";
			db_query($database_name, $sql);
			$sql = "TRUNCATE TABLE `tableau_matiere`  ;";
			db_query($database_name, $sql);
	
		if(isset($_REQUEST["action"]))
	{}else
	{
?>
	<form id="form" name="form" method="post" action="ca_par_matiere_premiere.php">
	<td><?php echo "Du : "; ?><input type="text" id="du" name="du" value="<?php echo $du; ?>" size="15"></td>
	<td><?php echo "Au : "; ?><input type="text" id="au" name="au" value="<?php echo $au; ?>" size="15"></td>
	<tr>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{
	 $du=dateFrToUs($_POST['du']);$au=dateFrToUs($_POST['au']);$du1=$_POST['du'];$au1=$_POST['au'];
	$debut_exercice=dateFrToUs($_POST['du']);$fin_exercice=dateFrToUs($_POST['au']);
	
	}
	
?>
</table>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Detail Evaluation"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "produit.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php $jour=date("d/m/Y H:m:s");echo "Quantités Matieres Premieres :  du : $du1 au $au1 edité le $jour"; ?></span>

<table class="table2">
<tr>
<td bgcolor="#66FFCC"><? $t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t7=0;$t8=0;$t9=0;echo "Matieres/kg";?></td>
<td bgcolor="#66FFCC"><? echo "Stock initial M.";?></td>
<td bgcolor="#66FFCC"><? echo "Stock initial M.P.F";?></td>
<td><? echo "Janvier";?><table><tr>
<td bgcolor="#66FFCC"><? echo "Achats";?></td>
<td bgcolor="#66FFCC"><? echo "Consommé";?></td></td>
<td><? echo "Janvier";?><table><tr>
<td bgcolor="#66FFCC"><? echo "Achats";?></td>
<td bgcolor="#66FFCC"><? echo "Consommé";?></td></td>
<td><? echo "Janvier";?><table><tr>
<td bgcolor="#66FFCC"><? echo "Achats";?></td>
<td bgcolor="#66FFCC"><? echo "Consommé";?></td></td>


</tr>
<?	
		if(isset($_REQUEST["action"]))
		
	{
	
	

	$sql  = "SELECT * ";$vide="";$mt=0;$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t7=0;$t8=0;$t9=0;
	$sql .= "FROM types_matieres where profile_name<>'$vide' ORDER BY profile_name;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) { $stock_final_matiere=0;$stock_encours_final=0;
	$stock_initial_pf=0;$stock_final_pf=0;$stock_final=0;$encours_initial_pf=0;$encours_final_pf=0;$stock_initial=0;
 		$matiere = $users_["profile_name"];$m=0;$vfm=0;
	echo "<tr><td><a href=\"ca_par_matiere_details.php?matiere=$matiere&du=$debut_exercice&au=$fin_exercice\">$matiere</a></td>";
	 $sql11  = "SELECT * ";
	$sql11 .= "FROM achats_mat where produit='$matiere' and date between '$debut_exercice' and '$fin_exercice' ORDER BY produit;";
	$users11 = db_query($database_name, $sql11);$achats=0;$prix_revient=0;
	while($users11_ = fetch_array($users11)) { 
 		$produit = $users11_["produit"];
		$achats = $achats+$users11_["qte"];$prix_revient=$prix_revient+($users11_["qte"]*$users11_["prix_achat"]);
		
	}
	//stock initial
	
	
	 $sql1  = "SELECT * ";$d="2012-01-01";$d_exe1="2013-01-01";
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
			
			/*$sql15  = "SELECT * ";
			$sql15 .= "FROM stock_final_pf where produit='$produit' and date_exe='$du' ORDER BY produit;";
			$users115 = db_query($database_name, $sql15);$stock_ini_exe=0;
			$users115_ = fetch_array($users115);
			$stock_ini_exe=$users115_["stock_final"];*/

		
		
		
		
		$sql1  = "SELECT * ";
		$stock_final_matiere=$stock_final_matiere+($users1_["stock_final"]*$users1_["poids"]/1000);
		$stock_encours_final = $stock_encours_final+($users1_["en_cours_final"]*$users1_["poids"]/1000);

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
	
	{?>	<? $m=$m+($qte*$poids/1000);$mt=$mt+$m; ?><? }
	 ?>
	<? }?>
	<td align="right"><? $spf=0;$sm=0;$t1=$t1+$stock_initial;$si=number_format($stock_initial,3,',',' ');
	print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$si </font>");?></td>
	<td align="right"><? $t2=$t2+$stock_initial_pf;$sipf=number_format($stock_initial_pf,3,',',' ');
	print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$sipf </font>");;?></td>
	<? $ec_i=0;$ec_f=$stock_encours_final;?>
	<td align="right"><? $t3=$t3+$encours_initial_pf;$ec_i_f=number_format($encours_initial_pf,3,',',' ');
	print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ec_i_f </font>");?></td>
	<td align="right"><? $t4=$t4+$achats;$ach=number_format($achats,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ach </font>");?></td>
	<td align="right"><? $t5=$t5+$m;$maf=number_format($m,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$maf </font>");?></td>
	<? $mf=$stock_initial+$ec_i+($stock_initial_pf)+$achats-$m;
	$spf=$stock_final_matiere;
	$t6=$t6+$spf;
	$sm=$stock_initial+$stock_initial_pf+$encours_initial_pf+$achats-$m-$spf-$stock_encours_final;

	$smf=number_format($sm,3,',',' ');
	
	$cout_revient=0;?>
	<? ////////////////////////////////////////report à nouveau
				$mat="mat";$frs="report";$date="2012-01-01";$p_r=$cout*$sm;
				$sql  = "INSERT INTO report_mat ( produit,type, frs,date,stock_final_pf,stock_final_mp,encours,valeur_final_mp ) VALUES ( ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $mat . "', ";
				$sql .= "'" . $frs . "', ";
				$sql .= "'" . $d_exe1 . "', ";
				$sql .= "'" . $spf . "', ";
				$sql .= "'" . $sm . "', ";
				$sql .= "'" . $ec_f . "', ";
				$sql .= $p_r . ");";

				db_query($database_name, $sql);

	?>
	
	<td align="right"><? $spfaf=number_format($spf,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$spfaf </font>");;?></td>
	<td align="right"><? $t7=$t7+$ec_f;$ec_f_f=number_format($ec_f,3,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ec_f_f </font>");;?></td>
	<td align="right"><? $t8=$t8+$sm;print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$smf </font>");?></td>
	<td align="right"><? $cmup1= number_format($cout,2,',',' ');$cmup= $cout;print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$cmup1 </font>");?></td>
	<td align="right"><? $t9=$t9+($cout*$sm);$coutt=number_format($cmup*$sm,2,',',' ');$v_f_m_p=$cmup*$sm;echo $coutt;?></td>
	
	<? 
				$type="matiere";
				$sql  = "INSERT INTO tableau_matiere ( matiere,type,s_i_m, s_i_m_p_f,encours_1_1,achats_matiere,consome,s_f_p_f,encours_31_12,s_f_m_p,cmup,v_f_m_p ) VALUES ( ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= "'" . $stock_initial . "', ";
				$sql .= "'" . $stock_initial_pf . "', ";
				$sql .= "'" . $encours_initial_pf . "', ";
				$sql .= "'" . $achats . "', ";
				$sql .= "'" . $m . "', ";
				$sql .= "'" . $spf . "', ";
				$sql .= "'" . $ec_f . "', ";
				$sql .= "'" . $sm . "', ";
				$sql .= "'" . $cmup . "', ";
				$sql .= $v_f_m_p . ");";

				db_query($database_name, $sql);

	
	
	}?>

	<? }?>
	

<? echo "<tr><td><a href=\"fiche_matiere_premiere.php?du=$du&au=$au\">Matiere Premiere</a></td>";?>

<? ?>

</body>

</html>