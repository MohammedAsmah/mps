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
	if(isset($_REQUEST["action_"])) { 
		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$date = $_REQUEST["date"];$date_p=$_REQUEST["date_p"];$date_p1=$_REQUEST["date_p1"];
			$service=$_REQUEST["service"];
			$client=$_REQUEST["client"];
			$statut=$_REQUEST["statut"];
			$date_open=$_REQUEST["date_open"];
			$user_open=$user_name;
			$observation=$_REQUEST["observation"];
			$motif_cancel=$_REQUEST["motif_cancel"];
			$fournisseur=$_REQUEST["fournisseur"];
			$lp=$_REQUEST["lp"];
			$id_registre=$_POST['id_registre'];	$date=$_POST['date'];	$client=$_POST['client'];	$service=$_POST['service'];
			$id_registre1=$_POST['id_registre1'];	$date1=$_POST['date1'];	$client1=$_POST['client1'];	$service1=$_POST['service1'];
			$duree1=$_POST['code'];$code1=$_POST['code'];
			$date=dateFrToUs($date);$date_p=dateFrToUs($date_p);$date_p1=dateFrToUs($date_p1);
			$type_voucher=$_POST['type_voucher'];
			if ($type_voucher=="debours"){$frais_monuments=$_POST['frais_monuments'];$frais_guide=$_POST['frais_guide'];
			$frais_divers=$_POST['frais_divers'];$guide=$_POST['guide'];}
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			$type_voucher=$_POST['type_voucher'];
			if ($type_voucher=="sejour"){
				// recherche contrat	
				$achat1="SEJOURS";$achat2="CIRCUITS";$achat3="CIRCUITS SEJOURS";
				$sql  = "SELECT * FROM contrats_sejours WHERE first_name=\"$fournisseur\" AND (last_name=\"$achat1\" or last_name=\"$achat2\" or last_name=\"$achat3\")".";";
				$user = db_query($database_name, $sql); $user_ = fetch_array($user);
				$code_produit="";
				$code_produit=$user_["user_id"];}
		
	if ($type_voucher=="transport"){
	// recherche contrat			
		$sql  = "SELECT * FROM contrats_transports WHERE last_name=\"$fournisseur\" and first_name=\"$service\"".";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$code_produit="";
		$code_produit=$user_["user_id"];}
			
	if ($type_voucher=="restaurant"){
	// recherche contrat			
		$sql  = "SELECT * FROM contrats_restaurants WHERE last_name=\"$fournisseur\"".";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$code_produit="";
		$code_produit=$user_["user_id"];}
		
		
	if ($type_voucher<>"debours"){
				$type_service="SEJOURS ET CIRCUITS";
				$sql  = "INSERT INTO registre_vouchers_rak (date,date_passage,date_passage1,lp,service,client,fournisseur,date_open,user_open,observation,statut,type_voucher,code_produit ) VALUES 
				('$date','$date_p','$date_p1','$lp','$service','$client','$fournisseur','$date_open','$user_open','$observation','$statut','$type_voucher','$code_produit')";
				db_query($database_name, $sql);}
				else
				{$fournisseur=$guide;
				$sql  = "INSERT INTO registre_debours_rak (date,date_passage,date_passage1,lp,service,client,
				fournisseur,frais_monuments,frais_guide,frais_divers,date_open,user_open,observation,statut,type_voucher ) VALUES 
				('$date','$date_p','$date_p1','$lp','$service','$client','$fournisseur',
				'$frais_monuments','$frais_guide','$frais_divers','$date_open','$user_open','$observation','$statut','$type_voucher')";
				db_query($database_name, $sql);}


			break;

			case "update_user":
			
			$type_voucher=$_POST['type_voucher'];
	if ($type_voucher=="sejour"){
	// recherche contrat			
		$achat1="SEJOURS";$achat2="CIRCUITS";$achat3="CIRCUITS SEJOURS";
		$sql  = "SELECT * FROM contrats_sejours WHERE first_name=\"$fournisseur\" AND (last_name=\"$achat1\" or last_name=\"$achat2\" or last_name=\"$achat3\")".";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$code_produit="";
		$code_produit=$user_["user_id"];}
		
	if ($type_voucher=="transport"){
	// recherche contrat			
		$sql  = "SELECT * FROM contrats_transports WHERE last_name=\"$fournisseur\" and first_name=\"$service\"".";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$code_produit="";
		$code_produit=$user_["user_id"];}
			
	if ($type_voucher=="restaurant"){
	// recherche contrat			
		$sql  = "SELECT * FROM contrats_restaurants WHERE last_name=\"$fournisseur\"".";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$code_produit="";
		$code_produit=$user_["user_id"];}
		
	if ($type_voucher<>"debours"){
			$sql = "UPDATE registre_vouchers_rak SET ";
			$sql .= "statut = '" . $_REQUEST["statut"] . "', ";
			$sql .= "observation = '" . $observation . "', ";
			$sql .= "code_produit = '" . $code_produit . "', ";
			$sql .= "date = '" . $date . "', ";
			$sql .= "date_passage = '" . $date_p . "', ";
			$sql .= "date_passage1 = '" . $date_p1 . "', ";
			$sql .= "fournisseur = '" . $fournisseur . "', ";
			$sql .= "service = '" . $service . "', ";
			$sql .= "motif_cancel = '" . $motif_cancel . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);}
			else
			{$fournisseur=$guide;$frais_monuments=$_POST['frais_monuments'];$frais_guide=$_POST['frais_guide'];
			$frais_divers=$_POST['frais_divers'];
			echo $frais_monuments."-".$frais_guide."-".$frais_divers;
			$sql = "UPDATE registre_debours_rak SET ";
			$sql .= "statut = '" . $_REQUEST["statut"] . "', ";
			$sql .= "observation = '" . $observation . "', ";
			$sql .= "date = '" . $date . "', ";
			$sql .= "date_passage = '" . $date_p . "', ";
			$sql .= "date_passage1 = '" . $date_p1 . "', ";
			$sql .= "fournisseur = '" . $fournisseur . "', ";
			$sql .= "frais_monuments = '" . $frais_monuments . "', ";
			$sql .= "frais_guide = '" . $frais_guide . "', ";
			$sql .= "frais_divers = '" . $frais_divers . "', ";
			$sql .= "service = '" . $service . "', ";
			$sql .= "motif_cancel = '" . $motif_cancel . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);}

			
			break;
			
			case "delete_user":
			
	if ($type_voucher<>"debours"){
			$sql = "DELETE FROM registre_vouchers_rak WHERE profile_id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);}
			else
			{			$sql = "DELETE FROM registre_debours_rak WHERE profile_id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);}

			break;

		} //switch
	} //if
	
	else
	{
	$id_registre1=$_GET['id_registre'];	$date1=$_GET['date'];	$client1=$_GET['client'];	$service1=$_GET['service'];
	$duree1=$_GET['duree'];$code1=$_GET['code'];$date_p=$_GET['date'];$date_p1=$_GET['date'];
	}
	$v_s="sejour";$v_t="transport";$v_r="restaurant";$v_d="debours";
	// sejour
	$sql  = "SELECT * ";
	$sql .= "FROM registre_vouchers_rak where lp='$id_registre1' and type_voucher='$v_s' ORDER BY id;";
	$users = db_query($database_name, $sql);
	// transport
	$sql1  = "SELECT * ";
	$sql1 .= "FROM registre_vouchers_rak where lp='$id_registre1' and type_voucher='$v_t' ORDER BY id;";
	$users1 = db_query($database_name, $sql1);
	// restaurant
	$sql2  = "SELECT * ";
	$sql2 .= "FROM registre_vouchers_rak where lp='$id_registre1' and type_voucher='$v_r' ORDER BY id;";
	$users2 = db_query($database_name, $sql2);
	// debours
	$sql3  = "SELECT * ";
	$sql3 .= "FROM registre_debours_rak where lp='$id_registre1' and type_voucher='$v_d' ORDER BY id;";
	$users3 = db_query($database_name, $sql3);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre_voucher.php?user_id=" + user_id; }
	function EditUser1(user_id) { document.location = "registre_sejour_annuler.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo ""; ?></span>
<th><?php echo "LP : "; echo $id_registre1+200000;?></th>
<th><?php echo "==== ";echo dateUsToFr($date1);?></th>
<th><?php echo "==== ";echo $service1;?></th>
<th><?php echo "==== ";echo $client1;?></th>

<p style="text-align:center">
<table class="table2">
Vouchers Sejour :
<tr>
	<th><?php echo "Voucher";?></th>
	<th><?php echo "Fournisseur";?></th>
	<th><?php echo "Du";?></th>
	<th><?php echo "Au";?></th>
	<th><?php echo "Statut";?></th>
	<th><?php echo "Utilisateur";?></th>
	<th><?php echo "Details";?></th>
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<? $v=$users_["id"]+200000;$id_r=$users_["id"];$date=$users_["date"];$date_p=$users_["date_passage"];$date_p1=$users_["date_passage1"];$fournisseur=$users_["fournisseur"];$duree=$users_["duree"];$client=$users_["client"];$service=$users_["service"];$code=$users_["code_produit"];$lp=$users_["lp"];
echo "<td><a href=\"registre_voucher.php?user_id=$id_r&type_voucher=$v_s&date=$date&lp=$lp&date_p=$date_p&date_p1=$date_p1&id_voucher=$id_r&fournisseur=$fournisseur&code='$code'&client=$client&service=$service&duree=$duree\">".$v."</a></td>";?>
<td><?php echo $users_["fournisseur"]; ?></td>
<td><?php echo dateUsToFr($users_["date_passage"]); ?></td>
<td><?php echo dateUsToFr($users_["date_passage1"]); ?></td>
<td><?php echo $users_["statut"]; ?></td>
<td><?php echo $users_["user_open"]; ?></td>
<td><?php echo $users_["code_produit"]; ?></td>
<? $id_r=$users_["id"];$date=$users_["date"];$date_p=$users_["date_passage"];$date_p1=$users_["date_passage1"];$fournisseur=$users_["fournisseur"];$duree=$users_["duree"];$client=$users_["client"];$service=$users_["service"];$code=$users_["code_produit"];$lp=$users_["lp"];
echo "<td><a href=\"bookings_v.php?type_voucher=$v_s&date=$date&lp=$lp&date_p=$date_p&date_p1=$date_p1&id_voucher=$id_r&fournisseur=$fournisseur&code=$code&client=$client&service=$service&duree=$duree\">"."Bookings"."</a></td>";?>
<?php } ?>

</table>

<p style="text-align:center">

<? echo "<td><a href=\"registre_voucher.php?type_voucher=$v_s&id_registre=$id_registre1&date=$date1&client=$client1&service=$service1&duree=$duree1&code=$code1&user_id=0\">"."Ajout Voucher"."</a></td>";?>

<p style="text-align:center">


<table class="table2">
Vouchers Transport
<tr>
	<th><?php echo "Voucher";?></th>
	<th><?php echo "Fournisseur";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Service";?></th>
	<th><?php echo "Statut";?></th>
	<th><?php echo "Utilisateur";?></th>
	<th><?php echo "Details";?></th>
	
</tr>

<?php while($users_ = fetch_array($users1)) { ?><tr>
<? $v=$users_["id"]+200000;$id_r=$users_["id"];$date=$users_["date"];$date_p=$users_["date_passage"];$date_p1=$users_["date_passage1"];$fournisseur=$users_["fournisseur"];$duree=$users_["duree"];$client=$users_["client"];$service=$users_["service"];$code=$users_["code_produit"];$lp=$users_["lp"];
echo "<td><a href=\"registre_voucher.php?user_id=$id_r&type_voucher=$v_t&date=$date&lp=$lp&date_p=$date_p&date_p1=$date_p1&id_voucher=$id_r&fournisseur=$fournisseur&code='$code'&client=$client&service=$service&duree=$duree\">".$v."</a></td>";?>
<td><?php echo $users_["fournisseur"]; ?></td>
<td><?php echo dateUsToFr($users_["date"]); ?></td>
<td><?php echo $users_["service"]; ?></td>
<td><?php echo $users_["statut"]; ?></td>
<td><?php echo $users_["user_open"]; ?></td>
<? $id_r=$users_["id"];$date=$users_["date"];$fournisseur=$users_["fournisseur"];$duree=$users_["duree"];$client=$users_["client"];$service=$users_["service"];$code=$users_["code_produit"];$lp=$users_["lp"];
echo "<td><a href=\"bookings_v.php?type_voucher=$v_t&lp=$lp&id_voucher=$id_r&code=$code&fournisseur=$fournisseur&date=$date&client=$client&service=$service&duree=$duree\">"."Bookings"."</a></td>";?>
<?php } ?>

</table>

<p style="text-align:center">

<? echo "<td><a href=\"registre_voucher.php?type_voucher=$v_t&id_registre=$id_registre1&date=$date1&client=$client1&service=$service1&duree=$duree1&code=$code1&user_id=0\">"."Ajout Voucher"."</a></td>";?>

<p style="text-align:center">


<table class="table2">
Vouchers Restaurant
<tr>
	<th><?php echo "Voucher";?></th>
	<th><?php echo "Fournisseur";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Service";?></th>
	<th><?php echo "Statut";?></th>
	<th><?php echo "Utilisateur";?></th>
	<th><?php echo "Details";?></th>
	
</tr>

<?php while($users_ = fetch_array($users2)) { ?><tr>
<? $v=$users_["id"]+200000;$id_r=$users_["id"];$date=$users_["date"];$date_p=$users_["date_passage"];$date_p1=$users_["date_passage1"];$fournisseur=$users_["fournisseur"];$duree=$users_["duree"];$client=$users_["client"];$service=$users_["service"];$code=$users_["code_produit"];$lp=$users_["lp"];
echo "<td><a href=\"registre_voucher.php?user_id=$id_r&type_voucher=$v_r&date=$date&lp=$lp&date_p=$date_p&date_p1=$date_p1&id_voucher=$id_r&fournisseur=$fournisseur&code='$code'&client=$client&service=$service&duree=$duree\">".$v."</a></td>";?>
<td><?php echo $users_["fournisseur"]; ?></td>
<td><?php $date_passage=$users_["date_passage"];echo dateUsToFr($users_["date_passage"]); ?></td>
<td><?php echo $users_["service"]; ?></td>
<td><?php echo $users_["statut"]; ?></td>
<td><?php echo $users_["user_open"]; ?></td>
<? $id_r=$users_["id"];$date=$users_["date"];$fournisseur=$users_["fournisseur"];$duree=$users_["duree"];$client=$users_["client"];$service=$users_["service"];$code=$users_["code_produit"];$lp=$users_["lp"];
echo "<td><a href=\"bookings_v.php?type_voucher=$v_r&lp=$lp&id_voucher=$id_r&fournisseur=$fournisseur&date=$date_passage&client=$client&service=$service&code=$code&duree=$duree\">"."Bookings"."</a></td>";?>
<?php } ?>

</table>


<p style="text-align:center">

<? echo "<td><a href=\"registre_voucher.php?type_voucher=$v_r&id_registre=$id_registre1&date=$date1&client=$client1&service=$service1&duree=$duree1&code=$code1&user_id=0\">"."Ajout Voucher"."</a></td>";?>

<table class="table2">
Debours
<tr>
	<th><?php echo "Pièce";?></th>
	<th><?php echo "Debours";?></th>
	<th><?php echo "Service";?></th>
	<th><?php echo "Statut";?></th>
	<th><?php echo "Utilisateur";?></th>
	
</tr>

<?php while($users_ = fetch_array($users3)) { ?><tr>
<? $v=$users_["id"]+200000;$id_r=$users_["id"];$date=$users_["date"];$date_p=$users_["date_passage"];$date_p1=$users_["date_passage1"];$fournisseur=$users_["fournisseur"];$duree=$users_["duree"];$client=$users_["client"];$service=$users_["service"];$code=$users_["code_produit"];$lp=$users_["lp"];
echo "<td><a href=\"registre_debour.php?user_id=$id_r&type_voucher=$v_d&date=$date&lp=$lp&date_p=$date_p&date_p1=$date_p1&id_voucher=$id_r&fournisseur=$fournisseur&code='$code'&client=$client&service=$service&duree=$duree\">".$v."</a></td>";?>
<td><?php echo $users_["fournisseur"]; ?></td>
<td><?php echo $users_["service"]; ?></td>
<td><?php echo $users_["statut"]; ?></td>
<td><?php echo $users_["user_open"]; ?></td>
<? echo "<td><a href=\"registre_debour_edit.php?user_id=$id_r&type_voucher=$v_d&date=$date&lp=$lp&date_p=$date_p&date_p1=$date_p1&id_voucher=$id_r&fournisseur=$fournisseur&code='$code'&client=$client&service=$service&duree=$duree\">Imprimer</a></td>";?>
<?php } ?>

</table>


<p style="text-align:center">

<? echo "<td><a href=\"registre_debour.php?type_voucher=$v_d&id_registre=$id_registre1&date=$date1&client=$client1&service=$service1&duree=$duree1&code=$code1&user_id=0\">"."Ajout pièce"."</a></td>";?>


<form id="form_user1" name="form_user1" method="post" action="registres_vouchers_edit.php">
<? $retour="retour";echo "<td><a href=\"registres_vouchers_edit.php?action_r=$retour&date=$date1&client=$client1\">"."Retour"."</a></td>";?>
<input type="hidden" id="action_r" name="action_r" value="<?php echo $retour; ?>">
</form>

</body>

</html>