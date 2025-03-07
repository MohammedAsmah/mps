	<a name="haut"></a>
	<?php
	// vérification sur la session authentification (la session est elle enregistrée ?)
	// ici les éventuelles actions en cas de réussite de la connexion
	require "config.php";
	require "connect_db.php";
	$sql = "TRUNCATE TABLE `pointeuse_mensuel`  ;";
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
			
<?php
// importation    
while (!feof($fp))
{
  $ligne = fgets($fp,4096);  
  // on crée un tableau des élements séparés par des points virgule
  $liste = explode(",",$ligne); 
  // premier élément
  $liste[0] = ( isset($liste[0]) ) ? $liste[0] : Null;
  $liste[1] = ( isset($liste[1]) ) ? $liste[1] : Null;
  $liste[2] = ( isset($liste[2]) ) ? $liste[2] : Null;
  /*$liste[3] = ( isset($liste[3]) ) ? $liste[3] : Null;
  $liste[4] = ( isset($liste[4]) ) ? $liste[4] : Null;
  $liste[5] = ( isset($liste[5]) ) ? $liste[5] : Null;
  $liste[6] = ( isset($liste[6]) ) ? $liste[6] : Null;
  $liste[7] = ( isset($liste[7]) ) ? $liste[7] : Null;
  $liste[8] = ( isset($liste[8]) ) ? $liste[8] : Null;
  $liste[9] = ( isset($liste[9]) ) ? $liste[9] : Null;
  $liste[10] = ( isset($liste[10]) ) ? $liste[10] : Null;*/
	$champs0=$liste[0]; 
	$champs1=$liste[1]; 
	list($d, $h) = explode(" ", $champs1);
	list($heures, $min,$seconde) = explode(":", $h);
	list($annee, $mois,$jours) = explode("-", $d);
	echo $d;
	$champs2=$liste[2];
	$ch=substr($champs2,0,5);$ch=Trim($ch);$non_inclus=0;$debut=$_POST['d'];
	/////////////////////////////////////////////////////////
	//if ($d=="2011/6/1" and $ch=="C/Out" and $heures<9){$non_inclus=1;}
	//if ($d=="2011/7/1" and $ch=="C/In" and $heures>1){$non_inclus=1;}
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
	if ($champs0!='')
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
		$query = "INSERT INTO pointeuse_mensuel (id,name,date,statut,audited,date_j,time_long,heures,minutes,non_inclus)
		VALUES('','$champs0','$champs1','$champs2','$ch','$d','$h','$heures','$min','$non_inclus')";  
  		
		$result= mysql_query($query);
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
			<table width="505" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#eeeeee">
    			<tr>
      				<td width="361"><?php echo $champs1;?></td>
    			</tr>
			</table>
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
<br><br>Nombre de valeurs nouvellement enregistrées: <b><?php echo $cpt;?></b>.<br><br>

<?php
	
