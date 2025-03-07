<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
$action="Recherche";$date="";$date1="";$du="";$au="";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
		<? require "body_cal.php";?>
	
<?		

	$transport=$_GET['transport'];$date=$_GET['date'];$date1=$_GET['date1'];$du=dateUsToFr($_GET['date']);$au=dateUsToFr($_GET['date1']);
	
	
	$sql  = "SELECT transport,vendeur,date,matricule,service,sum(montant+jaouda) As total_net,sum(frais) As total_frais ";
	$sql .= "FROM registre_vendeurs where  (date between '$date' and '$date1') and montant<>0 and transport='$transport' GROUP BY service order by total_frais DESC ;";
	$users = db_query($database_name, $sql);
	
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Balance $transport $du au $au "; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	
	
	<th><?php echo "Destination";?></th>
	
	<th><?php echo "Chargement";?></th>
	<th><?php echo "Transport";?></th>
	<th><?php echo "%";?></th>
	
</tr>

<?php $debit=0;$credit=0;$tca=0;$s=0;$ttrans=0;
while($users_ = fetch_array($users)) { ?><tr>
<?php 

		
		$service = $users_["service"];$service1 = $users_["service"];
		$service = urlencode(str_replace("+", "%2B", $service));
		$vendeur = $users_["vendeur"];
		$date = $users_["date"];
		$total_net = $users_["total_net"];
		$total_frais = $users_["total_frais"];

?>

<?php echo "<td><a href=\"evaluations_transport_chargement.php?ville=$service&date=$date&date1=$date1\">$service1</a></td>";?></td>


<td align="right"><?php $tca=$tca+$users_["total_net"];echo number_format($users_["total_net"],2,',',' ');?></td>
<td align="right"><?php $ttrans=$ttrans+$users_["total_frais"];echo number_format($users_["total_frais"],2,',',' ');?></td>
<td align="right"><?php echo number_format($users_["total_frais"]/$users_["total_net"]*100,2,',',' ')."%";?></td>

<?php } ?>
<tr>
<td></td>
<td align="right"><?php echo number_format($tca,2,',',' ');?></td>
<td align="right"><?php echo number_format($ttrans,2,',',' ');?></td>
<td align="right"><?php echo number_format($ttrans/$tca*100,2,',',' ')."%";?></td>
</table>

<p style="text-align:center">

</body>

</html>