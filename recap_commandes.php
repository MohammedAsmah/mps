<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();	$user_name=GetUserName();


	$error_message = "";$date="";$date_f="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;
		$date="";$action="Recherche";	
	$profiles_list_vendeur = "";$vendeur="";

	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {$client = $_REQUEST["frs"];$date = dateFrToUs($_REQUEST["date"]);
		$date_f = dateFrToUs($_REQUEST["date"]);$bb = $_REQUEST["bb"];
		
			
			// prepares data to simplify database insert or update
			$frs = $_REQUEST["frs"];$vendeur = $_REQUEST["vendeur"];$destination = $_REQUEST["destination"];
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
		$sql  = "SELECT * ";
		$sql .= "FROM rs_data_fournisseurs WHERE last_name = '$frs' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$ville=$user_["ville"];$fax=$user_["fax"];
			
			}
		if($_REQUEST["action_"] == "update_user"){	
			$destination = $_REQUEST["destination"];
			$frs = $_REQUEST["frs"];$vendeur = $_REQUEST["vendeur"];$client = $_REQUEST["frs"];
			
			$bl = $_REQUEST["bl"];$bc = $_REQUEST["bc"];$piece = $_REQUEST["piece"];
			}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
				
				$result = mysql_query("SELECT commande FROM commandes_frs ORDER BY commande DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$dir = $row["commande"];
								
				$date = dateFrToUs($_REQUEST["date"]);
				list($annee1,$mois1,$jour1) = explode('-', $date); 
				$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
				$mois=date("M",$pdu);$annee=date("Y",$pdu);
				if ($mois=="May"){$mois1="MAI";}
				if ($mois=="Jun"){$mois1="JUIN";}
				if ($mois=="Jul"){$mois1="JUIL";}
				if ($mois=="Aug"){$mois1="AOUT";}
				if ($mois=="Sep"){$mois1="SEP";}
				if ($mois=="Oct"){$mois1="OCT";}
				if ($mois=="Nov"){$mois1="NOV";}
				if ($mois=="Dec"){$mois1="DEC";}
				if ($mois=="Jan"){$mois1="JAN";}
				if ($mois=="Feb"){$mois1="FEV";}
				if ($mois=="Mar"){$mois1="MARS";}
				if ($mois=="Apr"){$mois1="AVRIL";}
				$result = mysql_query("SELECT eval FROM commandes_frs where (mois='$mois1' and annee='$annee') ORDER BY eval DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$dir_eval = $row["eval"]+1;
				if ($dir_eval<10){$dev="00".$dir_eval;}
				if ($dir_eval>9 and $dir_eval<100) {$dev="0".$dir_eval;}
				if ($dir_eval>=100){$dev=$dir_eval;}
				$encours=$mois1." ".$dev;$remise10=10;$cde=$dir+1;$encours="encours";
				$sql  = "INSERT INTO commandes_frs ( commande,date_e,client,ville,fax, vendeur, remise_10,remise_2,remise_3,evaluation,bb,destination,sans_remise ) VALUES ( ";
				$sql .= "'" . $cde . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $ville . "', ";
				$sql .= "'" . $fax . "', ";				
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $remise10 . "', ";
				$sql .= "'" . $remise2 . "', ";
				$sql .= "'" . $remise3 . "', ";
				$sql .= "'" . $encours . "', ";
				$sql .= "'" . $bb . "', ";
				$sql .= "'" . $destination . "', ";
				$sql .= "'" . $sans_remise . "');";

				db_query($database_name, $sql);
		
		
		//retour à liste triée par date
		$date=$_POST['date'];$vendeur=$_POST['vendeur'];$action="recherche";$destination=$_POST['destination'];
					

			break;

			case "update_user":
			if(isset($_REQUEST["ev_pre"])) { $ev_pre = 1; } else { $ev_pre = 0; }
						if(isset($_REQUEST["piece"])) { $piece = 1; } else { $piece = 0; }

			$net = $_REQUEST["net"];if(isset($_REQUEST["active"])) {$active = $_REQUEST["active"];}
				$date = dateFrToUs($_REQUEST["date"]);$evaluation = $_REQUEST["evaluation"];
				list($annee1,$mois1,$jour1) = explode('-', $date); 
				$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
				$mois=date("M",$pdu);$annee=date("Y",$pdu);
				if ($mois=="May"){$mois1="MAI";}
				if ($mois=="Jun"){$mois1="JUIN";}
				if ($mois=="Jul"){$mois1="JUIL";}
				if ($mois=="Aug"){$mois1="AOUT";}
				if ($mois=="Sep"){$mois1="SEP";}
				if ($mois=="Oct"){$mois1="OCT";}
				if ($mois=="Nov"){$mois1="NOV";}
				if ($mois=="Dec"){$mois1="DEC";}
				if ($mois=="Jan"){$mois1="JAN";}
				if ($mois=="Feb"){$mois1="FEV";}
				if ($mois=="Mar"){$mois1="MARS";}
				if ($mois=="Apr"){$mois1="AVRIL";}
				$result = mysql_query("SELECT eval FROM commandes_frs where (mois='$mois1' and annee='$annee') and active=1 ORDER BY eval DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$dir_eval = $row["eval"]+1;
				if ($dir_eval<10){$dev="00".$dir_eval;}
				if ($dir_eval>9 and $dir_eval<100) {$dev="0".$dir_eval;}
				if ($dir_eval>=100){$dev=$dir_eval;}
				$remise10=10;
						if(isset($_REQUEST["active"])) { $active = 1;$encours=$mois1." ".$dev; } 
						else { $active = 0; $encours=$evaluation;}
			$sql = "UPDATE commandes_frs SET ";
			$sql .= "client = '" . $client . "', ";
			$sql .= "date_e = '" . $date . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			$sql .= "ville = '" . $ville . "', ";
			$sql .= "fax = '" . $fax . "', ";
			$sql .= "evaluation = '" . $encours . "', ";
			$sql .= "eval = '" . $dir_eval . "', ";
			$sql .= "mois = '" . $mois1 . "', ";
			$sql .= "annee = '" . $annee . "', ";
			$sql .= "active = '" . $active . "', ";
			$sql .= "remise_10 = '" . $remise10 . "', ";
			$sql .= "bb = '" . $bb . "', ";
			$sql .= "remise_2 = '" . $remise2 . "', ";
			$sql .= "remise_3 = '" . $remise3 . "', ";
			$sql .= "net = '" . $net . "', ";
			$sql .= "ev_pre = '" . $ev_pre . "', ";
			$sql .= "piece = '" . $piece . "', ";
			$sql .= "bl = '" . $bl . "', ";
			$sql .= "bc = '" . $bc . "', ";
			$sql .= "sans_remise = '" . $sans_remise . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);

			//revenir à liste
			$date=$_POST['date'];$vendeur=$_POST['vendeur'];$action="recherche";$destination=$_POST['destination'];
			


			break;
			
			case "delete_user":
			$sql  = "SELECT * ";
			$sql .= "FROM commandes_frs WHERE id = " . $_REQUEST["user_id"] . ";";
			$user = db_query($database_name, $sql); $users_ = fetch_array($user);
			$commande=$users_["commande"];$destination=$users_["destination"];
			$sql = "DELETE FROM commandes_frs WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			$sql = "DELETE FROM detail_commandes_frs WHERE commande = " . $commande . ";";
			db_query($database_name, $sql);
			$sql = "DELETE FROM detail_commandes_frs WHERE commande = " . $commande . ";";
			db_query($database_name, $sql);
			
			
			
			break;


		} //switch
	} //if
	

	$sql1 = "SELECT * FROM vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_vendeur .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$profiles_list_vendeur .= $temp_["vendeur"];
		$profiles_list_vendeur .= "</OPTION>";
	}
		$profiles_list_dep = "";$destination="";
	$sql1 = "SELECT * FROM rs_data_dep ORDER BY ville;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($destination == $temp_["ville"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_dep .= "<OPTION VALUE=\"" . $temp_["ville"] . "\"" . $selected . ">";
		$profiles_list_dep .= $temp_["ville"];
		$profiles_list_dep .= "</OPTION>";
	}

		if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="recap_commandes.php">
	<table><td><?php echo "Date: "; ?><input onClick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<tr><td></td><td><?php echo "Departement :"; ?></td><td><select id="destination" name="destination"><?php echo $profiles_list_dep; ?></select></td>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{$date=dateFrToUs($_POST['date']);$date_f=dateFrToUs($_POST['date']);$vendeur=$_POST['vendeur'];$destination=$_POST['destination'];
		
		$sql  = "SELECT * ";
		$sql .= "FROM commandes_frs where date_e='$date' ORDER BY date_e;";
		$users = db_query($database_name, $sql);
		}
		
		else
			
		{
		@$vendeur=$_GET['vendeur'];@$date=$_GET['date'];@$destination=$_GET['destination'];
		$sql  = "SELECT * ";
		$sql .= "FROM commandes_frs where  date_e='$date' ORDER BY date_e;";
		$users = db_query($database_name, $sql);}
		
	if(isset($_REQUEST["action_"]))
	{$date=dateFrToUs($_POST['date']);$date_f=dateFrToUs($_POST['date']);$vendeur=$_POST['vendeur'];
		
		$sql  = "SELECT * ";
		$sql .= "FROM commandes_frs where date_e='$date' ORDER BY date_e;";
		$users = db_query($database_name, $sql);
		}
		
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Commandes"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "bc_mps_details.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "liste Commandes"; ?></span>
<tr>
<td><?php echo dateUsToFr($date_f); ;?></td>
</tr><tr><? echo "<td><a href=\"bc_mps_details.php?vendeur=$vendeur&destination=$destination&date=$date_f&user_id=0\">Ajout Commande</a></td>";?>
</tr>

<table class="table2">

<tr>
	<th><?php echo "Fournisseur";?></th>
	<th><?php echo "Articles";?></th>
	<th><?php echo "Date";?></th>
	
</tr>

<?php 

$total_g=0;
while($users_ = fetch_array($users)) { ?><tr>
<? $commande=$users_["commande"];$bln=$users_["bl"];$bcn=$users_["bc"];$evaluation=$users_["evaluation"];$client=$users_["client"];$date_e=dateUsToFr($users_["date_e"]);
$vendeur=$users_["vendeur"];$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];
$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$id=$users_["id"]; $date_en=dateFrToUs($users_["date"]);$ev_pre=$users_["ev_pre"];
echo "<td><a href=\"bc_mps_details.php?date=$date_e&user_id=$id\">$client</a></td>";$ref=$users_["vendeur"];?>
<? echo "<td><a href=\"enregistrer_panier_bc_mps.php?vendeur=$vendeur&client=$client&date=$date_e&numero=$commande\">Detail commande </a>";?>
<td><?php echo $date_e; ?></td>
<? }?>

</table>
<tr>
</tr>

<p style="text-align:center">
</body>

</html>