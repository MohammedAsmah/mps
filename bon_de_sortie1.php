<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
		//sub
	
	
		$id_registre=$_GET['id_registre'];$bon_sortie=$_GET['bon_sortie'];
		$vendeur=$_GET['vendeur'];$date=dateUsToFr($_GET['date']);
			
			$sql = "TRUNCATE TABLE `bon_de_sortie`  ;";
			db_query($database_name, $sql);

		$sql  = "SELECT * ";
		$sql .= "FROM commandes WHERE id_registre = " . $id_registre . ";";
		$user = db_query($database_name, $sql); 

	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "detail_facture_pro.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<table class="table2">
<td><?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"000033\">Bon de Sortie Magasin </font>");?></td>
<td bordercolor=""></td>
<td align="right"><?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"000033\">Marrakech le : $date  </font>");?></td>
<tr></tr>
<p></p>
<p></p>
<tr><td><?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"000033\">Vendeur : $vendeur </font>");?></td>
<td><?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"000033\">Numero : $bon_sortie </font>");?></td>
<td><?php print("<font size=\"3\" face=\"Comic sans MS\" color=\"000033\">Destination :  </font>");?></td>
</tr>
</table>
<tr>

<?	
while($user_ = fetch_array($user)) { ?><tr>	
		<? $date = dateUsToFr($user_["date_e"]);
		$client = $user_["client"];$montant_f = $user_["net"];$numero = $user_["commande"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];

	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$quantite=$users1_["quantite"];$condit=$users1_["condit"];
		

				$sql  = "INSERT INTO bon_de_sortie ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $condit . "');";

				db_query($database_name, $sql);
		
		
		
		?>
	<?	}?>
<?	}?>

<table class="table2">

<tr>
	<th><?php echo "Designation Article";?></th>
	<th><?php echo "Quantité";?></th>
	<th><?php echo "X";?></th>
	<th><?php echo "Paquets";?></th>
	<th><?php echo "Observation";?></th>
</tr>
<? 

		$sql  = "SELECT * ";
		$sql .= "FROM produits order by produit ;";
		$user1 = db_query($database_name, $sql);
	while($users11_ = fetch_array($user1)) { 
		$produit=$users11_["produit"];$condit=$users11_["condit"];$qte=0;

	$sql1  = "SELECT * ";
	$sql1 .= "FROM bon_de_sortie where produit='$produit' and commande='$id_registre' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$qte=$qte+$users1_["quantite"];
	}	
		if ($qte>0){
		?>
		<tr><td><?php echo $produit; ?></td>
		<td align="center"><?php echo $qte."<td>X</td>"; ?></td>
		<td align="center"><?php echo $condit; ?></td>
		<td></td>
		</tr>
		<? }?>

	<?	}?>

</table>
<tr></tr>
<p></p>
<p></p>
<table width="802">
<td>    Magasinier</td>
<td>    Controle</td>
<td>Visa</td>
<p></p>
<p></p>
<tr><td></td><td>Enregistrer le : .................</td></tr>
</table>
<p style="text-align:center">


</body>

</html>