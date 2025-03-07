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
			$result = mysql_query("SELECT bon_sortie FROM registre_vendeurs where mois=$mois and annee=$annee ORDER BY bon_sortie DESC LIMIT 0,1"); 
			$row = mysql_fetch_array($result); 
			echo $row["bon_sortie"];
			$dir = $row["bon_sortie"]+1;
	
			
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
				$sql  = "INSERT INTO registre_vendeurs (date,service,vendeur,date_open,user_open,observation,mois,annee,bon_sortie,statut)
				 VALUES ('$date','$service','$vendeur','$date_open','$user_open','$observation','$mois','$annee','$dir','$statut')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			
			$sql = "UPDATE registre_vendeurs SET ";
			$sql .= "service = '" . $_REQUEST["service"] . "', ";
			$sql .= "date = '" . $date . "', ";
			$sql .= "observation = '" . $observation . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			$sql .= "motif_cancel = '" . $motif_cancel . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			//mise � jour commandes
			$sql = "UPDATE commandes SET ";
			$sql .= "date_e = '" . $date . "' ";
			$sql .= "WHERE id_registre = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			
			break;
			
			case "delete_user":
			
			
			// delete user's profile
			$sql = "DELETE FROM registre_vendeurs WHERE id = " . $_REQUEST["user_id"] . ";";
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
	<form id="form" name="form" method="post" action="registres_vendeurs_update3.php">
	<td><?php echo "Date : "; ?><input onclick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
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
	function EditUser(user_id) { document.location = "registre_vendeur.php?user_id=" + user_id; }
	function EditUser1(user_id) { document.location = "registre_sejour_annuler_sans_lp.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	if(isset($_REQUEST["action"]))
	{ $date=dateFrToUs($_POST['date1']);
	
	$sql  = "SELECT * ";$d1="2009-01-01";$d2="2009-12-31";
	$sql .= "FROM registre_vendeurs where date between '$d1' and '$d2' ORDER BY id;";
	$users11 = db_query($database_name, $sql);
?>


<span style="font-size:24px"><?php echo dateUsToFr($date); ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Destination";?></th>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "B.S Vendeur";?></th>
	<th><?php echo "B.S Magasin";?></th>
	<th><?php echo "Eval.Clients";?></th>
	
	
</tr>

<?php $compteur1=0;$total_g=0;
while($user_ = fetch_array($users11)) { 
		$date=$user_["date"];
		$service = $user_["service"];
		$vendeur = $user_["vendeur"];
		$statut = $user_["statut"];
		$user_open = $user_["user_open"];
		$date_open = $user_["date_open"];
		$observation=$user_["observation"];
		$mois=$user_["mois"];
		$annee=$user_["annee"];
		$bon_sortie=$user_["bon_sortie"];
		$statut=$user_["statut"];$new_id=$user_["id"];
		$id=$user_["id"];$ancien_registre=$user_["ancien_registre"];?>
			<td><a href="JavaScript:EditUser(<?php echo $user_["id"]; ?>)"><?php echo dateUsToFr($user_["date"]); ?></A></td>
			<td><?php $destination=$user_["service"];echo $user_["service"]; ?></td>
			<td><?php echo $user_["vendeur"]; ?></td>
			<td><?php echo $user_["ancien_registre"]; ?></td>
			<td><?php echo $user_["id"]; ?></td>
	<? $sql  = "SELECT * ";$cc=11111;
	$sql .= "FROM commandes where commande=$cc ORDER BY date_e;";
	$users = db_query($database_name, $sql);
	$total_g=0;
	while($users_ = fetch_array($users)) { 
		$date_e = $users_["date_e"];$vendeur=$users_["vendeur"];$ancien_registre=$users_["id_registre"];$net=$users_["net"];$active=$users_["active"];
		$ev_pre=$users_["ev_pre"];$commande=11111;$facture=$users_["facture"];$bondesortie=$users_["bondesortie"];$id1=$users_["id"];
		$ancien_commande=$users_["commande"];$evaluation=$users_["evaluation"];$client=$users_["client"];$valider_f=$users_["valider_f"];	
		$remise10=$users_["remise_10"];$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$remise4=$users_["remise_4"];
		$sans_remise=$users_["sans_remise"];$date=dateUsToFr($users_["date_e"]);$date=dateUsToFr($users_["date_e"]);
		$eval=$users_["eval"];$mois=$users_["mois"];$annee=$users_["annee"];$ccc=$id1+5516;
			$sql = "UPDATE commandes SET ";
			$sql .= "commande = '" . $ccc . "' ";
			$sql .= "WHERE id = " . $id1 . ";";
			db_query($database_name, $sql);

			
			
			 }
			 ?>
 			
			</tr>
		


 <? } 
 
 
 
 
 
 
 ?>

</table>
</strong>
<p style="text-align:center">

<? }?>
</body>

</html>