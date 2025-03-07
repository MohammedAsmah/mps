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
			
			$date = dateFrToUs($_REQUEST["date"]);
			list($annee1,$mois1,$jour1) = explode('-', $date); 
			$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
			$mois=date("m",$pdu);$annee=date("Y",$pdu);
			$service=$_REQUEST["service"];
			$vendeur=$_REQUEST["vendeur"];
			$date_open=$_REQUEST["date_open"];
			$user_open=$user_name;
			$observation=$_REQUEST["observation"];
			$motif_cancel=$_REQUEST["motif_cancel"];
			$libelle1=$_REQUEST["libelle1"];
			$montant1=$_REQUEST["montant1"];
			$libelle2=$_REQUEST["libelle2"];
			$montant2=$_REQUEST["montant2"];
			$libelle3=$_REQUEST["libelle3"];
			$montant3=$_REQUEST["montant3"];
			$libelle4=$_REQUEST["libelle4"];
			$montant4=$_REQUEST["montant4"];
			$libelle5=$_REQUEST["libelle5"];
			$montant5=$_REQUEST["montant5"];
			$libelle6=$_REQUEST["libelle6"];
			$montant6=$_REQUEST["montant6"];
			$libelle7=$_REQUEST["libelle7"];
			$montant7=$_REQUEST["montant7"];
			$libelle8=$_REQUEST["libelle8"];
			$montant8=$_REQUEST["montant8"];
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
	// recherche contrat			
		$code_produit="";
			
				$type_service="SEJOURS ET CIRCUITS";
				$sql  = "INSERT INTO registre_reglements (date,service,vendeur,date_open,user_open,libelle1,montant1,
				libelle2,montant2,libelle3,montant3,libelle4,montant4,libelle5,montant5,libelle6,montant6,libelle7,montant7,libelle8,montant8,observation)
				 VALUES ('$date','$service','$vendeur','$date_open','$user_open','$libelle1','$montant1',
				 '$libelle2','$montant2','$libelle3','$montant3','$libelle4','$montant4','$libelle5','$montant5','$libelle6','$montant6','$libelle7','$montant7','$libelle8','$montant8','$observation')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			
			$sql = "UPDATE registre_reglements SET ";
			$sql .= "service = '" . $_REQUEST["service"] . "', ";
			$sql .= "date = '" . $date . "', ";
			$sql .= "observation = '" . $observation . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			$sql .= "libelle1 = '" . $libelle1 . "', ";
			$sql .= "montant1 = '" . $montant1 . "', ";
			$sql .= "libelle2 = '" . $libelle2 . "', ";
			$sql .= "montant2 = '" . $montant2 . "', ";
			$sql .= "libelle3 = '" . $libelle3 . "', ";
			$sql .= "montant3 = '" . $montant3 . "', ";
			$sql .= "libelle4 = '" . $libelle4 . "', ";
			$sql .= "montant4 = '" . $montant4 . "', ";
			$sql .= "libelle5 = '" . $libelle5 . "', ";
			$sql .= "montant5 = '" . $montant5 . "', ";
			$sql .= "libelle6 = '" . $libelle6 . "', ";
			$sql .= "montant6 = '" . $montant6 . "', ";
			$sql .= "libelle7 = '" . $libelle7 . "', ";
			$sql .= "montant7 = '" . $montant7 . "', ";
			$sql .= "libelle8 = '" . $libelle8 . "', ";
			$sql .= "montant8 = '" . $montant8 . "', ";
			$sql .= "motif_cancel = '" . $motif_cancel . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			
			
			// delete user's profile
			$sql = "DELETE FROM registre_reglements WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	else {$vendeur="";$date1="";}
	if(isset($_REQUEST["action_"]) and $_REQUEST["action_"] != "delete_user") { $date1 = $_REQUEST["date"];}
	else {$vendeur="";$date1="";}
	$action="recherche";
	$vendeur_list = "";
	$sql = "SELECT * FROM  vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$vendeur_list .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$vendeur_list .= $temp_["vendeur"];
		$vendeur_list .= "</OPTION>";
	}

	
	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="registres_reglements_maj.php">
	<td><?php echo "Date : "; ?><input onclick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<TR><td><?php echo "Vendeur		:"; ?></td><td><select id="vendeur" name="vendeur"><?php echo $vendeur_list; ?></select></td></TR>
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
	function EditUser(user_id) { document.location = "registre_reglement.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	if(isset($_REQUEST["action"]))
	{ $date=dateFrToUs($_POST['date1']);$vendeur=$_POST['vendeur'];
	
	$sql  = "SELECT * ";
	$sql .= "FROM registre_reglements where date='$date' and vendeur='$vendeur' ORDER BY id;";
	$users11 = db_query($database_name, $sql);
?>


<span style="font-size:24px"><?php echo dateUsToFr($date)."---> ".$vendeur; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Bon Sortie";?></th>
	<th><?php echo "Tableau Enc";?></th>
	<th><?php echo "Encaissé";?></th>
	
</tr>

<?php $compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { $id_r=$users_1["id"];$date_enc=$users_1["date"];$vendeur=$users_1["vendeur"];
			$statut=$users_1["statut"];$observation=$users_1["observation"];
			$service=$users_1["service"];$code=$users_1["code_produit"];$id_tableau=$users_1["id"]."/2008";$bon=$users_1["statut"];?><tr>
			<td><?php echo dateUsToFr($users_1["date"]); ?></td>
			<td><?php echo $users_1["observation"]; ?></td>
			<? echo "<td><a href=\"tableau_enc.php?id_registre=$id_r&date_enc=$date_enc&vendeur=$vendeur&bon_sortie=$bon\">".$id_tableau."</a></td>";

	$sql  = "SELECT * ";
	$sql .= "FROM commandes where id_registre_regl=$id_r ORDER BY date_e;";
	$users = db_query($database_name, $sql);
	$total_g=0;
	while($users_ = fetch_array($users)) { 
		$commande=$users_["commande"];$evaluation=$users_["evaluation"];$client=$users_["client"];$date11=dateUsToFr($users_["date_e"]);
		$vendeur=$users_["vendeur"];$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];
		$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];
		$id=$users_["id"];
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
			 ?><? $total_g=number_format($total_g,2,',',' ');?>
			<? echo "<td><a href=\"reglements_maj.php?id_registre=$id_r&date_enc=$date_enc&vendeur=$vendeur&bon_sortie=$bon\">".$total_g."</a></td>";
 } ?>

</table>
</strong>
<p style="text-align:center">

<? }?>
</body>

</html>