<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";$action="Recherche";$date="";$date1="";$du="";$au="";
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$user_login = $user_["login"];
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
	<form id="form" name="form" method="post" action="palmares_vendeurs.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{
	
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];
	$du=$_POST['date'];$au=$_POST['date1'];$encours="encours";

	$sql  = "SELECT trimestre,commande,client,vendeur,date,sum(net) As total ";
	$sql .= "FROM commandes where date_e between '$date' and '$date1' and evaluation<>'$encours' GROUP BY vendeur order by total DESC;";
	$users = db_query($database_name, $sql);
	
	
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Palmares Vendeurs $du au $au"; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th colspan="2"><?php echo "Vendeur";?></th>
	<th><?php echo "Net";?></th>
	<th colspan="2"><?php echo "Graphs de synthese";?></th>
	
</tr>

<?php $debit=0;$credit=0;$t=0;$s=0;$t=0;$tr1=0;$tr2=0;$tr3=0;$tr4=0;
while($users_ = fetch_array($users)) { $trimestre=$users_["trimestre"];$vendeur=$users_["vendeur"];

?><tr>
<?php $vendeur=$users_["vendeur"];?>
<? echo "<td><a href=\"palmares_details_vendeurs.php?vendeur=$vendeur&date=$date&date1=$date1\">$vendeur</a></td>";?>
<? echo "<td><a href=\"palmares_details_vendeurs_c.php?vendeur=$vendeur&date=$date&date1=$date1\">LISTE CLIENTS</a></td>";?>
<td align="right"><?php $t=$t+$users_["total"];echo number_format($users_["total"],2,',',' ');?></td>
<? if ($user_login=="rakia" or $user_login=="admin"){?>
<? echo "<td><a href=\"\\mps\\examples\\pie_evaluations_vendeurs_clients.php?date1=$date&date2=$date1&vendeur=$vendeur\"> Graph / Clients</a></td>";?>
<? echo "<td><a href=\"\\mps\\examples\\pie_evaluations_vendeurs_villes.php?date1=$date&date2=$date1&vendeur=$vendeur\"> Graph / Secteur</a></td>";?>
<? }?>
<?php } ?>
<tr>
<td></td>
<td align="right"><?php echo number_format($t,2,',',' ');?></td>
</tr>
</table>

<?php } ?>

<? if ($user_login=="rakia" or $user_login=="admin"){?>
<table>
<tr><? echo "<td><a href=\"\\mps\\examples\\pie_evaluations_vendeurs.php?date1=$date&date2=$date1\">Representation Graphique C.A</a></td>";?>
<tr><? echo "<td><a href=\"\\mps\\examples\\pie_evaluations_vendeurs_avoirs.php?date1=$date&date2=$date1\">Representation Graphique Avoirs</a></td>";?>
<tr><? echo "<td><a href=\"\\mps\\examples\\pie_evaluations_vendeurs_articles.php?date1=$date&date2=$date1\">Representation Graphique Articles</a></td>";?>

<? }?>

<p style="text-align:center">

</body>

</html>