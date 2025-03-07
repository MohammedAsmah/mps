<?php
set_time_limit(0);
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();$datej=date("d/m/Y H:i:s");
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$user_login = $user_["login"];
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"])) { 
		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			
			$date_v = dateFrToUs($_REQUEST["date"]);
			$frais=$_REQUEST["frais"];
			
			list($annee1,$mois1,$jour1) = explode('-', $date_v); 
			$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
			$mois=date("m",$pdu);$annee=date("Y",$pdu);
			$service=$_REQUEST["service"];
			$vendeur=$_REQUEST["vendeur"];
			$result = mysql_query("SELECT bon_sortie FROM registre_vendeurs where mois=$mois and annee=$annee ORDER BY bon_sortie DESC LIMIT 0,1"); 
			$row = mysql_fetch_array($result); 
			
			$dir = $row["bon_sortie"]+1;
			$imprimer1=$_REQUEST["imprimer1"];
			$matricule=$_REQUEST["matricule"];$obs_c=$_REQUEST["obs_c"];
			if($imprimer1 != 1) {
			if(isset($_REQUEST["imprimer"])) { $imprimer = 1; } else { $imprimer = 0; }
			$heure=date("d/m/y H:i");
			$montant=$_REQUEST["montantev"];}else{ $imprimer = 1; $heure=$_REQUEST["heure1"];
			$montant=$_REQUEST["montantev1"];}
			
			
			
			$statut=$dir."/".$mois.$annee;
			$date_open=$_REQUEST["date_open"];
			$user_open=$user_name;
			$observation=$_REQUEST["observation"];
			$motif_cancel=$_REQUEST["motif_cancel"];
			$livraison=$_REQUEST["livraison"];
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
	// recherche contrat			
		$code_produit="";
			
				$type_service="SEJOURS ET CIRCUITS";
				$sql  = "INSERT INTO registre_vendeurs (date,service,vendeur,date_open,user_open,observation,livraison,mois,annee,bon_sortie,statut)
				 VALUES ('$date_v','$service','$vendeur','$date_open','$user_open','$observation','$livraison','$mois','$annee','$dir','$statut')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			if(isset($_REQUEST["bl_out"])) { $bl_out = 1; } else { $bl_out = 0; }
			if(isset($_REQUEST["bl_in"])) { $bl_in = 1; } else { $bl_in = 0; }
			if(isset($_REQUEST["frais_v"])) { $frais_v = 1; } else { $frais_v = 0; }
			
			$sql = "UPDATE registre_vendeurs SET ";
			$sql .= "service = '" . $_REQUEST["service"] . "', ";
			$sql .= "bl_out = '" . $bl_out . "', ";
			$sql .= "bl_in = '" . $bl_in . "', ";
			$sql .= "livraison = '" . $livraison . "', ";
			$sql .= "frais = '" . $frais . "', ";
			$sql .= "frais_v = '" . $frais_v . "', ";
			$sql .= "date = '" . $date_v . "', ";
			$sql .= "montant = '" . $montant . "', ";
			$sql .= "heure = '" . $heure . "', ";
			$sql .= "imprimer = '" . $imprimer . "', ";
			$sql .= "observation = '" . $observation . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			$sql .= "matricule = '" . $matricule . "', ";$sql .= "obs_c = '" . $obs_c . "', ";
			$sql .= "motif_cancel = '" . $motif_cancel . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			$id_registre=$_REQUEST["user_id"];
			$sql  = "SELECT * ";
			$sql .= "FROM registre_vendeurs WHERE id = " . $_REQUEST["user_id"] . ";";
			$user = db_query($database_name, $sql); $user_ = fetch_array($user);
			$bondesortie = $user_["statut"];$dest=$user_["service"];$vendeur_c=$user_["vendeur"];
			$libelle="Frais Transport B.S $bondesortie $dest $vendeur_c";

			//valider sur caisse
			if ($frais_v==1)
				{
				$caisse="MPS";$type="TRANSPORT  CHARGEMENT";
				$debit=0;$credit=$frais;
				$id_registre=$_REQUEST["user_id"];
				$sql  = "INSERT INTO journal_caisses ( date,id_registre,caisse,libelle,type,debit,user,datej,credit ) VALUES ( ";
				$sql .= "'".$date_v . "',";
				$sql .= "'".$id_registre . "',";
				$sql .= "'".$caisse . "',";
				$sql .= "'".$libelle . "',";
				$sql .= "'".$type . "',";
				$sql .= "'".$debit . "',";
				$sql .= "'".$user_name . "',";
				$sql .= "'".$datej . "',";
				$sql .= "'".$credit . "');";
				db_query($database_name, $sql);?>
				<script>
					
				</script>
				<? }
				// pas de validation
				else
				{
				$id_registre=$_REQUEST["user_id"];
				$sql = "DELETE FROM journal_caisses WHERE id_registre = " . $_REQUEST["user_id"] . ";";
				db_query($database_name, $sql);?>
				<script>
					
				</script>
				<? }



			
			break;
			
			case "delete_user":
			
			
			// delete user's profile
			$sql = "DELETE FROM registre_vendeurs WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			$sql = "UPDATE commandes SET ";$vide=0;
			$sql .= "id_registre = '" . $vide . "' ";
			$sql .= "WHERE id_registre = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			$sql = "DELETE FROM bon_de_sortie_magasin WHERE id_registre = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			$profile_id = GetUserProfile();	$user_name=GetUserName();$date_time=date("y-m-d h:m:s");
			$table_name="registre_vendeurs";$record=$_REQUEST["user_id"];
				$sql  = "INSERT INTO deleted_files ( user,date_time,table_name,record ) VALUES ( ";
				$sql .= "'" . $user_name . "', ";
				$sql .= "'" . $date_time . "', ";
				$sql .= "'" . $table_name . "', ";
				$sql .= "'" . $record . "');";

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
	<form id="form" name="form" method="post" action="registres_vendeurs_t.php">
	<td><?php echo "Date : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	
	</form>
	
	<? }


?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre_vendeur_t.php?user_id=" + user_id; }
	function EditUser1(user_id) { document.location = "registre_sejour_annuler_sans_lp.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	if(isset($_REQUEST["action"]))
	{ $date=dateFrToUs($_POST['date1']);
	
	$sql  = "SELECT * ";$d1="2023-01-01";$d2="2025-12-31";
	$sql .= "FROM registre_vendeurs where date='$date' ORDER BY id;";
	//$sql .= "FROM registre_vendeurs where date between '$d1' and '$d2' ORDER BY id;";
	$users11 = db_query($database_name, $sql);
?>


<span style="font-size:24px"><?php echo dateUsToFr($date); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Destination";?></th>
	<th><?php echo "Vendeur1";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Transport";?></th>
	<th><?php echo "Pourcentage";?></th>
	<th><?php echo "B.S Gardien";?></th>
	<th><?php echo "B.F Chargement";?></th>
	<th><?php echo "B.S Magasin";?></th>
	
	
	
</tr>

<?php $compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { $id_r=$users_1["id"];$date3=$users_1["date"];$vendeur=$users_1["vendeur"];
			$statut=$users_1["statut"];$observation=$users_1["observation"];$valide=$users_1["valide"];$valide_c=$users_1["valide_c"];
			$service=$users_1["service"];$code=$users_1["code_produit"];$lp=$users_1["id"]+100000;$bon=$users_1["statut"];?><tr>
			<? $dt=dateUsToFr($users_1["date"]);$user_id=$users_1["id"];$imprimer=$users_1["imprimer"];$livraison=$users_1["livraison"];
			$hh=$users_1["heure"];$mm=$users_1["montant"];$bl_out=$users_1["bl_out"];$bl_in=$users_1["bl_in"];$frais=$users_1["frais"];$frais_v=$users_1["frais_v"];
				
			$sql  = "SELECT * ";
				$sql .= "FROM rs_data_villes WHERE ville = '" . $service . "';";
				$user = db_query($database_name, $sql); $user_ = fetch_array($user);
				$transport = $user_["transport"];$pourcentage = $user_["pourcentage"];
				
				/*$sql = "UPDATE registre_vendeurs SET ";
			$sql .= "frais = '" . $transport . "' ";
			
			$sql .= "WHERE id = " . $id_r . ";";
			db_query($database_name, $sql);*/
			
	
/*
	
			$sql  = "SELECT * ";
	$sql .= "FROM commandes where id_registre=$id_r ORDER BY date_e;";
	$users = db_query($database_name, $sql);
	$total_g=0;$ttg=0;
	while($users_ = fetch_array($users)) { 
		$commande=$users_["commande"];$evaluation=$users_["evaluation"];$client=$users_["client"];$date11=dateUsToFr($users_["date_e"]);
		$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];
		$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$ttg=$ttg+$users_["net"];
		$id=$users_["id"];
		
			$sql = "UPDATE commandes SET ";
			$sql .= "bondesortie = '" . $bon . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
		
		
		
		
		
		$sql1  = "SELECT * ";$m=0;$total=0;
		$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=0 ORDER BY produit;";
		$users1 = db_query($database_name, $sql1);$non_favoris=0;
		while($users1_ = fetch_array($users1)) { 
			$produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
			$total=$total+$m;
			
						
			
			
			}
			
			
			
			if ($sans_remise==1){$t=$total;$net=$total;} 
			else {
				$t=$total;$remise_1=0;$remise_2=0;$remise_3=0;
				if ($remise10>0){$remise_1=$total*$remise10/100;}
				if ($remise2>0){$remise_2=($total-$remise_1)*$remise2/100;}
				if ($remise3>0){$remise_3=($total-$remise_1-$remise_2)*$remise3/100;}
			 }
			$sql1  = "SELECT * ";$total1=0;
			$sql1 .= "FROM detail_commandes where commande='$numero' and sans_remise=1 ORDER BY produit;";
			$users1 = db_query($database_name, $sql1);
			while($users1_ = fetch_array($users1)) { 
				$produit=$users1_["produit"]; $id=$users1_["id"];$m=$users1_["quantite"]*$users1_["prix_unit"]*$users1_["condit"];
				$total1=$total1+$m;
			 }
				$net=$total+$total1-$remise_1-$remise_2-$remise_3; 
				$total_g=$total_g+$net;
			 }
			
			*/
			
			
			
			
			
			if ($id_r==6162){$total_g="57700.00";}
			
			if ($valide_c==0){
			if ($valide==1){?><td bgcolor="#33FFCC">
						<? echo "<a href=\"registre_vendeur_t.php?user_id=$user_id&montant=$ttg&frais=$frais&fv=$frais_v\">".$dt."</a>"; ?></td>
						
			<? } 
			else { ?>
			<td>
			<? echo "<a href=\"registre_vendeur_t.php?user_id=$user_id&montant=$ttg&frais=$frais&fv=$frais_v\">".$dt."</a>"; ?></td>
			
					<? }
			}
			else{?>			<td><?php echo dateUsToFr($users_1["date"]); ?></td>

			
			<? }?>
			<td><?php $destination=$users_1["service"];echo $users_1["service"]."(".$pourcentage."%)"; 

			
			?></td>

	<? 
			 ?><?php if ($user_login=="admin"){
			  echo "<td><a href=\"evaluation_pre5.php?impression=$impression&observation=$observation&montant=$ttg&id_registre=$id_r&date=$date3&vendeur=$vendeur&bon_sortie=$bon&service=$service\">".$vendeur."</a>"; 
			$imp=" Entete"; $entete="<a href=\"evaluation_pre_imp5.php?observation=$observation&montant=$ttg&id_registre=$id_r&date=$date3&vendeur=$vendeur&bon_sortie=$bon&service=$service\">".$imp."</a>"; 
			print("<font size=\"1\" face=\"Comic sans MS\" color=\"#FF0000\">$entete </font></td>");
			}?>
			
			<?php $pp=$frais/$mm*100;if ( $pp > $pourcentage){?>
			 <td align="right"><? $ch=number_format($mm,2,',',' ')."</td>";print("<font size=\"2\" face=\"Comic sans MS\" color=\"#FF0000\">$ch </font>");?>
			  <td align="right"><? $fraist=number_format($frais,2,',',' ')."</td>";print("<font size=\"2\" face=\"Comic sans MS\" color=\"#FF0000\">$fraist </font>");?>
 			<td align="right"><? $pt=number_format(($frais/$mm)*100,2,',',' ')."%</td>";print("<font size=\"2\" face=\"Comic sans MS\" color=\"#FF0000\">$pt </font>");?>
			<? } else {?>
			<td align="right"><? $ch=number_format($mm,2,',',' ')."</td>";print("<font size=\"2\" face=\"Comic sans MS\" color=\"#0400ff\">$ch </font>");?>
			  <td align="right"><? $fraist=number_format($frais,2,',',' ')."</td>";print("<font size=\"2\" face=\"Comic sans MS\" color=\"#0400ff\">$fraist </font>");?>
 			<td align="right"><? $pt=number_format(($frais/$mm)*100,2,',',' ')."%</td>";print("<font size=\"2\" face=\"Comic sans MS\" color=\"#0400ff\">$pt </font>");?>
			<? } ?>
			
			
			
			<td><?php if ($destination<>""){if ($id_r==6162){$mm="57700.00";}
			 
			
			echo "<a href=\"evaluation_gardien.php?observation=$observation&montant=$ttg&id_registre=$id_r&date=$date3&vendeur=$vendeur&bon_sortie=$bon&service=$service\">".$bon."</a>";?></td>
			<td><? echo "<a href=\"evaluation_chauffeur.php?observation=$observation&montant=$ttg&id_registre=$id_r&date=$date3&vendeur=$vendeur&bon_sortie=$bon&service=$service\"><mark>".$bon."</mark></a>";?></td>
			<td><?php 
			echo "<a href=\"bon_de_sortie5_g.php?observation=$observation&montant=$ttg&id_registre=$id_r&date=$date3&vendeur=$vendeur&bon_sortie=$bon&service=$service&livraison=$livraison\">".$bon."</a>"; ?></td>
			
			
			
			<?php if ($bl_out=="1"){?>
			<td><?php echo "<a href=\"bon_de_sortie_bl.php?observation=$observation&montant=$ttg&id_registre=$id_r&date=$date3&vendeur=$vendeur&bon_sortie=$bon&service=$service\">BL</a>"; ?></td>
			<? } else {?><td></td><?}?>

			<? }else{?><td></td><? }
						
			
 } ?>

</table>
</strong>
<p style="text-align:center">



<? }?>
</body>

</html>
