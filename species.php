<?
header('Content-type: text/html; charset=iso-8859-1');   
2   
3 $mysql_db = @mysql_connect("localhost", "root", "");   
4 @mysql_select_db("robloche");   
5   
6 $query  = "SELECT `Species` FROM `Animals` WHERE `Family` = '".$_POST["family"]."'";   
7 $query .= " ORDER BY `Species`";   
8 $result = @tjs_query($query);   
9   
10 echo 'var o = null;';   
11 echo 'var s = document.forms["'.$_POST["form"].'"].elements["'.$_POST["select"].'"];';   
12 echo 's.options.length = 0;';   
13 while($r = mysql_fetch_array($result))   
14     echo 's.options[s.options.length] = new Option("'.$r["Species"].'");';   
15   
16 @mysql_close($mysql_db);   
?>

