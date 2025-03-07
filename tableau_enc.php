<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";
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
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	
	$date=$_GET['date_enc'];$vendeur=$_GET['vendeur'];$id_registre=$_GET['id_registre'];$total_e=0;$total_c=0;$total_t=0;
	$bon_sortie=$_GET['bon_sortie'];$t=$_GET['t'];$dest=$_GET['dest'];$a="A";
	$sql  = "SELECT numero_cheque,client,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles where impaye=0 and id_registre_regl='$id_registre' and numero_cheque<>'$a' Group BY id;";
	$users11 = db_query($database_name, $sql);
?>

<span style="font-size:36px"><?php echo "MPS"; ?></span>
<P></P>
<span style="font-size:16px"><?php echo "Tableau Encaissement $t / BS : $bon_sortie    Date : ".dateUsToFr($date)."   ".$vendeur." - ".$dest; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo "Montant Eval";?></th>
	<th><?php echo "Regl/Client";?></th>
	<th><?php echo "Total A enc";?></th>
	<th bgcolor="#33CC66"><?php echo "Avoir";?></th>
	<th bgcolor="#33CC66"><?php echo "Diff/Prix";?></th>
	<th bgcolor="#3366FF"><?php echo "ESPECE";?></th>
	<th bgcolor="#3366FF"><?php echo "CHEQUE";?></th>
	<th bgcolor="#3366FF"><?php echo "EFFET";?></th>
	<th bgcolor="#3366FF"><?php echo "VIREMENT";?></th>
</tr>

<?php $compteur1=0;$total_g=0;$t_espece=0;
while($users_1 = fetch_array($users11)) { 
			$client=$users_1["client"];$total_e=$users_1["total_e"];$total_avoir=$users_1["total_avoir"];
			$total_cheque=$users_1["total_cheque"];$total_espece=$users_1["total_espece"];$total_effet=$users_1["total_effet"];
			$total_diff_prix=$users_1["total_diff_prix"];$total_virement=$users_1["total_virement"];?>
			<tr>
			<td><?php echo $client; ?></td>
			<td align="right"><?php echo number_format($total_e,2,',',' '); ?></td>
			<td><?php ?></td>
			<td><?php ?></td>
			<td align="right"><?php echo number_format($total_avoir,2,',',' '); ?></td>
			<td align="right"><?php echo number_format($total_diff_prix,2,',',' '); ?></td>
			<td align="right"><?php $t_espece=$t_espece+$total_espece-$total_avoir-$total_diff_prix;echo number_format($total_espece-$total_avoir-$total_diff_prix,2,',',' '); ?></td>
			<td align="right"><?php echo number_format($total_cheque,2,',',' '); ?></td>
			<td align="right"><?php echo number_format($total_effet,2,',',' '); ?></td>
			<td align="right"><?php echo number_format($total_virement,2,',',' '); ?></td>
<? } ?>
<tr><td bgcolor=""></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>

<tr><td></td><td></td><td></td><td></td><td></td><td><?php echo "Total"; ?></td>
			<td align="right"><?php echo number_format($t_espece,2,',',' '); ?></td>
<td></td><td></td><td></td>
</strong>
<p style="text-align:center">

<?
	$sql  = "SELECT * ";
	$sql .= "FROM registre_reglements where id='$id_registre' ORDER BY id;";
	$users11 = db_query($database_name, $sql);$user_ = fetch_array($users11);
		$libelle1=$user_["libelle1"];$montant1=$user_["montant1"];
		$libelle2=$user_["libelle2"];$montant2=$user_["montant2"];
		$libelle3=$user_["libelle3"];$montant3=$user_["montant3"];
		$libelle4=$user_["libelle4"];$montant4=$user_["montant4"];
		$libelle5=$user_["libelle5"];$montant5=$user_["montant5"];
		$objet1=$user_["objet1"];$cheque1=$user_["cheque1"];
		$objet2=$user_["objet2"];$cheque2=$user_["cheque2"];
		$objet3=$user_["objet3"];$cheque3=$user_["cheque3"];
		$objet4=$user_["objet4"];$cheque4=$user_["cheque4"];
		$objet5=$user_["objet5"];$cheque5=$user_["cheque5"];
		$objet6=$user_["objet6"];$cheque6=$user_["cheque6"];
		$objet7=$user_["objet7"];$cheque7=$user_["cheque7"];
		$objet8=$user_["objet8"];$cheque8=$user_["cheque8"];
		$objet9=$user_["objet9"];$cheque9=$user_["cheque9"];
		$objet10=$user_["objet10"];$cheque10=$user_["cheque10"];
		$date_cheque1=dateUsToFr($user_["date_cheque1"]);$ref1=$user_["ref1"];
		$date_cheque2=dateUsToFr($user_["date_cheque2"]);$ref2=$user_["ref2"];
		$date_cheque3=dateUsToFr($user_["date_cheque3"]);$ref3=$user_["ref3"];
		$date_cheque4=dateUsToFr($user_["date_cheque4"]);$ref4=$user_["ref4"];
		$date_cheque5=dateUsToFr($user_["date_cheque5"]);$ref5=$user_["ref5"];
		$date_cheque6=dateUsToFr($user_["date_cheque6"]);$ref6=$user_["ref6"];
		$date_cheque7=dateUsToFr($user_["date_cheque7"]);$ref7=$user_["ref7"];
		$date_cheque8=dateUsToFr($user_["date_cheque8"]);$ref8=$user_["ref8"];
		$date_cheque9=dateUsToFr($user_["date_cheque9"]);$ref9=$user_["ref9"];
		$date_cheque10=dateUsToFr($user_["date_cheque10"]);$ref10=$user_["ref10"];
		
		
		
		
		
		
?>

		<tr><td bordercolorlight="#FFFFFF"></td><td></td><td></td><td></td><td></td>
		<td><?php echo $libelle1; ?></td>
		<td align="right"><?php echo number_format($montant1,2,',',' '); ?></td><td></td><td></td><td></td>
		</tr>
		<tr><td></td><td></td><td></td><td></td><td></td>
		<td><?php echo $libelle2; ?></td>
		<td align="right"><?php echo number_format($montant2,2,',',' '); ?></td><td></td><td></td><td></td>
		</tr>
		<tr><td></td><td></td><td></td><td></td><td></td>
		<td><?php echo $libelle3; ?></td>
		<td align="right"><?php echo number_format($montant3,2,',',' '); ?></td><td></td><td></td><td></td>
		</tr>
		<tr><td></td><td></td><td></td><td></td><td></td>
		<td><?php echo $libelle4; ?></td>
		<td align="right"><?php echo number_format($montant4,2,',',' '); ?></td><td></td><td></td><td></td>
		</tr>
		<tr><td></td><td></td><td></td><td></td><td></td>
		<td><?php echo $libelle5; ?></td>
		<td align="right"><?php echo number_format($montant5,2,',',' '); ?></td><td></td><td></td><td></td>
		</tr>
		<td></td><td></td><td></td><td></td><td></td><td><?php echo "A Encaisser"; ?></td>
		<td align="right"><?php $t_enc=$t_espece-($montant1+$montant2+$montant3+$montant4+$montant5);echo number_format($t_espece-($montant1+$montant2+$montant3+$montant4+$montant5),2,',',' '); ?></td>
<td></td><td></td><td></td>

</table>
<p></p>
<p>Autres Encaissement / Cheques impayés </p>

<table class="table2">
		<td><?php echo "Libelle"; ?></td>
		<td><?php echo "Date Cheque"; ?></td>
		<td><?php echo "Numero"; ?></td>
		<td><?php echo "Montant"; ?></td>

		<? if ($objet1<>""){?>
		<tr>
		<td><?php echo $objet1; ?></td>
		<td><?php echo $date_cheque1; ?></td>
		<td><?php echo $ref1; ?></td>
		<td align="right"><?php echo number_format($cheque1,2,',',' '); ?></td>
		</tr>
		<? }?>		<? if ($objet2<>""){?>

		<tr>
		<td><?php echo $objet2; ?></td>
		<td><?php echo $date_cheque2; ?></td>
		<td><?php echo $ref2; ?></td>
		<td align="right"><?php echo number_format($cheque2,2,',',' '); ?></td>
		</tr>
		<? }?>		<? if ($objet3<>""){?>
		
		<tr>
		<td><?php echo $objet3; ?></td>
		<td><?php echo $date_cheque3; ?></td>
		<td><?php echo $ref3; ?></td>
		<td align="right"><?php echo number_format($cheque3,2,',',' '); ?></td>
		</tr>
		<? }?>		<? if ($objet4<>""){?>
		
		<tr>
		<td><?php echo $objet4; ?></td>
		<td><?php echo $date_cheque4; ?></td>
		<td><?php echo $ref4; ?></td>
		<td align="right"><?php echo number_format($cheque4,2,',',' '); ?></td>
		</tr>
		<? }?>		<? if ($objet5<>""){?>

		<tr>
		<td><?php echo $objet5; ?></td>
		<td><?php echo $date_cheque5; ?></td>
		<td><?php echo $ref5; ?></td>
		<td align="right"><?php echo number_format($cheque5,2,',',' '); ?></td>
		</tr>
		<? }?>		<? if ($objet6<>""){?>

		<tr>
		<td><?php echo $objet6; ?></td>
		<td><?php echo $date_cheque6; ?></td>
		<td><?php echo $ref6; ?></td>
		<td align="right"><?php echo number_format($cheque6,2,',',' '); ?></td>
		</tr>
		<? }?>		<? if ($objet7<>""){?>

		<tr>
		<td><?php echo $objet7; ?></td>
		<td><?php echo $date_cheque7; ?></td>
		<td><?php echo $ref7; ?></td>
		<td align="right"><?php echo number_format($cheque7,2,',',' '); ?></td>
		</tr>
		<? }?>		<? if ($objet8<>""){?>

		<tr>
		<td><?php echo $objet8; ?></td>
		<td><?php echo $date_cheque8; ?></td>
		<td><?php echo $ref8; ?></td>
		<td align="right"><?php echo number_format($cheque8,2,',',' '); ?></td>
		</tr>
		<? }?>		<? if ($objet9<>""){?>

		<tr>
		<td><?php echo $objet9; ?></td>
		<td><?php echo $date_cheque9; ?></td>
		<td><?php echo $ref9; ?></td>
		<td align="right"><?php echo number_format($cheque9,2,',',' '); ?></td>
		</tr>
		<? }?>		<? if ($objet10<>""){?>

		<tr>
		<td><?php echo $objet10; ?></td>
		<td><?php echo $date_cheque10; ?></td>
		<td><?php echo $ref10; ?></td>
		<td align="right"><?php echo number_format($cheque10,2,',',' '); ?></td>
		</tr>
		<? }?>
		<tr>
		<td></td>
		<td></td>
		<td><? echo "Total Espece";?></td>
		<? $t_enc=$t_enc+$cheque1+$cheque2+$cheque3+$cheque4+$cheque5+$cheque6+$cheque7+$cheque8+$cheque9+$cheque10;?>
		<td align="right"><?php echo number_format($t_enc,2,',',' '); ?></td>
		</tr>
		
</table>


</body>

</html>