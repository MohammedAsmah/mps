  <?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
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

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "facture.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo ""; ?></span>

<?
	$date1="";$date2="";$action="Recherche";

	?>
	
	<form id="form" name="form" method="post" action="releves_encaiss_cheques_com.php">
	<td><?php echo "Du : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au : "; ?><input onClick="ds_sh(this);" name="date2" value="<?php echo $date2; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<?



	if(isset($_REQUEST["action"]))
	{
	$date1=dateFrToUs($_POST['date1']);$date2=dateFrToUs($_POST['date2']);
	$date_d1=dateFrToUs($_POST['date1']);$date_d2=dateFrToUs($_POST['date2']);
	$de1=$_POST['date1'];$de2=$_POST['date2'];
		
	/*$sql  = "SELECT * ";
	$sql .= "FROM factures where date_f between '$date1' and '$date2' ORDER BY id;";
	$users = db_query($database_name, $sql);*/
?>

<p></p>
<tr><? echo "<td><a href=\"\\mps\\tutorial\\releve_encaiss_cheques_com.php?date1=$date_d1&date2=$date_d2\">Imprimer Etat 1</a></td>";?>
</tr>
<tr><? /*echo "<td><a href=\"\\mps\\tutorial\\releve_encaiss_cheques_regroupe.php?date1=$date_d1&date2=$date_d2\">Imprimer Etat 2</a></td>";*/?>
</tr>
<? } ?>
<p style="text-align:center">

</body>

</html>
