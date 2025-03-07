<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";
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
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	
	$id_registre=$_GET['id_registre'];$total_e=0;$total_c=0;$total_t=0;$evaluation=$_GET['evaluation'];
	$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles where evaluation='$evaluation' Order BY id;";
	$users11 = db_query($database_name, $sql);
?>


<span style="font-size:24px"><?php echo "Tableau Encaissement "; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo "Tableau";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Montant encaissé";?></th>

</tr>

<?php $compteur1=0;$total_g=0;$t_espece=0;
while($users_1 = fetch_array($users11)) { 
			$client=$users_1["client"];$date_enc=$users_1["date_enc"];?>
			<tr>
			<td><?php echo $client; ?></td>
			<td><?php echo $users_1["id_registre_regl"]; ?></td>
			<td align="right"><?php echo dateUsToFr($date_enc); ?></td>
			<td><?php echo $users_1["m_cheque"]+$users_1["m_espece"]+$users_1["m_effet"]; ?></td>
<? } ?>
</table>


</body>

</html>