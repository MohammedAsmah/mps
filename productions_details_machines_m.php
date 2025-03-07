<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$machine=$_GET["machine"];
	$sql  = "SELECT machine,produit,date,obs_machine_1,obs_machine_2,obs_machine_3,sum(prod_6_14) as t_prod_6_14,sum(prod_14_22) as t_prod_14_22,sum(prod_22_6) as t_prod_22_6,
	sum(temps_arret_h_1) as t_temps_arret_h,sum(temps_arret_m_1) as t_temps_arret_m,sum(rebut_1) as t_rebut,sum(poids_1) as t_poids,
	sum(tc1) as t_tc1,sum(tc2) as t_tc2,sum(tc3) as t_tc3 ";$today=date("y-m-d");
	$sql .= "FROM details_productions where machine='$machine' group by id ORDER BY date;";
	$users = db_query($database_name, $sql);

	?>
	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Historique Maintenance Sur Machine $machine "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Historique Maintenance Sur Machine $machine "; ?></span>

<table class="table2">

<tr>
        <td width="70"><?php echo " Date "; ?></td>
        <td width="70"><?php echo " Temps d'arrêt "; ?></td>
        <td width="70"><?php echo " Observations "; ?></td>
        

</tr>
<?php $obs_g="";while($users_ = fetch_array($users)) { ?><tr>
<? $id_production=$id_production;$id=$users_["id"];$machine=$users_["machine"];
$obs_machine=$users_["obs_machine_1"]." ".$users_["obs_machine_2"]." ".$users_["obs_machine_3"];?>
<td style="text-align:left"><?php $d=dateUsToFr($users_["date"]); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>");?></td>
<td style="text-align:center"><?php $t= $users_["t_temps_arret_h"].":".$users_["t_temps_arret_m"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t </font>"); ?></td>
<td style="text-align:center"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$obs_machine </font>"); ?></td>

<?php } ?>

</table>
<p style="text-align:center">

</body>

</html>