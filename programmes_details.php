<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$user_login = $user_["login"];
	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	if(isset($_REQUEST["action_"]))
	 {$id_production=$_POST["id_production"];
	 
	 if ($user_login=="admin" or $user_login=="nezha" or $user_login=="arahal"){
	 		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
				$machine=$_REQUEST["machine"];$produit=$_REQUEST["produit"];$du=dateFrToUs($_REQUEST["du"]);$au=dateFrToUs($_REQUEST["au"]);
				$prod_6_14=$_REQUEST["prod_6_14"];$date_ins=date("Y-m-d");$prod_14_22=$_REQUEST["prod_14_22"];$prod_22_6=$_REQUEST["prod_22_6"];
				$rebut=$_REQUEST["rebut"];$poids=$_REQUEST["poids"];$tc1=$_REQUEST["tc1"];$tc2=$_REQUEST["tc2"];$tc3=$_REQUEST["tc3"];
				$temps_arret_h=$_REQUEST["temps_arret_h"];$temps_arret_m=$_REQUEST["temps_arret_m"];$obs_machine=$_REQUEST["obs_machine"];
				$sql  = "SELECT * ";
		$sql .= "FROM machines WHERE designation = '" . $machine . "';";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$ordre = $user_["ordre"];
				$sql  = "INSERT INTO registre_postes ( id_semaine,du,au,produit,poste )
					VALUES ('$id_production','$du','$au','$produit','$machine')";
					db_query($database_name, $sql);
					
			break;

			case "update_user":
			$equipe=$_REQUEST["equipe"];
			if ($equipe==1){
			$sql = "UPDATE registre_postes SET ";
			$sql .= "prod_6_14 = '" . $_REQUEST["prod_6_14"] . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);		
			$disponible=0;$affectation="oui";$affectation_non="non";
			$sql1 = "UPDATE employes SET ";
			$sql1 .= "affectation = '" . $affectation . "' ";
			
			$sql1 .= "WHERE employe = '" . $_REQUEST["prod_6_14"] . "';";
			db_query($database_name, $sql1);
			
			//
			$sql1 = "UPDATE employes SET ";
			$sql1 .= "affectation = '" . $affectation_non . "' ";
			
			$sql1 .= "WHERE employe = '" . $_REQUEST["prod_6_14_ancien"] . "';";
			db_query($database_name, $sql1);
			
			
			}
			if ($equipe==2){
			$sql = "UPDATE registre_postes SET ";
			$sql .= "prod_14_22 = '" . $_REQUEST["prod_14_22"] . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);		
			$disponible=0;$affectation="oui";$affectation_non="non";
			$sql1 = "UPDATE employes SET ";
			$sql1 .= "affectation = '" . $affectation . "' ";
			
			$sql1 .= "WHERE employe = '" . $_REQUEST["prod_14_22"] . "';";
			db_query($database_name, $sql1);
			
			//
			$sql1 = "UPDATE employes SET ";
			$sql1 .= "affectation = '" . $affectation_non . "' ";
			
			$sql1 .= "WHERE employe = '" . $_REQUEST["prod_14_22_ancien"] . "';";
			db_query($database_name, $sql1);
			
			}
			if ($equipe==3){
			$sql = "UPDATE registre_postes SET ";
			$sql .= "prod_22_6 = '" . $_REQUEST["prod_22_6"] . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);		
			
			$disponible=0;$affectation="oui";$affectation_non="non";
			$sql1 = "UPDATE employes SET ";
			$sql1 .= "affectation = '" . $affectation . "' ";
			
			$sql1 .= "WHERE employe = '" . $_REQUEST["prod_22_6"] . "';";
			db_query($database_name, $sql1);
			
			//
			$sql1 = "UPDATE employes SET ";
			$sql1 .= "affectation = '" . $affectation_non . "' ";
			
			$sql1 .= "WHERE employe = '" . $_REQUEST["prod_22_6_ancien"] . "';";
			db_query($database_name, $sql1);
			
			}
			
			//////////////////////////////////////////////////
			
			
			
			//////////////////////////////////////////////
			break;
			
			case "delete_user":
					$sql  = "SELECT * ";
					$sql .= "FROM details_productions WHERE id = " . $_REQUEST["user_id"] . ";";
					$user = db_query($database_name, $sql); $user_ = fetch_array($user);
					$date = $user_["date"];$id_production = $user_["id_production"];

			// delete user's profile
			$sql = "DELETE FROM details_productions WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			}

		} //switch
	 }else{

		$id_production=$_GET["id_production"];}
	
		$sql  = "SELECT * ";
		$sql .= "FROM registre_programmes WHERE id = " . $id_production . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$du = dateUsToFr($user_["du"]);$au = dateUsToFr($user_["au"]);

	$sql  = "SELECT * ";$today=date("y-m-d");
	$sql .= "FROM registre_postes where id_semaine='$id_production' ORDER BY id;";
	
	
	$users = db_query($database_name, $sql);

	?>
	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Production $date "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Programme Du $du Au $au"; ?></span>
<? echo "<span><a href=\"programme_detail.php?id_production=$id_production&user_id=0\">Ajout</a></span>";?>

<table class="table2">

<tr>
	<th><?php echo "Machine";?></th>
	<th><?php echo "Produit";?></th>
        <td width="70"><?php echo " 07-15 "; ?></td>
        <td width="70"><?php echo " 15-23 "; ?></td>
        <td width="70"><?php echo " 23-07 "; ?></td>
       

</tr>
<?php $obs_g="";while($users_ = fetch_array($users)) { ?><tr>
<? $id_production=$id_production;$id=$users_["id"];$machine=$users_["poste"];$obs_machine=$users_["obs_machine"];$obs_g .= '<br>'.$obs_machine;
$m="<td>$machine</td>";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");?>
<td style="text-align:left"><?php $p=$users_["produit"]; 

		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = " . $p . ";";
		$user = db_query($database_name, $sql); $user_p = fetch_array($userp);
		$poidsp = $user_["poids"];








print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$p </font>");?></td>
<td style="text-align:center"><?php $p1="*".$users_["prod_6_14"]."*";$pp1="<a href=\"programme_detail1.php?id_production=$id_production&user_id=$id\">$p1</a>";
print("<font size=\"2\" face=\"Comic sans MS\" color=\"000033\">$pp1 </font>"); ?></td>
<td style="text-align:center"><?php $p2= "*".$users_["prod_14_22"]."*";$pp2="<a href=\"programme_detail2.php?id_production=$id_production&user_id=$id\">$p2</a>";
print("<font size=\"2\" face=\"Comic sans MS\" color=\"000033\">$pp2 </font>"); ?></td>
<td style="text-align:center"><?php $p3= "*".$users_["prod_22_6"]."*";$pp3="<a href=\"programme_detail3.php?id_production=$id_production&user_id=$id\">$p3</a>";
print("<font size=\"2\" face=\"Comic sans MS\" color=\"000033\">$pp3 </font>"); ?></td>

<?php } ?>
<? echo "<a href=\"\\mps\\tutorial\\fiche_production_24.php?id_production=$id_production\">Imprimer Fiche</a>";?>
</table>
<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$obs_g </font>"); ?></td>
<p style="text-align:center">



<?php $obs_g="";

$sql  = "SELECT * ";$occ="occasionnelles";$per="permanents";$vide="";$non="non";
	$sql .= "FROM employes where employe<>'$vide' and statut=0 and (service='$occ' or service='$per') and affectation='$non' and hs=0 ORDER BY employe;";
	$users = db_query($database_name, $sql);$erreur=0;$compteur=0;


?>
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
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<? $compteur=$compteur+1;if($users_["conge"]==1){ ?>
<td bgcolor="#66CCCC"><?php echo $compteur." - ".$users_["employe"];?></td>
<? }else { ?><td><?php echo $compteur." - ".$users_["employe"];?></td>
<? }?>



<td align="center" ><input type="checkbox" id="machine" name="machine"<?php if($users_["machine"]) { echo " checked"; } ?>   ></td>
<td align="center"><input type="checkbox" id="machine" name="machine"<?php if($users_["laveuse"]) { echo " checked"; } ?> ></td>
<td align="center"><input type="checkbox" id="machine" name="machine"<?php if($users_["extrudeuse"]) { echo " checked"; } ?> ></td>
<td align="center"><input type="checkbox" id="machine" name="machine"<?php if($users_["broyeur"]) { echo " checked"; } ?> ></td>
<td align="center"><input type="checkbox" id="machine" name="machine"<?php if($users_["melange"]) { echo " checked"; } ?> ></td>
<td align="center"><input type="checkbox" id="machine" name="machine"<?php if($users_["services"]) { echo " checked"; } ?> ></td>
<td align="center"><input type="checkbox" id="machine" name="machine"<?php if($users_["chargement"]) { echo " checked"; } ?> ></td>
<td align="center"><input type="checkbox" id="machine" name="machine"<?php if($users_["emballage"]) { echo " checked"; } ?> ></td>



<?php } ?>

</table>
</body>

</html>