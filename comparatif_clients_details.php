<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
$valeur=3600;
set_time_limit($valeur);
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";$action="Recherche";$date="";$date1="";$du="";$au="";
	$t1=0;$t2=0;$t3=0;
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	$ville=$_GET['ville'];$vendeur=$_GET['vendeur'];$periode=$_GET['periode'];$du=$_GET['du'];$au=$_GET['au'];
	
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

<?  //$date=dateFrToUs($_POST['du']);$du=$_POST['date'];$date1=dateFrToUs($_POST['au']);$au=$_POST['date1'];
	$date=dateFrToUs($du);$date1=dateFrToUs($au);
	$du=$_POST['date'];$au=$_POST['date1'];$encours="encours";$t1=0;$t2=0;$t3=0;$t4=0;
	list($annee1,$mois1,$jour1) = explode('-', $date); 
	$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
	list($annee11,$mois11,$jour11) = explode('-', $date1); 
	$pau = mktime(0,0,0,$mois11,$jour11,$annee11); 
	$jour=date("d",$pdu);$mois=date("m",$pdu);$annee=date("Y",$pdu);
	$jour1=date("d",$pau);$mois1=date("m",$pau);$annee1=date("Y",$pau);
	$d1=$jour."/".$mois."/".$annee1;$d2=$jour1."/".$mois1."/".$annee1;
	$annee_1=$annee-1;$annee_2=$annee-2;$annee_3=$annee-3;$annee_0=$annee-0;
	$d1_exe_1=$annee_1."-".$mois."-".$jour;$d2_exe_1=$annee_1."-".$mois1."-".$jour1;
	$d1_exe_2=$annee_2."-".$mois."-".$jour;$d2_exe_2=$annee_2."-".$mois1."-".$jour1;?>
	
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Comparatif Clients  $jour/$mois  au  $jour1/$mois1 "; ?></span>

<p style="text-align:center">
	<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo $annee_0;?></th>
	<th><?php echo $annee_1;?></th>
	<th><?php echo $annee_2;?></th>
	<th><?php echo $annee_3;?></th>
</tr>

	
	
	<? 
	
	
	$sql  = "SELECT client,ville,vendeur,sum(exe_encours) As total_exe_encours, sum(exe_1) As total_exe_1,sum(exe_2) As total_exe_2,sum(exe_3) As total_exe_3 ";
	$sql .= "FROM comparatif_clients where ville='$ville' GROUP BY client order by total_exe_encours DESC;";
	//$sql .= "FROM comparatif_clients where ville='$ville' and vendeur='$vendeur' GROUP BY client;";
	$userse = db_query($database_name, $sql);
	while($users_e = fetch_array($userse)) { $ville=$users_e["ville"];$n="<a href=\"comparatif_clients_details.php?ville=$ville\">$ville</a>";?><tr>
	
	<td align="left"><?php echo $users_e["client"];;?></td>
	<td align="right"><?php echo number_format($users_e["total_exe_encours"],2,',',' ');$t1=$t1+$users_e["total_exe_encours"];?></td>
	<td align="right"><?php echo number_format($users_e["total_exe_1"],2,',',' ');$t2=$t2+$users_e["total_exe_1"];?></td>
	<td align="right"><?php echo number_format($users_e["total_exe_2"],2,',',' ');$t3=$t3+$users_e["total_exe_2"];?></td>
	<td align="right"><?php echo number_format($users_e["total_exe_3"],2,',',' ');$t4=$t4+$users_e["total_exe_3"];?></td>
	<?php } ?>
	
	<tr><td align="right"><?php echo "Totaux : ";?></td>
	<td align="right"><?php echo number_format($t1,2,',',' ');?></td>
	<td align="right"><?php echo number_format($t2,2,',',' ');?></td>
	<td align="right"><?php echo number_format($t3,2,',',' ');?></td>
	<td align="right"><?php echo number_format($t4,2,',',' ');?></td>



<p style="text-align:center">

</body>

</html>