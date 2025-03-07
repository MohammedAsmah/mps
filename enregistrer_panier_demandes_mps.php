<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	
		//sub
	
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 
		
		if($_REQUEST["action_"] != "delete_user") {$numero =$_REQUEST["numero"];$client =$_REQUEST["client"];
		$id = $_REQUEST["numero"];$id_c = $_REQUEST["numero"];
		$sql  = "SELECT * ";
		$sql .= "FROM demandes_frs WHERE commande = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_e"]);$montant_f=$user_["net"];$date_sortie = $user_["date_e"];
		$client = $user_["client"];$piece = $user_["piece"];
		$vendeur = $user_["vendeur"];
		$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
			
			// prepares data to simplify database insert or update
			$produit =$_REQUEST["produit"];$quantite = $_REQUEST["quantite"];
			if ($_REQUEST["action_"]=="insert_new_user"){
			$produit1 =$_REQUEST["produit1"];$quantite1 = $_REQUEST["quantite1"];
			$produit2 =$_REQUEST["produit2"];$quantite2 = $_REQUEST["quantite2"];
			$produit3 =$_REQUEST["produit3"];$quantite3 = $_REQUEST["quantite3"];
			$produit4 =$_REQUEST["produit4"];$quantite4 = $_REQUEST["quantite4"];
			$produit5 =$_REQUEST["produit5"];$quantite5 = $_REQUEST["quantite5"];
			$produit6 =$_REQUEST["produit6"];$quantite6 = $_REQUEST["quantite6"];
			$produit7 =$_REQUEST["produit7"];$quantite7 = $_REQUEST["quantite7"];
			$produit8 =$_REQUEST["produit8"];$quantite8 = $_REQUEST["quantite8"];
			$produit9 =$_REQUEST["produit9"];$quantite9 = $_REQUEST["quantite9"];
			$produit10 =$_REQUEST["produit10"];$quantite10 = $_REQUEST["quantite10"];




//////////////////////////////
			}

			if(isset($_REQUEST["sans_remise"]) and $produit<>"") { $sans_remise = 1; } else { $sans_remise = 0; }
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit = $user_["condit"];$prix_unit = $user_["prix"];

			if ($_REQUEST["action_"]=="insert_new_user"){
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit1' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit1 = $user_["condit"];$prix_unit1 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit2' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit2 = $user_["condit"];$prix_unit2 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit3' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit3 = $user_["condit"];$prix_unit3 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit4' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit4 = $user_["condit"];$prix_unit4 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit5' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit5 = $user_["condit"];$prix_unit5 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit6' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit6 = $user_["condit"];$prix_unit6 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit7' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit7 = $user_["condit"];$prix_unit7 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit8' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit8 = $user_["condit"];$prix_unit8 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit9' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit9 = $user_["condit"];$prix_unit9 = $user_["prix"];
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE produit = '$produit10' ;";
		$user = db_query($database_name, $sql);
		$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit10 = $user_["condit"];$prix_unit10 = $user_["prix"];
		}
		}	
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
				
				if ($produit<>""){
				
				$sql  = "INSERT INTO detail_demandes_frs ( commande, produit, quantite,prix_unit,condit )
				VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $prix_unit . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
				//promotions
				}
				
		
				if ($produit1<>""){
				$sql  = "INSERT INTO detail_demandes_frs ( commande, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit1 . "', ";
				$sql .= "'" . $quantite1 . "', ";
				$sql .= "'" . $prix_unit1 . "', ";
				$sql .= "'" . $condit1 . "');";
				db_query($database_name, $sql);
								//promotions

				
				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_demandes_frs WHERE commande=$numero and produit = '$produit2' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit2="";}

				if ($produit2<>""){
				$sql  = "INSERT INTO detail_demandes_frs ( commande, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit2 . "', ";
				$sql .= "'" . $quantite2 . "', ";
				$sql .= "'" . $prix_unit2 . "', ";
				$sql .= "'" . $condit2 . "');";
				db_query($database_name, $sql);
								//promotions
				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_demandes_frs WHERE commande=$numero and produit = '$produit3' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit3="";}

				if ($produit3<>""){
				$sql  = "INSERT INTO detail_demandes_frs ( commande, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit3 . "', ";
				$sql .= "'" . $quantite3 . "', ";
				$sql .= "'" . $prix_unit3 . "', ";
				$sql .= "'" . $condit3 . "');";
				db_query($database_name, $sql);
								//promotions
				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_demandes_frs WHERE commande=$numero and produit = '$produit4' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit4="";}

				if ($produit4<>""){
				$sql  = "INSERT INTO detail_demandes_frs ( commande, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit4 . "', ";
				$sql .= "'" . $quantite4 . "', ";
				$sql .= "'" . $prix_unit4 . "', ";
				$sql .= "'" . $condit4 . "');";
				db_query($database_name, $sql);
								//promotions

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_demandes_frs WHERE commande=$numero and produit = '$produit5' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit5="";}

				if ($produit5<>""){
				$sql  = "INSERT INTO detail_demandes_frs ( commande, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit5 . "', ";
				$sql .= "'" . $quantite5 . "', ";
				$sql .= "'" . $prix_unit5 . "', ";
				$sql .= "'" . $condit5 . "');";
				db_query($database_name, $sql);
								//promotions
				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_demandes_frs WHERE commande=$numero and produit = '$produit6' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit6="";}

				if ($produit6<>""){
				$sql  = "INSERT INTO detail_demandes_frs ( commande, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit6 . "', ";
				$sql .= "'" . $quantite6 . "', ";
				$sql .= "'" . $prix_unit6 . "', ";
				$sql .= "'" . $condit6 . "');";
				db_query($database_name, $sql);
								//promotions

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_demandes_frs WHERE commande=$numero and produit = '$produit7' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit7="";}

				if ($produit7<>""){
				$sql  = "INSERT INTO detail_demandes_frs ( commande, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit7 . "', ";
				$sql .= "'" . $quantite7 . "', ";
				$sql .= "'" . $prix_unit7 . "', ";
				$sql .= "'" . $condit7 . "');";
				db_query($database_name, $sql);
								//promotions

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_demandes_frs WHERE commande=$numero and produit = '$produit8' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit8="";}

				if ($produit8<>""){
				$sql  = "INSERT INTO detail_demandes_frs ( commande, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit8 . "', ";
				$sql .= "'" . $quantite8 . "', ";
				$sql .= "'" . $prix_unit8 . "', ";
				$sql .= "'" . $condit8 . "');";
				db_query($database_name, $sql);

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_demandes_frs WHERE commande=$numero and produit = '$produit9' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit9="";}

				if ($produit9<>""){
				$sql  = "INSERT INTO detail_demandes_frs ( commande, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit9 . "', ";
				$sql .= "'" . $quantite9 . "', ";
				$sql .= "'" . $prix_unit9 . "', ";
				$sql .= "'" . $condit9 . "');";
				db_query($database_name, $sql);
								//promotions

				}
						$sql  = "SELECT * ";$p="";
		$sql .= "FROM detail_demandes_frs WHERE commande=$numero and produit = '$produit10' ;";
		$user2 = db_query($database_name, $sql); $user_2 = fetch_array($user2);
		$p = $user_2["produit"];
		if ($p<>""){$produit10="";}

				if ($produit10<>""){
				$sql  = "INSERT INTO detail_demandes_frs ( commande, produit, quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $numero . "', ";
				$sql .= "'" . $produit10 . "', ";
				$sql .= "'" . $quantite10 . "', ";
				$sql .= "'" . $prix_unit10 . "', ";
				$sql .= "'" . $condit10 . "');";
				db_query($database_name, $sql);
								//promotions

				}

			
			break;

			case "update_user":
			if(isset($_REQUEST["sans_remise"])) { $sans_remise = 1; } else { $sans_remise = 0; }
			$condit=$_REQUEST["condit"];$prix_unit = $_REQUEST["prix_unit"];
			$sql = "UPDATE detail_demandes_frs SET ";
			$sql .= "produit = '" . $produit . "', ";
			$sql .= "quantite = '" . $quantite . "', ";
			$sql .= "prix_unit = '" . $prix_unit . "', ";
			$sql .= "sans_remise = '" . $sans_remise . "', ";
			$sql .= "condit = '" . $condit . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			

			break;
			
			case "delete_user":
			
		$sql  = "SELECT * ";
		$sql .= "FROM detail_commandes_frs WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$numero = $user_["commande"];$produit = $user_["produit"];
		

			$sql = "DELETE FROM detail_demandes_frs WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);

		$id = $numero;$id_c = $numero;
		$sql  = "SELECT * ";
		$sql .= "FROM demandes_frs WHERE commande = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_e"]);$id_registre = $user_["id_registre"];
		$client = $user_["client"];$montant_f = $user_["net"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
			
			
			break;


		} //switch
		
	} //if
	else
	{
	
	$numero=$_GET['numero'];$client=$_GET['client'];$montant_f=0;$vendeur=$_GET['vendeur'];$id_c=$_GET['numero'];
	$id = $numero;
		$sql  = "SELECT * ";
		$sql .= "FROM demandes_frs WHERE commande = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$date = dateUsToFr($user_["date_e"]);$client = $user_["client"];
		$client = $user_["client"];$montant_f = $user_["net"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];
	}
	
	
?>
</table>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Demandes"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "detail_facture_pro.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<table class="table2">
<td><?php echo $client;?></td><td><?php $montant1=number_format($montant_f,2,',',' ');
echo "Demande : ".$evaluation."---->Date : $date --->";?></td>
</table>
<tr>
<table class="table2">

<tr>
	<th><?php $total=0;echo "Ref";?></th>
	<th><?php $total=0;echo "Article";?></th>
	<th><?php echo "Quantité";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Total";?></th>
</tr>

<?	
	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_demandes_frs where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { ?>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
		$sub=$users1_["sub"];
echo "<td><a href=\"remplir_panier_demandes_mps.php?numero=$numero&user_id=$id&client=$client&montant=$m\">$id</a></td>";?>
<td><?php echo $produit; ?></td>
<td align="center"><?php echo $users1_["quantite"]; ?></td>
<td align="right"><?php $p=$users1_["prix_unit"];echo number_format($p,2,',',' '); ?></td>
<td align="right"><?php $total=$total+$m;echo number_format($m,2,',',' '); ?></td>
</tr>
<?	}?>

</table>
<table>
<tr>
<? echo "<td><a href=\"remplir_panier_demandes_mps.php?numero=$numero&user_id=0&client=$client\">Ajout Article à la demande </a></td>";?>
</tr><tr>
<? $date1=dateFrToUs($date);echo "<td><a href=\"demandes_prix_mps.php?vendeur=$vendeur&date=$date1\">Retour dans Liste demandes</a></td>";?>
</tr>
<tr>
<? $date1=dateFrToUs($date);echo "<td><a href=\"editer_demandes_mps.php?numero=$numero\">Edition Demande de Prix</a></td>";?>
</tr>
<tr>
</tr>

</table>

<p style="text-align:center">


</body>

</html>