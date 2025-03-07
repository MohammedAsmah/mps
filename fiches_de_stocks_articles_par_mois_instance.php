<?php
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$produit = $_REQUEST["produit"];$condit = $_REQUEST["condit"];$prix = $_REQUEST["prix"];$poids = $_REQUEST["poids"];
			$tige=$_REQUEST["tige"];$qte_tige=$_REQUEST["qte_tige"];
			$stock_initial = $_REQUEST["stock_initial"];
			$stock_final = $_REQUEST["stock_initial"]+$_REQUEST["production"]-$_REQUEST["qte_vendu"];
			$encours = $_REQUEST["encours"];
			
			$type = $_REQUEST["type"];$famille = $_REQUEST["famille"];
			$accessoire_1 = $_REQUEST["accessoire_1"];$accessoire_2 = $_REQUEST["accessoire_2"];$accessoire_3 = $_REQUEST["accessoire_3"];
			$qte_ac_1 = $_REQUEST["qte_ac_1"];$qte_ac_2 = $_REQUEST["qte_ac_2"];$qte_ac_3 = $_REQUEST["qte_ac_3"];
			if(isset($_REQUEST["non_disponible"])) { $non_disponible = 1; } else { $non_disponible = 0; }
			
			$production = $_REQUEST["production"];$poids_evaluation = $_REQUEST["poids_evaluation"];
			$prix_revient = $_REQUEST["prix_revient"];$prix_revient_final = $_REQUEST["prix_revient_final"];
			$stock_ini_exe = $_REQUEST["stock_ini_exe"];
			if(isset($_REQUEST["liquider"])) { $liquider = 1; } else { $liquider = 0; }
			if(isset($_REQUEST["favoris"])) { $favoris = 1; } else { $favoris = 0; }
			if(isset($_REQUEST["non_favoris"])) { $non_favoris = 1; } else { $non_favoris = 0; }
			if(isset($_REQUEST["dispo"])) { $dispo = 1; } else { $dispo = 0; }
			if(isset($_REQUEST["stock_controle"])) { $stock_controle = 1; } else { $stock_controle = 0; }
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO produits ( produit, condit, prix,dispo, tige,qte_tige,matiere,qte_matiere,emballage,qte_emballage,emballage2,qte_emballage2,emballage3,qte_emballage3,
				etiquette,qte_etiquette,favoris,non_favoris,accessoire_1,accessoire_2,accessoire_3,qte_ac_1,qte_ac_2,qte_ac_3,type,famille,non_disponible,stock_controle,poids_evaluation,poids ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $condit . "', ";
				$sql .= "'" . $prix . "', ";
				$sql .= "'" . $dispo . "', ";
				$sql .= "'" . $_REQUEST["tige"] . "', ";
				$sql .= "'" . $_REQUEST["qte_tige"] . "', ";
				$sql .= "'" . $_REQUEST["matiere"] . "', ";
				$sql .= "'" . $_REQUEST["qte_matiere"] . "', ";
				$sql .= "'" . $_REQUEST["emballage"] . "', ";
				$sql .= "'" . $_REQUEST["qte_emballage"] . "', ";
				$sql .= "'" . $_REQUEST["emballage2"] . "', ";
				$sql .= "'" . $_REQUEST["qte_emballage2"] . "', ";
				$sql .= "'" . $_REQUEST["emballage3"] . "', ";
				$sql .= "'" . $_REQUEST["qte_emballage3"] . "', ";
				
				$sql .= "'" . $_REQUEST["etiquette"] . "', ";
				$sql .= "'" . $_REQUEST["qte_etiquette"] . "', ";
				$sql .= "'" . $favoris . "', ";
				$sql .= "'" . $non_favoris . "', ";
				$sql .= "'" . $accessoire_1 . "', ";
				$sql .= "'" . $accessoire_2 . "', ";
				$sql .= "'" . $accessoire_3 . "', ";
				$sql .= "'" . $qte_ac_1 . "', ";
				$sql .= "'" . $qte_ac_2 . "', ";
				$sql .= "'" . $qte_ac_3 . "', ";
				$sql .= "'" . $type . "', ";$sql .= "'" . $famille . "', ";
				$sql .= "'" . $non_disponible . "', ";
				$sql .= "'" . $stock_controle . "', ";
				$sql .= "'" . $poids_evaluation . "', ";
				$sql .= $poids . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE produits SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "', ";
			$sql .= "favoris = '" . $favoris . "', ";
			$sql .= "non_favoris = '" . $non_favoris . "', ";
			$sql .= "condit = '" . $condit . "', ";
			$sql .= "dispo = '" . $dispo . "', ";
			$sql .= "encours = '" . $encours . "', ";
			$sql .= "stock_ini_exe = '" . $stock_ini_exe . "', ";
			$sql .= "prix_revient = '" . $prix_revient . "', ";
			$sql .= "prix_revient_final = '" . $prix_revient_final . "', ";
			$sql .= "prix = '" . $prix . "', ";
			$sql .= "poids_evaluation = '" . $poids_evaluation . "', ";
			$sql .= "accessoire_1 = '" . $accessoire_1 . "', ";
			$sql .= "accessoire_2 = '" . $accessoire_2 . "', ";
			$sql .= "accessoire_3 = '" . $accessoire_3 . "', ";
			$sql .= "qte_ac_1 = '" . $qte_ac_1 . "', ";
			$sql .= "qte_ac_2 = '" . $qte_ac_2 . "', ";
			$sql .= "qte_ac_3 = '" . $qte_ac_3 . "', ";
			$sql .= "type = '" . $type . "', ";
			$sql .= "non_disponible = '" . $non_disponible . "', ";
			$sql .= "stock_controle = '" . $stock_controle . "', ";
			$sql .= "tige = '" . $_REQUEST["tige"] . "', ";
			$sql .= "qte_tige = '" . $_REQUEST["qte_tige"] . "', ";
			$sql .= "matiere = '" . $_REQUEST["matiere"] . "', ";
			$sql .= "qte_matiere = '" . $_REQUEST["qte_matiere"] . "', ";
			$sql .= "emballage = '" . $_REQUEST["emballage"] . "', ";
			$sql .= "qte_emballage = '" . $_REQUEST["qte_emballage"] . "', ";
			$sql .= "emballage2 = '" . $_REQUEST["emballage2"] . "', ";
			$sql .= "qte_emballage2 = '" . $_REQUEST["qte_emballage2"] . "', ";
			$sql .= "emballage3 = '" . $_REQUEST["emballage3"] . "', ";
			$sql .= "qte_emballage3 = '" . $_REQUEST["qte_emballage3"] . "', ";
			$sql .= "famille = '" . $famille . "', ";
			$sql .= "etiquette = '" . $_REQUEST["etiquette"] . "', ";
			$sql .= "qte_etiquette = '" . $_REQUEST["qte_etiquette"] . "', ";
			$sql .= "liquider = '" . $liquider . "', ";
			$sql .= "poids = '" . $poids . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM produits WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	
	// recherche ville
	?>
	
	<?
	$sql  = "SELECT * ";$vide="";$acc="Accessoire";$poids_total=0;
	$sql .= "FROM produits where dispo=1 and famille <> '$acc' ORDER BY produit;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Produits"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "fiche_de_stock_article.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Sorties de Stock en Quantités"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Designation";?></th>
	<th><?php echo "Stock ini.";?></th>
	<th><?php echo "Jan.";?></th>
	<th><?php echo "Fev";?></th>
	<th><?php echo "Mars";?></th>
	<th><?php echo "Avril";?></th>
	<th><?php echo "Mai";?></th>
	<th><?php echo "Juin.";?></th>
	<th><?php echo "Juill";?></th>
	<th><?php echo "Aout";?></th>
	<th><?php echo "Sep";?></th>
	<th><?php echo "Oct";?></th>
	<th><?php echo "Nov";?></th>
	<th><?php echo "Dec";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?>


		<? 
		$stock_ini=$users_["stock_ini_exe"];$solde=0;$condit=$users_["condit"];
		
		$janvier=0;
		$fevrier=0;
		$mars=0;
		$avril=0;
		$mai=0;
		$juin=0;
		$juillet=0;
		$aout=0;
		$septembre=0;
		$octobre=0;
		$novembre=0;
		$decembre=0;
		$janvier_p=0;
		$fevrier_p=0;
		$mars_p=0;
		$avril_p=0;
		$mai_p=0;
		$juin_p=0;
		$juillet_p=0;
		$aout_p=0;
		$septembre_p=0;
		$octobre_p=0;
		$novembre_p=0;
		$decembre_p=0;
	 
 		$produit=$users_["produit"];$d1="2014-01-01";$d2="2014-12-31";$qte=0;
		$sql1  = "SELECT * ";$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$d1' and '$d2' ) ORDER BY produit;";$users11 = db_query($database_name, $sql1);
		while($users11_ = fetch_array($users11)) { 
		$date=$users11_["date_f"];
		if ($date>="2014-01-01" and $date<="2014-01-31"){$janvier=$janvier+($users11_["quantite"]*$users11_["condit"]);$poids_total=$poids_total+($users11_["quantite"]*$users11_["condit"]*$users_["poids"]);}
		if ($date>="2014-02-01" and $date<="2014-02-28"){$fevrier=$fevrier+($users11_["quantite"]*$users11_["condit"]);$poids_total=$poids_total+($users11_["quantite"]*$users11_["condit"]*$users_["poids"]);}
		if ($date>="2014-03-01" and $date<="2014-03-31"){$mars=$mars+($users11_["quantite"]*$users11_["condit"]);$poids_total=$poids_total+($users11_["quantite"]*$users11_["condit"]*$users_["poids"]);}
		if ($date>="2014-04-01" and $date<="2014-04-30"){$avril=$avril+($users11_["quantite"]*$users11_["condit"]);$poids_total=$poids_total+($users11_["quantite"]*$users11_["condit"]*$users_["poids"]);}
		if ($date>="2014-05-01" and $date<="2014-05-31"){$mai=$mai+($users11_["quantite"]*$users11_["condit"]);$poids_total=$poids_total+($users11_["quantite"]*$users11_["condit"]*$users_["poids"]);}
		if ($date>="2014-06-01" and $date<="2014-06-30"){$juin=$juin+($users11_["quantite"]*$users11_["condit"]);$poids_total=$poids_total+($users11_["quantite"]*$users11_["condit"]*$users_["poids"]);}
		if ($date>="2014-07-01" and $date<="2014-07-31"){$juillet=$juillet+($users11_["quantite"]*$users11_["condit"]);$poids_total=$poids_total+($users11_["quantite"]*$users11_["condit"]*$users_["poids"]);}
		if ($date>="2014-08-01" and $date<="2014-08-31"){$aout=$aout+($users11_["quantite"]*$users11_["condit"]);$poids_total=$poids_total+($users11_["quantite"]*$users11_["condit"]*$users_["poids"]);}
		if ($date>="2014-09-01" and $date<="2014-09-30"){$septembre=$septembre+($users11_["quantite"]*$users11_["condit"]);$poids_total=$poids_total+($users11_["quantite"]*$users11_["condit"]*$users_["poids"]);}
		if ($date>="2014-10-01" and $date<="2014-10-31"){$octobre=$octobre+($users11_["quantite"]*$users11_["condit"]);$poids_total=$poids_total+($users11_["quantite"]*$users11_["condit"]*$users_["poids"]);}
		if ($date>="2014-11-01" and $date<="2014-11-30"){$novembre=$novembre+($users11_["quantite"]*$users11_["condit"]);$poids_total=$poids_total+($users11_["quantite"]*$users11_["condit"]*$users_["poids"]);}
		if ($date>="2014-12-01" and $date<="2014-12-31"){$decembre=$decembre+($users11_["quantite"]*$users11_["condit"]);$poids_total=$poids_total+($users11_["quantite"]*$users11_["condit"]*$users_["poids"]);}
		
				
		}
		
		
		///////////////////
		$sql1  = "SELECT * ";
			$sql1 .= "FROM entrees_stock_f where produit='$produit' and (date between '$d1' and '$d2' ) ORDER BY produit;";
			$users11p = db_query($database_name, $sql1);
			while($users11_p = fetch_array($users11p)) { 
			$date=$users11_p["date"];
		if ($date>="2014-01-01" and $date<="2014-01-31"){$janvier_p=$janvier_p+($users11_p["depot_a"]*$condit);}
		if ($date>="2014-02-01" and $date<="2014-02-28"){$fevrier_p=$fevrier_p+($users11_p["depot_a"]*$condit);}
		if ($date>="2014-03-01" and $date<="2014-03-31"){$mars_p=$mars_p+($users11_p["depot_a"]*$condit);}
		if ($date>="2014-04-01" and $date<="2014-04-30"){$avril_p=$avril_p+($users11_p["depot_a"]*$condit);}
		if ($date>="2014-05-01" and $date<="2014-05-31"){$mai_p=$mai_p+($users11_p["depot_a"]*$condit);}
		if ($date>="2014-06-01" and $date<="2014-06-30"){$juin_p=$juin_p+($users11_p["depot_a"]*$condit);}
		if ($date>="2014-07-01" and $date<="2014-07-31"){$juillet_p=$juillet_p+($users11_p["depot_a"]*$condit);}
		if ($date>="2014-08-01" and $date<="2014-08-31"){$aout_p=$aout_p+($users11_p["depot_a"]*$condit);}
		if ($date>="2014-09-01" and $date<="2014-09-30"){$septembre_p=$septembre_p+($users11_p["depot_a"]*$condit);}
		if ($date>="2014-10-01" and $date<="2014-10-31"){$octobre_p=$octobre_p+($users11_p["depot_a"]*$condit);}
		if ($date>="2014-11-01" and $date<="2014-11-30"){$novembre_p=$novembre_p+($users11_p["depot_a"]*$condit);}
		if ($date>="2014-12-01" and $date<="2014-12-31"){$decembre_p=$decembre_p+($users11_p["depot_a"]*$condit);}
			
			}
		
		
		$total=$janvier+$fevrier+$mars+$avril+$mai+$juin+$juillet+$aout+$septembre+$octobre+$novembre+$decembre;

 $r_janvier=$stock_ini+$janvier_p-$janvier;
 $r_fevrier=$r_janvier+$fevrier_p-$fevrier;  
 $r_mars=$r_fevrier+$mars_p-$mars;  
 $r_avril=$r_mars+$avril_p-$avril;
 $r_mai=$r_avril+$mai_p-$mai;
 $r_juin=$r_mai+$juin_p-$juin;
 $r_juillet=$r_juin+$juillet_p-$juillet;
 $r_aout=$r_juillet+$aout_p-$aout;
 $r_septembre=$r_aout+$septembre_p-$septembre;
 $r_octobre=$r_septembre+$octobre_p-$octobre;
 $r_novembre=$r_octobre+$novembre_p-$novembre;
 $r_decembre=$r_novembre+$decembre_p-$decembre;
	
	//$sorties=$janvier+$fevrier+$mars+$avril+$mai+$juin+$juillet+$aout+
 if ($r_mai<0){
 ?><tr>
<td style="text-align:left" bgcolor="#66CCCC"><?php echo $users_["produit"]; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $stock_ini;  ?></td>
<td bgcolor="#66CCCC" align="right"><table><tr><td><?php echo "S: ".$janvier;  ?></td></tr><tr><td><?php echo "E: ".$janvier_p;  ?></td></tr><tr><td><?php echo "R: ".$r_janvier;  ?></td></tr></table></td>
<td bgcolor="#66CCCC" align="right"><table><tr><td><?php echo "S: ".$fevrier;  ?></td></tr><tr><td><?php echo "E: ".$fevrier_p;  ?></td></tr><tr><td><?php echo "R: ".$r_fevrier;  ?></td></tr></table></td>
<td bgcolor="#66CCCC" align="right"><table><tr><td><?php echo "S: ".$mars;  ?></td></tr><tr><td><?php echo "E: ".$mars_p;  ?></td></tr><tr><td><?php echo "R: ".$r_mars;  ?></td></tr></table></td>
<td bgcolor="#66CCCC" align="right"><table><tr><td><?php echo "S: ".$avril;  ?></td></tr><tr><td><?php echo "E: ".$avril_p;  ?></td></tr><tr><td><?php echo "R: ".$r_avril;  ?></td></tr></table></td>
<td bgcolor="#66CCCC" align="right"><table><tr><td><?php echo "S: ".$mai;  ?></td></tr><tr><td><?php echo "E: ".$mai_p;  ?></td></tr><tr><td><?php echo "R: ".$r_mai;  ?></td></tr></table></td>
<td bgcolor="#66CCCC" align="right"><table><tr><td><?php echo "S: ".$juin;  ?></td></tr><tr><td><?php echo "E: ".$juin_p;  ?></td></tr><tr><td><?php echo "R: ".$r_juin;  ?></td></tr></table></td>
<td bgcolor="#66CCCC" align="right"><table><tr><td><?php echo "S: ".$juillet;  ?></td></tr><tr><td><?php echo "E: ".$juillet_p;  ?></td></tr><tr><td><?php echo "R: ".$r_juillet;  ?></td></tr></table></td>
<td bgcolor="#66CCCC" align="right"><table><tr><td><?php echo "S: ".$aout;  ?></td></tr><tr><td><?php echo "E: ".$aout_p;  ?></td></tr><tr><td><?php echo "R: ".$r_aout;  ?></td></tr></table></td>
<td bgcolor="#66CCCC" align="right"><table><tr><td><?php echo "S: ".$septembre;  ?></td></tr><tr><td><?php echo "E: ".$septembre_p;  ?></td></tr><tr><td><?php echo "R: ".$r_septembre;  ?></td></tr></table></td>
<td bgcolor="#66CCCC" align="right"><table><tr><td><?php echo "S: ".$octobre;  ?></td></tr><tr><td><?php echo "E: ".$octobre_p;  ?></td></tr><tr><td><?php echo "R: ".$r_octobre;  ?></td></tr></table></td>
<td bgcolor="#66CCCC" align="right"><table><tr><td><?php echo "S: ".$novembre;  ?></td></tr><tr><td><?php echo "E: ".$novembre_p;  ?></td></tr><tr><td><?php echo "R: ".$r_novembre;  ?></td></tr></table></td>
<td bgcolor="#66CCCC" align="right"><table><tr><td><?php echo "S: ".$decembre;  ?></td></tr><tr><td><?php echo "E: ".$decembre_p;  ?></td></tr><tr><td><?php echo "R: ".$r_decembre;  ?></td></tr></table></td>
<? }?>

<? }?>

</table>

<p style="text-align:center">

	
	<? ?>

</body>

</html>