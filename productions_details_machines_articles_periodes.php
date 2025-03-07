<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$machine=$_POST["machine"];$produit=$_POST["produit"];
	$du=dateFrToUs($_POST["du"]);$au=dateFrToUs($_POST["au"]);
	$du1=$_POST["du"];$au1=$_POST["au"];
	$sql  = "SELECT machine,produit,date,sum(prod_6_14) as t_prod_6_14,sum(prod_14_22) as t_prod_14_22,sum(prod_22_6) as t_prod_22_6,
	sum(temps_arret_h_1) as t_temps_arret_h,sum(temps_arret_m_1) as t_temps_arret_m,sum(rebut_1) as t_rebut1,
	sum(rebut_2) as t_rebut2,sum(rebut_3) as t_rebut3,sum(poids_1) as t_poids,
	sum(tc1) as t_tc1,sum(tc2) as t_tc2,sum(tc3) as t_tc3 ";$today=date("y-m-d");
	$sql .= "FROM details_productions where machine='$machine' and produit='$produit' and date between '$du' and '$au' group by id ORDER BY date;";
	$users = db_query($database_name, $sql);

	?>
	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo " "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "$produit / $machine du $du1 au $au1"; ?></span>

<table class="table2">

<tr>
        <td width="70"><?php echo " Date "; ?></td>
        <td width="70"><?php echo " Prod 6-14 "; ?></td>
        <td width="70"><?php echo " Prod 14-22 "; ?></td>
        <td width="70"><?php echo " Prod 22-6 "; ?></td>
        <td width="70"><?php echo " Total "; ?></td>
        <td width="70"><?php echo " Rebuts "; ?></td>
       

</tr>
<?php $obs_g="";$tr=0;while($users_ = fetch_array($users)) { ?><tr>
<? 
$tableau = array(); 
$tableau[] = intval($users_["t_prod_6_14"]); 
$id_production=$id_production;$id=$users_["id"];$machine1=$users_["machine"];$obs_machine=$users_["obs_machine"];?>
<td style="text-align:left"><?php $d=dateUsToFr($users_["date"]); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>");?></td>
<td style="text-align:center"><?php $p1=$users_["t_prod_6_14"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$p1 </font>"); ?></td>
<td style="text-align:center"><?php $p2= $users_["t_prod_14_22"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$p2 </font>"); ?></td>
<td style="text-align:center"><?php $p3= $users_["t_prod_22_6"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$p3 </font>"); ?></td>
<td style="text-align:center"><?php $total= $users_["t_prod_22_6"]+$users_["t_prod_6_14"]+$users_["t_prod_14_22"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"FF0000\">$total </font>"); ?></td>
<td style="text-align:center"><?php $rebut= $users_["t_rebut1"]+$users_["t_rebut2"]+$users_["t_rebut3"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$rebut </font>"); ?></td>


<?php $tr=$tr+$rebut;$pro=$pro+$total;} ?>
<tr><td></td><td></td><td></td><td></td>
<td style="text-align:center"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"FF0000\">$pro </font>"); ?></td>
<td style="text-align:center"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tr </font>"); ?></td>

</table>
<p style="text-align:center">
<table class="table2">
<tr><? echo "<td><a href=\"\\mps\\examples\\graph_production_par_periode.php?du=$du&au=$au&produit=$produit&machine=$machine\">Representation Graphique Production</a></td>";?>
<tr><? echo "<td><a href=\"\\mps\\examples\\graph_rebus_par_periode.php?du=$du&au=$au&produit=$produit&machine=$machine\">Representation Graphique Rebuts</a></td>";?>
</table>

</body>

</html>