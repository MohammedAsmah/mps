<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$produit=$_GET["produit"];
	$sql  = "SELECT machine,produit,date,sum(prod_6_14) as t_prod_6_14,sum(prod_14_22) as t_prod_14_22,sum(prod_22_6) as t_prod_22_6,
	sum(temps_arret_h_1) as t_temps_arret_h1,sum(temps_arret_m_1) as t_temps_arret_m1,
	sum(temps_arret_h_2) as t_temps_arret_h2,sum(temps_arret_m_2) as t_temps_arret_m2,
	sum(temps_arret_h_3) as t_temps_arret_h3,sum(temps_arret_m_3) as t_temps_arret_m3,
	sum(rebut_1) as t_rebut1,sum(rebut_2) as t_rebut2,sum(rebut_3) as t_rebut3,sum(poids_1) as t_poids,
	sum(tc1) as t_tc1,sum(tc2) as t_tc2,sum(tc3) as t_tc3,sum(jour) as t_jour ";$today=date("y-m-d");
	$sql .= "FROM details_productions where produit='$produit' group by machine ORDER BY date DESC;";
	$users = db_query($database_name, $sql);

	?>
	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Historique Production $produit sur Machines "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Historique Production $produit sur Machines"; ?></span>

<table class="table2">

<tr>
        <td width="70"><?php echo " Machine "; ?></td>
        <td width="70"><?php echo " Prod 6-14 "; ?></td>
        <td width="70"><?php echo " Prod 14-22 "; ?></td>
        <td width="70"><?php echo " Prod 22-6 "; ?></td>
     
        <td width="70"><?php echo " Temps d'arrêt "; ?></td>
        <td width="70"><?php echo " Rebuts "; ?></td>
        
		 <td width="70"><?php echo " Moy 24h "; ?></td>
		 <td width="70"><?php echo " Dernier Poids "; ?></td>
		  <td width="70"><?php echo " Pèriode "; ?></td>
          <td width="70"><?php echo " Total Pro. "; ?></td>

</tr>
<?php $obs_g="";$jour=0;$ht=0;while($users_ = fetch_array($users)) { ?><tr>
<? $id_production=$id_production;$id=$users_["id"];$machine=$users_["machine"];$obs_machine=$users_["obs_machine"];$last_date=dateUsToFr($users_["date"]);
$p=$users_["machine"];$jour=$jour+1;$produit=$users_["produit"];$t_jour= $users_["t_jour"]; ?>
<? echo "<td><a href=\"productions_details_machines_articles1.php?machine=$machine&produit=$produit\">$machine  ----> $last_date</a></td>";?>
<td style="text-align:center"><?php $p1=intval($users_["t_prod_6_14"]/$t_jour);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$p1 </font>"); ?></td>
<td style="text-align:center"><?php $p2=intval($users_["t_prod_14_22"]/$t_jour);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$p2 </font>"); ?></td>
<td style="text-align:center"><?php $p3=intval($users_["t_prod_22_6"]/$t_jour);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$p3 </font>"); ?></td>
<td style="text-align:center"><?php $h= ($users_["t_temps_arret_h1"]+$users_["t_temps_arret_h2"]+$users_["t_temps_arret_h3"])/$t_jour;
$m=($users_["t_temps_arret_m1"]+$users_["t_temps_arret_m2"]+$users_["t_temps_arret_m3"])/$t_jour;
$h_m=$m/60;$h=$h+$h_m;$heure=number_format($h,2,',',' ');$ht=$ht+$h;$total= $users_["t_prod_22_6"]+$users_["t_prod_6_14"]+$users_["t_prod_14_22"];
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$heure </font>"); ?></td>
<td style="text-align:center"><?php $rebut= intval(($users_["t_rebut1"]+$users_["t_rebut2"]+$users_["t_rebut3"])/$t_jour);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$rebut </font>"); ?></td>
<td style="text-align:center"><?php $moy=intval($total/$t_jour);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$moy </font>"); ?></td>
<? echo "<td><a href=\"productions_details_machines_articles11.php?machine=$machine&produit=$produit\">Poids</a></td>";?>

<td style="text-align:center"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$t_jour jours </font>"); ?></td>
<td style="text-align:center"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"FF0000\">$total </font>"); ?></td>

<?php } ?>

</table>
<p style="text-align:center">

</body>

</html>