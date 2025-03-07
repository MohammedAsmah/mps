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
	
	$du1=date("d/m/Y");$date=date("Y-m-d");$fin_exe="2010-12-31";$user_id = $_REQUEST["user_id"];

		$sql  = "SELECT * ";
		$sql .= "FROM credits WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$designation = $user_["designation"];$date_obtention = dateUsToFr($user_["date_obtention"]);$date_debut = dateUsToFr($user_["date_debut"]);
		$montant_echeance = $user_["montant_echeance"];$echeance = $user_["echeance"];
		$montant = $user_["montant"];$nbr_echeances = $user_["nbr_echeances"];
		$date_fin = dateUsToFr($user_["date_fin"]);$banque = $user_["banque"];

	$sql  = "SELECT montant_echeance,date_echeance ";
	$sql .= "FROM echeances_credits where id_credit=$user_id order BY date_echeance;";
	$users = db_query($database_name, $sql);
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Tableau $designation "; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Echeance";?></th>
	<th><?php echo "Montant";?></th>
</tr>

<?php $debit=0;$credit=0;$m=0;
while($users_ = fetch_array($users)) { ?><tr>
<td><? echo dateUsToFr($users_["date_echeance"]);?></td>
<td align="right"><?php $m=$m+$users_["montant_echeance"];echo number_format($users_["montant_echeance"],2,',',' ');?></td>
<?php } ?></tr>

<tr><td></td>
<td align="right"><?php echo number_format($m,2,',',' ');?></td>

</table>

<p style="text-align:center">

</body>

</html>