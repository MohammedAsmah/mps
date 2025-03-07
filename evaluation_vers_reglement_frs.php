<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	$id_commande=$_GET['id_commande'];$id_registre=$_GET['id_registre'];$vendeur=$_GET['vendeur'];
	$eval=$_GET['evaluation'];$client=$_GET['client'];$montant_e=$_GET['montant'];
	$mode_list = "";$mo="mode_reg";$date_enc=$_GET['date_enc'];$facture="";$montant_f="";
	
	$sql  = "SELECT preparation,validation,date,frs,produit,ref,taux_tva,type,sum(qte) As total_qte,sum(prix_achat) As total_prix ";$eti="eti";
	$sql .= "FROM achats_mat where frs='$vendeur' and ref='$eval' GROUP BY ref order by date;";
	$users = db_query($database_name, $sql);$users_ = fetch_array($users);$preparation=$users_["preparation"];
	$last_preparation=$users_["preparation"];
	if (!$preparation){$action_r="reglement";}else{$action_r="maj";}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Detail Evaluation"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
			UpdateUser();
	}

--></script>

<style type="text/css">
<!--
.Style1 {color: #FF0000}
-->
</style>
</head>

<body style="background:#dfe8ff">

<?php  echo $action_r;  ?><p>

<form id="form_user" name="form_user" method="post" action="reglements_frs.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
		<tr>
		<td><?php echo "Fournisseur : "; ?></td><td><?php echo $vendeur; ?></td>
		</tr>
		<tr>
		<td><?php echo "Facture : "; ?></td><td><?php echo $eval." : ".number_format($montant_e,2,',',' '); ?></td>
		</tr>
		<tr>
		<td><?php echo "Date : "; ?></td><td><?php echo dateUsToFr($date_enc); ?></td>
		</tr>
		<tr>
		<td><?php echo "Montant Traite : "; ?></td><td><input type="text" id="montant_e" name="montant_e" value="<?php echo $montant_e; ?>"></td>
		</tr>
		<tr>
		<td><input type="checkbox" id="preparation" name="preparation"<?php if($preparation) { echo " checked"; } ?>></td>
		<td><?php echo "Inclure"; ?></td></tr>
	
<tr>
		
	<table class="table3">

	</table>

        <p>&nbsp;</p>
  <tr>
  <p style="text-align:center">
    
<center>
    
<input type="hidden" id="id_registre" name="id_registre" value="<?php echo $id_registre; ?>">
    <input type="hidden" id="id_commande" name="id_commande" value="<?php echo $eval; ?>">
    <input type="hidden" id="action_r" name="action_r" value="<?php echo $action_r; ?>">
    <input type="hidden" id="vendeur" name="vendeur" value="<?php echo $vendeur; ?>">
    <input type="hidden" id="date_enc" name="date_enc" value="<?php echo $date_enc; ?>">
	<input type="hidden" id="last_preparation" name="last_preparation" value="<?php echo $last_preparation; ?>">
    <input type="hidden" id="eval" name="eval" value="<?php echo $eval; ?>">
<table class="table3"><tr>
    
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
    </tr></table>
    
</center>
</form>


<p style="text-align:center">
<table>
<? /*echo "<td><a href=\"registres_reglements.php?date=$date&vendeur=$vendeur&id_registre=$id_registre\">Terminer</a></td>";*/?>
</table>
</body>

</html>