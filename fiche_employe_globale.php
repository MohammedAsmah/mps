<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
$profile_id = GetUserProfile();
$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];
	$error_message = "";
	$user_id = $_REQUEST["user_id"];
	

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Client";

		$ref = "";$service="";
		$employe = "";$statut=0;$poste="";$s_h=0;$mode="";$paie="";$date_entree="";$cin="";$cnss="";$adresse="";$photo="";
		$situation_famille="";$statut_conjoint="";$conjoint="";$nbre_enfants="";
		$adresse_cr="";$date_cr="";$statut_cr=0;$casier="";$date_cj="";$statut_cj="";$gsm="";$domicile="";
		$nom1="";$nom2="";$nom3="";$tel_nom1="";$tel_nom2="";$tel_nom3="";$date_cin="";$salaire_net=0;
		$date_embauche="";$date_naissance="";$conge=0;$conge_du="";$conge_au="";
		
		
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM salaries WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$ref = $user_["ref"];$service = $user_["service"];$s_h = $user_["s_h"];$t_h_25 = $user_["t_h_25"];$salaire_net = $user_["salaire_net"];
		$employe = $user_["employe"];$statut=$user_["statut"];$poste=$user_["poste"];$mode=$user_["mode"];$poste1=$user_["fonction"];
		$paie=$user_["paie"];$adresse=$user_["adresse"];$cin=$user_["cin"];$cnss=$user_["cnss"];$date_sortie=dateUsToFr($user_["date_sortie"]);
		$date_entree=dateUsToFr($user_["date_entree"]);$situation_famille=$user_["situation_famille"];$nbre_enfants=$user_["nbre_enfants"];
		$conjoint=$user_["conjoint"];$statut_conjoint=$user_["statut_conjoint"];$photo=$user_["photo"];
		$adresse_cr=$user_["adresse_cr"];$date_cr=dateUsToFr($user_["date_cr"]);$statut_cr=$user_["statut_cr"];
		$casier=$user_["casier"];$date_cj=dateUsToFr($user_["date_cj"]);$statut_cj=$user_["statut_cj"];
		$gsm=$user_["gsm"];$domicile=$user_["domicile"];$date_embauche=dateUsToFr($user_["date_embauche"]);
		$nom1=$user_["nom1"];$nom2=$user_["nom2"];$nom3=$user_["nom3"];$date_cin=dateUsToFr($user_["date_cin"]);$date_c=dateUsToFr($user_["date_c"]);
		$tel_nom1=$user_["tel_nom1"];$tel_nom2=$user_["tel_nom2"];$tel_nom3=$user_["tel_nom3"];$date_naissance=dateUsToFr($user_["date_naissance"]);
		
		$conge=$user_["conge"];$conge_du=dateUsToFr($user_["conge_du"]);$conge_au=dateUsToFr($user_["conge_au"]);
		
		}
	$profiles_list_s = "";
	$sql43 = "SELECT * FROM rs_data_services1 ORDER BY service;";
	$temp = db_query($database_name, $sql43);
	while($temp_ = fetch_array($temp)) {
		if($service == $temp_["service"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_s .= "<OPTION VALUE=\"" . $temp_["service"] . "\"" . $selected . ">";
		$profiles_list_s .= $temp_["service"];
		$profiles_list_s .= "</OPTION>";
	}
$profiles_list_poste = "";
	$sql43 = "SELECT * FROM rs_data_postes1 ORDER BY poste;";
	$temp = db_query($database_name, $sql43);
	while($temp_ = fetch_array($temp)) {
		if($poste == $temp_["poste"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_poste .= "<OPTION VALUE=\"" . $temp_["poste"] . "\"" . $selected . ">";
		$profiles_list_poste .= $temp_["poste"];
		$profiles_list_poste .= "</OPTION>";
	}
	$profiles_list_poste1 = "";
	$sql43 = "SELECT * FROM rs_data_fonctions1 ORDER BY poste;";
	$temp = db_query($database_name, $sql43);
	while($temp_ = fetch_array($temp)) {
		if($poste1 == $temp_["poste"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_poste1 .= "<OPTION VALUE=\"" . $temp_["poste"] . "\"" . $selected . ">";
		$profiles_list_poste1 .= $temp_["poste"];
		$profiles_list_poste1 .= "</OPTION>";
	}
$profiles_list_paie = "";
	$sql45 = "SELECT * FROM rs_data_paie ORDER BY paie;";
	$temp = db_query($database_name, $sql45);
	while($temp_ = fetch_array($temp)) {
		if($paie == $temp_["paie"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_paie .= "<OPTION VALUE=\"" . $temp_["paie"] . "\"" . $selected . ">";
		$profiles_list_paie .= $temp_["paie"];
		$profiles_list_paie .= "</OPTION>";
	}
$profiles_list_mode = "";
	$sql46 = "SELECT * FROM rs_data_mode ORDER BY mode;";
	$temp = db_query($database_name, $sql46);
	while($temp_ = fetch_array($temp)) {
		if($mode == $temp_["mode"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_mode .= "<OPTION VALUE=\"" . $temp_["mode"] . "\"" . $selected . ">";
		$profiles_list_mode .= $temp_["mode"];
		$profiles_list_mode .= "</OPTION>";
	}
	
	$profiles_list_sf = "";
	$sql46 = "SELECT * FROM rs_data_sf ORDER BY mode;";
	$temp = db_query($database_name, $sql46);
	while($temp_ = fetch_array($temp)) {
		if($situation_famille == $temp_["mode"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_sf .= "<OPTION VALUE=\"" . $temp_["mode"] . "\"" . $selected . ">";
		$profiles_list_sf .= $temp_["mode"];
		$profiles_list_sf .= "</OPTION>";
	}	
	
	// extracts profile list
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
<script language="JavaScript">
<!--
//PLF-http://www.jejavascript.net/
var position=0;
var msg="VOTRE TEXTE DEFILANT";
var msg="     "+msg;
var longue=msg.length;
var fois=(70/msg.length)+1;
for(i=0;i<=fois;i++) msg+=msg;
function textdefil() {
document.form1.deftext.value=msg.substring(position,position+70);
position++;
if(position == longue) position=0;
setTimeout("textdefil()",100);
}
window.onload = textdefil;
//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
		if(document.getElementById("employe").value == "" ) {
			alert("<?php echo Translate("The values for the fields are required !"); ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "fiches_employes_globales.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo "Fiche Employe"; ?></span>

<form id="form_user" name="form_user" enctype="multipart/form-data" method="post" action="fiches_employes_globales.php">


<table class="table2"><tr><td style="text-align:center">

	<center>

		<table class="table3">
		<tr><table>
		<td>
		<tr><td><?php echo "Matricule : "; ?><input type="text" id="ref" name="ref" style="width:160px" value="<?php echo $ref; ?>"></td>
		<tr><td><?php echo "Nom et Prenom : "; ?><input type="text" id="employe" name="employe" style="width:260px" value="<?php echo $employe; ?>"></td>
		<tr><td><?php echo "Type Engagement"; ?><select id="service" name="service"><?php echo $profiles_list_s; ?></select></td>
		<tr><td><?php echo "Departement"; ?><select id="poste" name="poste"><?php echo $profiles_list_poste; ?></select></td>
		<tr><td><?php echo "Fonction"; ?><select id="poste1" name="poste1"><?php echo $profiles_list_poste1; ?></select></td>
		<tr><td><?php echo "Photo : "; ?><input type="file" name="fichier1" /></td>
		<tr><td><? {print("<img src=\"./photos/$photo\" border=\"0\">");} ?></td>
		</td>
		</table>
		<tr>
		<td><?php echo "Certificat Residence"; ?></td>
		<tr><td><?php echo "Addresse : "; ?>
		<input type="text" id="adresse_cr" name="adresse_cr" style="width:260px" value="<?php echo $adresse_cr; ?>"></td>
		<tr><td><?php echo "Délivré le : "; ?>
		<input type="text" id="date_cr" name="date_cr" style="width:260px" value="<?php echo $date_cr; ?>"></td>
		<tr><td><?php echo "Casier "; ?></td>
		<tr><td><?php echo "Document : "; ?>
		<input type="text" id="casier" name="casier" style="width:260px" value="<?php echo $casier; ?>"></td>
		<tr><td><?php echo "Délivré le : "; ?>
		<input type="text" id="date_cj" name="date_cj" style="width:260px" value="<?php echo $date_cj; ?>"></td>
		<tr><td><?php echo "Tél. G.S.M : "; ?>
		<input type="text" id="gsm" name="gsm" style="width:260px" value="<?php echo $gsm; ?>"></td>
		<tr><td><?php echo "Tél. Domicile : "; ?>
		<input type="text" id="gsm" name="gsm" style="width:260px" value="<?php echo $gsm; ?>"></td>
		<tr><td><?php echo "Personnes à contacter en cas d'urgence "; ?></td>
		<tr>
		<td><input type="text" id="nom1" name="nom1" style="width:200px" value="<?php echo $nom1; ?>">
		<input type="text" id="tel_nom1" name="tel_nom1" style="width:200px" value="<?php echo $tel_nom1; ?>"></td>
		<tr>
		<td><input type="text" id="nom2" name="nom2" style="width:200px" value="<?php echo $nom2; ?>">
		<input type="text" id="tel_nom2" name="tel_nom2" style="width:200px" value="<?php echo $tel_nom2; ?>"></td>
		<tr>
		<td><input type="text" id="nom3" name="nom3" style="width:200px" value="<?php echo $nom3; ?>">
		<input type="text" id="tel_nom3" name="tel_nom3" style="width:200px" value="<?php echo $tel_nom3; ?>"></td>
		
		
		
		<tr>
		<td><?php echo "Salaire de Base"; ?><input type="text" id="s_h" name="s_h" style="width:90px" value="<?php echo $s_h; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Salaire Net "; ?><input type="text" id="salaire_net" name="salaire_net" style="width:90px" value="<?php echo $salaire_net; ?>"></td>
		</tr>
		<tr><td><?php echo "Paie"; ?><select id="paie" name="paie"><?php echo $profiles_list_paie; ?></select></td>
		<tr><td><?php echo "Mode"; ?><select id="mode" name="mode"><?php echo $profiles_list_mode; ?></select></td>
		
		<tr><td><input type="checkbox" id="statut" name="statut"<?php if($statut) { echo " checked"; } ?>>Arrêt le :<input type="text" id="date_sortie" name="date_sortie" style="width:160px" value="<?php echo $date_sortie; ?>"></td>

		<tr>
		<td><?php echo "Date entree : "; ?><input type="text" id="date_entree" name="date_entree" style="width:260px" value="<?php echo $date_entree; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Date embauche : "; ?><input type="text" id="date_embauche" name="date_embauche" style="width:260px" value="<?php echo $date_embauche; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Adresse : "; ?><input type="text" id="adresse" name="adresse" style="width:260px" value="<?php echo $adresse; ?>"></td>
		</tr>
		
		<tr>
		<td><?php echo "C.I.N"; ?><input type="text" id="cin" name="cin" style="width:260px" value="<?php echo $cin; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Date Naissance"; ?><input type="text" id="date_naissance" name="date_naissance" style="width:260px" value="<?php echo $date_naissance; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Date C.I.N"; ?><input type="text" id="date_cin" name="date_cin" style="width:260px" value="<?php echo $date_cin; ?>"></td>
		</tr>
			
		
		<tr>
		<td><?php echo "C.N.S.S"; ?><input type="text" id="cnss" name="cnss" style="width:260px" value="<?php echo $cnss; ?>"></td>
		</tr>
		
		<tr><td><?php echo "Situation Famille"; ?><select id="situation_famille" name="situation_famille"><?php echo $profiles_list_sf; ?></select></td>
		
		<tr>
		<td><?php echo "Nbre enfants"; ?><input type="text" id="nbre_enfants" name="nbre_enfants" style="width:260px" value="<?php echo $nbre_enfants; ?>"></td>
		</tr>
	
		<tr>
		<td><?php echo "Conjoint"; ?><input type="text" id="conjoint" name="conjoint" style="width:260px" value="<?php echo $conjoint; ?>"></td>
		</tr>	
		
		<tr>
		<td><?php echo "Statut Conjoint"; ?><input type="text" id="statut_conjoint" name="statut_conjoint" style="width:260px" value="<?php echo $statut_conjoint; ?>"></td>
		</tr>		

		<? if ($login=="admin"){?>
		<tr>
		<td><?php echo "Date Ctr"; ?><input type="text" id="date_c" name="date_c" style="width:260px" value="<?php echo $date_c; ?>"></td>
		</tr>	
		<tr>
		<td><?php echo "En congé"; ?><input type="checkbox" id="conge" name="conge"<?php if($conge) { echo " checked"; } ?>></td>
		</tr>
		<tr>
		<td><?php echo "Date Du"; ?><input type="text" id="conge_du" name="conge_du" style="width:260px" value="<?php echo $conge_du; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Date Au"; ?><input type="text" id="conge_au" name="conge_au" style="width:260px" value="<?php echo $conge_au; ?>"></td>
		</tr>
		
		
		<? }?>
		</table>
		
		
		
		


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<? if ($login=="leila"){?>
<input type="hidden" id="date_c" name="date_c" value="<?php echo $date_c; ?>">
<? }?>
<table class="table3"><tr>

<?php if($user_id != "0") { ?>
<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td style="width:20px"></td>
<td><button type="button" onClick="DeleteUser()"><?php echo Translate("Delete"); ?></button></td>
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php 
} ?>
</tr></table>

</center>

</form>

</body>

</html>