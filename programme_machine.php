<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$qte_tige1=0;

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$produit = "";$machine="";$prod_6_14="";$prod_14_22="";$prod_22_6="";$temps_arret="";$rebut="";$poids="";$tc1="";$tc2="";$tc3="";$obs_machine="";$obs="";
		$date=$date;$qte=0;
		$debut="";$fin="";$timedebut="";$timefin="";$stock_i="";$stock_f="";
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM programme_machines WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$produit = $user_["produit"];$qte = $user_["qte"];$date = dateUsToFr($user_["date"]);
		$machine = $user_["machine"];$prod_6_14 = $user_["prod_6_14"];$prod_14_22 = $user_["prod_14_22"];$prod_22_6 = $user_["prod_22_6"];
		$temps_arret_h = $user_["temps_arret_h"];$temps_arret_m = $user_["temps_arret_m"];$obs = $user_["obs"];
		$rebut = $user_["rebut"];$tc1 = $user_["tc1"];$tc2 = $user_["tc2"];$tc3 = $user_["tc3"];$obs_machine = $user_["obs_machine"];
		$stock_i = $user_["stock_i"];$timefin = $user_["timefin"];$fin = dateUsToFr($user_["fin"]);
		$timedebut = $user_["timedebut"];$debut = dateUsToFr($user_["debut"]);$stock_f = $user_["stock_f"];
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
	$sql44 = "SELECT * FROM machines ORDER BY id;";
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
		
			UpdateUser();
		
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "programme_machines.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="programme_machines.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

        <tr>
        
        <td><?php echo " Machine "; ?></td>
        <td><?php echo " Article "; ?></td>
		</tr>
        <td><select id="machine" name="machine"><?php echo $profiles_list_machine; ?></select></td>
        <td><select id="produit" name="produit"><?php echo $profiles_list_article; ?></select></td>
		</tr>
		<tr><td><?php echo "Debut Production : "; ?></td><td>Date : <input type="text" id="debut" name="debut" style="width:90px" value="<?php echo $debut; ?>">
		Heure : <input type="text" id="timedebut" name="timedebut" style="width:90px" value="<?php echo $timedebut; ?>"></td>
		<tr><td><?php echo "Fin Production : "; ?></td><td>Date : <input type="text" id="fin" name="fin" style="width:90px" value="<?php echo $fin; ?>">
		Heure : <input type="text" id="timefin" name="timefin" style="width:90px" value="<?php echo $timefin; ?>"></td>
		<tr><td><?php echo "Stock Initial : "; ?></td><td><input type="text" id="stock_i" name="stock_i" style="width:60px" value="<?php echo $stock_i; ?>"></td>
		<tr><td><?php echo "Stock Finnal : "; ?></td><td><input type="text" id="stock_f" name="stock_f" style="width:60px" value="<?php echo $stock_f; ?>"></td>
		
		
        
	</table>
	</tr>
	</center>


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
<?php } ?>
</tr></table>

</center>

</form>

</body>

</html>