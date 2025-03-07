	<a name="haut"></a>
	<?php
	// vérification sur la session authentification (la session est elle enregistrée ?)
	// ici les éventuelles actions en cas de réussite de la connexion
	require "config.php";
	require "connect_db.php";
	
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
  $liste[4] = ( isset($liste[4]) ) ? $liste[4] : Null;
  /*$liste[5] = ( isset($liste[5]) ) ? $liste[5] : Null;
  /*$liste[6] = ( isset($liste[6]) ) ? $liste[6] : Null;
  $liste[7] = ( isset($liste[7]) ) ? $liste[7] : Null;
  $liste[8] = ( isset($liste[8]) ) ? $liste[8] : Null;
  $liste[9] = ( isset($liste[9]) ) ? $liste[9] : Null;
  $liste[10] = ( isset($liste[10]) ) ? $liste[10] : Null;*/
	$champs0=$liste[0]; 
	$champs1=$liste[1]; 
	$champs2=$liste[2];
	$champs3=$liste[3]; 
	$champs4=$liste[4]; 
	
	
	// pour eviter qu un champs "nom" du fichier soit vide
	if ($champs0!='')
		{
		// nouvel ajout, compteur incrémenté
		$cpt++; 
		
				
		
		$query = "INSERT INTO detail_commandes_frs (id,champs1,produit,quantite,unite,prix_unit)
		VALUES('','$champs0','$champs1','$champs2','$champs3','$champs4')";  
  		
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



<p style="text-align:center">

</body>

</html>

