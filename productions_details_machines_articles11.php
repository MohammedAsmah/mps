<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$machine=$_GET["machine"];$produit=$_GET["produit"];
	$sql  = "SELECT machine,produit,date,sum(prod_6_14) as t_prod_6_14,sum(prod_14_22) as t_prod_14_22,sum(prod_22_6) as t_prod_22_6,
	sum(temps_arret_h_1) as t_temps_arret_h,sum(temps_arret_m_1) as t_temps_arret_m,sum(rebut_1) as t_rebut1,
	sum(rebut_2) as t_rebut2,sum(rebut_3) as t_rebut3,sum(poids_1) as t_poids,sum(poids_2) as t_poids2,sum(poids_3) as t_poids3,
	sum(tc1) as t_tc1,sum(tc2) as t_tc2,sum(tc3) as t_tc3 ";$today=date("y-m-d");
	$sql .= "FROM details_productions where machine='$machine' and produit='$produit' and (poids_1<>0 or poids_2<>0 or poids_3<>0) group by id ORDER BY date;";
	$users = db_query($database_name, $sql);

	?>
	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Historique Production $produit sur Machine $machine "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Historique Production $produit sur $machine"; ?></span>

<table class="table2">

<tr>
        <td width="70"><?php echo " Date "; ?></td>
        <td width="70"><?php echo " Poids 6-14 "; ?></td>
        <td width="70"><?php echo " Poids 14-22 "; ?></td>
        <td width="70"><?php echo " Poids 22-6 "; ?></td>
        
       

</tr>
<?php $obs_g="";$tr=0;while($users_ = fetch_array($users)) { ?><tr>
<? 
$tableau = array(); 
$tableau[] = intval($users_["t_prod_6_14"]); $du1_c=dateUsToFr($users_["date"]);
$id_production=$id_production;$id=$users_["id"];$machine=$users_["machine"];$obs_machine=$users_["obs_machine"];?>
<td style="text-align:left"><?php $d=dateUsToFr($users_["date"]); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>");?></td>
<td style="text-align:center"><?php $p1=$users_["t_poids"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$p1 </font>"); ?></td>
<td style="text-align:center"><?php $p2= $users_["t_poids2"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$p2 </font>"); ?></td>
<td style="text-align:center"><?php $p3= $users_["t_poids3"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$p3 </font>"); ?></td>


<?php 




} ?>

</table>
<p style="text-align:center">



</body>

</html>