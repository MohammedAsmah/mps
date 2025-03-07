<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	$id=$_REQUEST['id'];$reference=$_REQUEST['reference'];$id_p=$_REQUEST['id_p'];

	$sql  = "SELECT *";
	$sql .= "FROM porte_feuilles_factures where id='$id' Order BY id;";
	$users11 = db_query($database_name, $sql);$users_1 = fetch_array($users11);
	$id_r=$users_1["id"];$date_enc=$users_1["date_enc"];$vendeur=$users_1["vendeur"];$facture_n=$users_1["facture_n"];$date_f=dateUsToFr($users_1["date_f"]);
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
	
	
	
	
	
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

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
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "enc_vers_facture1.php?action_=delete&id=<?php echo $_REQUEST["id"]; ?>";
		}
	}

--></script>

<style type="text/css">
<!--
.Style1 {color: #FF0000}
-->
</style>
</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<form id="form_user" name="form_user" method="post" action="enc_vers_facture1.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	
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
            <td bgcolor="#3399FF">Montant Traité</td>
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
            <td><input name="date_cheque" type="text" class="Style1" id="date_cheque" style="width:150px" value="<?php echo $date_cheque; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          
		  <tr>
            <td bgcolor="#3399FF">Date Facture </td>
            <td><input name="date_f" type="text" class="Style1" id="date_f" style="width:150px" value="<?php echo $date_f; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
		  
		  <tr>
            <td bgcolor="#3399FF">N° Facture </td>
            <td><input name="facture_n" type="text" class="Style1" id="facture_n" style="width:150px" value="<?php echo $facture_n; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
         
		  </table>
		  
		  
		  <? }?>
		  
		  <? if ($m_espece<>0){?>
		  <table width="317" border="1">
          <tr bgcolor="#ECE9D8">
            <td bgcolor="#ECE9D8"><span class="Style1">Mode</span></td>
            <td bgcolor="#ECE9D8"><span class="Style1">ESPECE</span></td>
			
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#3399FF">Montant Traité</td>
            <td><input name="m_espece" type="text" class="Style1" id="m_espece" style="width:150px" value="<?php echo $m_espece; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
         <tr>
            <td bgcolor="#3399FF">Date Facture </td>
            <td><input name="date_f" type="text" class="Style1" id="date_f" style="width:150px" value="<?php echo $date_f; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
		  
		  <tr>
            <td bgcolor="#3399FF">N° Facture </td>
            <td><input name="facture_n" type="text" class="Style1" id="facture_n" style="width:150px" value="<?php echo $facture_n; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
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
            <td bgcolor="#3399FF">Montant Traité</td>
            <td><input name="m_effet" type="text" class="Style1" id="m_effet" style="width:150px" value="<?php echo $m_effet; ?>"></td>
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
		  <tr>
            <td bgcolor="#3399FF">Date Facture </td>
            <td><input name="date_f" type="text" class="Style1" id="date_f" style="width:150px" value="<?php echo $date_f; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
		  
		  <tr>
            <td bgcolor="#3399FF">N° Facture </td>
            <td><input name="facture_n" type="text" class="Style1" id="facture_n" style="width:150px" value="<?php echo $facture_n; ?>"></td>
            <td bgcolor="#3399FF">&nbsp;</td>
          </tr>
                    
		      <? }?>
		  
		  
          
        </table>		
		<p>&nbsp;</p>
<tr>
		
		
  <p style="text-align:center">
    
<center>
    
<input type="hidden" id="id_registre_regl" name="id_registre_regl" value="<?php echo $id_registre_regl; ?>">
<? $action_="update";?>   
   <input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
    
<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
<input type="hidden" id="id_p" name="id_p" value="<?php echo $id_p; ?>">
<input type="hidden" id="reference" name="reference" value="<?php echo $reference; ?>">

<table class="table3"><tr>
 
<td><button type="button" onClick="UpdateUser()"><?php echo Translate("Update"); ?></button></td>
<td><button type="button" onClick="DeleteUser()"><?php echo Translate("Delete"); ?></button></td>
  
	</tr></table>
    
</center>
</form>


<p style="text-align:center">
</body>

</html>