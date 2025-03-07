<?php
set_time_limit(0);
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$user_login = $user_["login"];$date1="";$date2="";$action="Recherche";$vendeur="";
	$vendeur_list = "";
	$sql = "SELECT * FROM  vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$vendeur_list .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$vendeur_list .= $temp_["vendeur"];
		$vendeur_list .= "</OPTION>";
	}
	
	
	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="registres_vendeurs_mc.php">
	<td><?php echo "Du : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au : "; ?><input onClick="ds_sh(this);" name="date2" value="<?php echo $date2; ?>" readonly="readonly" style="cursor: text" /></td>
	<td>
		<?php echo "Vendeur		:"; ?></td><td>
		<select id="vendeur" name="vendeur"><?php echo $vendeur_list; ?></select></td>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	
	</form>
	
	<? }


?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre_vendeur.php?user_id=" + user_id; }
	function EditUser1(user_id) { document.location = "registre_sejour_annuler_sans_lp.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	if(isset($_REQUEST["action"]))
	{ $date1=dateFrToUs($_POST['date1']);$date2=dateFrToUs($_POST['date2']);$vendeur=$_POST['vendeur'];
	
	$sql  = "SELECT * ";$d1="2013-01-01";$d2="2013-01-31";
	$sql .= "FROM registre_vendeurs where vendeur='$vendeur' and date between '$date1' and '$date2' group by matricule ORDER BY id;";
	//	$sql .= "FROM registre_vendeurs where date between '$d1' and '$d2' ORDER BY id;";
	$users11 = db_query($database_name, $sql);
?>


<span style="font-size:24px"><?php echo $vendeur."  :  ".dateUsToFr($date1)." Au ".dateUsToFr($date2); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Matricule";?></th>
		
</tr>

<?php $compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { $matricule=$users_1["matricule"];?>
<? echo "<tr><td><a href=\"detail_matricule.php?matricule=$matricule&vendeur=$vendeur&date1=$date1&date2=$date2\">$matricule</a></td>";?>
<? } ?>

</table>



<span style="font-size:24px"><?php echo $vendeur."  :  ".dateUsToFr($date1)." Au ".dateUsToFr($date2); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th><th><?php echo "Bon Sortie";?></th>
	<th><?php echo "Destination";?></th>
	<th><?php echo "Observation";?></th>
	<th><?php echo "Matricule";?></th>
	<th><?php echo "Montant";?></th>
	
		
</tr>

<?php $sql  = "SELECT * ";
	$sql .= "FROM registre_vendeurs where vendeur='$vendeur' and date between '$date1' and '$date2' ORDER BY date;";
	$users11 = db_query($database_name, $sql);

while($users_1 = fetch_array($users11)) { $matricule=$users_1["matricule"];$id_r=$users_1["id"];?>
<? $date=dateUsToFr($users_1["date"]); echo "<tr><td>$date</td>";?>
<? $bon=$users_1["statut"]; echo "<td>$bon</td>";?>
<? $des=$users_1["service"]; echo "<td>$des</td>";?>
<? $obs=$users_1["observation"]; echo "<td>$obs</td>";?>
<? $obs_c=$users_1["obs_c"];echo "<td>$matricule --> $obs_c</td>";


	
			
			$sql  = "SELECT * ";
	$sql .= "FROM commandes where id_registre=$id_r ORDER BY date_e;";
	$users = db_query($database_name, $sql);
	$total_g=0;$ttg=0;
	while($users_ = fetch_array($users)) { 
		$commande=$users_["commande"];$evaluation=$users_["evaluation"];$client=$users_["client"];$date11=dateUsToFr($users_["date_e"]);
		$vendeur=$users_["vendeur"];$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];
		$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$ttg=$ttg+$users_["net"];
		$id=$users_["id"];
		}
		$ttgf=number_format($ttg,2,',',' ');
	echo "<td>$ttgf</td>";	
?>




<? } ?>

</table>

</strong>
<p style="text-align:center">



<? }?>
</body>

</html>
