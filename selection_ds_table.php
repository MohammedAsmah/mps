<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Document sans titre</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php 

  echo '<select size=1 name="cat">'."\n"; 
  echo '<option value="-1">Choisir un résultat<option>'."\n"; 
   
  // Récupération des informations triées par ordre alphabétique 
  $sql = "SELECT valeur, texte FROM ma_table ORDER BY texte"; 
  $ReqLog = mysql_query($sql, $connexion); 
   
  while ($resultat = mysql_fetch_row($ReqLog)) { 
    echo '<option value="'.$resultat[0].'">'.$resultat[1]; 
    echo '</option>'."\n"; 
  } 
   
  echo '</select>'."\n"; 

?> 


<?php 

// diffirences entre deux dates

//pour MySQL version 4.1.1 ou supérieur 
$requete1 = mysql_query('SELECT DATEDIFF(date1,date2) FROM table'); 

//pour MySQL inférieur à la version 4.1.1 
$requete2 = mysql_query('SELECT TO_DAYS(date1) - TO_DAYS(date2) FROM table'); 

//Autre utilisation 
//Sélectionner toutes les lignes dont la colonne date1 représente une date de moins de 30 jours 
$requete2 = mysql_query('SELECT champs1 FROM table WHERE TO_DAYS(NOW()) - TO_DAYS(date1) <= 30'); 


// tableau à partir de mysql

<?php 

function table2html($table , $start , $numRec){ 
// La connexion au serveur et le tableau se fait avant l'appel de la fonction 
   
   
// Création de la requête SQL 
$query = "SELECT * FROM $table"; 
   
if (isset($start) AND isset($numRec)) 
{ $query .= " LIMIT $start, $numRec"; } 
   
// C'est une fonction globale et on ne connaît pas a priori sa structure! 
   
// Execute la requête 
$mysqlResult = mysql_query($query); 
   
// Détermine la structure du tableau 
$fields = mysql_num_fields($mysqlResult); 
$totalLen = 0; 
   
// Construction de vecteurs avec les noms et la longueur des champs 
for ($i = 0; $i < $fields; $i++) { 
$tableN[$i] = mysql_field_name($mysqlResult, $i); 
$tableL[$i] = mysql_field_len($mysqlResult, $i); 
$totalLen = $totalLen + $tableL[$i]; 
} 
   
// Ajout de la largeur des colonnes en % pour le tableau en HTML à afficher. 
$som = 0; 
for ($i = 0; $i < $fields-1; $i++) { 
$tableP[$i] = intval($tableL[$i]/$totalLen*100); 
$som = $som + $tableP[$i]; 
} 
// De cette façon je m'assure que la longueur totale du tableau est 100% 
$tableP[$fields-1] = 100 - $som; 
   
// Début de la construction du tableau HTML 
$htmlTable = ""; 
$htmlTable .= "<TABLE width=100% border=1>"; 
   
// Ajout de l'entête du tableau 
$htmlTable .= "<TR>"; 
for ($i = 0; $i < $fields; $i++) { 
$htmlTable .= "<TD width=$tableP[$i]% bgcolor=\"#CCFFCC\" 
align=center><B>$tableN[$i]</B></TD>"; 
} 
$htmlTable .= "</TD>"; 
   
// Maitenant le vrai boulot: on construit le tableau! 
$rows = mysql_num_rows($mysqlResult); 
for ($j = 0; $j < $rows; $j++) { 
$htmlTable .= "<TR>"; 
for ($i = 0; $i < $fields; $i++) { 
$htmlTable .= "<TD width=$tableP[$i]%>"; 
$htmlTable .= mysql_result($mysqlResult, $j, $i); 
$htmlTable .= "</TD>"; 
} 
$htmlTable .= "</TR>"; 
} 
   
// Et le tableau HTML est créé! 
$htmlTable .= "</TABLE>"; 
   
return $htmlTable; 
   
/* Exemple d'appel: 
   
$server = ""; // L'adresse du serveur ici 
$user = ""; // Login 
$pass = ""; // Mot de passe 
$dbb = ""; // Le nom de la BD 
$table = ""; // Le nom du tableau BD 
   
$link = mysql_connect($server, $user, $pass) or die("La connexion au serveur 
n'a pas réussi!"); 
@mysql_select_db($dbb, $link) or die("La connexion à la base de données n'a pas 
réussi!"); 
   
print(table2html($table, 0, 30)); // Par exemple 
mysql_close($link); 
   
   
*/ 
} 
?> 

// lecture fichier text
<?php 

$filename = "nom_fichier.txt"; 
$fs = filesize($filename); 
$fp = fopen($filename, "r"); 

while (! feof($fp) ) 
  { 
  $source = fread($fp,$fs); 
  echo "$source<br>"; 
  } 

?>    


// afficher sur n clone le contenu d'une table

<?php 
//--- une requête ---// 
$truc = "blabla"; 
$req = "select champ1,champ2 from $table where bazar='$truc' order by champ1 Asc"; 
   
//--- Résultat ---// 
$res = mysql_query($req); 
while($data = mysql_fetch_assoc($res)) 
{ 
$tablo[]=$data; //--- mettre les données dans un tableau 
} 
$nbcol=2; //--- détermine le nombre de colonnes 

echo '<table>'; 
$nb=count($tablo); 
for($i=0;$i<$nb;$i++){ 
   
//--- les valeurs que l'on souhaite afficher 
$valeur1=$tablo[$i]['champ1']; 
$valeur2=$tablo[$i]['champ2']; 

if($i%$nbcol==0) 
echo '<tr>'; 
echo '<td>',$valeur1,'<br/>',$valeur2,'</td>'; 

if($i%$nbcol==($nbcol-1)) 
echo '</tr>'; 

} 
echo '</table>'; 

?> 

?> 

</body>
</html>
