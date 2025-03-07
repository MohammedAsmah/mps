<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url

			$produit=$_GET['produit'];$date=$_GET['date'];$date1=$_GET['date1'];
			

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
	
	
<?			
	
	$sql  = "SELECT date,frs,produit,ref,type,sum(qte) As total_qte,sum(prix_achat) As total_prix ";$eti="eti";
	$sql .= "FROM achats_mat where type='$produit' and date between '$date' and '$date1' GROUP BY id order by date;";
	$users = db_query($database_name, $sql);
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Balance achats $produit "; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Produit";?></th>
	<th><?php echo "Qte";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Valeur";?></th>
	<th><?php echo "Frs";?></th>
	<th><?php echo "Reference";?></th>
</tr>

<?php $debit=0;$credit=0;$t=0;$q=0;
while($users_ = fetch_array($users)) { ?><tr>
<?php $dt=dateUsToFr($users_["date"]);?>
<td><?php echo $dt;?></td>
<td><?php echo $users_["produit"];?></td>
<td align="right"><?php echo $users_["total_qte"];$q=$q+$users_["total_qte"];?></td>
<td align="right"><?php echo $users_["total_prix"];?></td>
<td align="right"><?php $p=$users_["total_prix"]*$users_["total_qte"];$t=$t+($users_["total_prix"]*$users_["total_qte"]);
echo number_format($p,2,',',' ');
?></td>
<td><?php echo $users_["frs"];?></td>
<td align="center"><?php echo $users_["ref"];?></td>


<?php } ?>
<tr></tr>
<td></td><td></td><td align="right"><?php echo number_format($q,3,',',' ')?></td><td></td>
<td align="right"><?php echo number_format($t,2,',',' ')?></td>
</table>

<p style="text-align:center">

</body>

</html>