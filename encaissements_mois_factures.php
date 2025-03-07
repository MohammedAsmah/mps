<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";$action="Recherche";$date1="";$date2="";
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url

	if(isset($_REQUEST["action_r"])) {
	
	if ($_REQUEST["action_r"]=="reglement"){
	
		$id_porte_feuille = $_REQUEST["id"];
		$id_registre_regl = $_REQUEST["id_registre_regl"];
		$date1 = $_REQUEST["date1"];
		$date2 = $_REQUEST["date2"];
		$evaluation = $_REQUEST["evaluation"];
		$client = $_REQUEST["client"];
		$montant_e = $_REQUEST["montant_e"];
		$vendeur = $_REQUEST["vendeur"];
		
		$m_cheque = $_REQUEST["m_cheque"];
		$m_espece = $_REQUEST["m_espece"];
		$m_effet = $_REQUEST["m_effet"];
		
		
		if ($m_cheque<>0)
		{
		$numero_cheque = $_REQUEST["numero_cheque"];
		$date_cheque = dateFrToUs($_REQUEST["date_cheque"]);
		$v_banque = $_REQUEST["v_banque"];
		$client_tire = $_REQUEST["client_tire"];
		$date_enc = $_REQUEST["date_enc"];
		
		
		
		
		
		$facture_1_c = $_REQUEST["facture_1_c"];$date_facture_1_c = dateFrToUs($_REQUEST["date_facture_1_c"]);
		
		if ($facture_1_c<>"")
		{
		$traite_1_c = $_REQUEST["traite_1_c"];
		$montant_f_1=0;$date_f_1="";$client_1="";	 	
		
		if ($facture_1_c>9039){
		$sql  = "SELECT * ";
		$sql .= "FROM factures2016 where numero='$facture_1_c' order BY id;";
		$users = db_query($database_name, $sql);
		$user_ = fetch_array($users);$montant_f_1 = $user_["montant"];$date_f_1 = $user_["date_f"];$client_1 = $user_["client"];$exe1=$facture_1_c;
		}
		else
		{
		
		if ($facture_1_c<10){$zero="000";}
		if ($facture_1_c>=10 and $facture_1_c<100){$zero="00";}
		if ($facture_1_c>=100 and $facture_1_c<1000){$zero="0";}
		if ($facture_1_c>=1000 and $facture_1_c<10000){$zero="";}
		if ($date_facture_1_c>="2018-01-01" and $date_facture_1_c<"2019-01-01"){$factures="factures2018";$exe1=$zero.$facture_1_c."/18";}
		if ($date_facture_1_c>="2017-01-01" and $date_facture_1_c<"2018-01-01"){$factures="factures";$exe1=$zero.$facture_1_c."/17";}
		if ($date_facture_1_c>="2019-01-01" and $date_facture_1_c<"2020-01-01"){$factures="factures2019";$exe1=$zero.$facture_1_c."/19";}
		if ($date_facture_1_c>="2020-01-01" and $date_facture_1_c<"2021-01-01"){$factures="factures2020";$exe1=$zero.$facture_1_c."/20";}
		if ($date_facture_1_c>="2021-01-01" and $date_facture_1_c<"2022-01-01"){$factures="factures2021";$exe1=$zero.$facture_1_c."/21";}
		if ($date_facture_1_c>="2022-01-01" and $date_facture_1_c<"2023-01-01"){$factures="factures2022";$exe1=$zero.$facture_1_c."/22";}
		if ($date_facture_1_c>="2023-01-01" and $date_facture_1_c<"2024-01-01"){$factures="factures2023";$exe1=$zero.$facture_1_c."/23";}
		if ($date_facture_1_c>="2024-01-01" and $date_facture_1_c<"2025-01-01"){$factures="factures2024";$exe1=$zero.$facture_1_c."/24";}
		if ($date_facture_1_c>="2025-01-01" and $date_facture_1_c<"2026-01-01"){$factures="factures2025";$exe1=$zero.$facture_1_c."/25";}
		if ($date_facture_1_c>="2026-01-01" and $date_facture_1_c<"2027-01-01"){$factures="factures2026";$exe1=$zero.$facture_1_c."/26";}

		$sql  = "SELECT * ";
		$sql .= "FROM ".$factures." where numero='$facture_1_c' order BY id;";
		$users = db_query($database_name, $sql);
		$user_ = fetch_array($users);$montant_f_1 = $user_["montant"];$date_f_1 = $user_["date_f"];$client_1 = $user_["client"];
		}
		
		$sql1  = "INSERT INTO porte_feuilles_factures 
		(vendeur,id_porte_feuille,client,client_tire,v_banque,date_enc,id_registre_regl,facture_n,date_f,montant_f,evaluation,montant_e,date_cheque,m_cheque,m_cheque_g,numero_cheque)
		VALUES ('$vendeur','$id_porte_feuille','$client_1','$client_tire','$v_banque','$date_enc','$id_registre_regl','$facture_1_c','$date_facture_1_c','$montant_f_1','$evaluation','$montant_e','$date_cheque','$traite_1_c','$m_cheque','$numero_cheque')";
		db_query($database_name, $sql1);
		}
		
		$facture_2_c = $_REQUEST["facture_2_c"];$date_facture_2_c = dateFrToUs($_REQUEST["date_facture_2_c"]);
		if ($facture_2_c<>"")
		{
		$traite_2_c = $_REQUEST["traite_2_c"];
		$montant_f_2=0;$date_f_2="";$client_2="";	 	
		if ($facture_2_c>9039){
		$sql  = "SELECT * ";
		$sql .= "FROM factures2016 where numero='$facture_2_c' order BY id;";
		$users = db_query($database_name, $sql);
		$user_ = fetch_array($users);$montant_f_2 = $user_["montant"];$date_f_2 = $user_["date_f"];$client_2 = $user_["client"];$exe2=$facture_2_c;
		}else
		{
		if ($facture_2_c<10){$zero="000";}
		if ($facture_2_c>=10 and $facture_2_c<100){$zero="00";}
		if ($facture_2_c>=100 and $facture_2_c<1000){$zero="0";}
		if ($facture_2_c>=1000 and $facture_2_c<10000){$zero="";}
		//if ($date_facture_2_c>="2018-01-01"){$factures="factures2018";$exe2=$zero.$facture_2_c."/18";}else{$factures="factures";$exe2=$zero.$facture_2_c."/17";}
		
		if ($date_facture_2_c>="2018-01-01" and $date_facture_2_c<"2019-01-01"){$factures="factures2018";$exe2=$zero.$facture_2_c."/18";}
		if ($date_facture_2_c>="2017-01-01" and $date_facture_2_c<"2018-01-01"){$factures="factures";$exe2=$zero.$facture_2_c."/17";}
		if ($date_facture_2_c>="2019-01-01" and $date_facture_2_c<"2020-01-01"){$factures="factures2019";$exe2=$zero.$facture_2_c."/19";}
		if ($date_facture_2_c>="2020-01-01" and $date_facture_2_c<"2021-01-01"){$factures="factures2020";$exe2=$zero.$facture_2_c."/20";}
		if ($date_facture_2_c>="2021-01-01" and $date_facture_2_c<"2022-01-01"){$factures="factures2021";$exe2=$zero.$facture_2_c."/21";}
		if ($date_facture_2_c>="2022-01-01" and $date_facture_2_c<"2023-01-01"){$factures="factures2022";$exe2=$zero.$facture_2_c."/22";}
		if ($date_facture_2_c>="2023-01-01" and $date_facture_2_c<"2024-01-01"){$factures="factures2023";$exe2=$zero.$facture_2_c."/23";}
		if ($date_facture_2_c>="2024-01-01" and $date_facture_2_c<"2025-01-01"){$factures="factures2024";$exe2=$zero.$facture_2_c."/24";}
		if ($date_facture_2_c>="2025-01-01" and $date_facture_2_c<"2026-01-01"){$factures="factures2025";$exe2=$zero.$facture_2_c."/25";}
		if ($date_facture_2_c>="2026-01-01" and $date_facture_2_c<"2027-01-01"){$factures="factures2026";$exe2=$zero.$facture_2_c."/26";}
		
		$sql  = "SELECT * ";
		$sql .= "FROM ".$factures." where numero='$facture_2_c' order BY id;";
		$users = db_query($database_name, $sql);
		$user_ = fetch_array($users);$montant_f_2 = $user_["montant"];$date_f_2 = $user_["date_f"];$client_2 = $user_["client"];
		}
		
		$sql1  = "INSERT INTO porte_feuilles_factures 
		(vendeur,id_porte_feuille,client ,client_tire,v_banque,date_enc,id_registre_regl,facture_n,date_f,montant_f,evaluation,montant_e,date_cheque,m_cheque,m_cheque_g,numero_cheque)
		VALUES ('$vendeur','$id_porte_feuille','$client_2','$client_tire','$v_banque','$date_enc','$id_registre_regl','$facture_2_c','$date_facture_2_c','$montant_f_2','$evaluation','$montant_e','$date_cheque','$traite_2_c','$m_cheque','$numero_cheque')";
		db_query($database_name, $sql1);
		}
		
		$facture_3_c = $_REQUEST["facture_3_c"];$date_facture_3_c = dateFrToUs($_REQUEST["date_facture_3_c"]);
		if ($facture_3_c<>"")
		{
		$traite_3_c = $_REQUEST["traite_3_c"];
		$montant_f_3=0;$date_f_3="";$client_3="";	 	
		if ($facture_3_c>9039){
		$sql  = "SELECT * ";
		$sql .= "FROM factures2016 where numero='$facture_3_c' order BY id;";
		$users = db_query($database_name, $sql);
		$user_ = fetch_array($users);$montant_f_3 = $user_["montant"];$date_f_3 = $user_["date_f"];$client_3 = $user_["client"];$exe3=$facture_3_c;
		}else
		{
		if ($facture_3_c<10){$zero="000";}
		if ($facture_3_c>=10 and $facture_3_c<100){$zero="00";}
		if ($facture_3_c>=100 and $facture_3_c<1000){$zero="0";}
		if ($facture_3_c>=1000 and $facture_3_c<10000){$zero="";}
		//if ($date_facture_3_c>="2018-01-01"){$factures="factures2018";$exe3=$zero.$facture_3_c."/18";}else{$factures="factures";$exe3=$zero.$facture_3_c."/17";}
		
		if ($date_facture_3_c>="2018-01-01" and $date_facture_3_c<"2019-01-01"){$factures="factures2018";$exe3=$zero.$facture_3_c."/18";}
		if ($date_facture_3_c>="2017-01-01" and $date_facture_3_c<"2018-01-01"){$factures="factures";$exe3=$zero.$facture_3_c."/17";}
		if ($date_facture_3_c>="2019-01-01" and $date_facture_3_c<"2020-01-01"){$factures="factures2019";$exe3=$zero.$facture_3_c."/19";}
		if ($date_facture_3_c>="2020-01-01" and $date_facture_3_c<"2021-01-01"){$factures="factures2020";$exe3=$zero.$facture_3_c."/20";}
		if ($date_facture_3_c>="2021-01-01" and $date_facture_3_c<"2022-01-01"){$factures="factures2021";$exe3=$zero.$facture_3_c."/21";}
		if ($date_facture_3_c>="2022-01-01" and $date_facture_3_c<"2023-01-01"){$factures="factures2022";$exe3=$zero.$facture_3_c."/22";}
		if ($date_facture_3_c>="2023-01-01" and $date_facture_3_c<"2024-01-01"){$factures="factures2023";$exe3=$zero.$facture_3_c."/23";}
		if ($date_facture_3_c>="2024-01-01" and $date_facture_3_c<"2025-01-01"){$factures="factures2024";$exe3=$zero.$facture_3_c."/24";}
		if ($date_facture_3_c>="2025-01-01" and $date_facture_3_c<"2026-01-01"){$factures="factures2025";$exe3=$zero.$facture_3_c."/25";}
		if ($date_facture_3_c>="2026-01-01" and $date_facture_3_c<"2027-01-01"){$factures="factures2026";$exe3=$zero.$facture_3_c."/26";}
		
		
		$sql  = "SELECT * ";
		$sql .= "FROM ".$factures." where numero='$facture_3_c' order BY id;";
		$users = db_query($database_name, $sql);
		$user_ = fetch_array($users);$montant_f_3 = $user_["montant"];$date_f_3 = $user_["date_f"];$client_3 = $user_["client"];
		}
		
		
		$sql1  = "INSERT INTO porte_feuilles_factures 
		(vendeur,id_porte_feuille,client ,client_tire,v_banque,date_enc,id_registre_regl,facture_n,date_f,montant_f,evaluation,montant_e,date_cheque,m_cheque,m_cheque_g,numero_cheque)
		VALUES ('$vendeur','$id_porte_feuille','$client_3','$client_tire','$v_banque','$date_enc','$id_registre_regl','$facture_3_c','$date_facture_3_c','$montant_f_3','$evaluation','$montant_e','$date_cheque','$traite_3_c','$m_cheque','$numero_cheque')";
		db_query($database_name, $sql1);
		}
		
		$facture_4_c = $_REQUEST["facture_4_c"];$date_facture_4_c = dateFrToUs($_REQUEST["date_facture_4_c"]);
		if ($facture_4_c<>"")
		{
		$traite_4_c = $_REQUEST["traite_4_c"];
		$montant_f_4=0;$date_f_4="";$client_4="";	 	
		
		if ($facture_4_c>9039){
		$sql  = "SELECT * ";
		$sql .= "FROM factures2016 where numero='$facture_4_c' order BY id;";
		$users = db_query($database_name, $sql);
		$user_ = fetch_array($users);$montant_f_4 = $user_["montant"];$date_f_4 = $user_["date_f"];$client_4 = $user_["client"];$exe4=$facture_4_c;
		}
		else
		{
		if ($facture_4_c<10){$zero="000";}
		if ($facture_4_c>=10 and $facture_4_c<100){$zero="00";}
		if ($facture_4_c>=100 and $facture_4_c<1000){$zero="0";}
		if ($facture_4_c>=1000 and $facture_4_c<10000){$zero="";}
		//if ($date_facture_4_c>="2018-01-01"){$factures="factures2018";$exe4=$zero.$facture_4_c."/18";}else{$factures="factures";$exe4=$zero.$facture_4_c."/17";}
		
		if ($date_facture_4_c>="2018-01-01" and $date_facture_4_c<"2019-01-01"){$factures="factures2018";$exe4=$zero.$facture_4_c."/18";}
		if ($date_facture_4_c>="2017-01-01" and $date_facture_4_c<"2018-01-01"){$factures="factures";$exe4=$zero.$facture_4_c."/17";}
		if ($date_facture_4_c>="2019-01-01" and $date_facture_4_c<"2020-01-01"){$factures="factures2019";$exe4=$zero.$facture_4_c."/19";}
		if ($date_facture_4_c>="2020-01-01" and $date_facture_4_c<"2021-01-01"){$factures="factures2020";$exe4=$zero.$facture_4_c."/20";}
		if ($date_facture_4_c>="2021-01-01" and $date_facture_4_c<"2022-01-01"){$factures="factures2021";$exe4=$zero.$facture_4_c."/21";}
		if ($date_facture_4_c>="2022-01-01" and $date_facture_4_c<"2023-01-01"){$factures="factures2022";$exe4=$zero.$facture_4_c."/22";}
		if ($date_facture_4_c>="2023-01-01" and $date_facture_4_c<"2024-01-01"){$factures="factures2023";$exe4=$zero.$facture_4_c."/23";}
		if ($date_facture_4_c>="2024-01-01" and $date_facture_4_c<"2025-01-01"){$factures="factures2024";$exe4=$zero.$facture_4_c."/24";}
		if ($date_facture_4_c>="2025-01-01" and $date_facture_4_c<"2026-01-01"){$factures="factures2025";$exe4=$zero.$facture_4_c."/25";}
		if ($date_facture_4_c>="2026-01-01" and $date_facture_4_c<"2027-01-01"){$factures="factures2026";$exe4=$zero.$facture_4_c."/26";}
		
		
		$sql  = "SELECT * ";
		$sql .= "FROM ".$factures." where numero='$facture_4_c' order BY id;";
		$users = db_query($database_name, $sql);
		$user_ = fetch_array($users);$montant_f_4 = $user_["montant"];$date_f_4 = $user_["date_f"];$client_4 = $user_["client"];
		}
		
		$sql1  = "INSERT INTO porte_feuilles_factures 
		(vendeur,id_porte_feuille,client ,client_tire,v_banque,date_enc,id_registre_regl,facture_n,date_f,montant_f,evaluation,montant_e,date_cheque,m_cheque,m_cheque_g,numero_cheque)
		VALUES ('$vendeur','$id_porte_feuille','$client_4','$client_tire','$v_banque','$date_enc','$id_registre_regl','$facture_4_c','$date_facture_4_c','$montant_f_4','$evaluation','$montant_e','$date_cheque','$traite_4_c','$m_cheque','$numero_cheque')";
		db_query($database_name, $sql1);
		}
		}
		
		//////////////////////////
		if ($m_espece<>0)
		{
		
		$date_enc = $_REQUEST["date_enc"];
				
		$facture_1_es = $_REQUEST["facture_1_es"];$date_facture_1_es = dateFrToUs($_REQUEST["date_facture_1_es"]);
		if ($facture_1_es<>"")
		{
		$traite_1_es = $_REQUEST["traite_1_es"];
		$montant_f_1=0;$date_f_1="";$client_1="";	 	
		
		if ($facture_1_es>9039){
		$sql  = "SELECT * ";
		$sql .= "FROM factures2016 where numero='$facture_1_es' order BY id;";
		$users = db_query($database_name, $sql);
		$user_ = fetch_array($users);$montant_f_1 = $user_["montant"];$date_f_1 = $user_["date_f"];$client_1 = $user_["client"];$exe5=$facture_1_es;
		}else
		{
		if ($facture_1_es<10){$zero="000";}
		if ($facture_1_es>=10 and $facture_1_es<100){$zero="00";}
		if ($facture_1_es>=100 and $facture_1_es<1000){$zero="0";}
		if ($facture_1_es>=1000 and $facture_1_es<10000){$zero="";}
		//if ($date_facture_1_es>="2018-01-01"){$factures="factures2018";$exe5=$zero.$facture_1_es."/18";}else{$factures="factures";$exe5=$zero.$facture_1_es."/17";}
		
		if ($date_facture_1_es>="2018-01-01" and $date_facture_1_es<"2019-01-01"){$factures="factures2018";$exe5=$zero.$facture_1_es."/18";}
		if ($date_facture_1_es>="2017-01-01" and $date_facture_1_es<"2018-01-01"){$factures="factures";$exe5=$zero.$facture_1_es."/17";}
		if ($date_facture_1_es>="2019-01-01" and $date_facture_1_es<"2020-01-01"){$factures="factures2019";$exe5=$zero.$facture_1_es."/19";}
		if ($date_facture_1_es>="2020-01-01" and $date_facture_1_es<"2021-01-01"){$factures="factures2020";$exe5=$zero.$facture_1_es."/20";}
		if ($date_facture_1_es>="2021-01-01" and $date_facture_1_es<"2022-01-01"){$factures="factures2021";$exe5=$zero.$facture_1_es."/21";}
		if ($date_facture_1_es>="2022-01-01" and $date_facture_1_es<"2023-01-01"){$factures="factures2022";$exe5=$zero.$facture_1_es."/22";}
		if ($date_facture_1_es>="2023-01-01" and $date_facture_1_es<"2024-01-01"){$factures="factures2023";$exe5=$zero.$facture_1_es."/23";}
		if ($date_facture_1_es>="2024-01-01" and $date_facture_1_es<"2025-01-01"){$factures="factures2024";$exe5=$zero.$facture_1_es."/24";}
		if ($date_facture_1_es>="2025-01-01" and $date_facture_1_es<"2026-01-01"){$factures="factures2025";$exe5=$zero.$facture_1_es."/25";}
		if ($date_facture_1_es>="2026-01-01" and $date_facture_1_es<"2027-01-01"){$factures="factures2026";$exe5=$zero.$facture_1_es."/26";}
		
		
		$sql  = "SELECT * ";
		$sql .= "FROM ".$factures." where numero='$facture_1_es' order BY id;";
		$users = db_query($database_name, $sql);
		$user_ = fetch_array($users);$montant_f_1 = $user_["montant"];$date_f_1 = $user_["date_f"];$client_1 = $user_["client"];
		}
				
		
		$sql1  = "INSERT INTO porte_feuilles_factures 
		(vendeur,id_porte_feuille,client,date_enc,id_registre_regl,facture_n,date_f,montant_f,evaluation,montant_e,m_espece,date_f)
		VALUES ('$vendeur','$id_porte_feuille','$client_1','$date_enc','$id_registre_regl','$facture_1_es','$date_facture_1_es','$montant_f_1','$evaluation','$montant_e','$traite_1_es','$date_f_1')";
		db_query($database_name, $sql1);
		}
		
				
		}
		
		/////////////////////////
			if ($m_effet<>0)
		{
		$numero_effet = $_REQUEST["numero_effet"];
		$date_echeance = dateFrToUs($_REQUEST["date_echeance"]);
		$v_banque = $_REQUEST["v_banque_e"];
		$client_tire = $_REQUEST["client_tire_e"];
		$date_enc = $_REQUEST["date_enc"];
		
		
		
		
		
		$facture_1_ef = $_REQUEST["facture_1_ef"];$date_facture_1_ef = dateFrToUs($_REQUEST["date_facture_1_ef"]);
		if ($facture_1_ef<>"")
		{
		$traite_1_ef = $_REQUEST["traite_1_ef"];
		$montant_f_1=0;$date_f_1="";$client_1="";	 	
		
		if ($facture_1_ef>9039){
		$sql  = "SELECT * ";
		$sql .= "FROM factures2016 where numero='$facture_1_ef' order BY id;";
		$users = db_query($database_name, $sql);
		$user_ = fetch_array($users);$montant_f_1 = $user_["montant"];$date_f_1 = $user_["date_f"];$client_1 = $user_["client"];$exe1=$facture_1_ef;
		}else
		{
		if ($facture_1_ef<10){$zero="000";}
		if ($facture_1_ef>=10 and $facture_1_ef<100){$zero="00";}
		if ($facture_1_ef>=100 and $facture_1_ef<1000){$zero="0";}
		if ($facture_1_ef>=1000 and $facture_1_ef<10000){$zero="";}
		//if ($date_facture_1_ef>="2018-01-01"){$factures="factures2018";$exe1=$zero.$facture_1_ef."/18";}else{$factures="factures";$exe1=$zero.$facture_1_ef."/17";}
		
		if ($date_facture_1_ef>="2018-01-01" and $date_facture_1_ef<"2019-01-01"){$factures="factures2018";$exe1=$zero.$facture_1_ef."/18";}
		if ($date_facture_1_ef>="2017-01-01" and $date_facture_1_ef<"2018-01-01"){$factures="factures";$exe1=$zero.$facture_1_ef."/17";}
		if ($date_facture_1_ef>="2019-01-01" and $date_facture_1_ef<"2020-01-01"){$factures="factures2019";$exe1=$zero.$facture_1_ef."/19";}
		if ($date_facture_1_ef>="2020-01-01" and $date_facture_1_ef<"2021-01-01"){$factures="factures2020";$exe1=$zero.$facture_1_ef."/20";}
		if ($date_facture_1_ef>="2021-01-01" and $date_facture_1_ef<"2022-01-01"){$factures="factures2021";$exe1=$zero.$facture_1_ef."/21";}
		if ($date_facture_1_ef>="2022-01-01" and $date_facture_1_ef<"2023-01-01"){$factures="factures2022";$exe1=$zero.$facture_1_ef."/22";}
		if ($date_facture_1_ef>="2023-01-01" and $date_facture_1_ef<"2024-01-01"){$factures="factures2023";$exe1=$zero.$facture_1_ef."/23";}
		if ($date_facture_1_ef>="2024-01-01" and $date_facture_1_ef<"2025-01-01"){$factures="factures2024";$exe1=$zero.$facture_1_ef."/24";}
		if ($date_facture_1_ef>="2025-01-01" and $date_facture_1_ef<"2026-01-01"){$factures="factures2025";$exe1=$zero.$facture_1_ef."/25";}
		if ($date_facture_1_ef>="2026-01-01" and $date_facture_1_ef<"2027-01-01"){$factures="factures2026";$exe1=$zero.$facture_1_ef."/26";}
		
		
		$sql  = "SELECT * ";
		$sql .= "FROM ".$factures." where numero='$facture_1_ef' order BY id;";
		$users = db_query($database_name, $sql);
		$user_ = fetch_array($users);$montant_f_1 = $user_["montant"];$date_f_1 = $user_["date_f"];$client_1 = $user_["client"];
		}
		
		
		
		$sql1  = "INSERT INTO porte_feuilles_factures 
		(vendeur,id_porte_feuille,client,client_tire_e,v_banque,date_enc,id_registre_regl,facture_n,date_f,montant_f,evaluation,montant_e,date_echeance,m_effet,m_effet_g,numero_effet)
		VALUES ('$vendeur','$id_porte_feuille','$client_1','$client_tire','$v_banque','$date_enc','$id_registre_regl','$facture_1_ef','$date_facture_1_ef','$montant_f_1','$evaluation','$montant_e','$date_echeance','$traite_1_ef','$m_effet_g','$numero_effet')";
		db_query($database_name, $sql1);
		}
		
		$facture_2_c = $_REQUEST["facture_2_c"];$date_facture_2_c = dateFrToUs($_REQUEST["date_facture_2_c"]);
		if ($facture_2_c<>"")
		{
		$traite_2_c = $_REQUEST["traite_2_c"];
		$montant_f_2=0;$date_f_2="";$client_2="";	
		
		if ($facture_2_c>9039){
		$sql  = "SELECT * ";
		$sql .= "FROM factures2016 where numero='$facture_2_c' order BY id;";
		$users = db_query($database_name, $sql);$exe2=$facture_2_c;
		
		}else
		{
		if ($facture_2_c<10){$zero="000";}
		if ($facture_2_c>=10 and $facture_2_c<100){$zero="00";}
		if ($facture_2_c>=100 and $facture_2_c<1000){$zero="0";}
		if ($facture_2_c>=1000 and $facture_2_c<10000){$zero="";}
		//if ($date_facture_2_c>="2018-01-01"){$factures="factures2018";$exe2=$zero.$facture_2_c."/18";}else{$factures="factures";$exe2=$zero.$facture_2_c."/17";}
		
		if ($date_facture_2_c>="2018-01-01" and $date_facture_2_c<"2019-01-01"){$factures="factures2018";$exe2=$zero.$facture_2_c."/18";}
		if ($date_facture_2_c>="2017-01-01" and $date_facture_2_c<"2018-01-01"){$factures="factures";$exe2=$zero.$facture_2_c."/17";}
		if ($date_facture_2_c>="2019-01-01" and $date_facture_2_c<"2020-01-01"){$factures="factures2019";$exe2=$zero.$facture_2_c."/19";}
		if ($date_facture_2_c>="2020-01-01" and $date_facture_2_c<"2021-01-01"){$factures="factures2020";$exe2=$zero.$facture_2_c."/20";}
		if ($date_facture_2_c>="2021-01-01" and $date_facture_2_c<"2022-01-01"){$factures="factures2021";$exe2=$zero.$facture_2_c."/21";}
		if ($date_facture_2_c>="2022-01-01" and $date_facture_2_c<"2023-01-01"){$factures="factures2022";$exe2=$zero.$facture_2_c."/22";}
		if ($date_facture_2_c>="2023-01-01" and $date_facture_2_c<"2024-01-01"){$factures="factures2023";$exe2=$zero.$facture_2_c."/23";}
		if ($date_facture_2_c>="2024-01-01" and $date_facture_2_c<"2025-01-01"){$factures="factures2024";$exe2=$zero.$facture_2_c."/24";}
		if ($date_facture_2_c>="2025-01-01" and $date_facture_2_c<"2026-01-01"){$factures="factures2025";$exe2=$zero.$facture_2_c."/25";}
		if ($date_facture_2_c>="2026-01-01" and $date_facture_2_c<"2027-01-01"){$factures="factures2026";$exe2=$zero.$facture_2_c."/26";}
		
		$sql  = "SELECT * ";
		$sql .= "FROM ".$factures." where numero='$facture_2_c' order BY id;";
		$users = db_query($database_name, $sql);
		
		}
		
		$user_ = fetch_array($users);$montant_f_2 = $user_["montant"];$date_f_2 = $user_["date_f"];$client_2 = $user_["client"];
		
		$sql1  = "INSERT INTO porte_feuilles_factures 
		(vendeur,id_porte_feuille,client,client_tire_e,v_banque,date_enc,id_registre_regl,facture_n,date_f,montant_f,evaluation,montant_e,date_echeance,m_effet,m_effet_g,numero_effet)
		VALUES ('$vendeur','$id_porte_feuille','$client_2','$client_tire','$v_banque','$date_enc','$id_registre_regl','$facture_2_c','$date_facture_2_c','$montant_f_2','$evaluation','$montant_e','$date_echeance','$traite_2_c','$m_effet_g','$numero_effet')";
		db_query($database_name, $sql1);
		}
		
		$facture_3_c = $_REQUEST["facture_3_c"];$date_facture_3_c = dateFrToUs($_REQUEST["date_facture_3_c"]);
		if ($facture_3_c<>"")
		{
		$traite_3_c = $_REQUEST["traite_3_c"];
		$montant_f_3=0;$date_f_3="";$client_3="";	 	
		if ($facture_3_c>9039){
		$sql  = "SELECT * ";
		$sql .= "FROM factures2016 where numero='$facture_3_c' order BY id;";
		$users = db_query($database_name, $sql);$exe3=$facture_3_c;
		
		}else
		{if ($facture_3_c<10){$zero="000";}
		if ($facture_3_c>=10 and $facture_3_c<100){$zero="00";}
		if ($facture_3_c>=100 and $facture_3_c<1000){$zero="0";}
		if ($facture_3_c>=1000 and $facture_3_c<10000){$zero="";}
		//if ($date_facture_3_c>="2018-01-01"){$factures="factures2018";$exe3=$zero.$facture_3_c."/18";}else{$factures="factures";$exe3=$zero.$facture_3_c."/17";}
		
		if ($date_facture_3_c>="2018-01-01" and $date_facture_3_c<"2019-01-01"){$factures="factures2018";$exe3=$zero.$facture_3_c."/18";}
		if ($date_facture_3_c>="2017-01-01" and $date_facture_3_c<"2018-01-01"){$factures="factures";$exe3=$zero.$facture_3_c."/17";}
		if ($date_facture_3_c>="2019-01-01" and $date_facture_3_c<"2020-01-01"){$factures="factures2019";$exe3=$zero.$facture_3_c."/19";}
		if ($date_facture_3_c>="2020-01-01" and $date_facture_3_c<"2021-01-01"){$factures="factures2020";$exe3=$zero.$facture_3_c."/20";}
		if ($date_facture_3_c>="2021-01-01" and $date_facture_3_c<"2022-01-01"){$factures="factures2021";$exe3=$zero.$facture_3_c."/21";}
		if ($date_facture_3_c>="2022-01-01" and $date_facture_3_c<"2023-01-01"){$factures="factures2022";$exe3=$zero.$facture_3_c."/22";}
		if ($date_facture_3_c>="2023-01-01" and $date_facture_3_c<"2024-01-01"){$factures="factures2023";$exe3=$zero.$facture_3_c."/23";}
		if ($date_facture_3_c>="2024-01-01" and $date_facture_3_c<"2025-01-01"){$factures="factures2024";$exe3=$zero.$facture_3_c."/24";}
		if ($date_facture_3_c>="2025-01-01" and $date_facture_3_c<"2026-01-01"){$factures="factures2025";$exe3=$zero.$facture_3_c."/25";}
		if ($date_facture_3_c>="2026-01-01" and $date_facture_3_c<"2027-01-01"){$factures="factures2026";$exe3=$zero.$facture_3_c."/26";}
		
		
		
		
		$sql  = "SELECT * ";
		$sql .= "FROM ".$factures." where numero='$facture_3_c' order BY id;";
		$users = db_query($database_name, $sql);
		
		}
		$user_ = fetch_array($users);$montant_f_3 = $user_["montant"];$date_f_3 = $user_["date_f"];$client_3 = $user_["client"];
		
		$sql1  = "INSERT INTO porte_feuilles_factures 
		(vendeur,id_porte_feuille,client,client_tire_e,v_banque,date_enc,id_registre_regl,facture_n,date_f,montant_f,evaluation,montant_e,date_echeance,m_effet,m_effet_g,numero_effet)
		VALUES ('$vendeur','$id_porte_feuille','$client_3','$client_tire','$v_banque','$date_enc','$id_registre_regl','$facture_3_c','$date_facture_3_c','$montant_f_3','$evaluation','$montant_e','$date_echeance','$traite_3_c','$m_effet_g','$numero_effet')";
		db_query($database_name, $sql1);
		}
		
		$facture_4_c = $_REQUEST["facture_4_c"];$date_facture_4_c = dateFrToUs($_REQUEST["date_facture_4_c"]);
		if ($facture_4_c<>"")
		{
		$traite_4_c = $_REQUEST["traite_4_c"];
		$montant_f_4=0;$date_f_4="";$client_4="";	 	
		if ($facture_4_c>9039){
		$sql  = "SELECT * ";
		$sql .= "FROM factures2016 where numero='$facture_4_c' order BY id;";
		$users = db_query($database_name, $sql);$exe4=$facture_4_c;
		
		}else
		{if ($facture_4_c<10){$zero="000";}
		if ($facture_4_c>=10 and $facture_4_c<100){$zero="00";}
		if ($facture_4_c>=100 and $facture_4_c<1000){$zero="0";}
		if ($facture_4_c>=1000 and $facture_4_c<10000){$zero="";}
		//if ($date_facture_4_c>="2018-01-01"){$factures="factures2018";$exe4=$zero.$facture_4_c."/18";}else{$factures="factures";$exe4=$zero.$facture_4_c."/17";}
		
		if ($date_facture_4_c>="2018-01-01" and $date_facture_4_c<"2019-01-01"){$factures="factures2018";$exe4=$zero.$facture_4_c."/18";}
		if ($date_facture_4_c>="2017-01-01" and $date_facture_4_c<"2018-01-01"){$factures="factures";$exe4=$zero.$facture_4_c."/17";}
		if ($date_facture_4_c>="2019-01-01" and $date_facture_4_c<"2020-01-01"){$factures="factures2019";$exe4=$zero.$facture_4_c."/19";}
		if ($date_facture_4_c>="2020-01-01" and $date_facture_4_c<"2021-01-01"){$factures="factures2020";$exe4=$zero.$facture_4_c."/20";}
		if ($date_facture_4_c>="2021-01-01" and $date_facture_4_c<"2022-01-01"){$factures="factures2021";$exe4=$zero.$facture_4_c."/21";}
		if ($date_facture_4_c>="2022-01-01" and $date_facture_4_c<"2023-01-01"){$factures="factures2022";$exe4=$zero.$facture_4_c."/22";}
		if ($date_facture_4_c>="2023-01-01" and $date_facture_4_c<"2024-01-01"){$factures="factures2023";$exe4=$zero.$facture_4_c."/23";}
		if ($date_facture_4_c>="2024-01-01" and $date_facture_4_c<"2025-01-01"){$factures="factures2024";$exe4=$zero.$facture_4_c."/24";}
		if ($date_facture_4_c>="2025-01-01" and $date_facture_4_c<"2026-01-01"){$factures="factures2025";$exe4=$zero.$facture_4_c."/25";}
		if ($date_facture_4_c>="2026-01-01" and $date_facture_4_c<"2027-01-01"){$factures="factures2026";$exe4=$zero.$facture_4_c."/26";}
		
		$sql  = "SELECT * ";
		$sql .= "FROM ".$factures." where numero='$facture_4_c' order BY id;";
		$users = db_query($database_name, $sql);
		
		}
		$user_ = fetch_array($users);$montant_f_4 = $user_["montant"];$date_f_4 = $user_["date_f"];$client_4 = $user_["client"];
		
		$sql1  = "INSERT INTO porte_feuilles_factures 
		(vendeur,id_porte_feuille,client,client_tire_e,v_banque,date_enc,id_registre_regl,facture_n,date_f,montant_f,evaluation,montant_e,date_echeance,m_effet,m_effet_g,numero_effet)
		VALUES ('$vendeur','$id_porte_feuille','$client_4','$client_tire','$v_banque','$date_enc','$id_registre_regl','$facture_4_c','$date_facture_4_c','$montant_f_4','$evaluation','$montant_e','$date_echeance','$traite_4_c','$m_effet_g','$numero_effet')";
		db_query($database_name, $sql1);
		}
		
		}
		
		///////////////////////
			
			$enc_facture1=1;$enc_facture2=date("d/m/Y");$enc_facture3=$user_name;
			$sql = "UPDATE porte_feuilles SET ";
			$sql .= "enc_facture1 = '" . $enc_facture1 . "', ";
			$sql .= "enc_facture2 = '" . $enc_facture2 . "', ";
			$sql .= "enc_facture3 = '" . $enc_facture3 . "' ";
			$sql .= "WHERE id = " . $id_porte_feuille . ";";
			db_query($database_name, $sql);
		
		
	}
	
	}
	
	?>
	<? 
	$reference="";
	if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="encaissements_mois_factures.php">
	<td><input name="reference" type="text" class="Style1" id="reference" style="width:150px" value="<?php echo $reference; ?>"></td>
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

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	if(isset($_REQUEST["action"]) or isset($_REQUEST["action_r"]))
	{ /*$date=dateFrToUs($_POST['date1']);$total=0;$date2=dateFrToUs($_POST['date2']);
	$dt1=$_POST['date1'];
	$dt2=$_POST['date2'];*/
	$reference=$_POST['reference'];
	
	/*$sql  = "SELECT * ";$espece="ESPECE";
	$sql .= "FROM porte_feuilles where date_enc='$date' ORDER BY id_registre_regl;";
	$users11 = db_query($database_name, $sql);*/
	$date_aout="2010-08-01";
	$sql  = "SELECT id,date_remise,date_cheque,date_echeance,date_virement,date_enc,client,client_tire,client_tire_e,vendeur,numero_cheque,numero_effet,v_banque,facture_n,impaye,numero_virement,
	sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet,sum(m_virement) as total_virement
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix ";
	$sql .= "FROM porte_feuilles where (chq_f=1 or esp_f=1 or eff_f=1 or vir_f=1) and facture_n=0 and (numero_cheque like '$reference%' or numero_effet like '$reference%' or numero_virement like '$reference%') group by id ORDER BY date_cheque,date_echeance;";
	$users11 = db_query($database_name, $sql);
	
?>


<span style="font-size:24px"><?php echo "Encaissments A facturer sur : ".$reference; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "Client";?></th>
	<th><?php echo "date encaiss";?></th>
	<th><?php echo "Ref.enc";?></th>
	
	<th><?php echo "M.Esp";?></th>
	
	
	<th><?php echo "M.Effet";?></th>
	<th><?php echo "date echeance";?></th>
	
	<th><?php echo "M.Cheque";?></th>
	<th><?php echo "date cheque";?></th>
	
	<th><?php echo "Soldé";?></th>
	
</tr>

<?php $compteur1=0;$total_g=0;$total_e=0;$total_c=0;$total_t=0;$total_ee=0;$d="";
while($users_1 = fetch_array($users11)) { $date_enc=$users_1["date_enc"];$vendeur=$users_1["vendeur"];$impaye=$users_1["impaye"];$ch=$users_1["numero_cheque"];
			$id_porte_feuille=$users_1["id"];
			if ($ch<>"" and $ch<>"0"){$ch="Chq/".$ch;}else{$ch="";}
			$eff=$users_1["numero_effet"];
			if ($eff<>"" and $eff<>"0"){$eff="Eff/".$eff;}else{$eff="";}
			$vir=$users_1["numero_cheque_v"];
			if ($vir<>"" and $vir<>"0"){$vir="Vir/".$vir;}else{$vir="";}
			
			
			$ref=$ch." ".$eff;$facture_n=$users_1["facture_n"];$date_remise=$users_1["date_remise"];$id=$users_1["id"];$date_virement=$users_1["date_virement"];
			$client=$users_1["client"];$client_tire=$users_1["client_tire"];$client_tire_e=$users_1["client_tire_e"];$date_cheque=$users_1["date_cheque"];
			$client=$users_1["client"];$total_e=$users_1["total_e"];$total_avoir=$users_1["total_avoir"];$date_echeance=$users_1["date_echeance"];
			$total_cheque=$users_1["total_cheque"];$total_espece=$users_1["total_espece"];$total_effet=$users_1["total_effet"];$total_virement=$users_1["total_virement"];
			$total_diff_prix=$users_1["total_diff_prix"];
	$sql  = "SELECT * ";
	$sql .= "FROM clients where client='$client' ORDER BY id;";
	$users111 = db_query($database_name, $sql);$user_ = fetch_array($users111);
		$inputation=$user_["inputation"];$patente=$user_["patente"];
				
				/*if ($facture_n>9039){
				$sql  = "SELECT * ";
				$sql .= "FROM factures2016 where numero='$facture_n' ORDER BY id;";
				$users = db_query($database_name, $sql);$row = fetch_array($users);$d=$row["date_f"];$date_aout="2010-08-01";
				}else
				{
				
				
				
				$sql  = "SELECT * ";
				$sql .= "FROM factures where numero='$facture_n' ORDER BY id;";
				$users = db_query($database_name, $sql);$row = fetch_array($users);$d=$row["date_f"];$date_aout="2010-08-01";
				}*/
			?>

			<? echo "<tr><td><a href=\"enc_vers_facture.php?id=$id&reference=$reference\">$client</a></td>";?>
			
			<td><?php $d1= dateUsToFr($date_enc);print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$d1 </font>"); ?></td>
			<td><?php print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$ref </font>"); ?></td>
			
			
			<td align="right"><?php $total_c=$total_c+$total_cheque;$tchq=number_format($total_espece,2,',',' ');
			print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tchq </font>");
			 ?></td>
			
			
			
			<td align="right"><?php $total_c=$total_c+$total_cheque;$tchq=number_format($total_effet,2,',',' ');
			print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tchq </font>");
			 ?></td>
			 <td><?php $d1= dateUsToFr($date_echeance);if ($d1=="00/00/0000"){$d1="";}print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$d1 </font>"); ?></td>
			
			
			
			<td align="right"><?php $total_c=$total_c+$total_cheque;$tchq=number_format($total_cheque,2,',',' ');
			print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tchq </font>");
			 ?></td>
			 <td><?php $d1= dateUsToFr($date_cheque);if ($d1=="00/00/0000"){$d1="";}print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$d1 </font>"); ?></td>
			 
			 <td align="right"><?php $total_v=$total_v+$total_virement;$tchq=number_format($total_virement,2,',',' ');
			print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tchq </font>");
			 ?></td>
			 <td><?php $d1= dateUsToFr($date_virement);if ($d1=="00/00/0000"){$d1="";}print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$d1 </font>"); ?></td>
			 
			
						
<? 

///////////////
	$sql  = "SELECT * ";$t=0;
	$sql .= "FROM porte_feuilles_factures where id_porte_feuille='$id_porte_feuille' ORDER BY id;";
	$users111 = db_query($database_name, $sql);
	while($users_11 = fetch_array($users111)) 
	{ 
		$t=$t+$users_11["m_cheque"]+$users_11["m_espece"]+$users_11["m_effet"];
	
	}
	?>
	<?php $tchq=number_format($t,2,',',' ');
			
			 ?>
			 <? echo "<td><a href=\"enc_vers_facture1.php?id=$id&reference=$reference\">$tchq</a></td>";?>
			 
			</tr>
			 
			 <?

/////////////////

} 




?>

			
</table>
</strong>
<p style="text-align:center">


<? }?>
</body>

</html>