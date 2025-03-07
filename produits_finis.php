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
	
	<form id="form" name="form" method="post" action="produits_finis.php">

	<td><?php $action="Recherche";$du="01/01/2024";echo "Du : "; ?><input type="text" id="du" name="du" value="<?php echo $du; ?>" size="15"></td>
	<td><?php $au="";echo "Au : "; ?><input type="text" id="au" name="au" value="<?php echo $au; ?>" size="15"></td>
	<tr>
	
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }else
	
	{
	$du=dateFrToUs($_POST['du']);$au=dateFrToUs($_POST['au']);$au1=$_POST['au'];

	$sql = "DELETE FROM stock_final_pf WHERE date_exe = " . $au . ";";
			db_query($database_name, $sql);
	
	$sql  = "SELECT * ";$vide="";$production_g=0;
	$sql .= "FROM produits WHERE produit<>'$vide' ORDER BY produit;";
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

<span style="font-size:24px"><?php $jour=date("d/m/Y H:m:s");echo "Stock Produits Finis MPS au $au1 edité le $jour "; ?></span>

<table class="table2">

<tr>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Article </font>");?></th>
	
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">S.Initial </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Entrees </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Achats </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Sorties </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Avoirs </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">S.Final </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Poids U. </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Condit </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Poids.T </font>");?></th>
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Px.Vente TTC </font>");?></th>
		<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Px.Vente HT </font>");?></th>
			<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Px.Vente Net </font>");?></th>
		
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Px Revient </font>");?></th>
	
		<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Marge </font>");?></th>
		
	<th><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">Valeur </font>");?></th>
	
		
</tr>

<?php $valeur=0;$valeur1=0;$qpt=0;$qist=0;$qisf=0;$qte_emballage_totale=0;while($users_ = fetch_array($users)) { ?>


			<? 
			$produit=$users_["produit"];$condit=$users_["condit"];$id=$users_["id"];$emballage=$users_["emballage3"];$qte_emballage=$users_["qte_emballage3"];
			$stock_ini_exe=$users_["stock_ini_exe"];$poids=$users_["poids"];$stock_ini_exe_p=$users_["stock_ini_exe_p"];
			$emballage_c=$users_["emballage"];$qte_emballagec=$users_["qte_emballage"];
			$du="2024-01-01";
			$qte_vendu=0;$qte_avoir=0;
			$sql1  = "SELECT * ";
			$sql1 .= "FROM detail_factures2024 where produit='$produit' and (date_f between '$du' and '$au' ) ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);
			while($users11_ = fetch_array($users11)) { 
			$qte_vendu=$qte_vendu+($users11_["quantite"]*$users11_["condit"]);
			$qte_avoir=$qte_avoir+($users11_["quantite_avoir"]*$users11_["condit"]);
			$numero=$users11_["facture"];
			}

			$sql1  = "SELECT * ";$du="2024-01-01";
			$sql1 .= "FROM entrees_stock_f where produit='$produit' and (date between '$du' and '$au' ) and achat=0 ORDER BY produit;";
			$users11 = db_query($database_name, $sql1);$production=0;
			while($users11_ = fetch_array($users11)) { 
			$production=$production+($users11_["depot_a"]*$condit);$production_g=$production_g+($users11_["depot_a"]*$condit)*$poids;
			}
			
			$sql1  = "SELECT * ";$du="2024-01-01";$achats_revendu=0;
			$sql1 .= "FROM entrees_stock_f where produit='$produit' and (date between '$du' and '$au' ) and achat=1 ORDER BY produit;";
			$users111 = db_query($database_name, $sql11);
			while($users111_ = fetch_array($users111)) { 
			$achats_revendu=$achats_revendu+($users11_["depot_a"]*$condit);
			}

			$stock_final=$stock_ini_exe+$production+$achats_revendu-$qte_vendu-$qte_avoir;
			$tpoids = rand(2, 5);
			
			if ($stock_final<>0 or $qte_vendu<>0){?>
<tr><td style="text-align:left"><?php $poids=$users_["poids"];$matiere=$users_["matiere"];$p=$users_["produit"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$p </font>"); ?></td>

<td align="right"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$stock_ini_exe </font>"); $qist=$qist+$stock_ini_exe; ?></td>
<td align="right"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$production </font>"); ?></td>
<td align="right"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$achats_revendu </font>"); ?></td>
<td align="right"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$qte_vendu </font>"); ?></td>
<td align="right"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$qte_avoir </font>"); ?></td>
<td align="right"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$stock_final </font>");$qisf=$qisf+$stock_final; ?></td>
<td align="right"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$poids </font>"); ?></td>
<?php //$poids_dim=$users_["poids"]-$users_["poids"]*$tpoids/100;print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$poids_dim </font>"); ?>
<?php //$diff=$poids-$poids_dim;print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$diff </font>"); ?>
<td align="right"><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$condit </font>"); ?></td>
<td align="right"><?php $qp=$stock_final*$users_["poids"];$qp1000=number_format($qp/1000,3,'.',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$qp1000 </font>"); ?></td>
<?php if ($users_["matiere"]=="POLYPROPYLENE"){$mat="PP";}
if ($users_["matiere"]=="POLYPROPYLENE"){$mat="PP";}
if ($users_["matiere"]=="POLYSTERNE CRISTAL"){$mat="PS";}
if ($users_["matiere"]=="MATIERE CHOC"){$mat="PSC";}
if ($users_["matiere"]=="POLYTHYLENE"){$mat="PE";}
if ($users_["matiere"]=="POLYPROPYLENES REGENERES"){$mat="MR";}
if ($users_["matiere"]=="SOUFFLAGE"){$mat="PES";}
if ($users_["matiere"]=="SOUFFLAGE PE"){$mat="PES PE";}
 ?><td align="right">
<?php $pua=number_format($users_["prix"],2,'.',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$pua </font>");?></td>
<?php 

$pht=$users_["prix"]/1.20;$r2=$pht*0.97;$r10=$r2*0.98;$rm=$r10*0.90;
$phtnet=$pht*0.90*0.98*0.97;
/*
$prix_revient1=$users_["prix_revient"];


$t = rand(2, 8);
$taux=$phtnet*$t/100;
$prix_revient=$phtnet-$taux;

$prix_revient1=$users_["prix"]/1.20;$r2=$prix_revient1*0.98;;$rm=$r2*0.95;$prix_revient1=$rm;

$prix_revient1=$users_["prix_revient"];*/
$prix_revient=$users_["prix_revient"];

		/*$sql  = "SELECT * ";
		$sql .= "FROM liste_prix_revient WHERE produit = '$produit';";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$prix_revient = $user_["prix"];*/




?>
<td align="right"><?$phtbrut=number_format($pht,2,'.',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$phtbrut </font>"); ?></td>
<td align="right"><?$phtnet=number_format($pht*0.90*0.98*0.97,2,'.',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$phtnet </font>"); ?></td>
<td align="right"><?$puv=number_format($prix_revient,2,'.',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$puv </font>"); ?></td>
<td align="right"><?$marge=number_format($phtnet-$prix_revient,2,'.',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$marge </font>"); ?></td>


<td align="right"><?php 
$vf=$stock_final*$prix_revient;

$qpt=$qpt+$qp;$valeur=$valeur+($stock_final*$prix_revient); 
$valeur1=$valeur1+($stock_final*$prix_revient1);
$vt=number_format(($stock_final*$prix_revient),2,'.',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$vt </font>");?></td>


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
			/*$sql .= "stock_ini_exe = '" . $stock_final . "', ";
			$sql .= "stock_ini_exe_p = '" . $stock_ini_exe . "', ";*/
			//$sql .= "prix_revient = '" . $rm . "', ";
			$sql .= "stock_final_a_reporter = '" . $stock_final . "', ";
			$sql .= "valeur_final_a_reporter = '" . $vf . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
			
			

}?>
<TR><td></td>
<td><?php /*echo $qist;*/ ?></td>
<td align="right"><?php $qpt1000=number_format($production_g/1000,3,'.',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$qpt1000 </font>"); ?></td>
<td></td><td></td><td></td>
<td><?php /*echo $qisf;*/ ?></td>
<td></td><td></td>
<td align="right"><?php $qpt1000=number_format($qpt/1000,3,'.',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$qpt1000 </font>"); ?></td>
<td></td><td></td><td></td><td></td><td></td>
<td align="right"><?php $vt1000=number_format($valeur,2,'.',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$vt1000 </font>"); ?></td>

</tr>
</table>



<?php } ?>

<p style="text-align:center">


</body>

</html>