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

<?php while($users_ = fetch_array($users)) { ?><tr>


		<? 
		$stock_ini=$users_["stock_ini_exe"];$solde=0;
		
		
		//janvier
		$produit=$users_["produit"];$d1="2013-01-01";$d2="2013-01-31";$qte=0;
		$sql1  = "SELECT * ";$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$d1' and '$d2' ) ORDER BY produit;";$users11 = db_query($database_name, $sql1);
		while($users11_ = fetch_array($users11)) { $qte=$qte+($users11_["quantite"]*$users11_["condit"]);}
		$poids_total=$poids_total+($qte*$users_["poids"]);$janvier=$qte;
		///////////////////
		/*$sql1  = "SELECT * ";
			$sql1 .= "FROM entrees_stock_f where produit='$produit' and (date between '$d1' and '$d2' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);$janvier_p=0;
			while($users11_ = fetch_array($users11)) { 
			$janvier_p=$janvier_p+($users11_["depot_a"]*$condit);
			}*/
		
		//fervier
		$produit=$users_["produit"];$d1="2013-02-01";$d2="2013-02-28";$qte=0;
		$sql1  = "SELECT * ";$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$d1' and '$d2' ) ORDER BY produit;";$users11 = db_query($database_name, $sql1);
		while($users11_ = fetch_array($users11)) { $qte=$qte+($users11_["quantite"]*$users11_["condit"]);}
		$poids_total=$poids_total+($qte*$users_["poids"]);$fevrier=$qte;
		///////////////////
		/*$sql1  = "SELECT * ";
			$sql1 .= "FROM entrees_stock_f where produit='$produit' and (date between '$d1' and '$d2' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);$fevrier_p=0;
			while($users11_ = fetch_array($users11)) { 
			$fevrier_p=$fevrier_p+($users11_["depot_a"]*$condit);
			}*/
		//mars
		$produit=$users_["produit"];$d1="2013-03-01";$d2="2013-03-31";$qte=0;
		$sql1  = "SELECT * ";$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$d1' and '$d2' ) ORDER BY produit;";$users11 = db_query($database_name, $sql1);
		while($users11_ = fetch_array($users11)) { $qte=$qte+($users11_["quantite"]*$users11_["condit"]);}
		$poids_total=$poids_total+($qte*$users_["poids"]);$mars=$qte;
		///////////////////
		/*$sql1  = "SELECT * ";
			$sql1 .= "FROM entrees_stock_f where produit='$produit' and (date between '$d1' and '$d2' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);$mars_p=0;
			while($users11_ = fetch_array($users11)) { 
			$mars_p=$mars_p+($users11_["depot_a"]*$condit);
			}*/
		//avril
		$produit=$users_["produit"];$d1="2013-04-01";$d2="2013-04-30";$qte=0;
		$sql1  = "SELECT * ";$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$d1' and '$d2' ) ORDER BY produit;";$users11 = db_query($database_name, $sql1);
		while($users11_ = fetch_array($users11)) { $qte=$qte+($users11_["quantite"]*$users11_["condit"]);}
		$poids_total=$poids_total+($qte*$users_["poids"]);$avril=$qte;
		///////////////////
		/*$sql1  = "SELECT * ";
			$sql1 .= "FROM entrees_stock_f where produit='$produit' and (date between '$d1' and '$d2' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);$avril_p=0;
			while($users11_ = fetch_array($users11)) { 
			$avril_p=$avril_p+($users11_["depot_a"]*$condit);
			}*/
		//mai
		$produit=$users_["produit"];$d1="2013-05-01";$d2="2013-05-31";$qte=0;
		$sql1  = "SELECT * ";$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$d1' and '$d2' ) ORDER BY produit;";$users11 = db_query($database_name, $sql1);
		while($users11_ = fetch_array($users11)) { $qte=$qte+($users11_["quantite"]*$users11_["condit"]);}
		$poids_total=$poids_total+($qte*$users_["poids"]);$mai=$qte;
		///////////////////
		/*$sql1  = "SELECT * ";
			$sql1 .= "FROM entrees_stock_f where produit='$produit' and (date between '$d1' and '$d2' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);$mai_p=0;
			while($users11_ = fetch_array($users11)) { 
			$mai_p=$mai_p+($users11_["depot_a"]*$condit);
			}*/
		//juin
		$produit=$users_["produit"];$d1="2013-06-01";$d2="2013-06-30";$qte=0;
		$sql1  = "SELECT * ";$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$d1' and '$d2' ) ORDER BY produit;";$users11 = db_query($database_name, $sql1);
		while($users11_ = fetch_array($users11)) { $qte=$qte+($users11_["quantite"]*$users11_["condit"]);}
		$poids_total=$poids_total+($qte*$users_["poids"]);$juin=$qte;
		///////////////////
		/*$sql1  = "SELECT * ";
			$sql1 .= "FROM entrees_stock_f where produit='$produit' and (date between '$d1' and '$d2' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);$juin_p=0;
			while($users11_ = fetch_array($users11)) { 
			$juin_p=$juin_p+($users11_["depot_a"]*$condit);
			}*/
		//juillet
		$produit=$users_["produit"];$d1="2013-07-01";$d2="2013-07-31";$qte=0;
		$sql1  = "SELECT * ";$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$d1' and '$d2' ) ORDER BY produit;";$users11 = db_query($database_name, $sql1);
		while($users11_ = fetch_array($users11)) { $qte=$qte+($users11_["quantite"]*$users11_["condit"]);}
		$poids_total=$poids_total+($qte*$users_["poids"]);$juillet=$qte;
		///////////////////
		/*$sql1  = "SELECT * ";
			$sql1 .= "FROM entrees_stock_f where produit='$produit' and (date between '$d1' and '$d2' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);$juillet_p=0;
			while($users11_ = fetch_array($users11)) { 
			$juillet_p=$juillet_p+($users11_["depot_a"]*$condit);
			}*/
		//aout
		$produit=$users_["produit"];$d1="2013-08-01";$d2="2013-08-31";$qte=0;
		$sql1  = "SELECT * ";$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$d1' and '$d2' ) ORDER BY produit;";$users11 = db_query($database_name, $sql1);
		while($users11_ = fetch_array($users11)) { $qte=$qte+($users11_["quantite"]*$users11_["condit"]);}
		$poids_total=$poids_total+($qte*$users_["poids"]);$aout=$qte;
		///////////////////
		/*$sql1  = "SELECT * ";
			$sql1 .= "FROM entrees_stock_f where produit='$produit' and (date between '$d1' and '$d2' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);$aout_p=0;
			while($users11_ = fetch_array($users11)) { 
			$aout_p=$aout_p+($users11_["depot_a"]*$condit);
			}*/
		//septembre
		$produit=$users_["produit"];$d1="2013-09-01";$d2="2013-09-30";$qte=0;
		$sql1  = "SELECT * ";$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$d1' and '$d2' ) ORDER BY produit;";$users11 = db_query($database_name, $sql1);
		while($users11_ = fetch_array($users11)) { $qte=$qte+($users11_["quantite"]*$users11_["condit"]);}
		$poids_total=$poids_total+($qte*$users_["poids"]);$septembre=$qte;
		///////////////////
		/*$sql1  = "SELECT * ";
			$sql1 .= "FROM entrees_stock_f where produit='$produit' and (date between '$d1' and '$d2' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);$septembre_p=0;
			while($users11_ = fetch_array($users11)) { 
			$septembre_p=$septembre_p+($users11_["depot_a"]*$condit);
			}*/
		//octobre
		$produit=$users_["produit"];$d1="2013-10-01";$d2="2013-10-31";$qte=0;
		$sql1  = "SELECT * ";$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$d1' and '$d2' ) ORDER BY produit;";$users11 = db_query($database_name, $sql1);
		while($users11_ = fetch_array($users11)) { $qte=$qte+($users11_["quantite"]*$users11_["condit"]);}
		$poids_total=$poids_total+($qte*$users_["poids"]);$octobre=$qte;
		///////////////////
		/*$sql1  = "SELECT * ";
			$sql1 .= "FROM entrees_stock_f where produit='$produit' and (date between '$d1' and '$d2' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);$octobre_p=0;
			while($users11_ = fetch_array($users11)) { 
			$octobre_p=$octobre_p+($users11_["depot_a"]*$condit);
			}*/
		//novembre
		$produit=$users_["produit"];$d1="2013-11-01";$d2="2013-11-30";$qte=0;
		$sql1  = "SELECT * ";$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$d1' and '$d2' ) ORDER BY produit;";$users11 = db_query($database_name, $sql1);
		while($users11_ = fetch_array($users11)) { $qte=$qte+($users11_["quantite"]*$users11_["condit"]);}
		$poids_total=$poids_total+($qte*$users_["poids"]);$novembre=$qte;
		///////////////////
		/*$sql1  = "SELECT * ";
			$sql1 .= "FROM entrees_stock_f where produit='$produit' and (date between '$d1' and '$d2' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);$novembre_p=0;
			while($users11_ = fetch_array($users11)) { 
			$novembre_p=$novembre_p+($users11_["depot_a"]*$condit);
			}*/
		//decembre
		$produit=$users_["produit"];$d1="2013-12-01";$d2="2013-12-31";$qte=0;
		$sql1  = "SELECT * ";$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$d1' and '$d2' ) ORDER BY produit;";$users11 = db_query($database_name, $sql1);
		while($users11_ = fetch_array($users11)) { $qte=$qte+($users11_["quantite"]*$users11_["condit"]);}
		$poids_total=$poids_total+($qte*$users_["poids"]);$decembre=$qte;
		///////////////////
		/*$sql1  = "SELECT * ";
			$sql1 .= "FROM entrees_stock_f where produit='$produit' and (date between '$d1' and '$d2' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);$decembre_p=0;
			while($users11_ = fetch_array($users11)) { 
			$decembre_p=$decembre_p+($users11_["depot_a"]*$condit);
			}*/
			
		
		
		$total=$janvier+$fevrier+$mars+$avril+$mai+$juin+$juillet+$aout+$septembre+$octobre+$novembre+$decembre;
		
		?>


<td style="text-align:left" bgcolor="#66CCCC"><?php echo $users_["produit"]; ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $stock_ini; $solde=$solde+$stock_ini-$janvier;
/*$janvier=$janvier_p-$janvier;
$fevrier=$fevrier_p-$fevrier;
$mars=$mars_p-$mars;
$avril=$avril_p-$avril;
$mai=$mai_p-$mai;
$juin=$juin_p-$juin;
$juillet=$juillet_p-$juillet;
$aout=$aout_p-$aout;
$septembre=$septembre_p-$septembre;
$octobre=$octobre_p-$octobre;
$novembre=$novembre_p-$novembre;
$decembre=$decembre_p-$decembre;*/

 ?></td>

<td bgcolor="#66CCCC" align="right"><?php echo $janvier;  ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $fevrier;  ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $mars;  ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $avril;  ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $mai;  ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $juin;  ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $juillet;  ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $aout;  ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $septembre;  ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $octobre;  ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $novembre;  ?></td>
<td bgcolor="#66CCCC" align="right"><?php echo $decembre;  ?></td>

<? }?>

</table>

<p style="text-align:center">

	
	<? ?>

</body>

</html>