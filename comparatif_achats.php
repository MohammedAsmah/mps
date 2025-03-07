<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
$valeur=3600;
set_time_limit($valeur);
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";$action="Recherche";$date="";$date1="";$du="";$au="";
	$sql = "TRUNCATE TABLE `comparatif_achats`  ;";
			db_query($database_name, $sql);
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	$vendeur="";$profiles_list_vendeur="";
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
	<form id="form" name="form" method="post" action="comparatif_achats.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" />

	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{
	
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];
	$du=$_POST['date'];$au=$_POST['date1'];$encours="encours";$t1=0;$t2=0;$t3=0;$t4=0;
	list($annee1,$mois1,$jour1) = explode('-', $date);// $vendeur=$_POST['vendeur'];
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

<span style="font-size:24px"><?php echo "Comparatif Achats en Quantités $jour/$mois  au  $jour1/$mois1 "; ?></span>

<p style="text-align:center">
	<table class="table2">

<tr>
	<th><?php echo "Designation";?></th>
	<th><?php echo $annee_0;?></th>
	<th><?php echo $annee_1;?></th>
	<th><?php echo $annee_2;?></th>
	<th><?php echo $annee_3;?></th>
</tr>

	
	
	<? 
	$sql  = "SELECT produit,type, frs,ref,date,date_ins,prix_achat,ttc,ht,qte,pttt,importation,sum(qte) As total_net,sum(prix_achat*qte) As total_ht ";
	$sql .= "FROM achats_mat where date between '$date' and '$date1'  GROUP BY type;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) { 
	$m=$users_["total_net"];
	$c=$users_["type"];$frs=$users_["frs"];$produit=$users_["produit"];$v=$users_["total_ht"];
	
	$sql  = "INSERT INTO comparatif_achats ( type,frs,produit,exe_encours,exe_encours_v )
				 VALUES ('$c','$frs','$produit','$m','$v')";

				db_query($database_name, $sql);
				
	}
	
	$sql  = "SELECT produit,type, frs,ref,date,date_ins,prix_achat,ttc,ht,pttt,importation,sum(qte) As total_net,sum(prix_achat*qte) As total_ht ";
	$sql .= "FROM achats_mat where date between '$d1_exe_1' and '$d2_exe_1'  GROUP BY type;";
	$users1 = db_query($database_name, $sql);
	while($users_1 = fetch_array($users1)) { 
	$m=$users_1["total_net"];
	$c=$users_1["type"];$frs=$users_1["frs"];$produit=$users_1["produit"];$v=$users_1["total_ht"];
	
	$sql  = "INSERT INTO comparatif_achats ( type,frs,produit,exe_1,exe_1_v )
				 VALUES ('$c','$frs','$produit','$m','$v')";

				db_query($database_name, $sql);
				
	}
	
	
	$sql  = "SELECT produit,type, frs,ref,date,date_ins,prix_achat,ttc,ht,pttt,importation,sum(qte) As total_net,sum(prix_achat*qte) As total_ht ";
	$sql .= "FROM achats_mat where date between '$d1_exe_2' and '$d2_exe_2'  GROUP BY type;";
	$users2 = db_query($database_name, $sql);
	while($users_2 = fetch_array($users2)) { 
	$m=$users_2["total_net"];
	$c=$users_2["type"];$frs=$users_2["frs"];$produit=$users_2["produit"];$v=$users_2["total_ht"];
	
	$sql  = "INSERT INTO comparatif_achats ( type,frs,produit,exe_2,exe_2_v )
				 VALUES ('$c','$frs','$produit','$m','$v')";

				db_query($database_name, $sql);
				
	}

	
	$sql  = "SELECT produit,type, frs,ref,date,date_ins,prix_achat,ttc,ht,pttt,importation,sum(qte) As total_net,sum(prix_achat*qte) As total_ht ";
	$sql .= "FROM achats_mat where date between '$d1_exe_3' and '$d2_exe_3'  GROUP BY type;";
	$users3 = db_query($database_name, $sql);
	while($users_3 = fetch_array($users3)) { 
	$m=$users_3["total_net"];
	$c=$users_3["type"];$frs=$users_3["frs"];$produit=$users_3["produit"];$v=$users_3["total_ht"];
	
	$sql  = "INSERT INTO comparatif_achats ( type,frs,produit,exe_3,exe_3_v )
				 VALUES ('$c','$frs','$produit','$m','$v')";

				db_query($database_name, $sql);
				
	}

	
	$divers="divers";
	$sql  = "SELECT type,frs,produit,sum(exe_encours) As total_exe_encours, sum(exe_1) As total_exe_1,sum(exe_2) As total_exe_2,sum(exe_3) As total_exe_3 ";
	$sql .= "FROM comparatif_achats where type<>'$divers' GROUP BY type;";
	$usersev = db_query($database_name, $sql);
	while($users_ev = fetch_array($usersev)) { 
	$periode="$jour/$mois  au  $jour1/$mois1";
	$type=$users_ev["type"];
	if ($type=="col"){$matiere="Colorants (kg)";}
	if ($type=="emb"){$matiere="Emballage Cartons (unite)";}
	if ($type=="emb1"){$matiere="Emballage Sachets (kg)";}
	if ($type=="emb2"){$matiere="Emballage Divers";}
	if ($type=="mat"){$matiere="Matiere Première (kg)";}
	if ($type=="mat2"){$matiere="Matiere Rebroyée (kg)";}
	if ($type=="mat_cons"){$matiere="Matiere Consomable (kg)";}
	if ($type=="tig"){$matiere="Tiges Aluminium (kg)";}
	
	
	
	
	$frs=$users_ev["frs"];$n="<a href=\"comparatif_achatss_details.php?type=$type&frs=$frs&periode=$periode&du=$du&au=$au\">$matiere</a>";?><tr>
	
	<td align="left"><?php echo $n;?></td>
	<td align="right"><?php echo number_format($users_ev["total_exe_encours"],2,',',' ');$t1=$t1+$users_ev["total_exe_encours"];?></td>
	<td align="right"><?php echo number_format($users_ev["total_exe_1"],2,',',' ');$t2=$t2+$users_ev["total_exe_1"];?></td>
	<td align="right"><?php echo number_format($users_ev["total_exe_2"],2,',',' ');$t3=$t3+$users_ev["total_exe_2"];?></td>
	<td align="right"><?php echo number_format($users_ev["total_exe_3"],2,',',' ');$t4=$t4+$users_ev["total_exe_3"];?></td>
	<?php } ?>
	
	<tr><td align="right"><?php echo "Totaux : ";?></td>
	<td align="right"><?php echo number_format($t1,2,',',' ');?></td>
	<td align="right"><?php echo number_format($t2,2,',',' ');?></td>
	<td align="right"><?php echo number_format($t3,2,',',' ');?></td>
<td align="right"><?php echo number_format($t4,2,',',' ');?></td>


</table>


<p>

<span style="font-size:24px"><?php echo "Comparatif Achats en Valeurs $jour/$mois  au  $jour1/$mois1 "; ?></span>

<p style="text-align:center">
	<table class="table2">

<tr>
	<th><?php echo "Designation";?></th>
	<th><?php echo $annee_0;?></th>
	<th><?php echo $annee_1;?></th>
	<th><?php echo $annee_2;?></th>
	<th><?php echo $annee_3;?></th>
</tr>

<? $divers="divers";$t1=0;$t2=0;$t3=0;$t4=0;
	$sql  = "SELECT type,frs,produit,sum(exe_encours_v) As total_exe_encours_v, sum(exe_1_v) As total_exe_1_v,sum(exe_2_v) As total_exe_2_v,sum(exe_3_v) As total_exe_3_v ";
	$sql .= "FROM comparatif_achats where type<>'$divers' GROUP BY type;";
	$userse = db_query($database_name, $sql);
	while($users_e = fetch_array($userse)) { 
	$periode="$jour/$mois  au  $jour1/$mois1";
	$type=$users_e["type"];
	if ($type=="col"){$matiere="Colorants";}
	if ($type=="emb"){$matiere="Emballage Cartons";}
	if ($type=="emb1"){$matiere="Emballage Sachets";}
	if ($type=="emb2"){$matiere="Emballage Divers";}
	if ($type=="mat"){$matiere="Matiere Première";}
	if ($type=="mat2"){$matiere="Matiere Rebroyée";}
	if ($type=="mat_cons"){$matiere="Matiere Consomable";}
	if ($type=="tig"){$matiere="Tiges Aluminium";}
	
	
	
	
	$frs=$users_e["frs"];$n="<a href=\"comparatif_achatss_details.php?type=$type&frs=$frs&periode=$periode&du=$du&au=$au\">$matiere</a>";?><tr>
	
	<td align="left"><?php echo $n;?></td>
	<td align="right"><?php echo number_format($users_e["total_exe_encours_v"],2,',',' ');$t1=$t1+$users_e["total_exe_encours_v"];?></td>
	<td align="right"><?php echo number_format($users_e["total_exe_1_v"],2,',',' ');$t2=$t2+$users_e["total_exe_1_v"];?></td>
	<td align="right"><?php echo number_format($users_e["total_exe_2_v"],2,',',' ');$t3=$t3+$users_e["total_exe_2_v"];?></td>
	<td align="right"><?php echo number_format($users_e["total_exe_3_v"],2,',',' ');$t4=$t4+$users_e["total_exe_3_v"];?></td>
	<?php } ?>
	
	<tr><td align="right"><?php echo "Totaux : ";?></td>
	<td align="right"><?php echo number_format($t1,2,',',' ');?></td>
	<td align="right"><?php echo number_format($t2,2,',',' ');?></td>
	<td align="right"><?php echo number_format($t3,2,',',' ');?></td>
<td align="right"><?php echo number_format($t4,2,',',' ');?></td>

</table>




<?php 
/*$sql = "TRUNCATE TABLE `comparatif_achats`  ;";
			db_query($database_name, $sql);*/

} ?>

<p style="text-align:center">

</body>

</html>