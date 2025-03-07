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
  echo "<td><h1>" . $row["produit"] . "</td>   X    <td>".$row["condit"]."</h1></td>";$photo=$row["image"];
  print("<img src=\"./$photo\" alt=\"\" style=\"width:250px;height:250px;\" border=\"1\">");
  echo "</tr>";
  echo "<tr><td><h1>" . $row["palette"] . " Paquet par Palette </h1></td>";
  }
  
  echo "<script>var playSound = (function(){var s,sounds = {},soundUrls = {laser: \"sound/error.mp3\"};
  for(s in soundUrls){sounds[s] = new Audio(soundUrls[s]);sounds[s].preload = 'auto';sounds[s].load();}
  return function(soundname){if(soundname in sounds){sounds[soundname].play();}};})();playSound('laser');</script>";


mysql_close($con);
?> 
