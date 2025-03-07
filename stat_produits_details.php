<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
$valeur=3600;
set_time_limit($valeur);
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";

	$error_message = "";$caisse="";$action="Recherche";
	$produit=$_GET['produit'];;$date1="";$du="";$au="";
	
	
	
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

	
	<?
	
	$date=dateFrToUs($_GET['date']);$du=$_GET['date'];$date1=dateFrToUs($_GET['date1']);$au=$_GET['date1'];
	$du=$_GET['date'];$au=$_GET['date1'];$encours="encours";$t1=0;$t2=0;$t3=0;$t4=0;$q1=0;$q2=0;$q3=0;$q4=0;
	list($annee1,$mois1,$jour1) = explode('-', $date); 
	$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
	list($annee11,$mois11,$jour11) = explode('-', $date1); 
	$pau = mktime(0,0,0,$mois11,$jour11,$annee11); 
	$jour=date("d",$pdu);$mois=date("m",$pdu);$annee=date("Y",$pdu);
	$jour1=date("d",$pau);$mois1=date("m",$pau);$annee1=date("Y",$pau);
	$d1=$jour."/".$mois."/".$annee1;$d2=$jour1."/".$mois1."/".$annee1;
	$annee_1=$annee-1;$annee_2=$annee-2;$annee_3=$annee-3;$annee_0=$annee-0;
	$d1_exe_1=$annee_1."-".$mois."-".$jour;$d2_exe_1=$annee_1."-".$mois1."-".$jour1;
	$d1_exe_2=$annee_2."-".$mois."-".$jour;$d2_exe_2=$annee_2."-".$mois1."-".$jour1;
	$d1_exe_3=$annee_3."-".$mois."-".$jour;$d2_exe_3=$annee_3."-".$mois1."-".$jour1;
	
	?>
	
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Comparatif Article: ";$p=$produit."   "." PERIODE DU $jour/$mois  au  $jour1/$mois1";
print("<font size=\"4\" face=\"Comic sans MS\" color=\"FF0015\">$p </font>"); ?></span>

<p style="text-align:center">
	
<TABLE BORDER>
	<TR>
		<TH>ARTICLE</TH>
		<TH COLSPAN=4>VALEURS</TH>
		<TH COLSPAN=4>QUANTITES</TH>
	</TR>
	<TR>
		<TH></TH>
		<TH><? echo $annee;?></TH> <TH><? echo $annee_1;?></TH> <TH><? echo $annee_2;?></TH> <TH><? echo $annee_3;?></TH> 
		<TH><? echo $annee;?></TH> <TH><? echo $annee_1;?></TH> <TH><? echo $annee_2;?></TH> <TH><? echo $annee_3;?></TH> 
	</TR>
	

<?php 

$sql  = "SELECT client,vendeur,produit,sum(valeur1) As v1,sum(quantite1) As qte1,sum(valeur2) As v2,sum(quantite2) As qte2,sum(valeur3) As v3,sum(quantite3) As qte3,sum(valeur4) As v4,sum(quantite4) As qte4 ";
	$sql .= "FROM stat_produits where produit='$produit' GROUP BY produit;";
	$users_t = db_query($database_name, $sql);$total1=0;$total2=0;$total3=0;$total4=0;
	
	while($users_tt = fetch_array($users_t)) {
		$total1=$total1+$users_tt["v1"];$total2=$total2+$users_tt["v2"];$total3=$total3+$users_tt["v3"];$total4=$total4+$users_tt["v4"];
	}




	$sql  = "SELECT client,vendeur,produit,sum(valeur1) As v1,sum(quantite1) As qte1,sum(valeur2) As v2,sum(quantite2) As qte2,sum(valeur3) As v3,sum(quantite3) As qte3,sum(valeur4) As v4,sum(quantite4) As qte4 ";
	$sql .= "FROM stat_produits where produit='$produit' GROUP BY vendeur;";
	$users = db_query($database_name, $sql);
	
	while($users_ = fetch_array($users)) {
	$vendeur=$users_["vendeur"];
	
?><tr>
<td align="left" WIDTH="20%"><?php echo $vendeur;?></td>
<td align="right" WIDTH="12%"><?php echo number_format($users_["v1"],2,',',' ');$t1=$t1+$users_["v1"];@$p=$users_["v1"]/$total1*100;
echo "<br>";$p=number_format($p,2,',',' ')." %";print("<font size=\"3\" face=\"Comic sans MS\" color=\"FF0015\">$p </font>"); ?></td>
<td align="right" WIDTH="12%"><?php echo number_format($users_["v2"],2,',',' ');$t2=$t2+$users_["v2"];@$p=$users_["v2"]/$total2*100;
echo "<br>";$p=number_format($p,2,',',' ')." %";print("<font size=\"3\" face=\"Comic sans MS\" color=\"FF0015\">$p </font>"); ?></td>
<td align="right" WIDTH="12%"><?php echo number_format($users_["v3"],2,',',' ');$t3=$t3+$users_["v3"];@$p=$users_["v3"]/$total3*100;
echo "<br>";$p=number_format($p,2,',',' ')." %";print("<font size=\"3\" face=\"Comic sans MS\" color=\"FF0015\">$p </font>"); ?></td>
<td align="right" WIDTH="12%"><?php echo number_format($users_["v4"],2,',',' ');$t4=$t4+$users_["v4"];@$p=$users_["v4"]/$total4*100;
echo "<br>";$p=number_format($p,2,',',' ')." %";print("<font size=\"3\" face=\"Comic sans MS\" color=\"FF0015\">$p </font>");?></td>
<td align="right" WIDTH="8%"><?php echo $users_["qte1"];$q1=$q1+$users_["qte1"];?></td>
<td align="right" WIDTH="8%"><?php echo $users_["qte2"];$q2=$q2+$users_["qte2"];?></td>
<td align="right" WIDTH="8%"><?php echo $users_["qte3"];$q3=$q3+$users_["qte3"];?></td>
<td align="right" WIDTH="8%"><?php echo $users_["qte4"];$q4=$q4+$users_["qte4"];?></td>
<?php }  ?>
<tr><td align="right"><?php echo "Totaux : ";?></td>
<td align="right"><?php echo number_format($t1,2,',',' ');?></td>
<td align="right"><?php echo number_format($t2,2,',',' ');?></td>
<td align="right"><?php echo number_format($t3,2,',',' ');?></td>
<td align="right"><?php echo number_format($t4,2,',',' ');?></td>
<td align="right"><?php ?></td>
<td align="right"><?php ?></td>
<td align="right"><?php ?></td>
<td align="right"><?php ?></td>
</table>


<p style="text-align:center">
<? echo "<table><td><a href=\"\\mps\\examples\\graph_variation_ca.php?ca1=$t4&ca2=$t3&ca3=$t2&ca4=$t1&produit=$produit\"> Graph</a></td></table>";?>
</body>

</html>