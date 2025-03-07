<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	$error_message = "";	$du="";$au="";$action="Recherche";$du1="";$au1="";
//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];
	$error_message = "";
	if(isset($_REQUEST["action_"])) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$statut = $_REQUEST["statut"];
			
			
		}
		
		if ($login=="admin" or $login=="rakia"){
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO pointeuse_mensuel ( name, date_j, statut ) VALUES ( ";
				$sql .= "'" . $employe . "', ";
				$sql .= "'" . $condit . "', ";
				$sql .= "'" . $prix . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $dispo . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE pointeuse_mensuel SET ";
			$sql .= "statut = '" . $_REQUEST["statut"] . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM pointeuse_mensuel WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	}
	} //if
	
		
	
	

	
	?>
	<? 
	
	
	
	$sql  = "SELECT * ";$m="mensuel";$occ="occasionnelles";$per="permanents";
	$sql .= "FROM employes where statut=0 and service<>'$occ' and service<>'$per' ORDER BY employe ;";
	$users2 = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Pointage"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "pointage_mensuel.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Etat Pointage Mensuels 01/07/2011 au 31/07/2011"; ?></span>





<table class="table2">



<?php 

$date2=0;$date1=0;
function date_to_timestamp ($date) {
    return preg_match('/^\s*(\d\d\d\d)-(\d\d)-(\d\d)\s*(\d\d):(\d\d):(\d\d)/', $date, $m)
           ?  mktime($m[4], $m[5], $m[6], $m[2], $m[3], $m[1])
           : 0;
}

function date_diff ($date_recent, $date_old) {
   return date_to_timestamp($date_recent) - date_to_timestamp($date_old);
}

?>
<?



while($users_2 = fetch_array($users2)) { 
	$name=$users_2["employe"];$t_h_dimanche=0;$t_h_samedi=0;$t_h_n=0;$id=$users_2["id"];
	$t_h_normales=0;$t_h_25=0;$t_h_50=0;$t_h_100=0;$mode_pointage=$users_2["mode_pointage"];
	
	
	/*?><tr><th><?php echo $name;?></th><th></th><th></th><th></th></tr>
	
<? */
	
	$service=$users_2["service"];$poste=$users_2["poste"];

	$sql  = "SELECT * ";
	$sql .= "FROM pointeuse_mensuel where name='$name' and non_inclus=0 ORDER BY id;";
	$users = db_query($database_name, $sql);$in=0;$out=0;
	$lun=0;$mar=0;$mer=0;$jeu=0;$ven=0;$sam=0;$dim=0;
	$lun_s=0;$mar_s=0;$mer_s=0;$jeu_s=0;$ven_s=0;$sam_s=0;$dim_s=0;
	$sam_m=0;$dim_m=0;$lun_m=0;$mar_m=0;$mer_m=0;$jeu_m=0;$ven_m=0;
	$sam_soir=0;$dim_soir=0;$lun_soir=0;$mar_soir=0;$mer_soir=0;$jeu_soir=0;$ven_soir=0;
	$j_1=0;$j_2=0;$j_3=0;$j_4=0;$j_5=0;$j_6=0;$j_7=0;

while($users_ = fetch_array($users)) { 

		$de=$users_["date"];
		list($d, $h) = explode(" ", $de);
		list($heures, $min,$seconde) = explode(":", $h);
		list($annee, $mois,$jours) = explode("-", $d);
		$entree="";$sortie="";
		$s1=substr($users_["statut"], 0, 4); 
		$s2=substr($users_["statut"], 0, 5);
		$in_s1=8;$in_m1=7;$in_m2=14;$in_m3=19;


		if ($s1=="C/In")
			{$in=$in+1;$date_in=strtotime($users_["date"]);
			/*echo $in."</br>"; */
			$entree=$heures.":".$min;$in_s=8;$avance_min=0;

			
				$in_s=7;$in_m1=7;$in_m2=14;$in_m3=19;
				if ($heures<$in_m1 or ($heures>12 and $heures<$in_m2) or ($heures>16 and $heures<$in_m3))
					{$avance_min=60-$min;$c_in=$heures;$date1 = mktime($heures,$min,$seconde,$mois,$jours,$annee);}
					else
					{$in_m1=7;$in_m2=14;$in_m3=19;$c_in=$heures;$date1 = mktime($heures,$min,$seconde,$mois,$jours,$annee);}
		
		}

		if ($s2=="C/Out")
			{$out=$out+1;$date_out=strtotime($users_["date"]);$sortie=$heures.":".$min;$c_out=$heures;
			$date2 = mktime($heures,$min,$seconde,$mois,$jours,$annee);
			$diff=$c_out-$c_in;
			$diff_date = $date2-$date1; 
			@$diff['heures'] = (int)($diff_date/(60*60*60)); 
			@$diff['jours'] = (int)($diff_date/(60*60*24)); 
			$heures_totales = $diff_date/(60);$h_t=intval($heures_totales/60);$m_t=$heures_totales%60;
			$tempsreel=$date_out-$date_in;$t_r=strftime('%H:%M:%S', $tempsreel);
			list($hr, $mr,$sr) = explode(":", $t_r);
			$hr=$hr-1;
		}

		if ($s1=="C/In")
			{$datej=$users_["date_j"];
			list($annee1,$mois1,$jour1) = explode('-', $datej); 
			$d = mktime(0,0,0,$mois1,$jour1,$annee1);
			$nom_jour=date("D",$d);$numero_jour=date("d",$d);
			$jour_t="";
			if ($nom_jour=="Sat"){$jour_t="Samedi";} if ($nom_jour=="Sun"){$jour_t="Dimanche";}
			if ($nom_jour=="Mon"){$jour_t="Lundi";} if ($nom_jour=="Tue"){$jour_t="Mardi";}
			if ($nom_jour=="Wed"){$jour_t="Mercredi";} if ($nom_jour=="Thu"){$jour_t="Jeudi";}
			if ($nom_jour=="Fri"){$jour_t="Vendredi";} 
		}

		if ($s2=="C/Out") 
			{ if ($hr<=0)
				{}
				else
					{if ($avance_min>0)
						{if ($avance_min<$mr)
							{$mr=$mr-$avance_min;}
						else
							{$hr=$hr-1;$mr=60-$avance_min+$mr;}
						}

					}
			if ($mr>=25 and $mr<=50){$heures=$hr+0.50;$minute=00;}
			if ($mr<25){$heures=$hr;$minutes=00;}
			if ($mr>50){$heures=$hr+1;$minutes=00;}
			///////////////////////////////////
			if ($nom_jour=="Mon"){if ($heures>=9){$lun_s=$lun_s+$heures-8;$lun=$lun+$heures-$lun_s;$lun_m=$lun_m+4;$lun_soir=$lun_soir+4;}
			else{$lun_s=0;$lun=$lun+$heures;if ($heures>=4){$lun_soir=$lun_soir+$heures-4;$lun_m=$lun_m+4;}else{$lun_soir=0;$lun_m=$lun_m+$heures;}}}
			
			if ($nom_jour=="Tue"){if ($heures>=9){$mar_s=$mar_s+$heures-8;$mar=$mar+$heures-$mar_s;$mar_m=$mar_m+4;$mar_soir=$mar_soir+4;}
			else{$mar_s=0;$mar=$mar+$heures;if ($heures>=4){$mar_soir=$mar_soir+$heures-4;$mar_m=$mar_m+4;}else{$mar_soir=0;$mar_m=$mar_m+$heures;}}}
			
			if ($nom_jour=="Wed"){if ($heures>=9){$mer_s=$mer_s+$heures-8;$mer=$mer+$heures-$mer_s;$mer_m=$mer_m+4;$mer_soir=$mer_soir+4;}
			else{$mer_s=0;$mer=$mer+$heures;if ($heures>=4){$mer_soir=$mer_soir+$heures-4;$mer_m=$mer_m+4;}else{$mer_soir=0;$mer_m=$mer_m+$heures;}}}
			
			if ($nom_jour=="Thu"){if ($heures>=9){$jeu_s=$jeu_s+$heures-8;$jeu=$jeu+$heures-$jeu_s;$jeu_m=$jeu_m+4;$jeu_soir=$jeu_soir+4;}
			else{$jeu_s=0;$jeu=$jeu+$heures;if ($heures>=4){$jeu_soir=$jeu_soir+$heures-4;$jeu_m=$jeu_m+4;}else{$jeu_soir=0;$jeu_m=$jeu_m+$heures;}}}
			
			if ($nom_jour=="Fri"){if ($heures>=9){$ven_s=$ven_s+$heures-8;$ven=$ven+$heures-$ven_s;$ven_m=$ven_m+4;$ven_soir=$ven_soir+4;}
			else{$ven_s=0;$ven=$ven+$heures;if ($heures>=4){$ven_soir=$ven_soir+$heures-4;$ven_m=$ven_m+4;}else{$ven_soir=0;$ven_m=$ven_m+$heures;}}}
			
			if ($nom_jour=="Sat"){if ($heures>=9){$sam_s=$sam_s+$heures-8;$sam=$sam+$heures-$sam_s;$sam_m=$sam_m+4;$sam_soir=$sam_soir+4;}
			else{$sam_s=0;$sam=$sam+$heures;if ($heures>=4){$sam_soir=$sam_soir+$heures-4;$sam_m=$sam_m+4;}else{$sam_soir=0;$sam_m=$sam_m+$heures;}}}
			
			if ($nom_jour=="Sun"){if ($heures>=9){$dim_s=$dim_s+$heures-8;$dim=$dim+$heures-$dim_s;$dim_m=$dim_m+4;$dim_soir=$dim_soir+4;}
			else{$dim_s=0;$dim=$dim+$heures;if ($heures>=4){$dim_soir=$dim_soir+$heures-4;$dim_m=$dim_m+4;}else{$dim_soir=0;$dim_m=$dim_m+$heures;}}}
			
			if ($nom_jour=="Sat"){$t_h_samedi=$t_h_samedi+$heures;}
			if ($nom_jour=="Sun"){$t_h_dimanche=$t_h_dimanche+$heures;}
			if ($nom_jour=="Mon"){$t_h_n=$t_h_n+$lun;$t_h_25=$t_h_25+$lun_s;} 
			if ($nom_jour=="Tue"){$t_h_n=$t_h_n+$mar;$t_h_25=$t_h_25+$mar_s;}
			if ($nom_jour=="Wed"){$t_h_n=$t_h_n+$mer;$t_h_25=$t_h_25+$mer_s;}
			if ($nom_jour=="Thu"){$t_h_n=$t_h_n+$jeu;$t_h_25=$t_h_25+$jeu_s;}
			if ($nom_jour=="Fri"){$t_h_n=$t_h_n+$ven;$t_h_25=$t_h_25+$ven_s;} 
			if ($nom_jour=="Sat"){$t_h_n=$t_h_n+$sam;$t_h_25=$t_h_25+$sam_s;} 
			
			///////////////////////
			if ($numero_jour==1){if ($mode_pointage==0){$j_1=$hr;}else{$j_1=$j_1+$hr;}}
			if ($numero_jour==2){if ($mode_pointage==0){$j_2=$hr;}else{$j_2=$j_2+$hr;}}
			if ($numero_jour==3){if ($mode_pointage==0){$j_3=$heures;}else{$j_3=$j_3+$heures;}}
			if ($numero_jour==4){if ($mode_pointage==0){$j_4=$heures;}else{$j_4=$j_4+$heures;}}
			if ($numero_jour==5){if ($mode_pointage==0){$j_5=$heures;}else{$j_5=$j_5+$heures;}}
			if ($numero_jour==6){if ($mode_pointage==0){$j_6=$heures;}else{$j_6=$j_6+$heures;}}
			if ($numero_jour==7){if ($mode_pointage==0){$j_7=$heures;}else{$j_7=$j_7+$heures;}}
			
			if ($numero_jour==8){if ($mode_pointage==0){$j_8=$heures;}else{$j_8=$j_8+$heures;}}
			if ($numero_jour==9){if ($mode_pointage==0){$j_9=$hr;}else{$j_9=$j_9+$hr;}}
			if ($numero_jour==10){if ($mode_pointage==0){$j_10=$heures;}else{$j_10=$j_10+$heures;}}
			if ($numero_jour==11){if ($mode_pointage==0){$j_11=$heures;}else{$j_11=$j_11+$heures;}}
			if ($numero_jour==12){if ($mode_pointage==0){$j_12=$heures;}else{$j_12=$j_12+$heures;}}
			if ($numero_jour==13){if ($mode_pointage==0){$j_13=$heures;}else{$j_13=$j_13+$heures;}}
			if ($numero_jour==14){if ($mode_pointage==0){$j_14=$heures;}else{$j_14=$j_14+$heures;}}
			
			if ($numero_jour==15){if ($mode_pointage==0){$j_15=$heures;}else{$j_15=$j_15+$heures;}}
			if ($numero_jour==16){if ($mode_pointage==0){$j_16=$heures;}else{$j_16=$j_16+$heures;}}
			if ($numero_jour==17){if ($mode_pointage==0){$j_17=$heures;}else{$j_17=$j_17+$heures;}}
			if ($numero_jour==18){if ($mode_pointage==0){$j_18=$heures;}else{$j_18=$j_18+$heures;}}
			if ($numero_jour==19){if ($mode_pointage==0){$j_19=$heures;}else{$j_19=$j_19+$heures;}}
			if ($numero_jour==20){if ($mode_pointage==0){$j_20=$heures;}else{$j_20=$j_20+$heures;}}
			if ($numero_jour==21){if ($mode_pointage==0){$j_21=$heures;}else{$j_21=$j_21+$heures;}}
			
			if ($numero_jour==22){if ($mode_pointage==0){$j_22=$heures;}else{$j_22=$j_22+$heures;}}
			if ($numero_jour==23){if ($mode_pointage==0){$j_23=$heures;}else{$j_23=$j_23+$heures;}}
			if ($numero_jour==24){if ($mode_pointage==0){$j_24=$heures;}else{$j_24=$j_24+$heures;}}
			if ($numero_jour==25){if ($mode_pointage==0){$j_25=$heures;}else{$j_25=$j_25+$heures;}}
			if ($numero_jour==26){if ($mode_pointage==0){$j_26=$heures;}else{$j_26=$j_26+$heures;}}
			if ($numero_jour==27){if ($mode_pointage==0){$j_27=$heures;}else{$j_27=$j_27+$heures;}}
			if ($numero_jour==28){if ($mode_pointage==0){$j_28=$heures;}else{$j_28=$j_28+$heures;}}
			
			if ($numero_jour==29){if ($mode_pointage==0){$j_29=$heures;}else{$j_29=$j_29+$heures;}}
			if ($numero_jour==30){if ($mode_pointage==0){$j_30=$heures;}else{$j_30=$j_30+$heures;}}
			if ($numero_jour==31){if ($mode_pointage==0){$j_31=$heures;}else{$j_31=$j_31+$heures;}}
			
			
			
			
			
			
			
		} 

	}
 
			$repos=0;if ($sam_m+$sam_s==0 or $lun_m+$lun_s==0 or $mar_m+$mar_s==0 or $mer_m+$mer_s==0 
			or $jeu_m+$jeu_s==0 or $ven_m+$ven_s==0){$repos=1;}
		
		
		$hn=0;$t_h_s_25=0;$t_h_s_50=0;
		$heures_normales=$sam_m+$sam_soir+$lun_m+$lun_soir+$mar_m+$mar_soir+$mer_m+$mer_soir+$jeu_m+$jeu_soir+$ven_m+$ven_soir;
		$heures_sup=$sam_s+$lun_s+$mar_s+$mer_s+$jeu_s+$ven_s;
		$ht=$heures_normales+$heures_sup;
		$hn=$heures_normales;
		
					
			
			
			
			
			//update
				if($in==$out){$controle=0;}else{$controle=1;}
			$sql = "UPDATE employes SET ";
			$sql .= "controle = '" . $controle . "', ";
			$sql .= "sam_m = '" . $sam_m . "', ";
			$sql .= "dim_m = '" . $dim_m . "', ";
			$sql .= "lun_m = '" . $lun_m . "', ";
			$sql .= "mar_m = '" . $mar_m . "', ";
			$sql .= "mer_m = '" . $mer_m . "', ";
			$sql .= "jeu_m = '" . $jeu_m . "', ";
			$sql .= "ven_m = '" . $ven_m . "', ";
			$sql .= "sam_s = '" . $sam_soir . "', ";
			$sql .= "dim_s = '" . $dim_soir . "', ";
			$sql .= "lun_s = '" . $lun_soir . "', ";
			$sql .= "mar_s = '" . $mar_soir . "', ";
			$sql .= "mer_s = '" . $mer_soir . "', ";
			$sql .= "jeu_s = '" . $jeu_soir . "', ";
			$sql .= "ven_s = '" . $ven_soir . "', ";
			$sql .= "sam_sup = '" . $sam_s . "', ";
			$sql .= "dim_sup = '" . $dim_s . "', ";
			$sql .= "lun_sup = '" . $lun_s . "', ";
			$sql .= "mar_sup = '" . $mar_s . "', ";
			$sql .= "mer_sup = '" . $mer_s . "', ";
			$sql .= "jeu_sup = '" . $jeu_s . "', ";
			$sql .= "ven_sup = '" . $ven_s . "', ";	
			$sql .= "heures = '" . $heures . "', ";	
			$sql .= "t_h_25 = '" . $t_h_s_25 . "', ";
			$sql .= "t_h_50 = '" . $t_h_s_50 . "', ";
			$sql .= "c_in = '" . $in . "', ";
			$sql .= "c_out = '" . $out . "', ";
			$sql .= "j_1 = '" . $j_1 . "', ";
			$sql .= "j_2 = '" . $j_2 . "', ";
			$sql .= "j_3 = '" . $j_3 . "', ";
			$sql .= "j_4 = '" . $j_4 . "', ";
			$sql .= "j_5 = '" . $j_5 . "', ";
			$sql .= "j_6 = '" . $j_6 . "', ";
			$sql .= "j_7 = '" . $j_7 . "', ";
			
			$sql .= "j_8 = '" . $j_8 . "', ";
			$sql .= "j_9 = '" . $j_9 . "', ";
			$sql .= "j_10 = '" . $j_10 . "', ";
			$sql .= "j_11 = '" . $j_11 . "', ";
			$sql .= "j_12 = '" . $j_12 . "', ";
			$sql .= "j_13 = '" . $j_13 . "', ";
			$sql .= "j_14 = '" . $j_14 . "', ";
			
			$sql .= "j_15 = '" . $j_15 . "', ";
			$sql .= "j_16 = '" . $j_16 . "', ";
			$sql .= "j_17 = '" . $j_17 . "', ";
			$sql .= "j_18 = '" . $j_18 . "', ";
			$sql .= "j_19 = '" . $j_19 . "', ";
			$sql .= "j_20 = '" . $j_20 . "', ";
			$sql .= "j_21 = '" . $j_21 . "', ";
			
			$sql .= "j_22 = '" . $j_22 . "', ";
			$sql .= "j_23 = '" . $j_23 . "', ";
			$sql .= "j_24 = '" . $j_24 . "', ";
			$sql .= "j_25 = '" . $j_25 . "', ";
			$sql .= "j_26 = '" . $j_26 . "', ";
			$sql .= "j_27 = '" . $j_27 . "', ";
			$sql .= "j_28 = '" . $j_28 . "', ";
			
			$sql .= "j_29 = '" . $j_29 . "', ";
			$sql .= "j_30 = '" . $j_30 . "', ";
			$sql .= "j_31 = '" . $j_31 . "', ";
			
			
			
			
			$sql .= "t_h_normales = '" . $hn . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
 ?>

<?php } ?>

</table>

<? $sql  = "SELECT * ";$occ="occasionnelles";$per="permanents";
	$sql .= "FROM employes where statut=0 and service<>'$occ' and service<>'$per' ORDER BY service,employe;";
	$users2 = db_query($database_name, $sql);

	?>
<table class="table2">

<tr>
	<th><?php print("<font size=\"0.5\" face=\"Arial\" color=\"000033\">Nom prenom </font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Courrier\" color=\"000033\">01</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">02</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">03</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">04</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">05</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">06</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">07</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">08</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">09</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">10</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">11</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">12</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">13</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">14</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">15</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">16</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">17</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">18</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">19</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">20</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">21</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">22</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">23</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">24</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">25</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">26</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">27</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">28</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">29</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">30</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">31</font>");?></th>
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">T.H</font>");?></th>	
	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\" color=\"000033\">T.J</font>");?></th>	
	
</tr>

<?php $tr=0;while($users_2 = fetch_array($users2)) { ?><tr>
<?php $em=$users_2["employe"];?>	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$em</font>");?></th>
<?php $j_1=number_format($users_2["j_1"],2,',',' '); ?>	<th><?php print("<font size=\"0.5\" face=\"Courrier\">$j_1</font>");?></th>
<?php $j_2= number_format($users_2["j_2"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_2</font>");?></th>
<?php $j_3= number_format($users_2["j_3"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_3</font>");?></th>
<?php $j_4= number_format($users_2["j_4"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_4</font>");?></th>
<?php $j_5= number_format($users_2["j_5"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_5</font>");?></th>
<?php $j_6= number_format($users_2["j_6"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_6</font>");?></th>
<?php $j_7= number_format($users_2["j_7"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_7</font>");?></th>

<?php $j_8=number_format($users_2["j_8"],2,',',' '); ?>	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_8</font>");?></th>
<?php $j_9= number_format($users_2["j_9"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_9</font>");?></th>
<?php $j_10= number_format($users_2["j_10"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_10</font>");?></th>
<?php $j_11= number_format($users_2["j_11"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_11</font>");?></th>
<?php $j_12= number_format($users_2["j_12"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_12</font>");?></th>
<?php $j_13= number_format($users_2["j_13"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_13</font>");?></th>
<?php $j_14= number_format($users_2["j_14"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_14</font>");?></th>

<?php $j_15=number_format($users_2["j_15"],2,',',' '); ?>	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_15</font>");?></th>
<?php $j_16= number_format($users_2["j_16"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_16</font>");?></th>
<?php $j_17= number_format($users_2["j_17"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_17</font>");?></th>
<?php $j_18= number_format($users_2["j_18"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_18</font>");?></th>
<?php $j_19= number_format($users_2["j_19"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_19</font>");?></th>
<?php $j_20= number_format($users_2["j_20"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_20</font>");?></th>
<?php $j_21= number_format($users_2["j_21"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_21</font>");?></th>

<?php $j_22= number_format($users_2["j_22"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_22</font>");?></th>
<?php $j_23= number_format($users_2["j_23"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_23</font>");?></th>
<?php $j_24= number_format($users_2["j_24"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_24</font>");?></th>
<?php $j_25= number_format($users_2["j_25"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_25</font>");?></th>
<?php $j_26= number_format($users_2["j_26"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_26</font>");?></th>
<?php $j_27= number_format($users_2["j_27"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_27</font>");?></th>

<?php $j_28=number_format($users_2["j_28"],2,',',' '); ?>	<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_28</font>");?></th>
<?php $j_29= number_format($users_2["j_29"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_29</font>");?></th>
<?php $j_30= number_format($users_2["j_30"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_30</font>");?></th>
<?php $j_31= number_format($users_2["j_31"],2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$j_31</font>");?></th>

<?php $tj= $users_2["j_1"]+$users_2["j_2"]+$users_2["j_3"]+$users_2["j_4"]+$users_2["j_5"]+$users_2["j_6"]+
$users_2["j_7"]+$users_2["j_8"]+$users_2["j_9"]+$users_2["j_10"]+$users_2["j_11"]+$users_2["j_12"]+$users_2["j_13"]+
$users_2["j_14"]+$users_2["j_15"]+$users_2["j_16"]+$users_2["j_17"]+$users_2["j_18"]+$users_2["j_19"]+$users_2["j_20"]+
$users_2["j_21"]+$users_2["j_22"]+$users_2["j_23"]+$users_2["j_24"]+$users_2["j_25"]+$users_2["j_26"]+$users_2["j_27"]+
$users_2["j_28"]+$users_2["j_29"]+$users_2["j_30"]+$users_2["j_31"]; ?>
<?php $tjj= number_format($tj,2,',',' '); ?><th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$tjj</font>");?></th>
<? 

$t_jours=0;
if ($users_2["j_1"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_2"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_3"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_4"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_5"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_6"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_7"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_8"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_9"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_10"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_11"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_12"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_13"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_14"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_15"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_16"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_17"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_18"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_19"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_20"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_21"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_22"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_22"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_23"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_24"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_25"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_26"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_27"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_28"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_29"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_30"]<>0){$t_jours=$t_jours+1;}
if ($users_2["j_31"]<>0){$t_jours=$t_jours+1;}
?>
<th><?php print("<font size=\"0.5\" face=\"Comic sans MS\">$t_jours</font>");?></th>

<?php } ?>

</table>



<p style="text-align:center">

</body>

</html>