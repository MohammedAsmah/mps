<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$type="effets_aa";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	 //if
	$du1=date("d/m/Y");$date=date("Y-m-d");$av=1;
	$sql1  = "SELECT * ";$bcp="bcp";
	$sql1 .= "FROM rs_data_banques where banque='$bcp' ORDER BY banque;";
	$users1 = db_query($database_name, $sql1);$users_1 = fetch_array($users1);
	$oc=$users_1["oc"];$av=$users_1["av"];
	
	$sql  = "SELECT * ";
	$sql .= "FROM credits where type='$type' and av=1 and date_debut>='$date' ORDER BY date_debut;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php  ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "effet_oc.php?user_id=" + user_id; }
	function EditUser1(user_id) { document.location = "echeancier_credit.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php  ?></span>

<table class="table2">
<tr>
	<th><?php echo "Ligne Effets Avalises au : ".$du1;?></th>

<tr>
	<th><?php echo "Designation";?></th>
	<th><?php echo "Montant";?></th>

	<th style="width:50px" align="center"><?php echo "Echeance";?></th>
	<th><?php echo "Cumuls";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { $color=$users_["color"];?><tr>

<td style="width:150px"><?php $des=$users_["designation"];print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$des </font>");?></td>
<td align="right"><?php $me=$users_["montant_echeance"];$me=number_format($me,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$me </font>"); ?></td>

<td style="width:50px" align="center"><?php $d= dateUsToFr($users_["date_debut"]);print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$d </font>"); ?></td>
<td align="right"><?php $total=$total+$users_["montant_echeance"];$t= number_format($total,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$t </font>"); ?></td>

<?php } ?>
<tr>
<td></td><td></td><td style="width:50px" align="center"><?php $la= "Ligne Aval : ";print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$la </font>");?></td>
<td align="right"><?php $ligne=$av;$l= number_format($ligne,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$l </font>"); ?></td>
<tr><td></td><td></td><td style="width:50px" align="center"><?php $so= "Solde Autorisation ";print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$so </font>");?></td>
<td align="right"><?php $s= number_format($ligne-$total,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$s </font>"); ?></td>
</table>


<tr>
</tr>

</body>

</html>