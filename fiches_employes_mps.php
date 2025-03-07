<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) ) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$employe = $_REQUEST["employe"];$ref = $_REQUEST["ref"];$service = $_REQUEST["service"];$s_h = $_REQUEST["s_h"];
			$poste = $_REQUEST["poste"];if(isset($_REQUEST["statut"])) { $statut = 1; } else { $statut = 0; }
			$mode = $_REQUEST["mode"];$paie = $_REQUEST["paie"];
		$adresse = $_REQUEST["adresse"];
		$cin = $_REQUEST["cin"];$cnss = $_REQUEST["cnss"];$date_entree = dateFrToUs($_REQUEST["date_entree"]);
		$situation_famille = $_REQUEST["situation_famille"];$nbre_enfants = $_REQUEST["nbre_enfants"];
		$conjoint = $_REQUEST["conjoint"];$date_cin=dateFrToUs($_REQUEST["date_cin"]);$date_naissance=dateFrToUs($_REQUEST["date_naissance"]);
		$statut_conjoint = $_REQUEST["statut_conjoint"];$date_embauche = dateFrToUs($_REQUEST["date_embauche"]);
		
		$adresse_cr=$_REQUEST["adresse_cr"];$date_cr=dateFrToUs($_REQUEST["date_cr"]);
		$t_h_25 = $_REQUEST["t_h_25"];
		$casier=$_REQUEST["casier"];$date_cj=dateFrToUs($_REQUEST["date_cj"]);
		$gsm=$_REQUEST["gsm"];$domicile=$_REQUEST["domicile"];
		$nom1=$_REQUEST["nom1"];$nom2=$_REQUEST["nom2"];$nom3=$_REQUEST["nom3"];
		$tel_nom1=$_REQUEST["tel_nom1"];$tel_nom2=$_REQUEST["tel_nom2"];$tel_nom3=$_REQUEST["tel_nom3"];
		

// Récupération du dossier dans lequel le fichier sera uploadé	
$DESTINATION_FOLDER = 'photos/' ;								
// Taille maximale de fichier, valeur en bytes					
$MAX_SIZE = 50000000 ;													
// Définition des extensions de fichier autorisées (avec le ".")
$AUTH_EXT = array( ".jpg", ".jpeg",".png") ;											


// Fonction permettant de vérifier si l'extension du fichier est

// On vérifie que le champs contenant le chemin du fichier soit
// bien rempli.

		
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
			$poste="service";$tectra=1;
			
		
			$sql  = "INSERT INTO employes 
			(ref,employe,service,statut,poste,paie,mode,s_h,tectra,ordre,date_entree) VALUES ('$ref','$employe','$service','$statut','$poste','$paie','$mode','$s_h','$tectra','$ref','$date_entree')";
				db_query($database_name, $sql);
			

			break;

			case "update_user":
			
			$poste="service";
			
			$user_id=$_REQUEST["user_id"];
				$sql = "UPDATE employes SET ref = '$ref',employe = '$employe',service = '$service',statut = '$statut',date_embauche='$date_embauche'
			,poste = '$poste',mode = '$mode',paie = '$paie',s_h='$s_h',date_entree='$date_entree' WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM employes WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";$occ="occasionnelles";$per="permanents";$vide="";
	$sql .= "FROM employes where employe<>'$vide' and (service='$occ' or service='$per') and statut=0 ORDER BY service,employe;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "fiche_employe_mps.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste "; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "Nom";?></th>
	<th><?php echo "Entree le";?></th>
	<th><?php echo "Embauche";?></th>	
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<? if ($users_["service"]=="permanents"){?>
<td bgcolor="#66CCCC"><a href="JavaScript:EditUser(<?php $id=$users_["id"];echo $users_["id"]; ?>)"><?php echo $users_["employe"];?></A></td>
<td bgcolor="#66CCCC"><?php echo dateUsToFr($users_["date_entree"]); $employe=$users_["employe"];$st=$users_["situation_famille"];?></td>
<td bgcolor="#66CCCC"><?php echo dateUsToFr($users_["date_embauche"]); $employe=$users_["employe"];$st=$users_["situation_famille"];?></td>
<? } else {?>
<td><a href="JavaScript:EditUser(<?php $id=$users_["id"];echo $users_["id"]; ?>)"><?php echo $users_["employe"];?></A></td>
<td><?php echo dateUsToFr($users_["date_entree"]); $employe=$users_["employe"];$st=$users_["situation_famille"];?></td>
<td><?php echo dateUsToFr($users_["date_embauche"]); $employe=$users_["employe"];$st=$users_["situation_famille"];?></td>
<? }?>

<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

</body>

</html>