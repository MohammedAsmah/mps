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
			$profile_name = $_REQUEST["profile_name"];$cout_revient = $_REQUEST["cout_revient"];
			$to = "";$stock_initial = $_REQUEST["stock_initial"];$achats = $_REQUEST["achats"];$consomme = $_REQUEST["consomme"];
			$type_a = "";			if(isset($_REQUEST["mode_consomme"])) { $mode_consomme = 1; } else { $mode_consomme = 0; }

		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
				$sql  = "INSERT INTO types_emballages ( profile_name,stock_initial,cout_revient,achats,mode_consomme,type_a ) VALUES ( ";
				$sql .= "'".$profile_name . "',";
				$sql .= "'".$stock_initial . "',";
				$sql .= "'".$cout_revient . "',";
				$sql .= "'".$achats . "',";
				$sql .= "'".$mode_consomme . "',";
				$sql .= "'".$type_a . "');";
				db_query($database_name, $sql);

			break;

			case "update_user":

			$sql = "UPDATE types_emballages SET ";
			$sql .= "profile_name = '" . $profile_name . "', ";
			$sql .= "consomme = '" . $consomme . "', ";
			$sql .= "mode_consomme = '" . $mode_consomme . "', ";
			$sql .= "cout_revient = '" . $cout_revient . "' ";
			$sql .= "WHERE profile_id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM types_emballages WHERE profile_id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";$vide="";
	$sql .= "FROM types_emballages where profile_name<>'$vide' ORDER BY profile_name;";
	$users = db_query($database_name, $sql);$sti=0;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "emballage.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo ""; ?></span>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

<table class="table2">

<tr>
	<th><?php echo "Libelle";?></th>
	<th><?php echo "Stock_initial :Kg";?></th>
	<th><?php echo "Achats Exercice :Kg";?></th>
	<th><?php echo "Valeur Achats ";?></th>
	<th><?php echo "Consommé Exercice :Kg";?></th>
	<th><?php echo "Stock Final :Kg";?></th>
	<th><?php echo "C.M.U.P";?></th>
	<th><?php echo "Valeur Totale";?></th>
</tr>

<?php 
	$v=0;$achats_t=0;while($users_ = fetch_array($users)) { ?><tr>
	
	<?
	$p= $users_["profile_name"];$st=$users_["stock_initial"];$cr=$users_["cout_revient"];$emballage= $users_["profile_name"];
					//achat mat
	$sql1  = "SELECT * ";$achats=0;$prix_revient=0;$du="2011-01-01";$au="2011-12-31";$mc=$users_["mode_consomme"];$consomme=$users_["consomme"];
	$sql1 .= "FROM achats_mat where produit='$p' and date between '$du' and '$au' ORDER BY produit;";
	$users1e = db_query($database_name, $sql1);$prix_revient=0;
	while($users1_e = fetch_array($users1e)) { 
		$achats = $achats+$users1_e["qte"];
		$achats_t = $achats_t+$users1_e["qte"];
		$prix_revient=$prix_revient+($users1_e["qte"]*$users1_e["prix_achat"]);
	}

	
	//consomme	
	$consomme_qte=0;
	if ($mc==1){$consomme_qte=$consomme;}else{

		$sql1  = "SELECT * ";$production=0;$qte_t=0;
	$sql1 .= "FROM produits where emballage='$emballage' or emballage2='$emballage' or emballage3='$emballage' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users1_ = fetch_array($users1)) { 
 		$produit = $users1_["produit"];$condit1 = $users1_["condit"];$qte=0;$poids = $users1_["poids"];$montant=0;$condit=0;
		$emballage1 = $users1_["emballage"];$emballage2 = $users1_["emballage2"];$emballage3 = $users1_["emballage3"];$qte_emb=1;
		if ($emballage==$emballage1){$qte_emb=$users1_["qte_emballage"];}
		if ($emballage==$emballage2){$qte_emb=$users1_["qte_emballage2"];}
		if ($emballage==$emballage3){$qte_emb=$users1_["qte_emballage3"];}


	$sql1  = "SELECT * ";$mf="";$du="2011-01-01";$au="2011-12-31";
	$sql1 .= "FROM detail_factures where produit='$produit' and (date_f between '$du' and '$au' ) ORDER BY produit;";
	$users11 = db_query($database_name, $sql1);
	while($users11_ = fetch_array($users11)) { 
			$consomme_qte=$consomme_qte+($users11_["quantite"]*$qte_emb);	
		}
	}
	}
	
	
	/*$type="CARTON";$unite="UNITE";
	$sql  = "INSERT INTO matieres_premieres ( produit,type,unite ) VALUES ( ";
				$sql .= "'".$emballage . "',";
				$sql .= "'".$type . "',";
				$sql .= "'".$unite . "');";
				db_query($database_name, $sql);*/
	
	
	//stock initial
	$sql1  = "SELECT * ";$stock_initial_pf=0;$stock_final_pf=0;$stock_initial=0;$d="2011-01-01";
	$sql1 .= "FROM report_mat_precedant where date='$d' and produit='$p' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$vfm=0;
	while($users1_ = fetch_array($users1)) { 
 		$produit = $users1_["produit"];
		$stock_initial_pf = $stock_initial_pf+$users1_["stock_final_pf"];
		$encours_initial_pf=$encours_initial_pf+$users1_["encours"];
		$stock_initial=$stock_initial+$users1_["stock_final_mp"];
		$vfm=$vfm+$users1_["valeur_final_mp"];
	}
	@$cout=($vfm+$prix_revient)/($stock_initial+$achats);
	$c=$vfm."+".$prix_revient."/".$stock_initial."+".$achats;
	if ($cr>0){$cout=$cr;}
	?>	<? $p=$users_["profile_name"];$id=$users_["profile_id"];
	$colorant="<td align=\"left\"><a href=\"emballage.php?user_id=$id&stock_initial=$stock_initial&achats=$achats\">$p</a></td>";
		print("<font size=\"1\" face=\"Arial\" color=\"#000033\">$colorant </font>");?>

	<td align="right"><?php $sti=$sti+$stock_initial;$si= number_format($stock_initial,3,',',' ');print("<font size=\"2\" face=\"Arial\" color=\"#000033\">$si </font>");?></td>
	<td align="right"><?php $ac= number_format($achats,3,',',' ');print("<font size=\"2\" face=\"Arial\" color=\"#000033\">$ac </font>");?></td>
	<td align="right"><?php $pr= number_format($prix_revient,3,',',' ');print("<font size=\"2\" face=\"Arial\" color=\"#000033\">$pr </font>");?></td>

	<td align="right"><?php $cons= number_format($consomme_qte,3,',',' ');print("<font size=\"2\" face=\"Arial\" color=\"#000033\">$cons </font>");?></td>
	<td align="right"><?php $sf= number_format(($stock_initial+$achats-$consomme_qte),3,',',' ');print("<font size=\"2\" face=\"Arial\" color=\"#000033\">$sf </font>");?></td>
	<td align="right"><?php $coutt= number_format($cout,2,',',' ');print("<font size=\"2\" face=\"Arial\" color=\"#000033\">$coutt </font>");?></td>
	<td align="right"><?php $v=$v+$cout*($stock_initial+$achats-$consomme_qte);$cc=$cout*($stock_initial+$achats-$consomme_qte);
	$ccc= number_format($cc,2,',',' ');print("<font size=\"2\" face=\"Arial\" color=\"#000033\">$ccc </font>");?></td>
	</tr>
<?php } ?>
<tr>
<td></td>
<td><?php echo number_format($sti,3,',',' ');?></td>
<td align="right"><?php echo number_format($achats_t,3,',',' ');?></td><td></td><td></td><td></td><td></td>
	<td align="right"><?php echo number_format($v,2,',',' ');?></td>
</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

</body>

</html>