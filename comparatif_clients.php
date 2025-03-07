<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
$valeur=3600;
set_time_limit($valeur);
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";$action="Recherche";$date="";$date1="";$du="";$au="";
	$sql = "TRUNCATE TABLE `comparatif_clients`  ;";
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
	<form id="form" name="form" method="post" action="comparatif_clients.php">
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

<span style="font-size:24px"><?php echo "Comparatif Clients  $jour/$mois  au  $jour1/$mois1 "; ?></span>

<p style="text-align:center">
	<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo $annee_0;?></th>
	<th><?php echo $annee_1;?></th>
	<th><?php echo $annee_2;?></th>
	<th><?php echo $annee_3;?></th>
</tr>

	
	
	<? 
	$sql  = "SELECT client,date_e,vendeur,ville,sum(net) As total_net ";
	$sql .= "FROM commandes where date_e between '$date' and '$date1'  GROUP BY client;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) { 
	$m=$users_["total_net"];
	$c=$users_["client"];$v=$users_["vendeur"];
	$sql = "SELECT * FROM clients where client='$c' ORDER BY client;";
		$userc1 = db_query($database_name, $sql); $user_c1= fetch_array($userc1);
		$ville = $user_c1["ville"];
	
	$sql  = "INSERT INTO comparatif_clients ( client,vendeur,ville,exe_encours )
				 VALUES ('$c','$v','$ville','$m')";

				db_query($database_name, $sql);
				
	}
	
	$sql  = "SELECT client,date_e,vendeur,ville,sum(net) As total_net ";
	$sql .= "FROM commandes where date_e between '$d1_exe_1' and '$d2_exe_1'  GROUP BY client;";
	$users1 = db_query($database_name, $sql);
	while($users_1 = fetch_array($users1)) { 
	$m=$users_1["total_net"];
	$c=$users_1["client"];$v=$users_1["vendeur"];
	$sql = "SELECT * FROM clients where client='$c' ORDER BY client;";
		$userc2 = db_query($database_name, $sql); $user_c2 = fetch_array($userc2);
		$ville = $user_c2["ville"];
	
	$sql  = "INSERT INTO comparatif_clients ( client,vendeur,ville,exe_1 )
				 VALUES ('$c','$v','$ville','$m')";

				db_query($database_name, $sql);
	
	}
	
	
	$sql  = "SELECT client,date_e,vendeur,ville,sum(net) As total_net ";
	$sql .= "FROM commandes where date_e between '$d1_exe_2' and '$d2_exe_2'  GROUP BY client;";
	$users2 = db_query($database_name, $sql);
	while($users_2 = fetch_array($users2)) { 
	$m=$users_2["total_net"];
	$c=$users_2["client"];$v=$users_2["vendeur"];
	
	
		$sql = "SELECT * FROM clients where client='$c' ORDER BY client;";
		$userc3 = db_query($database_name, $sql); $user_c3 = fetch_array($userc3);
		$ville = $user_c3["ville"];
	
	$sql  = "INSERT INTO comparatif_clients ( client,vendeur,ville,exe_2 )
				 VALUES ('$c','$v','$ville','$m')";

				db_query($database_name, $sql);
	
	}

	
	$sql  = "SELECT client,date_e,vendeur,ville,sum(net) As total_net ";
	$sql .= "FROM commandes where date_e between '$d1_exe_3' and '$d2_exe_3'  GROUP BY client;";
	$users3 = db_query($database_name, $sql);
	while($users_3 = fetch_array($users3)) { 
	$m=$users_3["total_net"];
	$c=$users_3["client"];$v=$users_3["vendeur"];
	
	
		$sql = "SELECT * FROM clients where client='$c' ORDER BY client;";
		$userc3 = db_query($database_name, $sql); $user_c3 = fetch_array($userc3);
		$ville = $user_c3["ville"];
	
	$sql  = "INSERT INTO comparatif_clients ( client,vendeur,ville,exe_3 )
				 VALUES ('$c','$v','$ville','$m')";

				db_query($database_name, $sql);
	
	}

	
	
	$sql  = "SELECT client,ville,vendeur,sum(exe_encours) As total_exe_encours, sum(exe_1) As total_exe_1,sum(exe_2) As total_exe_2,sum(exe_3) As total_exe_3 ";
	//$sql .= "FROM comparatif_clients where vendeur='$vendeur' GROUP BY ville;";
	$sql .= "FROM comparatif_clients  GROUP BY ville;";
	$userse = db_query($database_name, $sql);
	while($users_e = fetch_array($userse)) { 
	$periode="$jour/$mois  au  $jour1/$mois1";
	$ville=$users_e["ville"];$vendeur=$users_e["vendeur"];$n="<a href=\"comparatif_clients_details.php?ville=$ville&vendeur=$vendeur&periode=$periode&du=$du&au=$au\">$ville</a>";?><tr>
	
	<td align="left"><?php echo $n;?></td>
	<td align="right"><?php echo number_format($users_e["total_exe_encours"],2,',',' ');$t1=$t1+$users_e["total_exe_encours"];?></td>
	<td align="right"><?php echo number_format($users_e["total_exe_1"],2,',',' ');$t2=$t2+$users_e["total_exe_1"];?></td>
	<td align="right"><?php echo number_format($users_e["total_exe_2"],2,',',' ');$t3=$t3+$users_e["total_exe_2"];?></td>
	<td align="right"><?php echo number_format($users_e["total_exe_3"],2,',',' ');$t4=$t4+$users_e["total_exe_3"];?></td>
	<?php } ?>
	
	<tr><td align="right"><?php echo "Totaux : ";?></td>
	<td align="right"><?php echo number_format($t1,2,',',' ');?></td>
	<td align="right"><?php echo number_format($t2,2,',',' ');?></td>
	<td align="right"><?php echo number_format($t3,2,',',' ');?></td>
<td align="right"><?php echo number_format($t4,2,',',' ');?></td>

<?php } ?>

<p style="text-align:center">

</body>

</html>