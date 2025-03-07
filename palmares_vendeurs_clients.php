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
		<? require "body_cal.php";?>

	<?
	
			if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="palmares_vendeurs_clients.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{
		$sql  = "SELECT * ";
		$sql .= "FROM clients order by client;";$users_c = db_query($database_name, $sql);
		while($users_cc = fetch_array($users_c)) { 
			$id_cc=$users_cc["id"];$null=0;
			$sql = "UPDATE clients SET ";
			$sql .= "er1_08 = '" . $null . "', ";
			$sql .= "eme2_08 = '" . $null . "', ";
			$sql .= "eme3_08 = '" . $null . "', ";
			$sql .= "eme4_08 = '" . $null . "',";
			$sql .= "er1_09 = '" . $null . "', ";
			$sql .= "eme2_09 = '" . $null . "', ";
			$sql .= "eme3_09 = '" . $null . "', ";
			$sql .= "eme4_09 = '" . $null . "' ";
			$sql .= "WHERE id = " . $id_cc . ";";
			db_query($database_name, $sql);
		}
	
	
	
	
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];
	$du=$_POST['date'];$au=$_POST['date1'];

	$sql  = "SELECT id,date_e,trimestre,commande,client,vendeur,date,sum(net) As total ";
	$sql .= "FROM commandes where date_e between '$date' and '$date1' GROUP BY id order by total DESC;";
	$users1 = db_query($database_name, $sql);
	$du1_08_t="2008-01-01";$au1_08_t="2008-03-31";$trimestre1_08="1er Trimestre 2008";
	$du2_08_t="2008-04-01";$au2_08_t="2008-06-30";$trimestre2_08="2eme Trimestre 2008";
	$du3_08_t="2008-07-01";$au3_08_t="2008-09-30";$trimestre3_08="3eme Trimestre 2008";
	$du4_08_t="2008-10-01";$au4_08_t="2008-12-31";$trimestre4_08="4eme Trimestre 2008";
	$du1_09_t="2009-01-01";$au1_09_t="2009-03-31";$trimestre1_09="1er Trimestre 2009";
	$du2_09_t="2009-04-01";$au2_09_t="2009-06-30";$trimestre2_09="2eme Trimestre 2009";
	$du3_09_t="2009-07-01";$au3_09_t="2009-09-30";$trimestre3_09="3eme Trimestre 2009";
	$du4_09_t="2009-10-01";$au4_09_t="2009-12-31";$trimestre4_09="4eme Trimestre 2009";
	
	while($users_1 = fetch_array($users1)) { 
	$vendeur=$users_1["vendeur"];$date_e=$users_1["date_e"];$id=$users_1["id"];$client=$users_1["client"];$net=$users_1["total"];
	$sql  = "SELECT * ";
	$sql .= "FROM clients where client='$client' order by client;";
	$users1c = db_query($database_name, $sql);$users_1c = fetch_array($users1c);$ville=$users_1c["ville"];$id_c=$users_1c["id"];
	$er1_08=$users_1c["er1_08"];
	$eme2_08=$users_1c["eme2_08"];$eme3_08=$users_1c["eme3_08"];$eme4_08=$users_1c["eme4_08"];
	$er1_09=$users_1c["er1_09"];$eme2_09=$users_1c["eme2_09"];$eme3_09=$users_1c["eme3_09"];$eme4_09=$users_1c["eme4_09"];
	
	if ($date_e>=$du1_08_t and $date_e<=$au1_08_t){$trimestre=$trimestre1_08;$er1_08=$er1_08+$net;}
	if ($date_e>=$du2_08_t and $date_e<=$au2_08_t){$trimestre=$trimestre2_08;$eme2_08=$eme2_08+$net;}
	if ($date_e>=$du3_08_t and $date_e<=$au3_08_t){$trimestre=$trimestre3_08;$eme3_08=$eme3_08+$net;}
	if ($date_e>=$du4_08_t and $date_e<=$au4_08_t){$trimestre=$trimestre4_08;$eme4_08=$eme4_08+$net;}
	if ($date_e>=$du1_09_t and $date_e<=$au1_09_t){$trimestre=$trimestre1_09;$er1_09=$er1_09+$net;}
	if ($date_e>=$du2_09_t and $date_e<=$au2_09_t){$trimestre=$trimestre2_09;$eme2_09=$eme2_09+$net;}
	if ($date_e>=$du3_09_t and $date_e<=$au3_09_t){$trimestre=$trimestre3_09;$eme3_09=$eme3_09+$net;}
	if ($date_e>=$du4_09_t and $date_e<=$au4_09_t){$trimestre=$trimestre4_09;$eme4_09=$eme4_09+$net;}
			$sql = "UPDATE commandes SET ";
			$sql .= "trimestre = '" . $trimestre . "', ";
			$sql .= "ville = '" . $ville . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
			$sql = "UPDATE clients SET ";
			$sql .= "er1_08 = '" . $er1_08 . "', ";
			$sql .= "eme2_08 = '" . $eme2_08 . "', ";
			$sql .= "eme3_08 = '" . $eme3_08 . "', ";
			$sql .= "eme4_08 = '" . $eme4_08 . "',";
			$sql .= "er1_09 = '" . $er1_09 . "', ";
			$sql .= "eme2_09 = '" . $eme2_09 . "', ";
			$sql .= "eme3_09 = '" . $eme3_09 . "', ";
			$sql .= "eme4_09 = '" . $eme4_09 . "' ";
			$sql .= "WHERE id = " . $id_c . ";";
			db_query($database_name, $sql);
}

	$sql  = "SELECT trimestre,commande,client,vendeur,date,sum(net) As total ";
	$sql .= "FROM commandes where date_e between '$date' and '$date1' GROUP BY vendeur order by total DESC;";
	$users = db_query($database_name, $sql);
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Palmares Vendeurs $du au $au"; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "Net";?></th>
	
</tr>

<?php $debit=0;$credit=0;$t=0;$s=0;$t=0;$tr1=0;$tr2=0;$tr3=0;$tr4=0;
while($users_ = fetch_array($users)) { $trimestre=$users_["trimestre"];$vendeur=$users_["vendeur"];
if ($trimestre=="1er trimestre 2008"){$tr1=$tr1+$users_["total"];}
if ($trimestre=="2eme trimestre 2008"){$tr2=$tr2+$users_["total"];}
if ($trimestre=="3eme trimestre 2008"){$tr3=$tr3+$users_["total"];}
if ($trimestre=="4eme trimestre 2008"){$tr4=$tr4+$users_["total"];}

?><tr>
<td bgcolor="#00FF99"><?php echo $users_["vendeur"];?></td><td align="right" bgcolor="#00FF99"><?php echo number_format($users_["total"],2,',',' ');?></td>
	<? 
	$sql  = "SELECT ville,secteur,trimestre,commande,client,vendeur,date,sum(net) As total_t ";
	$sql .= "FROM commandes where vendeur='$vendeur' and date_e between '$date' and '$date1' GROUP BY ville order by total_t DESC ;";
	$users1 = db_query($database_name, $sql);
while($users_1 = fetch_array($users1)) { $ville=$users_1["ville"];?>
<tr><td bgcolor="#00CCFF" align="center"><?php echo $users_1["ville"];?></td><td align="right" bgcolor="#00CCFF"><?php echo number_format($users_1["total_t"],2,',',' ');?></td></tr>

	<? 
	$sql  = "SELECT ville,secteur,trimestre,commande,client,vendeur,date,sum(net) As total_tc ";
	$sql .= "FROM commandes where vendeur='$vendeur' and ville='$ville' and date_e between '$date' and '$date1' GROUP BY client order by total_tc DESC ;";
	$users1cc = db_query($database_name, $sql);
while($users_1cc = fetch_array($users1cc)) { $client=$users_1cc["client"];?>
<tr><td><?php echo $users_1cc["client"];?></td><td align="right"><?php echo number_format($users_1cc["total_tc"],2,',',' ');?></td></tr>

<? }?>
<? }?>

<td align="right"><?php $t=$t+$users_["total"];?></td>
<?php } ?>
<tr>
<td></td>
<td align="right"><?php echo number_format($t,2,',',' ');?></td>
</tr>
</table>

<?php } ?>

<p style="text-align:center">

</body>

</html>