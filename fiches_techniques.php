<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	$id_produit = $_GET["id_produit"];$produit = $_GET["produit"];$prix = number_format($_GET["prix"],2,',',' ');$categorie = $_GET["categorie"];
	
	$condit = $_GET["condit"];$poids_art = number_format($_GET["poids_art"],0,',',' ');
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action"]) && $profile_id == 1) { 

		if($_REQUEST["action"] != "delete_user") {
			// prepares data to simplify database insert or update
			$accessoire = $_REQUEST["accessoire"];$qte = $_REQUEST["qte"];$matiere = $_REQUEST["matiere"];$id_produit = $_REQUEST["id_produit"];$produit = $_REQUEST["produit"];
			$homo = $_REQUEST["homo"];$copo = $_REQUEST["copo"];$mlv = $_REQUEST["mlv"];$mrb = $_REQUEST["mrb"];$charge = $_REQUEST["charge"];$homos = $_REQUEST["homos"];
			$poids = $_REQUEST["poids"];$emb_separe = 0;
			//if(isset($_REQUEST["emb_separe"])) { $emb_separe = 1; } else { $emb_separe = 0; }
		}
		
		switch($_REQUEST["action"]) {

			case "insert_new_user":
				$sql  = "SELECT * ";
			$sql .= "FROM produits  where id='$id_produit' ORDER BY produit ASC;";
			$users = db_query($database_name, $sql);$user_p = fetch_array($users);
			$condit = $user_p["condit"];$poids_art = $user_p["poids"];$prix = $user_p["prix"];$produit = $user_p["produit"];$categorie = $_REQUEST["categorie"];
				
				
				$sql  = "INSERT INTO fiches_techniques ( accessoire,id_produit,qte,matiere,homo,copo,mlv,mrb,charge,homos,poids,emb_separe ) VALUES ( ";
				$sql .= "'".$accessoire . "',";
				$sql .= "'".$id_produit . "',";
				$sql .= "'".$qte . "',";
				$sql .= "'".$matiere . "',";
				$sql .= "'".$homo . "',";
				$sql .= "'".$copo . "',";
				$sql .= "'".$mlv . "',";
				$sql .= "'".$mrb . "',";
				$sql .= "'".$charge . "',";
				$sql .= "'".$homos . "',";
				$sql .= "'".$poids . "',";
				$sql .= "'".$emb_separe . "');";
				db_query($database_name, $sql);

			break;

			case "update_user":
			$categorie = $_REQUEST["categorie"];
			$sql  = "SELECT * ";
			$sql .= "FROM produits  where id='$id_produit' ORDER BY produit ASC;";
			$users = db_query($database_name, $sql);$user_p = fetch_array($users);
			$condit = $user_p["condit"];$poids_art = $user_p["poids"];$prix = $user_p["prix"];$produit = $user_p["produit"];
			
			$sql = "UPDATE fiches_techniques SET ";
			$sql .= "accessoire = '" . $accessoire . "', ";
			$sql .= "qte = '" . $qte . "', ";
			$sql .= "matiere = '" . $matiere . "', ";
			$sql .= "homo = '" . $homo . "', ";
			$sql .= "copo = '" . $copo . "', ";
			$sql .= "mlv = '" . $mlv . "', ";
			$sql .= "mrb = '" . $mrb . "', ";
			$sql .= "charge = '" . $charge . "', ";
			$sql .= "homos = '" . $homos . "', ";
			$sql .= "poids = '" . $poids . "', ";
			$sql .= "emb_separe = '" . $emb_separe . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$user_id=$_REQUEST["user_id"];$categorie = $_REQUEST["categorie"];
			$sql  = "SELECT * ";
			$sql .= "FROM fiches_techniques where id='$user_id' ORDER BY id;";
			$users12 = db_query($database_name, $sql);$users_12 = fetch_array($users12);$id_produit=$users_12["id_produit"];
			
			$sql  = "SELECT * ";
			$sql .= "FROM produits  where id='$id_produit' ORDER BY produit ASC;";
			$users = db_query($database_name, $sql);$user_p = fetch_array($users);
			$condit = $user_p["condit"];$poids_art = $user_p["poids"];$prix = $user_p["prix"];$produit = $user_p["produit"];
			
			
			$sql = "DELETE FROM fiches_techniques WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
		
	$sql  = "SELECT * ";
	$sql .= "FROM fiches_techniques where id_produit='$id_produit' ORDER BY id;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "fiche_technique.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><table class="table2">
<?php 

echo "<tr><td>Article : ".$produit."</td></tr><tr><td>Conditionnement : ".$condit."</td></tr><tr><td>Tarif de Vente : ".$prix."</td></tr><tr><td>Poids Article : ".$poids_art."gr</td></tr></table>"; ?></span>

<p style="text-align:center">


<table class="table2">

<tr><th><?php echo "Id";?></th>
	<th><?php echo "Libelle";?></th>
	<th><?php echo "Historique";?></th>
	<th><?php echo "Quantite";?></th>
	<th><?php echo "Matiere et Melange";?></th>
	<th><?php echo "Poids";?></th>
		
</tr>

<?php $poids=0;while($users_ = fetch_array($users)) { ?><tr>
	
	<? $user_id=$users_["id"];
	if ($login=="driss"){echo "<td></td>";}else {echo "<td><a href=\"fiche_technique.php?user_id=$user_id&id_produit=$id_produit&produit=$produit&categorie=$categorie\">$user_id </a>";}?>
	<td><?php $acc=$users_["accessoire"];echo "<a href=\"productions_details_articles.php?produit=$acc\">$acc </a>"; ?></td>
	<td>
	<? $sql  = "SELECT machine,produit,date,poids_1,tc1,sum(prod_6_14) as t_prod_6_14,sum(prod_14_22) as t_prod_14_22,sum(prod_22_6) as t_prod_22_6,
	sum(temps_arret_h_1) as t_temps_arret_h1,sum(temps_arret_m_1) as t_temps_arret_m1,
	sum(temps_arret_h_2) as t_temps_arret_h2,sum(temps_arret_m_2) as t_temps_arret_m2,
	sum(temps_arret_h_3) as t_temps_arret_h3,sum(temps_arret_m_3) as t_temps_arret_m3,
	sum(rebut_1) as t_rebut1,sum(rebut_2) as t_rebut2,sum(rebut_3) as t_rebut3,sum(poids_1) as t_poids,
	sum(tc1) as t_tc1,sum(tc2) as t_tc2,sum(tc3) as t_tc3,sum(jour) as t_jour ";$today=date("y-m-d");
	$sql .= "FROM details_productions where produit='$acc' group by machine ORDER BY date DESC;";
	$users1 = db_query($database_name, $sql);
	?>
<table class="table2">

<tr>
        <td width="70"><?php echo " Machine "; ?></td>
                 

</tr>
<?php $obs_g="";$jour=0;$ht=0;//while($users_1 = fetch_array($users1)) { 
$users_1 = fetch_array($users1)?><tr>
<? $id_production=$id_production;$id=$users_1["id"];$machine=$users_1["machine"];$obs_machine=$users_1["obs_machine"];$poids_1=$users_1["poids_1"];$tc1=$users_1["tc1"];$last_date=dateUsToFr($users_1["date"]);
$p=$users_1["machine"];$jour=$jour+1;$acces=$users_1["produit"];$t_jour= $users_1["t_jour"]; ?>
<? echo "<td><a href=\"productions_details_machines_articles1.php?machine=$machine&produit=$acces\">$machine ----> ($last_date)</a></td>";?>
<?php $p1=intval($users_1["t_prod_6_14"]/$t_jour);?>
<?php $p2=intval($users_1["t_prod_14_22"]/$t_jour); ?>
<?php $p3=intval($users_1["t_prod_22_6"]/$t_jour); ?>
<?php $h= ($users_1["t_temps_arret_h1"]+$users_1["t_temps_arret_h2"]+$users_1["t_temps_arret_h3"])/$t_jour;
$m=($users_1["t_temps_arret_m1"]+$users_1["t_temps_arret_m2"]+$users_1["t_temps_arret_m3"])/$t_jour;
$h_m=$m/60;$h=$h+$h_m;$heure=number_format($h,2,',',' ');$ht=$ht+$h;$total= $users_1["t_prod_22_6"]+$users_1["t_prod_6_14"]+$users_1["t_prod_14_22"];
//print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$heure </font>"); ?>
<?php $rebut= intval(($users_1["t_rebut1"]+$users_1["t_rebut2"]+$users_1["t_rebut3"])/$t_jour);//print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$rebut </font>"); ?>
<?php $moy=intval($total/$t_jour);//print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$poids_1 </font>"); ?>
<?php //print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$tc1 </font>"); ?>


<?php //} ?>

</table>
	
	
	</td>
	
	<td style="text-align:center"><?php echo $users_["qte"]; ?></td>
	<td>
	<table>
		<tr><td><?php echo $users_["matiere"]; ?></td>
		<? if ($users_["homo"]<>0){?><tr><td><?php echo number_format($users_["homo"],0,',',' ')." HOMO"; ?></td><? }?>
		<? if ($users_["copo"]<>0){?><tr><td><?php echo number_format($users_["copo"],0,',',' ')." COPO"; ?></td><? }?>
		<? if ($users_["mlv"]<>0){?><tr><td><?php echo number_format($users_["mlv"],0,',',' ')." MLV"; ?></td><? }?>
		<? if ($users_["mrb"]<>0){?><tr><td><?php echo number_format($users_["mrb"],0,',',' ')." RBR"; ?></td><? }?>
		<? if ($users_["charge"]<>0){?><tr><td><?php echo number_format($users_["charge"],0,',',' ')." CHARGE"; ?></td><? }?>
		<? if ($users_["homos"]<>0){?><tr><td><?php echo number_format($users_["homos"],0,',',' ')." HOMO SABIC"; ?></td><? }?>
	</table>
	</td>
	
	<td style="text-align:center"><?php echo $users_["poids"];$poids=$poids+($users_["poids"]*$users_["qte"]); ?></td>
		
	
<?php } ?>
<tr><td></td><td></td><td></td><td></td><td><?php echo "Poids total : "; ?></td>
<td style="text-align:center"><?php echo $poids; ?></td>

</table>

<p style="text-align:center">
<table class="table2">
<? echo "<td><a href=\"fiche_technique.php?user_id=0&id_produit=$id_produit&produit=$produit&categorie=$categorie\">Ajout Accessoire </a>";?>
<? echo "<td><a href=\"fiches.php?categorie=$categorie\">Fiches $categorie </a>";?>	
</table>
</body>

</html>