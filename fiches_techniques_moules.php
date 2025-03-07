<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	$id_produit = $_GET["id_produit"];$produit = $_GET["produit"];
    $prix = number_format($_GET["prix"],2,',',' ');$categorie = $_GET["categorie"];
	$sql  = "SELECT * ";
			$sql .= "FROM produits  where id='$id_produit' ORDER BY produit ASC;";
			$users = db_query($database_name, $sql);$user_pp = fetch_array($users);
			$image = $user_pp["image"];



	$condit = $_GET["condit"];$poids_art = number_format($_GET["poids_art"],0,',',' ');
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action"]) && $profile_id == 1) { 

		if($_REQUEST["action"] != "delete_user") {
			// prepares data to simplify database insert or update
			$accessoire = $_REQUEST["accessoire"];$qte = $_REQUEST["qte"];$matiere = $_REQUEST["matiere"];$id_produit = $_REQUEST["id_produit"];$produit = $_REQUEST["produit"];
			$homo = $_REQUEST["homo"];$copo = $_REQUEST["copo"];$mlv = $_REQUEST["mlv"];$mrb = $_REQUEST["mrb"];$charge = $_REQUEST["charge"];$homos = $_REQUEST["homos"];
			$poids = $_REQUEST["poids"];$emb_separe = 0;

            //moule
            $numero_moule = $_REQUEST["numero_moule"];
            $couleur_moule = $_REQUEST["couleur_moule"];
            $cycle_moule = $_REQUEST["cycle_moule"];
			$v1 = $_REQUEST["v1"];
			$v2 = $_REQUEST["v2"];
			$v3 = $_REQUEST["v3"];
			//if(isset($_REQUEST["emb_separe"])) { $emb_separe = 1; } else { $emb_separe = 0; }
		}
		
		switch($_REQUEST["action"]) {

			case "insert_new_user":
			

			break;

			case "update_user":
			$categorie = $_REQUEST["categorie"];
            $id_produit = $_REQUEST["id_produit"];
            $sql  = "SELECT * ";
            $sql .= "FROM produits  where id='$id_produit' ORDER BY produit ASC;";
            $users = db_query($database_name, $sql);$user_pp = fetch_array($users);
            $image = $user_pp["image"];
            $condit = $user_pp["condit"];$poids_art = $user_pp["poids"];$prix = $user_pp["prix"];$produit = $user_pp["produit"];

		
			
			$sql = "UPDATE fiches_techniques SET ";
			
            //moule
            $sql .= "numero_moule = '" . $numero_moule . "', ";
            $sql .= "couleur_moule = '" . $couleur_moule . "', ";
			$sql .= "v1 = '" . $v1 . "', ";
			$sql .= "v2 = '" . $v2 . "', ";
			$sql .= "v3 = '" . $v3 . "', ";
            $sql .= "cycle_moule = '" . $cycle_moule . "' ";

			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			
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
	function EditUser(user_id) { document.location = "fiche_technique_moule.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><table class="table2">
<?php 

echo "<tr><td>Article : ".$produit."</td></tr><tr><td>Conditionnement : ".$condit."</td></tr><tr><td>Tarif de Vente : ".$prix."</td></tr><tr><td>Poids Article : ".$poids_art."gr</td></tr></table>"; ?></span>

<p style="text-align:center">

<div class="icon" >
<img src="<?php echo $image ?>" height="200px" width="200px">
</div>
<table class="table2">

<tr><th><?php echo "Id";?></th>
<th><?php echo "Numero";?></th>
	<th><?php echo "Libelle";?></th>
	<th><?php echo "Categorie";?></th>
	<th><?php echo "Cycle";?></th>
	<th><?php echo "Historique";?></th>
		
</tr>

<?php $poids=0;$compt=0;while($users_ = fetch_array($users)) { ?><tr>
	
	<? $user_id=$users_["id"];$compt=$compt+1;
	if ($login=="driss"){echo "<td></td>";}else 
    
    {echo "<td><a href=\"fiche_technique_moule.php?user_id=$user_id&id_produit=$id_produit&produit=$produit&categorie=$categorie\">00$compt </a>";}?>
	<td><?php $numero_moule=$users_["numero_moule"];echo $numero_moule ; $couleur_moule=$users_["couleur_moule"];?></td>
    <td><?php $acc=$users_["accessoire"];echo $acc ; ?></td>
	
	<td bgcolor="<? echo $couleur_moule;?>"><?php ?></td>
	<td align="center"><?php $cycle=$users_["cycle_moule"];echo $cycle ; ?></td>
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
	
	
	<td>
	<table>
		
		
	</table>
	</td>
	
	
    <td><?php $acc=$users_["accessoire"];echo "<a href=\"productions_details_articles.php?produit=$acc\">Historique </a>"; ?></td>
		
	
<?php } ?>
<tr><td></td><td></td><td></td><td></td><td></td>


</table>

<p style="text-align:center">
<table class="table2">
<? ?>
<? echo "<td><a href=\"fiches_moules.php?categorie=$categorie\">Fiches $categorie </a>";?>	
</table>
</body>

</html>