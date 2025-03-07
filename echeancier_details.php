<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
	
	
<?			
	
	$du1=date("d/m/Y");$date=date("Y-m-d");$fin_exe="2010-12-31";
	$sql  = "SELECT * ";$mois = $_GET["mois"];
	$sql .= "FROM echeances_credits where month(date_echeance)='$mois' and date_echeance<='$fin_exe' and date_echeance>='$date' order BY date_echeance;";
	$users = db_query($database_name, $sql);
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Echeancier Au ".$du1; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Designation";?></th>
	<th><?php echo "Montant";?></th>
</tr>

<?php $t=0;
while($users_ = fetch_array($users)) { ?><tr>
<? $id_credit=$users_["id_credit"];
	$sql  = "SELECT * ";
	$sql .= "FROM credits where id>='$id_credit' order BY id;";
	$users1 = db_query($database_name, $sql);$user_ = fetch_array($users1);
	$designation = $user_["designation"];

?>
<td align="left"><?php echo dateUsToFr($users_["date_echeance"]);?></td>
<td align="left"><?php echo $designation;?>
<td align="right"><?php $t=$t+$users_["montant_echeance"];echo number_format($users_["montant_echeance"],2,',',' ');?></td>
<?php } ?>
<tr>
<td></td><td></td>
<td align="right"><?php echo number_format($t,2,',',' ');?></td>
</table>

<p style="text-align:center">

</body>

</html>