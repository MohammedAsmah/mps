	<a name="haut"></a>
	<?php
	// v�rification sur la session authentification (la session est elle enregistr�e ?)
	// ici les �ventuelles actions en cas de r�ussite de la connexion
	 require_once('connexion.php'); 
	 require "config.php";
	require "connect_db.php";
	require "functions.php";
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

$date_commande=dateFrToUs($_REQUEST["date1"]);

// ouverture du fichier en lecture    
if ($fichier)
	{
	//ouverture du fichier temporaire 
	$fp = fopen ($_FILES["userfile"]["tmp_name"], "r"); 
	$fp2 = fopen ($_FILES["userfile"]["tmp_name"], "r"); 
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

$compteur=0;
// importation    
while (!feof($fp2))
{
  $ligne = fgets($fp2,4096);  
 
	  // on cr�e un tableau des �lements s�par�s par des points virgule
  $liste = explode(",",$ligne); 
 // premier �l�ment
  $liste[0] = ( isset($liste[0]) ) ? $liste[0] : Null;
  $liste[1] = ( isset($liste[1]) ) ? $liste[1] : Null;
  $liste[2] = ( isset($liste[2]) ) ? $liste[2] : Null;
  $liste[3] = ( isset($liste[3]) ) ? $liste[3] : Null;
  $liste[4] = ( isset($liste[4]) ) ? $liste[4] : Null;
  $liste[5] = ( isset($liste[5]) ) ? $liste[5] : Null;
  $liste[6] = ( isset($liste[6]) ) ? $liste[6] : Null;
	$champs0=$liste[0]; $champs_v="";
//echo $liste[0]."\n";echo $liste[1]."\n";echo $liste[2]."\n";echo $liste[3]."\n";echo $liste[4]."\n";

?>
<table width="505" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#eeeeee">
    			<tr>
      				<td width="124">Article import� :</td>
      				<td width="361"><?php echo $liste[0]."-". $liste[1]."-". $liste[2]."-". $liste[3]."-". $liste[4];?></td>
    			</tr>
			</table>
			<?

  
	
	
	function deleteSpecialChar($str) {
      
    // remplacer tous les caract�res sp�ciaux par une cha�ne vide
    $res = str_replace( array( '%', '@', '\'', ';', '<', '>' ), ' ', $str);
      
    return $res;
}
  
	
		
	//
	
		

	/*if ($champs1!='')
		{
		
		$cpt++; 
		
		$query = "INSERT INTO detail_commandes_clients (date,commande,produit,condit,quantite)
		VALUES('$date_commande','$cde','$champs0','$champs1','$champs2')";  
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
      				<td width="124">Article import� :</td>
      				<td width="361"><?php echo $liste[0]."-". $liste[1]."-". $liste[2]."-". $liste[3]."-". $liste[4];?></td>
    			</tr>
			</table>
			<?php
			}
		}*/
		
 
}
// fermeture du fichier
fclose($fp2);
//on supprime la derniere car elle est vide
/*$sql=mysql_query("DELETE FROM report_06 WHERE champs1=''"); */





//==================
// FIN
//==================
?>
<br><br>Nombre de valeurs nouvellement enregistr�es: <b><?php echo $cpt."   ".$compteur;?></b>.<br><br>

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

