<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	$id_commande=$_GET['id_commande'];$id_registre=$_GET['id_registre'];$vendeur=$_GET['vendeur'];
	$eval=$_GET['evaluation'];$client=$_GET['client'];$montant_e=$_GET['montant'];$action_r="reglement";
	$mode_list = "";$mo="mode_reg";$date_enc=$_GET['date_enc'];$facture="";$montant_f="";
	
		$obs="";$n_banque="BCP";$n_banque_e="BCP";$n_banque1="BCP";$n_banque2="BCP";
		$n_banque3="BCP";$n_banque4="BCP";$n_banque5="BCP";$n_banque6="BCP";$n_banque7="BCP";$n_banque8="BCP";
	
		$m_cheque0="";$cheque="";$numero_cheque="";$date_cheque="";$client_tire="";$date_remise_cheque="";$v_banque="";$chq_f=0;$chq_e=0;$facture_n=0;
		$m_cheque1="";$cheque1="";$numero_cheque1="";$date_cheque1="";$client_tire1="";$date_remise_cheque1="";$v_banque1="";$chq_f1=0;$chq_e1=0;
		$m_cheque2="";$cheque2="";$numero_cheque2="";$date_cheque2="";$client_tire2="";$date_remise_cheque2="";$v_banque2="";$chq_f2=0;$chq_e2=0;
		$m_cheque3="";$cheque3="";$numero_cheque3="";$date_cheque3="";$client_tire3="";$date_remise_cheque3="";$v_banque3="";$chq_f3=0;$chq_e3=0;
		$m_cheque4="";$cheque4="";$numero_cheque4="";$date_cheque4="";$client_tire4="";$date_remise_cheque4="";$v_banque4="";$chq_f4=0;$chq_e4=0;
		$m_cheque5="";$cheque5="";$numero_cheque5="";$date_cheque5="";$client_tire5="";$date_remise_cheque5="";$v_banque5="";$chq_f5=0;$chq_e5=0;
		$m_cheque6="";$cheque6="";$numero_cheque6="";$date_cheque6="";$client_tire6="";$date_remise_cheque6="";$v_banque6="";$chq_f6=0;$chq_e6=0;
		$m_cheque7="";$cheque7="";$numero_cheque7="";$date_cheque7="";$client_tire7="";$date_remise_cheque7="";$v_banque7="";$chq_f7=0;$chq_e7=0;
		$m_cheque8="";$cheque8="";$numero_cheque8="";$date_cheque8="";$client_tire8="";$date_remise_cheque8="";$v_banque8="";$chq_f8=0;$chq_e8=0;
	
		$chq_f1=0;$chq_e1=0;
		$chq_f2=0;$chq_e2=0;
		$chq_f3=0;$chq_e3=0;
		
	
		
		$v_banque_e="";$client_tire_e="";$vir_f=0;$vir_e=0;
		$m_virement="";$numero_virement="";$date_virement="";$v_banque_v="";
		
		$m_cheque_g0="";$m_cheque_g1="";$m_cheque_g2="";$m_cheque_g3="";$m_cheque_g4="";$m_cheque_g5="";$m_cheque_g6="";
//1er regl	
		$m_cheque_g7="";	$m_cheque_g8="";
		$m_espece="";$espece="";$esp_f=0;$esp_e=0;
		
//1er regl		
		$m_effet="";$effet="";$numero_effet="";$date_effet="";$date_echeance="";
		$date_remise_effet="";$eff_f=0;$eff_e=0;
//1er regl		
		$m_avoir="";$avoir="";$numero_avoir="";
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
		$profiles_list_avoirs = "Selectionnez avoir";
	$sql_produit = "SELECT * FROM avoirs where (client='$client' or client='') and liquide=0 ORDER BY be;";
	$temp_produit = db_query($database_name, $sql_produit);
	while($temp_produit_ = fetch_array($temp_produit)) {
		if($numero_avoir == $temp_produit_["be"]) { $selected = " selected"; } else { $selected = ""; }
		$profiles_list_avoirs .= "<OPTION VALUE=\"" . $temp_produit_["be"] . "\"" . $selected . ">";
		$profiles_list_avoirs .= $temp_produit_["be"]."-->".$temp_produit_["net"];
		$profiles_list_avoirs .= "</OPTION>";
	}


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><? echo dateUsToFr($date_enc);?></title>

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

<form id="form_user" name="form_user" method="post" action="reglements.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
		<tr>
		<td><?php echo "Client"; ?></td><td><?php echo $client; ?></td>
		</tr>
		<tr>
		<td><?php echo "Evaluation"; ?></td><td><?php echo $eval." : ".number_format($montant_e,2,',',' '); ?></td>
		</tr>
		<tr>
		<td><?php echo "Date"; ?></td><td><?php echo dateUsToFr($date_enc); ?></td>
		</tr>
	</table>
		<table width="317" border="1">
          <tr bgcolor="#ECE9D8">
            <td width="164"><span class="Style1">Mode</span></td>
            <td width="108"><span class="Style1">CHEQUE</span></td>
            <td width="23" bgcolor="#3399FF">&nbsp;</td>
          </tr>
		  
            <td bgcolor="#3399FF">Numero cheque</td><td bgcolor="#3399FF">Montant Cheque </td><td bgcolor="#3399FF">Montant Trait� </td><td bgcolor="#3399FF">Banque</td>
			<td bgcolor="#3399FF">Client tir&eacute;</td><td bgcolor="#3399FF">Date cheque </td> <td bgcolor="#3399FF">Notre Banque </td>
		</tr>
		<tr>
            <td><input name="numero_cheque" type="text" class="Style1" id="numero_cheque" style="width:120px" value="<?php echo $numero_cheque; ?>"></td>
			<td align="right"><input name="m_cheque_g0" type="text" class="Style1" id="m_cheque_g0" style="width:120px" value="<?php echo $m_cheque_g0; ?>"></td>
			<td align="right"><input name="m_cheque0" type="text" class="Style1" id="m_cheque0" style="width:120px" value="<?php echo $m_cheque0; ?>"></td>
			<td><input name="v_banque" type="text" class="Style1" id="v_banque" style="width:120px" value="<?php echo $v_banque; ?>"></td>
            <td><input name="client_tire" type="text" class="Style1" id="client_tire" style="width:180px" value="<?php echo $client_tire; ?>"></td>
            <td><input onclick="ds_sh(this);" name="date_cheque" readonly="readonly" style="cursor: text" value="<?php echo $date_cheque; ?>"></td>		
			
            <td><input name="n_banque" type="text" class="Style1" id="n_banque" style="width:60px" value="<?php echo $n_banque; ?>"></td>
			<td><input type="checkbox" id="chq_f" name="chq_f"<?php if($chq_f) { echo " checked"; } ?>>F</td>
			<td><input type="checkbox" id="chq_e" name="chq_e"<?php if($chq_e) { echo " checked"; } ?>>E</td>
            <td><input name="facture_n" type="text" class="Style1" id="facture_n" style="width:60px" value="<?php echo $facture_n; ?>"></td>

          </tr>
		  
		<tr>
		    <td><input name="numero_cheque1" type="text" class="Style1" id="numero_cheque1" style="width:120px" value="<?php echo $numero_cheque1; ?>"></td>
			<td align="right"><input name="m_cheque_g1" type="text" class="Style1" id="m_cheque_g1" style="width:120px" value="<?php echo $m_cheque_g1; ?>"></td>
		    <td align="right"><input name="m_cheque1" type="text" class="Style1" id="m_cheque1" style="width:120px" value="<?php echo $m_cheque1; ?>"></td>
            <td><input name="v_banque1" type="text" class="Style1" id="v_banque1" style="width:120px" value="<?php echo $v_banque1; ?>"></td>
            <td><input name="client_tire1" type="text" class="Style1" id="client_tire1" style="width:180px" value="<?php echo $client_tire1; ?>"></td>
			<td><input onclick="ds_sh(this);" name="date_cheque1" readonly="readonly" style="cursor: text" value="<?php echo $date_cheque1; ?>"></td>			
            <td><input name="n_banque1" type="text" class="Style1" id="n_banque1" style="width:60px" value="<?php echo $n_banque1; ?>"></td>
          	<td><input type="checkbox" id="chq_f1" name="chq_f1"<?php if($chq_f1) { echo " checked"; } ?>>F</td>
			<td><input type="checkbox" id="chq_e1" name="chq_e1"<?php if($chq_e1) { echo " checked"; } ?>>E</td>
		  </tr>
		<tr>
            <td><input name="numero_cheque2" type="text" class="Style1" id="numero_cheque2" style="width:120px" value="<?php echo $numero_cheque2; ?>"></td>
			<td align="right"><input name="m_cheque_g2" type="text" class="Style1" id="m_cheque_g2" style="width:120px" value="<?php echo $m_cheque_g2; ?>"></td>
		    <td align="right"><input name="m_cheque2" type="text" class="Style1" id="m_cheque2" style="width:120px" value="<?php echo $m_cheque2; ?>"></td>
            <td><input name="v_banque2" type="text" class="Style1" id="v_banque2" style="width:120px" value="<?php echo $v_banque2; ?>"></td>
            <td><input name="client_tire2" type="text" class="Style1" id="client_tire2" style="width:180px" value="<?php echo $client_tire2; ?>"></td>
            <td><input onclick="ds_sh(this);" name="date_cheque2" readonly="readonly" style="cursor: text" value="<?php echo $date_cheque2; ?>"></td>
            <td><input name="n_banque2" type="text" class="Style1" id="n_banque2" style="width:60px" value="<?php echo $n_banque2; ?>"></td>
          	<td><input type="checkbox" id="chq_f2" name="chq_f2"<?php if($chq_f2) { echo " checked"; } ?>>F</td>
			<td><input type="checkbox" id="chq_e2" name="chq_e2"<?php if($chq_e2) { echo " checked"; } ?>>E</td>
		  </tr>
		<tr>
            <td><input name="numero_cheque3" type="text" class="Style1" id="numero_cheque3" style="width:120px" value="<?php echo $numero_cheque2; ?>"></td>
			<td align="right"><input name="m_cheque_g3" type="text" class="Style1" id="m_cheque_g3" style="width:120px" value="<?php echo $m_cheque_g3; ?>"></td>
			<td><input name="m_cheque3" type="text" class="Style1" id="m_cheque3" style="width:120px" value="<?php echo $m_cheque3; ?>"></td>
            <td><input name="v_banque3" type="text" class="Style1" id="v_banque3" style="width:120px" value="<?php echo $v_banque3; ?>"></td>
            <td><input name="client_tire3" type="text" class="Style1" id="client_tire3" style="width:180px" value="<?php echo $client_tire3; ?>"></td>
            <td><input onclick="ds_sh(this);" name="date_cheque3" readonly="readonly" style="cursor: text" value="<?php echo $date_cheque3; ?>"></td>
            <td><input name="n_banque3" type="text" class="Style1" id="n_banque3" style="width:60px" value="<?php echo $n_banque3; ?>"></td>
          	<td><input type="checkbox" id="chq_f3" name="chq_f3"<?php if($chq_f3) { echo " checked"; } ?>>F</td>
			<td><input type="checkbox" id="chq_e3" name="chq_e3"<?php if($chq_e3) { echo " checked"; } ?>>E</td>
		  </tr>
		  <? /*
		
		<tr>
            <td><input name="numero_cheque4" type="text" class="Style1" id="numero_cheque4" style="width:120px" value="<?php echo $numero_cheque4; ?>"></td>
			<td align="right"><input name="m_cheque_g4" type="text" class="Style1" id="m_cheque_g4" style="width:120px" value="<?php echo $m_cheque_g4; ?>"></td>
			<td><input name="m_cheque4" type="text" class="Style1" id="m_cheque4" style="width:120px" value="<?php echo $m_cheque4; ?>"></td>
            <td><input name="v_banque4" type="text" class="Style1" id="v_banque4" style="width:120px" value="<?php echo $v_banque4; ?>"></td>
            <td><input name="client_tire4" type="text" class="Style1" id="client_tire4" style="width:180px" value="<?php echo $client_tire4; ?>"></td>
            <td><input name="date_cheque4" type="text" class="Style1" id="date_cheque4" style="width:120px" value="<?php echo $date_cheque4; ?>"></td>
            <td><input name="n_banque4" type="text" class="Style1" id="n_banque4" style="width:60px" value="<?php echo $n_banque4; ?>"></td>
          </tr>
		<tr>
            <td><input name="numero_cheque5" type="text" class="Style1" id="numero_cheque5" style="width:120px" value="<?php echo $numero_cheque5; ?>"></td>
			<td align="right"><input name="m_cheque_g5" type="text" class="Style1" id="m_cheque_g5" style="width:120px" value="<?php echo $m_cheque_g5; ?>"></td>
			<td><input name="m_cheque5" type="text" class="Style1" id="m_cheque5" style="width:120px" value="<?php echo $m_cheque5; ?>"></td>
            <td><input name="v_banque5" type="text" class="Style1" id="v_banque5" style="width:120px" value="<?php echo $v_banque5; ?>"></td>
            <td><input name="client_tire5" type="text" class="Style1" id="client_tire5" style="width:180px" value="<?php echo $client_tire5; ?>"></td>
            <td><input name="date_cheque5" type="text" class="Style1" id="date_cheque5" style="width:120px" value="<?php echo $date_cheque5; ?>"></td>
            <td><input name="n_banque5" type="text" class="Style1" id="n_banque5" style="width:60px" value="<?php echo $n_banque5; ?>"></td>
          </tr>
		<tr>
	            <td><input name="numero_cheque6" type="text" class="Style1" id="numero_cheque6" style="width:120px" value="<?php echo $numero_cheque6; ?>"></td>
			<td align="right"><input name="m_cheque_g6" type="text" class="Style1" id="m_cheque_g6" style="width:120px" value="<?php echo $m_cheque_g6; ?>"></td>
		<td><input name="m_cheque6" type="text" class="Style1" id="m_cheque6" style="width:120px" value="<?php echo $m_cheque6; ?>"></td>
            <td><input name="v_banque6" type="text" class="Style1" id="v_banque6" style="width:120px" value="<?php echo $v_banque6; ?>"></td>
            <td><input name="client_tire6" type="text" class="Style1" id="client_tire6" style="width:180px" value="<?php echo $client_tire6; ?>"></td>
            <td><input name="date_cheque6" type="text" class="Style1" id="date_cheque6" style="width:120px" value="<?php echo $date_cheque6; ?>"></td>
            <td><input name="n_banque6" type="text" class="Style1" id="n_banque6" style="width:60px" value="<?php echo $n_banque6; ?>"></td>
          </tr>
		<tr>
            <td><input name="numero_cheque7" type="text" class="Style1" id="numero_cheque7" style="width:120px" value="<?php echo $numero_cheque7; ?>"></td>
			<td align="right"><input name="m_cheque_g7" type="text" class="Style1" id="m_cheque_g7" style="width:120px" value="<?php echo $m_cheque_g7; ?>"></td>
			<td><input name="m_cheque7" type="text" class="Style1" id="m_cheque7" style="width:120px" value="<?php echo $m_cheque7; ?>"></td>
            <td><input name="v_banque7" type="text" class="Style1" id="v_banque7" style="width:120px" value="<?php echo $v_banque7; ?>"></td>
            <td><input name="client_tire7" type="text" class="Style1" id="client_tire7" style="width:180px" value="<?php echo $client_tire7; ?>"></td>
            <td><input name="date_cheque7" type="text" class="Style1" id="date_cheque7" style="width:120px" value="<?php echo $date_cheque7; ?>"></td>
            <td><input name="n_banque7" type="text" class="Style1" id="n_banque7" style="width:60px" value="<?php echo $n_banque7; ?>"></td>
          </tr>
		<tr>
            <td><input name="numero_cheque8" type="text" class="Style1" id="numero_cheque8" style="width:120px" value="<?php echo $numero_cheque8; ?>"></td>
			<td align="right"><input name="m_cheque_g8" type="text" class="Style1" id="m_cheque_g8" style="width:120px" value="<?php echo $m_cheque_g8; ?>"></td>
			<td><input name="m_cheque8" type="text" class="Style1" id="m_cheque8" style="width:120px" value="<?php echo $m_cheque8; ?>"></td>
            <td><input name="v_banque8" type="text" class="Style1" id="v_banque8" style="width:120px" value="<?php echo $v_banque8; ?>"></td>
            <td><input name="client_tire8" type="text" class="Style1" id="client_tire8" style="width:180px" value="<?php echo $client_tire8; ?>"></td>
            <td><input name="date_cheque8" type="text" class="Style1" id="date_cheque8" style="width:120px" value="<?php echo $date_cheque8; ?>"></td>
            <td><input name="n_banque8" type="text" class="Style1" id="n_banque8" style="width:60px" value="<?php echo $n_banque8; ?>"></td>
          </tr>
		  */?>
		  <tr>
            <td bgcolor="#3399FF">&nbsp;</td>
            <td bgcolor="#3399FF">&nbsp;</td>
            <td bgcolor="#3399FF">&nbsp;</td>
            <td bgcolor="#3399FF">&nbsp;</td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
		  
		  	</table>
		<table width="317" border="1">
          <tr bgcolor="#ECE9D8">
            <td bgcolor="#ECE9D8"><span class="Style1">Mode</span></td>
            <td bgcolor="#ECE9D8"><span class="Style1">ESPECE</span></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Montant</td>
            <td><input name="m_espece" type="text" class="Style1" id="m_espece" style="width:150px" value="<?php echo $m_espece; ?>"></td>
			<td><input type="checkbox" id="esp_f" name="esp_f"<?php if($esp_f) { echo " checked"; } ?>>F</td>
			<td><input type="checkbox" id="esp_e" name="esp_e"<?php if($esp_e) { echo " checked"; } ?>>E</td>
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
			<td><input onclick="ds_sh(this);" name="date_echeance" readonly="readonly" style="cursor: text" value="<?php echo $date_echeance; ?>"></td>			
            <td bgcolor="#3399FF">&nbsp;</td>
			
          </tr>
		  <tr><td><input type="checkbox" id="eff_f" name="eff_f"<?php if($eff_f) { echo " checked"; } ?>>F</td>
			<td><input type="checkbox" id="eff_e" name="eff_e"<?php if($eff_e) { echo " checked"; } ?>>E</td>
			</tr>
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
           <td><input onclick="ds_sh(this);" name="date_virement" readonly="readonly" style="cursor: text" value="<?php echo $date_virement; ?>"></td>	
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
		  <tr><td><input type="checkbox" id="vir_f" name="vir_f"<?php if($vir_f) { echo " checked"; } ?>>F</td>
			<td><input type="checkbox" id="vir_e" name="vir_e"<?php if($vir_e) { echo " checked"; } ?>>E</td>
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
            <td bgcolor="#3399FF"><input name="obs" type="text" class="Style1" id="obs" style="width:150px" value="<?php echo $obs; ?>"></td>
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
    <input type="hidden" id="id_commande" name="id_commande" value="<?php echo $id_commande; ?>">
    <input type="hidden" id="action_r" name="action_r" value="<?php echo $action_r; ?>">
    <input type="hidden" id="montant_e" name="montant_e" value="<?php echo $montant_e; ?>">
    <input type="hidden" id="vendeur" name="vendeur" value="<?php echo $vendeur; ?>">
    <input type="hidden" id="date_enc" name="date_enc" value="<?php echo $date_enc; ?>">
    <input type="hidden" id="eval" name="eval" value="<?php echo $eval; ?>">
<table class="table3"><tr>
 <? if ($date_enc=="0000-00-00"){}else{?>   
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<? }?>
    </tr></table>
    
</center>
</form>


<p style="text-align:center">
<table>
<? /*echo "<td><a href=\"registres_reglements.php?date=$date&vendeur=$vendeur&id_registre=$id_registre\">Terminer</a></td>";*/?>
</table>
</body>

</html>