<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];$date_ajout=date("Y-m-d");$du="";$au="";$action="Recherche";
	$profiles_list_mois = "";$mois="";
	$sql1 = "SELECT * FROM mois_rak_08 ORDER BY id;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($mois == $temp_["mois"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_mois .= "<OPTION VALUE=\"" . $temp_["mois"] . "\"" . $selected . ">";
		$profiles_list_mois .= $temp_["mois"];
		$profiles_list_mois .= "</OPTION>";
	}
	$profiles_list_produit = "";
	$sql1 = "SELECT * FROM produits ORDER BY produit;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($produit == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_produit .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_produit .= $temp_["produit"];
		$profiles_list_produit .= "</OPTION>";
	}
	?>
	
	<form id="form" name="form" method="post" action="maj_factures_global.php">
	<td><?php echo "Mois : "; ?></td><td><select id="mois" name="mois"><?php echo $profiles_list_mois; ?></select>
	<td><?php $annee=date("Y");echo "Annee : "; ?><input type="text" id="annee" name="annee" value="<?php echo $annee; ?>" size="15"></td>
	<td><?php echo "Article : "; ?></td><td><select id="produit" name="produit"><?php echo $profiles_list_produit; ?></select>
	
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<?
	if(isset($_REQUEST["action"]))
	{
		$du = "2020-01-01";
	$au = "2020-12-30";
	$sql  = "SELECT * ";$ins="FACTURE EN INSTANCE";
	$sql .= "FROM factures2020 where (date_f between '$du' and '$au') and editee=0 and client <> '$ins' ORDER BY id;";
	$users = db_query($database_name, $sql);
	
	}
	
?>
</table>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Facture Client"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "detail_facture.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<table class="table2">
</table>
<tr>
<table class="table2">

<tr>
	<th><?php $total=0;echo "Ref";?></th>
	<th><?php $total=0;echo "Produit";?></th>
	<th><?php echo "Quantité";?></th>
	<th><?php echo "Paquets";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Total";?></th>
</tr>

<?	$q=0;$total=0;
	while($users_ = fetch_array($users)) { $date_f=dateUsToFr($users_["date_f"]);$numero=$users_["numero"];$client=$users_["client"];
	$date_ff=$users_["date_f"];$editee=$users_["editee"];$prx=="BAC NAKHLA MM";
	
	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_factures2020 where facture='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];$commande=$users1_["commande"];$px=$users1_["prix_unit"];$condx=$users1_["condit"];
		$quantitex=$users1_["quantite"];$total1=$quantitex*$px*$condx;
		
		
		
		if ($produit=="BAC NAKHLA MM"){
		
			
		$quantite=$users1_["quantite"];$pu=5.50;$p="PANIER FRIGO BLANC GM";$cond=40;$total2=$quantite*$pu*$cond;
		
		$sql  = "INSERT INTO detail_factures2020 ( commande,produit,prix_unit,quantite,condit,date_f,facture ) 
		VALUES ( ";
		$sql .= "'" . $commande . "', ";
		$sql .= "'" . $p . "', ";
		$sql .= "'" . $pu . "', ";
		$sql .= "'" . $quantite . "', ";
		$sql .= "'" . $cond . "', ";
		$sql .= "'" . $date_ff . "', ";
		$sql .= $numero . ");";
		db_query($database_name, $sql);
		
			$sql = "DELETE FROM detail_factures2020 WHERE id = " . $id . ";";
			db_query($database_name, $sql);
		
		echo "<td>$date_f $numero $client $editee </td>";
		echo "<td>$produit</td>";
		echo "<td>$p</td>";
		echo "<td>$quantitex</td>";
		echo "<td>$px</td>";
		echo "<td>$condx</td>";
		echo "<td>$quantite</td>";
		echo "<td>$pu</td>";
		echo "<td>$cond</td>";
		echo "<td>$total1</td>";
		echo "<td>$total2</td>";		
		echo "</tr>";
		$q=$q+($quantitex*$condx);
		} // fin T5

?>

<? }?>


<? }?>



<p style="text-align:center">

<? echo "<td>$q</td>";?>
</body>

</html>