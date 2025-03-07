<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];
	$qte_tige1=0;
				


	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Produit";

		$produit = "";$favoris = 0;$non_favoris = 0;$colorant="";$qte_colorant=0;$dispo=0;
		$condit = "";$poids_evaluation="";$unite="";
		$non_disponible="";$seuil_critique=0;$type="";$stock_controle="";
		$accessoire_1="";$qte_ac_1="";$poids_ac_1="";$mat_ac_1="";
		$accessoire_2="";$qte_ac_2="";$poids_ac_2="";$mat_ac_2="";
		$accessoire_3="";$qte_ac_3="";$poids_ac_3="";$mat_ac_3="";$famille="";

		$prix = "";$en_cours_final=0;$prix_revient_final=0;$production=0;$stock_ini_exe=0;
		$poids = "";$stock_initial = 0;$encours = 0;$stock_final = 0;$prix_revient =0;
		$tige="";$qte_tige=1;$emballage="";$qte_emballage=1;$matiere="";$qte_matiere=1;$etiquette="";$qte_etiquette=1;
	
	} else {

		$action_ = "besoin";
		$qte=0;$obs="";$besoin="";
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM articles_commandes WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$non_disponible=$user_["non_disponible"];$seuil_critique=$user_["seuil_critique"];
		$accessoire_1=$user_["accessoire_1"];$qte_ac_1=$user_["qte_ac_1"];
		$accessoire_2=$user_["accessoire_2"];$qte_ac_2=$user_["qte_ac_2"];
		$accessoire_3=$user_["accessoire_3"];$qte_ac_3=$user_["qte_ac_3"];$unite=$user_["unite"];



		$title = "details";$poids_evaluation=$user_["poids_evaluation"];
		$stock_ini_exe = $user_["stock_ini_exe"];$type = $user_["type"];$stock_controle = $user_["stock_controle"];
		$produit = $user_["produit"];$colorant = $user_["colorant"];$dispo = $user_["dispo"];$production=0;$production1 = $user_["production"];
		$condit = $user_["condit"];$qte_colorant=$user_["qte_colorant"];$prix_revient_final = $user_["prix_revient_final"];$en_cours_final = $user_["en_cours_final"];
		$prix = $user_["prix"];$favoris = $user_["favoris"];$non_favoris = $user_["non_favoris"];$encours = $user_["encours"];
		$poids = $user_["poids"];$stock_initial = $user_["stock_ini_exe"];$stock_final = $user_["stock_final"];$prix_revient = $user_["prix_revient"];
		$tige=$user_["tige"];$qte_tige=$user_["qte_tige"];$emballage=$user_["emballage"];$qte_emballage=$user_["qte_emballage"];
		$matiere=$user_["matiere"];$qte_matiere=$user_["qte_matiere"];$etiquette=$user_["etiquette"];$qte_etiquette=$user_["qte_etiquette"];
			
			
	}
	
	$profiles_list_famille = "";
	$sql1 = "SELECT * FROM familles_produits ORDER BY produit;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($type == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_famille .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_famille .= $temp_["produit"];
		$profiles_list_famille .= "</OPTION>";
	}
	
	$list_unites = "";
	$sql5 = "SELECT * FROM unites_mesures ORDER BY unite;";
	$temp = db_query($database_name, $sql5);
	while($temp_ = fetch_array($temp)) {
		if($unite == $temp_["unite"]) { $selected = " selected"; } else { $selected = ""; }
		
		$list_unites .= "<OPTION VALUE=\"" . $temp_["unite"] . "\"" . $selected . ">";
		$list_unites .= $temp_["unite"];
		$list_unites .= "</OPTION>";
	}
	
	// extracts profile list

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function ValidateBesoin() {
			document.getElementById("form_user1").submit();
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression de ce produit ?"; ?>")) {
			document.location = "articles_commandes.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

	function EditUser(user_id) { document.location = "articles_commandes.php?action_=delete_user&user_id=" + user_id; }
	
//--></script>

</head>

<body style="background:#dfe8ff">



<?php if($user_id != "0" and $produit <> "") { ?>

<form id="form_user" name="form_user" method="post" action="articles_commandes.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table2">

		<tr>
		<td><?php echo "Article"; ?></td><td><?php echo $produit; ?></td>
		</tr>
        </td>
		<tr>
		<td><?php echo "Famille : "; ?></td><td><?php echo $type; ?></td>
		</tr>
        <tr>
		<td><?php echo "Unite"; ?></td><td><?php echo $unite;?></td>
		</tr><tr>
		<td><?php echo "Quantité"; ?></td><td><input type="text" id="qte" name="qte" style="width:140px" value="<?php echo $qte; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Besoin pour"; ?></td><td><input type="text" id="besoin" name="besoin" style="width:340px" value="<?php echo $besoin; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Observation"; ?></td><td><input type="text" id="obs" name="obs" style="width:340px" value="<?php echo $obs; ?>"></td>
		</tr>
		
	</table>

	</center>

</td></tr></table>


<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<table class="table3"><tr>


<td><button type="button" onClick="UpdateUser()"><?php echo "Ajouter et Retour Liste"; ?></button></td>
<td style="width:20px"></td>
<?php }  ?>
</tr></table>

</center>

</form>

<p style="text-align:center">
<div>
<table class="table2">
<div id="titre">
<caption><?php echo "Besoin en cours"; ?></caption>
<thead>
	<th><?php echo "Code";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Article";?></th>
	<th><?php echo "Quantité";?></th>
	<th><?php echo " Unite ";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Besoin";?></th>
	<th><?php echo "Frs";?></th>
	<th><?php echo "Statut";?></th>	
</thead>
</div>
<tbody>
<?php 

$sql  = "SELECT * ";$reception="reception";$vide="";
	$sql .= "FROM detail_bon_besoin where statut<>'$reception' and produit<>'$vide' and confirme=0 ORDER BY date_b;";
	$usersb = db_query($database_name, $sql);


while($users_b = fetch_array($usersb)) { ?>

<? $statut=$users_b["statut"];if ($statut=="encours de validation"){?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_b["id"]; ?>)"><?php echo $users_b["id"];$id=$users_b["id"];?></A></td>
<td><?php echo dateUsToFr($users_b["date_b"]); ?></td>
<td><?php echo $users_b["produit"]; ?></td>
<td><?php echo $users_b["quantite"]; ?></td>
<td><?php echo $users_b["unite"]; ?></td>
<td><?php echo $users_b["prix"]; ?></td>
<td><?php echo $users_b["besoin"]; ?></td>
<td><?php echo $users_b["obs"]; ?></td>
<td><?php echo $users_b["statut"]; ?></td>
<td class="st"><div class="rouge"></div></td>
<? }?>

<? if ($statut==""){?><tr>
<td bgcolor="#55FFFF"><?php echo $users_b["id"];$id=$users_b["id"];?></td>
<td style="text-align:left" bgcolor="#55FFFF"><?php echo dateUsToFr($users_b["date_b"]); ?></td>
<td style="text-align:left" bgcolor="#55FFFF"><?php echo $users_b["produit"]; ?></td>
<td style="text-align:left" bgcolor="#55FFFF" align="right"><?php echo $users_b["quantite"]; ?></td>
<td style="text-align:left" bgcolor="#55FFFF" align="right"><?php echo $users_b["unite"]; ?></td>
<td style="text-align:left" bgcolor="#55FFFF" align="right"><?php echo $users_b["prix"]; ?></td>
<td style="text-align:left" bgcolor="#55FFFF" align="right"><?php echo $users_b["besoin"]; ?></td>
<td style="text-align:left" bgcolor="#55FFFF" align="right"><?php echo $users_b["obs"]; ?></td>
<td style="text-align:left" bgcolor="#55FFFF" align="right"><?php echo $users_b["statut"]; ?></td>
<? }?>


<?php } ?>
</tbody>
</table>

</div>





<?php if($produit == "") { $action_="envoyer";

$sql  = "SELECT * ";$vide="";$statut="encours de validation";
	$sql .= "FROM detail_bon_besoin where confirm_code='$vide' and produit<>'$vide' and confirme=0 and statut='$vide' ORDER BY date DESC;";
	$userscc = db_query($database_name, $sql);
$count=0;

while($users_cc = fetch_array($userscc)) { 
$count=$count+1;

}

if ($count==0){echo "aucun article en besoin"; }else{






?>
<div>

	<form id="form_user1" name="form_user1" method="post" action="articles_commandes.php">

	<table width="671" class="table3">

		<tr>
		<td><?php echo "Numero Bon de Besoin"; ?></td><td><input type="text" id="bn" name="bn" style="width:140px" value="<?php echo $bn; ?>"></td>
		<td><?php echo "Nom du Demandeur"; ?></td><td><input type="text" id="dn" name="dn" style="width:140px" value="<?php echo $dn; ?>"></td>
		<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
		<td><button type="button" onClick="ValidateBesoin()"><?php echo "Envoyer Bon de Besoin"; ?></button></td>
	</table>
	</form>
</div>

<? }
}



if ($produit <> ""){?>







<p style="text-align:center">

<table class="table2">
<div id="titre">
<caption><?php echo "Historique Commandes article : $produit"; ?></caption>
<thead>
	
	<th><?php echo "Date";?></th>
	<th><?php echo "Fournisseur";?></th>
	<th><?php echo "Quantite";?></th>
	<th><?php echo " Unite ";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo "Besoin";?></th>
	<th><?php echo "Statut";?></th>	
</thead>
</div>
<tbody>
<?php 


$sql  = "SELECT * ";
	$sql .= "FROM detail_commandes_frs where produit='$produit' ORDER BY date DESC;";
	$usersc = db_query($database_name, $sql);


while($users_c = fetch_array($usersc)) { ?><tr>

<? 
		$id_c=$users_c["commande"];$sql  = "SELECT * ";
		$sql .= "FROM commandes_frs where  id='$id_c' ORDER BY date_e;";
		$users = db_query($database_name, $sql);
		$users_ = fetch_array($users);
		$date_e=dateUsToFr($users_["date_e"]);$client=$users_["client"];

?>


<td style="text-align:left" bgcolor="#66CCCC"><?php echo $date_e; ?></td>
<td style="text-align:left" bgcolor="#66CCCC"><?php echo $client; ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="right"><?php echo $users_c["quantite"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="right"><?php echo $users_c["condit"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="right"><?php echo $users_c["prix_unit"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="right"><?php echo $users_c["besoin"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="right"><?php echo $users_c["obs"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="right"><?php echo $users_c["statut"]; ?></td>

<?php }
}
 ?>
</tbody>
</table>


</body>

</html>