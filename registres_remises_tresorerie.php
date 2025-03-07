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
			
			$date = dateFrToUs($_REQUEST["date"]);
			list($annee1,$mois1,$jour1) = explode('-', $date); 
			$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
			$mois=date("m",$pdu);$annee=date("Y",$pdu);
			$service="";
			$banque=$_REQUEST["banque"];
			$date_open=$_REQUEST["date_open"];
			$user_open=$user_name;
			$observation="";
			$motif_cancel="";
			if(isset($_REQUEST["remise_vers_tresorerie"])) { $remise_vers_tresorerie = 1; } else { $remise_vers_tresorerie = 0; }
			if(isset($_REQUEST["remise_vers_tresorerie1"])) { $remise_vers_tresorerie1 = 1; } else { $remise_vers_tresorerie1 = 0; }						
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":

			break;

			case "update_user":

			$sql = "UPDATE registre_remises SET ";
			$sql .= "date = '" . $date . "', ";
			$sql .= "observation = '" . $observation . "', ";
			$sql .= "remise_vers_tresorerie = '" . $remise_vers_tresorerie . "', ";
			$sql .= "remise_vers_tresorerie1 = '" . $remise_vers_tresorerie1 . "', ";
			$sql .= "motif_cancel = '" . $motif_cancel . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);$impaye=1;$id_registre=$_REQUEST["user_id"];
			
				
				// vers tresorerie
				
				if ($remise_vers_tresorerie==1){
				$sql  = "SELECT * ";
				$sql .= "FROM porte_feuilles_factures where numero_remise=$id_registre ORDER BY id;";
				$users = db_query($database_name, $sql);
				
				while($users_ = fetch_array($users)) { 
					$id=$users_["id"];$m_cheque=$users_["m_cheque"];$numero_cheque=$users_["numero_cheque"];$id_porte_feuille=$users_["id_porte_feuille"];
					$client=$users_["client"];$client_tire=$users_["client_tire"];$credit=0;$m_effet=$users_["m_effet"];
					$numero_effet=$users_["numero_effet"];$facture_n=$users_["facture_n"];
					$sql  = "SELECT * ";
					$sql .= "FROM clients where client='$client' order BY id;";
					$user = db_query($database_name, $sql); $user_ = fetch_array($user);
					$patente = $user_["patente"];$inputation = $user_["inputation"];
					$caisse=$banque;
					if ($m_cheque<>0) {$n="Cheque N° $numero_cheque";$debit=$m_cheque;$type="REMISE CHEQUES";}
					if ($m_effet<>0) {$n="Effet N° $numero_effet";$debit=$m_effet;$type="REMISE EFFETS";}
					$libelle="$n / $client / $client_tire / Facture $facture_n ";$type_r=1;
					
					$sql  = "INSERT INTO journal_banques ( date,remise,caisse,libelle,type,type_remise,imputation,debit,credit ) VALUES ( ";
				$sql .= "'".$date . "',";
				$sql .= "'".$id_registre . "',";
				$sql .= "'".$caisse . "',";
				$sql .= "'".$libelle . "',";
				$sql .= "'".$type . "',";$sql .= "'".$type_r . "',";
				$sql .= "'".$inputation . "',";
				$sql .= "'".$debit . "',";
				$sql .= "'".$credit . "');";
				db_query($database_name, $sql);
					}
					}
					
					if ($remise_vers_tresorerie1==1){
					//effets
				$sql  = "SELECT * ";
				$sql .= "FROM porte_feuilles_factures where numero_remise_e=$id_registre ORDER BY id;";
				$users1 = db_query($database_name, $sql);	
					
				while($users_1 = fetch_array($users1)) { 
					$id=$users_1["id"];$m_cheque=$users_1["m_cheque"];$numero_cheque=$users_1["numero_cheque"];$id_porte_feuille=$users_1["id_porte_feuille"];
					$client=$users_1["client"];$client_tire=$users_1["client_tire"];$imputation=$users_1["inputation"];$credit=0;$m_effet=$users_1["m_effet"];
					$numero_effet=$users_1["numero_effet"];$facture_n=$users_1["facture_n"];
					$sql  = "SELECT * ";
					$sql .= "FROM clients where client='$client' order BY id;";
					$user = db_query($database_name, $sql); $user_ = fetch_array($user);
					$patente = $user_["patente"];$inputation = $user_["inputation"];
					$caisse=$banque;
					if ($m_cheque<>0) {$n="Cheque N° $numero_cheque";$debit=$m_cheque;$type="REMISE CHEQUES";}
					if ($m_effet<>0) {$n="Effet N° $numero_effet";$debit=$m_effet;$type="REMISE EFFETS";}
					$libelle="$n / $client / $client_tire / Facture $facture_n ";$type_r=2;
					
					$sql  = "INSERT INTO journal_banques ( date,remise,caisse,libelle,type,type_remise,imputation,debit,credit ) VALUES ( ";
				$sql .= "'".$date . "',";
				$sql .= "'".$id_registre . "',";
				$sql .= "'".$caisse . "',";
				$sql .= "'".$libelle . "',";
				$sql .= "'".$type . "',";$sql .= "'".$type_r . "',";
				$sql .= "'".$inputation . "',";
				$sql .= "'".$debit . "',";
				$sql .= "'".$credit . "');";
				db_query($database_name, $sql);
					}	 
					
		
				}
				
				if ($remise_vers_tresorerie==0)
				{
				$sql2 = "DELETE FROM journal_banques WHERE type_remise=1 and remise = " . $id_registre . ";";
				db_query($database_name, $sql2);
							
				}
				
				if ($remise_vers_tresorerie1==0)
				{
				$sql2 = "DELETE FROM journal_banques WHERE type_remise=2 and remise = " . $id_registre . ";";
				db_query($database_name, $sql2);
							
				}
				
			break;
			
			case "delete_user":
			
			break;


		} //switch
	} //if
	
	else {$banque="";$date1="";$date2="";}
	if(isset($_REQUEST["action_"]) and $_REQUEST["action_"] != "delete_user") { $date1 = $_REQUEST["date"];}
	else {$banque="";$date1="";}
	$action="recherche";
	$banque_list = "";
	$sql = "SELECT * FROM  rs_data_banques ORDER BY banque;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($banque == $temp_["banque"]) { $selected = " selected"; } else { $selected = ""; }
		
		$banque_list .= "<OPTION VALUE=\"" . $temp_["banque"] . "\"" . $selected . ">";
		$banque_list .= $temp_["banque"];
		$banque_list .= "</OPTION>";
	}

	
	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="registres_remises_tresorerie.php">
	<td><?php echo "Du : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au : "; ?><input onClick="ds_sh(this);" name="date2" value="<?php echo $date2; ?>" readonly="readonly" style="cursor: text" /></td>
	<TR><td><?php echo "Banque Verssement : "; ?></td><td><select id="banque" name="banque"><?php echo $banque_list; ?></select></td></TR>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<? }


?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre_remise_tresorerie.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	if (isset($_REQUEST["action_l"])){
	$date=$_GET['date1'];$banque=$_GET['banque'];$date2=$_GET['date2'];
	$date_d1=$_GET['date1'];$date_d2=$_GET['date2'];
	$de1=$_GET['date1'];$de2=$_GET['date2'];
	}

	if(isset($_REQUEST["action"]))
	{ $date=dateFrToUs($_POST['date1']);$banque=$_POST['banque'];$date2=dateFrToUs($_POST['date2']);
	$date_d1=dateFrToUs($_POST['date1']);$date_d2=dateFrToUs($_POST['date2']);
	$de1=dateFrToUs($_POST['date1']);$de2=dateFrToUs($_POST['date2']);}
	
	
	if (isset($_REQUEST["action_l"]) or isset($_REQUEST["action"])){
	$sql  = "SELECT * ";
	$sql .= "FROM registre_remises where (date between '$date' and '$date2') and banque='$banque' ORDER BY id;";
	$users11 = db_query($database_name, $sql);



?>


<span style="font-size:24px"><?php echo dateUsToFr($date)."---> ".$banque; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date Remise";?></th>
	<th><?php echo "Numero Remise";?></th>
	<th><?php echo "Cheques";?></th>
	<th><?php echo "Effets";?></th>
	<th><?php echo "Ajout";?></th>
</tr>

<?php 
$compteur1=0;$total_g=0;$t_cheque=0;$t_eff=0;
while($users_1 = fetch_array($users11)) { $id_r=$users_1["id"];$date_enc=$users_1["date"];$banque=$users_1["banque"];
			$statut=$users_1["statut"];$observation=$users_1["observation"];$dest=$users_1["service"];$date_remise=$users_1["date"];
			$service=$users_1["service"];$code=$users_1["code_produit"];$id_tableau=$users_1["id"]."/2008";$bon=$users_1["statut"];?><tr>
			<td><a href="JavaScript:EditUser(<?php echo $users_1["id"]; ?>)"><?php echo dateUsToFr($users_1["date"]); ?></A></td>
			<?php $t=$users_1["bon_sortie"]."/".$users_1["mois"]."".$users_1["annee"]; 
			$sql  = "SELECT * ";$a="";$date_d="2010-08-01";$date_dn="0000-00-00";
			$sql .= "FROM porte_feuilles_factures where numero_remise=$id_r and m_cheque<>0 and remise=1 and numero_cheque<>'$a'   ORDER BY id;";
			$users = db_query($database_name, $sql);
			$total_g=0;
			while($users_ = fetch_array($users)) { 
				$m_cheque=$users_["m_cheque"];
				$total_g=$total_g+$m_cheque;
			 }
			 $t_cheque=$t_cheque+$total_g;
			$total_c=number_format($total_g,2,',',' ');
			
			$sql  = "SELECT * ";
			$sql .= "FROM porte_feuilles_factures where numero_remise_e=$id_r and m_effet<>0 and remise_e=1 ORDER BY id;";
			$users1 = db_query($database_name, $sql);
			$total_e=0;
			while($users1_ = fetch_array($users1)) { 
				$m_effet=$users1_["m_effet"];$numero_remise_e=$users1_["numero_remise"];$id=$users1_["id"];
				$remise_e=$users1_["remise"];$date_remise_e=$users1_["date_remise"];
				$total_e=$total_e+$m_effet;
				
								
				
			 }
			 $t_eff=$t_eff+$total_e;
			$total_ef=number_format($total_e,2,',',' ');
			?>
			<td align="right"
			<? 
			echo "<td><a href=\"\\mps\\tutorial\\tableau_remise.php?dest=$dest&t=$t&id_registre=$id_r&date_enc=$date_enc&banque=$banque&bon_sortie=$observation\">".$t."</a></td>";
			echo "<td align=\"right\">$total_c</td><td align=\"right\">$total_ef</td>";
 } ?>

<tr><td></td><td></td>
<td align="right">
<? 			echo number_format($t_cheque,2,',',' ');?></td>
<td align="right"><? 			echo number_format($t_eff,2,',',' ');?></td>
</table>
</strong>
<p style="text-align:center">
<table class="table2">

</table>

<? }?>
</body>

</html>