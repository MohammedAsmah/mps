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

$sql="SELECT * FROM produits WHERE produit = '".$q."'";

$result = mysql_query($sql);

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";echo "<td>";
  ?>
  <table class="table2">
  <? 
  echo "<tr>";
  echo "<td> Prix Unit : " . number_format($row["prix"],2,',',' ') . "</td>";
  echo "</tr>";
   echo "<tr>";
  echo "<td> Conditionnement : " . $row["condit"] . "</td>";
  echo "</tr>";
 
  echo "</table>";
  echo "</td>";echo "</tr>";
  
  
  
  $prix_unit=number_format($row["prix"],2,',',' ');$condit=$row["condit"];$tp = $row["prix"]*$row["condit"];
  
  }

?>
<tr>
<table class="table2">
	
	<tr>
		<td>
			<iframe src="fiche_de_stock_article_facture.php?p=<? echo $q;?>" width="800" height="600" align="middle"></iframe>
		</td>
	</tr>
</table>

<?  
  
mysql_close($con);
?> 
