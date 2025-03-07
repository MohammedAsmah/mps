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
			$service=$_REQUEST["service"];
			$vendeur=$_REQUEST["vendeur"];
			$date_open=$_REQUEST["date_open"];
			$user_open=$user_name;
			$observation=$_REQUEST["observation"];
			$motif_cancel=$_REQUEST["motif_cancel"];
			
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
	// recherche contrat			
		$code_produit="";
			
				$type_service="SEJOURS ET CIRCUITS";
				$sql  = "INSERT INTO registre_reglements (date,service,vendeur,date_open,user_open,observation)
				 VALUES ('$date','$service','$vendeur','$date_open','$user_open','$observation')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			
			$sql = "UPDATE registre_reglements SET ";
			$sql .= "service = '" . $_REQUEST["service"] . "', ";
			$sql .= "date = '" . $date . "', ";
			$sql .= "observation = '" . $observation . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			$sql .= "motif_cancel = '" . $motif_cancel . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			
			
			// delete user's profile
			$sql = "DELETE FROM registre_reglements WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	else {$vendeur="";$date1="";}
	if(isset($_REQUEST["action_"]) and $_REQUEST["action_"] != "delete_user") { $date1 = $_REQUEST["date"];}
	else {$vendeur="";$date1="";}
	$action="recherche";
	$vendeur_list = "";
	$sql = "SELECT * FROM  vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$vendeur_list .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$vendeur_list .= $temp_["vendeur"];
		$vendeur_list .= "</OPTION>";
	}

	
	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="tableau_encaissements.php">
	<td><?php echo "Date : "; ?><input onclick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<TR><td><?php echo "Vendeur		:"; ?></td><td><select id="vendeur" name="vendeur"><?php echo $vendeur_list; ?></select></td></TR>
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
	function EditUser(user_id) { document.location = "registre_reglement.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	if(isset($_REQUEST["action"]))
	{ $date=dateFrToUs($_POST['date1']);$vendeur=$_POST['vendeur'];$total_e=0;$total_c=0;$total_t=0;
	
	$sql  = "SELECT * ";
	$sql .= "FROM porte_feuilles where date_enc='$date' and vendeur='$vendeur' ORDER BY id;";
	$users11 = db_query($database_name, $sql);
?>


<span style="font-size:24px"><?php echo "Tableau Encaissement : ".dateUsToFr($date)."--->Vendeur : ".$vendeur; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Evaluation";?></th>
	<th><?php echo "Reference";?></th>
	<th><?php echo "ESPECE";?></th>
	<th><?php echo "CHEQUE";?></th>
	<th><?php echo "EFFET";?></th>
	
</tr>

<?php $compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { $id_r=$users_1["id"];$date_enc=$users_1["date_enc"];$vendeur=$users_1["vendeur"];
			$client=$users_1["client"];$evaluation=$users_1["evaluation"];
			$mode=$users_1["mode"];$valeur=$users_1["valeur"];$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];
			$ref=$v_banque." ".$numero_cheque;?>
			<tr><td><?php echo dateUsToFr($users_1["date_enc"]); ?></td>
			<td><?php echo $client; ?></td>
			<td><?php echo $evaluation; ?></td>
			<td><?php echo $ref; ?></td>

			<? if ($mode=="ESPECE"){?> <td align="right"><?php $total_e=$total_e+$valeur;echo number_format($valeur,2,',',' '); ?></td><TD></TD><TD></TD><? }?>
			<? if ($mode=="CHEQUE"){?> <td></td><td align="right"><?php $total_c=$total_c+$valeur;echo number_format($valeur,2,',',' '); ?></td><td></td><? }?>
			<? if ($mode=="EFFET"){?> <td></td><TD></TD><td align="right"><?php $total_t=$total_t+$valeur;echo number_format($valeur,2,',',' '); ?></td><? }?>

<? } ?>
<tr><td></td><td></td><td></td><td></td>
			<td align="right"><?php echo number_format($total_e,2,',',' '); ?></td>
			<td align="right"><?php echo number_format($total_c,2,',',' '); ?></td>
			<td align="right"><?php echo number_format($total_t,2,',',' '); ?></td>

</table>
</strong>
<p style="text-align:center">

<?
	$sql  = "SELECT * ";
	$sql .= "FROM registre_reglements where date='$date' and vendeur='$vendeur' ORDER BY id;";
	$users11 = db_query($database_name, $sql);$user_ = fetch_array($users11);
		$libelle1=$user_["libelle1"];$montant1=$user_["montant1"];
		$libelle2=$user_["libelle2"];$montant2=$user_["montant2"];
		$libelle3=$user_["libelle3"];$montant3=$user_["montant3"];
		$libelle4=$user_["libelle4"];$montant4=$user_["montant4"];
		$libelle5=$user_["libelle5"];$montant5=$user_["montant5"];
?>
<table class="table2">

<tr>
	<th><?php echo "Libelle";?></th>
	<th><?php echo "Montant";?></th>
</tr>
		<tr>
		<td><?php echo $libelle1; ?></td>
		<td align="right"><?php echo number_format($montant1,2,',',' '); ?></td>
		</tr>
		<tr>
		<td><?php echo $libelle2; ?></td>
		<td align="right"><?php echo number_format($montant2,2,',',' '); ?></td>
		</tr>
		<tr>
		<td><?php echo $libelle3; ?></td>
		<td align="right"><?php echo number_format($montant3,2,',',' '); ?></td>
		</tr>
		<tr>
		<td><?php echo $libelle4; ?></td>
		<td align="right"><?php echo number_format($montant4,2,',',' '); ?></td>
		</tr>
		<tr>
		<td><?php echo $libelle5; ?></td>
		<td align="right"><?php echo number_format($montant5,2,',',' '); ?></td>
		</tr>
		<td></td>
		<td align="right"><?php echo number_format(($montant1+$montant2+$montant3+$montant4+$montant5),2,',',' '); ?></td>



<? }?>
</body>

</html>