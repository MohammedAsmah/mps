<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";$action="Recherche";$date="";$date1="";$du="";$au="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	


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
		<? require "body_cal.php";

	$client=$_GET['client'];$du=$_GET['du'];$au=$_GET['au'];$encours="encours";$vide="";
	$sql  = "SELECT * ";
	$sql .= "FROM commandes where date_e between '$du' and '$au' and evaluation<>'$vide' and evaluation<>'$encours' and escompte<>0  and client='$client' order by id;";

	$users = db_query($database_name, $sql);
	
	
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Palmares Clients $du au $au $client"; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Evaluation";?></th>
	<th><?php echo "Montant ";?></th>
	<th><?php echo "Mt Escompte";?></th>
	
</tr>

<?php $debit=0;$credit=0;$t=0;$s=0;$t=0;$net_avoir=0;
while($users_ = fetch_array($users)) { $total=$users_["total"];?><tr><td>
<? $date_e=dateUsToFr($users_["date_e"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$date_e </font>");?></td>
<td><? $eval=$users_["evaluation"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$eval </font>");?></td>
<td align="right"><?php $t=$t+$users_["net"];echo number_format($users_["net"],2,',',' ');$brut=$users_["net"]/((100-$users_["escompte"])/100);?></td>
<td align="right"><? $c=$c+($brut*$users_["escompte"]/100);echo number_format(($brut*$users_["escompte"]/100),2,',',' ');?></td>
<?php } ?>
<tr>
<td></td><td></td>
<td align="right"><?php echo number_format($t,2,',',' ');?></td>
<td align="right"><?php echo number_format($c,2,',',' ');?></td>
</tr>
</table>


<p style="text-align:center">

</body>

</html>