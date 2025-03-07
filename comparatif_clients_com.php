<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
$valeur=3600;
set_time_limit($valeur);
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";$action="Recherche";$date="";$date1="";$du="";$au="";
	$sql = "TRUNCATE TABLE `comparatif_clients_com`  ;";
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
	<form id="form" name="form" method="post" action="comparatif_clients_com.php">
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

<span style="font-size:24px"><?php echo "Comparatif Clients Avec Escompte 2% sur Evaluations du $jour/$mois  au  $jour1/$mois1 "; ?></span>

<p style="text-align:center">
	<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo $annee_0;?></th>
	<th><?php echo $annee_1;?></th>
	<th><?php echo "Variation C.A";?></th>
	
</tr>

	
	
	<? 
	$sql  = "SELECT client,date_e,vendeur,ville,escompte,sum(net) As total_net ";
	$sql .= "FROM commandes where escompte<>0 and date_e between '$date' and '$date1'  GROUP BY id;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) { 
	$m=$users_["total_net"];
	$c=$users_["client"];$v=$users_["vendeur"];$escompte=$users_["escompte"];$escompte=$m/0.98;
	$sql = "SELECT * FROM clients where client='$c' ORDER BY client;";
		$userc1 = db_query($database_name, $sql); $user_c1= fetch_array($userc1);
		$ville = $user_c1["ville"];
	
	if ($escompte<>0){
	$sql  = "INSERT INTO comparatif_clients_com ( client,vendeur,ville,exe_encours,escompte )
				 VALUES ('$c','$v','$ville','$escompte','$escompte')";

				db_query($database_name, $sql);}
				
	}
	
	$sql  = "SELECT client,date_e,vendeur,ville,escompte,sum(net) As total_net ";
	$sql .= "FROM commandes where escompte<>0 and date_e between '$d1_exe_1' and '$d2_exe_1'  GROUP BY id;";
	$users1 = db_query($database_name, $sql);
	while($users_1 = fetch_array($users1)) { 
	$m=$users_1["total_net"];
	$c=$users_1["client"];$v=$users_1["vendeur"];$escompte=$users_1["escompte"];$escompte=$m/0.98;
	$sql = "SELECT * FROM clients where client='$c' ORDER BY client;";
		$userc2 = db_query($database_name, $sql); $user_c2 = fetch_array($userc2);
		$ville = $user_c2["ville"];
	
	if ($escompte<>0){
	$sql  = "INSERT INTO comparatif_clients_com ( client,vendeur,ville,exe_1,escompte )
				 VALUES ('$c','$v','$ville','$escompte','$escompte')";

				db_query($database_name, $sql);}
	
	}
	
	
	/*$sql  = "SELECT client,date_e,vendeur,ville,escompte,sum(net) As total_net ";
	$sql .= "FROM commandes where escompte<>0 and date_e between '$d1_exe_2' and '$d2_exe_2'  GROUP BY id;";
	$users2 = db_query($database_name, $sql);
	while($users_2 = fetch_array($users2)) { 
	$m=$users_2["total_net"];
	$c=$users_2["client"];$v=$users_2["vendeur"];$escompte=$users_2["escompte"];$escompte=$m/0.98;
	
	
		$sql = "SELECT * FROM clients where client='$c' ORDER BY client;";
		$userc3 = db_query($database_name, $sql); $user_c3 = fetch_array($userc3);
		$ville = $user_c3["ville"];
	
	if ($escompte<>0){
	$sql  = "INSERT INTO comparatif_clients_com ( client,vendeur,ville,exe_2,escompte )
				 VALUES ('$c','$v','$ville','$escompte','$escompte')";

				db_query($database_name, $sql);}
	
	}*/

	
	/*$sql  = "SELECT client,date_e,vendeur,ville,escompte,sum(net) As total_net ";
	$sql .= "FROM commandes where escompte<>0 and date_e between '$d1_exe_3' and '$d2_exe_3'  GROUP BY id;";
	$users3 = db_query($database_name, $sql);
	while($users_3 = fetch_array($users3)) { 
	$m=$users_3["total_net"];
	$c=$users_3["client"];$v=$users_3["vendeur"];$escompte=$users_3["escompte"];$escompte=$m/0.98;
	
	
		$sql = "SELECT * FROM clients where client='$c' ORDER BY client;";
		$userc3 = db_query($database_name, $sql); $user_c3 = fetch_array($userc3);
		$ville = $user_c3["ville"];
	
	if ($escompte<>0){
	$sql  = "INSERT INTO comparatif_clients_com ( client,vendeur,ville,exe_3,escompte )
				 VALUES ('$c','$v','$ville','$escompte','$escompte')";

				db_query($database_name, $sql);}
	
	}*/

	
	
	$sql  = "SELECT client,ville,vendeur,escompte,sum(exe_encours) As total_exe_encours, sum(exe_1) As total_exe_1,sum(exe_2) As total_exe_2,sum(exe_3) As total_exe_3 ";
	//$sql .= "FROM comparatif_clients where vendeur='$vendeur' GROUP BY ville;";
	$sql .= "FROM comparatif_clients_com where escompte<>0 GROUP BY client;";
	$userse = db_query($database_name, $sql);$c1=0;$c2=0;
	while($users_e = fetch_array($userse)) { 
	$periode="$jour/$mois  au  $jour1/$mois1";
	$client=$users_e["client"];$vendeur=$users_e["vendeur"];$n="<a href=\"comparatif_clients_details.php?ville=$ville&vendeur=$vendeur&periode=$periode&du=$du&au=$au\">$ville</a>";?><tr>
	
	<td align="left"><?php echo $client." / ".$vendeur;?></td>
	<td align="right"><?php echo number_format($users_e["total_exe_encours"],2,',',' ');$t1=$t1+$users_e["total_exe_encours"];?>
	<?php //echo "----".number_format($users_e["total_exe_encours"]*2/100,2,',',' ');$c1=$c1+$users_e["total_exe_encours"]*2/100;?></td>
	
	<td align="right"><?php echo number_format($users_e["total_exe_1"],2,',',' ');$t2=$t2+$users_e["total_exe_1"];?>
	<?php //echo "----".number_format($users_e["total_exe_1"]*2/100,2,',',' ');$c2=$c2+$users_e["total_exe_1"]*2/100;?></td>
	
	<td align="right"><?php $t=($users_e["total_exe_encours"]-$users_e["total_exe_1"])/$users_e["total_exe_1"]*100;echo number_format($t,2,',',' ')."%";?></td>
	
	<?php } ?>
	
	<tr><td align="right"><?php echo "Totaux : ";?></td>
	<td align="right"><?php echo number_format($t1,2,',',' ');//echo number_format($c1,2,',',' ');?></td>
	<td align="right"><?php echo number_format($t2,2,',',' ');//echo number_format($c2,2,',',' ');?></td>


<? $sql = "TRUNCATE TABLE `comparatif_clients_com`  ;";
			db_query($database_name, $sql);
			?>
	
</table>	
	

<span style="font-size:24px"><?php echo "Comparatif Clients Avec Escompte sur C.A du $jour/$mois  au  $jour1/$mois1 "; ?></span>

<p style="text-align:center">
	<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo $annee_0;?></th>
	<th><?php echo $annee_1;?></th>
	<th><?php echo "Variation C.A";?></th>
	
</tr>

	
	
	<? 
	$sql  = "SELECT client,date_e,vendeur,ville,escompte,sum(net) As total_net ";
	$sql .= "FROM commandes where escompte=0 and date_e between '$date' and '$date1'  GROUP BY id;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) { 
	$m=$users_["total_net"];
	$c=$users_["client"];$v=$users_["vendeur"];$escompte=$users_["escompte"];$escompte=$m/0.98;
	$sql = "SELECT * FROM clients where client='$c' ORDER BY client;";
		$userc1 = db_query($database_name, $sql); $user_c1= fetch_array($userc1);
		$ville = $user_c1["ville"];
	
	
	$sql  = "INSERT INTO comparatif_clients_com ( client,vendeur,ville,exe_encours,escompte )
				 VALUES ('$c','$v','$ville','$m','$escompte')";

				db_query($database_name, $sql);
				
	}
	
	$sql  = "SELECT client,date_e,vendeur,ville,escompte,sum(net) As total_net ";
	$sql .= "FROM commandes where escompte=0 and date_e between '$d1_exe_1' and '$d2_exe_1'  GROUP BY id;";
	$users1 = db_query($database_name, $sql);
	while($users_1 = fetch_array($users1)) { 
	$m=$users_1["total_net"];
	$c=$users_1["client"];$v=$users_1["vendeur"];$escompte=$users_1["escompte"];$escompte=$m/0.98;
	$sql = "SELECT * FROM clients where client='$c' ORDER BY client;";
		$userc2 = db_query($database_name, $sql); $user_c2 = fetch_array($userc2);
		$ville = $user_c2["ville"];
	
	
	$sql  = "INSERT INTO comparatif_clients_com ( client,vendeur,ville,exe_1,escompte )
				 VALUES ('$c','$v','$ville','$m','$escompte')";

				db_query($database_name, $sql);
	
	}
	
	
	
	
	
	$sql  = "SELECT client,ville,vendeur,escompte,sum(exe_encours) As total_exe_encours, sum(exe_1) As total_exe_1,sum(exe_2) As total_exe_2,sum(exe_3) As total_exe_3 ";
	//$sql .= "FROM comparatif_clients where vendeur='$vendeur' GROUP BY ville;";
	$sql .= "FROM comparatif_clients_com GROUP BY client order by total_exe_encours DESC;";
	$userse = db_query($database_name, $sql);$c1=0;$c2=0;
	while($users_e = fetch_array($userse)) { 
	$periode="$jour/$mois  au  $jour1/$mois1";
	$client=$users_e["client"];$vendeur=$users_e["vendeur"];$n="<a href=\"comparatif_clients_details.php?ville=$ville&vendeur=$vendeur&periode=$periode&du=$du&au=$au\">$ville</a>";?><tr>
	
	<td align="left"><?php echo $client." / ".$vendeur;?></td>
	<td align="right"><?php echo number_format($users_e["total_exe_encours"],2,',',' ');$t1=$t1+$users_e["total_exe_encours"];?>
	<?php //echo "----".number_format($users_e["total_exe_encours"]*2/100,2,',',' ');$c1=$c1+$users_e["total_exe_encours"]*2/100;?></td>
	
	<td align="right"><?php echo number_format($users_e["total_exe_1"],2,',',' ');$t2=$t2+$users_e["total_exe_1"];?>
	<?php //echo "----".number_format($users_e["total_exe_1"]*2/100,2,',',' ');$c2=$c2+$users_e["total_exe_1"]*2/100;?></td>
	
	<td align="right"><?php $t=($users_e["total_exe_encours"]-$users_e["total_exe_1"])/$users_e["total_exe_1"]*100;echo number_format($t,2,',',' ')."%";?></td>
	
	<?php } ?>
	
	<tr><td align="right"><?php echo "Totaux : ";?></td>
	<td align="right"><?php echo number_format($t1,2,',',' ');//echo number_format($c1,2,',',' ');?></td>
	<td align="right"><?php echo number_format($t2,2,',',' ');//echo number_format($c2,2,',',' ');?></td>
	





	
<?php } ?>









<p style="text-align:center">

</body>

</html>