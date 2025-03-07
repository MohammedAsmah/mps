<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	$id=$_GET['id'];$date1=$_GET['date1'];$date2=$_GET['date2'];$date_enc=$_GET['date_enc'];
	$id_registre=$_GET['id_registre'];
	$vendeur=$_GET['vendeur'];
	$action_r="m_reglement";

	$sql  = "SELECT *";
	$sql .= "FROM porte_feuilles where id='$id' Order BY id;";
	$users11 = db_query($database_name, $sql);$users_1 = fetch_array($users11);
	$id_r=$users_1["id"];$date_enc=$users_1["date_enc"];$vendeur=$users_1["vendeur"];$facture_n=$users_1["facture_n"];
	$montant_f=$users_1["montant_f"];
	$client=$users_1["client"];$evaluation=$users_1["evaluation"];$montant_e=$users_1["montant_e"];
	$mode=$users_1["mode"];$m_cheque=$users_1["m_cheque"];$n_banque_e=$users_1["n_banque_e"];$numero_cheque=$users_1["numero_cheque"];
	$m_espece=$users_1["m_espece"];$m_effet=$users_1["m_effet"];$m_avoir=$users_1["m_avoir"];
	$m_diff_prix=$users_1["m_diff_prix"];$date_cheque=dateUsToFr($users_1["date_cheque"]);$date_echeance=dateUsToFr($users_1["date_echeance"]);
	$client_tire=$users_1["client_tire"];$client_tire_e=$users_1["client_tire_e"];$numero_effet=$users_1["numero_effet"];
	$numero_avoir=$users_1["numero_avoir"];$v_banque=$users_1["v_banque"];$v_banque_e=$users_1["v_banque_e"];$n_banque=$users_1["n_banque"];$chq_f=$users_1["chq_f"];
	$chq_e=$users_1["chq_e"];$esp_f=$users_1["esp_f"];$esp_e=$users_1["esp_e"];
	$obs_diff_prix=$users_1["obs_diff_prix"];$eff_f=$users_1["eff_f"];$eff_e=$users_1["eff_e"];
	$numero_virement=$users_1["numero_virement"];$v_banque_v=$users_1["v_banque_v"];$m_virement=$users_1["m_virement"];$date_virement=dateUsToFr($users_1["date_virement"]);
	
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
<title><? echo dateUsToFr($date_enc);?></title>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<form id="form_user" name="form_user" method="post" action="reglements.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
		<tr>
		<td><?php echo "Client"; ?></td><td><?php echo $client; ?></td>
		</tr>
		<tr>
		<td><?php echo "Evaluation"; ?></td><td><input type="text" id="montant_e" name="montant_e" style="width:260px" value="<?php echo $montant_e; ?>"></td>
		</tr>
		<tr>
		<td><?php echo "Date"; ?></td><td><?php echo dateUsToFr($date_enc); ?></td>
		</tr>
		<tr>
		<td><?php echo "Facture"; ?></td><td><input type="text" id="facture_n" name="facture_n" style="width:260px" value="<?php echo $facture_n; ?>"></td>
		</tr>
	</table>
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
            <td><input name="m_cheque" type="text" class="Style1" id="m_cheque" style="width:150px" value="<?php echo $m_cheque; ?>"></td>
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
           <td><input name="date_cheque" type="text" class="Style1" id="date_cheque" style="width:100px" value="<?php echo $date_cheque; ?>"></td>				
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
          <tr bgcolor="#ECE9D8">
            <td bgcolor="#ECE9D8"><span class="Style1">Mode</span></td>
            <td bgcolor="#ECE9D8"><span class="Style1">ESPECE</span></td>
			 <td><input type="checkbox" id="esp_f" name="esp_f"<?php if($esp_f) { echo " checked"; } ?>>F</td>
			<td><input type="checkbox" id="esp_e" name="esp_e"<?php if($esp_e) { echo " checked"; } ?>>E</td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Montant</td>
            <td><input name="m_espece" type="text" class="Style1" id="m_espece" style="width:150px" value="<?php echo $m_espece; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr bgcolor="#ECE9D8">
            <td bgcolor="#3399FF">&nbsp;</td>
            <td bgcolor="#3399FF">&nbsp;</td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr bgcolor="#ECE9D8">
            <td bgcolor="#ECE9D8"><span class="Style1">Mode</span></td>
            <td bgcolor="#ECE9D8"><span class="Style1">EFFET</span></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Montant</td>
            <td><input name="m_effet" type="text" class="Style1" id="m_effet" style="width:150px" value="<?php echo $m_effet; ?>"></td>
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
      <td><input name="date_echeance" type="text" class="Style1" id="date_echeance" style="width:100px" value="<?php echo $date_echeance; ?>"></td>	
            <td bgcolor="#3399FF">&nbsp;</td>
			
          </tr>
		  <td><input type="checkbox" id="eff_f" name="eff_f"<?php if($eff_f) { echo " checked"; } ?>>F</td>
			<td><input type="checkbox" id="eff_e" name="eff_e"<?php if($eff_e) { echo " checked"; } ?>>E</td>
          <tr>
            <td bgcolor="#3399FF">Notre Banque </td>
            <td><input name="n_banque_e" type="text" class="Style1" id="n_banque_e" style="width:150px" value="<?php echo $n_banque_e; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr bgcolor="#3399FF">
            <td bgcolor="#3399FF">&nbsp;</td>
            <td bgcolor="#3399FF">&nbsp;</td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr bgcolor="#ECE9D8">
            <td bgcolor="#ECE9D8"><span class="Style1">Mode</span></td>
            <td bgcolor="#ECE9D8"><span class="Style1">VIREMENT</span></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Montant</td>
            <td><input name="m_virement" type="text" class="Style1" id="m_virement" style="width:150px" value="<?php echo $m_virement; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Numero Virement</td>
            <td><input name="numero_virement" type="text" class="Style1" id="numero_virement" style="width:150px" value="<?php echo $numero_virement; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Banque</td>
            <td><input name="v_banque_v" type="text" class="Style1" id="v_banque_v" style="width:150px" value="<?php echo $v_banque_v; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Date virement </td>
          <td><input name="date_virement" type="text" class="Style1" id="date_virement" style="width:100px" value="<?php echo $date_virement; ?>"></td>	
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
		  
		  
          <tr bgcolor="#3399FF">
            <td bgcolor="#ECE9D8"><span class="Style1">Mode</span></td>
            <td bgcolor="#ECE9D8"><span class="Style1">AVOIR</span></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr bgcolor="#3399FF">
            <td bgcolor="#3399FF">Montant</td>
            <td bgcolor="#3399FF"><input name="m_avoir" type="text" class="Style1" id="m_avoir" style="width:150px" value="<?php echo $m_avoir; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr bgcolor="#3399FF">
            <td bgcolor="#3399FF">Numero Avoir </td>
            <td bgcolor="#3399FF"><input name="numero_avoir" type="text" class="Style1" id="numero_avoir" style="width:150px" value="<?php echo $numero_avoir; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr bgcolor="#3399FF">
            <td bgcolor="#3399FF">&nbsp;</td>
            <td bgcolor="#3399FF">&nbsp;</td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr bgcolor="#3399FF">
            <td bgcolor="#ECE9D8"><span class="Style1">Mode</span></td>
            <td bgcolor="#ECE9D8"><span class="Style1">DIFF/PRIX</span></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr bgcolor="#3399FF">
            <td>Montant</td>
            <td bgcolor="#3399FF"><input name="m_diff_prix" type="text" class="Style1" id="m_diff_prix" style="width:150px" value="<?php echo $m_diff_prix; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr bgcolor="#3399FF">
            <td>Observation</td>
            <td bgcolor="#3399FF"><input name="obs" type="text" class="Style1" id="obs" style="width:150px" value="<?php echo $obs_diff_prix; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
        </table>		<p>&nbsp;</p>
<tr>
		
	<table class="table3">

	</table>

        <p>&nbsp;</p>
  <tr>
  <p style="text-align:center">
    
<center>
    
<input type="hidden" id="id_registre" name="id_registre" value="<?php echo $id_registre; ?>">
    <input type="hidden" id="action_r" name="action_r" value="<?php echo $action_r; ?>">
	<input type="hidden" id="date_enc" name="date_enc" value="<?php echo $date_enc; ?>">
    <input type="hidden" id="vendeur" name="vendeur" value="<?php echo $vendeur; ?>">
<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
<input type="hidden" id="date1" name="date1" value="<?php echo $date1; ?>">
<input type="hidden" id="date2" name="date2" value="<?php echo $date2; ?>">

<table class="table3"><tr>
 
<td><button type="button" onClick="UpdateUser()"><?php echo Translate("Update"); ?></button></td>
  
	</tr></table>
    
</center>
</form>


<p style="text-align:center">
</body>

</html>