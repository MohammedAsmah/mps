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
		$adresse = $_REQUEST["adresse"];$cin = $_REQUEST["cin"];$cnss = $_REQUEST["cnss"];$date_entree = dateFrToUs($_REQUEST["date_entree"]);
		$situation_famille = $_REQUEST["situation_famille"];$nbre_enfants = $_REQUEST["nbre_enfants"];$conjoint = $_REQUEST["conjoint"];
		$statut_conjoint = $_REQUEST["statut_conjoint"];
		

// Récupération du dossier dans lequel le fichier sera uploadé	
$DESTINATION_FOLDER = 'photos/' ;								
// Taille maximale de fichier, valeur en bytes					
$MAX_SIZE = 50000000 ;													
// Définition des extensions de fichier autorisées (avec le ".")
$AUTH_EXT = array( ".jpg", ".jpeg") ;											


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
			
		
				$sql  = "INSERT INTO employes ( ref, employe,service,statut,poste,paie,mode,s_h,photo )
				 VALUES ('$ref','$employe','$service','$statut','$poste','$paie','$mode','$s_h','$nomFichier')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			
			$sql = "UPDATE employes SET service = '$service',statut = '$statut'
			,poste = '$poste' WHERE id = '$user_id'";
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
	function EditUser(user_id) { document.location = "employe.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "liste "; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "operateur";?></th>
	<th><?php echo "service";?></th>
	<th><?php echo "Poste";?></th>
	<th><?php echo "Statut";?></th>	
	<th><?php echo "paie";?></th>		
	<th><?php echo "mode";?></th>
	<th><?php echo "S.H";?></th>
	<th><?php echo "Date entrée";?></th>
	
	<th><?php echo "Date embauche";?></th>
	<th><?php echo "Ancienté";?></th>
	<th><?php echo "Taux";?></th>
</tr>

<?php $date_jour=date("Y-m-d");while($users_ = fetch_array($users)) { ?><tr>
<td><?php echo $users_["employe"];?></td>
<td><?php echo $users_["service"]; $ch=substr($users_["service"],0,22);$ch=Trim($ch);$id=$users_["id"];?></td>
<?php /*echo $ch; 
			$id=$users_["id"];
			$sql = "UPDATE employes SET service = '$ch' WHERE id = '$id'";
			db_query($database_name, $sql);*/

?>
<td><?php echo $users_["poste"]; ?></td>
<td><?php $statut=$users_["statut"]; if ($statut==1){echo "Sortie";}?></td>
<td><?php echo $users_["paie"]; ?></td>
<td><?php echo $users_["mode"]; ?></td>
<td><?php echo $users_["s_h"]; ?></td>
<td><?php $date_entree=$users_["date_entree"];$date_embauche=$users_["date_embauche"];$nbjours = round((strtotime($date_jour) - strtotime($date_embauche))/(60*60*24)-1); echo dateUsToFr($users_["date_entree"]); ?></td>
<td><?php echo dateUsToFr($users_["date_embauche"]); ?></td>
<td><?php echo number_format($nbjours/365,2,',',' '); 

$nbre_annee = intval($nbjours/365);$s_h=17.13;
if ($nbre_annee < 2 or $nbre_annee>50){$ancienté = "0%";$anc=0;$s_h=$s_h*(1+0);}
if ($nbre_annee >= 2 and $nbre_annee < 5){$ancienté = "5%";$anc=0;$s_h=$s_h*(1.05);}
if ($nbre_annee >= 5 and $nbre_annee < 12){$ancienté = "10%";$anc=10;$s_h=$s_h*(1.10);}
if ($nbre_annee >= 12 and $nbre_annee < 20){$ancienté = "15%";$anc=15;$s_h=$s_h*(1.15);}
if ($nbre_annee >= 20 and $nbre_annee < 25){$ancienté = "20%";$anc=20;$s_h=$s_h*(1.20);}
if ($nbre_annee >= 25 and $nbre_annee < 50){$ancienté = "25%";$anc=25;$s_h=$s_h*(1.25);}
$sql = "UPDATE employes SET s_h='$s_h' WHERE id = '$id'";
			db_query($database_name, $sql);


?></td>
<td><?php echo $ancienté; ?></td>
<td><?php echo $s_h; ?></td>
<?php } ?>

</table>

<p style="text-align:center">

</body>

</html>