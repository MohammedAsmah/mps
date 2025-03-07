<?php

$host="mysql5-1.business"; // Host name
$username="datamjpmps"; // Mysql username
$password="Marwane06"; // Mysql password
$db_name="datamjpmps"; // Database name


//Connect to server and select database.
mysql_connect("$host", "$username", "$password")or die("cannot connect to server");
mysql_select_db("$db_name")or die("cannot select DB");

?>