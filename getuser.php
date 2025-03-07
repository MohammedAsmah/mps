<?php
$q=$_GET["q"];

$con = mysql_connect('localhost', 'root', '');
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("mps2009", $con);

$sql="SELECT * FROM clients WHERE client = '".$q."'";

$result = mysql_query($sql);

echo "<table border='1'>
<tr>
<th>Firstname</th>
<th>Lastname</th>
<th>Age</th>
<th>Hometown</th>
<th>Job</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['client'] . "</td>";
  echo "<td>" . $row['vendeur'] . "</td>";
  echo "<td>" . $row['remise10'] . "</td>";
  echo "<td>" . $row['remise2'] . "</td>";
  echo "<td>" . $row['remise3'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysql_close($con);
?> 