<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$date=$_GET['date'];$date1=$_GET['date1'];$vendeur=$_GET['vendeur'];
	$du=dateUsToFr($_GET['date']);$au=dateUsToFr($_GET['date1']);
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
	
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Palmares Vendeur : $vendeur $du au $au "; ?></span>

<p style="text-align:center">
<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo "C.A";?></th>
	
	
</tr>


	<? $sql  = "SELECT client,vendeur,date_e,sum(net) as total ";
	$sql .= "FROM commandes where vendeur='$vendeur' and date_e between '$date' and '$date1' group by client ORDER BY total DESC;";
	$users = db_query($database_name, $sql);
	$total_g=0;$t_net=0;
	while($users_ = fetch_array($users)) { 
		$client=$users_["client"];
		$vendeur=$users_["vendeur"];$net_c=$users_["total"];$t_net=$t_net+$net_c;
						
			 
			 ?> <tr><td><? echo $client."</td>";?>
			 <td align="right"><? echo number_format($users_["total"],2,',',' ')."</td>";?>
 			<?

 } ?>
<tr><TD align="right"><? echo "TOTAL";?></td>
<td align="right"><? echo number_format($t_net,2,',',' ')."</td>";?>
</tr></table>

 

<p style="text-align:center">

</body>

</html>