<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	$du="";$au="";$action="Recherche";$du1="";$au1="";
	
		if(isset($_REQUEST["action"])){}else{
		?>
	
	
	<form id="form" name="form" method="post" action="ca_par_valeur.php">
	<td><?php echo "Du : "; ?><input type="text" id="du" name="du" value="<?php echo $du; ?>" size="15"></td>
	<td><?php echo "Au : "; ?><input type="text" id="au" name="au" value="<?php echo $au; ?>" size="15"></td>
	<tr>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Factures"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "facture.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

	<?
	if(isset($_REQUEST["action"]))
	{
	 $du=dateFrToUs($_POST['du']);$au=dateFrToUs($_POST['au']);$du1=$_POST['du'];$au1=$_POST['au'];$inst="FACTURE EN INSTANCE";
	
	if ($du>"2017-12-31"){
	$sql  = "SELECT * ";
	$sql .= "FROM factures2018 where date_f between '$du' and '$au' and client<>'$inst' ORDER BY id;";
	$users = db_query($database_name, $sql);}
	
	if ($du>"2016-12-31" and $du<"2018-01-01"){
	$sql  = "SELECT * ";
	$sql .= "FROM factures where date_f between '$du' and '$au' and client<>'$inst' ORDER BY id;";
	$users = db_query($database_name, $sql);}

	if ($du<"2017-01-01"){
	$sql  = "SELECT * ";
	$sql .= "FROM factures2016 where date_f between '$du' and '$au' and client<>'$inst' ORDER BY id;";
	$users = db_query($database_name, $sql);}
?>



<span style="font-size:24px"><?php echo "Chiffre Affaires en Valeurs : $du1 au $au1"; ?></span> 

<table class="table2">

<tr>
	<th><?php echo "Numero";?></th>
	<th><?php echo "Date";?></th>
	<th width="200"><?php echo "Client";?></th>
	<th width="150"><?php echo "Montant";?></th>
</tr>

<?php $ca=0;while($users_ = fetch_array($users)) { ?><tr>

<? $client=$users_["client"];$id=$users_["id"];$f=$users_["numero"];$d=$users_["date_f"];?>

<td><?php $evaluation=$users_["evaluation"]; $client=$users_["client"];$user_id=$users_["id"];$facture=$users_["id"]+9040;
echo $facture;?></td>
<td><?php $date=dateUsToFr($users_["date_f"]);$d=dateUsToFr($users_["date_f"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?> </td>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];?>
<td align="right" width="150"><?php $ca=$ca+$users_["montant"];$m=number_format($users_["montant"],2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");
 ?></td>
<?php } ?>
<tr><td></td><td></td><td></td>
<td align="right"><?php $ca=number_format($ca,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ca </font>");?></td></tr>
</table>


<? }?>

<p style="text-align:center">


</body>

</html>