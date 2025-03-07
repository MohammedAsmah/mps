<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$du1=date("d/m/Y");$date=date("Y-m-d");$fin_exe="2010-12-31";$t=0;$type="provisions";
	$sql  = "SELECT id,designation,sum(montant_echeance) as t_m,date_echeance ";
	$sql .= "FROM echeances_credits where type='$type' and date_echeance>='$date' and date_echeance<='$fin_exe' group by id order BY date_echeance;";
	$users = db_query($database_name, $sql);
while($users_ = fetch_array($users)) { 
	
			$date_echeance=$users_["date_echeance"];$id=$users_["id"];
			list($annee1,$mois1,$jour1) = explode('-', $date_echeance); 
			$date = mktime(0,0,0,$mois1,$jour1,$annee1); 
			$mois=date("M",$date);
				if ($mois=="May"){$mois1="MAI";$mois_v=5;}
				if ($mois=="Jun"){$mois1="JUIN";$mois_v=6;}
				if ($mois=="Jul"){$mois1="JUIL";$mois_v=7;}
				if ($mois=="Aug"){$mois1="AOUT";$mois_v=8;}
				if ($mois=="Sep"){$mois1="SEP";$mois_v=9;}
				if ($mois=="Oct"){$mois1="OCT";$mois_v=10;}
				if ($mois=="Nov"){$mois1="NOV";$mois_v=11;}
				if ($mois=="Dec"){$mois1="DEC";$mois_v=12;}
				if ($mois=="Jan"){$mois1="JAN";$mois_v=1;}
				if ($mois=="Feb"){$mois1="FEV";$mois_v=2;}
				if ($mois=="Mar"){$mois1="MARS";$mois_v=3;}
				if ($mois=="Apr"){$mois1="AVRIL";$mois_v=4;}
			$sql = "UPDATE echeances_credits SET mois = '$mois_v' WHERE id = $id ";
			db_query($database_name, $sql);
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
	
<table class="table2">
<tr><td><? $j=date("d/m/Y H:i:s");echo "Echeancier Edite le : $j ";?></td></tr>
<tr>
	<th><?php echo "Echeance";?></th>
	<th><?php echo "Designation";?></th>
	<th><?php echo "Montant";?></th>
</tr>

</table>
	
<?	

		
	$te=0;
	for ($compteur=1;$compteur<=12;$compteur++)
	{
				if ($compteur==5){$mois1="MAI";$mois_v=5;}
				if ($compteur==6){$mois1="JUIN";$mois_v=6;}
				if ($compteur==7){$mois1="JUILLET";$mois_v=7;}
				if ($compteur==8){$mois1="AOUT";$mois_v=8;}
				if ($compteur==9){$mois1="SEPTEMBRE";$mois_v=9;}
				if ($compteur==10){$mois1="OCTOBRE";$mois_v=10;}
				if ($compteur==11){$mois1="NOVEMBRE";$mois_v=11;}
				if ($compteur==12){$mois1="DECEMBRE";$mois_v=12;}
				if ($compteur==1){$mois1="JANVIER";$mois_v=1;}
				if ($compteur==2){$mois1="FEVRIER";$mois_v=2;}
				if ($compteur==3){$mois1="MARS";$mois_v=3;}
				if ($compteur==4){$mois1="AVRIL";$mois_v=4;}

	$du1=date("d/m/Y");$date=date("Y-m-d");$fin_exe="2010-12-31";$t=0;$tt=0;
	$sql  = "SELECT id,designation,sum(montant_echeance) as t_m,date_echeance ";
	$sql .= "FROM echeances_credits where type='$type' and mois=$compteur and date_echeance>'$date' and date_echeance<='$fin_exe' group by id order BY date_echeance;";
	$users1 = db_query($database_name, $sql);
	while($users_1 = fetch_array($users1)) { 
	$tt=$tt+$users_1["t_m"];}
	if ($tt>0){
	
	
	$sql  = "SELECT id,designation,sum(montant_echeance) as t_m,date_echeance ";
	$sql .= "FROM echeances_credits where type='$type' and mois=$compteur and date_echeance>'$date' and date_echeance<='$fin_exe' group by id order BY date_echeance;";
	$users = db_query($database_name, $sql);
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>


<p style="text-align:center">



<table class="table2">
<tr><td bgcolor="#66FFFF"><? echo "Echeancier : $mois1";?></td><td bgcolor="#66FFFF"></td><td bgcolor="#66FFFF"></td></tr>

<?php $debit=0;$credit=0;
while($users_ = fetch_array($users)) { ?>
<?php 		$date_echeance=$users_["date_echeance"];
			list($annee1,$mois1,$jour1) = explode('-', $date_echeance); 
			$date = mktime(0,0,0,$mois1,$jour1,$annee1); 
			$mois=date("M",$date);
				if ($mois=="May"){$mois1="MAI";$mois_v=5;}
				if ($mois=="Jun"){$mois1="JUIN";$mois_v=6;}
				if ($mois=="Jul"){$mois1="JUIL";$mois_v=7;}
				if ($mois=="Aug"){$mois1="AOUT";$mois_v=8;}
				if ($mois=="Sep"){$mois1="SEP";$mois_v=9;}
				if ($mois=="Oct"){$mois1="OCT";$mois_v=10;}
				if ($mois=="Nov"){$mois1="NOV";$mois_v=11;}
				if ($mois=="Dec"){$mois1="DEC";$mois_v=12;}
				if ($mois=="Jan"){$mois1="JAN";$mois_v=1;}
				if ($mois=="Feb"){$mois1="FEV";$mois_v=2;}
				if ($mois=="Mar"){$mois1="MARS";$mois_v=3;}
				if ($mois=="Apr"){$mois1="AVRIL";$mois_v=4;}?>
<tr><td><? echo dateUsToFr($date_echeance);?></td>
<td><? echo $users_["designation"];?></td>
<td align="right"><?php $t=$t+$users_["t_m"];$te=$te+$users_["t_m"];echo number_format($users_["t_m"],2,',',' ');?></td>
<?php } ?>
<? if ($t>0){?>
<tr><td></td><td align="right"><? echo "Total $mois1 : ";?></td>
<td align="right" bgcolor="#3366FF"><?php echo number_format($t,2,',',' ');?></td></tr>
<? }?>
<? }?>
<? }?>

<tr><td></td><td align="right"><? echo "Total Echeancier : ";?></td>
<td align="right" bgcolor="#3366FF"><?php echo number_format($te,2,',',' ');?></td></tr>
</table>

<p style="text-align:center">

</body>

</html>