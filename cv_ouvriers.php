<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();$user_name=GetUserName();
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$employe = $_REQUEST["employe"];$ref = $_REQUEST["ref"];$service = $_REQUEST["service"];$poste = $_REQUEST["poste"];$ordre = $_REQUEST["ordre"];
			$poste = $_REQUEST["poste"];if(isset($_REQUEST["statut"])) { $statut = 1; } else { $statut = 0; }
			$t_h_normales = $_REQUEST["t_h_normales"];$t_h_25 = $_REQUEST["t_h_25"];$t_h_50 = $_REQUEST["t_h_50"];
			if(isset($_REQUEST["manual"])) { $manual = 1; } else { $manual = 0; }
				$sam_m = $_REQUEST["sam_m"];$dim_m = $_REQUEST["dim_m"];$lun_m = $_REQUEST["lun_m"];$mar_m = $_REQUEST["mar_m"];
			$mer_m = $_REQUEST["mer_m"];$jeu_m = $_REQUEST["jeu_m"];$ven_m = $_REQUEST["ven_m"];
			$sam_s = $_REQUEST["sam_s"];$dim_s = $_REQUEST["dim_s"];$lun_s = $_REQUEST["lun_s"];$mar_s = $_REQUEST["mar_s"];
			$mer_s = $_REQUEST["mer_s"];$jeu_s = $_REQUEST["jeu_s"];$ven_s = $_REQUEST["ven_s"];
			$sam_sup = $_REQUEST["sam_sup"];$dim_sup = $_REQUEST["dim_sup"];$lun_sup = $_REQUEST["lun_sup"];$mar_sup = $_REQUEST["mar_sup"];
			$mer_sup = $_REQUEST["mer_sup"];$jeu_sup = $_REQUEST["jeu_sup"];$ven_sup = $_REQUEST["ven_sup"];
			if(isset($_REQUEST["valide"])) { $valide = 1; } else { $valide = 0; }
			$observations = $_REQUEST["observations"];
			if(isset($_REQUEST["machine"]) ) { $machine = 1; } else { $machine = 0; }
			if(isset($_REQUEST["laveuse"]) ) { $laveuse = 1; } else { $laveuse = 0; }
			if(isset($_REQUEST["extrudeuse"]) )  { $extrudeuse = 1; } else { $extrudeuse = 0; }
			if(isset($_REQUEST["broyeur"])) { $broyeur = 1; } else { $broyeur = 0; }
			if(isset($_REQUEST["melange"]) ) { $melange = 1; } else { $melange = 0; }
			if(isset($_REQUEST["services"]) ) { $services = 1; } else { $services = 0; }
			if(isset($_REQUEST["chargement"]) ) { $chargement = 1; } else { $chargement = 0; }
			if(isset($_REQUEST["emballage"]) ) { $emballage = 1; } else { $emballage = 0; }
			$autres = $_REQUEST["autres"];
			
			
		
		$repos=0;if ($sam_m+$sam_s==0 or $lun_m+$lun_s==0 or $mar_m+$mar_s==0 or $mer_m+$mer_s==0 
			or $jeu_m+$jeu_s==0 or $ven_m+$ven_s==0){$repos=1;}
		
		
		$hn=0;$t_h_s_25=0;$t_h_s_50=0;
		$heures_normales=$sam_m+$sam_s+$lun_m+$lun_s+$mar_m+$mar_s+$mer_m+$mer_s+$jeu_m+$jeu_s+$ven_m+$ven_s;
		$heures_sup=$sam_sup+$lun_sup+$mar_sup+$mer_sup+$jeu_sup+$ven_sup;
		$ht=$heures_normales+$heures_sup;
		if ($heures_normales>=44)
		{$hn=44;$t_h_s_25=$sam_sup+$lun_sup+$mar_sup+$mer_sup+$jeu_sup+$ven_sup+($heures_normales-44);
		if ($repos==0){$t_h_s_50=$dim_m+$dim_s+$dim_sup;}
		else{$t_h_s_25=$t_h_s_25+$dim_m+$dim_s+$dim_sup;$t_h_s_50=0;}}
		else {
			if ($heures_normales+$heures_sup>=44)
				{$hn=44;$t_h_s_25=$ht-44;if ($repos==0){$t_h_s_50=$dim_m+$dim_s+$dim_sup;}else{$t_h_s_25=$t_h_s_25+$dim_m+$dim_s+$dim_sup;$t_h_s_50=0;}}
				else
				{$htt=$heures_normales+$heures_sup+$dim_m+$dim_s+$dim_sup;
				if ($htt>=44){$hn=44;$t_h_s_25=$htt-44;$t_h_s_50=0;}
				else {$hn=$heures_normales+$heures_sup+$dim_m+$dim_s+$dim_sup;$t_h_s_25=0;$t_h_s_50=0;}
				}
			}
			
		////////////////////////////////////////////////////////
			
			
			
			
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE employes SET machine = '$machine' ,laveuse = '$laveuse' ,extrudeuse = '$extrudeuse' ,broyeur = '$broyeur' ,melange = '$melange' ,services = '$services' ,chargement = '$chargement' ,emballage = '$emballage' ,
			autres = '$autres' 	WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM employes WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";$occ="occasionnelles";$per="permanents";$vide="";
	$sql .= "FROM employes where employe<>'$vide' and statut=0 and (service='$occ' or service='$per') ORDER BY employe;";
	$users = db_query($database_name, $sql);$erreur=0;$compteur=0;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Pointage "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "cv_ouvrier.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Compétences "; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Nom et Prenom ";?></th>
	<th><?php echo "Machine";?></th>
	<th><?php echo "Laveuse";?></th>
	<th><?php echo "Extrudeuse";?></th>
	<th><?php echo "Broyeur";?></th>
	<th><?php echo "Mélange";?></th>
	<th><?php echo "Services";?></th>
	<th><?php echo "Chargement";?></th>	
	<th><?php echo "Emballage";?></th>	
	<th><?php echo "Autres";?></th>		
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<? $compteur=$compteur+1;if($login=="admin" or $login=="nezha"){ ?>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["ordre"]." - ".$users_["employe"];?></A></td>
<? }else { ?><td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["ordre"]." - ".$users_["employe"];?></A></td>
<? }?>



<td align="center" ><input type="checkbox" id="machine" name="machine"<?php if($users_["machine"]) { echo " checked"; } ?>   ></td>
<td align="center"><input type="checkbox" id="machine" name="machine"<?php if($users_["laveuse"]) { echo " checked"; } ?> ></td>
<td align="center"><input type="checkbox" id="machine" name="machine"<?php if($users_["extrudeuse"]) { echo " checked"; } ?> ></td>
<td align="center"><input type="checkbox" id="machine" name="machine"<?php if($users_["broyeur"]) { echo " checked"; } ?> ></td>
<td align="center"><input type="checkbox" id="machine" name="machine"<?php if($users_["melange"]) { echo " checked"; } ?> ></td>
<td align="center"><input type="checkbox" id="machine" name="machine"<?php if($users_["services"]) { echo " checked"; } ?> ></td>
<td align="center"><input type="checkbox" id="machine" name="machine"<?php if($users_["chargement"]) { echo " checked"; } ?> ></td>
<td align="center"><input type="checkbox" id="machine" name="machine"<?php if($users_["emballage"]) { echo " checked"; } ?> ></td>
<td><?php echo $users_["autres"]; ?></td>


<?php } ?>

</table>

<p style="text-align:center">


</body>

</html>