<html>
<head></head>
<body>
 
 
<h2>Account Statement</h2>
 
 
<table border="1" cellspacing="0" cellpadding="10">
 
 
<tr>
<td colspan="3"><b>PURCHASES</b></td>
</tr>
 
 
<tr>
<td>Date</td>
<td>Description</td>
<td>Amount</td>
</tr>
 
 
<?php
// database parameters
// get these via user input
$host = "localhost";
$user = "root";
$pass = "marwane06";
$db = "mps2008";


////////////////

function int2str($a){
	if ($a<0) return 'moins '.int2str(-$a);
	if ($a<17){
		switch ($a){
			case 0: return 'zero';
			case 1: return 'un';
			case 2: return 'deux';
			case 3: return 'trois';
			case 4: return 'quatre';
			case 5: return 'cinq';
			case 6: return 'six';
			case 7: return 'sept';
			case 8: return 'huit';
			case 9: return 'neuf';
			case 10: return 'dix';
			case 11: return 'onze';
			case 12: return 'douze';
			case 13: return 'treize';
			case 14: return 'quatorze';
			case 15: return 'quinze';
			case 16: return 'seize';
		}
	} else if ($a<20){
		return 'dix-'.int2str($a-10);
	} else if ($a<100){
		if ($a%10==0){
			switch ($a){
				case 20: return 'vingt';
				case 30: return 'trente';
				case 40: return 'quarante';
				case 50: return 'cinquante';
				case 60: return 'soixante';
				case 70: return 'soixante-dix';
				case 80: return 'quatre-vingt';
				case 90: return 'quatre-vingt-dix';
			}
		} else if ($a<70){
			return int2str($a-$a%10).' '.int2str($a%10);
		} else if ($a<80){
			return int2str(60).' '.int2str($a%20);
		} else{
			return int2str(80).' '.int2str($a%20);
		}
	} else if ($a==100){
		return 'cent';
	} else if ($a<200){
		return int2str(100).' '.int2str($a%100);
	} else if ($a<1000){
		return int2str((int)($a/100)).' '.int2str(100).' '.int2str($a%100);
	} else if ($a==1000){
		return 'mille';
	} else if ($a<2000){
		return int2str(1000).' '.int2str($a%1000).' ';
	} else if ($a<1000000){
		return int2str((int)($a/1000)).' '.int2str(1000).' '.int2str($a%1000);
	}  
	//on pourrait pousser pour aller plus loin, mais c'est sans interret pour ce projet, et pas interessant, c'est pas non plus compliqué...
}
 // et voilà ce que ca donne






 
 
 
// query database for purchases
$connection = mysql_connect($host, $user, $pass) or die ("Unable to connect!");
mysql_select_db($db) or die ("Unable to select database!"); $query = "SELECT client, date_f, montant FROM factures where montant<>0"; $result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
 
 
if(mysql_num_rows($result) > 0)
{
      // counter to record purchase totals
      $purchaseTotal = 0;
 
 
      // get the raw data (records)
      // iterate through result set
      // print transactions details
      while($row = mysql_fetch_object($result))
      {
                   echo "<tr>";
                     echo "<td>" . $row->date_f . "</td>";
                     echo "<td>" . $row->client . "</td>";
                     echo "<td align=right>" . sprintf("%01.2f", $row->montant) . "</td>";
					echo "<td>".int2str("$row->montant")."</td>";     
					 echo "</tr>";
 
 
                     // increment purchase counter
                    $purchaseTotal += $row->montant;
        }
     
}
?>
 
 
<tr>
<td colspan="2" align="right">Sub-Total of Purchases</td>
<td align="right"><? echo sprintf("%01.2f", $purchaseTotal); ?></td> </tr>
 
 
 
 
<?  
// close connection
mysql_close($connection);
?>
 
 
</table>
 
 
<p>
<hr>
<?php
// include class and create object
 
 
// obtain outstanding amount
// purchases less payments
// print the amount in words
?>
<hr>
 
 
</body>
</html>
