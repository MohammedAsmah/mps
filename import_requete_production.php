	<a name="haut"></a>
	<?php
	// v�rification sur la session authentification (la session est elle enregistr�e ?)
	// ici les �ventuelles actions en cas de r�ussite de la connexion
	 require_once('connexion.php'); 
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
  $string="\"";$type="production";
  //$liste = trim($string, $ligne);
  // premier �l�ment
  $liste[0] = ( isset($liste[0]) ) ? $liste[0] : Null;
  $liste[1] = ( isset($liste[1]) ) ? $liste[1] : Null;
  $liste[2] = ( isset($liste[2]) ) ? $liste[2] : Null;
  $liste[3] = ( isset($liste[3]) ) ? $liste[3] : Null;
	/*$champs0=$liste[0]; 
	$champs1=$liste[1]; 
	$champs2=$liste[2];
    $champs2=$liste[3];*/
	
	$champs0=$liste[0]; 
	$champs1=$liste[1]; 
	$champs2=$liste[2];
    $champs3=$liste[3];
	$champs0=trim($champs0,$string); 
	$champs1=trim($champs1,$string); 
	$champs2=trim($champs2,$string);
    $champs3=trim($champs3,$string);
	
	$type="production";
  	// pour eviter qu un champs "nom" du fichier soit vide
	if ($champs1!='')
		{
		// nouvel ajout, compteur incr�ment�
		$cpt++; 
		//if ($cpt >1){		
		/*$query = "INSERT INTO  entrees_stock (date, produit, depot_a,type )
		VALUES('','$champs0','$champs1','$champs2','$type')";  
  		$result= mysql_query($query);*/
		
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
      				<td width="124">Article import� :</td>
      				<td width="361"><?php echo $champs0."-". $champs1."-". $champs2."-". $champs3;?></td>
    			</tr>
			</table>
			<?php
			}
		//}
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
// pour cette fonction, voir mes sources, elle s y trouve.


//================================
// Recherche doublon sur champs2
//================================
//include ("fonction_doublon.php"); 
// recherche de doublon sur le champs "articulo"
//$doublon= "champs2";
//appel de la fonction doublon
//fonction_recherche_doublon($doublon);
	
	
?>

<a name="bas"></a>
<p align="right"><a href="#haut">Haut de page</a></p><br>

