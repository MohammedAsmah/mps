<?php
$q=$_GET["q"];

$con = mysql_connect('localhost', 'root', '');
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("mps2009", $con);

$sql="SELECT * FROM tarifs_achats where produit = '$q' ;";

$result = mysql_query($sql);

echo "<table border='1'>
<tr>"?>
    <th><?php echo "Fournisseur";?></th>
	<th><?php echo "Prix unitaire";?></th>
	
</tr>
<?
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['fournisseur'] . "</td>";
  echo "<td>" . $row['prix_unitaire'] . "</td>"; 
  echo "</tr>";
  }
echo "</table>";

mysql_close($con);
?> 