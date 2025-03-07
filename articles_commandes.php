<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">

<title><?php echo "" . "liste articles commandes"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "article_commande.php?user_id=" + user_id; }
	function EditUser1(user_id) { document.location = "article_commande_besoin.php?user_id=" + user_id; }
--></script>

</head>

<?php
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();	$user_name=GetUserName();$date_time=date("y-m-d h:m:s");

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"])) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$produit = $_REQUEST["produit"];$condit = $_REQUEST["condit"];$prix = $_REQUEST["prix"];$type = $_REQUEST["type"];
			$unite = $_REQUEST["unite"];$type_c="MP";
			if(isset($_REQUEST["dispo"])) { $dispo = 1; } else { $dispo = 0; }
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO articles_commandes ( produit, unite, prix,type,type_c, dispo ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $unite . "', ";
				$sql .= "'" . $prix . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= "'" . $type_c . "', ";
				$sql .= $dispo . ");";

				db_query($database_name, $sql);
			

			break;

			case "update_user":

			$sql = "UPDATE articles_commandes SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "', ";
			$sql .= "unite = '" . $unite . "', ";
			$sql .= "dispo = '" . $dispo . "', ";
			$sql .= "prix = '" . $prix . "', ";
			$sql .= "type_c = '" . $type_c . "', ";
			$sql .= "type = '" . $type . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM articles_commandes WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;

			case "besoin":
			$id=$_REQUEST["user_id"];$qte=$_REQUEST["qte"];$obs=$_REQUEST["obs"];$besoin=$_REQUEST["besoin"];$date_c=date("Y-m-d");
			$sql  = "SELECT * ";
			$sql .= "FROM articles_commandes WHERE id = " . $id . ";";
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
							
				$sql  = "INSERT INTO detail_bon_besoin ( date_b,produit, quantite,prix_unit,besoin,obs,unite,condit )
				VALUES ( ";
				$sql .= "'" . $date_c . "', ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $qte . "', ";
				$sql .= "'" . $prix . "', ";
				$sql .= "'" . $besoin . "', ";
				$sql .= "'" . $obs . "', ";
				$sql .= "'" . $unite . "', ";
				$sql .= "'" . $condit . "');";
				db_query($database_name, $sql);
				//promotions
				
			break;
			
			case "envoyer":
			$sql  = "SELECT * ";$reception="reception";$encours="encours de validation";$vide="";
			$sql .= "FROM detail_bon_besoin where confirme=0 and confirm_code='$vide' ORDER BY date_b;";
			$usersb = db_query($database_name, $sql);
			$htmlContent="<table class=\"table2\">
				<tr>

				<th>Quantite</th>
				<th>Designation</th>
				<th>Besoin</th>
				<th>Obs</th>
				</tr>";
			$espace="  ------>  ";
			while($users_b = fetch_array($usersb)) { 
				$p=$users_b["produit"];
				$q=$users_b["quantite"];
				$u=$users_b["unite"];
				$b=$users_b["besoin"];
				$o=$users_b["obs"];
				$htmlContent.="<tr><td>".$q." ".$u."</td><td>".$p."</td><td>".$espace." ".$b."</td><td>".$o."</td></tr>";
			} 
			$htmlContent.="</table>";
			$htmlContent1=$htmlContent;
			$htmlContent1.="Bon de Besoin en attente de confirmation \r\n";
			

			echo "Bon de Besoin envoyé 2";$vide="";$date_bb=date("Y-m-d");$statut="encours de validation";
			$demandeur=$_REQUEST["dn"];
			$sql  = "INSERT INTO besoins_frs ( user,date_time,date_e,date,observation) VALUES ( ";
				$sql .= "'" . $user_name . "', ";
				$sql .= "'" . $date_time . "', ";
				$sql .= "'" . $date_bb . "', ";
				$sql .= "'" . $date_bb . "', ";
				$sql .= "'" . $demandeur . "');";
				db_query($database_name, $sql);	
				$numero_id=mysql_insert_id();
				
				
				echo "<table>";
				
				$confirm_code=md5(uniqid(rand()));
				$sql = "UPDATE detail_bon_besoin SET ";
			$sql .= "numero_bb = '" . $_REQUEST["bn"] . "', ";
			$sql .= "commande = '" . $numero_id . "', ";
			$sql .= "date_bb = '" . $date_bb . "', ";
			$sql .= "statut = '" . $statut . "', ";
			$sql .= "confirm_code = '" . $confirm_code . "', ";
			$sql .= "demandeur_bb = '" . $_REQUEST["dn"] . "' ";
			$sql .= "WHERE statut = '" . $vide . "';";
			db_query($database_name, $sql);
			
			
			
			$htmlContent.="Click on this link to activate \r\n";
			$htmlContent.="http://www.data2mjp.com/mps/confirmation.php?passkey=$confirm_code";
			

			$time_edition=date("Y-m-d H:i:s");
			$ipcon = $ip." at ".$time_edition;

			$subject = "Bon de besoin MPS ".$time_edition." ".$_REQUEST["dn"];

			$to_us  = "rakia.nezha@gmail.com,moulage.plastique.sud@gmail.com";
			$to_driss = "driss.b01@gmail.com, abdelaali.jabbour@gmail.com";
			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From: <postmaster@data2mjp.com>' . "\r\n";
			$headers .= 'Cc: postmaster@data2mjp.com' . "\r\n";


			//$htmlContent = file_get_contents("send.php");
			echo "Bon de besoin envoyé ";

$to = "abdelaali.jabbour@gmail.com";
$subject1 = "Bon de Besoin MPS";

$time_edition=date("Y-m-d H:i:s");
$ipcon = $ip." at ".$time_edition;

$message="<html><head></head><body>".$htmlContent."</body></html>";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

//mail($to, $subject1, $message, $headers);

			
			// exemple sur environnement Windows

			mail($to_driss,$subject,$htmlContent,$headers);
			mail($to_us,$subject,$htmlContent1,$headers);
	
		} //switch
	} //if

	// recherche ville

	$sql  = "SELECT * ";
	$sql .= "FROM articles_commandes ORDER BY produit;";
	$users = db_query($database_name, $sql);
	
?>	


<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>



<table class="table2">
<div id="titre">
<caption><?php echo "liste articles commandes"; ?></caption>
<thead>
	<th><?php echo "Code";?></th>
	<th><?php echo "Article";?></th>
	<th><?php echo "Prix Unit";?></th>
	<th><?php echo " Unite ";?></th>
	<th><?php echo "Dispo";?></th>
	<th><?php echo "Panier";?></th>
</thead>
</div>
<tbody>


<?php while($users_ = fetch_array($users)) { 
/*$p=$users_["produit"];
$t=$users_["type"];
if ($t=="COLORANTS"){
$type="COLORANTS";$unite="KG";
	$sql  = "INSERT INTO matieres_premieres ( produit,type,unite ) VALUES ( ";
				$sql .= "'".$p . "',";
				$sql .= "'".$type . "',";
				$sql .= "'".$unite . "');";
				db_query($database_name, $sql);
}
*/



?><tr>



<td bgcolor="#66CCCC"><? if ($users_["id"]=="1796"){echo $users_["id"];$id=$users_["id"];}else{?><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["id"];$id=$users_["id"];?></A><? }?></td>
<td style="text-align:left" bgcolor="#66CCCC"><?php echo $users_["produit"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC"><?php echo $users_["type"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="right"><?php echo $users_["prix"]; ?></td>
<td style="text-align:left" bgcolor="#66CCCC" align="right"><?php echo $users_["unite"]; ?></td>
<td bgcolor="#66CCCC"><a href="JavaScript:EditUser1(<?php echo $users_["id"]; ?>)"><?php echo $users_["id"];$id=$users_["id"];?></A></td>
<?php } ?>
</tbody>
</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>
	
</body>

</html>