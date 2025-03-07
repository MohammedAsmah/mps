<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$du="";$au="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	
	if(isset($_REQUEST["action_r"])) {
	
	if ($_REQUEST["action_r"]=="reglement"){
	
		
		$id_commande = $_REQUEST["id_commande"];
	 	$sql  = "SELECT * ";
		$sql .= "FROM factures where id='$id_commande' ORDER BY date_f;";$client="";
		$users2 = db_query($database_name, $sql);$users2_ = fetch_array($users2);
		$solde=$users2_["solde"];$client=$users2_["client"];$date_f=$users2_["date_f"];
		$id_registre = $_REQUEST["id_registre"];$montant_e=$_REQUEST["montant_e"];$date_enc=$_REQUEST["date_enc"];
		$vendeur=$_REQUEST["vendeur"];
		$facture=$_REQUEST["id_commande"]+9040;$montant_f=$_REQUEST["montant_e"];
//1er regl		
		$m_cheque0=$_REQUEST["m_cheque0"];$numero_cheque=$_REQUEST["numero_cheque"];
		$date_cheque=dateFrToUs($_REQUEST["date_cheque"]);$v_banque=$_REQUEST["v_banque"];$v_banque_e=$_REQUEST["v_banque_e"];
		$n_banque=$_REQUEST["n_banque"];$client_tire=$_REQUEST["client_tire"];$client_tire_e=$_REQUEST["client_tire_e"];
		$date_remise_cheque=dateFrToUs($_REQUEST["date_cheque"]);$n_banque_e=$_REQUEST["n_banque_e"];if ($client_tire_e==""){$client_tire_e=$client;}
		if ($client_tire==""){$client_tire=$client;}
		$m_cheque1=$_REQUEST["m_cheque1"];$numero_cheque1=$_REQUEST["numero_cheque1"];$date_cheque1=dateFrToUs($_REQUEST["date_cheque1"]);$v_banque1=$_REQUEST["v_banque1"];$client_tire1=$_REQUEST["client_tire1"];
		$m_cheque2=$_REQUEST["m_cheque2"];$numero_cheque2=$_REQUEST["numero_cheque2"];$date_cheque2=dateFrToUs($_REQUEST["date_cheque2"]);$v_banque2=$_REQUEST["v_banque2"];$client_tire2=$_REQUEST["client_tire2"];
		$m_cheque3=$_REQUEST["m_cheque3"];$numero_cheque3=$_REQUEST["numero_cheque3"];$date_cheque3=dateFrToUs($_REQUEST["date_cheque3"]);$v_banque3=$_REQUEST["v_banque3"];$client_tire3=$_REQUEST["client_tire3"];
		$m_cheque4=$_REQUEST["m_cheque4"];$numero_cheque4=$_REQUEST["numero_cheque4"];$date_cheque4=dateFrToUs($_REQUEST["date_cheque4"]);$v_banque4=$_REQUEST["v_banque4"];$client_tire4=$_REQUEST["client_tire4"];
		$m_cheque5=$_REQUEST["m_cheque5"];$numero_cheque5=$_REQUEST["numero_cheque5"];$date_cheque5=dateFrToUs($_REQUEST["date_cheque5"]);$v_banque5=$_REQUEST["v_banque5"];$client_tire5=$_REQUEST["client_tire5"];
		$m_cheque6=$_REQUEST["m_cheque6"];$numero_cheque6=$_REQUEST["numero_cheque6"];$date_cheque6=dateFrToUs($_REQUEST["date_cheque6"]);$v_banque6=$_REQUEST["v_banque6"];$client_tire6=$_REQUEST["client_tire6"];
		$m_cheque7=$_REQUEST["m_cheque7"];$numero_cheque7=$_REQUEST["numero_cheque7"];$date_cheque7=dateFrToUs($_REQUEST["date_cheque7"]);$v_banque7=$_REQUEST["v_banque7"];$client_tire7=$_REQUEST["client_tire7"];
		$m_cheque8=$_REQUEST["m_cheque8"];$numero_cheque8=$_REQUEST["numero_cheque8"];$date_cheque8=dateFrToUs($_REQUEST["date_cheque8"]);$v_banque8=$_REQUEST["v_banque8"];$client_tire8=$_REQUEST["client_tire8"];
		$date_remise_cheque=dateFrToUs($_REQUEST["date_cheque"]);$n_banque=$_REQUEST["n_banque"];
		$date_remise_cheque1=dateFrToUs($_REQUEST["date_cheque1"]);$n_banque1=$_REQUEST["n_banque1"];
		$date_remise_cheque2=dateFrToUs($_REQUEST["date_cheque2"]);$n_banque2=$_REQUEST["n_banque2"];
		$date_remise_cheque3=dateFrToUs($_REQUEST["date_cheque3"]);$n_banque3=$_REQUEST["n_banque3"];
		$date_remise_cheque4=dateFrToUs($_REQUEST["date_cheque4"]);$n_banque4=$_REQUEST["n_banque4"];
		$date_remise_cheque5=dateFrToUs($_REQUEST["date_cheque5"]);$n_banque5=$_REQUEST["n_banque5"];
		$date_remise_cheque6=dateFrToUs($_REQUEST["date_cheque6"]);$n_banque6=$_REQUEST["n_banque6"];
		$date_remise_cheque7=dateFrToUs($_REQUEST["date_cheque7"]);$n_banque7=$_REQUEST["n_banque7"];
		$date_remise_cheque8=dateFrToUs($_REQUEST["date_cheque8"]);$n_banque8=$_REQUEST["n_banque8"];
		$m_cheque_g0=$_REQUEST["m_cheque_g0"];
		$m_cheque_g1=$_REQUEST["m_cheque_g1"];
		$m_cheque_g2=$_REQUEST["m_cheque_g2"];
		$m_cheque_g3=$_REQUEST["m_cheque_g3"];
		$m_cheque_g4=$_REQUEST["m_cheque_g4"];
		$m_cheque_g5=$_REQUEST["m_cheque_g5"];
		$m_cheque_g6=$_REQUEST["m_cheque_g6"];
		$m_cheque_g7=$_REQUEST["m_cheque_g7"];
		$m_cheque_g8=$_REQUEST["m_cheque_g8"];
		if ($m_cheque0<>""){}else{$m_cheque0=$m_cheque_g0;}
		if ($m_cheque1<>""){}else{$m_cheque1=$m_cheque_g1;}
		if ($m_cheque2<>""){}else{$m_cheque2=$m_cheque_g2;}
		if ($m_cheque3<>""){}else{$m_cheque3=$m_cheque_g3;}
		if ($m_cheque4<>""){}else{$m_cheque4=$m_cheque_g4;}
		if ($m_cheque5<>""){}else{$m_cheque5=$m_cheque_g5;}
		if ($m_cheque6<>""){}else{$m_cheque6=$m_cheque_g6;}
		if ($m_cheque7<>""){}else{$m_cheque7=$m_cheque_g7;}
		if ($m_cheque8<>""){}else{$m_cheque8=$m_cheque_g8;}
	
		
//1er regl		
		$m_espece=$_REQUEST["m_espece"];
		
//1er regl		
		$m_effet=$_REQUEST["m_effet"];$numero_effet=$_REQUEST["numero_effet"];$date_echeance=dateFrToUs($_REQUEST["date_echeance"]);
		$date_remise_effet=dateFrToUs($_REQUEST["date_enc"]);
//1er regl		
		$m_avoir=$_REQUEST["m_avoir"];$numero_avoir=$_REQUEST["numero_avoir"];
		$m_diff_prix=$_REQUEST["m_diff_prix"];$obs=$_REQUEST["obs"];
		$m_virement=$_REQUEST["m_virement"];$numero_virement=$_REQUEST["numero_virement"];$date_virement=dateFrToUs($_REQUEST["date_virement"]);
		$v_banque_v=$_REQUEST["v_banque_v"];$evaluation=0;

		$solde=$solde+($m_cheque0+$m_cheque1+$m_cheque2+$m_cheque3+$m_cheque4+$m_cheque5+$m_cheque6+$m_cheque7+$m_cheque8+$m_espece+$m_effet+$m_avoir+$m_diff_prix+$m_virement);
		
		$montant_enc=($m_cheque0+$m_cheque1+$m_cheque2+$m_cheque3+$m_cheque4+$m_cheque5+$m_cheque6+$m_cheque7+$m_cheque8+$m_espece+$m_effet+$m_avoir+$m_diff_prix+$m_virement);

			$sql = "UPDATE factures SET ";$valider_f=1;$oui=1;
			$sql .= "id_registre_regl = '" . $id_registre . "', ";
			$sql .= "solde = '" . $solde . "' ";
			$sql .= "WHERE id = " . $id_commande . ";";
			db_query($database_name, $sql);
			if ($m_cheque0<>0){$chq_f=1;}else{$chq_f=0;}
			if ($m_effet<>0){$eff_f=1;}else{$eff_f=0;}
	
		if ($m_cheque0<>0){
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,id_commande,date_e,client ,client_tire,client_tire_e,n_banque,n_banque_e,v_banque,v_banque_e,v_banque_v,date_enc,id_registre_regl,
	facture_n,montant_f,montant_e,date_cheque,date_echeance,date_virement,date_remise_cheque,date_remise_effet,m_cheque,chq_f,eff_f,m_cheque_g,
	numero_cheque,numero_virement,numero_effet,numero_avoir )
	VALUES ('$vendeur','$id_commande','$date_f','$client','$client_tire','$client_tire_e','$n_banque','$n_banque_e','$v_banque','$v_banque_e','$v_banque_v',
	'$date_enc','$id_registre','$facture','$montant_f','$montant_e','$date_cheque','$date_echeance','$date_virement','$date_remise_cheque',
	'$date_remise_effet','$m_cheque0','$chq_f','$eff_f','$m_cheque_g0','$numero_cheque','$numero_virement','$numero_effet','$numero_avoir')";
	db_query($database_name, $sql1);}
	
	if ($m_espece<>0){
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,id_commande,date_e,client ,client_tire,client_tire_e,n_banque,n_banque_e,v_banque,v_banque_e,v_banque_v,date_enc,id_registre_regl,
	facture_n,montant_f,montant_e,date_cheque,date_echeance,date_virement,date_remise_cheque,date_remise_effet,m_espece,
	m_avoir,m_diff_prix,obs_diff_prix,numero_cheque,numero_virement,numero_effet,numero_avoir )
	VALUES ('$vendeur','$id_commande','$date_f','$client','$client_tire','$client_tire_e','$n_banque','$n_banque_e','$v_banque','$v_banque_e','$v_banque_v',
	'$date_enc','$id_registre','$facture','$montant_f','$montant_e','$date_cheque','$date_echeance','$date_virement','$date_remise_cheque',
	'$date_remise_effet','$m_espece','$m_avoir','$m_diff_prix','$obs','$numero_cheque','$numero_virement','$numero_effet','$numero_avoir')";
	db_query($database_name, $sql1);}
	
	if ($m_effet<>0){
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,id_commande,date_e,client ,client_tire,client_tire_e,n_banque,n_banque_e,v_banque,v_banque_e,v_banque_v,date_enc,id_registre_regl,
	facture_n,montant_f,montant_e,date_cheque,date_echeance,date_virement,date_remise_cheque,date_remise_effet,m_effet,numero_cheque,numero_virement,numero_effet,numero_avoir )
	VALUES ('$vendeur','$id_commande','$date_f','$client','$client_tire','$client_tire_e','$n_banque','$n_banque_e','$v_banque','$v_banque_e','$v_banque_v',
	'$date_enc','$id_registre','$facture','$montant_f','$montant_e','$date_cheque','$date_echeance','$date_virement','$date_remise_cheque',
	'$date_remise_effet','$m_effet','$numero_cheque','$numero_virement','$numero_effet','$numero_avoir')";
	db_query($database_name, $sql1);}
	
	if ($m_virement<>0){
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,id_commande,date_e,client ,client_tire,client_tire_e,n_banque,n_banque_e,v_banque,v_banque_e,v_banque_v,date_enc,id_registre_regl,
	facture_n,montant_f,montant_e,date_cheque,date_echeance,date_virement,date_remise_cheque,date_remise_effet,m_virement,numero_cheque,numero_virement,numero_effet,numero_avoir )
	VALUES ('$vendeur','$id_commande','$date_f','$client','$client_tire','$client_tire_e','$n_banque','$n_banque_e','$v_banque','$v_banque_e','$v_banque_v',
	'$date_enc','$id_registre','$facture','$montant_f','$montant_e','$date_cheque','$date_echeance','$date_virement','$date_remise_cheque',
	'$date_remise_effet','$m_virement','$numero_cheque','$numero_virement','$numero_effet','$numero_avoir')";
	db_query($database_name, $sql1);}
	
	
	
	$impaye=0;
	
	if ($m_cheque1<>"")
	{if ($client_tire1==""){$client_tire1=$client;}
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,impaye,id_commande,date_e,client ,client_tire,n_banque,v_banque,date_enc,id_registre_regl,facture_n,montant_f,evaluation,montant_e,date_cheque,date_remise_cheque,m_cheque,m_cheque_g,numero_cheque )
	VALUES
	('$vendeur','$impaye','$id_commande','$date_f','$client','$client_tire1','$n_banque1','$v_banque1','$date_enc','$id_registre','$facture','$montant_f',
	'$evaluation','$montant_e','$date_cheque1','$date_remise_cheque1','$m_cheque1','$m_cheque_g1','$numero_cheque1')";
	db_query($database_name, $sql1);
	}
	if ($m_cheque2<>"")
	{if ($client_tire2==""){$client_tire2=$client;}
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,impaye,id_commande,date_e,client ,client_tire,n_banque,v_banque,date_enc,id_registre_regl,facture_n,montant_f,evaluation,montant_e,date_cheque,date_remise_cheque,m_cheque,m_cheque_g,numero_cheque )
	VALUES
	('$vendeur','$impaye','$id_commande','$date_f','$client','$client_tire2','$n_banque2','$v_banque2','$date_enc','$id_registre','$facture','$montant_f',
	'$evaluation','$montant_e','$date_cheque2','$date_remise_cheque2','$m_cheque2','$m_cheque_g2','$numero_cheque2')";
	db_query($database_name, $sql1);
	}
		if ($m_cheque3<>"")
	{if ($client_tire3==""){$client_tire3=$client;}
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,impaye,id_commande,date_e,client ,client_tire,n_banque,v_banque,date_enc,id_registre_regl,facture_n,montant_f,evaluation,montant_e,date_cheque,date_remise_cheque,m_cheque,m_cheque_g,numero_cheque )
	VALUES
	('$vendeur','$impaye','$id_commande','$date_f','$client','$client_tire3','$n_banque3','$v_banque3','$date_enc','$id_registre','$facture','$montant_f',
	'$evaluation','$montant_e','$date_cheque3','$date_remise_cheque3','$m_cheque3','$m_cheque_g3','$numero_cheque3')";
	db_query($database_name, $sql1);
	}
	if ($m_cheque4<>"")
	{if ($client_tire4==""){$client_tire4=$client;}
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,impaye,id_commande,date_e,client ,client_tire,n_banque,v_banque,date_enc,id_registre_regl,facture_n,montant_f,evaluation,montant_e,date_cheque,date_remise_cheque,m_cheque,m_cheque_g,numero_cheque )
	VALUES
	('$vendeur','$impaye','$id_commande','$date_f','$client','$client_tire4','$n_banque4','$v_banque4','$date_enc','$id_registre','$facture','$montant_f',
	'$evaluation','$montant_e','$date_cheque4','$date_remise_cheque4','$m_cheque4','$m_cheque_g4','$numero_cheque4')";
	db_query($database_name, $sql1);
	}
	if ($m_cheque5<>"")
	{if ($client_tire5==""){$client_tire5=$client;}
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,impaye,id_commande,date_e,client ,client_tire,n_banque,v_banque,date_enc,id_registre_regl,facture_n,montant_f,evaluation,montant_e,date_cheque,date_remise_cheque,m_cheque,m_cheque_g,numero_cheque )
	VALUES
	('$vendeur','$impaye','$id_commande','$date_f','$client','$client_tire5','$n_banque5','$v_banque5','$date_enc','$id_registre','$facture','$montant_f',
	'$evaluation','$montant_e','$date_cheque5','$date_remise_cheque5','$m_cheque5','$m_cheque_g5','$numero_cheque5')";
	db_query($database_name, $sql1);
	}
	if ($m_cheque6<>"")
	{if ($client_tire6==""){$client_tire6=$client;}
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,impaye,id_commande,date_e,client ,client_tire,n_banque,v_banque,date_enc,id_registre_regl,facture_n,montant_f,evaluation,montant_e,date_cheque,date_remise_cheque,m_cheque,m_cheque_g,numero_cheque )
	VALUES
	('$vendeur','$impaye','$id_commande','$date_f','$client','$client_tire6','$n_banque6','$v_banque6','$date_enc','$id_registre','$facture','$montant_f',
	'$evaluation','$montant_e','$date_cheque6','$date_remise_cheque6','$m_cheque6','$m_cheque_g6','$numero_cheque6')";
	db_query($database_name, $sql1);
	}
	if ($m_cheque7<>"")
	{if ($client_tire7==""){$client_tire7=$client;}
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,impaye,id_commande,date_e,client ,client_tire,n_banque,v_banque,date_enc,id_registre_regl,facture_n,montant_f,evaluation,montant_e,date_cheque,date_remise_cheque,m_cheque,m_cheque_g,numero_cheque )
	VALUES
	('$vendeur','$impaye','$id_commande','$date_f','$client','$client_tire7','$n_banque7','$v_banque7','$date_enc','$id_registre','$facture','$montant_f',
	'$evaluation','$montant_e','$date_cheque7','$date_remise_cheque7','$m_cheque7','$m_cheque_g7','$numero_cheque7')";
	db_query($database_name, $sql1);
	}
	if ($m_cheque8<>"")
	{if ($client_tire8==""){$client_tire8=$client;}
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,impaye,id_commande,date_e,client ,client_tire,n_banque,v_banque,date_enc,id_registre_regl,facture_n,montant_f,evaluation,montant_e,date_cheque,date_remise_cheque,m_cheque,m_cheque_g,numero_cheque )
	VALUES
	('$vendeur','$impaye','$id_commande','$date_f','$client','$client_tire8','$n_banque8','$v_banque8','$date_enc','$id_registre','$facture','$montant_f',
	'$evaluation','$montant_e','$date_cheque8','$date_remise_cheque8','$m_cheque8','$m_cheque_g8','$numero_cheque8')";
	db_query($database_name, $sql1);
	}
	
	
	}
	else
	///mise à jour reglments //////////////////////////////
	{
		$id_registre = $_REQUEST["id_registre"];$vendeur=$_REQUEST["vendeur"];
		$montant_f=$_REQUEST["montant_e"];$id = $_REQUEST["id"];$montant_e=$_REQUEST["montant_e"];
//1er regl		
		$m_cheque=$_REQUEST["m_cheque"];$numero_cheque=$_REQUEST["numero_cheque"];$m_cheque_g=$_REQUEST["m_cheque_g"];
		if ($m_cheque<>""){}else{$m_cheque=$m_cheque_g;}
		$date_cheque=dateFrToUs($_REQUEST["date_cheque"]);$v_banque=$_REQUEST["v_banque"];$v_banque_e=$_REQUEST["v_banque_e"];
		$n_banque=$_REQUEST["n_banque"];$client_tire=$_REQUEST["client_tire"];$client_tire_e=$_REQUEST["client_tire_e"];
		$date_remise_cheque=dateFrToUs($_REQUEST["date_cheque"]);$n_banque_e=$_REQUEST["n_banque_e"];$date_echeance=dateFrToUs($_REQUEST["date_echeance"]);
		
//1er regl		
		$m_espece=$_REQUEST["m_espece"];
		
//1er regl		
		$m_effet=$_REQUEST["m_effet"];$numero_effet=$_REQUEST["numero_effet"];
		
//1er regl		
		$m_avoir=$_REQUEST["m_avoir"];$numero_avoir=$_REQUEST["numero_avoir"];
		$m_diff_prix=$_REQUEST["m_diff_prix"];$obs=$_REQUEST["obs"];
		$m_virement=$_REQUEST["m_virement"];$numero_virement=$_REQUEST["numero_virement"];$date_virement=dateFrToUs($_REQUEST["date_virement"]);
		$v_banque_v=$_REQUEST["v_banque_v"];
			
			$sql = "UPDATE porte_feuilles SET ";
			$sql .= "m_cheque = '" . $m_cheque . "', ";
			$sql .= "m_cheque_g = '" . $m_cheque_g . "', ";
			$sql .= "m_virement = '" . $m_virement . "', ";
			$sql .= "date_virement = '" . $date_virement . "', ";
			$sql .= "numero_virement = '" . $numero_virement . "', ";
			$sql .= "v_banque_v = '" . $v_banque_v . "', ";
			$sql .= "m_espece = '" . $m_espece . "', ";
			$sql .= "m_effet = '" . $m_effet . "', ";
			$sql .= "m_avoir = '" . $m_avoir . "', ";
			$sql .= "m_diff_prix = '" . $m_diff_prix . "', ";
			$sql .= "v_banque = '" . $v_banque . "', ";
			$sql .= "montant_e = '" . $montant_e . "', ";
			$sql .= "montant_f = '" . $montant_f . "', ";
			$sql .= "date_cheque = '" . $date_cheque . "', ";
			$sql .= "date_echeance = '" . $date_echeance . "', ";
			$sql .= "client_tire = '" . $client_tire . "', ";
			$sql .= "client_tire_e = '" . $client_tire_e . "', ";
			$sql .= "v_banque_e = '" . $v_banque_e . "', ";
			$sql .= "numero_effet = '" . $numero_effet . "', ";
			$sql .= "numero_cheque = '" . $numero_cheque . "' ";
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);

	
	}
			
	if ($vendeur=="CAISSE" or $vendeur=="VENTE USINE"){$v1="CAISSE";$v2="VENTE USINE";
	
	$sql  = "SELECT * ";$instance="FACTURE EN INSTANCE";
	$sql .= "FROM factures where (vendeur='$v1' or vendeur='$v2' ) and client<>'$instance' ORDER BY date_f;";
	$users = db_query($database_name, $sql);
	}
	else
	{
	$sql  = "SELECT * ";$instance="FACTURE EN INSTANCE";
	$sql .= "FROM factures where vendeur='$vendeur' and client<>'$instance' ORDER BY date_f;";
	$users = db_query($database_name, $sql);
	}
	
	}
	else
	{

	$id_registre=$_GET['id_registre'];
	$date=$_GET['date_enc'];$date3=$_GET['date_enc'];$date_enc=$_GET['date_enc'];$date_enc2=$_GET['date_enc'];
	$vendeur=$_GET['vendeur'];		$date1=$_GET['date1'];$vendeur=$_GET['vendeur'];$date2=$_GET['date2'];

	if ($vendeur=="CAISSE" or $vendeur=="VENTE USINE"){$v1="CAISSE";$v2="VENTE USINE";
	$sql  = "SELECT * ";$instance="FACTURE EN INSTANCE";
	$sql .= "FROM factures where (vendeur='$v1' or vendeur='$v2' ) and client<>'$instance' ORDER BY date_f;";
	$users = db_query($database_name, $sql);
	}
	else
	{
	$sql  = "SELECT * ";$instance="FACTURE EN INSTANCE";
	$sql .= "FROM factures where vendeur='$vendeur' and client<>'$instance' ORDER BY date_f;";
	$users = db_query($database_name, $sql);
	}
	
	
	}
	$sql  = "SELECT *";
	$sql .= "FROM porte_feuilles where id_registre_regl='$id_registre' and impaye=0 Order BY id;";
	$users11 = db_query($database_name, $sql);
	
	?>
	
<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo "Facture";?></th>
	<th><?php echo "Montant Facture";?></th>
	<th bgcolor="#33CC66"><?php echo "Avoir";?></th>
	<th bgcolor="#33CC66"><?php echo "Diff/Prix";?></th>
	<th bgcolor="#3366FF"><?php echo "ESPECE";?></th>
	<th bgcolor="#3366FF"><?php echo "CHEQUE";?></th>
	<th bgcolor="#3366FF"><?php echo "EFFET";?></th>
	<th bgcolor="#3366FF"><?php echo "VIREMENT";?></th>
</tr>

<?php $compteur1=0;$total_g=0;$t_espece=0;
while($users_1 = fetch_array($users11)) { 
			$id_r=$users_1["id"];$date_enc1=$users_1["date_enc"];$vendeur=$users_1["vendeur"];$date_enc2=$users_1["date_enc"];
			$client=$users_1["client"];$facture=$users_1["facture_n"];$montant_e=$users_1["montant_e"];
			$mode=$users_1["mode"];$m_cheque=$users_1["m_cheque"];$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];
			$ref=$v_banque." ".$numero_cheque;$m_espece=$users_1["m_espece"];$m_effet=$users_1["m_effet"];$m_avoir=$users_1["m_avoir"];
			$m_diff_prix=$users_1["m_diff_prix"];$m_virement=$users_1["m_virement"];?>
			<tr>
			<? echo "<td><a href=\"evaluation_vers_reglement1_f.php?id=$id_r&id_registre=$id_registre&vendeur=$vendeur&client=$client&montant=$montant_e\">$client</a></td>";?>
			<td><?php echo $facture; ?></td>
			<td align="right"><?php echo number_format($montant_e,2,',',' '); ?></td>
			<td align="right"><?php echo number_format($m_avoir,2,',',' '); ?></td>
			<td align="right"><?php echo number_format($m_diff_prix,2,',',' '); ?></td>
			<td align="right"><?php $t_espece=$t_espece+$m_espece;echo number_format($m_espece,2,',',' '); ?></td>
			<td align="right"><?php echo number_format($m_cheque,2,',',' '); ?></td>
			<td align="right"><?php echo number_format($m_effet,2,',',' '); ?></td>
			<td align="right"><?php echo number_format($m_virement,2,',',' '); ?></td>
<? } ?>
<tr><td bgcolor=""></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>

</table>

	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Factures"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "detail_evaluation.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "liste Factures"; ?></span>
<tr>
<td><?php echo $vendeur ;?></td>
			<? /*echo "<td><a href=\"tableau_enc1.php?id_registre=$id_registre\">Editer Tableau</a></td>";*/?>
<? echo "<td><a href=\"\\mps\\tutorial\\tableau_encaissement1.php?id_registre=$id_registre\">-->Editer Tableau</a></td>";?>
<? $action_l="l";echo "<td><a href=\"registres_reglements.php?action_l=$action_l&vendeur=$vendeur&date1=$date1&date2=$date2\">-->Retour Liste Tableaux</a></td>";?>
</tr>

<table class="table2">

<tr>
	<th><?php echo "Facture";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Net";?></th>
</tr>

<?php 

$total_g=0;
while($users_ = fetch_array($users)) { ?><tr>
	<? $client=$users_["client"];$date=dateUsToFr($users_["date_f"]);
	$vendeur=$users_["vendeur"];$id_commande=$users_["id"];$solde=$users_["solde"];$num=$id_commande+9040;
	echo "<td>$num</td>";?>
	<?php $id=$users_["id"];?>
	<td><?php echo $date; ?></td>
	<td><?php echo $users_["client"]; ?></td>
	<td style="text-align:Right"><?php $net=$users_["montant"];echo number_format($net,2,',',' '); ?></td>
	<? echo "<td><a href=\"evaluation_vers_reglement_f.php?id_registre=$id_registre&montant=$net&id_commande=$id_commande&vendeur=$vendeur&client=$client&date_enc=$date_enc2\">valider</a></td>";?>

<?php } ?>

<tr><td></td><td></td><td></td><td></td>
<td style="text-align:Right"><?php echo number_format($total_g,2,',',' '); ?></td>
</tr>

</table>
<tr>
</tr>

<p style="text-align:center">

</body>

</html>