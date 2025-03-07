<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$machine=$_GET["machine"];$du_f=$_GET["du"];$au_f=$_GET["au"];
	$sql  = "SELECT * ";$today=date("y-m-d");
	$sql .= "FROM details_maintenances where machine='$machine' and date between '$du_f' and '$au_f' group by date ORDER BY date;";
	$users = db_query($database_name, $sql);

	?>
	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Historique Entretien sur Machine $machine "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Historique Entretien sur $machine du $du_f au $au_f "; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Intervention";?></th>
	<th><?php echo "Operateur";?></th>
    <td width="180"><?php echo " Observations "; ?></td>
	<td width="180"><?php echo " Compteur "; ?></td>
       

</tr>
<?php $obs_g="";$jour=0;while($users_ = fetch_array($users)) { ?><tr>
<? $intervention = $users_["intervention"];$date = dateUsToFr($users_["date"]);$operateur = $users_["operateur"];
		$compteur = $users_["compteur"];
		$obs = $users_["obs"];
 $datep = dateUsToFr($users_["date"]);?>
<? echo "<td>$datep</td>";?>
<td style="text-align:center"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$intervention </font>"); ?></td>
<td style="text-align:center"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$operateur </font>"); ?></td>
<td style="text-align:center"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$obs </font>"); ?></td>
<td style="text-align:center"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$compteur </font>"); ?></td>

<?php } ?>

</table>
<p style="text-align:center">

</body>

</html>