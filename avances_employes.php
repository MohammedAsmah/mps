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
			$employe = $_REQUEST["employe"];$motif = $_REQUEST["motif"];
			$montant = $_REQUEST["montant"];$montant_prelevement = $_REQUEST["montant_prelevement"];
			$date_avance = dateFrToUs($_REQUEST["date_avance"]);
			$date_debut = dateFrToUs($_REQUEST["date_debut"]);

// Récupération du dossier dans lequel le fichier sera uploadé	
$DESTINATION_FOLDER = 'avances/' ;								
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
			
				$type="avance";
				$sql  = "INSERT INTO avances_employes ( employe,type, date_avance,montant,motif,document )
				 VALUES ('$employe','$type','$date_avance','$montant','$motif','$nomFichier')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			
			$sql = "UPDATE avances_employes SET montant = '$montant',date_avance = '$date_avance',motif = '$motif' WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM avances_employes WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	}

	else
		{$employe=$_GET["employe"];}
	
	$sql  = "SELECT * ";$type="avance";
	$sql .= "FROM avances_employes where employe='$employe' and type='$type' ORDER BY id;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "avance_employe.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Avances employe : ".$employe; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "Date";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Motif";?></th>
	
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<?php $id=$users_["id"]; $date_avance=dateUsToFr($users_["date_avance"]);$employe=$users_["employe"];?>
<? echo "<td><a href=\"avance_employe.php?employe=$employe&user_id=$id\">$date_avance</a></td>";?>
<td><?php echo $users_["montant"]; ?></td>
<td><?php echo $users_["motif"]; ?></td>

<?php } ?>

</table>

<p style="text-align:center">
<? echo "<td><a href=\"avance_employe.php?employe=$employe&user_id=0\">Ajout avance</a></td>";?>
</p>
</body>

</html>