<?php
$famille=$_GET["famille"];$frs=$_GET["frs"];

$con = mysql_connect('localhost', 'root', '');
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("mps2009", $con);

$sql="SELECT * FROM tarifs_achats where fournisseur='$frs' and famille = '$famille' ;";

$result = mysql_query($sql);

echo "<table border='1'>
<tr>"?>
    <th><?php echo "Article";?></th>
	<th><?php echo "Prix unitaire";?></th>
	
</tr>
<?
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['produit'] . "</td>";
  echo "<td>" . $row['prix_unitaire'] . "</td>"; 
  echo "</tr>";
  }
echo "</table>";

mysql_close($con);
?> 