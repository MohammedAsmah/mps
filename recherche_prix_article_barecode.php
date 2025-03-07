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

$sql="SELECT * FROM produits WHERE barecode = '".$q."'";

$result = mysql_query($sql);

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row["produit"] . "</td><td>----</td>"."<td>" . number_format($row["prix_rechange"],2,',',' ') . "</td>";$prix=number_format($row["prix_rechange"],2,',',' ');
  echo "</tr>";
  }

mysql_close($con);
?> 
