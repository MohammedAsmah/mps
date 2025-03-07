<?php
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	
	// recherche ville
	?>
	
	<?$d1="2014-01-01";$d2="2014-12-31";
	
	
	
	/*$i=0;$d="2014-01-01";$nbre=0;
	
	
	while ($i<=365)
	{
		$dateN1 = date('Y-m-d', strtotime("$d +$i day"));
		//echo "\n$dateN1\n";
		$i=$i+1;
		$sql  = "INSERT INTO jours_annee ( date,nbre_machines, nbre_postes ) VALUES ( ";
				$sql .= "'" . $dateN1 . "', ";
				$sql .= "'" . $nbre . "', ";
				$sql .= $nbre . ");";

				db_query($database_name, $sql);
	}
	

	*/
	
	
	
	
	
	
	
	
	
	
	
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Produits"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "fiche_de_stock_article.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
 </table>
<span style="font-size:24px"><?php echo "Nbre de Machines en Production par Jour "; ?></span>
<table class="table2">
<? ///////////////////


			$sql1  = "SELECT * ";
			$sql1 .= "FROM jours_annee where (date between '$d1' and '$d2' ) order by date;";
			$users11j = db_query($database_name, $sql1);
			while($users11_j = fetch_array($users11j)) { 
				$date=$users11_j["date"];

			$sql1  = "SELECT * ";$j=0;
			$sql1 .= "FROM entrees_stock_f where date ='$date' order by date;";
			$users11d = db_query($database_name, $sql1);
			while($users11_d = fetch_array($users11d)) { 
				$j=$j+1;
			
			}?>
			<tr>
			<td><?php echo dateUsToFr($date);  ?></td>
			<td><?php echo $j;  ?></td>
			<? }	
			
			
?>
</table>
<p style="text-align:center">

	
	<? ?>

</body>

</html>