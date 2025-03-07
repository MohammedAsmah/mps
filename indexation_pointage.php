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
			
		
				$sql  = "INSERT INTO pointeuse ( name, date_j, statut ) VALUES ( ";
				$sql .= "'" . $employe . "', ";
				$sql .= "'" . $condit . "', ";
				$sql .= "'" . $prix . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $dispo . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE pointeuse SET ";
			$sql .= "statut = '" . $_REQUEST["statut"] . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM pointeuse WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	}
	} //if
	
		
	
	

	
	?>
	<? 
	
	
	
	$sql  = "SELECT * ";
	$sql .= "FROM employes where statut=0 ORDER BY employe ;";
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
	function EditUser(user_id) { document.location = "pointage.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Etat Pointage 07/05/2011 au 13/05/2011"; ?></span>





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
	$t_h_normales=0;$t_h_25=0;$t_h_50=0;$t_h_100=0;
		$valide_sam=$users_2["valide_sam"];
		$valide_dim=$users_2["valide_dim"];
		$valide_lun=$users_2["valide_lun"];
		$valide_mar=$users_2["valide_mar"];
		$valide_mer=$users_2["valide_mer"];
		$valide_jeu=$users_2["valide_jeu"];
		$valide_ven=$users_2["valide_ven"];
	
	
	
	
	
	
	/*?><tr><th><?php echo $name;?></th><th></th><th></th><th></th></tr>
	
<? */
	
	$service=$users_2["service"];$poste=$users_2["poste"];

	$sql  = "SELECT * ";
	$sql .= "FROM pointeuse where name='$name' and non_inclus=0 ORDER BY id;";
	$users = db_query($database_name, $sql);$in=0;$out=0;
	$lun=0;$mar=0;$mer=0;$jeu=0;$ven=0;$sam=0;$dim=0;
	$lun_s=0;$mar_s=0;$mer_s=0;$jeu_s=0;$ven_s=0;$sam_s=0;$dim_s=0;
	$sam_m=0;$dim_m=0;$lun_m=0;$mar_m=0;$mer_m=0;$jeu_m=0;$ven_m=0;
	$sam_soir=0;$dim_soir=0;$lun_soir=0;$mar_soir=0;$mer_soir=0;$jeu_soir=0;$ven_soir=0;

while($users_ = fetch_array($users)) { 

		$de=$users_["date"];
		list($d, $h) = explode(" ", $de);
		list($heures, $min,$seconde) = explode(":", $h);
		list($annee, $mois,$jours) = explode("-", $d);
		$entree="";$sortie="";
		$s1=substr($users_["statut"], 0, 4); 
		$s2=substr($users_["statut"], 0, 5);
		$in_s1=8;$in_m1=7;$in_m2=14;$in_m3=19;


		/*if ($s1=="C/In")
			{$in=$in+1;$date_in=strtotime($users_["date"]);
			$entree=$heures.":".$min;$in_s=8;$avance_min=0;

			if ($poste=="service" and $name<>"SEMHARI MOHAMED")
				{
				$in_s=8;
				if ($heures<=$in_s)
					{$avance_min=60-$min;$c_in=$heures;$date1 = mktime($heures,$min,$seconde,$mois,$jours,$annee);}
				else {$in_m1=7;$in_m2=14;$in_m3=19;$c_in=$heures;$date1 = mktime($heures,$min,$seconde,$mois,$jours,$annee);}
			}

			if ($poste=="machine" and $name<>"SEMHARI MOHAMED")
				{$in_s=7;$in_m1=7;$in_m2=14;$in_m3=19;
				if ($heures<=$in_m1 or ($heures>12 and $heures<$in_m2) or ($heures>16 and $heures<$in_m3))
					{$avance_min=60-$min;$c_in=$heures;$date1 = mktime($heures,$min,$seconde,$mois,$jours,$annee);}
					else
					{$in_m1=7;$in_m2=14;$in_m3=19;$c_in=$heures;$date1 = mktime($heures,$min,$seconde,$mois,$jours,$annee);}
			}
		}*/

		/////
		 if ($s1=="C/In")
			{$in=$in+1;$date_in=strtotime($users_["date"]);
			$entree=$heures.":".$min;$in_s=8;$avance_min=0;

			if ($poste=="service" and $name<>"SEMHARI MOHAMED")
				{
				/*$in_s=6;*/
				if ($heures<=$in_s)
					{$avance_min=60-$min;$c_in=$heures;$date1 = mktime($heures,$min,$seconde,$mois,$jours,$annee);}
				else {$in_m1=6;$in_m2=14;$in_m3=19;$c_in=$heures;$date1 = mktime($heures,$min,$seconde,$mois,$jours,$annee);}
			}

			if ($poste=="machine" and $name<>"SEMHARI MOHAMED")
				{$in_s=6;$in_m1=6;$in_m2=14;$in_m3=22;
				if ($heures<=$in_m1 or ($heures>12 and $heures<=$in_m2) or ($heures>16 and $heures<=$in_m3))
					{$avance_min=60-$min;$c_in=$heures;$date1 = mktime($heures,$min,$seconde,$mois,$jours,$annee);}
					else
					{$in_m1=6;$in_m2=14;$in_m3=22;$c_in=$heures;$date1 = mktime($heures,$min,$seconde,$mois,$jours,$annee);}
			}
		}
		//////
		
		
		
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
			$nom_jour=date("D",$d);
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
			
			//////////////////////////////////////////////////////
			/*if ($nom_jour=="Mon"){if ($heures>=9){$lun_s=$lun_s+$heures-8;$lun=$lun+$heures-$lun_s;$lun_m=$lun_m+4;$lun_soir=$lun_soir+4;}
			else{$lun_s=0;$lun=$lun+$heures;if ($heures>=4){$lun_soir=$lun_soir+$heures-4;$lun_m=$lun_m+4;}else{$lun_soir=0;$lun_m=$lun_m+$heures;}}}
			if ($nom_jour=="Tue"){if ($heures>=9){$mar_s=$heures-8;$mar=$heures-$mar_s;$mar_m=4;$mar_soir=4;}
			else{$mar_s=0;$mar=$heures;if ($heures>=4){$mar_soir=$heures-4;$mar_m=4;}else{$mar_soir=0;$mar_m=$heures;}}}
			if ($nom_jour=="Wed"){if ($heures>=9){$mer_s=$heures-8;$mer=$heures-$mer_s;$mer_m=4;$mer_soir=4;}
			else{$mer_s=0;$mer=$heures;if ($heures>=4){$mer_soir=$heures-4;$mer_m=4;}else{$mer_soir=0;$mer_m=$heures;}}}
			if ($nom_jour=="Thu"){if ($heures>=9){$jeu_s=$heures-8;$jeu=$heures-$jeu_s;$jeu_m=4;$jeu_soir=4;}
			else{$jeu_s=0;$jeu=$heures;if ($heures>=4){$jeu_soir=$heures-4;$jeu_m=4;}else{$jeu_soir=0;$jeu_m=$heures;}}}
			if ($nom_jour=="Fri"){if ($heures>=9){$ven_s=$heures-8;$ven=$heures-$ven_s;$ven_m=4;$ven_soir=4;}
			else{$ven_s=0;$ven=$heures;if ($heures>=4){$ven_soir=$heures-4;$ven_m=4;}else{$ven_soir=0;$ven_m=$heures;}}}
			if ($nom_jour=="Sat"){if ($heures>=9){$sam_s=$heures-8;$sam=$heures-$sam_s;$sam_m=4;$sam_soir=4;}
			else{$sam_s=0;$sam=$heures;if ($heures>=4){$sam_soir=$heures-4;$sam_m=4;}else{$sam_soir=0;$sam_m=$heures;}}}
			if ($nom_jour=="Sun"){if ($heures>=9){$dim_s=$heures-8;$dim=$heures-$dim_s;$dim_m=4;$dim_soir=4;}
			else{$dim_s=0;$dim=$heures;if ($heures>=4){$dim_soir=$heures-4;$dim_m=4;}else{$dim_soir=0;$dim_m=$heures;}}}
			*/
			///////////////////////////////////////////////////////////////////////////////////
			
			
			
			if ($nom_jour=="Sat"){$t_h_samedi=$t_h_samedi+$heures;}
			if ($nom_jour=="Sun"){$t_h_dimanche=$t_h_dimanche+$heures;}
			if ($nom_jour=="Mon"){$t_h_n=$t_h_n+$lun;$t_h_25=$t_h_25+$lun_s;} 
			if ($nom_jour=="Tue"){$t_h_n=$t_h_n+$mar;$t_h_25=$t_h_25+$mar_s;}
			if ($nom_jour=="Wed"){$t_h_n=$t_h_n+$mer;$t_h_25=$t_h_25+$mer_s;}
			if ($nom_jour=="Thu"){$t_h_n=$t_h_n+$jeu;$t_h_25=$t_h_25+$jeu_s;}
			if ($nom_jour=="Fri"){$t_h_n=$t_h_n+$ven;$t_h_25=$t_h_25+$ven_s;} 
			if ($nom_jour=="Sat"){$t_h_n=$t_h_n+$sam;$t_h_25=$t_h_25+$sam_s;} 
		} 

	}
 
			/*
			$repos=0;if ($sam_m+$sam_s==0 or $lun_m+$lun_s==0 or $mar_m+$mar_s==0 or $mer_m+$mer_s==0 
			or $jeu_m+$jeu_s==0 or $ven_m+$ven_s==0){$repos=1;}
		
		
		$hn=0;$t_h_s_25=0;$t_h_s_50=0;
		$heures_normales=$sam_m+$sam_soir+$lun_m+$lun_soir+$mar_m+$mar_soir+$mer_m+$mer_soir+$jeu_m+$jeu_soir+$ven_m+$ven_soir;
		$heures_sup=$sam_s+$lun_s+$mar_s+$mer_s+$jeu_s+$ven_s;
		$ht=$heures_normales+$heures_sup;
		if ($heures_normales>=44)
		{$hn=44;$t_h_s_25=$sam_s+$lun_s+$mar_s+$mer_s+$jeu_s+$ven_s+($heures_normales-44);
		if ($repos==0){$t_h_s_50=$dim_m+$dim_soir+$dim_s;}
		else{$t_h_s_25=$t_h_s_25+$dim_m+$dim_soir+$dim_s;$t_h_s_50=0;}}
		else {
			if ($heures_normales+$heures_sup>=44)
				{$hn=44;$t_h_s_25=$ht-44;if ($repos==0){$t_h_s_50=$dim_m+$dim_soir+$dim_s;}
				else{$t_h_s_25=$t_h_s_25+$dim_m+$dim_soir+$dim_s;$t_h_s_50=0;}}
				else
				{$htt=$heures_normales+$heures_sup+$dim_m+$dim_soir+$dim_s;
				if ($htt>=44){$hn=44;$t_h_s_25=$htt-44;$t_h_s_50=0;}
				else {$hn=$heures_normales+$heures_sup+$dim_m+$dim_soir+$dim_s;$t_h_s_25=0;$t_h_s_50=0;}
				}
			}
			*/
			
			
			
			
			
			
			
			
			//update
				if($in==$out){$controle=0;}else{$controle=1;}
			$sql = "UPDATE employes SET ";
			$sql .= "controle = '" . $controle . "', ";
			if ($valide_sam==0){
			$sql .= "sam_m = '" . $sam_m . "', ";
			$sql .= "sam_s = '" . $sam_soir . "', ";
			$sql .= "sam_sup = '" . $sam_s . "', ";}
			if ($valide_dim==0){
			$sql .= "dim_m = '" . $dim_m . "', ";
			$sql .= "dim_s = '" . $dim_soir . "', ";
			$sql .= "dim_sup = '" . $dim_s . "', ";}
			if ($valide_lun==0){
			$sql .= "lun_m = '" . $lun_m . "', ";
			$sql .= "lun_s = '" . $lun_soir . "', ";
			$sql .= "lun_sup = '" . $lun_s . "', ";}
			if ($valide_mar==0){
			$sql .= "mar_m = '" . $mar_m . "', ";
			$sql .= "mar_s = '" . $mar_soir . "', ";
			$sql .= "mar_sup = '" . $mar_s . "', ";}
			if ($valide_mer==0){
			$sql .= "mer_m = '" . $mer_m . "', ";
			$sql .= "mer_s = '" . $mer_soir . "', ";
			$sql .= "mer_sup = '" . $mer_s . "', ";}
			if ($valide_jeu==0){
			$sql .= "jeu_m = '" . $jeu_m . "', ";
			$sql .= "jeu_s = '" . $jeu_soir . "', ";
			$sql .= "jeu_sup = '" . $jeu_s . "', ";}
			if ($valide_ven==0){
			$sql .= "ven_m = '" . $ven_m . "', ";
			$sql .= "ven_s = '" . $ven_soir . "', ";
			$sql .= "ven_sup = '" . $ven_s . "', ";	}

			$sql .= "heures = '" . $heures . "' ";	
			/*$sql .= "t_h_25 = '" . $t_h_s_25 . "', ";
			$sql .= "t_h_50 = '" . $t_h_s_50 . "', ";
			$sql .= "t_h_normales = '" . $hn . "' ";*/
			$sql .= "WHERE valide=0 and id = " . $id . ";";
			db_query($database_name, $sql);
 ?>

<?php } ?>

</table>

<? $sql  = "SELECT * ";$occ="occasionnelles";$per="permanents";
	$sql .= "FROM employes where statut=0 and (service='$occ' or service='$per') ORDER BY service,employe;";
	$users2 = db_query($database_name, $sql);

	?>
<table class="table2">

<tr>
	<th><?php echo "Nom et Prenom ";?></th>
	<th><?php echo "H.N";?></th>
	<th><?php echo "H.25%";?></th>
	<th><?php echo "H.50%";?></th>
	<th><?php echo "H.100%";?></th>
	<th><?php echo "Total H.";?></th>	
</tr>

<?php $tr=0;while($users_2 = fetch_array($users2)) { ?><tr>
<? if ($users_2["controle"]==1){?>
<td><?php echo $users_2["employe"];?></td>
<td align="right"><?php echo number_format($users_2["t_h_normales"],2,',',' '); ?></td>
<td align="right"><?php echo number_format($users_2["t_h_25"],2,',',' '); ?></td>
<td align="right"><?php echo number_format($users_2["t_h_50"],2,',',' '); ?></td>
<td align="right"><?php echo number_format($users_2["t_h_100"],2,',',' '); ?></td>
<td align="right"><?php $tt=$users_2["t_h_normales"]+($users_2["t_h_25"]*1.25)+($users_2["t_h_50"]*1.50);
echo number_format($tt,2,',',' ');?></td>
<? } else {?>
<td><?php echo $users_2["employe"];?></td>
<td align="right" bgcolor="#66CCCC"><?php echo number_format($users_2["t_h_normales"],2,',',' '); ?></td>
<td align="right" bgcolor="#66CCCC"><?php echo number_format($users_2["t_h_25"],2,',',' '); ?></td>
<td align="right" bgcolor="#66CCCC"><?php echo number_format($users_2["t_h_50"],2,',',' '); ?></td>
<td align="right" bgcolor="#66CCCC"><?php echo number_format($users_2["t_h_100"],2,',',' '); ?></td>
<td align="right" bgcolor="#66CCCC"><?php $tt=$users_2["t_h_normales"]+($users_2["t_h_25"]*1.25)+($users_2["t_h_50"]*1.50);
echo number_format($tt,2,',',' ');?></td>

<?php } ?>
<?php } ?>

</table>



<p style="text-align:center">

</body>

</html>