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
	$sql  = "SELECT machine,produit,date,sum(prod_6_14) as t_prod_6_14,sum(prod_14_22) as t_prod_14_22,sum(prod_22_6) as t_prod_22_6,
	sum(temps_arret_h_1) as t_temps_arret_h1,sum(temps_arret_m_1) as t_temps_arret_m1,
	sum(temps_arret_h_2) as t_temps_arret_h2,sum(temps_arret_m_2) as t_temps_arret_m2,
	sum(temps_arret_h_3) as t_temps_arret_h3,sum(temps_arret_m_3) as t_temps_arret_m3,
	sum(rebut_1) as t_rebut1,sum(rebut_2) as t_rebut2,sum(rebut_3) as t_rebut3,sum(poids_1) as t_poids,
	sum(tc1) as t_tc1,sum(tc2) as t_tc2,sum(tc3) as t_tc3 ";$today=date("y-m-d");
	$sql .= "FROM details_productions where machine='$machine' and date between '$du_f' and '$au_f' group by produit ORDER BY date;";
	$users = db_query($database_name, $sql);

	?>
	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Historique Production sur Machine $machine "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "historique Production sur $machine du $du_f au $au_f "; ?></span>

<table class="table2">

<tr>
        <td width="70"><?php echo " Produit "; ?></td>
        <td width="70"><?php echo " Prod 6-14 "; ?></td>
        <td width="70"><?php echo " Prod 14-22 "; ?></td>
        <td width="70"><?php echo " Prod 22-6 "; ?></td>
        <td width="70"><?php echo " Total "; ?></td>
        <td width="70"><?php echo " Temps d'arrêt "; ?></td>
        <td width="70"><?php echo " Rebuts "; ?></td>
        <td width="70"><?php echo " Poids "; ?></td>
       

</tr>
<?php $obs_g="";$jour=0;while($users_ = fetch_array($users)) { ?><tr>
<? $id_production=$id_production;$id=$users_["id"];$machine=$users_["machine"];$obs_machine=$users_["obs_machine"];
$p=$users_["produit"];$jour=$jour+1; ?>
<? echo "<td><a href=\"productions_details_machines_articles.php?machine=$machine&produit=$p\">$p</a></td>";?>
<td style="text-align:center"><?php $p1=$users_["t_prod_6_14"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$p1 </font>"); ?></td>
<td style="text-align:center"><?php $p2= $users_["t_prod_14_22"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$p2 </font>"); ?></td>
<td style="text-align:center"><?php $p3= $users_["t_prod_22_6"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$p3 </font>"); ?></td>
<td style="text-align:center"><?php $total= $users_["t_prod_22_6"]+$users_["t_prod_6_14"]+$users_["t_prod_14_22"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"FF0000\">$total </font>"); ?></td>
<td style="text-align:center"><?php $h= $users_["t_temps_arret_h1"]+$users_["t_temps_arret_h2"]+$users_["t_temps_arret_h3"];
$m=$users_["t_temps_arret_m1"]+$users_["t_temps_arret_m2"]+$users_["t_temps_arret_m3"];
$h_m=$m/60;$h=$h+$h_m;
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$h </font>"); ?></td>
<td style="text-align:center"><?php $rebut= $users_["t_rebut1"]+$users_["t_rebut2"]+$users_["t_rebut3"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$rebut </font>"); ?></td>
<td style="text-align:center"><?php $poids= $users_["t_poids"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$poids </font>"); ?></td>

<?php } ?>

</table>
<p style="text-align:center">

</body>

</html>