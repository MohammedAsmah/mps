<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url

	$action="recherche";$date1="";$date2="";
	
	
	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="registres_vendeurs_sg.php">
	<td><?php echo "Du : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au : "; ?><input onClick="ds_sh(this);" name="date2" value="<?php echo $date2; ?>" readonly="readonly" style="cursor: text" /></td>

	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<? }


?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre_vendeur_s.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	if(isset($_REQUEST["action"]))
	{ $date=dateFrToUs($_POST['date1']);$date1=dateFrToUs($_POST['date2']);
	
	$sql  = "SELECT * ";
	$sql .= "FROM registre_vendeurs where date between '$date' and '$date1' and valide=0 ORDER BY id;";
	$users11 = db_query($database_name, $sql);
?>


<span style="font-size:24px"><?php echo dateUsToFr($date); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Destination";?></th>
	<th><?php echo "Vendeur";?></th>
	
	
</tr>

<?php $compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { $id_registre=$users_1["id"];$date3=$users_1["date"];$vendeur=$users_1["vendeur"];
			$statut=$users_1["statut"];$observation=$users_1["observation"];$valide=$users_1["valide"];$valide_c=$users_1["valide_c"];
			$service=$users_1["service"];$code=$users_1["code_produit"];$lp=$users_1["id"]+100000;$bon=$users_1["statut"];?><tr>
			<? 
			
						//validation bon sortie
			$sql = "TRUNCATE TABLE `bon_de_sortie1`  ;";
			db_query($database_name, $sql);
			$sql  = "SELECT * ";
		$sql .= "FROM commandes WHERE id_registre = " . $id_registre . ";";
		$user = db_query($database_name, $sql); 

		while($user_ = fetch_array($user)) { 
		$date = dateUsToFr($user_["date_e"]);
		$client = $user_["client"];$montant_f = $user_["net"];$numero = $user_["commande"];
		$vendeur = $user_["vendeur"];$remise10 = $user_["remise_10"];$remise2 = $user_["remise_2"];
		$evaluation = $user_["evaluation"];$sans_remise = $user_["sans_remise"];$remise3 = $user_["remise_3"];

	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { 
		$produit=$users1_["produit"]; 
		$id=$users1_["id"];$quantite=$users1_["quantite"];$condit=$users1_["condit"];
				$sql  = "INSERT INTO bon_de_sortie1 ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
		//accesoires
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$userp = db_query($database_name, $sql);
		$user_a = fetch_array($userp);
		$accessoire_1 = $user_a["accessoire_1"];$accessoire_2 = $user_a["accessoire_2"];$accessoire_3 = $user_a["accessoire_3"];
		
		$qte_ac_1 = $user_a["qte_ac_1"]*$quantite;$qte_ac_2 = $user_a["qte_ac_2"]*$quantite;$qte_ac_3 = $user_a["qte_ac_3"]*$quantite;
		if ($accessoire_1<>"")
		{		
				$sql  = "INSERT INTO bon_de_sortie1 ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $accessoire_1 . "', ";
				$sql .= "'" . $qte_ac_1 . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
		}
		if ($accessoire_2<>"")
		{		$sql  = "INSERT INTO bon_de_sortie1 ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $accessoire_2 . "', ";
				$sql .= "'" . $qte_ac_2 . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
		}
		if ($accessoire_3<>"")
		{		$sql  = "INSERT INTO bon_de_sortie1 ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $accessoire_3 . "', ";
				$sql .= "'" . $qte_ac_3 . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
		}
		
		}
		
		
		
//promotion
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes_pro where commande='$numero' ORDER BY produit;";
	$users1p = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1p)) { 
		$produit=$users1_["produit"]; $id=$users1_["id"];$quantite=$users1_["quantite"];$condit=$users1_["condit"];
				$sql  = "INSERT INTO bon_de_sortie1 ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
				
	//accessoires promo
			//accesoires
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$userp = db_query($database_name, $sql);
		$user_a = fetch_array($userp);
		$accessoire_1 = $user_a["accessoire_1"];$accessoire_2 = $user_a["accessoire_2"];$accessoire_3 = $user_a["accessoire_3"];
		
		$qte_ac_1 = $user_a["qte_ac_1"]*$quantite;$qte_ac_2 = $user_a["qte_ac_2"]*$quantite;$qte_ac_3 = $user_a["qte_ac_3"]*$quantite;
		if ($accessoire_1<>"")
		{		
				$sql  = "INSERT INTO bon_de_sortie1 ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $accessoire_1 . "', ";
				$sql .= "'" . $qte_ac_1 . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
		}
		if ($accessoire_2<>"")
		{		$sql  = "INSERT INTO bon_de_sortie1 ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $accessoire_2 . "', ";
				$sql .= "'" . $qte_ac_2 . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
		}
		if ($accessoire_3<>"")
		{		$sql  = "INSERT INTO bon_de_sortie1 ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $accessoire_3 . "', ";
				$sql .= "'" . $qte_ac_3 . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
		}

	}
	
	}
	
	$sql1  = "SELECT commande,produit,condit,sum(quantite) as total_quantite ";
	$sql1 .= "FROM bon_de_sortie1 where commande='$id_registre' group BY produit;";
	$users1 = db_query($database_name, $sql1);
	while($users11_ = fetch_array($users1)) { 
	$produit=$users11_["produit"]; $quantite=$users11_["total_quantite"];$condit=$users11_["condit"];
	
				$sql  = "INSERT INTO bon_de_sortie_magasin ( id_registre, date,produit, condit,depot_a ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $date3 . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $condit . "', ";
				$sql .= "'" . $quantite . "');";

				db_query($database_name, $sql);
	}	

						$sql = "UPDATE registre_vendeurs SET ";$motif_cancel="validation globale";$valide=1;
			$sql .= "valide = '" . $valide . "', ";
			$sql .= "motif_cancel = '" . $motif_cancel . "' ";
			$sql .= "WHERE id = " . $id_registre . ";";
			db_query($database_name, $sql);

			
			
			
			
			
			if ($valide_c==0){
			if ($valide==1){?>
			<td bgcolor="#33FFCC"><a href="JavaScript:EditUser(<?php echo $users_1["id"]; ?>)"><?php echo dateUsToFr($users_1["date"]); ?></A></td>
			<? } 
			else { ?>
			<td><a href="JavaScript:EditUser(<?php echo $users_1["id"]; ?>)"><?php echo dateUsToFr($users_1["date"]); ?></A></td>
			<? }
			}
			else{?>			<td><?php echo dateUsToFr($users_1["date"]); ?></td>

			
			<? }?>
			<td><?php $destination=$users_1["service"];echo $users_1["service"]; ?></td>
				<td><?php $vendeur=$users_1["vendeur"];echo $users_1["vendeur"]; ?></td>
					<? 
	

 } ?>

</table>
</strong>
<p style="text-align:center">


<? }?>
</body>

</html>