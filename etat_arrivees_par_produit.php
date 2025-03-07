<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
		$client="";$action="Recherche";$mode1="DEBITEUR";
		$du="01/11/06";$au="30/11/06";$sel=1;$lp="";
	
	if(isset($_REQUEST["action"]))
	{
	 $date1=dateFrToUs($_POST['date1']);$client=$_POST['client'];
	 $date2=dateFrToUs($_POST['date2']);
	 $produit=$_POST['produit'];$action=$_REQUEST["action"];
	$sql  = "SELECT * ";
	$sql .= "FROM rs_data_produits where profile_id=1 or profile_id=2 ORDER BY last_name;";
	$users_r = db_query($database_name, $sql);}
		else
	 {$client="";$produit="";}


	$client_list = "";
	$sql = "SELECT * FROM  rs_data_clients ORDER BY last_name;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client == $temp_["last_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list .= "<OPTION VALUE=\"" . $temp_["last_name"] . "\"" . $selected . ">";
		$client_list .= $temp_["last_name"];
		$client_list .= "</OPTION>";
	}
	$produit_list = "";
	$sql = "SELECT * FROM  rs_data_produits where profile_id=1 or profile_id=2 ORDER BY last_name ;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit == $temp_["last_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list .= "<OPTION VALUE=\"" . $temp_["last_name"] . "\"" . $selected . ">";
		$produit_list .= $temp_["last_name"];
		$produit_list .= "</OPTION>";
	}
	
	?>
	
	<form id="form" name="form" method="post" action="etat_arrivees_par_produit.php">
	<td><?php echo "Client : "; ?><select id="client" name="client"><?php echo $client_list; ?></select></td>
	<td><?php echo "Produit : "; ?><select id="produit" name="produit"><?php echo $produit_list; ?></select></td>
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" / value="<?php echo $du; ?>"></td>
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date2" readonly="readonly" style="cursor: text" / value="<?php echo $au; ?>"></td>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	<?
	
	
	if(isset($_REQUEST["action"]))
	{
	 $date1=dateFrToUs($_POST['date1']);
	 $client=$_POST['client'];$produit=$_POST['produit'];
	 $date2=dateFrToUs($_POST['date2']);
	 $action=$_REQUEST["action"];
	$sql  = "SELECT * ";
	$sql .= "FROM rs_data_produits where profile_id=1 or profile_id=2 ORDER BY last_name;";
	$users_r = db_query($database_name, $sql);}
	
	else
	{$date1="";$date2="";}
	

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre_sejour.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo ""; ?></span>

<? $net_total=0;$total_pax=0;$net_t=0;echo dateUsToFr($date1)."  au  : ".dateUsToFr($date2)."  - ".$client;?>

			<table class="table2" bordercolordark="#333333">
			<tr>
			<td width="180">Produit</td>
			<td width="30">Pax</td>
			</tr>
			
<?php $pax=0;$j=0;$j1=0;$pax1=0;$i_total=0;
while($users_r_ = fetch_array($users_r)) 
		{ 	$service=$users_r_["last_name"];
			if ($client<>""){
			$sql  = "SELECT * ";
			$sql .= "FROM details_bookings_sejours_rak where arrivee between '$date1' and '$date2' and service='$service' and a_facturer='$client'  ORDER BY id;";}
			else
			{$sql  = "SELECT * ";
			$sql .= "FROM details_bookings_sejours_rak where arrivee between '$date1' and '$date2' and service='$service' ORDER BY id;";}
			$users = db_query($database_name, $sql);
			
			?>
			<?php $i=0; 
			while($users_b_ = fetch_array($users)) 
			{
			$adt=$users_b_["adultes"];$enf=$users_b_["enfants"];$origine=$users_b_["origine"];
			if($origine=="APT-RAK" or $origine=="APT-FES" or $origine=="APT-CASA" or $origine=="APT - RAK" or $origine=="APT - FES" or $origine=="APT - CASA") {$i=$i+($adt+$enf);}
			}?>
			
			<? if ($i>0){?><tr>
			<td><?php echo $service; ?></td>
			<td><?php $tranche=$i;echo $i; $i_total=$i_total+$i?></td>
			</tr><? }?>
			
			
			<?php $j=0;$j1=0;$tnet=0; ?>
<? } ?>
<td>Total Arrivees</td><td><? echo $i_total;?></td>
</table>
<p style="text-align:center">


</body>

</html>