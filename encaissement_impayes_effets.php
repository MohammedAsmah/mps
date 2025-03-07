<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";$action_s=$_GET['action_s'];
	$idp=$_GET['id'];$du=dateUsToFr($_GET['du']);$au=dateUsToFr($_GET['au']);$action_r="reglement_chq";$facture_n=$_GET['facture_n'];$facture_imp=$_GET['facture_n'];
	$ref_impaye=$_GET['ref_impaye'];$client=$_GET['client'];
	$sql  = "SELECT * ";$du1=$_GET['du'];$au1=$_GET['au'];
	$sql .= "FROM porte_feuilles_factures where id_porte_feuille='$idp' and facture_n=$facture_imp and numero_effet='$ref_impaye' ORDER BY id;";
	$users11 = db_query($database_name, $sql);$row = fetch_array($users11);
			$date_remise=$row["date_remise"];
			$client_imp=$client;//$facture_imp=$row["facture_n"];
			$client_tire_imp=$row["client_tire"];
			$numero_cheque_imp=$row["numero_effet"];$v_banque_imp=$row["v_banque"];
			$m_cheque=$row["m_effet"];
			$date_impaye=$row["date_impaye_e"];//$facture_n=$row["facture_n"];
	if ($action_s=="sup")
	{$id_s=$_GET['id_s'];$numero=$_GET['numero'];
		$sql = "DELETE FROM porte_feuilles_impayes WHERE facture_n='$facture_n' and id = " . $id_s . ";";
		db_query($database_name, $sql);
		$sql = "DELETE FROM porte_feuilles_factures WHERE facture_n='$facture_n' and vendeur = " . $numero . ";";
		db_query($database_name, $sql);
		
		}
	
	$mode_list = "";$mo="mode_reg";$date_enc="";$facture="";$montant_f="";
	
		$obs="";$n_banque="BCP";$n_banque_e="BCP";$n_banque1="BCP";$n_banque2="BCP";
		$n_banque3="BCP";$n_banque4="BCP";$n_banque5="BCP";$n_banque6="BCP";$n_banque7="BCP";$n_banque8="BCP";
	
		$m_cheque0="";$cheque="";$numero_cheque="";$date_cheque="";$client_tire="";$date_remise_cheque="";$v_banque="";
		$m_cheque1="";$cheque1="";$numero_cheque1="";$date_cheque1="";$client_tire1="";$date_remise_cheque1="";$v_banque1="";
		$m_cheque2="";$cheque2="";$numero_cheque2="";$date_cheque2="";$client_tire2="";$date_remise_cheque2="";$v_banque2="";
		$m_cheque3="";$cheque3="";$numero_cheque3="";$date_cheque3="";$client_tire3="";$date_remise_cheque3="";$v_banque3="";
		$m_cheque4="";$cheque4="";$numero_cheque4="";$date_cheque4="";$client_tire4="";$date_remise_cheque4="";$v_banque4="";
		$m_cheque5="";$cheque5="";$numero_cheque5="";$date_cheque5="";$client_tire5="";$date_remise_cheque5="";$v_banque5="";
		$m_cheque6="";$cheque6="";$numero_cheque6="";$date_cheque6="";$client_tire6="";$date_remise_cheque6="";$v_banque6="";
		$m_cheque7="";$cheque7="";$numero_cheque7="";$date_cheque7="";$client_tire7="";$date_remise_cheque7="";$v_banque7="";
		$m_cheque8="";$cheque8="";$numero_cheque8="";$date_cheque8="";$client_tire8="";$date_remise_cheque8="";$v_banque8="";
	
		
		$v_banque_e="";$client_tire_e="";$client_tire1="";$v_banque1="";
		$m_virement="";$numero_virement="";$date_virement="";$v_banque_v="";
		
		$m_cheque_g0="";$m_cheque_g1="";$m_cheque_g2="";$m_cheque_g3="";$m_cheque_g4="";$m_cheque_g5="";$m_cheque_g6="";
//1er regl	
		$m_cheque_g7="";	$m_cheque_g8="";$avoir_sur_compte="";
		$m_espece="";$espece="";
		
//1er regl		
		$m_effet="";$effet="";$numero_effet="";$date_effet="";$date_echeance="";
		$date_remise_effet="";
//1er regl		
		$m_avoir="";$avoir="";$numero_avoir="";$date_avoir="";
		$m_diff_prix="";$diff_prix="";

	$profiles_list_p = "Selectionnez Produit";
	$sql_produit = "SELECT * FROM rs_data_banques ORDER BY banque;";
	$temp_produit = db_query($database_name, $sql_produit);
	while($temp_produit_ = fetch_array($temp_produit)) {
		if($n_banque == $temp_produit_["banque"]) { $selected = " selected"; } else { $selected = ""; }
		$profiles_list_p .= "<OPTION VALUE=\"" . $temp_produit_["banque"] . "\"" . $selected . ">";
		$profiles_list_p .= $temp_produit_["banque"];
		$profiles_list_p .= "</OPTION>";
	}
	$profiles_list_p1 = "Selectionnez Produit";
	$sql_produit = "SELECT * FROM rs_data_banques ORDER BY banque;";
	$temp_produit = db_query($database_name, $sql_produit);
	while($temp_produit_ = fetch_array($temp_produit)) {
		if($v_banque == $temp_produit_["banque"]) { $selected = " selected"; } else { $selected = ""; }
		$profiles_list_p1 .= "<OPTION VALUE=\"" . $temp_produit_["banque"] . "\"" . $selected . ">";
		$profiles_list_p1 .= $temp_produit_["banque"];
		$profiles_list_p1 .= "</OPTION>";
	}
	$sql  = "SELECT * ";
	$sql .= "FROM clients where client='$client_imp' ORDER BY client;";
	$users111 = db_query($database_name, $sql);$row1 = fetch_array($users111);
			$vendeur=$row1["vendeur_nom"];echo $vendeur;
		
		$profiles_list_p2 = "Selectionnez Produit";$tableau="Tableau";
	$sql_produit = "SELECT * FROM registre_reglements ORDER BY date desc;";
	$temp_produit = db_query($database_name, $sql_produit);
	while($temp_produit_ = fetch_array($temp_produit)) {
		$t=$temp_produit_["bon_sortie"]."/".$temp_produit_["mois"]."".$temp_produit_["annee"];
		if($tableau == $temp_produit_["date"]) { $selected = " selected"; } else { $selected = ""; }
		$profiles_list_p2 .= "<OPTION VALUE=\"" . $temp_produit_["id"] . "\"" . $selected . ">";
		$profiles_list_p2 .= $t;
		$profiles_list_p2 .= "</OPTION>";
	}


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
<? require "head_cal.php";?>
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
<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<form id="form_user" name="form_user" method="post" action="registres_remises_impayes_enc.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
		<tr>
		<td><?php echo "Client "; ?></td><td><?php echo $client_imp." / ".$client_tire_imp." / "."Facture : ".$facture_imp; ?></td>
		</tr>
		<tr>
		<td><?php echo "Numero Effet "; ?></td><td><?php echo $ref_impaye." ".$v_banque_imp; ?></td>
		</tr>
		<tr>
		<td><?php echo "Montant Effet "; ?></td><td><?php echo $m_cheque; ?></td>
		</tr>
		<tr>
		<td><?php echo "Date impaye "; ?></td><td><?php echo dateUsToFr($date_impaye); ?></td>
		</tr>
	<TR><td><?php echo "Tableau encaissement :"; ?></td><td><select id="tableau" name="tableau"><?php echo $profiles_list_p2; ?></select></td></TR>
<table class="table2">

<tr><th></th>
	<th><?php echo "Date enc";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Reference";?></th>
	<th><?php echo "M.Effet";?></th>
	<th><?php echo "M.Traité";?></th>
	<th><?php echo "Tableau";?></th>
</tr>
<? 	$sql  = "SELECT * ";$mt=0;
	$sql .= "FROM porte_feuilles_impayes where id_porte_feuille='$idp' and facture_n='$facture_n' and numero_cheque_imp='$ref_impaye' ORDER BY id;";
	$users11 = db_query($database_name, $sql);
while($users_1 = fetch_array($users11)) { 
	$date_enc1=dateUsToFr($users_1["date_enc"]);$tableau=$users_1["tableau"];$id_s=$users_1["id"];
	$m_avoir1=$users_1["m_avoir"];$numero_avoir1=$users_1["numero_avoir"];$numero_chq=$users_1["numero_effet"];
	$espece1=$users_1["m_espece"];$m_virement1=$users_1["m_virement"];$client1=$users_1["client"];$cheque1=$users_1["m_cheque"];$effet1=$users_1["m_effet"];
	$c=$users_1["numero_cheque"];$f=$users_1["numero_effet"];
	$m=$espece1+$m_virement1+$cheque1+$m_avoir1+$effet1;if ($espece1<>0){$ref="espece";}if ($m_virement1<>0){$ref="Virement";}
	$cheque2=$users_1["m_cheque_g"];
	if ($cheque1<>0){$ref="cheque ".$c;$date_enc1=dateUsToFr($users_1["date_cheque"]);}
	if ($effet1<>0){$ref="Effet".$f;$date_enc1=dateUsToFr($users_1["date_echeance"]);}
	if ($m_avoir1<>0){$ref=$numero_avoir1;}
	$mt=$mt+$m;$mm=number_format($m,2,',',' ');$mmm=number_format($cheque2,2,',',' ');
	
	$sql  = "SELECT * ";
	$sql .= "FROM registre_reglements where id='$tableau' ORDER BY id;";
	$row1 = db_query($database_name, $sql);$row = fetch_array($row1);
			$t=$row["bon_sortie"]."/".$row["mois"]."".$row["annee"];
	
	
			?><tr>
						<td><?php $sup="sup";$n_v1="<a href=\"encaissement_impayes_effets.php?facture_n=$facture_n&numero=$numero_chq&action_s=$sup&du=$du1&au=$au1&idp=$idp&id_s=$id_s\">supprimer</a>";
			print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$n_v1 </font>"); ?></td>

			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$date_enc1 </font>"); ?></td>
			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$client1 </font>"); ?></td>
			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$ref </font>"); ?></td>
			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$mmm </font>"); ?></td>
			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$mm </font>"); ?></td>
			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$t </font>"); ?></td>
<? }?>
<tr><td><td><td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">Encaisse </font>"); ?></td>
			<td><?php $mtt=number_format($mt,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$mtt </font>"); ?></td>
<tr><td><td><td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">Solde </font>"); ?></td>
			<td><?php $s=$m_cheque-$mt;$ss=number_format($s,2,',',' ');print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$ss </font>"); ?></td>
	</table>
	<tr>
	<table width="317" border="1">
	<tr><td bgcolor="#3399FF" width="150">Montant Espece : </td>
    <td><input name="espece" type="text" class="Style1" id="espece" style="width:120px" value="<?php echo $espece; ?>"></td></tr>
	<tr><td bgcolor="#3399FF" width="150">Date Espece : </td>
    <td><input onClick="ds_sh(this);" name="date_enc" value="<?php echo $date_enc; ?>" readonly="readonly" style="cursor: text" /></td></tr>
	</table><tr>
	<table width="317" border="1">
	<tr><td bgcolor="#3399FF" width="150">Montant Virement : </td>
    <td><input name="m_virement" type="text" class="Style1" id="m_virement" style="width:120px" value="<?php echo $m_virement; ?>"></td></tr>
	<tr><td bgcolor="#3399FF" width="150">Date Virement : </td>
    <td><input onClick="ds_sh(this);" name="date_virement" value="<?php echo $date_virement; ?>" readonly="readonly" style="cursor: text" /></td></tr>
	</table>
	<tr>
	<table width="317" border="1">
	<tr><td bgcolor="#3399FF" width="150">Numéro Effet : </td>
    <td><input name="numero_effet" type="text" class="Style1" id="numero_effet" style="width:120px" value="<?php echo $numero_effet; ?>"></td></tr>
	<tr><td bgcolor="#3399FF" width="150">Montant Effet : </td>
    <td><input name="m_effet" type="text" class="Style1" id="m_effet" style="width:120px" value="<?php echo $m_effet; ?>"></td></tr>
	<tr><td bgcolor="#3399FF" width="150">Date Echeance : </td>
    <td><input onClick="ds_sh(this);" name="date_echeance" value="<?php echo $date_echeance; ?>" readonly="readonly" style="cursor: text" /></td></tr>
	<tr><td bgcolor="#3399FF" width="150">Banque : </td>
	<td><input name="v_banque1" type="text" class="Style1" id="v_banque1" style="width:120px" value="<?php echo $v_banque1; ?>"></td>
	<tr><td bgcolor="#3399FF" width="150">Client Tiré : </td>            
			<td><input name="client_tire1" type="text" class="Style1" id="client_tire1" style="width:180px" value="<?php echo $client_tire1; ?>"></td>
	</table>
	<tr>
	
	
	
	
	<tr>
	<table width="317" border="1">
	<tr><td bgcolor="#3399FF" width="150">Montant Autre : </td>
    <td><input name="m_avoir" type="text" class="Style1" id="m_avoir" style="width:120px" value="<?php echo $m_avoir; ?>"></td>
	<td><input type="checkbox" id="avoir_sur_compte" name="avoir_sur_compte"<?php if($avoir_sur_compte) { echo " checked"; } ?>></td><td>Ne pas inclure Sur compte client</td>
	</tr>
	<tr><td bgcolor="#3399FF" width="150">Date : </td>
    <td><input onClick="ds_sh(this);" name="date_avoir" value="<?php echo $date_avoir; ?>" readonly="readonly" style="cursor: text" /></td></tr>
	<tr><td bgcolor="#3399FF" width="150">Libelle : </td>
    <td><input name="numero_avoir" type="text" class="Style1" id="numero_avoir" style="width:220px" value="<?php echo $numero_avoir; ?>"></td></tr>
	</table>
	<tr>
		<table width="317" border="1">
        <tr>
		    <td bgcolor="#3399FF">Numero cheque</td><td bgcolor="#3399FF">Montant Cheque </td><td bgcolor="#3399FF">Montant Traité </td>
			<td bgcolor="#3399FF">Banque</td>
			<td bgcolor="#3399FF">Client tir&eacute;</td><td bgcolor="#3399FF">Date cheque </td> <td bgcolor="#3399FF">Notre Banque </td>
		</tr>
		<tr>
            <td><input name="numero_cheque" type="text" class="Style1" id="numero_cheque" style="width:120px" value="<?php echo $numero_cheque; ?>"></td>
			<td align="right"><input name="m_cheque_g0" type="text" class="Style1" id="m_cheque_g0" style="width:120px" value="<?php echo $m_cheque_g0; ?>"></td>
			<td align="right"><input name="m_cheque0" type="text" class="Style1" id="m_cheque0" style="width:120px" value="<?php echo $m_cheque0; ?>"></td>
			<td><input name="v_banque" type="text" class="Style1" id="v_banque" style="width:120px" value="<?php echo $v_banque; ?>"></td>
            <td><input name="client_tire" type="text" class="Style1" id="client_tire" style="width:180px" value="<?php echo $client_tire; ?>"></td>
            <td><input onClick="ds_sh(this);" name="date_cheque" value="<?php echo $date_cheque; ?>" readonly="readonly" style="cursor: text" /></td>
            <td><input name="n_banque" type="text" class="Style1" id="n_banque" style="width:60px" value="<?php echo $n_banque; ?>"></td>
          </tr>
	</table>
	

        <p>&nbsp;</p>
  <tr>
  <p style="text-align:center">
    
<center>
    
<input type="hidden" id="idp" name="idp" value="<?php echo $idp; ?>">
    <input type="hidden" id="date1" name="date1" value="<?php echo $du; ?>">
    <input type="hidden" id="action_r" name="action_r" value="<?php echo $action_r; ?>">
    <input type="hidden" id="date2" name="date2" value="<?php echo $au; ?>">
    <input type="hidden" id="numero_cheque_imp" name="numero_cheque_imp" value="<?php echo $numero_cheque_imp; ?>">
    <input type="hidden" id="client_imp" name="client_imp" value="<?php echo $client_imp; ?>">
    <input type="hidden" id="facture_imp" name="facture_imp" value="<?php echo $facture_imp; ?>">
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