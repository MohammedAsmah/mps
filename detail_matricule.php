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

<? 	$date1=$_GET['date1'];$date2=$_GET['date2'];$vendeur=$_GET['vendeur'];$matricule=$_GET['matricule'];
	
	$sql  = "SELECT * ";$d1="2013-01-01";$d2="2013-01-31";
	$sql .= "FROM registre_vendeurs where vendeur='$vendeur' and date between '$date1' and '$date2' and matricule='$matricule' ORDER BY date;";
	//	$sql .= "FROM registre_vendeurs where date between '$d1' and '$d2' ORDER BY id;";
	$users11 = db_query($database_name, $sql);
?>


<span style="font-size:24px"><?php echo $matricule."  :  ".dateUsToFr($date1)." Au ".dateUsToFr($date2); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th><th><?php echo "Bon Sortie";?></th>
	<th><?php echo "Destination";?></th>
	<th><?php echo "Observations";?></th>
	<th><?php echo "Montant";?></th>
		
</tr>

<?php $compteur1=0;$total_g=0;

while($users_1 = fetch_array($users11)) { $id_r=$users_1["id"];$date3=$users_1["date"];$vendeur=$users_1["vendeur"];
			$statut=$users_1["statut"];$observation=$users_1["observation"];$valide=$users_1["valide"];$valide_c=$users_1["valide_c"];
			$service=$users_1["service"];$code=$users_1["code_produit"];$lp=$users_1["id"]+100000;$bon=$users_1["statut"];?><tr>
			<? $dt=dateUsToFr($users_1["date"]);$user_id=$users_1["id"];$imprimer=$users_1["imprimer"];
			$hh=$users_1["heure"];$mm=$users_1["montant"];
		
			$sql  = "SELECT * ";
			$sql .= "FROM commandes where id_registre=$id_r ORDER BY date_e;";
			$users = db_query($database_name, $sql);
			$total_g=0;$ttg=0;
			while($users_ = fetch_array($users)) { 
				$commande=$users_["commande"];$evaluation=$users_["evaluation"];$client=$users_["client"];$date11=dateUsToFr($users_["date_e"]);
				$vendeur=$users_["vendeur"];$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];
				$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$ttg=$ttg+$users_["net"];
				$id=$users_["id"];
				$sql1  = "SELECT * ";$m=0;$total=0;
				$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=0 ORDER BY produit;";
				$users1 = db_query($database_name, $sql1);$non_favoris=0;
				while($users1_ = fetch_array($users1)) { 
					$produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
					$total=$total+$m;
				}
				if ($sans_remise==1){$t=$total;$net=$total;} 
				else {
					$t=$total;$remise_1=0;$remise_2=0;$remise_3=0;
					if ($remise10>0){$remise_1=$total*$remise10/100;}
					if ($remise2>0){$remise_2=($total-$remise_1)*$remise2/100;}
					if ($remise3>0){$remise_3=($total-$remise_1-$remise_2)*$remise3/100;}
				}
				$sql1  = "SELECT * ";$total1=0;
				$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=1 ORDER BY produit;";
				$users1 = db_query($database_name, $sql1);
				while($users1_ = fetch_array($users1)) { 
					$produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
					$total1=$total1+$m;
				}
				$net=$total+$total1-$remise_1-$remise_2-$remise_3; 
				$total_g=$total_g+$net;
			}
?>			
			
						<td><?php $obs_c=$users_1["obs_c"];echo dateUsToFr($users_1["date"])." --> ".$obs_c; ?></td>
				<? $bon=$users_1["statut"]; echo "<td>$bon</td>";?>
			

			<td><?php $destination=$users_1["service"];echo $users_1["service"]; ?></td>
			<td><?php $destination=$users_1["service"];echo $users_1["observation"]; ?></td>
			 <td align="right"><? echo number_format($ttg,2,',',' ')."</td>";?>

			<? }?>
</table>
</strong>
<p style="text-align:center">



</body>

</html>
