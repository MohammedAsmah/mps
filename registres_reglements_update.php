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
			
			//mise à jour commandes
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
	<form id="form" name="form" method="post" action="registres_reglements_update.php">
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
	
	$sql  = "SELECT * ";
	$sql .= "FROM registre_reglements_2009 ORDER BY id;";
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
		$date=$user_["date"];$ancien_registre=$user_["id"];
		$service = $user_["service"];
		$vendeur = $user_["vendeur"];
		$bon_sortie = $user_["bon_sortie"];
		$mois = $user_["mois"];
		$annee = $user_["annee"];
		$statut = $user_["statut"];
		$user_open = $user_["user_open"];
		$date_open = $user_["date_open"];
		$observation=$user_["observation"];
		$motif_cancel=$user_["motif_cancel"];
		$libelle1=$user_["libelle1"];$montant1=$user_["montant1"];
		$libelle2=$user_["libelle2"];$montant2=$user_["montant2"];
		$libelle3=$user_["libelle3"];$montant3=$user_["montant3"];
		$libelle4=$user_["libelle4"];$montant4=$user_["montant4"];
		$libelle5=$user_["libelle5"];$montant5=$user_["montant5"];
		$libelle6=$user_["libelle6"];$montant6=$user_["montant6"];
		$libelle7=$user_["libelle7"];$montant7=$user_["montant7"];
		$libelle8=$user_["libelle8"];$montant8=$user_["montant8"];
		$objet1=$user_["objet1"];$cheque1=$user_["cheque1"];
		$objet2=$user_["objet2"];$cheque2=$user_["cheque2"];
		$objet3=$user_["objet3"];$cheque3=$user_["cheque3"];
		$objet4=$user_["objet4"];$cheque4=$user_["cheque4"];
		$objet5=$user_["objet5"];$cheque5=$user_["cheque5"];
		$objet6=$user_["objet6"];$cheque6=$user_["cheque6"];
		$objet7=$user_["objet7"];$cheque7=$user_["cheque7"];
		$objet8=$user_["objet8"];$cheque8=$user_["cheque8"];
		$objet9=$user_["objet9"];$cheque9=$user_["cheque9"];
		$objet10=$user_["objet10"];$cheque10=$user_["cheque10"];
		$date_cheque1=$user_["date_cheque1"];$ref1=$user_["ref1"];
		$date_cheque2=$user_["date_cheque2"];$ref2=$user_["ref2"];
		$date_cheque3=$user_["date_cheque3"];$ref3=$user_["ref3"];
		$date_cheque4=$user_["date_cheque4"];$ref4=$user_["ref4"];
		$date_cheque5=$user_["date_cheque5"];$ref5=$user_["ref5"];
		$date_cheque6=$user_["date_cheque6"];$ref6=$user_["ref6"];
		$date_cheque7=$user_["date_cheque7"];$ref7=$user_["ref7"];
		$date_cheque8=$user_["date_cheque8"];$ref8=$user_["ref8"];
		$date_cheque9=$user_["date_cheque9"];$ref9=$user_["ref9"];
		$date_cheque10=$user_["date_cheque10"];$ref10=$user_["ref10"];
				$sql  = "INSERT INTO registre_reglements (date,ancien_registre,service,vendeur,bon_sortie,mois,annee,date_open,user_open,libelle1,montant1,
				libelle2,montant2,libelle3,montant3,libelle4,montant4,libelle5,montant5,libelle6,montant6,libelle7,montant7,libelle8,montant8
				,objet1,cheque1,date_cheque1,ref1,
				date_cheque2,ref2,
				date_cheque3,ref3,
				date_cheque4,ref4,
				date_cheque5,ref5,
				date_cheque6,ref6,
				date_cheque7,ref7,
				date_cheque8,ref8,
				date_cheque9,ref9,
				date_cheque10,ref10,
				objet2,cheque2,objet3,cheque3,objet4,cheque4,objet5,cheque5,objet6,cheque6,objet7,cheque7,objet8,cheque8,
				objet9,cheque9,objet10,cheque10,observation)
				 VALUES ('$date','$ancien_registre','$service','$vendeur','$bon_sortie','$mois','$annee','$date_open','$user_open','$libelle1','$montant1',
				 '$libelle2','$montant2','$libelle3','$montant3','$libelle4','$montant4','$libelle5','$montant5','$libelle6','$montant6','$libelle7','$montant7','$libelle8','$montant8',
				 '$objet1','$cheque1','$date_cheque1','$ref1',
				 '$date_cheque2','$ref2',
				 '$date_cheque3','$ref3',
				 '$date_cheque4','$ref4',
				 '$date_cheque5','$ref5',
				 '$date_cheque6','$ref6',
				 '$date_cheque7','$ref7',
				 '$date_cheque8','$ref8',
				 '$date_cheque9','$ref9',
				 '$date_cheque10','$ref10',
				 '$objet2','$cheque2','$objet3','$cheque3','$objet4','$cheque4','$objet5','$cheque5','$objet6','$cheque6',
				 '$objet7','$cheque7','$objet8','$cheque8','$objet9','$cheque9','$objet10','$cheque10','$observation')";

				db_query($database_name, $sql);





 } 
 
 
 
 
 
 
 ?>

</table>
</strong>
<p style="text-align:center">

<? }?>
</body>

</html>