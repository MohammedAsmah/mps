<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$vendeur=$_GET['vendeur'];$date=$_GET['date'];$date1=$_GET['date1'];$du=dateUsToFr($_GET['date']);$au=dateUsToFr($_GET['date1']);

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
	
	$sql  = "SELECT id_registre,bondesortie,vendeur,client,net,date_e,solde,sum(net) As total_net,sum(solde) As total_solde ";
	$sql .= "FROM commandes where vendeur='$vendeur' and (date_e between '$date' and '$date1') and id_registre=0 GROUP BY bondesortie;";
	$users = db_query($database_name, $sql);
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Balance Evaluations $vendeur non sortie $du au $au "; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Net";?></th>
	<th><?php echo "Encaisse";?></th>
	<th><?php echo "Solde";?></th>
</tr>

<?php $debit=0;$credit=0;$t=0;$s=0;
while($users_ = fetch_array($users)) { ?><tr>
<?php $id_registre=$users_["id_registre"];$bon=$users_["bondesortie"];?>
<td><?php echo dateUsToFr($users_["date_e"]);?></td>
<td align="right"><?php $t=$t+$users_["total_net"];echo number_format($users_["total_net"],2,',',' ');?></td>
<td align="right"><?php $s=$s+$users_["total_solde"];echo number_format($users_["total_solde"],2,',',' ');?></td>
<td align="right"><?php echo number_format($users_["total_net"]-$users_["total_solde"],2,',',' ');?></td>


<?php } ?>
<tr><td></td><td align="right"><?php echo number_format($t,2,',',' ');?></td>
<td align="right"><?php echo number_format($s,2,',',' ');?></td>
<td align="right"><?php echo number_format($t-$s,2,',',' ');?></td>


</table>

<p style="text-align:center">

</body>

</html>