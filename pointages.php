<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	$error_message = "";	$du="";$au="";$action="Recherche";$du1="";$au1="";
//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];
	$error_message = "";
	if(isset($_REQUEST["action_"])) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$statut = $_REQUEST["statut"];
		}
		
		if ($login=="admin" or $login=="rakia" or $login=="semhari"){
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO pointeuse ( produit, condit, prix,type, dispo ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $condit . "', ";
				$sql .= "'" . $prix . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $dispo . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE pointeuse SET ";
			$sql .= "statut = '" . $_REQUEST["statut"] . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM pointeuse WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	}
	} //if
	
	$action="recherche";$service="";$date1="";$date2="";
	$service_list = "";
	$sql = "SELECT * FROM  rs_data_services ORDER BY service;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($service == $temp_["service"]) { $selected = " selected"; } else { $selected = ""; }
		
		$service_list .= "<OPTION VALUE=\"" . $temp_["service"] . "\"" . $selected . ">";
		$service_list .= $temp_["service"];
		$service_list .= "</OPTION>";
	}
	$employe_list = "";$ser1="Occasionnelles";$ser2="Permanents";
	$sql = "SELECT * FROM  employes where service='$ser1' or service='$ser2' ORDER BY employe;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($employe == $temp_["employe"]) { $selected = " selected"; } else { $selected = ""; }
		
		$employe_list .= "<OPTION VALUE=\"" . $temp_["employe"] . "\"" . $selected . ">";
		$employe_list .= $temp_["employe"];
		$employe_list .= "</OPTION>";
	}
	
	?>
	<?  ?>
	<form id="form" name="form" method="post" action="pointages.php">

	<TR><td><?php echo "Employe		:"; ?></td><td><select id="employe" name="employe"><?php echo $employe_list; ?></select></td></TR>

	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<? 	
	
	

	
	?>
	<? 
	
	
	if(isset($_REQUEST["action"]))
	{ 
	$employe=$_POST['employe'];
	$sql  = "SELECT * ";
	$sql .= "FROM employes where statut=0 and employe='$employe' ORDER BY employe ;";
	$users2 = db_query($database_name, $sql);
	}
	else
	{$sql  = "SELECT * ";$occ="occasionnelles";$per="permanents";
	$sql .= "FROM employes where statut=0 and (service='$occ' or service='$per') ORDER BY employe ;";
	$users2 = db_query($database_name, $sql);
	}
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Pointage"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "pointage.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Etat Pointage "; ?></span>





<table class="table2">



<?php 

$date2=0;$date1=0;
function date_to_timestamp ($date) {
    return preg_match('/^\s*(\d\d\d\d)-(\d\d)-(\d\d)\s*(\d\d):(\d\d):(\d\d)/', $date, $m)
           ?  mktime($m[4], $m[5], $m[6], $m[2], $m[3], $m[1])
           : 0;
}

function date_diff ($date_recent, $date_old) {
   return date_to_timestamp($date_recent) - date_to_timestamp($date_old);
}

?><tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Statut";?></th>
	<th><?php echo "Heures";?></th>	
	<th></th>
</tr>
<?



while($users_2 = fetch_array($users2)) { 
	$name=$users_2["employe"];$t_h_dimanche=0;$t_h_samedi=0;$t_h_n=0;$id=$users_2["id"];
	?><tr><th><?php echo $name;?></th><th></th><th></th><th></th></tr>
	
<?
	
	

	$sql  = "SELECT * ";
	$sql .= "FROM pointeuse where name='$name' and non_inclus=0 ORDER BY id;";
	$users = db_query($database_name, $sql);

while($users_ = fetch_array($users)) { 

$de=$users_["date"];
list($d, $h) = explode(" ", $de);
list($heures, $min,$seconde) = explode(":", $h);
list($annee, $mois,$jours) = explode("-", $d);

$entree="";$sortie="";
$s1=substr($users_["statut"], 0, 4); 
$s2=substr($users_["statut"], 0, 5);

if ($s1=="C/In"){$date_in=strtotime($users_["date"]);$entree=$heures.":".$min;$c_in=$heures;$date1 = mktime($heures,$min,$seconde,$mois,$jours,$annee);}
if ($s2=="C/Out"){$date_out=strtotime($users_["date"]);$sortie=$heures.":".$min;$c_out=$heures;
$date2 = mktime($heures,$min,$seconde,$mois,$jours,$annee);
$diff=$c_out-$c_in;
$diff_date = $date2-$date1; 
@$diff['heures'] = (int)($diff_date/(60*60*60)); 
@$diff['jours'] = (int)($diff_date/(60*60*24)); 
$heures_totales = $diff_date/(60);$h_t=intval($heures_totales/60);$m_t=$heures_totales%60;

$tempsreel=$date_out-$date_in;$t_r=strftime('%H:%M:%S', $tempsreel);
list($hr, $mr,$sr) = explode(":", $t_r);
$hr=$hr-1;
}

?>
<tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["id"];?></A></td>
<td><?php echo $users_["date"]; ?></td>
<td><?php echo $users_["statut"]; ?></td>

<?php 

	if ($s1=="C/In"){
	$datej=$users_["date_j"];
	list($annee1,$mois1,$jour1) = explode('-', $datej); 
	$d = mktime(0,0,0,$mois1,$jour1,$annee1);
	$nom_jour=date("D",$d);
	$jour_t="";
	if ($nom_jour=="Sat"){$jour_t="Samedi";} if ($nom_jour=="Sun"){$jour_t="Dimanche";}
	if ($nom_jour=="Mon"){$jour_t="Lundi";} if ($nom_jour=="Tue"){$jour_t="Mardi";}
	if ($nom_jour=="Wed"){$jour_t="Mercredi";} if ($nom_jour=="Thu"){$jour_t="Jeudi";}
	if ($nom_jour=="Fri"){$jour_t="Vendredi";} 
	
	?><td><?php echo $jour_t; ?></td><td></td><? 
	}


if ($s2=="C/Out") {?>
<? if ($hr<=0){?>
<td bgcolor="#66CCCC"><?php echo "Erreur !!"; ?></td>
<? } else {?>
<td><?php echo $hr.":".$mr; ?></td>
<? }?>
<?  
	
	
	if ($mr>=20){$heures=$hr+($mr/60);$minute=00;}else{$heures=$hr;$minutes=00;}
	$lun=0;$mar=0;$mer=0;$jeu=0;$ven=0;$sam=0;$dim=0;
	$lun_s=0;$mar_s=0;$mer_s=0;$jeu_s=0;$ven_s=0;$sam_s=0;$dim_s=0;

	if ($nom_jour=="Mon"){if ($heures>=9){$lun_s=$heures-8;$lun=$heures-$lun_s;}else{$lun_s=0;$lun=$heures;}}
	if ($nom_jour=="Tue"){if ($heures>=9){$mar_s=$heures-8;$mar=$heures-$mar_s;}else{$mar_s=0;$mar=$heures;}}
	if ($nom_jour=="Wed"){if ($heures>=9){$mer_s=$heures-8;$mer=$heures-$mer_s;}else{$mer_s=0;$mer=$heures;}}
	if ($nom_jour=="Thu"){if ($heures>=9){$jeu_s=$heures-8;$jeu=$heures-$jeu_s;}else{$jeu_s=0;$jeu=$heures;}}
	if ($nom_jour=="Fri"){if ($heures>=9){$ven_s=$heures-8;$ven=$heures-$ven_s;}else{$ven_s=0;$ven=$heures;}}
	if ($nom_jour=="Sat"){if ($heures>=9){$sam_s=$heures-8;$sam=$heures-$sam_s;}else{$sam_s=0;$sam=$heures;}}
	if ($nom_jour=="Sun"){if ($heures>=9){$dim_s=$heures-8;$dim=$heures-$dim_s;}else{$dim_s=0;$dim=$heures;}}

?>



<?

	?>

<td><?php echo number_format($heures,2,',',' ')." ".$repos; ?></td>

<? 	if ($nom_jour=="Sat"){$t_h_samedi=$t_h_samedi+$heures;}
    if ($nom_jour=="Sun"){$t_h_dimanche=$t_h_dimanche+$heures;}
	if ($nom_jour=="Mon"){$t_h_n=$t_h_n+$lun;} 
	if ($nom_jour=="Tue"){$t_h_n=$t_h_n+$mar;}
	if ($nom_jour=="Wed"){$t_h_n=$t_h_n+$mer;}
	if ($nom_jour=="Thu"){$t_h_n=$t_h_n+$jeu;}
	if ($nom_jour=="Fri"){$t_h_n=$t_h_n+$ven;} 
	if ($nom_jour=="Sat"){$t_h_n=$t_h_n+$sam;} 	
?>
<? } 

 }
 //update
			/*$sql = "UPDATE employes SET ";
			$sql .= "t_h_25 = '" . $t_h_samedi . "', ";
			$sql .= "t_h_50 = '" . $t_h_dimanche . "', ";
			$sql .= "t_h_normales = '" . $t_h_n . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
			
			if ($t_h_n>44){$t_s=$t_h_n-44+$t_h_samedi;$t_n=44;}else{$t_n=$t_h_n;$t_s="";}
			echo "<tr><td bgcolor=\"#66CCCC\"> Normales : ".number_format($t_n,2,',',' ')."</td>";
			echo "<tr><td bgcolor=\"#66CCCC\"> Heures Sup : ".number_format($t_s,2,',',' ')."</td>";
			echo "<td bgcolor=\"#66CCCC\"> Samedi : ".number_format($t_h_samedi,2,',',' ')."</td>";
			echo "<td bgcolor=\"#66CCCC\"> Dimanche : ".number_format($t_h_dimanche,2,',',' ')."</td></tr>";*/
 ?>

<?php } ?>

</table>

<p style="text-align:center">

</body>

</html>