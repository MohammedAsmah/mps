<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();$user_name=GetUserName();
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$employe = $_REQUEST["employe"];$ref = $_REQUEST["ref"];$service = $_REQUEST["service"];$poste = $_REQUEST["poste"];$ordre = $_REQUEST["ordre"];
			$poste = $_REQUEST["poste"];if(isset($_REQUEST["statut"])) { $statut = 1; } else { $statut = 0; }
			$t_h_normales = $_REQUEST["t_h_normales"];$t_h_25 = $_REQUEST["t_h_25"];$t_h_50 = $_REQUEST["t_h_50"];
			if(isset($_REQUEST["manual"])) { $manual = 1; } else { $manual = 0; }
				$sam_m = $_REQUEST["sam_m"];$dim_m = $_REQUEST["dim_m"];$lun_m = $_REQUEST["lun_m"];$mar_m = $_REQUEST["mar_m"];
			$mer_m = $_REQUEST["mer_m"];$jeu_m = $_REQUEST["jeu_m"];$ven_m = $_REQUEST["ven_m"];
			$sam_s = $_REQUEST["sam_s"];$dim_s = $_REQUEST["dim_s"];$lun_s = $_REQUEST["lun_s"];$mar_s = $_REQUEST["mar_s"];
			$mer_s = $_REQUEST["mer_s"];$jeu_s = $_REQUEST["jeu_s"];$ven_s = $_REQUEST["ven_s"];
			$sam_sup = $_REQUEST["sam_sup"];$dim_sup = $_REQUEST["dim_sup"];$lun_sup = $_REQUEST["lun_sup"];$mar_sup = $_REQUEST["mar_sup"];
			$mer_sup = $_REQUEST["mer_sup"];$jeu_sup = $_REQUEST["jeu_sup"];$ven_sup = $_REQUEST["ven_sup"];
			if(isset($_REQUEST["valide"])) { $valide = 1; } else { $valide = 0; }
			$observations = $_REQUEST["observations"];
			if(isset($_REQUEST["valide_sam"]) or $sam_m<>'') { $valide_sam = 1; } else { $valide_sam = 0; }
			if(isset($_REQUEST["valide_dim"]) or $dim_m<>'') { $valide_dim = 1; } else { $valide_dim = 0; }
			if(isset($_REQUEST["valide_lun"]) or $lun_m<>'')  { $valide_lun = 1; } else { $valide_lun = 0; }
			if(isset($_REQUEST["valide_mar"]) or $mar_m<>'') { $valide_mar = 1; } else { $valide_mar = 0; }
			if(isset($_REQUEST["valide_mer"]) or $mer_m<>'') { $valide_mer = 1; } else { $valide_mer = 0; }
			if(isset($_REQUEST["valide_jeu"]) or $jeu_m<>'') { $valide_jeu = 1; } else { $valide_jeu = 0; }
			if(isset($_REQUEST["valide_ven"]) or $ven_m<>'') { $valide_ven = 1; } else { $valide_ven = 0; }
			
			$motif_sam = $_REQUEST["motif_sam"];$motif_dim = $_REQUEST["motif_dim"];$motif_lun = $_REQUEST["motif_lun"];
			$motif_mar = $_REQUEST["motif_mar"];$motif_mer = $_REQUEST["motif_mer"];$motif_jeu = $_REQUEST["motif_jeu"];
			$motif_ven = $_REQUEST["motif_ven"];
			//////////////////////////////////////////
			
		
		$repos=0;if ($sam_m+$sam_s==0 or $lun_m+$lun_s==0 or $mar_m+$mar_s==0 or $mer_m+$mer_s==0 
			or $jeu_m+$jeu_s==0 or $ven_m+$ven_s==0){$repos=1;}
		
		
		$hn=0;$t_h_s_25=0;$t_h_s_50=0;
		$heures_normales=$sam_m+$sam_s+$lun_m+$lun_s+$mar_m+$mar_s+$mer_m+$mer_s+$jeu_m+$jeu_s+$ven_m+$ven_s;
		$heures_sup=$sam_sup+$lun_sup+$mar_sup+$mer_sup+$jeu_sup+$ven_sup;
		$ht=$heures_normales+$heures_sup;
		if ($heures_normales>=44)
		{$hn=44;$t_h_s_25=$sam_sup+$lun_sup+$mar_sup+$mer_sup+$jeu_sup+$ven_sup+($heures_normales-44);
		if ($repos==0){$t_h_s_50=$dim_m+$dim_s+$dim_sup;}
		else{$t_h_s_25=$t_h_s_25+$dim_m+$dim_s+$dim_sup;$t_h_s_50=0;}}
		else {
			if ($heures_normales+$heures_sup>=44)
				{$hn=44;$t_h_s_25=$ht-44;if ($repos==0){$t_h_s_50=$dim_m+$dim_s+$dim_sup;}else{$t_h_s_25=$t_h_s_25+$dim_m+$dim_s+$dim_sup;$t_h_s_50=0;}}
				else
				{$htt=$heures_normales+$heures_sup+$dim_m+$dim_s+$dim_sup;
				if ($htt>=44){$hn=44;$t_h_s_25=$htt-44;$t_h_s_50=0;}
				else {$hn=$heures_normales+$heures_sup+$dim_m+$dim_s+$dim_sup;$t_h_s_25=0;$t_h_s_50=0;}
				}
			}
			
		////////////////////////////////////////////////////////
			
			
			
			
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO employes ( code, employe,service,statut,poste )
				 VALUES ('$ref','$employe','$service','$statut','$poste')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE employes SET ordre = '$ordre',ref = '$ref',employe = '$employe',t_h_normales='$hn',
				t_h_25='$t_h_s_25',t_h_50='$t_h_s_50',valide='$valide', 
				sam_m='$sam_m',dim_m='$dim_m',lun_m='$lun_m',mar_m='$mar_m',mer_m='$mer_m',jeu_m='$jeu_m',ven_m='$ven_m',
			sam_s='$sam_s',dim_s='$dim_s',lun_s='$lun_s',mar_s='$mar_s',mer_s='$mer_s',jeu_s='$jeu_s',ven_s='$ven_s',
			sam_sup='$sam_sup',dim_sup='$dim_sup',lun_sup='$lun_sup',mar_sup='$mar_sup',mer_sup='$mer_sup',jeu_sup='$jeu_sup',ven_sup='$ven_sup',
			valide_sam='$valide_sam',valide_dim='$valide_dim',valide_lun='$valide_lun',valide_mar='$valide_mar',valide_mer='$valide_mer',valide_jeu='$valide_jeu',
			valide_ven='$valide_ven',observations='$observations',motif_sam='$motif_sam',motif_dim='$motif_dim',
			motif_lun='$motif_lun',motif_mar='$motif_mar',motif_mer='$motif_mer',motif_jeu='$motif_jeu',motif_ven='$motif_ven'
			
				WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM employes WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";$occ="occasionnelles";$per="permanents";$vide="";$semaine="semaine";
	$sql .= "FROM employes where employe<>'$vide' and cloture=0 and statut=0 and service='$per' and paie='$semaine' ORDER BY service DESC ,ordre,ordre1,date_entree;";
	$users = db_query($database_name, $sql);$erreur=0;$compteur=0;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Pointage "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "employe2.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php $date_e=date("d/m/Y h:m:s");

	$sql  = "SELECT * ";
	$sql .= "FROM paie_ouvriers ORDER BY id;";
	$users2 = db_query($database_name, $sql);
	while($users_2 = fetch_array($users2)) 
	{ if ($users_2["encours"]==1){$du=$users_2["du"];$au=$users_2["au"];$ferier_1=$users_2["ferier_1"];$ferier_2=$users_2["ferier_2"];}
	}
$titre= "ETAT H.SUP PERMANENTS Du $du au $au ";print("<font size=\"4\" face=\"Comic sans MS\" color=\"000033\">$titre </font>"); ?></span>

<table class="table2">

<tr>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Nom et Prenom </font>");?></th>

	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">H.T.Ferier </font>");?></th>	
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">H.Sup 25% </font>");?></th>	
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">H.Sup 50% </font>");?></th>	
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Total </font>");?></th>	
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">S.H </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Montant </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Arrondi </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Prelev./Av </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Net </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Signature </font>"); ?></th>	
	
</tr>

<?php while($users_ = fetch_array($users)) { ?>
<? 

 
	$compteur=$compteur+1;
	$samedi=$users_["sam_m"]+$users_["sam_s"]+$users_["sam_sup"];
	$dimanche=$users_["dim_m"]+$users_["dim_s"]+$users_["dim_sup"];
	$lundi=$users_["lun_m"]+$users_["lun_s"]+$users_["lun_sup"];
	$mardi=$users_["mar_m"]+$users_["mar_s"]+$users_["mar_sup"];
	$mercredi=$users_["mer_m"]+$users_["mer_s"]+$users_["mer_sup"];
	$jeudi=$users_["jeu_m"]+$users_["jeu_s"]+$users_["jeu_sup"];
	$vendredi=$users_["ven_m"]+$users_["ven_s"]+$users_["ven_sup"];
	
	$total_heures=$samedi+$dimanche+$lundi+$mardi+$mercredi+$jeudi+$vendredi;
	switch($ferier_1) {

			case "lundi":
				$jour_ferier_date1=$lundi;
			break;
			case "mardi":
				$jour_ferier_date1=$mardi;
			break;
			case "mercredi":
				$jour_ferier_date1=$mercredi;
			break;
			case "jeudi":
				$jour_ferier_date1=$jeudi;
			break;
			case "vendredi":
				$jour_ferier_date1=$vendredi;
			break;
			case "samedi":
				$jour_ferier_date1=$samedi;
			break;
			case "dimanche":
				$jour_ferier_date1=$dimanche;
			break;
			
		}
		switch($ferier_2) {

			case "lundi":
				$jour_ferier_date2=$lundi;
			break;
			case "mardi":
				$jour_ferier_date2=$mardi;
			break;
			case "mercredi":
				$jour_ferier_date2=$mercredi;
			break;
			case "jeudi":
				$jour_ferier_date2=$jeudi;
			break;
			case "vendredi":
				$jour_ferier_date2=$vendredi;
			break;
			case "samedi":
				$jour_ferier_date2=$samedi;
			break;
			case "dimanche":
				$jour_ferier_date2=$dimanche;
			break;
			
		} //switch
	$total_sans_jour_ferier=$total_heures-$jour_ferier_date1-$jour_ferier_date2;
	$jour_ferier=0;
	
	$jour_ferier_t=$jour_ferier_date1+$jour_ferier_date2;if ($ferier_1){$jour_ferier=$jour_ferier+8;}
	if ($ferier_2){$jour_ferier=$jour_ferier+8;}
	$base = 44-$jour_ferier;
	if ($total_sans_jour_ferier>$base){$heures_journal=$base;}else{$heures_journal=$total_sans_jour_ferier;}
	
	
	
	$heures_sup=$total_sans_jour_ferier-$base;
	if ($heures_sup<=0){$heures_sup=0;$heures_sup_25=0;$heures_sup_50=0;}
	else {
	if ($samedi>0 and $dimanche>0 and $lundi>0 and $mardi>0 and $mercredi>0 and $jeudi>0 and $vendredi>0){$heures_sup_25=$heures_sup-$dimanche;$heures_sup_50=$dimanche;}
	else {$heures_sup_25=$heures_sup;$heures_sup_50=0;}
	}
	
	
	$m=$users_["s_h"]*($jour_ferier_t+$heures_sup_25*1.25+$heures_sup_50*1.50);
	if  ($m>0){
	
	?>

<tr>
<td><?php $employe=$users_["employe"];print("<font size=\"1.5\" face=\"Comic sans MS\" color=\"000033\">$employe </font>");?></td>
<td align="right" ><?php $ft= number_format($jour_ferier_t,2,',',' '); print("<font size=\"1.5\" face=\"Comic sans MS\" color=\"000033\">$ft </font>");?></td>
<td align="right" ><?php $t25= number_format($heures_sup_25,2,',',' ');print("<font size=\"1.5\" face=\"Comic sans MS\" color=\"000033\">$t25 </font>"); ?></td>
<td align="right" ><?php $t50= number_format($heures_sup_50,2,',',' '); print("<font size=\"1.5\" face=\"Comic sans MS\" color=\"000033\">$t50 </font>");?></td>
<td align="right" ><?php $tt= number_format($jour_ferier_t+$heures_sup_25*1.25+$heures_sup_50*1.50,2,',',' ');print("<font size=\"1.5\" face=\"Comic sans MS\" color=\"000033\">$tt </font>"); ?></td>

<td align="right" ><?php $sh =number_format($users_["s_h"],2,',',' '); print("<font size=\"1.5\" face=\"Comic sans MS\" color=\"000033\">$sh </font>");?></td>
<td align="right" ><?php 
$tbrut= number_format($users_["s_h"]*($jour_ferier_t+$heures_sup_25*1.25+$heures_sup_50*1.50),2,'.',''); 
$totalbrut= $users_["s_h"]*($jour_ferier_t+$heures_sup_25*1.25+$heures_sup_50*1.50);
print("<font size=\"1.5\" face=\"Comic sans MS\" color=\"000033\">$tbrut </font>");?></td>
<td align="right"><?php $arrondi=0;$virgule=explode(".", $tbrut);$v=$virgule[1];$m=$virgule[0];
$arrondi=$v;if ($arrondi>0 and $arrondi<10){$arrondi=10;}if ($arrondi==0){$arrondi=0;}if ($arrondi>10 and $arrondi<20){$arrondi=20;}
if ($arrondi>20 and $arrondi<30){$arrondi=30;}if ($arrondi>30 and $arrondi<40){$arrondi=40;} 
if ($arrondi>40 and $arrondi<50){$arrondi=50;}if ($arrondi>50 and $arrondi<60){$arrondi=60;}
if ($arrondi>60 and $arrondi<70){$arrondi=70;}if ($arrondi>70 and $arrondi<80){$arrondi=80;}
if ($arrondi>80 and $arrondi<90){$arrondi=90;}if ($arrondi>90 and $arrondi<100){$arrondi=100;}
$r = $arrondi-$v;print("<font size=\"1.5\" face=\"Comic sans MS\" color=\"000033\">$r </font>");?></td>

<td align="right"><?php $sb=$m+$arrondi/100;
		
				if ($appliquer_avance==0){$prelevement=0;}else {if ($sb>=50 and $sb<100){$prelevement=50;}else{$prelevement=100;}if($sb<50){$prelevement=0;} }
				
				
				$sql  = "SELECT * ";
				$sql .= "FROM avances_employes where employe='$employe' ORDER BY date_avance;";
				$users22 = db_query($database_name, $sql);$avances=0;$s_r=0;
				while($users_22 = fetch_array($users22)) {
				if ($users_22["type"]=="avance"){$s_r=$s_r+$users_22["montant"];}else{$s_r=$s_r-$users_22["montant"];}
				}
				if ($s_r>0){				
				if ($sb>$prelevement){}else{$prelevement=0;}//provision insufi
				} else {$prelevement=0;} // pas de credit
				if ($s_r<=$prelevement){$prelevement=$s_r;}
				$sb=$sb-$prelevement;


$pr= number_format($prelevement,2,',',' '); $tav=$tav+$prelevement;print("<font size=\"1.5\" face=\"Comic sans MS\" color=\"000033\">$pr </font>");?></td>
<td align="right"><?php $netp= number_format($sb,2,',',' ');$sbt=$sbt+$sb; print("<font size=\"1.5\" face=\"Comic sans MS\" color=\"000033\">$netp </font>"); ?></td>
<td align="right" ><?php $ft=number_format($jour_ferier_t,2,',',' '); print("<font size=\"1.5\" face=\"Comic sans MS\" color=\"000033\"> </font>");?></td>


	<?php }
	} ?>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
<td align="right" ><?php print("<font size=\"1.5\" face=\"Comic sans MS\" color=\"000033\">Total </font>");?></td>
<td align="right" ><?php $total_h=number_format($sbt,2,',',' '); print("<font size=\"1.5\" face=\"Comic sans MS\" color=\"000033\"> $total_h</font>");?></td>
<td></td>
</table>

<p style="text-align:center">


</body>

</html>