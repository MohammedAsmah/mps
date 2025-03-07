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
			if(isset($_REQUEST["tectra"])) { $tectra = 1; } else { $tectra = 0; }
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
		$conge_du=dateFrToUs($_REQUEST["conge_du"]);$conge_au=dateFrToUs($_REQUEST["conge_au"]);if(isset($_REQUEST["conge"])) { $conge = 1; } else { $conge = 0; }

// Récupération du dossier dans lequel le fichier sera uploadé	
$DESTINATION_FOLDER = 'photos/' ;								
// Taille maximale de fichier, valeur en bytes					
$MAX_SIZE = 50000000 ;													
// Définition des extensions de fichier autorisées (avec le ".")
$AUTH_EXT = array( ".jpg", ".jpeg",".png") ;											


// Fonction permettant de vérifier si l'extension du fichier est
// autorisée.

function isExtAuthorized($ext){
	global $AUTH_EXT;
	if(in_array($ext, $AUTH_EXT)){
		return true;
	}else{
		return false;
	}
}

// On vérifie que le champs contenant le chemin du fichier soit
// bien rempli.

if(!empty($_FILES['fichier1']["name"])){
	
	// Nom du fichier choisi:
	$nomFichier = $_FILES['fichier1']["name"] ;
	// Nom temporaire sur le serveur:
	$nomTemporaire = $_FILES['fichier1']["tmp_name"] ;
	// Type du fichier choisi:
	$typeFichier = $_FILES['fichier1']["type"] ;
	// Poids en octets du fichier choisit:
	$poidsFichier = $_FILES['fichier1']["size"] ;
	// Code de l'erreur si jamais il y en a une:
	$codeErreur = $_FILES['fichier1']["error"] ;
	// Extension du fichier
	$extension = strrchr($nomFichier, ".") ;
	
	// Si le poids du fichier est de 0 bytes, le fichier est
	// invalide (ou le chemin incorrect) => message d'erreur
	// sinon, le script continue.
	if($poidsFichier <> 0){
		// Si la taille du fichier est supérieure à la taille
		// maximum spécifiée => message d'erreur
		if($poidsFichier < $MAX_SIZE){
			// On teste ensuite si le fichier a une extension autorisée
			if(isExtAuthorized($extension)){
				// Ensuite, on copie le fichier uploadé ou bon nous semble.
				$uploadOk = move_uploaded_file($nomTemporaire, $DESTINATION_FOLDER . $nomFichier) ;
			}else{
				echo ("Files with extension $extension can't be upload<br>") ;
			}
		}else{
			$tailleKo = $MAX_SIZE / 1000;
			echo("You can't upload files with higher size than tailleKo Ko.<br>");
		}		
	}else{
		echo("The selected file is not correct <br>");
	}
}else{
	echo("");
}

		
		
		
		
		
		
		
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
			$sql  = "INSERT INTO employes 
			(ref,employe,service,statut,poste,paie,mode,s_h,date_entree,tectra)
 VALUES ('$ref','$employe','$service','$statut','$poste','$paie','$mode','$s_h','$date_entree','$tectra')";
				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			if ($nomFichier<>""){
			$sql = "UPDATE employes SET ref = '$ref',employe = '$employe',service = '$service',statut = '$statut'
			,poste = '$poste',mode = '$mode',paie = '$paie',s_h='$s_h',photo='$nomFichier',
adresse_cr='$adresse_cr',
date_cr='$date_cr',
casier='$casier',
date_cj='$date_cj',
gsm='$gsm',
domicile='$domicile',
nom1='$nom1',
nom2='$nom2',
nom3='$nom3',
tel_nom1='$tel_nom1',
tel_nom2='$tel_nom2',
tel_nom3='$tel_nom3',
conjoint='$conjoint',
statut_conjoint='$statut_conjoint',
cin='$cin',conge='$conge',conge_du='$conge_du',conge_au='$conge_au',
date_cin='$date_cin',
cnss='$cnss',
adresse='$adresse',
date_entree='$date_entree',date_embauche='$date_embauche',date_naissance='$date_naissance',
situation_famille='$situation_famille',
nbre_enfants='$nbre_enfants',t_h_25='$t_h_25'
			
			 
			WHERE id = '$user_id'";}else
			{$sql = "UPDATE employes SET ref = '$ref',employe = '$employe',service = '$service',statut = '$statut'
			,poste = '$poste',mode = '$mode',paie = '$paie',s_h='$s_h',
adresse_cr='$adresse_cr',
date_cr='$date_cr',
casier='$casier',
date_cj='$date_cj',
gsm='$gsm',
domicile='$domicile',
nom1='$nom1',
nom2='$nom2',
nom3='$nom3',
tel_nom1='$tel_nom1',
tel_nom2='$tel_nom2',
tel_nom3='$tel_nom3',
conjoint='$conjoint',
statut_conjoint='$statut_conjoint',
cin='$cin',conge='$conge',conge_du='$conge_du',conge_au='$conge_au',
date_cin='$date_cin',
cnss='$cnss',
adresse='$adresse',
date_entree='$date_entree',date_embauche='$date_embauche',date_naissance='$date_naissance',
situation_famille='$situation_famille',
nbre_enfants='$nbre_enfants',t_h_25='$t_h_25'			
			 
			WHERE id = '$user_id'";}
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
	$sql .= "FROM employes where employe<>'$vide' and (service='$occ' or service='$per') and statut=0 ORDER BY service,date_entree;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "fiche_employe.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste "; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "Nom";?></th>
	<th><?php echo "Entree le";?></th>
	<th><?php echo "C.R";?></th>
	<th><?php echo "C.I.N";?></th>	
	<th><?php echo "Documents";?></th>
	
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<? if ($users_["service"]=="permanents"){?>
<td bgcolor="#66CCCC"><a href="JavaScript:EditUser(<?php $id=$users_["id"];echo $users_["id"]; ?>)"><?php echo $users_["employe"];?></A></td>
<td bgcolor="#66CCCC"><?php echo dateUsToFr($users_["date_entree"]); $employe=$users_["employe"];$st=$users_["situation_famille"];?></td>
<td bgcolor="#66CCCC"><?php echo dateUsToFr($users_["date_cr"]); ?></td>
<td bgcolor="#66CCCC"><?php echo dateUsToFr($users_["date_cin"]); ?></td>
<td bgcolor="#66CCCC"><? echo $st."</td>";?>

<? 				/*$type="avance";$date_av="2021-07-17";$prelevement=1500;
				$sql  = "INSERT INTO avances_employes (id,employe,date_avance,montant,type )
				 VALUES ('','$employe','$date_av','$prelevement','$type')";
				db_query($database_name, $sql);*/?>
	
<td bgcolor="#66CCCC"><? echo "<a href=\"documents_employes.php?id_employe=$id\">Màj</a></td>";?>
<td bgcolor="#66CCCC"><? echo "<a href=\"avances_employes.php?employe=$employe\">Màj</a></td>";?>
<? } else {?>
<td><a href="JavaScript:EditUser(<?php $id=$users_["id"];echo $users_["id"]; ?>)"><?php echo $users_["employe"];?></A></td>
<td><?php echo dateUsToFr($users_["date_entree"]); $employe=$users_["employe"];$st=$users_["situation_famille"];?></td>
<td><?php echo dateUsToFr($users_["date_cr"]); ?></td>
<td><?php echo dateUsToFr($users_["date_cin"]); ?></td>
<td bgcolor="#66CCCC"><? echo $st."</td>";?>

<? 				/*$type="avance";$date_av="2021-07-17";$prelevement=1500;
				$sql  = "INSERT INTO avances_employes ( employe,date_avance,montant,type )
				 VALUES ('$employe','$date_av','$prelevement','$type')";
				db_query($database_name, $sql);*/?>
	
<? echo "<td><a href=\"documents_employes.php?id_employe=$id\">Màj</a></td>";?>


<? }?>
<td><?php echo $users_["photo"];?></td>

<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

</body>

</html>