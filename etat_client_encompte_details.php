<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();	$user_name=GetUserName();


		// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
			
	$date=$_GET['date'];$vendeur=$_GET['vendeur'];$client=$_GET['client'];
			$date1=$_GET['date1'];
		$sql  = "SELECT evaluation,date_e,client,sum(en_compte) as encompte,sum(net) as montant,sum(en_compte_avoir) as encompte_avoir ";
		$sql .= "FROM commandes where (en_compte<>0 or en_compte_avoir<>0) and client='$client' and vendeur='$vendeur' and date_e between '$date' and '$date1' group by id ORDER BY date_e;";
		$users = db_query($database_name, $sql);
			
		
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Evaluations"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "evaluation_client_encompte.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "Releve clients : $client"; ?></span>
<tr>

</tr>

<table class="table2">

<tr>
	
	<th><?php echo "Client";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "En compte/Client";?></th>
	<th><?php echo "En compte/Avoir";?></th>
	
</tr>

<?php 

$total_g=0;$total_en_compte=0;$total_en_compte_avoir=0;
while($users_ = fetch_array($users)) { ?><tr>
<? $commande=$users_["commande"];$bln=$users_["bl"];$bcn=$users_["bc"];$evaluation=$users_["evaluation"];$client=$users_["client"];$date_e=dateUsToFr($users_["date_e"]);
$vendeur=$users_["vendeur"];$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];
$remise2=$users_["remise_2"];$net=$users_["montant"];$id=$users_["id"];$en_compte=$users_["encompte"];$en_compte_avoir=$users_["encompte_avoir"]; $date_en=dateFrToUs($users_["date"]);$ev_pre=$users_["ev_pre"];
?>
<td><?php echo $users_["client"]." - ".$users_["evaluation"]; ?></td>
<td><?php echo $date_e; ?></td>

<td align="right"><?php $total_g=$total_g+$net;echo number_format($net,2,',',' '); ?></td>
<td align="right"><?php echo number_format($en_compte,2,',',' '); $total_en_compte=$total_en_compte+$en_compte;?></td>
<td align="right"><?php echo number_format($en_compte_avoir,2,',',' '); $total_en_compte_avoir=$total_en_compte_avoir+$en_compte_avoir;?></td>



<?php } ?>
<tr><td></td><td></td>
<td align="right"><?php echo number_format($total_g,2,',',' '); ?></td>
<td align="right"><?php echo number_format($total_en_compte,2,',',' '); ?></td>
<td align="right"><?php echo number_format($total_en_compte_avoir,2,',',' '); ?></td>
</tr>

</table>
<tr>
</tr>

<p style="text-align:center">

<? 


?>
</body>

</html>