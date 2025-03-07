<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
			/*$sql = "TRUNCATE TABLE `stock_final_pf`  ;";
			db_query($database_name, $sql);*/
			
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$produit = $_REQUEST["produit"];$condit = $_REQUEST["condit"];$prix = $_REQUEST["prix"];$poids = $_REQUEST["poids"];
			$tige=$_REQUEST["tige"];$qte_tige=$_REQUEST["qte_tige"];
			$stock_initial = $_REQUEST["stock_initial"];$stock_final = $_REQUEST["stock_initial"]+$_REQUEST["production"]-$_REQUEST["qte_vendu"];
			$encours = $_REQUEST["encours"];
			$production = $_REQUEST["production"];
			$prix_revient = $_REQUEST["prix_revient"];$prix_revient_final = $_REQUEST["prix_revient_final"];$en_cours_final = $_REQUEST["en_cours_final"];
			
			if(isset($_REQUEST["favoris"])) { $favoris = 1; } else { $favoris = 0; }
			if(isset($_REQUEST["non_favoris"])) { $non_favoris = 1; } else { $non_favoris = 0; }
			if(isset($_REQUEST["dispo"])) { $dispo = 1; } else { $dispo = 0; }
		
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO produits ( produit, condit, prix,dispo, tige,qte_tige,matiere,qte_matiere,emballage,qte_emballage,
				etiquette,qte_etiquette,favoris,non_favoris,poids ) VALUES ( ";
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
				$sql .= "'" . $_REQUEST["etiquette"] . "', ";
				$sql .= "'" . $_REQUEST["qte_etiquette"] . "', ";
				$sql .= "'" . $favoris . "', ";
				$sql .= "'" . $non_favoris . "', ";
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
			/*$sql .= "stock_initial = '" . $stock_initial . "', ";
			$sql .= "stock_final = '" . $stock_final . "', ";
			$sql .= "production_auto = '" . $production . "', ";*/
			$sql .= "encours = '" . $encours . "', ";
			$sql .= "en_cours_final = '" . $en_cours_final . "', ";
			$sql .= "prix_revient = '" . $prix_revient . "', ";
			$sql .= "prix_revient_final = '" . $prix_revient_final . "', ";
			$sql .= "prix = '" . $prix . "', ";
			$sql .= "tige = '" . $_REQUEST["tige"] . "', ";
			$sql .= "qte_tige = '" . $_REQUEST["qte_tige"] . "', ";
			$sql .= "matiere = '" . $_REQUEST["matiere"] . "', ";
			$sql .= "qte_matiere = '" . $_REQUEST["qte_matiere"] . "', ";
			$sql .= "emballage = '" . $_REQUEST["emballage"] . "', ";
			$sql .= "qte_emballage = '" . $_REQUEST["qte_emballage"] . "', ";
			$sql .= "etiquette = '" . $_REQUEST["etiquette"] . "', ";
			$sql .= "qte_etiquette = '" . $_REQUEST["qte_etiquette"] . "', ";
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
	
	<? 	if(!isset($_REQUEST["action"])){
?>
	
	<form id="form" name="form" method="post" action="emballages_sachets_productions.php">

	<td><?php $action="Recherche";$du="01/01/2012";echo "Du : "; ?><input type="text" id="du" name="du" value="<?php echo $du; ?>" size="15"></td>
	<td><?php $au="";echo "Au : "; ?><input type="text" id="au" name="au" value="<?php echo $au; ?>" size="15"></td>
	<tr>
	
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }else
	
	{
	$du=dateFrToUs($_POST['du']);$au=dateFrToUs($_POST['au']);$au1=$_POST['au'];

	$sql = "DELETE FROM stock_final_pf WHERE date_exe = " . $au . ";";
			db_query($database_name, $sql);
	
	$sql  = "SELECT * ";
	$sql .= "FROM produits ORDER BY produit;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Produits"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "produit.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php $jour=date("d/m/Y H:m:s");echo "Stock Produits Finis au $au1 edité le $jour "; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Article";?></th>
	
	<th><?php echo "Entrees";?></th>
	
	<th><?php echo "Poids U.";?></th>
	<th><?php echo "Poids.T";?></th>
	<th><?php echo "Matiere";?></th>
	<th><?php echo "Emballage";?></th>
	<th><?php echo "Condit";?></th>
	<th><?php echo "Paquets Prod.";?></th>
	<th><?php echo "Qte Emballage";?></th>
	
</tr>

<?php $valeur=0;$qpt=0;$qist=0;$qisf=0;$qte_emballage_totale=0;while($users_ = fetch_array($users)) { ?>


			<? 
			$produit=$users_["produit"];$condit=$users_["condit"];$id=$users_["id"];$emballage=$users_["emballage3"];$qte_emballage=$users_["qte_emballage3"];
			$stock_ini_exe=$users_["stock_ini_exe"];
			$du="2012-01-01";
		$qte_vendu=0;
			$sql1  = "SELECT * ";
			$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$du' and '$au' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);
			while($users11_ = fetch_array($users11)) { 
			$qte_vendu=$qte_vendu+($users11_["quantite"]*$users11_["condit"]);$numero=$users11_["facture"];
			}

			$sql1  = "SELECT * ";$du="2012-01-01";
			$sql1 .= "FROM entrees_stock_f where produit='$produit' and (date between '$du' and '$au' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);$production=0;
			while($users11_ = fetch_array($users11)) { 
			$production=$production+($users11_["depot_a"]*$condit);
			}

			/*$sql15  = "SELECT * ";
			$sql15 .= "FROM stock_final_pf where produit='$produit' and date_exe='$du' ORDER BY produit;";
			$users115 = db_query($database_name, $sql15);$stock_ini_exe=0;
			$users115_ = fetch_array($users115);
			$stock_ini_exe=$users115_["stock_final"];*/
			

// version group by
/*	$sql1  = "SELECT produit,date_f,quantite,condit,sum(quantite*condit) As qte_vendu ";
	$sql1 .= "FROM detail_factures where produit='$produit' and date_f between '$du' and '$au' GROUP BY produit;";
	$users11 = db_query($database_name, $sql1);$users11_ = fetch_array($users11);$qte_vendu=$users11_["qte_vendu"];
	
	$sql2  = "SELECT produit,depot_a,date,condit,sum(depot_a*condit) As production ";
	$sql2 .= "FROM entrees_stock_f where produit='$produit' and date between '$du' and '$au' GROUP BY produit;";
	$users12 = db_query($database_name, $sql2);$users12_ = fetch_array($users12);$production=$users12_["production"];
*/		
			
			

			$stock_final=$stock_ini_exe+$production-$qte_vendu;
			
			
			if ($stock_final<>0 or $qte_vendu<>0){?>
<tr><td style="text-align:left"><?php $poids=$users_["poids"];$matiere=$users_["matiere"];$p=$users_["produit"];echo $p; ?></td>

<td align="right"><?php echo $production; ?></td>


<td align="right"><?php echo $poids; ?></td>
<td align="right"><?php $qp=$stock_final*$users_["poids"];echo number_format($qp/1000,3,'.',' '); ?></td>
<td ><?php if ($users_["matiere"]=="POLYPROPYLENE"){$mat="PP";}
if ($users_["matiere"]=="POLYPROPYLENE"){$mat="PP";}
if ($users_["matiere"]=="POLYSTERNE CRISTAL"){$mat="PS";}
if ($users_["matiere"]=="MATIERE CHOC"){$mat="PSC";}
if ($users_["matiere"]=="POLYTHYLENE"){$mat="PE";}
if ($users_["matiere"]=="REBROIYEE"){$mat="MR";}
if ($users_["matiere"]=="SOUFFLAGE"){$mat="PES";}
echo $mat; ?></td><td align="right"><?php echo number_format($users_["prix"],2,'.',' '); ?></td>
<?php 
$prix_revient=$users_["prix_revient"];
$pht=$users_["prix"]/1.20;$r2=$pht*0.98;$r10=$r2*0.90;$rm=$r10*0.90;$prix_revient=$rm;

 ?>
<?php 
$vf=$stock_final*$prix_revient;

$qpt=$qpt+$qp;$valeur=$valeur+($stock_final*$prix_revient); ?>
<td align="right"><?php echo $emballage; ?></td>
<td align="right"><?php echo $condit; ?></td>
<td align="right"><?php echo $production/$condit; ?></td>
<td align="right"><?php $q=$production/$condit*$qte_emballage/1000;echo number_format($q,3,'.',' ');$qte_emballage_totale=$qte_emballage_totale+$q ?></td>


<?php  

			// mise à jour stock final
				
				$sql  = "INSERT INTO stock_final_pf ( produit, condit, prix,poids,matiere,production,qte_vente,stock_ini_exe,stock_final,date_exe,prix_revient ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $condit . "', ";
				$sql .= "'" . $prix . "', ";
				$sql .= "'" . $poids . "', ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $production . "', ";
				$sql .= "'" . $qte_vendu . "', ";
				$sql .= "'" . $stock_ini_exe . "', ";
				$sql .= "'" . $stock_final . "', ";
				$sql .= "'" . $au . "', ";
				$sql .= $rm . ");";

				db_query($database_name, $sql);
}			
			$sql = "UPDATE produits SET ";
			$sql .= "stock_final = '" . $stock_final . "', ";
			$sql .= "prix_revient = '" . $rm . "', ";
			$sql .= "stock_final_a_reporter = '" . $stock_final . "', ";
			$sql .= "valeur_final_a_reporter = '" . $vf . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);


}?>
<TR><td></td>
<td><?php /*echo $qist;*/ ?></td>
<td></td><td></td>
<td><?php /*echo $qisf;*/ ?></td><td></td>
<td align="right"><?php echo number_format($qpt/1000,3,'.',' '); ?></td>
<td></td><td></td><td></td>
<td align="right"><?php echo number_format($valeur,2,'.',' '); ?></td>
<td></td><td></td><td></td>
<td align="right"><?php echo number_format($qte_emballage_totale,2,'.',' '); ?></td>
</tr>
</table>


<tr>
<span style="font-size:24px"><?php echo "Stock En cours au 31/12"; ?></span>
	<?
	$sql  = "SELECT * ";
	$sql .= "FROM produits where en_cours_final>0 ORDER BY produit;";
	$users = db_query($database_name, $sql);
	
?>

<table class="table2">

<tr>
	<th><?php echo "Article";?></th>
	<th><?php echo "Quantite";?></th>
	<th><?php echo "Poids Unitaire";?></th>
	<th><?php echo "Poids Total";?></th>
	<th><?php echo "Matiere";?></th>
	<th><?php echo "Prix Revient";?></th>
	<th><?php echo "Valeur Total";?></th>
</tr>

<?php $valeur=0;$poids_total=0;while($users_ = fetch_array($users)) { ?><tr>
<td ><?php echo $users_["produit"]; ?></td>
<td align="center"><?php echo $users_["en_cours_final"]; ?></td>
<td align="center"><?php echo $users_["poids"]; ?></td>
<td align="right"><?php echo number_format(($users_["poids"]*$users_["en_cours_final"])/1000,3,',',' '); 
$poids_total=$poids_total+(($users_["poids"]*$users_["en_cours_final"])/1000);?></td>
<td ><?php if ($users_["matiere"]=="POLYPROPYLENE"){$mat="PP";}
if ($users_["matiere"]=="POLYPROPYLENE"){$mat="PP";}
if ($users_["matiere"]=="POLYSTERNE CRISTAL"){$mat="PS";}
if ($users_["matiere"]=="MATIERE CHOC"){$mat="PSC";}
if ($users_["matiere"]=="POLYTHYLENE"){$mat="PE";}
if ($users_["matiere"]=="REBROIYEE"){$mat="MR";}
if ($users_["matiere"]=="SOUFFLAGE"){$mat="PES";}
echo $mat; ?></td>
<td align="right"><?php echo $users_["prix_revient_final"]; ?></td>

<td align="right"><?php $valeur=$valeur+($users_["en_cours_final"]*$users_["prix_revient_final"]); 
echo number_format(($users_["en_cours_final"]*$users_["prix_revient_final"]),2,',',' ')?></td>
<?php } ?>
<tr><td></td><td></td><td></td><td align="right">
<?php echo number_format($poids_total,3,',',' '); ?>
</td><td></td><td></td>
<td align="right"><?php echo number_format($valeur,2,',',' '); ?></td>
</table>

</tr>
<?php } ?>

<p style="text-align:center">

<? 			/*$sql1111  = "SELECT * ";$t=0;$vide="";
			$sql1111 .= "FROM detail_factures where date_f='$vide' ORDER BY produit;";
			$users1111 = db_query($database_name, $sql1111);
			while($users1111_ = fetch_array($users1111)) { 
			$t=$t+1;
			}
			?><table><td><? echo $t;?></td></table>

*/?>

</body>

</html>