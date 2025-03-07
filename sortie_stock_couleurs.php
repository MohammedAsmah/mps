<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$qte_tige1=0;$bs = $_REQUEST["bs"];$depot_at = $_REQUEST["depot_a"];$depot_bt = $_REQUEST["depot_b"];

	

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM bon_de_sortie_magasin WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "";

		$produit = $user_["produit"];$qte = $user_["qte"];$date = dateUsToFr($user_["date"]);
		$depot_a = $user_["depot_a"];$depot_b = $user_["depot_b"];$depot_c = $user_["depot_c"];
		$marron = $user_["marron"];$beige = $user_["beige"];$gris = $user_["gris"];
		$marron_b = $user_["marron_b"];$beige_b = $user_["beige_b"];$gris_b = $user_["gris_b"];
	
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
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression de ce produit ?"; ?>")) {
			document.location = "sorties_stock_couleurs.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">


<form id="form_user" name="form_user" method="post" action="sorties_stock_couleurs.php">



        
		<? if($user_id != "20000000") {?>
        	<table width="671" class="table2">

		<tr>
		<td><?php echo "Date"; ?></td><td><?php echo $date."   Bon Sortie : ".$bs; ?></td>
		</tr><tr>
		<tr><td><?php echo "Quantite"; ?></td><td><?php echo "Article"; ?></td>
		<td style="text-align:center"><?php echo "MPS ---> ".$depot_at; ?>
		<table width="671" class="table2">
		<td><?php echo "Marron"; ?></td>
		<td><?php echo "Beige"; ?></td>
		<td><?php echo "Gris"; ?></td>
		</table></td>
		<td style="text-align:center"><?php echo "JP ---> ".$depot_bt; ?>
		<table width="671" class="table2">
		<td><?php echo "Marron"; ?></td>
		<td><?php echo "Beige"; ?></td>
		<td><?php echo "Gris"; ?></td></TD>
		</table>		
		</tr>
		<td><?php echo $depot_a+$depot_b; ?></td>
		<td><?php echo $produit; ?></td>
		
		<? if($user_id <> "0") {?><td><table width="371" class="table2">
		<td style="text-align:center"><input type="text" id="marron" name="marron" style="width:100px" value="<?php echo $marron; ?>"></td>
		<td style="text-align:center"><input type="text" id="beige" name="beige" style="width:100px" value="<?php echo $beige; ?>"></td>
		<td style="text-align:center"><input type="text" id="gris" name="gris" style="width:100px" value="<?php echo $gris; ?>"></td></table></td>
		<td style="text-align:center"><table width="371" class="table2">
		<td style="text-align:center"><input type="text" id="marron_b" name="marron_b" style="width:100px" value="<?php echo $marron_b; ?>"></td>
		<td style="text-align:center"><input type="text" id="beige_b" name="beige_b" style="width:100px" value="<?php echo $beige_b; ?>"></td>
		<td style="text-align:center"><input type="text" id="gris_b" name="gris_b" style="width:100px" value="<?php echo $gris_b; ?>"></td></table></td>
		
		<? }?>
		</tr>
		<? }?>
        
		

	</table>

	</center>

</td></tr></table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="date" name="date" value="<?php echo $date; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">

<table class="table3"><tr>

<?php if($user_id != "0" and $user_id != "20000000") { ?>
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