<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
$valeur=3600;
set_time_limit($valeur);
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";

	$error_message = "";$caisse="";$action="Recherche";$date="";$date1="";$du="";$au="";
	$sql = "TRUNCATE TABLE `stat_produits`  ;";
			db_query($database_name, $sql);
	
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$profiles_list_vendeur="";
	$sql1 = "SELECT * FROM vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_vendeur .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$profiles_list_vendeur .= $temp_["vendeur"];
		$profiles_list_vendeur .= "</OPTION>";
	}

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
	
			if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="balance_evaluations_comparatif_articles.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" />
	<td><?php echo "Vendeur: "; ?></td><td><select id="vendeur" name="vendeur"><?php echo $profiles_list_vendeur; ?></select></td>
	
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{
	
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];$vendeur=$_POST['vendeur'];
	$du=$_POST['date'];$au=$_POST['date1'];$encours="encours";$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$q1=0;$q2=0;$q3=0;$q4=0;$q5=0;
	list($annee1,$mois1,$jour1) = explode('-', $date); 
	$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
	list($annee11,$mois11,$jour11) = explode('-', $date1); 
	$pau = mktime(0,0,0,$mois11,$jour11,$annee11); 
	$jour=date("d",$pdu);$mois=date("m",$pdu);$annee=date("Y",$pdu);
	$jour1=date("d",$pau);$mois1=date("m",$pau);$annee1=date("Y",$pau);
	$d1=$jour."/".$mois."/".$annee1;$d2=$jour1."/".$mois1."/".$annee1;
	$annee_1=$annee-1;$annee_2=$annee-2;$annee_3=$annee-3;$annee_0=$annee-0;$annee_4=$annee-4;
	$d1_exe_1=$annee_1."-".$mois."-".$jour;$d2_exe_1=$annee_1."-".$mois1."-".$jour1;
	$d1_exe_2=$annee_2."-".$mois."-".$jour;$d2_exe_2=$annee_2."-".$mois1."-".$jour1;
	$d1_exe_3=$annee_3."-".$mois."-".$jour;$d2_exe_3=$annee_3."-".$mois1."-".$jour1;
	$d1_exe_4=$annee_4."-".$mois."-".$jour;$d2_exe_4=$annee_4."-".$mois1."-".$jour1;
	
	?>
	
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Comparatif Articles  $jour/$mois  au  $jour1/$mois1 ====> $vendeur"; ?></span>

<p style="text-align:center">
	
<TABLE BORDER>
	<TR>
		<TH>ARTICLE</TH>
		<TH COLSPAN=4>VALEURS</TH>
		<TH COLSPAN=4>QUANTITES</TH>
	</TR>
	<TR>
		<TH></TH>
		<TH><? echo $annee;?></TH> <TH><? echo $annee_1;?></TH> <TH><? echo $annee_2;?></TH> <TH><? echo $annee_3;?></TH><TH><? echo $annee_4;?></TH>  
		<TH><? echo $annee;?></TH> <TH><? echo $annee_1;?></TH> <TH><? echo $annee_2;?></TH> <TH><? echo $annee_3;?></TH> <TH><? echo $annee_4;?></TH>
	</TR>
	


	

	<? 
	if ($vendeur==""){
	$sql  = "SELECT produit,client,vendeur,date,sum(valeur) As total_net,sum(quantite) As total_quantite ";
	$sql .= "FROM detail_commandes where date between '$date' and '$date1' and escompte_exercice=0 GROUP BY vendeur,produit;";
	$users = db_query($database_name, $sql);
	while($users_v1 = fetch_array($users)) {$produit=$users_v1["produit"];$valeur1=$users_v1["total_net"];$quantite1=$users_v1["total_quantite"];
	$client=$users_v1["client"];$vendeur=$users_v1["vendeur"];
		$sql  = "INSERT INTO stat_produits ( client,vendeur,produit, valeur1,quantite1,du,au ) VALUES ( ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $valeur1 . "', ";
				$sql .= "'" . $quantite1 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= $date1 . ");";
				db_query($database_name, $sql);
	}
	
	$sql  = "SELECT produit,client,vendeur,date,sum(valeur) As total_net,sum(quantite) As total_quantite ";
	$sql .= "FROM detail_commandes where date between '$d1_exe_1' and '$d2_exe_1' and escompte_exercice=0  GROUP BY vendeur,produit;";
	$users1 = db_query($database_name, $sql);
	while($users_v1 = fetch_array($users1)) {$produit=$users_v1["produit"];$valeur1=$users_v1["total_net"];$quantite1=$users_v1["total_quantite"];
	$client=$users_v1["client"];$vendeur=$users_v1["vendeur"];
		$sql  = "INSERT INTO stat_produits ( client,vendeur,produit, valeur2,quantite2,du,au ) VALUES ( ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $valeur1 . "', ";
				$sql .= "'" . $quantite1 . "', ";
				$sql .= "'" . $d1_exe_1 . "', ";
				$sql .= $d2_exe_1 . ");";
				db_query($database_name, $sql);
	}
	
	$sql  = "SELECT produit,client,vendeur,date,sum(valeur) As total_net,sum(quantite) As total_quantite ";
	$sql .= "FROM detail_commandes where date between '$d1_exe_2' and '$d2_exe_2' and escompte_exercice=0 GROUP BY vendeur,produit;";
	$users2 = db_query($database_name, $sql);
	while($users_v1 = fetch_array($users2)) {$produit=$users_v1["produit"];$valeur1=$users_v1["total_net"];$quantite1=$users_v1["total_quantite"];
	$client=$users_v1["client"];$vendeur=$users_v1["vendeur"];
		$sql  = "INSERT INTO stat_produits ( client,vendeur,produit, valeur3,quantite3,du,au ) VALUES ( ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $valeur1 . "', ";
				$sql .= "'" . $quantite1 . "', ";
				$sql .= "'" . $d1_exe_2 . "', ";
				$sql .= $d2_exe_2 . ");";
				db_query($database_name, $sql);
	}
	
	$sql  = "SELECT produit,client,vendeur,date,sum(valeur) As total_net,sum(quantite) As total_quantite ";
	$sql .= "FROM detail_commandes where date between '$d1_exe_3' and '$d2_exe_3' and escompte_exercice=0 GROUP BY vendeur,produit;";
	$users3 = db_query($database_name, $sql);
	while($users_v1 = fetch_array($users3)) {$produit=$users_v1["produit"];$valeur1=$users_v1["total_net"];$quantite1=$users_v1["total_quantite"];
	$client=$users_v1["client"];$vendeur=$users_v1["vendeur"];
		$sql  = "INSERT INTO stat_produits ( client,vendeur,produit, valeur4,quantite4,du,au ) VALUES ( ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $valeur1 . "', ";
				$sql .= "'" . $quantite1 . "', ";
				$sql .= "'" . $d1_exe_3 . "', ";
				$sql .= $d2_exe_3 . ");";
				db_query($database_name, $sql);
	}
	
	$sql  = "SELECT produit,client,vendeur,date,sum(valeur) As total_net,sum(quantite) As total_quantite ";
	$sql .= "FROM detail_commandes where date between '$d1_exe_4' and '$d2_exe_4' and escompte_exercice=0 GROUP BY vendeur,produit;";
	$users3 = db_query($database_name, $sql);
	while($users_v1 = fetch_array($users3)) {$produit=$users_v1["produit"];$valeur1=$users_v1["total_net"];$quantite1=$users_v1["total_quantite"];
	$client=$users_v1["client"];$vendeur=$users_v1["vendeur"];
		$sql  = "INSERT INTO stat_produits ( client,vendeur,produit, valeur5,quantite5,du,au ) VALUES ( ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $valeur1 . "', ";
				$sql .= "'" . $quantite1 . "', ";
				$sql .= "'" . $d1_exe_4 . "', ";
				$sql .= $d2_exe_4 . ");";
				db_query($database_name, $sql);
	}
	
	
	
	}else
	{
	$sql  = "SELECT produit,client,vendeur,date,sum(valeur) As total_net,sum(quantite) As total_quantite ";
	$sql .= "FROM detail_commandes where date between '$date' and '$date1' and vendeur='$vendeur' and escompte_exercice=0 GROUP BY vendeur,produit;";
	$users = db_query($database_name, $sql);
	while($users_v1 = fetch_array($users)) {$produit=$users_v1["produit"];$valeur1=$users_v1["total_net"];$quantite1=$users_v1["total_quantite"];
	$client=$users_v1["client"];$vendeur=$users_v1["vendeur"];
		$sql  = "INSERT INTO stat_produits ( client,vendeur,produit, valeur1,quantite1,du,au ) VALUES ( ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $valeur1 . "', ";
				$sql .= "'" . $quantite1 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= $date1 . ");";
				db_query($database_name, $sql);
	}
	
	$sql  = "SELECT produit,client,vendeur,date,sum(valeur) As total_net,sum(quantite) As total_quantite ";
	$sql .= "FROM detail_commandes where date between '$d1_exe_1' and '$d2_exe_1' and vendeur='$vendeur' and escompte_exercice=0  GROUP BY vendeur,produit;";
	$users1 = db_query($database_name, $sql);
	while($users_v1 = fetch_array($users1)) {$produit=$users_v1["produit"];$valeur1=$users_v1["total_net"];$quantite1=$users_v1["total_quantite"];
	$client=$users_v1["client"];$vendeur=$users_v1["vendeur"];
		$sql  = "INSERT INTO stat_produits ( client,vendeur,produit, valeur2,quantite2,du,au ) VALUES ( ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $valeur1 . "', ";
				$sql .= "'" . $quantite1 . "', ";
				$sql .= "'" . $d1_exe_1 . "', ";
				$sql .= $d2_exe_1 . ");";
				db_query($database_name, $sql);
	}
	
	$sql  = "SELECT produit,client,vendeur,date,sum(valeur) As total_net,sum(quantite) As total_quantite ";
	$sql .= "FROM detail_commandes where date between '$d1_exe_2' and '$d2_exe_2' and vendeur='$vendeur' and escompte_exercice=0 GROUP BY vendeur,produit;";
	$users2 = db_query($database_name, $sql);
	while($users_v1 = fetch_array($users2)) {$produit=$users_v1["produit"];$valeur1=$users_v1["total_net"];$quantite1=$users_v1["total_quantite"];
	$client=$users_v1["client"];$vendeur=$users_v1["vendeur"];
		$sql  = "INSERT INTO stat_produits ( client,vendeur,produit, valeur3,quantite3,du,au ) VALUES ( ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $valeur1 . "', ";
				$sql .= "'" . $quantite1 . "', ";
				$sql .= "'" . $d1_exe_2 . "', ";
				$sql .= $d2_exe_2 . ");";
				db_query($database_name, $sql);
	}
	
	$sql  = "SELECT produit,client,vendeur,date,sum(valeur) As total_net,sum(quantite) As total_quantite ";
	$sql .= "FROM detail_commandes where date between '$d1_exe_3' and '$d2_exe_3' and vendeur='$vendeur' and escompte_exercice=0 GROUP BY vendeur,produit;";
	$users3 = db_query($database_name, $sql);
	while($users_v1 = fetch_array($users3)) {$produit=$users_v1["produit"];$valeur1=$users_v1["total_net"];$quantite1=$users_v1["total_quantite"];
	$client=$users_v1["client"];$vendeur=$users_v1["vendeur"];
		$sql  = "INSERT INTO stat_produits ( client,vendeur,produit, valeur4,quantite4,du,au ) VALUES ( ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $valeur1 . "', ";
				$sql .= "'" . $quantite1 . "', ";
				$sql .= "'" . $d1_exe_3 . "', ";
				$sql .= $d2_exe_3 . ");";
				db_query($database_name, $sql);
	}
	
	$sql  = "SELECT produit,client,vendeur,date,sum(valeur) As total_net,sum(quantite) As total_quantite ";
	$sql .= "FROM detail_commandes where date between '$d1_exe_4' and '$d2_exe_4' and escompte_exercice=0 and vendeur='$vendeur' GROUP BY vendeur,produit;";
	$users3 = db_query($database_name, $sql);
	while($users_v1 = fetch_array($users3)) {$produit=$users_v1["produit"];$valeur1=$users_v1["total_net"];$quantite1=$users_v1["total_quantite"];
	$client=$users_v1["client"];$vendeur=$users_v1["vendeur"];
		$sql  = "INSERT INTO stat_produits ( client,vendeur,produit, valeur5,quantite5,du,au ) VALUES ( ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $valeur1 . "', ";
				$sql .= "'" . $quantite1 . "', ";
				$sql .= "'" . $d1_exe_4 . "', ";
				$sql .= $d2_exe_4 . ");";
				db_query($database_name, $sql);
	}
	
	}
	
	
	?>




<?php 

$sql  = "SELECT produit,sum(valeur1) As v1,sum(quantite1) As qte1,sum(valeur2) As v2,sum(quantite2) As qte2,sum(valeur3) As v3,sum(quantite3) As qte3,sum(valeur4) As v4,sum(quantite4) As qte4,sum(valeur5) As v5,sum(quantite5) As qte5 ";
	$sql .= "FROM stat_produits GROUP BY produit;";
	$users_t = db_query($database_name, $sql);$total1=0;$total2=0;$total3=0;$total4=0;$total5=0;
	
	while($users_tt = fetch_array($users_t)) {
		$total1=$total1+$users_tt["v1"];$total2=$total2+$users_tt["v2"];$total3=$total3+$users_tt["v3"];$total4=$total4+$users_tt["v4"];$total5=$total5+$users_tt["v5"];
	}




	$sql  = "SELECT produit,sum(valeur1) As v1,sum(quantite1) As qte1,sum(valeur2) As v2,sum(quantite2) As qte2,sum(valeur3) As v3,sum(quantite3) As qte3,sum(valeur4) As v4,sum(quantite4) As qte4,sum(valeur5) As v5,sum(quantite5) As qte5 ";
	$sql .= "FROM stat_produits GROUP BY produit;";
	$users = db_query($database_name, $sql);
	
	while($users_ = fetch_array($users)) {
	$produit=$users_["produit"];
	
?><tr>
<td align="left" WIDTH="20%"><?php echo "<a href=\"stat_produits_details.php?produit=$produit&date=$du&date1=$au\">$produit</a>";?></td>
<td align="right" WIDTH="12%"><?php echo number_format($users_["v1"],2,',',' ');$t1=$t1+$users_["v1"];@$p=$users_["v1"]/$total1*100;
echo "<br>";$p=number_format($p,2,',',' ')." %";print("<font size=\"3\" face=\"Comic sans MS\" color=\"FF0015\">$p </font>"); ?></td>
<td align="right" WIDTH="12%"><?php echo number_format($users_["v2"],2,',',' ');$t2=$t2+$users_["v2"];@$p=$users_["v2"]/$total2*100;
echo "<br>";$p=number_format($p,2,',',' ')." %";print("<font size=\"3\" face=\"Comic sans MS\" color=\"FF0015\">$p </font>"); ?></td>
<td align="right" WIDTH="12%"><?php echo number_format($users_["v3"],2,',',' ');$t3=$t3+$users_["v3"];@$p=$users_["v3"]/$total3*100;
echo "<br>";$p=number_format($p,2,',',' ')." %";print("<font size=\"3\" face=\"Comic sans MS\" color=\"FF0015\">$p </font>"); ?></td>
<td align="right" WIDTH="12%"><?php echo number_format($users_["v4"],2,',',' ');$t4=$t4+$users_["v4"];@$p=$users_["v4"]/$total4*100;
echo "<br>";$p=number_format($p,2,',',' ')." %";print("<font size=\"3\" face=\"Comic sans MS\" color=\"FF0015\">$p </font>");?></td>
<td align="right" WIDTH="12%"><?php echo number_format($users_["v5"],2,',',' ');$t5=$t5+$users_["v5"];@$p=$users_["v5"]/$total5*100;
echo "<br>";$p=number_format($p,2,',',' ')." %";print("<font size=\"3\" face=\"Comic sans MS\" color=\"FF0015\">$p </font>");?></td>
<td align="right" WIDTH="8%"><?php echo $users_["qte1"];$q1=$q1+$users_["qte1"];?></td>
<td align="right" WIDTH="8%"><?php echo $users_["qte2"];$q2=$q2+$users_["qte2"];?></td>
<td align="right" WIDTH="8%"><?php echo $users_["qte3"];$q3=$q3+$users_["qte3"];?></td>
<td align="right" WIDTH="8%"><?php echo $users_["qte4"];$q4=$q4+$users_["qte4"];?></td>
<td align="right" WIDTH="8%"><?php echo $users_["qte5"];$q5=$q5+$users_["qte5"];?></td>
<?php }  ?>
<tr><td align="right"><?php echo "Totaux : ";?></td>
<td align="right"><?php echo number_format($t1,2,',',' ');?></td>
<td align="right"><?php echo number_format($t2,2,',',' ');?></td>
<td align="right"><?php echo number_format($t3,2,',',' ');?></td>
<td align="right"><?php echo number_format($t4,2,',',' ');?></td>
<td align="right"><?php echo number_format($t5,2,',',' ');?></td>
<td align="right"><?php ?></td>
<td align="right"><?php ?></td>
<td align="right"><?php ?></td>
<td align="right"><?php ?></td>
</table>
<?php } ?>

<p style="text-align:center">

</body>

</html>