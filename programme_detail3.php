<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$id_production = $_REQUEST["id_production"];$qte_tige1=0;$equipe=3;
		$sql  = "SELECT * ";
		$sql .= "FROM productions WHERE id = " . $id_production . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$date = dateUsToFr($user_["date"]);


	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$produit = "";$machine="";$prod_6_14="";$prod_14_22="";$prod_22_6="";$temps_arret_h="";$rebut="";$poids="";$tc1="";$tc2="";$tc3="";$obs_machine="";$obs="";
		$date=$date;$qte=0;$temps_arret_m="";
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM registre_postes WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$produit = $user_["produit"];$du = dateUsToFr($user_["du"]);$au = dateUsToFr($user_["au"]);
		$machine = $user_["poste"];$prod_6_14 = $user_["prod_6_14"];$prod_14_22 = $user_["prod_14_22"];$prod_22_6 = $user_["prod_22_6"];$prod_22_6_ancien = $user_["prod_22_6"];
		$sqlc  = "SELECT * ";
		$sqlc .= "FROM machines WHERE designation = '" . $machine . "';";
		$userc = db_query($database_name, $sqlc); $user_c = fetch_array($userc);
		$categorie = $user_c["categorie"];
		$m1=0;$m2=0;$m3=0;$m4=0;$m5=0;$m6=0;$m7=0;$m8=0;
		$profiles_list_operateur = "";$non="non";
		/*echo "categorie : ".$categorie;
		switch($categorie) {

			case "injection":
					$m1 = 1;
					$sql44 = "SELECT * FROM employes where machine = 1  and affectation = '$non' ORDER BY employe;";					
			break;
			case "laveuse":
					$m2 = 1;
					$sql44 = "SELECT * FROM employes where laveuse = 1  and affectation = '$non' ORDER BY employe;";		
			break;
			case "extrudeuse":
					$m3 = 1;	
					$sql44 = "SELECT * FROM employes where extrudeuse = 1  and affectation = '$non' ORDER BY employe;";	
			break;
			case "broyeur":
					$m4 = 1;
					$sql44 = "SELECT * FROM employes where broyeur = 1  and affectation = '$non' ORDER BY employe;";	
			break;
			case "melange":
					$m5 = 1;
					$sql44 = "SELECT * FROM employes where melange = 1  and affectation = '$non' ORDER BY employe;";	
			break;
			case "chagements":
					$m6 = 1;
					$sql44 = "SELECT * FROM employes where chargements = 1  and affectation = '$non' ORDER BY employe;";	
			break;
			case "services":
					$m7 = 1 ;
					$sql44 = "SELECT * FROM employes where services = 1  and affectation = '$non' ORDER BY employe;";
			break;
			case "emballages":
					$m8 = 1;
					$sql44 = "SELECT * FROM employes where emballages = 1  and affectation = '$non' ORDER BY employe;";	
			break;
			
			
		}*/
		$vide="";$occ="occasionnelles";$per="permanents";$vide="";
		$sql44 = "SELECT * FROM employes where employe<>'$vide' and statut=0 and (service='$occ' or service='$per') and affectation = '$non' ORDER BY employe;";	
		$temp = db_query($database_name, $sql44);
	while($temp_ = fetch_array($temp)) {
		if($prod_22_6 == $temp_["employe"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_operateur .= "<OPTION VALUE=\"" . $temp_["employe"] . "\"" . $selected . ">";
		$profiles_list_operateur .= $temp_["employe"];
		$profiles_list_operateur .= "</OPTION>";
	}
		
	}
	$profiles_list_article = "";
	$sql4 = "SELECT * FROM produits ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article .= $temp_["produit"];
		$profiles_list_article .= "</OPTION>";
	}
	$profiles_list_machine = "";
	$sql44 = "SELECT * FROM machines ORDER BY designation;";
	$temp = db_query($database_name, $sql44);
	while($temp_ = fetch_array($temp)) {
		if($machine == $temp_["designation"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_machine .= "<OPTION VALUE=\"" . $temp_["designation"] . "\"" . $selected . ">";
		$profiles_list_machine .= $temp_["designation"];
		$profiles_list_machine .= "</OPTION>";
	}

	
	
	
	
	

	// extracts profile list

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">
<link href="Templates/css.css" rel="stylesheet" type="text/css">
<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
		if(document.getElementById("date").value == "" ) {
			alert("<?php echo "Date !"; ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "programmes_details.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php  ?></span>

<form id="form_user" name="form_user" method="post" action="programmes_details.php">

<table class="table2"><tr><td style="text-align:center">

	

		<tr> <td colspan="2"><h1>Poste de 06 à 14H</h1></td></tr>

		<tr>
		<td><?php echo "Du"; ?></td><td align="center"><input type="text" id="du" name="date" style="width:100px" value="<?php echo $du; ?>"></td>

        </tr>
		<tr>
		<td><?php echo "Au"; ?></td><td align="center"><input type="text" id="au" name="date" style="width:100px" value="<?php echo $au; ?>"></td>

        </tr>
		
		<tr>
		        <td><?php echo " Machine "; ?></td> <td><select id="machine" name="machine"><?php echo $profiles_list_machine; ?></select></td>
		</tr>
		<tr>
		        <td><?php echo " Operateur "; ?></td> <td><select id="prod_22_6" name="prod_22_6"><?php echo $profiles_list_operateur; ?></select></td>
		</tr>
       
   
	

</table>

<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="prod_22_6_ancien" name="prod_22_6_ancien" value="<?php echo $prod_22_6_ancien; ?>">
<input type="hidden" id="date" name="date" value="<?php echo $date; ?>">
<input type="hidden" id="equipe" name="equipe" value="<?php echo $equipe; ?>">

<input type="hidden" id="id_production" name="id_production" value="<?php echo $id_production; ?>">
<table class="table3"><tr>

<?php if($user_id != "0") { ?>
<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td style="width:20px"></td>
<td><button type="button" onClick="DeleteUser()"><?php echo Translate("Delete"); ?></button></td>
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php } ?>
</tr></table>

</center>

</form>

</body>

</html>