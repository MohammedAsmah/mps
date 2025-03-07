
<?


$q=$_GET["q"];

$con = mysql_connect('localhost', 'root', '');
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("mps2009", $con);

$sql="SELECT * FROM rs_data_fournisseurs where c1 = '$q' or c2 = '$q' or c3 = '$q' or c4 = '$q' or c5 = '$q' or c6 = '$q' ;";

$result = mysql_query($sql);

echo "<table border='1'>
<tr>"?>
    <th><?php echo "Nom";?></th>
	<th><?php echo "Ville";?></th>
	<th><?php echo "Tel";?></th>
	<th><?php echo "Fax";?></th>
	</tr>
<?
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";$frs=$row['last_name'];
  echo "<td><a href=\"getfrsarticle1.php?famille=$q&frs=$frs\">$frs</a></td>";
  echo "<td>" . $row['ville'] . "</td>"; 
  echo "<td>" . $row['tel'] . "</td>";
  echo "<td>" . $row['fax'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysql_close($con);
?> 
