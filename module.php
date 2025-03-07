<!--  ******************************************************************************************
************************************************************************************************
****     Le script PHP et le Javascript pour le clique droit et la Div qui s'affiche au 	****
****	 clique droit est entièrement de moi: Xavier Langlois (Caen,France)					****
****     E-mail: xavier.langlois@gmail.com													****
****     Site perso: http://xl714.free.fr													****
****     Ca serait sympa de me laisser un message si mon script vous apporte quelque chose	****
****     Et de laisser cette entête si vous mettez ce script en ligne.						****
****																						****
****	Le script pour transformer la simple liste en menu déroulant vient de:				****
****	http://www.javascriptfr.com/code.aspx?ID=21208  par 		Michel Deboom			****										****					
************************************************************************************************
*********************************************************************************************-->
<?php
function ConnectDB(){

//.....PAR ICI LES MODIFS.....PAR ICI LES MODIFS.....PAR ICI LES MODIFS.....PAR ICI LES MODIFS.....

	//Entrer ci dessous les infos nécessaires pour la connection à votre base de données
	//Ici par exemple en local avec EasyPHP avec une base de données s'appelant "madb"
	$host = "localhost"; //ou "sql.free.fr" pour une base se trouvant sur le server de free.
	$login = "root";
	$password = "";
	$base = "mps2008";

	$db = @mysql_connect($host,$login,$password) or die ("Connexion au serveur impossible.<br><a href=\"javascript:history.go(-1)\">BACK</a>");
	mysql_select_db($base);
	return $db;
}
function url_valide($url) 
{   $message = "";
	$len = strlen($url);
    $cmp_h = strcmp(substr($url,0,7),"http://");
    $cmp_n = strcmp(substr($url,0,7),"news://");
   	$cmp_f = strcmp(substr($url,0,6),"ftp://");
	if ($len < 10 || ($cmp_h != 0 && $cmp_n != 0 && $cmp_f != 0) )
	{	$message = "Url non valide ! Elle doit commencer par http:// (ou news:// ou encore ftp://)";
	}
    if ($message != "") 
	{	$message .= "<br><br>\n";
      	$message .= "<a href=\"javascript:history.go(-1);\">Retour au formulaire</a>\n";
      	die ($message);
    } 
	else 
	{   global $test_url;
      	if ($test_url && substr($url,0,7) == "http://") 
		{	$errno = 0;
			$errstr = "";    
		} 
    	return 1;
	} 
}
?>