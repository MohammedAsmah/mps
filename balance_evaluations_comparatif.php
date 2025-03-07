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
	<form id="form" name="form" method="post" action="balance_evaluations_comparatif.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];
	$du=$_POST['date'];$au=$_POST['date1'];$encours="encours";$t1=0;$t2=0;$t3=0;$t4=0;$vide="";$t5=0;
	list($annee1,$mois1,$jour1) = explode('-', $date); 
	$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
	list($annee11,$mois11,$jour11) = explode('-', $date1); 
	$pau = mktime(0,0,0,$mois11,$jour11,$annee11); 
	$jour=date("d",$pdu);$mois=date("m",$pdu);$annee=date("Y",$pdu);
	$jour1=date("d",$pau);$mois1=date("m",$pau);$annee1=date("Y",$pau);
	$d1=$jour."/".$mois."/".$annee1;$d2=$jour1."/".$mois1."/".$annee1;
	$annee_1=$annee-1;$annee_2=$annee-2;$annee_3=$annee-3;$annee_0=$annee-0;$annee_4=$annee-4;
	$d1_exe_1=$annee_1."-".$mois."-".$jour;$d2_exe_1=$annee_1."-".$mois1."-".$jour1;
	$d1_exe_2=$annee_2."-".$mois."-".$jour;$d2_exe_2=$annee_2."-".$mois1."-".$jour1;
	$d1_exe_3=$annee_3."-".$mois."-".$jour;$d2_exe_3=$annee_3."-".$mois1."-".$jour1;
	$d1_exe_4=$annee_4."-".$mois."-".$jour;$d2_exe_4=$annee_4."-".$mois1."-".$jour1;
	?>
	
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Comparatif Evaluations  $jour/$mois  au  $jour1/$mois1 "; ?></span>

<p style="text-align:center">
	<table class="table2">

<tr>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo $annee_0;?></th>
	<th><?php echo $annee_1;?></th>
	<th><?php echo $annee_2;?></th>
	<th><?php echo $annee_3;?></th>
	<th><?php echo $annee_4;?></th>
	
</tr>

	
	<?
	$sql  = "SELECT * ";
	$sql .= "FROM vendeurs order BY vendeur;";
	$users_v = db_query($database_name, $sql);
while($users_v1 = fetch_array($users_v)) { ?><tr>
	
	<? $vendeur=$users_v1["vendeur"];?>

	<? 
	$sql  = "SELECT vendeur,client,net,date_e,solde,sum(net) As total_net,sum(solde) As total_solde ";
	$sql .= "FROM commandes where date_e between '$date' and '$date1' and evaluation<>'$encours' and evaluation<>'$vide' and vendeur='$vendeur' and escompte_exercice=0 and id_registre<>0 GROUP BY vendeur;";
	$users = db_query($database_name, $sql);
	
	$sql  = "SELECT vendeur,client,net,date_e,solde,sum(net) As total_net,sum(solde) As total_solde ";
	$sql .= "FROM commandes where date_e between '$d1_exe_1' and '$d2_exe_1' and evaluation<>'$encours' and evaluation<>'$vide' and vendeur='$vendeur' and escompte_exercice=0 and id_registre<>0 GROUP BY vendeur;";
	$users1 = db_query($database_name, $sql);
	
	$sql  = "SELECT vendeur,client,net,date_e,solde,sum(net) As total_net,sum(solde) As total_solde ";
	$sql .= "FROM commandes where date_e between '$d1_exe_2' and '$d2_exe_2' and evaluation<>'$encours' and evaluation<>'$vide' and vendeur='$vendeur' and escompte_exercice=0 and id_registre<>0 GROUP BY vendeur;";
	$users2 = db_query($database_name, $sql);
	
	$sql  = "SELECT vendeur,client,net,date_e,solde,sum(net) As total_net,sum(solde) As total_solde ";
	$sql .= "FROM commandes where date_e between '$d1_exe_3' and '$d2_exe_3' and evaluation<>'$encours' and evaluation<>'$vide' and vendeur='$vendeur' and escompte_exercice=0 and id_registre<>0 GROUP BY vendeur;";
	$users3 = db_query($database_name, $sql);
	
	$sql  = "SELECT vendeur,client,net,date_e,solde,sum(net) As total_net,sum(solde) As total_solde ";
	$sql .= "FROM commandes where date_e between '$d1_exe_4' and '$d2_exe_4' and evaluation<>'$encours' and evaluation<>'$vide' and vendeur='$vendeur' and escompte_exercice=0 and id_registre<>0 GROUP BY vendeur;";
	$users4 = db_query($database_name, $sql);
	
	
	?>




<?php 
$users_ = fetch_array($users); $users_1 = fetch_array($users1);$users_2 = fetch_array($users2);$users_3 = fetch_array($users3);$users_4 = fetch_array($users4);
if ($users_["total_net"]<>0 or $users_1["total_net"]<>0 or $users_2["total_net"]<>0 or $users_3["total_net"]<>0){echo "<td>$vendeur</td>";
?>
<td align="right"><?php $mm=number_format($users_["total_net"],2,',',' ');$n="<a href=\"palmares_details_vendeurs.php?date=$date&date1=$date1&vendeur=$vendeur\">$mm</a>";
echo $n;$t1=$t1+$users_["total_net"];?></td>
<td align="right"><?php echo number_format($users_1["total_net"],2,',',' ');$t2=$t2+$users_1["total_net"];?></td>
<td align="right"><?php echo number_format($users_2["total_net"],2,',',' ');$t3=$t3+$users_2["total_net"];?></td>
<td align="right"><?php echo number_format($users_3["total_net"],2,',',' ');$t4=$t4+$users_3["total_net"];?></td>
<td align="right"><?php echo number_format($users_4["total_net"],2,',',' ');$t5=$t5+$users_4["total_net"];?></td>
<?php }} ?>
<tr><td align="right"><?php echo "Totaux : ";?></td>
<td align="right"><?php echo number_format($t1,2,',',' ');?></td>
<td align="right"><?php echo number_format($t2,2,',',' ');?></td>
<td align="right"><?php echo number_format($t3,2,',',' ');?></td>
<td align="right"><?php echo number_format($t4,2,',',' ');?></td>
<td align="right"><?php echo number_format($t5,2,',',' ');?></td>
</table>




<p>

<span style="font-size:24px"><?php echo "Comparatif FACTURATION  $jour/$mois  au  $jour1/$mois1 "; ?></span>

<p style="text-align:center">
	<table class="table2">

<tr>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo $annee_0;?></th>
	<th><?php echo $annee_1;?></th>
	<th><?php echo $annee_2;?></th>
	<th><?php echo $annee_3;?></th>
	<th><?php echo $annee_4;?></th>
</tr>

	
	<?
	$sql  = "SELECT * ";$tt1=0;$tt2=0;$tt3=0;$tt4=0;$tt5=0;
	$sql .= "FROM vendeurs order BY vendeur;";
	$users_vv = db_query($database_name, $sql);
while($users_v1 = fetch_array($users_vv)) { ?><tr>
	
	<? $vendeur=$users_v1["vendeur"];?>

	<? 
	
	
	
	$sql  = "SELECT vendeur,client,date_f,solde,sum(montant) As total_net ";
	$sql .= "FROM factures2024 where date_f between '$date' and '$date1' and hors_ca=0 and vendeur='$vendeur' GROUP BY vendeur;";
	$usersf = db_query($database_name, $sql);
	
	$sql  = "SELECT vendeur,client,date_f,solde,sum(montant) As total_net ";
	$sql .= "FROM factures2023 where date_f between '$d1_exe_1' and '$d2_exe_1' and hors_ca=0 and vendeur='$vendeur' GROUP BY vendeur;";
	$users1f = db_query($database_name, $sql);
	
	$sql  = "SELECT vendeur,client,date_f,solde,sum(montant) As total_net ";
	$sql .= "FROM factures2022 where date_f between '$d1_exe_2' and '$d2_exe_2' and hors_ca=0 and vendeur='$vendeur' GROUP BY vendeur;";
	$users2f = db_query($database_name, $sql);
	
	$sql  = "SELECT vendeur,client,date_f,solde,sum(montant) As total_net ";
	$sql .= "FROM factures2021 where date_f between '$d1_exe_3' and '$d2_exe_3' and hors_ca=0 and vendeur='$vendeur' GROUP BY vendeur;";
	$users3f = db_query($database_name, $sql);
	
	$sql  = "SELECT vendeur,client,date_f,solde,sum(montant) As total_net ";
	$sql .= "FROM factures2020 where date_f between '$d1_exe_4' and '$d2_exe_4' and hors_ca=0 and vendeur='$vendeur' GROUP BY vendeur;";
	$users4f = db_query($database_name, $sql);
	
	////////
	
	$sql  = "SELECT vendeur,client,net,date_e,solde,sum(net) As total_net,sum(solde) As total_solde ";
	$sql .= "FROM commandes where date_e between '$date' and '$date1' and evaluation<>'$encours' and evaluation<>'$vide' and vendeur='$vendeur' and escompte_exercice=0 GROUP BY vendeur;";
	$userse = db_query($database_name, $sql);
	
	$sql  = "SELECT vendeur,client,net,date_e,solde,sum(net) As total_net,sum(solde) As total_solde ";
	$sql .= "FROM commandes where date_e between '$d1_exe_1' and '$d2_exe_1' and evaluation<>'$encours' and evaluation<>'$vide' and vendeur='$vendeur' and escompte_exercice=0 GROUP BY vendeur;";
	$users1e = db_query($database_name, $sql);
	
	$sql  = "SELECT vendeur,client,net,date_e,solde,sum(net) As total_net,sum(solde) As total_solde ";
	$sql .= "FROM commandes where date_e between '$d1_exe_2' and '$d2_exe_2' and evaluation<>'$encours' and evaluation<>'$vide' and vendeur='$vendeur' and escompte_exercice=0 GROUP BY vendeur;";
	$users2e = db_query($database_name, $sql);
	
	$sql  = "SELECT vendeur,client,net,date_e,solde,sum(net) As total_net,sum(solde) As total_solde ";
	$sql .= "FROM commandes where date_e between '$d1_exe_3' and '$d2_exe_3' and evaluation<>'$encours' and evaluation<>'$vide' and vendeur='$vendeur' and escompte_exercice=0 GROUP BY vendeur;";
	$users3e = db_query($database_name, $sql);
	
	$sql  = "SELECT vendeur,client,net,date_e,solde,sum(net) As total_net,sum(solde) As total_solde ";
	$sql .= "FROM commandes where date_e between '$d1_exe_4' and '$d2_exe_4' and evaluation<>'$encours' and evaluation<>'$vide' and vendeur='$vendeur' and escompte_exercice=0 GROUP BY vendeur;";
	$users4e = db_query($database_name, $sql);
	
	$users_e = fetch_array($userse); $users_1e = fetch_array($users1e);$users_2e = fetch_array($users2e);$users_3e = fetch_array($users3e);$users_4e = fetch_array($users4e);
	$ev1=$users_e["total_net"];$ev2=$users_1e["total_net"];$ev3=$users_2e["total_net"];$ev4=$users_3e["total_net"];$ev5=$users_4e["total_net"];
	
	
	?>




<?php 
$users_ = fetch_array($usersf); $users_1 = fetch_array($users1f);$users_2 = fetch_array($users2f);$users_3 = fetch_array($users3f);$users_4 = fetch_array($users4f);
if ($users_["total_net"]<>0 or $users_1["total_net"]<>0 or $users_2["total_net"]<>0 or $users_3["total_net"]<>0){echo "<td>$vendeur</td>";
?>
<td align="right"><?php $mm=number_format($users_["total_net"],2,',',' ');$n="$mm";
echo $n;$tt1=$tt1+$users_["total_net"];?></td>
<td align="right"><?php echo number_format($users_1["total_net"],2,',',' ');$tt2=$tt2+$users_1["total_net"];?></td>
<td align="right"><?php echo number_format($users_2["total_net"],2,',',' ');$tt3=$tt3+$users_2["total_net"];?></td>
<td align="right"><?php echo number_format($users_3["total_net"],2,',',' ');$tt4=$tt4+$users_3["total_net"];?></td>
<td align="right"><?php echo number_format($users_4["total_net"],2,',',' ');$tt5=$tt5+$users_4["total_net"];?></td>
<?php }} ?>
<tr><td align="right"><?php echo "Totaux : ";?></td>
<td align="right"><?php echo number_format($tt1,2,',',' ');?></td>
<td align="right"><?php echo number_format($tt2,2,',',' ');?></td>
<td align="right"><?php echo number_format($tt3,2,',',' ');?></td>
<td align="right"><?php echo number_format($tt4,2,',',' ');?></td>
<td align="right"><?php echo number_format($tt5,2,',',' ');?></td>
<tr><td align="right"><?php echo "Perct : ";?></td>
<td align="right"><?php echo number_format($tt1/$t1*100,2,',',' ');?></td>
<td align="right"><?php echo number_format($tt2/$t2*100,2,',',' ');?></td>
<td align="right"><?php echo number_format($tt3/$t3*100,2,',',' ');?></td>
<td align="right"><?php echo number_format($tt4/$t4*100,2,',',' ');?></td>
<td align="right"><?php echo number_format($tt5/$t5*100,2,',',' ');?></td>
</table>


<?php } ?>

<p style="text-align:center">

</body>

</html>