<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";$date1="";$date2="";$action="Recherche";$client="";$vendeur="";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$client_list = "";
	$sql = "SELECT * FROM  clients ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$client_list .= $temp_["client"];
		$client_list .= "</OPTION>";
	}
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
	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "registre_remise.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	


	
	
	
	
	$sql  = "SELECT client_tire, sum(m_cheque) as m_cheques ";
	$sql .= "FROM porte_feuilles_factures where r_impaye=1 and facture_n<>0 and m_cheque<>0 group BY client_tire;";
	$users11 = db_query($database_name, $sql);

	$sql  = "SELECT client_tire_e, sum(m_effet) as m_effets ";$vide="";
	$sql .= "FROM porte_feuilles_factures where r_impaye_e=1 and facture_n<>0 and m_effet<>0 and m_cheque=0 and client_tire_e<>'$vide' group BY client_tire_e;";
	$users12 = db_query($database_name, $sql);


?>


<span style="font-size:24px"><?php echo "Clients douteux : "; ?></span>

<table class="table2">
<td>
<tr>
	
	<th><?php echo "Client";?></th>
	<th><?php echo "Chèques Impayés";?></th>
	
</tr>

<?php 
$compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { 
			$date_remise=$users_1["date_remise"];
			$client=$users_1["client"];$id=$users_1["id_porte_feuille"];
			$client_tire=$users_1["client_tire"];
			$numero_cheque=$users_1["numero_cheque"];$v_banque=$users_1["v_banque"];
			$m_cheques=number_format($users_1["m_cheques"],2,',',' ');$m_effets=$users_1["m_effets"];
				
				

			?><tr>
			
			<td><?php $c_t= "<a href=\"registres_remises_impayes_douteux_details.php?client_tire=$client_tire\">$client_tire</a>";print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$c_t </font>"); ?></td>
			
			<td><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$m_cheques</font>");?></td>
			
						
<? } ?>

</td>

<td>
<tr>
	
	<th><?php echo "Client";?></th>
	<th><?php echo "Effets Impayés";?></th>
	
</tr>

<?php 
$compteur1=0;$total_g=0;
while($users_2 = fetch_array($users12)) { 
			$date_remise=$users_2["date_remise"];
			$client=$users_2["client"];$id=$users_2["id_porte_feuille"];
			$client_tire_e=$users_2["client_tire_e"];
			$numero_cheque=$users_2["numero_cheque"];$v_banque=$users_2["v_banque"];
			$m_cheques=$users_2["m_cheques"];$m_effets=number_format($users_2["m_effets"],2,',',' ');
				
				
			?><tr>
			
			<td><?php $c_t= "<a href=\"registres_remises_impayes_douteux_details_e.php?client_tire=$client_tire_e\">$client_tire_e</a>";print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$c_t </font>"); ?></td>
					
						
			<td align="right"><?php print("<font size=\"2\" face=\"Comic sans MS\" color=\"#000033\">$m_effets </font>");?></td>
			
<? } ?>

</td>

</table>		
	

</body>

</html>