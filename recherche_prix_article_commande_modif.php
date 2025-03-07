<?php
	
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();	$user_name=GetUserName();



$q=$_GET["q"];

$con = mysql_connect('datamjpmps.mysql.db', 'datamjpmps', 'Marwane06');
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("datamjpmps", $con);


//entrees
			$sql1  = "SELECT * ";
			$sql1 .= "FROM produits where produit='$q' order BY produit;";
			$users11 = mysql_query($sql1);while($users1 = mysql_fetch_array($users11))
			{
			$condit = $users1["condit"];
			}
			

 
  echo "" . $condit;
 

mysql_close($con);
?> 
