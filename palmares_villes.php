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
	<form id="form" name="form" method="post" action="palmares_villes.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{
	
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];
	$du=$_POST['date'];$au=$_POST['date1'];$encours="encours";

	$sql  = "SELECT ville,commande,client,vendeur,date,sum(net) As total ";
	$sql .= "FROM commandes where date_e between '$date' and '$date1' and evaluation<>'$encours' GROUP BY ville order by total DESC;";
	$users = db_query($database_name, $sql);
	
	
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Palmares Villes $du au $au"; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Ville";?></th>
	<th><?php echo "Net";?></th>
</tr>

<?php $debit=0;$credit=0;$t=0;$s=0;$t=0;
while($users_ = fetch_array($users)) { ?><tr>
<? $ville=$users_["ville"];$bs= "<td>$ville</a>";
print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$bs </font>");?>
<td align="right"><?php $t=$t+$users_["total"];echo number_format($users_["total"],2,',',' ');?></td>
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