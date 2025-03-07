<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	$valeur=3600;
	set_time_limit($valeur);
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	/*$sql = "TRUNCATE TABLE `details_factures_mp`  ;";
			db_query($database_name, $sql);*/
	
	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	
	$du="";$au="";$action="Recherche";
	$profiles_list_mois = "";$mois="";
	$sql1 = "SELECT * FROM mois_rak_08 ORDER BY id;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($mois == $temp_["mois"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_mois .= "<OPTION VALUE=\"" . $temp_["mois"] . "\"" . $selected . ">";
		$profiles_list_mois .= $temp_["mois"];
		$profiles_list_mois .= "</OPTION>";
	}
	
	
	?>
	
	<form id="form" name="form" method="post" action="indexer_factures_matieres.php">
	 
	<td><?php echo "Du : "; ?><input type="text" id="du" name="du" value="<?php echo $du; ?>" size="15"></td>
	<td><?php echo "Au : "; ?><input type="text" id="au" name="au" value="<?php echo $au; ?>" size="15"></td>
	<tr>
	
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<?
	if(isset($_REQUEST["action"]))
	{
	 $du=dateFrToUs($_POST['du']);$au=dateFrToUs($_POST['au']);
	 
	$sql  = "SELECT * ";
	$sql .= "FROM factures where date_f between '$du' and '$au' ORDER BY id;";
	$users = db_query($database_name, $sql);
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Factures"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "facture.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste Factures"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Numero";?></th>
	<th><?php echo "Date";?></th>
	<th width="200"><?php echo "Client";?></th>
	<th width="150"><?php echo "Vendeur";?></th>
	<th><?php echo "Evaluations";?></th>
	<th width="100"><?php echo "Montant";?></th>
	<th><?php echo "Valide";?></th>
	<th><?php echo "Regrouper";?></th>
</tr>

<?php $ca=0;while($users_ = fetch_array($users)) { ?><tr>

<? $client=$users_["client"];$id=$users_["id"];$f=$users_["numero"];$d=$users_["date_f"];$client_se=Trim($client);

	$sql1  = "SELECT * ";$f1=$users_["id"]+9040;$vide="";
	$sql1 .= "FROM detail_factures where facture='$f' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { $id1=$users1_["id"];$produit=$users1_["produit"];$quantite=$users1_["quantite"];$condit=$users1_["condit"];
			
			$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit='$produit' ORDER BY produit;";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$matiere=$user_["matiere"];$type_matiere="matiere";$poids_matiere=$user_["poids"];$unite_poids_matiere="g";
		$colorant = $user_["colorant"];
		$tige=$user_["tige"];$emballage=$user_["emballage"];$emballage2=$user_["emballage2"];$emballage3=$user_["emballage3"];
		$qte_emballage=$user_["qte_emballage"];$qte_emballage2=$user_["qte_emballage2"];$qte_emballage3=$user_["qte_emballage3"];
		$type_matiere1="sachets";$type_matiere2="carton";
		$etiquette=$user_["etiquette"];
		
		
		//////////////
		$sql  = "SELECT * ";
		$sql .= "FROM types_emballages1 WHERE profile_name='$emballage3' ORDER BY profile_name;";
		$user11 = db_query($database_name, $sql); $user_11 = fetch_array($user11);

		$poids_sachet=$user_11["poids"];
		
			
			
			///matiere
				$sql  = "INSERT INTO details_factures_mp ( id_facture,id_detail_facture,date_facture,numero_facture,produit,paquets,condit,poids_unitaire,unite,libelle,quantite_unitaire,quantite,type ) VALUES ( ";
				$sql .= "'".$id . "',";
				$sql .= "'".$id1 . "',";
				$sql .= "'".$d . "',";
				$sql .= "'".$f . "',";
				$sql .= "'".$produit . "',";
				$sql .= "'".$quantite . "',";
				$sql .= "'".$condit . "',";$sql .= "'".$poids_matiere . "',";$sql .= "'".$unite_poids_matiere . "',";
				$sql .= "'".$matiere . "',";$sql .= "'".$poids_matiere . "',";
				$sql .= "'".$poids_matiere*$quantite*$condit . "',";
				$sql .= "'".$type_matiere . "');";
				db_query($database_name, $sql);
			
			
			///emballage sachets
				if ($emballage3<>""){
				$sql  = "INSERT INTO details_factures_mp ( id_facture,id_detail_facture,date_facture,numero_facture,produit,paquets,condit,libelle,quantite_unitaire,quantite,type ) VALUES ( ";
				$sql .= "'".$id . "',";
				$sql .= "'".$id1 . "',";
				$sql .= "'".$d . "',";
				$sql .= "'".$f . "',";
				$sql .= "'".$produit . "',";
				$sql .= "'".$quantite . "',";
				$sql .= "'".$condit . "',";
				$sql .= "'".$emballage3 . "',";
				$sql .= "'".$poids_sachet . "',";
				$sql .= "'".$poids_sachet*$quantite . "',";
				$sql .= "'".$type_matiere1 . "');";
				db_query($database_name, $sql);
				}
			
			///emballage cartons
				if ($emballage<>""){
				$sql  = "INSERT INTO details_factures_mp ( id_facture,id_detail_facture,date_facture,numero_facture,produit,paquets,condit,libelle,quantite_unitaire,quantite,type ) VALUES ( ";
				$sql .= "'".$id . "',";
				$sql .= "'".$id1 . "',";
				$sql .= "'".$d . "',";
				$sql .= "'".$f . "',";
				$sql .= "'".$produit . "',";
				$sql .= "'".$quantite . "',";
				$sql .= "'".$condit . "',";
				$sql .= "'".$emballage . "',";
				$sql .= "'".$qte_emballage . "',";
				$sql .= "'".$qte_emballage*$quantite . "',";
				$sql .= "'".$type_matiere2 . "');";
				db_query($database_name, $sql);
				}
				
				if ($emballage2<>""){
				$sql  = "INSERT INTO details_factures_mp ( id_facture,id_detail_facture,date_facture,numero_facture,produit,paquets,condit,libelle,quantite_unitaire,quantite,type ) VALUES ( ";
				$sql .= "'".$id . "',";
				$sql .= "'".$id1 . "',";
				$sql .= "'".$d . "',";
				$sql .= "'".$f . "',";
				$sql .= "'".$produit . "',";
				$sql .= "'".$quantite . "',";
				$sql .= "'".$condit . "',";
				$sql .= "'".$emballage2 . "',";
				$sql .= "'".$qte_emballage2 . "',";
				$sql .= "'".$qte_emballage2*$quantite . "',";
				$sql .= "'".$type_matiere2 . "');";
				db_query($database_name, $sql);
				}
						
			}
			
			


?>

<? if ($users_["valide"]==1){?>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];$user_id=$users_["id"];$facture=$users_["id"]+9040;
echo "<td>$facture</td>";?>
<td bgcolor="#33CCFF"><?php $date=dateUsToFr($users_["date_f"]);$d=dateUsToFr($users_["date_f"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td bgcolor="#33CCFF"><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?> </td>
<td bgcolor="#33CCFF"><?php $v=$users_["vendeur"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$v </font>"); ?> </td>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];
echo "<td>$evaluation</td>";?>
<td bgcolor="#33CCFF" align="right" width="150"><?php $ca=$ca+$users_["montant"];$m=number_format($users_["montant"],2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");?></td>

<? echo "<td>R</td>";?>

 
<td bgcolor="#33CCFF"><?php if ($users_["valide"]==1){$oui="oui";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$oui </font>");
}else{$non="non";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$non </font>");
} ?></td>
<? echo "<td>Regrouper</td>";?>
<? } else {?>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];$user_id=$users_["id"];$facture=$users_["id"]+9040;
echo "<td>$facture</td>";?>
<td><?php $date=dateUsToFr($users_["date_f"]);$d=dateUsToFr($users_["date_f"]);print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$d </font>"); ?></td>
<td><?php $c=$users_["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$c </font>"); ?> </td>
<td><?php $v=$users_["vendeur"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$v </font>"); ?> </td>

<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];
echo "<td>$evaluation</td>";?>
<td align="right" width="150"><?php $ca=$ca+$users_["montant"];$m=number_format($users_["montant"],2,',',' ');
print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$m </font>");
 ?></td>
 <? echo "<td>R</td>";?>

<td><?php if ($users_["valide"]==1){$oui="oui";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$oui </font>");
}else{$non="non";print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$non </font>");
} ?></td>
<? echo "<td>Regrouper</td>";?>
<? }?>

<?php } ?>
<tr><td></td><td></td><td></td><td></td><td></td>
<td align="right"><?php $ca=number_format($ca,2,',',' '); print("<font size=\"1\" face=\"Comic sans MS\" color=\"000033\">$ca </font>");?></td><td></td><td></td><td></td></tr>
</table>

<p style="text-align:center">

<? /*echo "<td><a href=\"facture.php?user_id=0&du=$du&au=$au\">Nouvelle Facture</a></td>";*/?>
</body>

</html>