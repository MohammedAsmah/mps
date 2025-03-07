<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$id_production = $_REQUEST["id_production"];$qte_tige1=0;$equipe=2;
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
		$sql .= "FROM details_productions WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$produit = $user_["produit"];$date = dateUsToFr($user_["date"]);$poids = $user_["poids_2"];
		$machine = $user_["machine"];$prod_6_14 = $user_["prod_6_14"];$prod_14_22 = $user_["prod_14_22"];$prod_22_6 = $user_["prod_22_6"];
		$temps_arret_h = $user_["temps_arret_h_2"];$temps_arret_m = $user_["temps_arret_m_2"];$obs = $user_["obs"];
		$rebut = $user_["rebut_2"];$tc1 = $user_["tc1"];$tc2 = $user_["tc2"];$tc3 = $user_["tc3"];$obs_machine = $user_["obs_machine_2"];
		
		
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
			document.location = "productions_details.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="productions_details.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table width="671" class="table3">

		<tr>
		<td><?php echo "Date"; ?></td><td align="center"><input type="text" id="date" name="date" style="width:100px" value="<?php echo $date; ?>"></td>

        </tr>
		<tr>
		        <td><?php echo " Machine "; ?></td> <td><select id="machine" name="machine"><?php echo $profiles_list_machine; ?></select></td>
		</tr>
		<tr>
		        <td width="240"><?php echo " Article "; ?></td><td><select id="produit" style="width:240px" name="produit"><?php echo $profiles_list_article; ?></select></td>



		</tr>
        </table>
        <tr>
		<table border="1" class="table2">		
		<tr>
        
        <td width="70"><?php echo " Prod 14h00-22h00 "; ?></td><td width="70"><?php echo " Rebuts "; ?></td><td width="180"><?php echo " Temps de cycle "; ?></td>
        <td width="70"><?php echo " Temps d'arrêt "; ?></td>
        
        <td width="70"><?php echo " Poids "; ?></td>
        
		</tr>
        
        <td align="center"><input type="text" id="prod_14_22" name="prod_14_22" style="width:50px" value="<?php echo $prod_14_22; ?>"></td>
		<td><input type="text" id="rebut" name="rebut" style="width:50px" value="<?php echo $rebut; ?>"></td>
		<td><input type="text" id="tc2" name="tc2" style="width:150px" value="<?php echo $tc2; ?>"></td>
        <td><input type="text" id="temps_arret_h" name="temps_arret_h" style="width:30px" value="<?php echo $temps_arret_h; ?>">:
        <input type="text" id="temps_arret_m" name="temps_arret_m" style="width:30px" value="<?php echo $temps_arret_m; ?>"></td>
        
        <td><input type="text" id="poids" name="poids" style="width:50px" value="<?php echo $poids; ?>"></td>
        
		</tr>
        
	</table>

    <tr>
	<table class="table2">
        <td width="200"><?php echo " Observation "; ?></td>
        <td><input type="text" id="obs_machine" name="obs_machine" style="width:400px" value="<?php echo $obs_machine; ?>"></td>
    </table>
	</tr>
	</center>

</td></tr></table>

<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
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