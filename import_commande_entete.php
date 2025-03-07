	<a name="haut"></a>
	<?php
	// vérification sur la session authentification (la session est elle enregistrée ?)
	// ici les éventuelles actions en cas de réussite de la connexion
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

//recupere le nom du fichier indiqué par l'user
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
	<p align="center" >- Importation échouée -</p>
	<p align="center" ><B>Désolé, mais vous n'avez pas spécifié de chemin valide ...</B></p>
	<?php
  	exit(); 
	}
// declaration de la variable "cpt" qui permettra de conpter le nombre d'enregistrement réalisé
$cpt=0;
?>
<p align="center">- Importation Réussie - <?php echo $date_commande;?> </p>

			<p align="right"><a href="#bas">Bas de page</a></p>
			
<?php
$compteur=0;
// importation    
while (!feof($fp))
{
  $ligne = fgets($fp,4096);  
  
  if ($compteur==0){$compteur=$compteur+1;
  // on crée un tableau des élements séparés par des points virgule
  $liste = explode(";",$ligne); 
  // premier élément
  $liste[0] = ( isset($liste[0]) ) ? $liste[0] : Null;
  $liste[1] = ( isset($liste[1]) ) ? $liste[1] : Null;
  $liste[2] = ( isset($liste[2]) ) ? $liste[2] : Null;
  $liste[3] = ( isset($liste[3]) ) ? $liste[3] : Null;
  $liste[4] = ( isset($liste[4]) ) ? $liste[4] : Null;
  $liste[5] = ( isset($liste[5]) ) ? $liste[5] : Null;
  $liste[6] = ( isset($liste[6]) ) ? $liste[6] : Null;
	$champs0=$liste[0]; $champs_v="";$clt_v = explode("--",$champs0);$client=trim($clt_v[1]);$vendeur=trim($clt_v[0]);
	$champs1=$liste[1]; 
	$champs2=$liste[2];
    $champs3= $liste[3];
	$champs4=$liste[4]; 
	$champs5=$liste[5];
	$champs6=$liste[6];
	
	
	
	
	///*-
	
	// requete et insertion ligne par ligne 
		// champs1 id en general dc on affecte pas de valeur
		echo $client."/n";
		$sql  = "SELECT * ";
		$sql .= "FROM clients WHERE client = '$client' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$remise10 = $user_["remise10"];
		$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];$secteur = $user_["ville"];$type_remise = $user_["type_remise"];$escompte = $user_["escompte"];
		$remise10_v = $user_["remise10_v"];$remise2_v = $user_["remise2_v"];$remise3_v = $user_["remise3_v"];$escompte2 = $user_["escompte2"];$plafond = $user_["minimum"];
		if ($remise10_v==0){$remise10=0;}
		if ($remise2_v==0){$remise2=0;}
		if ($remise3_v==0){$remise3=0;}
		echo $remise10."/n";
		echo $remise2."/n";
		echo $remise3."/n";
		
		$dir=0;
		$result = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$dir = $row["commande"];
				$cde=$dir+1;$encours="encours";
		echo $cde;
		
		
		
		
		
		
		
		
		$query = "INSERT INTO commandes_clients (commande,date_e,evaluation,client,vendeur,remise_10,remise_2,remise_3)
		VALUES($cde,'$date_commande','$encours','$client','$vendeur','$remise10','$remise2','$remise3')";  
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
      				<td width="124">client importé:</td>
      				<td width="361"><?php echo $liste[0]."-". $liste[1]."-". $liste[2]."-". $liste[3]."-". $liste[4];?></td>
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


$compteur=0;
// importation    
while (!feof($fp2))
{
  $ligne = fgets($fp2,4096);  
 
	  // on crée un tableau des élements séparés par des points virgule
  $liste = explode(";",$ligne); 
  
echo $liste[0]."\n";echo $liste[1]."\n";echo $liste[2]."\n";echo $liste[3]."\n";echo $liste[4]."\n";

  // premier élément
  $liste[0] = ( isset($liste[0]) ) ? $liste[0] : Null;
  $liste[1] = ( isset($liste[1]) ) ? $liste[1] : Null;
  $liste[2] = ( isset($liste[2]) ) ? $liste[2] : Null;
  $liste[3] = ( isset($liste[3]) ) ? $liste[3] : Null;
  $liste[4] = ( isset($liste[4]) ) ? $liste[4] : Null;
  $liste[5] = ( isset($liste[5]) ) ? $liste[5] : Null;
  $liste[6] = ( isset($liste[6]) ) ? $liste[6] : Null;
	$champs0=$liste[0]; $champs_v="";
	
	
	function deleteSpecialChar($str) {
      
    // remplacer tous les caractères spéciaux par une chaîne vide
    $res = str_replace( array( '%', '@', '\'', ';', '<', '>' ), ' ', $str);
      
    return $res;
}
  
// Exemple d'une chaîne de caractères 
$str = $champs0; 
  
// Appeler la fonction
$champs0 = deleteSpecialChar($str); 
	
	
	
	
	$champs0=$liste[0]; echo $champs0." | ";
	$champs1=$liste[1]; echo $champs1." | ";
	$champs2=$liste[2]; echo $champs2." | ";
    $champs3= $liste[3];echo $champs3." | ";
	$champs4=$liste[4]; echo $champs4." | ";
	$champs5=$liste[5];echo $champs5." | ";
	$champs6=$liste[6];echo $champs6." | ";
	
	//
	
	
	
	
  	// pour eviter qu un champs "nom" du fichier soit vide
	echo $champs1;
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
      				<td width="124">Article importé :</td>
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
<br><br>Nombre de valeurs nouvellement enregistrées: <b><?php echo $cpt."   ".$compteur;?></b>.<br><br>

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

