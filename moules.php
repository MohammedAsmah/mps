<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			
			$code = $_REQUEST["code"];
		$designation = $_REQUEST["designation"];
		$ordre = $_REQUEST["ordre"];
		$couleur = $_REQUEST["couleur"];
		$type_injection = $_REQUEST["type_injection"];
		$nbre_noyaux = $_REQUEST["nbre_noyaux"];
		$longeur_colonne = $_REQUEST["longeur_colonne"];
		$epaisseur = $_REQUEST["epaisseur"];
		$hauteur = $_REQUEST["hauteur"];
		$cales = $_REQUEST["cales"];
		$rondelle = $_REQUEST["rondelle"];
		$bague = $_REQUEST["bague"];
		$anneaux = $_REQUEST["anneaux"];
		$chint = $_REQUEST["chint"];
		$flexible = $_REQUEST["flexible"];
		$faux_plateau = $_REQUEST["faux_plateau"];
		$soufflette = $_REQUEST["soufflette"];
		$regulateur_t = $_REQUEST["regulateur_t"];
		$t_pneumatique = $_REQUEST["t_pneumatique"];
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO moules ( code, designation,ordre,couleur,type_injection,nbre_noyaux,longeur_colonne,epaisseur,hauteur,cales,rondelle,bague,anneaux,chint,flexible,faux_plateau,soufflette,regulateur_t,t_pneumatique )
				 VALUES ('$code','$designation','$ordre','$couleur','$type_injection','$nbre_noyaux','$longeur_colonne','$epaisseur','$hauteur','$cales','$rondelle','$bague','$anneaux','$chint','$flexible','$faux_plateau','$soufflette','$regulateur_t','$t_pneumatique')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE moules SET code = '$code',designation = '$designation',ordre = '$ordre',couleur = '$couleur',type_injection = '$type_injection',nbre_noyaux = '$nbre_noyaux'
					,longeur_colonne = '$longeur_colonne',epaisseur = '$epaisseur',hauteur = '$hauteur',cales = '$cales',rondelle = '$rondelle',bague = '$bague'
					 ,anneaux = '$anneaux',chint = '$chint',flexible = '$flexible',faux_plateau = '$faux_plateau',soufflette = '$soufflette',regulateur_t = '$regulateur_t',t_pneumatique = '$t_pneumatique' WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM moules WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;

			

		} //switch
	} //if
	
	$sql  = "SELECT * ";
	$sql .= "FROM moules ORDER BY ordre;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title><?php echo "" . "liste "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "moule.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<table class="table2">

<tr>
	
	<th><?php echo "N°Moule";?></th>
	<th><?php echo "Nom Moule ";?></th>
	
	
</tr>

<?php 

$du_f="2008-01-01";$au_f="2025-12-31";

while($users_ = fetch_array($users)) { 

	
	$designation=$users_["designation"];
	
	

	//if ($jour>0){
	
	?>


<tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["code"];?></A></td>
<td align="center"><?php  echo $users_["designation"];?></td>
<?

}

?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>

</body>

</html>