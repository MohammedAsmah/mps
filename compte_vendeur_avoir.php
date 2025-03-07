<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$client_r = $_REQUEST["client"];

		// extracts profile list
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	
--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo "Relevé En Compte / avoir client : ".$client_r." au ".date("d/m/Y"); ?></span>

<table class="table2"><tr><td style="text-align:center">

	<center>

	


<p style="text-align:center">

<center>


</center>


<?
	$sql  = "SELECT * ";$date_enc="2011-01-01";
	$sql .= "FROM commandes where client='$client_r' ORDER BY date_e;";
	$users = db_query($database_name, $sql);
?>
<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Ref";?></th>
	<th><?php echo "Montant Eval.";?></th>
	<th><?php echo "Encompte/avoir";?></th>
	
</tr>

<?php 
 
	
while($users_ = fetch_array($users)) { ?><tr>
<? $client=$users_["client"];$id=$users_["id"];$f=$users_["evaluation"];$d=dateUsToFr($users_["date_e"]);$net=$users_["net"];$encompte_avoir=$users_["encompte_avoir"];
if ($encompte_avoir<>0){
echo "<td align=\"left\">".$d."</td>";
echo "<td align=\"left\">".$f."</td>";
echo "<td align=\"right\">".number_format($net,2,',',' ')."</td>";
echo "<td align=\"right\">".number_format($encompte_avoir,2,',',' ')."</td>";

$solde = $solde + $encompte_avoir;
 }
 } 
echo "<tr><td></td><td></td><td></td><td align=\"right\">".number_format($solde,2,',',' ')."</td>";
?>

</table>

</body>

</html>