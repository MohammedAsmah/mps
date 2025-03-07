<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
			$hostname_smoby = "appbo.jaoudaplastic.ma"; // nom de votre serveur
			$database_smoby = "appbojaoudaplast_prod"; // nom de votre base de données
			$username_smoby = "appbojaoudaplast_bo"; // nom d'utilisateur (root par défaut) !!! 
			$password_smoby = "yHHzKfX(Y]l5"; // mot de passe (aucun par défaut mais il est conseillé d'en mettre un)
			
			
			
			$mysqli = new mysqli("$hostname_smoby", "$username_smoby", "$password_smoby", "$database_smoby");

			echo $mysqli->host_info . "\n";

	
			// Check connection
			if ($mysqli->connect_error) {
				die("Connection failed: " . $mysqli->connect_error);
			}
			else
			{echo "connected";}
		
		
		$action="recherche";$date_order=date("Y-m-d");
	
	
	?>
	<? if(isset($_REQUEST["action"])){$date_order=dateFrToUs($_POST['date1']);}else{ ?>
	<form id="form" name="form" method="post" action="commande_app.php">
	<td><?php echo "Date : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	
	</form>
	
	<? }
	
		
		$today="2024-11-14";
		$sql = "SELECT * FROM orders where delivery_date_clt='$date_order' ORDER BY delivery_date_clt";

		
	

	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head><? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Production"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">



</head>

<body style="background:#dfe8ff"><? require "body_cal.php";?>


<table class="table2">

<tr>
	<th><?php echo "date";?></th>
	<th><?php echo "commande";?></th>
	<th><?php echo "client";?></th>
	

</tr>
<? $t=0;
if ($result = $mysqli -> query($sql)) {
		  while ($row = $result -> fetch_row()) {
			  
			  $mysql_insert_id_mps=0;
			  
			  //printf ("%s (%s)\n", $row[0], $row[1]);?>
		  
		  <tr><td align="center"><?php $commande=$row[0];$date=$row["12"];echo dateUsToFr($row["12"]);?></td>
			<td align="center"><?php echo $row["1"];?></td>
			<td align="center"><?php $id_client=$row["8"];
			
			$sql = "SELECT * FROM companies where id='$id_client' ORDER BY id";
			if ($result1 = $mysqli -> query($sql)) {
			$rowc = $result1 -> fetch_row();
			echo $rowc["1"];
			$client=$rowc["1"];
			}
			$result1 -> free_result();
			
			
			//ajout sur systeme
			$sql  = "SELECT * ";
						$sql .= "FROM clients WHERE client = '$client' ;";
						$user = db_query($database_name, $sql);
						$user_ = fetch_array($user);$remise10 = $user_["remise10"];
						$remise2 = $user_["remise2"];$remise3 = $user_["remise3"];$type_remise = $user_["type_remise"];
						$escompte = $user_["escompte"];$vendeur = $user_["vendeur_nom"];$secteur = $user_["ville"];
						$escompte2 = $user_["escompte2"];$plafond = $user_["plafond"];$prix_grille = $user_["prix1"];
				
							
			
			?></td>
			<td align="center"><?php echo $vendeur;?></td>
			<td align="center"><?php echo $remise10;?></td>
			<td align="center"><?php echo $remise2;?></td>
			<td align="center"><?php echo $remise3;?></td>
			<td align="center"><?php echo $escompte1;?></td>
			<tr>
			<td colspan="8">
			<table>
			
			<? 
			$sql = "SELECT * FROM order_items where order_id='$commande' ORDER BY id";
			$compteur_mps=0;$compteur_jp=0;
			$mps = array();$jp = array();
			if ($result_items = $mysqli -> query($sql)) {
				while ($row_items = $result_items -> fetch_row()) {
					$id_article=$row_items["6"];
			  
				$sql = "SELECT * FROM articles where id='$id_article' ORDER BY id";
			if ($result2 = $mysqli -> query($sql)) {
			$rowp = $result2 -> fetch_row();
			
			$article=$rowp["1"];$com_id=$rowp["29"];
			}
			$result1 -> free_result();
			
			// Déclaration de la matrice
			  
			  
			  
			
			?>
		  
				<? if ($com_id==1){$mps[$compteur_mps] = array($article,$row_items["1"],$row_items["2"]);$compteur_mps = $compteur_mps+1;?>
				
				<? } else {$jp[$compteur_jp] = array($article,$row_items["1"],$row_items["2"]);$compteur_jp = $compteur_jp+1;?>
				
				<? }?>
			<? } 
			
			///afficher tableaux
			?><? 
			for ($i = 0; $i <= $compteur_mps; $i++) {
				echo "<tr><td>".$mps[$i][0]."</td><td>".$mps[$i][1]."</td><td>".$mps[$i][2]."</td></tr>";
			}
			echo "<tr><td></td></tr>";
			for ($i = 0; $i <= $compteur_jp; $i++) {
				echo "<tr><td>".$jp[$i][0]."</td><td>".$jp[$i][1]."</td><td>".$jp[$i][2]."</td></tr>";
			}
			
			
			}
			
			//ajout commande
			/*if ($compteur_mps>0){$company="MPS";$cde=0;
				$result_mps = mysql_query("SELECT commande FROM commandes_test ORDER BY commande DESC LIMIT 0,1"); 
				$row_mps = mysql_fetch_array($result_mps); 
				$dir = $row_mps["commande"];$cde=$dir+1;$encours="encours";$sans_remise=0;$importation=1;
				$sql  = "INSERT INTO commandes_test ( commande,date_e,importation,client,secteur,company, type_remise,escompte,escompte2,plafond,vendeur, remise_10,remise_2,remise_3,evaluation,destination,sans_remise ) VALUES ( ";
				$sql .= "'" . $cde . "', ";
				$sql .= "'" . $date . "', ";$sql .= "'" . $importation . "', ";
				$sql .= "'" . $client . "', ";$sql .= "'" . $secteur . "', ";$sql .= "'" . $company . "', ";
				$sql .= "'" . $type_remise . "', ";$sql .= "'" . $escompte . "', ";$sql .= "'" . $escompte2 . "', ";$sql .= "'" . $plafond . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $remise10 . "', ";
				$sql .= "'" . $remise2 . "', ";
				$sql .= "'" . $remise3 . "', ";
				$sql .= "'" . $encours . "', ";
				$sql .= "'" . $secteur . "', ";
				$sql .= "'" . $sans_remise . "');";

				db_query($database_name, $sql);
				
				$mysql_insert_id_mps=mysql_insert_id();
				
				for ($i = 0; $i <= $compteur_mps; $i++) {
					$produit=$mps[$i][0];
					$quantite = $mps[$i][1];
					$escompte_exercice=0;
				$sql  = "SELECT * ";
				$sql .= "FROM produits WHERE produit = '$produit' ;";
				$user = db_query($database_name, $sql);
				$user_ = fetch_array($user);$favoris = $user_["favoris"];$condit = $user_["condit"];
				$designation = $user_["designation"];if ($prix_grille==1){$prix_unit = $user_["prix"];}else{$prix_unit = $user_["asswak"];}
				
				$sql  = "INSERT INTO detail_commandes_test ( commande, produit,designation, quantite,prix_unit,date,evaluation,escompte_exercice,escompte,escompte2,client,vendeur,region,ville,condit ) VALUES ( ";
				$sql .= "'" . $cde . "', ";
				$sql .= "'" . $produit . "', ";$sql .= "'" . $designation . "', ";
				$sql .= "'" . $quantite . "', ";
				$sql .= "'" . $prix_unit . "', ";
				$sql .= "'" . $date . "', ";$sql .= "'" . $encours . "', ";
				$sql .= "'" . $escompte_exercice . "', ";
				$sql .= "'" . $escompte . "', ";
				$sql .= "'" . $escompte2 . "', ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $secteur . "', ";
				$sql .= "'" . $secteur . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
				//*promotions
				$sql1p  = "SELECT * ";
				$sql1p .= "FROM liste_promotions where article='$produit' and date_fin>='$date' and base<=$quantite ORDER BY base DESC;";
				$users11pp = db_query($database_name, $sql1p);$trouve=0;
				while($users11_pp = fetch_array($users11pp)) { 
					if ($trouve==0){
						$base=$users11_pp["base"];
						$promotion=$users11_pp["promotion"];
						$date_pp=$users11_pp["date"];
						if ($base>0){$trouve=1;
							@$taux=intval($quantite/$base);
							$promotion=$promotion*$taux;$type="promotion";
							$sql  = "INSERT INTO detail_commandes_pro_test ( commande, produit, quantite,type,date_p,condit ) VALUES ( ";
							$sql .= "'" . $mysql_insert_id_mps . "', ";
							$sql .= "'" . $produit . "', ";
							$sql .= "'" . $promotion . "', ";
							$sql .= "'" . $type . "', ";
							$sql .= "'" . $date_pp . "', ";
							$sql .= "'" . $condit . "');";
							db_query($database_name, $sql);
						} 
					}
				}
				
				
				
				
				
				
				}
				
				
				
				
				
				
			}*/
			
			/*echo "jp : ".$compteur_jp;
			if ($compteur_jp>0){$company="JAOUDA";
				$result_jp = mysql_query("SELECT commande FROM commandes ORDER BY commande DESC LIMIT 0,1"); 
				$row_jp = mysql_fetch_array($result_jp); 
				$dir = $row_jp["commande"];$cde=$dir+1;$encours="encours";$sans_remise=0;$importation=1;
			$sql  = "INSERT INTO commandes_test ( commande,date_e,importation,client,secteur,company, type_remise,escompte,vendeur, remise_10,remise_2,remise_3,evaluation,destination,sans_remise ) VALUES ( ";
				$sql .= "'" . $cde . "', ";
				$sql .= "'" . $date . "', ";$sql .= "'" . $importation . "', ";
				$sql .= "'" . $client . "', ";$sql .= "'" . $secteur . "', ";$sql .= "'" . $company . "', ";$sql .= "'" . $type_remise . "', ";$sql .= "'" . $escompte . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $remise10 . "', ";
				$sql .= "'" . $remise2 . "', ";
				$sql .= "'" . $remise3 . "', ";
				$sql .= "'" . $encours . "', ";
				$sql .= "'" . $destination . "', ";
				$sql .= "'" . $sans_remise . "');";

				db_query_jp($database_name, $sql);
			}*/
			
			
			
			
			
			$result_items -> free_result();
			?>
			
			
			</table>
			</td>
	
	
	
	
	</tr>
		  
		  
			
		 <? }
		  $result -> free_result();
		}

		$mysqli -> close();


/*while($users_ = fetch_array($users)) {?><tr>
	
	
	

<? }*/?>
</table>


</body>

</html>