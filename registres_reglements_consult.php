<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$id=$_GET["id"];

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre_reglement.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 
	$sql  = "SELECT * ";
	$sql .= "FROM registre_reglements where id=$id ORDER BY id;";
	$users11 = db_query($database_name, $sql);



?>


<span style="font-size:24px"><?php  ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Bon Sortie";?></th>
	<th><?php echo "Tableau Enc";?></th>
</tr>

<?php $compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { $id_r=$users_1["id"];$date_enc=$users_1["date"];$vendeur=$users_1["vendeur"];
			$statut=$users_1["statut"];$observation=$users_1["observation"];$dest=$users_1["service"];
			$service=$users_1["service"];$code=$users_1["code_produit"];$id_tableau=$users_1["id"]."/2008";$bon=$users_1["statut"];?><tr>
			<td><?php echo dateUsToFr($users_1["date"]); ?></td>
			<td><?php echo $users_1["observation"]; ?></td>
			<?php $t=$users_1["bon_sortie"]."/".$users_1["mois"]."".$users_1["annee"]; ?>
			<? $sql = "UPDATE porte_feuilles SET ";
			$sql .= "date_enc = '" . $date_enc . "' ";
			$sql .= "WHERE id_registre_regl = " . $id_r . ";";
			db_query($database_name, $sql);?>
			<? echo "<td><a href=\"\\mps\\tutorial\\tableau_encaissement.php?dest=$dest&t=$t&id_registre=$id_r&date_enc=$date_enc&vendeur=$vendeur&bon_sortie=$observation\">".$t."</a></td>";?>
			<?  /*echo "<td><a href=\"tableau_enc.php?dest=$dest&t=$t&id_registre=$id_r&date_enc=$date_enc&vendeur=$vendeur&bon_sortie=$observation\">".$t."</a></td>";*/?>
	<? $sql  = "SELECT * ";
	$sql .= "FROM commandes where id_registre_regl=$id_r ORDER BY date_e;";
	$users = db_query($database_name, $sql);
	$total_g=0;
	while($users_ = fetch_array($users)) { 
		$commande=$users_["commande"];$evaluation=$users_["evaluation"];$client=$users_["client"];$date11=dateUsToFr($users_["date_e"]);
		$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];
		$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];
		$id=$users_["id"];
		$net=$users_["net"];; 
		$total_g=$total_g+$net;
	 }
	$sql  = "SELECT * ";
	$sql .= "FROM factures where id_registre_regl=$id_r ORDER BY date_f;";
	$users = db_query($database_name, $sql);
	$total_gf=0;
	while($users_ = fetch_array($users)) { 
		$net=$users_["montant"];
		$total_gf=$total_gf+$net;
	 }
	 //reports
	 $ev="";$fa="";
 	$sql12  = "SELECT numero_cheque,client,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql12 .= "FROM porte_feuilles where id_registre_regl='$id_r' and facture_n='$fa' Group BY id_registre_regl;";
	$users1111 = db_query($database_name, $sql12);
	$users_111 = fetch_array($users1111);
	$client=$users_111["client"];$total_e=$users_111["total_e"];$total_avoir=$users_111["total_avoir"];
	$total_cheque=$users_111["total_cheque"];$total_espece=$users_111["total_espece"];$total_effet=$users_111["total_effet"];
	$total_diff_prix=$users_111["total_diff_prix"];$total_virement=$users_111["total_virement"];
	$total_eval=$total_espece+$total_cheque+$total_effet+$total_virement-($total_avoir+$total_diff_prix);
	$total_eval=number_format($total_eval,2,',',' ');
	 
	 $ev="";$fa="";
 	$sql12  = "SELECT numero_cheque,client,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql12 .= "FROM porte_feuilles where id_registre_regl='$id_r' and facture_n<>'$fa' Group BY id_registre_regl;";
	$users1111 = db_query($database_name, $sql12);
	$users_111 = fetch_array($users1111);
	$client=$users_111["client"];$total_e=$users_111["total_e"];$total_avoir=$users_111["total_avoir"];
	$total_cheque=$users_111["total_cheque"];$total_espece=$users_111["total_espece"];$total_effet=$users_111["total_effet"];
	$total_diff_prix=$users_111["total_diff_prix"];$total_virement=$users_111["total_virement"];
	$total_fa=$total_espece+$total_cheque+$total_effet+$total_virement-($total_avoir+$total_diff_prix);
	$total_fa=number_format($total_fa,2,',',' ');
			 ?><? 
			$total_gf=number_format($total_gf,2,',',' ');
 } ?>

</table>
</strong>
<p style="text-align:center">
<table class="table2">
</table>
</body>

</html>