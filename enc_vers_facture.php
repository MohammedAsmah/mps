<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	$id=$_GET['id'];$reference=$_GET['reference'];

	$sql  = "SELECT *";
	$sql .= "FROM porte_feuilles where id='$id' Order BY id;";
	$users11 = db_query($database_name, $sql);$users_1 = fetch_array($users11);
	$id_r=$users_1["id"];$date_enc=$users_1["date_enc"];$vendeur=$users_1["vendeur"];$facture_n=$users_1["facture_n"];
	$montant_f=$users_1["montant_f"];$id_registre_regl=$users_1["id_registre_regl"];
	$client=$users_1["client"];$evaluation=$users_1["evaluation"];$montant_e=$users_1["montant_e"];
	$mode=$users_1["mode"];$m_cheque=$users_1["m_cheque"];$n_banque_e=$users_1["n_banque_e"];$numero_cheque=$users_1["numero_cheque"];
	$m_espece=$users_1["m_espece"];$m_effet=$users_1["m_effet"];$m_avoir=$users_1["m_avoir"];
	$m_diff_prix=$users_1["m_diff_prix"];$date_cheque=dateUsToFr($users_1["date_cheque"]);$date_echeance=dateUsToFr($users_1["date_echeance"]);
	$client_tire=$users_1["client_tire"];$client_tire_e=$users_1["client_tire_e"];$numero_effet=$users_1["numero_effet"];
	$numero_avoir=$users_1["numero_avoir"];$v_banque=$users_1["v_banque"];$v_banque_e=$users_1["v_banque_e"];$n_banque=$users_1["n_banque"];$chq_f=$users_1["chq_f"];
	$chq_e=$users_1["chq_e"];$esp_f=$users_1["esp_f"];$esp_e=$users_1["esp_e"];
	$obs_diff_prix=$users_1["obs_diff_prix"];$eff_f=$users_1["eff_f"];$eff_e=$users_1["eff_e"];
	$numero_virement=$users_1["numero_virement"];$v_banque_v=$users_1["v_banque_v"];$m_virement=$users_1["m_virement"];$date_virement=dateUsToFr($users_1["date_virement"]);
	
	$profiles_list_p = "Selectionnez Produit";$action_r="reglement";
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

<form id="form_user" name="form_user" method="post" action="encaissements_mois_factures.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
		<tr>
		<td><?php echo "Client"; ?></td><td><?php echo $client; ?></td>
		</tr>
		<tr>
		<td><?php echo "Vendeur"; ?></td><td><?php echo $vendeur; ?></td>
		</tr>
		<tr>
		<td><?php echo "Evaluation"; ?></td><td><?php echo $montant_e; ?></td>
		</tr>
		<tr>
		<td><?php echo "Date Encaissement"; ?></td><td><?php echo dateUsToFr($date_enc); ?></td>
		</tr>
		
	</table>
		<? if ($m_cheque<>0){?>
		
		<table width="317" border="1">
          <tr bgcolor="#ECE9D8">
            <td width="164"><span class="Style1">Mode</span></td>
            <td width="108"><span class="Style1">CHEQUE</span></td>
            <td width="23" bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Numero cheque </td>
            <td><input name="numero_cheque" type="text" class="Style1" id="numero_cheque" style="width:150px" value="<?php echo $numero_cheque; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Montant</td>
            <td><?php echo $m_cheque; ?></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Banque</td>
            <td><input name="v_banque" type="text" class="Style1" id="v_banque" style="width:150px" value="<?php echo $v_banque; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Client tir&eacute;</td>
            <td><input name="client_tire" type="text" class="Style1" id="client_tire" style="width:150px" value="<?php echo $client_tire; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Date cheque </td>
            <td><input name="date_cheque" type="text" class="Style1" id="date_cheque" style="width:150px" value="<?php echo $date_cheque; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Notre Banque </td>
            <td><input name="n_banque" type="text" class="Style1" id="n_banque" style="width:150px" value="<?php echo $n_banque; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
		    <td><input type="checkbox" id="chq_f" name="chq_f"<?php if($chq_f) { echo " checked"; } ?>>F</td>
			<td><input type="checkbox" id="chq_e" name="chq_e"<?php if($chq_e) { echo " checked"; } ?>>E</td>
          <tr>
            <td bgcolor="#3399FF">&nbsp;</td>
            <td bgcolor="#3399FF">&nbsp;</td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
		  </table>
		  
		  <table width="317" border="1">
		  <tr>
            <td bgcolor="#3399FF">Facture </td><td bgcolor="#3399FF">Date Facture </td><td bgcolor="#3399FF">Montant Traité </td>
            <tr><td><input name="facture_1_c" type="text" class="Style1" id="facture_1_c" style="width:150px" value="<?php echo $facture_1_c; ?>"></td>
			<td><input onClick="ds_sh(this);" name="date_facture_1_c" value="<?php echo $date_facture_1_c; ?>" readonly="readonly" style="cursor: text" /></td>
			<td><input name="traite_1_c" type="text" class="Style1" id="traite_1_c" style="width:150px" value="<?php echo $traite_1_c; ?>"></td>
			
			<tr><td><input name="facture_2_c" type="text" class="Style1" id="facture_2_c" style="width:150px" value="<?php echo $facture_2_c; ?>"></td>
			<td><input onClick="ds_sh(this);" name="date_facture_2_c" value="<?php echo $date_facture_2_c; ?>" readonly="readonly" style="cursor: text" /></td>
			<td><input name="traite_2_c" type="text" class="Style1" id="traite_2_c" style="width:150px" value="<?php echo $traite_2_c; ?>"></td>
			
			<tr><td><input name="facture_3_c" type="text" class="Style1" id="facture_3_c" style="width:150px" value="<?php echo $facture_3_c; ?>"></td>
			<td><input onClick="ds_sh(this);" name="date_facture_3_c" value="<?php echo $date_facture_3_c; ?>" readonly="readonly" style="cursor: text" /></td>
			<td><input name="traite_3_c" type="text" class="Style1" id="traite_3_c" style="width:150px" value="<?php echo $traite_3_c; ?>"></td>
			
			<tr><td><input name="facture_4_c" type="text" class="Style1" id="facture_4_c" style="width:150px" value="<?php echo $facture_4_c; ?>"></td>
			<td><input onClick="ds_sh(this);" name="date_facture_4_c" value="<?php echo $date_facture_4_c; ?>" readonly="readonly" style="cursor: text" /></td>
			<td><input name="traite_4_c" type="text" class="Style1" id="traite_4_c" style="width:150px" value="<?php echo $traite_4_c; ?>"></td>
			
	
          </tr>
		  </table>
		  <? }?>
		  
		  <? if ($m_espece<>0){?>
		  <table width="317" border="1">
          <tr bgcolor="#ECE9D8">
            <td bgcolor="#ECE9D8"><span class="Style1">Mode</span></td>
            <td bgcolor="#ECE9D8"><span class="Style1">ESPECE</span></td>
			 <td><input type="checkbox" id="esp_f" name="esp_f"<?php if($esp_f) { echo " checked"; } ?>>F</td>
			<td><input type="checkbox" id="esp_e" name="esp_e"<?php if($esp_e) { echo " checked"; } ?>>E</td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Montant</td>
            <td><?php echo $m_espece; ?></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
         <table width="317" border="1">
		  <tr>
            <td bgcolor="#3399FF">Facture </td><td bgcolor="#3399FF">Date Facture </td><td bgcolor="#3399FF">Montant Traité </td>
            <tr><td><input name="facture_1_es" type="text" class="Style1" id="facture_1_es" style="width:150px" value="<?php echo $facture_1_es; ?>"></td>
			<td><input onClick="ds_sh(this);" name="date_facture_1_es" value="<?php echo $date_facture_1_es; ?>" readonly="readonly" style="cursor: text" /></td>
			<td><input name="traite_1_es" type="text" class="Style1" id="traite_1_es" style="width:150px" value="<?php echo $traite_1_es; ?>"></td>
			
			<tr><td><input name="facture_2_es" type="text" class="Style1" id="facture_2_es" style="width:150px" value="<?php echo $facture_2_es; ?>"></td>
			<td><input name="traite_2_es" type="text" class="Style1" id="traite_2_es" style="width:150px" value="<?php echo $traite_2_es; ?>"></td>
			
			<tr><td><input name="facture_3_es" type="text" class="Style1" id="facture_3_es" style="width:150px" value="<?php echo $facture_3_es; ?>"></td>
			<td><input name="traite_3_es" type="text" class="Style1" id="traite_3_es" style="width:150px" value="<?php echo $traite_3_es; ?>"></td>
			
			<tr><td><input name="facture_4_es" type="text" class="Style1" id="facture_4_es" style="width:150px" value="<?php echo $facture_4_es; ?>"></td>
			<td><input name="traite_4_es" type="text" class="Style1" id="traite_4_es" style="width:150px" value="<?php echo $traite_4_es; ?>"></td>
			
            
          </tr>
		  </table>
		    <? }?>
		  
		  
		    <? if ($m_effet<>0){?>
			<table width="317" border="1">
          <tr bgcolor="#ECE9D8">
            <td bgcolor="#ECE9D8"><span class="Style1">Mode</span></td>
            <td bgcolor="#ECE9D8"><span class="Style1">EFFET</span></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Montant</td>
            <td><?php echo $m_effet; ?></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Numero effet</td>
            <td><input name="numero_effet" type="text" class="Style1" id="numero_effet" style="width:150px" value="<?php echo $numero_effet; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Banque</td>
            <td><input name="v_banque_e" type="text" class="Style1" id="v_banque_e" style="width:150px" value="<?php echo $v_banque_e; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Client tir&eacute;</td>
            <td><input name="client_tire_e" type="text" class="Style1" id="client_tire_e" style="width:150px" value="<?php echo $client_tire_e; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Date echeance </td>
            <td><input name="date_echeance" type="text" class="Style1" id="date_echeance" style="width:150px" value="<?php echo $date_echeance; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
			
          </tr>
		  <td><input type="checkbox" id="eff_f" name="eff_f"<?php if($eff_f) { echo " checked"; } ?>>F</td>
			<td><input type="checkbox" id="eff_e" name="eff_e"<?php if($eff_e) { echo " checked"; } ?>>E</td>
          <tr>
            <td bgcolor="#3399FF">Notre Banque </td>
            <td><input name="n_banque_e" type="text" class="Style1" id="n_banque_e" style="width:150px" value="<?php echo $n_banque_e; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <table width="317" border="1">
		  <tr>
            <td bgcolor="#3399FF">Facture </td><td bgcolor="#3399FF">Date Facture </td><td bgcolor="#3399FF">Montant Traité </td>
             <tr><td><input name="facture_1_ef" type="text" class="Style1" id="facture_1_ef" style="width:150px" value="<?php echo $facture_1_ef; ?>"></td>
			 <td><input onClick="ds_sh(this);" name="date_facture_1_ef" value="<?php echo $date_facture_1_ef; ?>" readonly="readonly" style="cursor: text" /></td>
			<td><input name="traite_1_ef" type="text" class="Style1" id="traite_1_ef" style="width:150px" value="<?php echo $traite_1_ef; ?>"></td>
			
			<tr><td><input name="facture_2_c" type="text" class="Style1" id="facture_2_c" style="width:150px" value="<?php echo $facture_2_c; ?>"></td>
			<td><input onClick="ds_sh(this);" name="date_facture_2_c" value="<?php echo $date_facture_2_c; ?>" readonly="readonly" style="cursor: text" /></td>
			<td><input name="traite_2_c" type="text" class="Style1" id="traite_2_c" style="width:150px" value="<?php echo $traite_2_c; ?>"></td>
			
			<tr><td><input name="facture_3_c" type="text" class="Style1" id="facture_3_c" style="width:150px" value="<?php echo $facture_3_c; ?>"></td>
			<td><input onClick="ds_sh(this);" name="date_facture_3_c" value="<?php echo $date_facture_3_c; ?>" readonly="readonly" style="cursor: text" /></td>
			<td><input name="traite_3_c" type="text" class="Style1" id="traite_3_c" style="width:150px" value="<?php echo $traite_3_c; ?>"></td>
			
			<tr><td><input name="facture_4_c" type="text" class="Style1" id="facture_4_c" style="width:150px" value="<?php echo $facture_4_c; ?>"></td>
			<td><input onClick="ds_sh(this);" name="date_facture_4_c" value="<?php echo $date_facture_4_c; ?>" readonly="readonly" style="cursor: text" /></td>
			<td><input name="traite_4_c" type="text" class="Style1" id="traite_4_c" style="width:150px" value="<?php echo $traite_4_c; ?>"></td>
			
            
          </tr>
		  </table>
		      <? }?>
		  
		  
          
        </table>		
		<p>&nbsp;</p>
<tr>
		
		<table class="table2">
		<th><?php echo "Facture";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "M.Esp";?></th>
	<th><?php echo "M.Cheque";?></th>
	<th><?php echo "M.Effet";?></th>
	<th><?php echo "Total Enc";?></th>
		
	<?
	///////////////
	$sql  = "SELECT * ";$t=0;
	$sql .= "FROM porte_feuilles_factures where id_porte_feuille='$id' ORDER BY id;";
	$users111 = db_query($database_name, $sql);
	while($users_11 = fetch_array($users111)) 
	{ 
		$t=$t+$users_11["m_cheque"]+$users_11["m_espece"]+$users_11["m_effet"];?>
		<tr><td align="center"><?php $fact=$users_11["facture_n"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$fact </font>");?></td>
		<td align="left"><?php $clt=$users_11["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$clt </font>");?></td>
		<td align="right"><?php $esp=number_format($users_11["m_espece"],2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$esp </font>");?></td>
		<td align="right"><?php $chq=number_format($users_11["m_cheque"],2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$chq </font>");?></td>
		<td align="right"><?php $eff=number_format($users_11["m_effet"],2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$eff </font>");?></td>
		<td align="right"><?php $tchq=number_format($users_11["m_cheque"]+$users_11["m_espece"]+$users_11["m_effet"],2,',',' ');
			print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tchq </font>");
			 ?></td>	</tr>	
	<?	
	
	}
	?>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td><? echo "Toal : ";?></td>
	<td align="right"><?php $tchq=number_format($t,2,',',' ');
			print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tchq </font>");
			 ?></td></tr>
	
	</table>

        <p>&nbsp;</p>
  <tr>
  <p style="text-align:center">
    
<center>
    
<input type="hidden" id="id_registre_regl" name="id_registre_regl" value="<?php echo $id_registre_regl; ?>">
    <input type="hidden" id="action_r" name="action_r" value="<?php echo $action_r; ?>">
    
<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
<input type="hidden" id="reference" name="reference" value="<?php echo $reference; ?>">

<input type="hidden" id="client" name="client" value="<?php echo $client; ?>">
<input type="hidden" id="vendeur" name="vendeur" value="<?php echo $vendeur; ?>">
<input type="hidden" id="montant_e" name="montant_e" value="<?php echo $montant_e; ?>">

<input type="hidden" id="m_cheque" name="m_cheque" value="<?php echo $m_cheque; ?>">
<input type="hidden" id="m_espece" name="m_espece" value="<?php echo $m_espece; ?>">
<input type="hidden" id="m_effet" name="m_effet" value="<?php echo $m_effet; ?>">
<input type="hidden" id="date_enc" name="date_enc" value="<?php echo $date_enc; ?>">
<table class="table3"><tr>
 
<td><button type="button" onClick="UpdateUser()"><?php echo Translate("Update"); ?></button></td>
  
	</tr></table>
    
</center>
</form>


<p style="text-align:center">
</body>

</html>