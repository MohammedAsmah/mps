	<a name="haut"></a>
	<?php
	// v�rification sur la session authentification (la session est elle enregistr�e ?)
	// ici les �ventuelles actions en cas de r�ussite de la connexion
	require "config.php";
	require "connect_db.php";
	$sql = "TRUNCATE TABLE `paie_ouvriers`  ;";
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

//recupere le nom du fichier indiqu� par l'user
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
	<p align="center" >- Importation �chou�e -</p>
	<p align="center" ><B>D�sol�, mais vous n'avez pas sp�cifi� de chemin valide ...</B></p>
	<?php
  	exit(); 
	}
// declaration de la variable "cpt" qui permettra de conpter le nombre d'enregistrement r�alis�
$cpt=0;
?>
<p align="center">- Importation R�ussie -</p>

			<p align="right"><a href="#bas">Bas de page</a></p>
			
<?php
// importation    
while (!feof($fp))
{
  $ligne = fgets($fp,4096);  
  // on cr�e un tableau des �lements s�par�s par des points virgule
  $liste = explode(",",$ligne); 
  // premier �l�ment
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
	$champs2=$liste[2];
	
	
	if ($champs0!='')
		{
		// nouvel ajout, compteur incr�ment�
		$cpt++; 
		// requete et insertion ligne par ligne 
		// champs1 id en general dc on affecte pas de valeur
		/*$query = "INSERT INTO pointeuse (id,department,no,name,start_time,end_time,exception,audited,old_audited,time_long,valid_time,
		date,heures,minutes,lun,mar,mer,jeu,ven,sam,dim,lun_s,mar_s,mer_s,jeu_s,ven_s,sam_s,dim_s)
		VALUES('','$champs0','$champs1','$champs2','$start_time','$end_time','$champs5','$champs6','$champs7','$champs8','$champs9'
		,'$date','$heures','$minutes','$lun','$mar','$mer','$jeu','$ven','$sam','$dim','$lun_s','$mar_s','$mer_s','$jeu_s','$ven_s','$sam_s','$dim_s')";  
		*/
		$date="2011-06-01";$debut="2011-06-04";$m=50;$echeance="semaine";$motif="repport au 01/06/2011";
		$query = "INSERT INTO paie_ouvriers (id,semaine,du,au)
		VALUES('','$champs0','$champs1','$champs2')";  
  		
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
<br><br>Nombre de valeurs nouvellement enregistr�es: <b><?php echo $cpt;?></b>.<br><br>

<?php
	
