<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Client";

		$ref = "";$service="";
		$employe = "";$statut=0;$poste="";$s_h=16.32;$mode="";$paie="";$date_entree="";$cin="";$cnss="";$adresse="";$photo="";
		$situation_famille="";$statut_conjoint="";$conjoint="";$nbre_enfants="";
		$adresse_cr="";$date_cr="";$statut_cr=0;$casier="";$date_cj="";$statut_cj="";$gsm="";$domicile="";
		$nom1="";$nom2="";$nom3="";$tel_nom1="";$tel_nom2="";$tel_nom3="";$date_cin="";
		$date_embauche="";$date_naissance="";
		
		
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM employes WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$ref = $user_["ref"];$service = $user_["service"];$s_h = $user_["s_h"];$t_h_25 = $user_["t_h_25"];
		$employe = $user_["employe"];$statut=$user_["statut"];$poste=$user_["poste"];$mode=$user_["mode"];
		$paie=$user_["paie"];$adresse=$user_["adresse"];$cin=$user_["cin"];$cnss=$user_["cnss"];
		$date_entree=dateUsToFr($user_["date_entree"]);$situation_famille=$user_["situation_famille"];$nbre_enfants=$user_["nbre_enfants"];
		$conjoint=$user_["conjoint"];$statut_conjoint=$user_["statut_conjoint"];$photo=$user_["photo"];
		$adresse_cr=$user_["adresse_cr"];$date_cr=dateUsToFr($user_["date_cr"]);$statut_cr=$user_["statut_cr"];
		$casier=$user_["casier"];$date_cj=dateUsToFr($user_["date_cj"]);$statut_cj=$user_["statut_cj"];
		$gsm=$user_["gsm"];$domicile=$user_["domicile"];$date_embauche=dateUsToFr($user_["date_embauche"]);
		$nom1=$user_["nom1"];$nom2=$user_["nom2"];$nom3=$user_["nom3"];$date_cin=dateUsToFr($user_["date_cin"]);
		$tel_nom1=$user_["tel_nom1"];$tel_nom2=$user_["tel_nom2"];$tel_nom3=$user_["tel_nom3"];$date_naissance=dateUsToFr($user_["date_naissance"]);
		
		
		}
		
			
	$profiles_list_s = "";
	$sql43 = "SELECT * FROM rs_data_services ORDER BY service;";
	$temp = db_query($database_name, $sql43);
	while($temp_ = fetch_array($temp)) {
		if($service == $temp_["service"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_s .= "<OPTION VALUE=\"" . $temp_["service"] . "\"" . $selected . ">";
		$profiles_list_s .= $temp_["service"];
		$profiles_list_s .= "</OPTION>";
	}
$profiles_list_poste = "";
	$sql43 = "SELECT * FROM rs_data_postes ORDER BY poste;";
	$temp = db_query($database_name, $sql43);
	while($temp_ = fetch_array($temp)) {
		if($poste == $temp_["poste"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_poste .= "<OPTION VALUE=\"" . $temp_["poste"] . "\"" . $selected . ">";
		$profiles_list_poste .= $temp_["poste"];
		$profiles_list_poste .= "</OPTION>";
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
			document.location = "fiches_employes_mps.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo "Fiche Employe"; ?></span>

<form id="form_user" name="form_user" enctype="multipart/form-data" method="post" action="fiches_employes_mps.php">


<table class="table2"><tr><td style="text-align:center">

	<center>

		<table class="table3">
		<tr><table>
		<td>
		<tr><td><?php echo "Matricule : "; ?><input type="text" id="ref" name="ref" style="width:60px" value="<?php echo $ref; ?>"></td>
		<tr><td><?php echo "Nom et Prenom : "; ?><input type="text" id="employe" name="employe" style="width:260px" value="<?php echo $employe; ?>"></td>
		</td>
		
		</td>
		
		</table>
			
		
		
		<tr>
		<td><?php echo "Salaire H."; ?><input type="text" id="s_h" name="s_h" style="width:90px" value="<?php echo $s_h; ?>"></td>
		</tr>
		<tr><td><?php echo "Paie"; ?><select id="paie" name="paie"><?php echo $profiles_list_paie; ?></select></td>
		<tr><td><?php echo "Mode"; ?><select id="mode" name="mode"><?php echo $profiles_list_mode; ?></select></td>
		<tr><td><?php echo "Type Engagement"; ?><select id="service" name="service"><?php echo $profiles_list_s; ?></select></td>
		<tr><td><input type="checkbox" id="statut" name="statut"<?php if($statut) { echo " checked"; } ?>>Arrêt</td>

		<tr>
		<td><?php echo "Date entree : "; ?><input type="text" id="date_entree" name="date_entree" style="width:260px" value="<?php echo $date_entree; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Date embauche : "; ?><input type="text" id="date_embauche" name="date_embauche" style="width:260px" value="<?php echo $date_embauche; ?>"></td>
		</tr>					
		
		</table>
		
		
		
		


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
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