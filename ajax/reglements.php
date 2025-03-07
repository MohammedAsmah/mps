<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$user_login = $user_["login"];
	$error_message = "";$du="";$au="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;
	$id_registre=$_GET['id_registre'];
	$date_enc=$_GET['date_enc'];
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_d"])) {
		
			if ($_REQUEST["action_d"]=="delete"){
			$id = $_REQUEST["id"];$id_registre = $_REQUEST["id_registre"];$vendeur = $_REQUEST["vendeur"];
			$date1 = $_REQUEST["date1"];$date2 = $_REQUEST["date2"];
			$sql = "DELETE FROM porte_feuilles WHERE id = " . $_REQUEST["id"] . ";";
			db_query($database_name, $sql);
			
			
			$sql1 = "DELETE FROM porte_feuilles_factures WHERE id_porte_feuille = " . $_REQUEST["id"] . ";";
			db_query($database_name, $sql1);
			
			
			}

	}
	
	if(isset($_REQUEST["action_r"])) {
	
	if ($_REQUEST["action_r"]=="reglement"){
	
		$id_commande = $_REQUEST["id_commande"];
	 	$sql  = "SELECT * ";
		$sql .= "FROM commandes where id='$id_commande' and escompte_exercice=0 ORDER BY date_e;";$client="";
		$users2 = db_query($database_name, $sql);$users2_ = fetch_array($users2);
		$solde=$users2_["solde"];$client=$users2_["client"];$evaluation=$users2_["evaluation"];$date_e=$users2_["date_e"];
		$id_registre = $_REQUEST["id_registre"];$montant_e=$_REQUEST["montant_e"];$date_enc=$_REQUEST["date_enc"];
		$facture=$_REQUEST["facture_n"];$montant_f=0;
		
		
		
		
		
		
		
		
		
		$sql  = "SELECT * ";
		$sql .= "FROM factures2024 where numero='$facture' order BY id;";
		$users = db_query($database_name, $sql);
		$user_ = fetch_array($users);$montant_f = $user_["montant"];$date_facture = $user_["date_f"];
		
		
		$vendeur=$_REQUEST["vendeur"];$eval=$_REQUEST["eval"];
		
//1er regl		
		$m_cheque0=$_REQUEST["m_cheque0"];$numero_cheque=$_REQUEST["numero_cheque"];$date_cheque=dateFrToUs($_REQUEST["date_cheque"]);
		$v_banque=$_REQUEST["v_banque"];$client_tire=$_REQUEST["client_tire"];
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

		if(isset($_REQUEST["chq_f"])) { $chq_f = 1; } else { $chq_f = 0; }
		if(isset($_REQUEST["chq_e"])) { $chq_e = 1; } else { $chq_e = 0; }
		
		if(isset($_REQUEST["chq_f1"])) { $chq_f1 = 1; } else { $chq_f1 = 0; }
		if(isset($_REQUEST["chq_e1"])) { $chq_e1 = 1; } else { $chq_e1 = 0; }
		
		if(isset($_REQUEST["chq_f2"])) { $chq_f2 = 1; } else { $chq_f2 = 0; }
		if(isset($_REQUEST["chq_e2"])) { $chq_e2 = 1; } else { $chq_e2 = 0; }
		
		if(isset($_REQUEST["chq_f3"])) { $chq_f3 = 1; } else { $chq_f3 = 0; }
		if(isset($_REQUEST["chq_e3"])) { $chq_e3 = 1; } else { $chq_e3 = 0; }
		
		
		if(isset($_REQUEST["eff_f"])) { $eff_f = 1; } else { $eff_f = 0; }
		if(isset($_REQUEST["eff_e"])) { $eff_e = 1; } else { $eff_e = 0; }
		
		if(isset($_REQUEST["esp_f"])) { $esp_f = 1; } else { $esp_f = 0; }
		if(isset($_REQUEST["esp_e"])) { $esp_e = 1; } else { $esp_e = 0; }
		
		if(isset($_REQUEST["vir_f"])) { $vir_f = 1; } else { $vir_f = 0; }
		if(isset($_REQUEST["vir_e"])) { $vir_e = 1; } else { $vir_e = 0; }
		
		$v_banque_e=$_REQUEST["v_banque_e"];
		$client_tire_e=$_REQUEST["client_tire_e"];if ($client_tire_e==""){$client_tire_e=$client;}
		if ($client_tire==""){$client_tire=$client;}
		$date_remise_cheque=dateFrToUs($_REQUEST["date_cheque"]);$n_banque_e=$_REQUEST["n_banque_e"];
		
		$m_virement=$_REQUEST["m_virement"];$numero_virement=$_REQUEST["numero_virement"];
		$date_virement=dateFrToUs($_REQUEST["date_virement"]);
		$v_banque_v=$_REQUEST["v_banque_v"];
//1er regl		
		$m_espece=$_REQUEST["m_espece"];
		
//1er regl		
		$m_effet=$_REQUEST["m_effet"];$numero_effet=$_REQUEST["numero_effet"];$date_echeance=dateFrToUs($_REQUEST["date_echeance"]);
		$date_remise_effet=dateFrToUs($_REQUEST["date_enc"]);
//1er regl		
		$m_avoir=$_REQUEST["m_avoir"];$numero_avoir=$_REQUEST["numero_avoir"];
		
		
		
		
		
		
		$m_diff_prix=$_REQUEST["m_diff_prix"];$obs=$_REQUEST["obs"];


		$solde=$solde+($m_cheque0+$m_cheque1+$m_cheque2+$m_cheque3+$m_cheque4+$m_cheque5+$m_cheque6+$m_cheque7+$m_cheque8+$m_espece+$m_effet+$m_avoir+$m_diff_prix+$m_virement);
		
		$montant_enc=($m_cheque0+$m_cheque1+$m_cheque2+$m_cheque3+$m_cheque4+$m_cheque5+$m_cheque6+$m_cheque7+$m_cheque8+$m_espece+$m_effet+$m_avoir+$m_diff_prix+$m_virement);

			$sql = "UPDATE commandes SET ";$valider_f=1;$oui=1;
			$sql .= "id_registre_regl = '" . $id_registre . "', ";
			$sql .= "montant_reg = '" . $montant_enc . "', ";
			$sql .= "facture_n = '" . $facture . "', ";
			$sql .= "solde = '" . $solde . "' ";
			$sql .= "WHERE id = " . $id_commande . ";";
			db_query($database_name, $sql);
			
				


		// cheque 
		if ($m_cheque0<>0){
			
			//recherche doublons cheques
			$sql  = "SELECT * ";
			$sql .= "FROM porte_feuilles where numero_cheque='$numero_cheque';";
			$users111 = db_query($database_name, $sql);$users_111 = fetch_array($users111);
			$numero_cheque_ancien=$users_111["numero_cheque"];
			if ($numero_cheque_ancien == $numero_cheque){$t = rand(2, 8);$numero_cheque = $numero_cheque."-".$t;}
			
			
			
			
		if ($chq_f==1){}else{$facture=0;}
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,
	id_commande,
	date_e,
	client ,
	client_tire,
	
	n_banque,
	n_banque_e,
	v_banque,
	v_banque_e,
	v_banque_v,
	date_enc,
	id_registre_regl,
	facture_n,
	montant_f,
	evaluation,
	montant_e,
	date_cheque,
	
	
	date_remise_cheque,
	
	m_cheque,chq_f,chq_e,
	m_cheque_g,
	
	
	
	numero_cheque
	
	 )
	VALUES ('$vendeur',
	'$id_commande',$date_e,
	'$client',
	'$client_tire',
	
	'$n_banque',
	'$n_banque_e',
	'$v_banque',
	'$v_banque_e',
	'$v_banque_v',
	'$date_enc',
	'$id_registre',
	'$facture',
	'$montant_f',
	'$eval'
	,'$montant_e',
	'$date_cheque',
	
	'$date_remise_cheque',
	
	'$m_cheque0','$chq_f','$chq_e',
	'$m_cheque_g0',
		
	'$numero_cheque'
	
	)";
	db_query($database_name, $sql1);
	}
	
	// effet
	if ($m_effet<>0){$numero_cheque_v=0;
	
	//recherche doublons effet
	$sql  = "SELECT * ";
			$sql .= "FROM porte_feuilles where numero_effet='$numero_effet';";
			$users111 = db_query($database_name, $sql);$users_111 = fetch_array($users111);
			$numero_effet_ancien=$users_111["numero_effet"];
			if ($numero_effet_ancien == $numero_effet){$t = rand(2, 8);$numero_effet = $numero_effet."-".$t;}
	
	if ($eff_f==1){}else{$facture=0;}
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,
	id_commande,
	date_e,
	client ,
	
	client_tire_e,
	n_banque,
	n_banque_e,
	v_banque,
	v_banque_e,
	v_banque_v,
	date_enc,
	id_registre_regl,
	facture_n,
	montant_f,
	evaluation,
	montant_e,
	
	date_echeance,
	
	date_remise_effet,
	
	m_effet,eff_f,eff_e,
	numero_cheque,
	
	numero_effet
	 )
	VALUES ('$vendeur',
	'$id_commande',$date_e,
	'$client',
	
	'$client_tire_e',
	'$n_banque',
	'$n_banque_e',
	'$v_banque',
	'$v_banque_e',
	'$v_banque_v',
	'$date_enc',
	'$id_registre',
	'$facture',
	'$montant_f',
	'$eval'
	,'$montant_e',
	
	'$date_echeance',
	
	'$date_remise_effet',
	
	'$m_effet','$eff_f','$eff_e',
	'$numero_cheque_v',
	
	'$numero_effet'
	)";
	db_query($database_name, $sql1);
	}
	
	// virement
	if ($m_virement<>0){$numero_cheque_v=0;
	$enc_facture1=1;$enc_facture3=$user_login;$enc_facture2=date("d/m/Y");
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,id_commande,date_e,client ,client_tire,n_banque,v_banque,v_banque_v,date_enc,id_registre_regl,facture_n,montant_f,evaluation,montant_e,date_virement,m_virement,numero_cheque,vir_f,vir_e,
	
	numero_virement,enc_facture1,enc_facture2,enc_facture3
	 )
	VALUES ('$vendeur','$id_commande',$date_e,'$client','$client_tire','$n_banque','$v_banque','$v_banque_v','$date_enc','$id_registre','$facture','$montant_f','$eval','$montant_e','$date_virement',
	
	'$m_virement','$numero_cheque_v','$vir_f','$vir_e','$numero_virement','$enc_facture1','$enc_facture2','$enc_facture3')";
	db_query($database_name, $sql1);$id_porte_feuille=mysql_insert_id();
	}
	if ($m_virement<>0){$numero_cheque_v=0;
	
	$sql1  = "INSERT INTO porte_feuilles_factures 
	(vendeur,id_porte_feuille,date_e,client ,client_tire,n_banque,v_banque,v_banque_v,date_enc,id_registre_regl,facture_n,date_f,montant_f,evaluation,montant_e,date_virement,m_virement,numero_cheque,numero_virement)
	VALUES ('$vendeur','$id_porte_feuille',$date_e,'$client','$client_tire','$n_banque','$v_banque','$v_banque_v','$date_enc','$id_registre','$facture','$date_facture','$montant_f','$eval','$montant_e','$date_virement','$m_virement','$numero_cheque_v','$numero_virement')";
	db_query($database_name, $sql1);
	
	}
	
	
	
	
	// espece
	if ($m_espece<>0){$numero_cheque_v=0;
	if ($esp_f==1){$enc_facture1=1;$enc_facture3=$user_login;$enc_facture2=date("d/m/Y");}else{$facture=0;$enc_facture1=0;$enc_facture3="";$enc_facture2="";}
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,id_commande,date_e,client ,client_tire,client_tire_e,n_banque,	n_banque_e,	v_banque,v_banque_e,v_banque_v,date_enc,id_registre_regl,facture_n,montant_f,evaluation,montant_e,m_espece,
	esp_f,esp_e,m_avoir,m_diff_prix,obs_diff_prix,numero_cheque,numero_avoir,enc_facture1,enc_facture2,enc_facture3 )
	VALUES ('$vendeur','$id_commande',$date_e,'$client','$client_tire','$client_tire_e','$n_banque','$n_banque_e','$v_banque','$v_banque_e','$v_banque_v','$date_enc','$id_registre','$facture',
	'$montant_f','$eval','$montant_e','$m_espece','$esp_f','$esp_e','$m_avoir','$m_diff_prix','$obs','$numero_cheque_v','$numero_avoir','$enc_facture1','$enc_facture2','$enc_facture3')";
	db_query($database_name, $sql1);$id_porte_feuille=mysql_insert_id();
	}
	if ($m_espece<>0){$numero_cheque_v=0;
	if ($esp_f==1){
	$sql1  = "INSERT INTO porte_feuilles_factures 
	(vendeur,id_porte_feuille,date_e,client,date_enc,id_registre_regl,facture_n,date_f,montant_f,evaluation,montant_e,m_espece)
	VALUES ('$vendeur','$id_porte_feuille',$date_e,'$client','$date_enc','$id_registre','$facture','$date_facture','$montant_f','$eval','$montant_e','$m_espece')";
	db_query($database_name, $sql1);
	}
	}
	
	
	
	$impaye=0;
	
	if ($m_cheque1<>"")
	{
		//recherche doublons cheques
			$sql  = "SELECT * ";
			$sql .= "FROM porte_feuilles where numero_cheque='$numero_cheque1';";
			$users111 = db_query($database_name, $sql);$users_111 = fetch_array($users111);
			$numero_cheque_ancien1=$users_111["numero_cheque"];
			if ($numero_cheque_ancien1 == $numero_cheque1){$t = rand(2, 8);$numero_cheque1 = $numero_cheque1."-".$t;}
		
		if ($client_tire1==""){$client_tire1=$client;}
	if ($chq_f1==1){}else{$facture=0;}
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,impaye,id_commande,date_e,client ,client_tire,n_banque,v_banque,date_enc,id_registre_regl,facture_n,montant_f,evaluation,montant_e,date_cheque,date_remise_cheque,
	m_cheque,chq_f,chq_e,numero_cheque )
	VALUES
	('$vendeur','$impaye','$id_commande','$date_e','$client','$client_tire1','$n_banque1','$v_banque1','$date_enc','$id_registre','$facture','$montant_f',
	'$evaluation','$montant_e','$date_cheque1','$date_remise_cheque1','$m_cheque1','$chq_f1','$chq_e1','$numero_cheque1')";
	db_query($database_name, $sql1);
	}
	
	
	if ($m_cheque2<>"")
	{
		//recherche doublons cheques
			$sql  = "SELECT * ";
			$sql .= "FROM porte_feuilles where numero_cheque='$numero_cheque2';";
			$users111 = db_query($database_name, $sql);$users_111 = fetch_array($users111);
			$numero_cheque_ancien2=$users_111["numero_cheque"];
			if ($numero_cheque_ancien2 == $numero_cheque2){$t = rand(2, 8);$numero_cheque2 = $numero_cheque2."-".$t;}
		
		if ($client_tire2==""){$client_tire2=$client;}
	if ($chq_f2==1){}else{$facture=0;}
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,impaye,id_commande,date_e,client ,client_tire,n_banque,v_banque,date_enc,id_registre_regl,facture_n,montant_f,evaluation,montant_e,date_cheque,date_remise_cheque,
	m_cheque,chq_f,chq_e,numero_cheque )
	VALUES
	('$vendeur','$impaye','$id_commande','$date_e','$client','$client_tire2','$n_banque2','$v_banque2','$date_enc','$id_registre','$facture','$montant_f',
	'$evaluation','$montant_e','$date_cheque2','$date_remise_cheque2','$m_cheque2','$chq_f2','$chq_e2','$numero_cheque2')";
	db_query($database_name, $sql1);
	}
	
	
		if ($m_cheque3<>"")
	{if ($client_tire3==""){$client_tire3=$client;}
	if ($chq_f3==1){}else{$facture=0;}
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,impaye,id_commande,date_e,client ,client_tire,n_banque,v_banque,date_enc,id_registre_regl,facture_n,montant_f,evaluation,montant_e,date_cheque,date_remise_cheque,
	m_cheque,chq_f,chq_e,numero_cheque )
	VALUES
	('$vendeur','$impaye','$id_commande','$date_e','$client','$client_tire3','$n_banque3','$v_banque3','$date_enc','$id_registre','$facture','$montant_f',
	'$evaluation','$montant_e','$date_cheque3','$date_remise_cheque3','$m_cheque3','$chq_f3','$chq_e3','$numero_cheque3')";
	db_query($database_name, $sql1);
	}
	
	
	if ($m_cheque4<>"")
	{if ($client_tire4==""){$client_tire4=$client;}
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,impaye,id_commande,date_e,client ,client_tire,n_banque,v_banque,date_enc,id_registre_regl,facture_n,montant_f,evaluation,montant_e,date_cheque,date_remise_cheque,m_cheque,numero_cheque )
	VALUES
	('$vendeur','$impaye','$id_commande','$date_e','$client','$client_tire4','$n_banque4','$v_banque4','$date_enc','$id_registre','$facture','$montant_f',
	'$evaluation','$montant_e','$date_cheque4','$date_remise_cheque4','$m_cheque4','$numero_cheque4')";
	db_query($database_name, $sql1);
	}
	if ($m_cheque5<>"")
	{if ($client_tire6==""){$client_tire6=$client;}
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,impaye,id_commande,date_e,client ,client_tire,n_banque,v_banque,date_enc,id_registre_regl,facture_n,montant_f,evaluation,montant_e,date_cheque,date_remise_cheque,m_cheque,numero_cheque )
	VALUES
	('$vendeur','$impaye','$id_commande','$date_e','$client','$client_tire5','$n_banque5','$v_banque5','$date_enc','$id_registre','$facture','$montant_f',
	'$evaluation','$montant_e','$date_cheque5','$date_remise_cheque5','$m_cheque5','$numero_cheque5')";
	db_query($database_name, $sql1);
	}
	if ($m_cheque6<>"")
	{if ($client_tire7==""){$client_tire7=$client;}
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,impaye,id_commande,date_e,client ,client_tire,n_banque,v_banque,date_enc,id_registre_regl,facture_n,montant_f,evaluation,montant_e,date_cheque,date_remise_cheque,m_cheque,numero_cheque )
	VALUES
	('$vendeur','$impaye','$id_commande','$date_e','$client','$client_tire6','$n_banque6','$v_banque6','$date_enc','$id_registre','$facture','$montant_f',
	'$evaluation','$montant_e','$date_cheque6','$date_remise_cheque6','$m_cheque6','$numero_cheque6')";
	db_query($database_name, $sql1);
	}
	if ($m_cheque7<>"")
	{if ($client_tire7==""){$client_tire7=$client;}
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,impaye,id_commande,date_e,client ,client_tire,n_banque,v_banque,date_enc,id_registre_regl,facture_n,montant_f,evaluation,montant_e,date_cheque,date_remise_cheque,m_cheque,numero_cheque )
	VALUES
	('$vendeur','$impaye','$id_commande','$date_e','$client','$client_tire7','$n_banque7','$v_banque7','$date_enc','$id_registre','$facture','$montant_f',
	'$evaluation','$montant_e','$date_cheque7','$date_remise_cheque7','$m_cheque7','$numero_cheque7')";
	db_query($database_name, $sql1);
	}
	if ($m_cheque8<>"")
	{if ($client_tire8==""){$client_tire8=$client;}
	$sql1  = "INSERT INTO porte_feuilles 
	(vendeur,impaye,id_commande,date_e,client ,client_tire,n_banque,v_banque,date_enc,id_registre_regl,facture_n,montant_f,evaluation,montant_e,date_cheque,date_remise_cheque,m_cheque,numero_cheque )
	VALUES
	('$vendeur','$impaye','$id_commande','$date_e','$client','$client_tire8','$n_banque8','$v_banque8','$date_enc','$id_registre','$facture','$montant_f',
	'$evaluation','$montant_e','$date_cheque8','$date_remise_cheque8','$m_cheque8','$numero_cheque8')";
	db_query($database_name, $sql1);
	}

	
	
	
	}
	if ($_REQUEST["action_r"]=="m_reglement")
	///mise à jour reglments //////////////////////////////
	{
		$id_registre = $_REQUEST["id_registre"];$vendeur=$_REQUEST["vendeur"];$date1=$_REQUEST["date1"];$date2=$_REQUEST["date2"];
		$facture_n="";$montant_f=0;$id = $_REQUEST["id"];$montant_e=$_REQUEST["montant_e"];
//1er regl		
		$m_cheque=$_REQUEST["m_cheque"];$numero_cheque=$_REQUEST["numero_cheque"];
		$date_cheque=dateFrToUs($_REQUEST["date_cheque"]);$v_banque=$_REQUEST["v_banque"];$v_banque_e=$_REQUEST["v_banque_e"];
		$n_banque=$_REQUEST["n_banque"];$client_tire=$_REQUEST["client_tire"];$client_tire_e=$_REQUEST["client_tire_e"];
		$date_remise_cheque=dateFrToUs($_REQUEST["date_cheque"]);$n_banque_e=$_REQUEST["n_banque_e"];$date_echeance=dateFrToUs($_REQUEST["date_echeance"]);
		$m_virement=$_REQUEST["m_virement"];$numero_virement=$_REQUEST["numero_virement"];$date_virement=dateFrToUs($_REQUEST["date_virement"]);
		$v_banque_v=$_REQUEST["v_banque_v"];
//1er regl		
		$m_espece=$_REQUEST["m_espece"];
		
//1er regl		
		$m_effet=$_REQUEST["m_effet"];$numero_effet=$_REQUEST["numero_effet"];
		
//1er regl		
		$m_avoir=$_REQUEST["m_avoir"];$numero_avoir=$_REQUEST["numero_avoir"];
		$m_diff_prix=$_REQUEST["m_diff_prix"];$obs=$_REQUEST["obs"];
		
		if(isset($_REQUEST["chq_f"])) { $chq_f = 1; } else { $chq_f = 0; }
		if(isset($_REQUEST["chq_e"])) { $chq_e = 1; } else { $chq_e = 0; }
		if(isset($_REQUEST["eff_f"])) { $eff_f = 1; } else { $eff_f = 0; }
		if(isset($_REQUEST["eff_e"])) { $eff_e = 1; } else { $eff_e = 0; }
		
		if(isset($_REQUEST["esp_f"])) { $esp_f = 1; } else { $esp_f = 0; }
		if(isset($_REQUEST["esp_e"])) { $esp_e = 1; } else { $esp_e = 0; }
		
		if(isset($_REQUEST["vir_f"])) { $vir_f = 1; } else { $vir_f = 0; }
		if(isset($_REQUEST["vir_e"])) { $vir_e = 1; } else { $vir_e = 0; }
			
			
			//recherche doublons effet
						
			
			$sql = "UPDATE porte_feuilles SET ";
			$sql .= "m_cheque = '" . $m_cheque . "', ";
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
			$sql .= "facture_n = '" . $facture_n . "', ";
			$sql .= "chq_f = '" . $chq_f . "', ";
			$sql .= "chq_e = '" . $chq_e . "', ";
			$sql .= "eff_f = '" . $eff_f . "', ";
			$sql .= "eff_e = '" . $eff_e . "', ";
			$sql .= "esp_f = '" . $esp_f . "', ";
			$sql .= "esp_e = '" . $esp_e . "', ";
			$sql .= "vir_f = '" . $vir_f . "', ";
			$sql .= "vir_e = '" . $vir_e . "', ";
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
			
			
			
			/////////////////////
			if ($m_espece<>0){$numero_cheque_v=0;
	if ($esp_f==1){
	$sql1  = "INSERT INTO porte_feuilles_factures 
	(vendeur,id_porte_feuille,date_e,client,date_enc,id_registre_regl,facture_n,montant_f,evaluation,montant_e,m_espece)
	VALUES ('$vendeur','$id',$date_e,'$client','$date_enc','$id_registre','$facture','$montant_f','$eval','$montant_e','$m_espece')";
	db_query($database_name, $sql1);
	}
	}
	
	if ($m_virement<>0){$numero_cheque_v=0;
	if ($vir_f==1){
	$sql1  = "INSERT INTO porte_feuilles_factures 
	(vendeur,id_porte_feuille,date_e,client ,client_tire,n_banque,v_banque,v_banque_v,date_enc,id_registre_regl,facture_n,montant_f,evaluation,montant_e,date_virement,m_virement,numero_cheque,numero_virement)
	VALUES ('$vendeur','$id',$date_e,'$client','$client_tire','$n_banque','$v_banque','$v_banque_v','$date_enc','$id_registre','$facture','$montant_f','$eval','$montant_e','$date_virement','$m_virement','$numero_cheque_v','$numero_virement')";
	db_query($database_name, $sql1);
	}
	}
	
	///////////////////////////////
	
	
	
			

	
	}
			
			
	if ($vendeur=="CAISSE" or $vendeur=="VENTE USINE"){$v1="CAISSE";$v2="VENTE USINE";
	$sql  = "SELECT * ";
	$sql .= "FROM commandes where vendeur='$v1' or vendeur='$v2' and escompte_exercice=0 ORDER BY date_e;";
	/*$sql .= "FROM commandes where vendeur='$vendeur' and solde<net ORDER BY date_e;";*/
	$users = db_query($database_name, $sql);
	}
	else
	{
	$sql  = "SELECT * ";
	$sql .= "FROM commandes where vendeur='$vendeur' and escompte_exercice=0 ORDER BY date_e;";
	/*$sql .= "FROM commandes where vendeur='$vendeur' and solde<net ORDER BY date_e;";*/
	$users = db_query($database_name, $sql);
	}
	}
	
	
	
	
	else
	{

	$id_registre=$_GET['id_registre'];
	$date_enc=$_GET['date_enc'];$date3=$_GET['date_enc'];
	$vendeur=$_GET['vendeur'];$date1=$_GET['date1'];$vendeur=$_GET['vendeur'];$date2=$_GET['date2'];
	
	//limite recherche
	$sql  = "SELECT * ";
		$sql .= "FROM vendeurs where vendeur='$vendeur' ORDER BY vendeur;";
		$users2v = db_query($database_name, $sql);$users2_v = fetch_array($users2v);
		$dlimite=$users2_v["dlimite"];
			
	
	
	
	
	if ($vendeur=="CAISSE" or $vendeur=="VENTE USINE"){$v1="CAISSE";$v2="VENTE USINE";
	$sql  = "SELECT * ";
	$sql .= "FROM commandes where (vendeur='$v1' or vendeur='$v2') and escompte_exercice=0 and date_e>'$dlimite' ORDER BY date_e DESC;";
	$users = db_query($database_name, $sql);$t=1;
	}
	else
	{
	$sql  = "SELECT * ";
	$sql .= "FROM commandes where vendeur='$vendeur' and escompte_exercice=0 and date_e>'$dlimite' ORDER BY date_e DESC;";
	/*$sql .= "FROM commandes where vendeur='$vendeur' and solde<net ORDER BY date_e;";*/
	$users = db_query($database_name, $sql);$t=0;
	}
	
	
	}
	$sql  = "SELECT *";
	$sql .= "FROM porte_feuilles where id_registre_regl='$id_registre' and impaye=0 Order BY id;";
	$users11 = db_query($database_name, $sql);
	
	?>
<title><? echo dateUsToFr($date_enc);?></title>	
<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo "Evaluation";?></th>
	<th><?php echo "Montant Eval";?></th>
	<th bgcolor="#33CC66"><?php echo "Avoir";?></th>
	<th bgcolor="#33CC66"><?php echo "Diff/Prix";?></th>
	<th bgcolor="#3366FF"><?php echo "ESPECE";?></th>
	<th bgcolor="#3366FF"><?php echo "CHEQUE";?></th>
	<th bgcolor="#3366FF"><?php echo "EFFET";?></th>
	<th bgcolor="#3366FF"><?php echo "VIREMENT";?></th>
</tr>

<?php $compteur1=0;$total_g=0;$t_espece=0;
while($users_1 = fetch_array($users11)) { 
			$id_r=$users_1["id"];/*$date_enc=$users_1["date_enc"]*/;$vendeur=$users_1["vendeur"];
			$client=$users_1["client"];$evaluation=$users_1["evaluation"];$montant_e=$users_1["montant_e"];
			$mode=$users_1["mode"];$m_cheque=$users_1["m_cheque"];$v_banque=$users_1["v_banque"];$numero_cheque=$users_1["numero_cheque"];
			$ref=$v_banque." ".$numero_cheque;$m_espece=$users_1["m_espece"];$m_effet=$users_1["m_effet"];$m_avoir=$users_1["m_avoir"];
			$m_diff_prix=$users_1["m_diff_prix"];$m_virement=$users_1["m_virement"];$impaye=$users_1["impaye"];?>
			<tr>
			<? echo "<td><a href=\"evaluation_vers_reglement1.php?date_enc=$date_enc&date1=$date1&date2=$date2&id=$id_r&id_registre=$id_registre&vendeur=$vendeur\">$client</a></td>";?>
			<td><?php echo $evaluation; ?></td>
			<td align="right"><?php echo number_format($montant_e,2,',',' '); ?></td>
			<td align="right"><?php echo number_format($m_avoir,2,',',' '); ?></td>
			<td align="right"><?php echo number_format($m_diff_prix,2,',',' '); ?></td>
			<td align="right"><?php $t_espece=$t_espece+$m_espece;echo number_format($m_espece,2,',',' '); ?></td>
			<td align="right"><?php echo number_format($m_cheque,2,',',' '); ?></td>
			<td align="right"><?php echo number_format($m_effet,2,',',' '); ?></td>
			<td align="right"><?php echo number_format($m_virement,2,',',' '); ?></td>
			<? echo "<td><a href=\"delete_regl.php?date1=$date1&date2=$date2&id=$id_r&id_registre=$id_registre&vendeur=$vendeur\">Supp</a></td>";?>

<? } ?>
<tr><td bgcolor=""></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>

</table>

	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Evaluations"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "detail_evaluation.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "liste Evaluations"; ?></span>
<tr>
<td><?php echo $vendeur ;?></td>
<? /*echo "<td><a href=\"tableau_enc1.php?id_registre=$id_registre\">Editer Tableau</a></td>";*/?>
<? echo "<td><a href=\"\\mps\\tutorial\\tableau_encaissement1.php?id_registre=$id_registre\">Editer Tableau</a></td>";?>
<? $action_l="l";echo "<td><a href=\"registres_reglements.php?action_l=$action_l&vendeur=$vendeur&date1=$date1&date2=$date2\">-->Retour Liste Tableaux</a></td>";?>

</tr>

<table class="table2">

<tr>
	<th><?php echo "Evaluation";?></th>
	<th><?php echo "Date";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "Net";?></th>
	<th><?php echo "Eval Vendeur";?></th>
</tr>

<?php 

$total_g=0;
while($users_ = fetch_array($users)) { ?><tr>
	<? $commande=$users_["commande"];$evaluation=$users_["evaluation"];$client=$users_["client"];$date=dateUsToFr($users_["date_e"]);
	$vendeur=$users_["vendeur"];$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];
	$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];$id_commande=$users_["id"];$solde=$users_["solde"];
	echo "<td>$evaluation</td>";?>
	<?php $id=$users_["id"]; ;?>
	<td><?php echo $date; ?></td>
	<td><?php echo $users_["client"]; ?></td>
	<td style="text-align:Right"><?php $net=$users_["net"];echo number_format($net,2,',',' '); ?></td>
	<? echo "<td><a href=\"evaluation_vers_reglement.php?montant=$net&id_commande=$id_commande&date_enc=$date_enc&evaluation=$evaluation&
	id_registre=$id_registre&vendeur=$vendeur&client=$client\">valider</a></td>";?>
	<?php $t=$users_["id_registre_regl"]; ?>
<?php } ?>

<tr><td></td><td></td><td></td><td></td><td></td>
<td style="text-align:Right"><?php echo number_format($total_g,2,',',' '); ?></td>
</tr>

</table>
<tr>
</tr>

<p style="text-align:center">

</body>

</html>