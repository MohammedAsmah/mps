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
	if(isset($_REQUEST["action_"])) { 
		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			
			$date_v = dateFrToUs($_REQUEST["date"]);
			
			
			list($annee1,$mois1,$jour1) = explode('-', $date_v); 
			$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
			$mois=date("m",$pdu);$annee=date("Y",$pdu);
			$service=$_REQUEST["service"];
			$vendeur=$_REQUEST["vendeur"];
			$result = mysql_query("SELECT bon_sortie FROM registre_vendeurs_escomptes where mois=$mois and annee=$annee ORDER BY bon_sortie DESC LIMIT 0,1"); 
			$row = mysql_fetch_array($result); 
			
			$dir = $row["bon_sortie"]+1;
			if(isset($_REQUEST["valide"])) { $valide = 1; } else { $valide = 0; }
			
			$statut=$dir."/".$mois.$annee;
			$date_open=$_REQUEST["date_open"];
			$user_open=$user_name;
			$observation=$_REQUEST["observation"];
			$motif_cancel=$_REQUEST["motif_cancel"];
			
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
	// recherche contrat			
		$code_produit="";
			
				$type_service="SEJOURS ET CIRCUITS";
				$sql  = "INSERT INTO registre_vendeurs_escomptes (date,service,vendeur,date_open,user_open,observation,mois,annee,bon_sortie,statut)
				 VALUES ('$date_v','$service','$vendeur','$date_open','$user_open','$observation','$mois','$annee','$dir','$statut')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			
			$sql = "UPDATE registre_vendeurs_escomptes SET ";
			$sql .= "service = '" . $_REQUEST["service"] . "', ";
			$sql .= "date = '" . $date_v . "', ";
			$sql .= "observation = '" . $observation . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			$sql .= "valide = '" . $valide . "', ";
			$sql .= "motif_cancel = '" . $motif_cancel . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			$id_registre=$_REQUEST["user_id"];
			$sql  = "SELECT * ";
			$sql .= "FROM registre_vendeurs_escomptes WHERE id = " . $_REQUEST["user_id"] . ";";
			$user3 = db_query($database_name, $sql); $user_3 = fetch_array($user3);
			$bondesortie = $user_3["statut"];
			//validation bon sortie
			if ($valide==1){
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
//////////////////////////////blocage evaluation
		$sql = "UPDATE commandes SET ";$id=$user_["id"];$controle=1;
			$sql .= "controle = '" . $controle . "', ";
			$sql .= "bondesortie = '" . $bondesortie . "', ";
			$sql .= "date_e = '" . $date_v . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
	
	$sql1  = "SELECT * ";
	$sql1 .= "FROM detail_commandes where commande='$numero' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { $id=$users1_["id"];
	
			$sql = "UPDATE detail_commandes SET ";
			$sql .= "bon_sortie = '" . $bondesortie . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
	
	
		$produit=$users1_["produit"]; 
		$quantite=$users1_["quantite"];$condit=$users1_["condit"];
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
		$user_a = fetch_array($userp);$condit = 1;$id_produit = $user_a["id"];
		
		
		$sql  = "SELECT * ";
		$sql .= "FROM fiches_techniques WHERE id_produit = '$id_produit' ;";
		$userf = db_query($database_name, $sql);
		while($users1_f = fetch_array($userf))
		{
			$emb_separe = $users1_f["emb_separe"];
			$accessoire_1 = $users1_f["accessoire"];
			$qte_ac_1 = $users1_f["qte"]*$quantite*$condit;
			if ($emb_separe==1){
				$sql  = "INSERT INTO bon_de_sortie1 ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $accessoire_1 . "', ";
				$sql .= "'" . $qte_ac_1 . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
			}
			
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
		$condit = 1;$id_produit = $user_a["id"];
		
		
		$sql  = "SELECT * ";
		$sql .= "FROM fiches_techniques WHERE id_produit = '$id_produit' ;";
		$userfp = db_query($database_name, $sql);
		while($users1_fp = fetch_array($userfp))
		{
			$emb_separe = $users1_fp["emb_separe"];
			$accessoire_1 = $users1_fp["accessoire"];
			$qte_ac_1 = $users1_fp["qte"]*$quantite*$condit;
			if ($emb_separe==1){
				$sql  = "INSERT INTO bon_de_sortie1 ( commande, produit, quantite,condit ) VALUES ( ";
				$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $accessoire_1 . "', ";
				$sql .= "'" . $qte_ac_1 . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
			}
			
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
				$sql .= "'" . $date_v . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $condit . "', ";
				$sql .= "'" . $quantite . "');";

				db_query($database_name, $sql);
	}	

	}

			if ($valide==0){
			$sql = "DELETE FROM bon_de_sortie_magasin WHERE id_registre = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			}
			
			//mise à jour commandes
			$sql = "UPDATE commandes SET ";$controle=0;
			$sql .= "controle = '" . $controle . "', ";
			
			$sql .= "date_e = '" . $date_v . "' ";
			$sql .= "WHERE id_registre = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			
			break;
			
			case "delete_user":
			
			
			// delete user's profile
			$sql = "DELETE FROM registre_vendeurs_escomptes WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			$sql = "DELETE FROM bon_de_sortie_magasin WHERE id_registre = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	else {$vendeur="";$date1="";}
	if(isset($_REQUEST["action_"]) and $_REQUEST["action_"] != "delete_user") { $date1 = $_REQUEST["date"];}
	else {$vendeur="";$date1="";}
	$action="recherche";
	
	
	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="registres_vendeurs_ss.php">
	<td><?php echo "Date : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
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
	function EditUser(user_id) { document.location = "registre_vendeur_ss.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	if(isset($_REQUEST["action"]))
	{ $date=dateFrToUs($_POST['date1']);
	
	$sql  = "SELECT * ";
	$sql .= "FROM registre_vendeurs_escomptes where date='$date' ORDER BY id;";
	$users11 = db_query($database_name, $sql);
?>


<span style="font-size:24px"><?php echo dateUsToFr($date); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Destination";?></th>
	<th><?php echo "Bon Sortie";?></th>
	<th><?php echo "Vendeur";?></th>
	
	
</tr>

<?php $compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { $id_r=$users_1["id"];$date3=$users_1["date"];$vendeur=$users_1["vendeur"];
			$statut=$users_1["statut"];$observation=$users_1["observation"];$valide=$users_1["valide"];$valide_c=$users_1["valide_c"];
			$service=$users_1["service"];$code=$users_1["code_produit"];$lp=$users_1["id"]+100000;$bon=$users_1["statut"];?><tr>
			<? 
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
			<td><?php echo $bon; ?></td>
				<td><?php $vendeur=$users_1["vendeur"];echo $users_1["vendeur"]; ?></td>
					<? 
	

 } ?>

</table>
</strong>
<p style="text-align:center">


<? }?>
</body>

</html>