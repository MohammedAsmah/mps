	<a name="haut"></a>
	<?php
	// vérification sur la session authentification (la session est elle enregistrée ?)
	// ici les éventuelles actions en cas de réussite de la connexion
	require "config.php";
	require "connect_db.php";
	$sql = "TRUNCATE TABLE `pointeuse`  ;";
	db_query($database_name, $sql);

	 require_once('connexion.php');	 require_once('functions_dates.php'); 

 
//===========================================================
//
// Code de : Xavier Manzoni
// Email : kaptain_kavern_23@hotmail.com
// Date: 23 Novembre 2004
// Objectif :
//			Selection d'un fichier xls enregistre sous format 
// CSV (separateur ";") puis enregistrement dans la base.
//			Base: smoby
//			Table: bdd
//===========================================================

//=====================
// Initialisation
//=====================

mysql_select_db($database_smoby,$db);


//=========================
// Traitement des donnees
//=========================

//recupere le nom du fichier indiqué par l'user
$fichier=$_FILES["userfile"]["name"];

// ouverture du fichier en lecture    
if ($fichier)
	{
	//ouverture du fichier temporaire 
	$fp = fopen ($_FILES["userfile"]["tmp_name"], "r"); 
	}
else{ 
	// fichier inconnu 
	?>
	<p align="center" >- Importation échouée -</p>
	<p align="center" ><B>Désolé, mais vous n'avez pas spécifié de chemin valide ...</B></p>
	<?php
  	exit(); 
	}
// declaration de la variable "cpt" qui permettra de conpter le nombre d'enregistrement réalisé
$cpt=0;
?>
<p align="center">- Importation Réussie -</p>

			<p align="right"><a href="#bas">Bas de page</a></p>
			
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste pointage"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	

--></script>

</head>			
		
				
		<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Client"; ?></span>

<table class="table2">			
<?php
// importation    
$nt=0;
while (!feof($fp))
{
  $ligne = fgets($fp,4096);  
  // on crée un tableau des élements séparés par des points virgule
  $liste = explode(",",$ligne); 
  // premier élément
  $liste[0] = ( isset($liste[0]) ) ? $liste[0] : Null;
  $liste[1] = ( isset($liste[1]) ) ? $liste[1] : Null;
  $liste[2] = ( isset($liste[2]) ) ? $liste[2] : Null;
  $liste[3] = ( isset($liste[3]) ) ? $liste[3] : Null;
  /*$liste[4] = ( isset($liste[4]) ) ? $liste[4] : Null;
  $liste[5] = ( isset($liste[5]) ) ? $liste[5] : Null;
  $liste[6] = ( isset($liste[6]) ) ? $liste[6] : Null;
  $liste[7] = ( isset($liste[7]) ) ? $liste[7] : Null;
  $liste[8] = ( isset($liste[8]) ) ? $liste[8] : Null;
  $liste[9] = ( isset($liste[9]) ) ? $liste[9] : Null;
  $liste[10] = ( isset($liste[10]) ) ? $liste[10] : Null;*/
	$nom=$liste[0]; 
	$datefr=$liste[1]; $date_j=$liste[1]; 
	$heure=$liste[2]; $horaire=$liste[2]; 
	$type=$liste[3]; 
	
	list($heures, $min,$seconde) = explode(":", $horaire);
	list($annee, $mois,$jours) = explode("/", $datefr);
	
	$date = $annee."-".$mois."-".$jours;
	
	$ch=substr($type,0,3);$ch=Trim($ch);$non_inclus=0;$debut=$_POST['debut'];$fin=$_POST['fin'];
	/////////////////////////////////////////////////////////
	/*if ($d=="2011/6/11" and $ch=="C/Out" and $heures<9){$non_inclus=1;}
	if ($d=="2011/6/15" and $ch=="C/In" and $heures>1){$non_inclus=1;}*/
	
	if ($datefr==$_POST['debut'] and $ch=="SOR" and $heures<9){$non_inclus=1;}
	if ($datefr==$_POST['fin'] and $ch=="ENT" and $heures>1){$non_inclus=1;}
	
	/////////////////////////////////////////////////////////
	/*$champs3=$liste[3]; 
	$champs4=$liste[4]; 
	$champs5=$liste[5]; 
	$champs6=$liste[6]; 
	$champs7=$liste[7];
	$champs8=$liste[8]; 
	$champs9=$liste[9]; 
	$champs10=$liste[10];
	 $start_time=$champs3.":00";$end_time=$champs4.":00";	 $time_long=$champs8.":00";
	 $valid_time=$champs9.":00";

	$date=dateFrToUs($champs10);$h=0;$m=0;$s=0;
	list($annee1,$mois1,$jour1) = explode('-', $date); 
	$d = mktime(0,0,0,$mois1,$jour1,$annee1);

	list($h,$m,$s) = explode(':', $valid_time);
	if ($m>=15){$heures=$h+($m/60);$minute=0;}else{$heures=$h;$minutes=0;}
	
	
	$nom_jour=date("D",$d);
	$lun=0;$mar=0;$mer=0;$jeu=0;$ven=0;$sam=0;$dim=0;
	$lun_s=0;$mar_s=0;$mer_s=0;$jeu_s=0;$ven_s=0;$sam_s=0;$dim_s=0;

	if ($nom_jour=="Mon"){if ($heures>=9){$lun_s=$heures-8;$lun=$heures-$lun_s;}else{$lun_s=0;$lun=$heures;}}
	if ($nom_jour=="Tue"){if ($heures>=9){$mar_s=$heures-8;$mar=$heures-$mar_s;}else{$mar_s=0;$mar=$heures;}}
	if ($nom_jour=="Wed"){if ($heures>=9){$mer_s=$heures-8;$mer=$heures-$mer_s;}else{$mer_s=0;$mer=$heures;}}
	if ($nom_jour=="Thu"){if ($heures>=9){$jeu_s=$heures-8;$jeu=$heures-$jeu_s;}else{$jeu_s=0;$jeu=$heures;}}
	if ($nom_jour=="Fri"){if ($heures>=9){$ven_s=$heures-8;$ven=$heures-$ven_s;}else{$ven_s=0;$ven=$heures;}}
	if ($nom_jour=="Sat"){if ($heures>=5){$sam_s=$heures-4;$sam=$heures-$sam_s;}else{$sam_s=0;$sam=$heures;}}
	if ($nom_jour=="Sun"){if ($heures>=9){$dim_s=$heures-8;$dim=$heures-$dim_s;}else{$dim_s=0;$dim=$heures;}}
  	*/
	// pour eviter qu un champs "nom" du fichier soit vide
	
	
	
	if ($nom!='')
		{
		// nouvel ajout, compteur incrémenté
		$cpt++; 
		// requete et insertion ligne par ligne 
		// champs1 id en general dc on affecte pas de valeur
		/*$query = "INSERT INTO pointeuse (id,department,no,name,start_time,end_time,exception,audited,old_audited,time_long,valid_time,
		date,heures,minutes,lun,mar,mer,jeu,ven,sam,dim,lun_s,mar_s,mer_s,jeu_s,ven_s,sam_s,dim_s)
		VALUES('','$champs0','$champs1','$champs2','$start_time','$end_time','$champs5','$champs6','$champs7','$champs8','$champs9'
		,'$date','$heures','$minutes','$lun','$mar','$mer','$jeu','$ven','$sam','$dim','$lun_s','$mar_s','$mer_s','$jeu_s','$ven_s','$sam_s','$dim_s')";  
		*/
		
		$datep=dateFrToUs($date_j);
		$query = "INSERT INTO pointeuse (id,name,statut,date,horaire,non_inclus)
		VALUES('','$nom','$ch','$datep','$horaire','$non_inclus')";  
  		
		$result= mysql_query($query);
  		
		$sql  = "SELECT * ";
		$sql .= "FROM employes where employe='$nom' and statut=0 ORDER BY employe ;";
		$users2e = db_query($database_name, $sql);$users_2e = fetch_array($users2e);
		
		?>
<?
		
		$name=$users_2e["employe"];if($name==""){$nt=$nt+1;}
		
		
		echo "<tr><td>".$nom."</td><td>".$date_j."</td><td>".$horaire."</td><td>".$type."</td></tr>";
		
		
		
		if (mysql_error())
			{
			?>
			<p align="center" ><B>ERREUR DE REQUETE SUR LA BASE.</B></p>
			<?php 
			fclose($fp);
			exit(); 
  			}
		else
			{
			?>
			
			<?php
			}
		}
}
// fermeture du fichier
fclose($fp);
//on supprime la derniere car elle est vide
/*$sql=mysql_query("DELETE FROM report_06 WHERE champs1=''"); */

//==================
// FIN
//==================
?>


<?php
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

<span style="font-size:24px"><?php echo "Etat Pointage "; ?></span>





<table class="table2">



<?php 

$date2=0;$date1=0;
function date_to_timestamp ($date) {
    return preg_match('/^\s*(\d\d\d\d)-(\d\d)-(\d\d)\s*(\d\d):(\d\d):(\d\d)/', $date, $m)
           ?  mktime($m[4], $m[5], $m[6], $m[2], $m[3], $m[1])
           : 0;
}

/*function date_diff ($date_recent, $date_old) {
   return date_to_timestamp($date_recent) - date_to_timestamp($date_old);
}*/

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


		/* if ($s1=="C/In")
			{$in=$in+1;$date_in=strtotime($users_["date"]);
			$entree=$heures.":".$min;$in_s=8;$avance_min=0;

			if ($poste=="service" and $name<>"SEMHARI MOHAMED")
				{
				$in_s=6;
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
		 if ($s1=="ENT")
			{$in=$in+1;$date_in=strtotime($users_["date"]);
			$entree=$heures.":".$min;$in_s=8;$avance_min=0;

			if ($poste=="service" and $name<>"SEMHARI MOHAMED")
				{
				$in_s=8;
				if ($heures<$in_s)
{$avance_min=60-$min;$c_in=$heures;$date1 = mktime($heures,$min,$seconde,$mois,$jours,$annee);}
else {$in_m1=7;$in_m2=14;$in_m3=19;$c_in=$heures;$date1 = mktime($heures,$min,$seconde,$mois,$jours,$annee);}
}

			if ($poste=="machine" and $employe<>"SEMHARI MOHAMED"){$in_s=6;$in_m1=6;$in_m2=14;$in_m3=19;
if ($heures<$in_m1 or ($heures>12 and $heures<$in_m2) or ($heures>16 and $heures<$in_m3))
{$avance_min=60-$min;$c_in=$heures;$date1 = mktime($heures,$min,$seconde,$mois,$jours,$annee);}
else
{$in_m1=7;$in_m2=14;$in_m3=19;$c_in=$heures;$date1 = mktime($heures,$min,$seconde,$mois,$jours,$annee);}
}
}
		//////

		if ($s2=="SOR")
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

		if ($s1=="ENT")
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

		if ($s2=="Sor") 
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
			/*
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
			
			$sql .= "WHERE valide=0 and id = " . $id . ";";
			db_query($database_name, $sql);*/
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



<? /* $sql  = "SELECT * ";$t_p=0;
	$sql .= "FROM pointeuse group by name ORDER BY id;";
	$users_c = db_query($database_name, $sql);
	while($users_cc = fetch_array($users_c)) {
	$t_p=$t_p+1;
	}
	$sql  = "SELECT * ";$t_s=0;
	$sql .= "FROM employes group by employe ORDER BY id;";
	$users_ce = db_query($database_name, $sql);
	while($users_cce = fetch_array($users_ce)) {
	$t_s=$t_s+1;
	}*/
?>
<tr><td><? echo "Non trouves : ".$nt;?></td></tr>




</table>



<p style="text-align:center">

</body>

</html>

