<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$client = $_REQUEST["client"];

	


	// extracts profile list
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
		if(document.getElementById("last_name").value == "" ) {
			alert("<?php echo Translate("The values for the fields are required !"); ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression de ce client ?"; ?>")) {
			document.location = "clients.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

	function Editcontrat(user_id) { document.location = "contrats_sejours.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo "Relevé Compte Client : $client Edité le ".date("d/m/Y"); ?></span>

<table class="table2"><tr><td style="text-align:center">

	<center>

	
<p style="text-align:center">

<center>


</center>


<?
	$sql  = "SELECT * ";
	$sql .= "FROM commandes where client='$client' and escompte_exercice=0 ORDER BY id;";
	$users = db_query($database_name, $sql);
?>
<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Designation";?></th>
	<th><?php echo "Debit";?></th>
	<th><?php echo "Credit";?></th>
	<th><?php echo "Solde";?></th>
</tr>

<?php $ca=0;
			$sql = "TRUNCATE TABLE `releve_compte_client`  ;";
			db_query($database_name, $sql);

while($users_ = fetch_array($users)) { ?>
<? $id=$users_["id"];$f=$users_["evaluation"];$d=$users_["date_e"];$net=$users_["net"];?>
<?php $evaluation=$users_["evaluation"]; $client=$users_["client"];$user_id=$users_["id"];$vendeur=$users_["vendeur"];
				$sql  = "INSERT INTO releve_compte_client ( client, vendeur, ref,date, debit ) VALUES ( ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $evaluation . "', ";
				$sql .= "'" . $d . "', ";
				$sql .= $net . ");";
				db_query($database_name, $sql);
				
				
 } 
	$sql  = "SELECT *";$v="hors compte";
	$sql .= "FROM porte_feuilles where client='$client' and vendeur<>'$v' Order BY id;";
	$users11 = db_query($database_name, $sql);
while($users_1 = fetch_array($users11)) { 
			$id_r=$users_1["id"];$date_enc=$users_1["date_enc"];$vendeur=$users_1["vendeur"];$facture_n=$users_1["facture_n"];
			$evaluation=$users_1["evaluation"];$montant_e=$users_1["montant_e"];
			$mode=$users_1["mode"];$m_cheque=$users_1["m_cheque"];$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];
			$ref=$v_banque." ".$numero_cheque;$m_espece=$users_1["m_espece"];$m_effet=$users_1["m_effet"];$m_avoir=$users_1["m_avoir"];
			$m_diff_prix=$users_1["m_diff_prix"];$m_virement=$users_1["m_virement"];$numero_avoir=$users_1["numero_avoir"];$numero_effet=$users_1["numero_effet"];
			if ($facture_n==0){$facture_n="";}else{$evaluation="";}
			$r_impaye=$users_1["r_impaye"];$date_impaye=$users_1["date_impaye"];

			$ref="Regl/ ".$numero_cheque."-".$v_banque." Ref:$evaluation - ".$facture_n;
			$montant1=$m_espece-$m_avoir-$m_diff_prix;$ref1="espece $facture_n - $evaluation";
			$montant2=$m_avoir;$ref2="avoir $numero_avoir $facture_n - $evaluation";
			$montant3=$m_diff_prix;$ref3="diff /prix $facture_n - $evaluation";
			$montant4=$m_cheque;$ref4="cheque $numero_cheque - $v_banque - $facture_n - $evaluation";$ref4_imp="cheque $numero_cheque - $v_banque Retour Impayé";
			$montant5=$m_effet;$ref5="effet $numero_effet - $facture_n - $evaluation";$ref5_imp="effet $numero_effet Retour Impayé";
			$montant6=$m_virement;$ref6="virement $facture_n - $evaluation";
				if ($montant1>0){
				$sql  = "INSERT INTO releve_compte_client ( client, vendeur, ref,date, credit ) VALUES ( ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $ref1 . "', ";
				$sql .= "'" . $date_enc . "', ";
				$sql .= $montant1 . ");";
				db_query($database_name, $sql);}
				if ($montant2>0){
				$sql  = "INSERT INTO releve_compte_client ( client, vendeur, ref,date, credit ) VALUES ( ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $ref2 . "', ";
				$sql .= "'" . $date_enc . "', ";
				$sql .= $montant2 . ");";
				db_query($database_name, $sql);}
				if ($montant3>0){
				$sql  = "INSERT INTO releve_compte_client ( client, vendeur, ref,date, credit ) VALUES ( ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $ref3 . "', ";
				$sql .= "'" . $date_enc . "', ";
				$sql .= $montant3 . ");";
				db_query($database_name, $sql);}
				if ($montant4>0){
				$sql  = "INSERT INTO releve_compte_client ( client, vendeur, ref,date, credit ) VALUES ( ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $ref4 . "', ";
				$sql .= "'" . $date_enc . "', ";
				$sql .= $montant4 . ");";
				db_query($database_name, $sql);}
				$statut="impaye";
				//retour impaye cheque :
				if ($r_impaye==1 and $m_cheque<>0){
				$sql  = "INSERT INTO releve_compte_client ( client, vendeur, ref,date, statut,debit ) VALUES ( ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $ref4_imp . "', ";
				$sql .= "'" . $date_impaye . "', ";
				$sql .= "'" . $statut . "', ";
				$sql .= $montant4 . ");";
				db_query($database_name, $sql);}
				//
				
				if ($montant5>0){
				$sql  = "INSERT INTO releve_compte_client ( client, vendeur, ref,date, credit ) VALUES ( ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $ref5 . "', ";
				$sql .= "'" . $date_enc . "', ";
				$sql .= $montant5 . ");";
				db_query($database_name, $sql);}
				
				//retour impaye effet :
				if ($r_impaye==1 and $m_effet<>0){
				$sql  = "INSERT INTO releve_compte_client ( client, vendeur, ref,date, statut,debit ) VALUES ( ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $ref5_imp . "', ";
				$sql .= "'" . $date_impaye . "', ";
				$sql .= "'" . $statut . "', ";
				$sql .= $montant5 . ");";
				db_query($database_name, $sql);}
				//
				
				if ($montant6>0){
				$sql  = "INSERT INTO releve_compte_client ( client, vendeur, ref,date, credit ) VALUES ( ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $vendeur . "', ";
				$sql .= "'" . $ref6 . "', ";
				$sql .= "'" . $date_enc . "', ";
				$sql .= $montant6 . ");";
				db_query($database_name, $sql);}
				
 } 

//enc impayés

	$sql  = "SELECT *";$v="hors compte";
	$sql .= "FROM porte_feuilles_impayes where client='$client' Order BY id;";
	$users1111 = db_query($database_name, $sql);
while($users_111 = fetch_array($users1111)) { 
			$date_enc=$users_111["date_enc"];$avoir_sur_compte=$users_111["avoir_sur_compte"];
			$client=$users_111["client"];$numero_cheque_imp=$users_111["numero_cheque_imp"];
			$m_cheque=$users_111["m_cheque"]+$users_111["m_espece"]+$users_111["m_virement"]+$users_111["m_avoir"];
			
			$ref="";$ref1=" / Encaiss. impaye numero ".$numero_cheque_imp;
			if ($users_111["m_espece"]>0){$ref="espece";}
			if ($users_111["m_virement"]>0){$ref="virement";}
			if ($users_111["m_cheque"]>0){$ref="cheque";}
			if ($users_111["m_avoir"]>0){$ref=$users_111["numero_avoir"];}
			$ref=$ref.$ref1;
				if ($avoir_sur_compte<>1){
				$sql  = "INSERT INTO releve_compte_client ( client,  ref,date, credit ) VALUES ( ";
				$sql .= "'" . $client . "', ";
				$sql .= "'" . $ref . "', ";
				$sql .= "'" . $date_enc . "', ";
				$sql .= $m_cheque . ");";
				db_query($database_name, $sql);}
				
				
				
 } 

 
	$sql  = "SELECT *";
	$sql .= "FROM releve_compte_client where client='$client' Order BY date;";
	$users11 = db_query($database_name, $sql);$solde=0;
while($users_ = fetch_array($users11)) { ?><tr>
<? $client=$users_["client"];$ref=$users_["ref"]; $debit=$users_["debit"];$credit=$users_["credit"];$vendeur=$users_["vendeur"];$date=$users_["date"];
$solde=$solde+$debit-$credit;$statut=$users_["statut"];

if ($statut=="impaye"){?>

<td bgcolor="#FF0000"><? echo dateUsToFr($date);?></td>
<td bgcolor="#FF0000"><? echo $ref;?></td>
<? if ($debit>0){echo "<td bgcolor=\"#FF0000\" align=\"right\">".number_format($debit,2,',',' ')."</td><td></td>";}
else {echo "<td></td><td bgcolor=\"#FF0000\" align=\"right\">".number_format($credit,2,',',' ')."</td>";}
echo "<td bgcolor=\"#FF0000\" align=\"right\">".number_format($solde,2,',',' ');
 
}else
{?>

<td><? echo dateUsToFr($date);?></td>
<td><? echo $ref;?></td>
<? if ($debit>0){echo "<td align=\"right\">".number_format($debit,2,',',' ')."</td><td></td>";}else {echo "<td></td><td align=\"right\">".number_format($credit,2,',',' ')."</td>";}
echo "<td align=\"right\">".number_format($solde,2,',',' ');
 
}
 
 } 
$sql = "TRUNCATE TABLE `releve_compte_client`  ;";
			db_query($database_name, $sql);

?>
</table>

</body>

</html>