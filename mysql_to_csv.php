<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MySql to CSV script by www.erriko.it</title>
<style type="text/css">
body{
background:#dedede;
margin:0;
padding:0;
}
#wrapper{
width:100%;
}
#form{
margin-left:auto;
margin-right:auto;
margin-top:100px;
width:400px;
padding:20px;
background:#efefef;
border:2px solid #2e2e2e;
}
</style>
</head>
<body>
<div id="wrapper">
<div id="form">

<?php

 $host =  "mysql5-1.business"; // <-- inserisci qui l'indirizo ip di MySql
 $user =  "datamjpmps"; // <-- nome utente del database
 $pass =  "Marwane06"; // <-- password dell'utente
 $db = "datamjpmps"; // il database desiderato
 $table = $_POST['table']; // la tabella da esportare in .csv
 $file = $table; // il nome del file csv da generare
 
 $link = mysql_connect($host, $user, $pass) or die("Can not connect." . mysql_error()); /* usa i dati forniti per connetterti a MySql, se impossibile interrompi */
 
 mysql_select_db($db) or die("Can not connect."); // seleziona il db desiderato oppure interrompi
 
 $result = mysql_query("SHOW COLUMNS FROM ".$table."");
 $i = 0;
 if (mysql_num_rows($result) > 0) {
 while ($row = mysql_fetch_assoc($result)) {  
 $csv_output .= $row['Field']."; ";
 $i++;
 }
 }
 $csv_output .= "\n"; 
 
 $values = mysql_query("SELECT * FROM ".$table."");
 while ($rowr = mysql_fetch_row($values)) {
 for ($j=0;$j<$i;$j++) { 
 $csv_output .= $rowr[$j]."; ";
 }
 $csv_output .= "\n"; 
 }
 $filename = $file."_".date("d-m-Y_H-i",time()); // il nome del file sara' composto da quello scelto all'inizio e la data ed ora oggi
 /* setta le specifiche del file csv */
 header("Content-type: application/vnd.ms-excel");
 header("Content-disposition: csv" . date("Y-m-d") . ".csv");
 header( "Content-disposition: filename=".$filename.".csv");
 print $csv_output; // il file e' pronto e puo' essere scaricato
 exit;
 ?>
</div>
</div>
</body>
</html>
