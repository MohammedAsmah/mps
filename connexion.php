
<?php
// paramètres de connexion
$hostname_smoby = "datamjpmps.mysql.db"; // nom de votre serveur
$database_smoby = "datamjpmps"; // nom de votre base de données
$username_smoby = "datamjpmps"; // nom d'utilisateur (root par défaut) !!! ATTENTION, en utilisant root, vos visiteurs on tout les droits sur la base
$password_smoby = "Marwane06"; // mot de passe (aucun par défaut mais il est conseillé d'en mettre un)
$db = mysql_connect($hostname_smoby, $username_smoby, $password_smoby) or trigger_error(mysql_error(),E_USER_ERROR); 


/*mysql_select_db($database_smoby,$db);
$query  = "SELECT * FROM rs_data_users ORDER BY login ;";
$result= mysql_query($query);

while($users_2 = mysql_fetch_array($result)) { 
	echo "<tr><td>".$users_2["login"]."</td>";
}*/










?>
