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
	<form id="form" name="form" method="post" action="balance_commissions.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{
	
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];
	$du=$_POST['date'];$au=$_POST['date1'];$encours="encours";
	
	$sql  = "SELECT vendeur,client,montant,date_f,sum(montant) As total_net ";
	$sql .= "FROM factures where date_f between '$date' and '$date1' GROUP BY vendeur;";
	$users = db_query($database_name, $sql);
	
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Balance Commissions $du au $au"; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "C.A Facturé H.T";?></th>
	<th><?php echo "Commission";?></th>
</tr>

<?php $debit=0;$credit=0;$t=0;$s=0;$t_avoir_t=0;$c=0;$tv=0;
while($users_ = fetch_array($users)) { ?><tr>
<?php $vendeur=$users_["vendeur"];?>
<? echo "<td>$vendeur</td>";?>
<td align="right"><?php $t=$t+$users_["total_net"]/1.20;echo number_format($users_["total_net"]/1.20,2,',',' ');?></td>
<? 			
	$sql  = "SELECT * ";
	$sql .= "FROM vendeurs where vendeur='$vendeur' order BY vendeur;";
	$users1 = db_query($database_name, $sql);$users_1 = fetch_array($users1);$com = $users_1["com"];

	/*$sql  = "SELECT * ";
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
<?php $t_avoirs=number_format($t_avoir,2,',',' ');$tv=$tv+$t_avoir;?>
<? echo "<td align=\"right\"><a href=\"balance_avoirs.php?vendeur=$vendeur&date=$date&date1=$date1\">$t_avoirs</a></td>";*/?>
<?php $net=($users_["total_net"]/1.20);?>
		

<td align="right"><?php $c=$c+($net*$com/100);echo number_format($net*$com/100,2,',',' ');?></td>


<?php } ?>
<tr><td></td><td align="right"><?php echo number_format($t,2,',',' ');?></td>
<td align="right"><?php echo number_format($c,2,',',' ');?></td>
</table>
<?php } ?>

<? //non aboutit


	if(isset($_REQUEST["action"]))
	{
	
	} ?>



<p style="text-align:center">

</body>

</html>