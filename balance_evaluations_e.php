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
	<form id="form" name="form" method="post" action="balance_evaluations_e.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{
	
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];
	$du=$_POST['date'];$au=$_POST['date1'];$encours="encours";
	
	$sql  = "SELECT id,trimestre,vendeur,client,net,date_e,solde,sum(net) As total_net,sum(solde) As total_solde ";
	$sql .= "FROM commandes where date_e between '$date' and '$date1' and evaluation<>'$encours' and id_registre<>0 and valider_f=0 and escompte_exercice=0 GROUP BY vendeur;";
	$users = db_query($database_name, $sql);
	$du1_08_t="2008-01-01";$au1_08_t="2008-03-31";$trimestre1_08="1er Trimestre 2008";
	$du2_08_t="2008-04-01";$au2_08_t="2008-06-30";$trimestre2_08="2eme Trimestre 2008";
	$du3_08_t="2008-07-01";$au3_08_t="2008-09-30";$trimestre3_08="3eme Trimestre 2008";
	$du4_08_t="2008-10-01";$au4_08_t="2008-12-31";$trimestre4_08="4eme Trimestre 2008";
	
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Balance Evaluations sortie $du au $au"; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "Evaluation";?></th>
	<th><?php echo "Avoirs";?></th>
	<th><?php echo "Net";?></th>
	<th><?php echo "Trimestre";?></th>
</tr>

<?php $debit=0;$credit=0;$t=0;$s=0;$t_avoir_t=0;
while($users_ = fetch_array($users)) { 
$vendeur=$users_["vendeur"];$date_e=$users_["date_e"];$id=$users_["id"];
if ($date_e>=$du1_08_t and $date_e<=$au1_08_t){$trimestre=$trimestre1_08;}
if ($date_e>=$du2_08_t and $date_e<=$au2_08_t){$trimestre=$trimestre2_08;}
if ($date_e>=$du3_08_t and $date_e<=$au3_08_t){$trimestre=$trimestre3_08;}
if ($date_e>=$du4_08_t and $date_e<=$au4_08_t){$trimestre=$trimestre4_08;}
			$sql = "UPDATE commandes SET ";
			$sql .= "trimestre = '" . $trimestre . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);





?><tr>
<?php $vendeur=$users_["vendeur"];?>
<? echo "<td><a href=\"balance_evaluations_vendeurs.php?vendeur=$vendeur&date=$date&date1=$date1\">$vendeur</a></td>";?>
<td align="right"><?php $t=$t+$users_["total_net"];echo number_format($users_["total_net"],2,',',' ');?></td>
<?
	$sql  = "SELECT * ";
	$vide="";
	$sql .= "FROM porte_feuilles where (date_enc between '$date' and '$date1') and vendeur='$vendeur' and impaye=0 Order BY date_enc;";
	$users11 = db_query($database_name, $sql);$t_cheque=0;$t_espece=0;$t_avoir=0;
	while($row = fetch_array($users11))
	{	$numero_cheque = $row['numero_cheque'];$facture_n = $row['facture_n'];
		$total_cheque = $row['m_cheque'];$total_espece = $row['m_espece']-$row['m_avoir']-$row['m_diff_prix'];
		$total_effet = $row['m_effet'];$total_avoir = $row['m_avoir'];$total_diff = $row['m_diff_prix'];
		$total_virement = $row['m_virement'];$t_avoir=$t_avoir+$row['m_avoir'];$t_avoir_t=$t_avoir_t+$row['m_avoir'];
		$t_cheque=$t_cheque+$total_cheque-$total_effet-$total_virement;
		$t_espece=$t_espece+$total_espece;
	}?>
<?php $t_avoirs=number_format($t_avoir,2,',',' ');?>
<? echo "<td align=\"right\"><a href=\"balance_avoirs.php?vendeur=$vendeur&date=$date&date1=$date1\">$t_avoirs</a></td>";?>
<td align="right"><?php echo number_format($users_["total_net"]-$t_avoir,2,',',' ');?></td>
<td align="right"><?php echo $users_["trimestre"];?></td>
<?php } ?>
<tr><td></td><td align="right"><?php echo number_format($t,2,',',' ');?></td>
<td align="right"><?php echo number_format($t_avoir_t,2,',',' ');?></td>
<td align="right"><?php echo number_format($t-$t_avoir_t,2,',',' ');?></td>
</table>
<?php } ?>

<? //non aboutit


	if(isset($_REQUEST["action"]))
	{
	
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];
	$du=$_POST['date'];$au=$_POST['date1'];
	
	$sql  = "SELECT vendeur,client,net,date_e,solde,sum(net) As total_net,sum(solde) As total_solde ";
	$sql .= "FROM commandes where date_e between '$date' and '$date1' and id_registre=0 and escompte_exercice=0 GROUP BY vendeur;";
	$users = db_query($database_name, $sql);
	
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php /*echo "Balance Evaluations non sortie $du au $au";*/ ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php /*echo "Vendeur";?></th>
	<th><?php echo "Net";*/?></th>
</tr>

<?php /* $debit=0;$credit=0;$t=0;$s=0;
while($users_ = fetch_array($users)) { ?><tr>
<?php $vendeur=$users_["vendeur"];?>
<? echo "<td><a href=\"balance_evaluations_vendeurs1.php?vendeur=$vendeur&date=$date&date1=$date1\">$vendeur</a></td>";?>
<td align="right"><?php $t=$t+$users_["total_net"];echo number_format($users_["total_net"],2,',',' ');?></td>

<?php } ?>
<tr><td></td><td align="right"><?php echo number_format($t,2,',',' ');?></td>
</table>
<?php */} ?>



<p style="text-align:center">

</body>

</html>