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
			$libelle1=$_REQUEST["libelle1"];
			$montant1=$_REQUEST["montant1"];
			$libelle2=$_REQUEST["libelle2"];
			$montant2=$_REQUEST["montant2"];
			$libelle3=$_REQUEST["libelle3"];
			$montant3=$_REQUEST["montant3"];
			$libelle4=$_REQUEST["libelle4"];
			$montant4=$_REQUEST["montant4"];
			$libelle5=$_REQUEST["libelle5"];
			$montant5=$_REQUEST["montant5"];
			$libelle6=$_REQUEST["libelle6"];
			$montant6=$_REQUEST["montant6"];
			$libelle7=$_REQUEST["libelle7"];
			$montant7=$_REQUEST["montant7"];
			$libelle8=$_REQUEST["libelle8"];
			$montant8=$_REQUEST["montant8"];
			$objet1=$_REQUEST["objet1"];$cheque1=$_REQUEST["cheque1"];
			$objet2=$_REQUEST["objet2"];$cheque2=$_REQUEST["cheque2"];
			$objet3=$_REQUEST["objet3"];$cheque3=$_REQUEST["cheque3"];
			$objet4=$_REQUEST["objet4"];$cheque4=$_REQUEST["cheque4"];
			$objet5=$_REQUEST["objet5"];$cheque5=$_REQUEST["cheque5"];
			$objet6=$_REQUEST["objet6"];$cheque6=$_REQUEST["cheque6"];
			$objet7=$_REQUEST["objet7"];$cheque7=$_REQUEST["cheque7"];
			$objet8=$_REQUEST["objet8"];$cheque8=$_REQUEST["cheque8"];
			$objet9=$_REQUEST["objet9"];$cheque9=$_REQUEST["cheque9"];
			$objet10=$_REQUEST["objet10"];$cheque10=$_REQUEST["cheque10"];
			$date_cheque1=dateFrToUs($_REQUEST["date_cheque1"]);$ref1=$_REQUEST["ref1"];
			$date_cheque2=dateFrToUs($_REQUEST["date_cheque2"]);$ref2=$_REQUEST["ref2"];
			$date_cheque3=dateFrToUs($_REQUEST["date_cheque3"]);$ref3=$_REQUEST["ref3"];
			$date_cheque4=dateFrToUs($_REQUEST["date_cheque4"]);$ref4=$_REQUEST["ref4"];
			$date_cheque5=dateFrToUs($_REQUEST["date_cheque5"]);$ref5=$_REQUEST["ref5"];
			$date_cheque6=dateFrToUs($_REQUEST["date_cheque6"]);$ref6=$_REQUEST["ref6"];
			$date_cheque7=dateFrToUs($_REQUEST["date_cheque7"]);$ref7=$_REQUEST["ref7"];
			$date_cheque8=dateFrToUs($_REQUEST["date_cheque8"]);$ref8=$_REQUEST["ref8"];
			$date_cheque9=dateFrToUs($_REQUEST["date_cheque9"]);$ref9=$_REQUEST["ref9"];
			$date_cheque10=dateFrToUs($_REQUEST["date_cheque10"]);$ref10=$_REQUEST["ref10"];
						if(isset($_REQUEST["valider_caisse"])) { $valider_caisse = 1; } else { $valider_caisse = 0; }
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
	// recherche contrat			
				$code_produit="";
				$date = dateFrToUs($_REQUEST["date"]);
				list($annee1,$mois1,$jour1) = explode('-', $date); 
				$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
				$mois=date("M",$pdu);$annee=date("Y",$pdu);
				if ($mois=="May"){$mois1="05";}
				if ($mois=="Jun"){$mois1="06";}
				if ($mois=="Jul"){$mois1="07";}
				if ($mois=="Aug"){$mois1="08";}
				if ($mois=="Sep"){$mois1="09";}
				if ($mois=="Oct"){$mois1="10";}
				if ($mois=="Nov"){$mois1="11";}
				if ($mois=="Dec"){$mois1="12";}
				if ($mois=="Jan"){$mois1="01";}
				if ($mois=="Feb"){$mois1="02";}
				if ($mois=="Mar"){$mois1="03";}
				if ($mois=="Apr"){$mois1="04";}
				$result = mysql_query("SELECT bon_sortie FROM registre_reglements where (mois='$mois1' and annee='$annee') ORDER BY bon_sortie DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$dir_eval = $row["bon_sortie"]+1;
				if ($dir_eval<10){$dev="00".$dir_eval;}
				if ($dir_eval>9 and $dir_eval<100) {$dev="0".$dir_eval;}
				if ($dir_eval>=100){$dev=$dir_eval;}

				$type_service="SEJOURS ET CIRCUITS";

				$sql  = "INSERT INTO registre_reglements (date,service,vendeur,bon_sortie,mois,annee,date_open,user_open,libelle1,montant1,
				libelle2,montant2,libelle3,montant3,libelle4,montant4,libelle5,montant5,libelle6,montant6,libelle7,montant7,libelle8,montant8
				,objet1,cheque1,date_cheque1,ref1,
				date_cheque2,ref2,
				date_cheque3,ref3,
				date_cheque4,ref4,
				date_cheque5,ref5,
				date_cheque6,ref6,
				date_cheque7,ref7,
				date_cheque8,ref8,
				date_cheque9,ref9,
				date_cheque10,ref10,
				objet2,cheque2,objet3,cheque3,objet4,cheque4,objet5,cheque5,objet6,cheque6,objet7,cheque7,objet8,cheque8,
				objet9,cheque9,objet10,cheque10,observation)
				 VALUES ('$date','$service','$vendeur','$dev','$mois1','$annee','$date_open','$user_open','$libelle1','$montant1',
				 '$libelle2','$montant2','$libelle3','$montant3','$libelle4','$montant4','$libelle5','$montant5','$libelle6','$montant6','$libelle7','$montant7','$libelle8','$montant8',
				 '$objet1','$cheque1','$date_cheque1','$ref1',
				 '$date_cheque2','$ref2',
				 '$date_cheque3','$ref3',
				 '$date_cheque4','$ref4',
				 '$date_cheque5','$ref5',
				 '$date_cheque6','$ref6',
				 '$date_cheque7','$ref7',
				 '$date_cheque8','$ref8',
				 '$date_cheque9','$ref9',
				 '$date_cheque10','$ref10',
				 '$objet2','$cheque2','$objet3','$cheque3','$objet4','$cheque4','$objet5','$cheque5','$objet6','$cheque6',
				 '$objet7','$cheque7','$objet8','$cheque8','$objet9','$cheque9','$objet10','$cheque10','$observation')";

				db_query($database_name, $sql);$id_registre=mysql_insert_id();$impaye="impaye";$impaye1=1;
				
				
				if ($objet1<>""){
				$sql1  = "INSERT INTO porte_feuilles 
				(vendeur,impaye,client ,evaluation,date_enc,id_registre_regl,date_cheque,m_cheque,numero_cheque)
				VALUES ('$vendeur','$impaye1','$objet1','$impaye','$date_open','$id_registre','$date_cheque1','$cheque1','$ref1')";
				db_query($database_name, $sql1);}
				if ($objet2<>""){
				$sql1  = "INSERT INTO porte_feuilles 
				(vendeur,impaye,client ,evaluation,date_enc,id_registre_regl,date_cheque,m_cheque,numero_cheque)
				VALUES ('$vendeur','$impaye1','$objet2','$impaye','$date_open','$id_registre','$date_cheque2','$cheque2','$ref2')";
				db_query($database_name, $sql1);}
				if ($objet3<>""){
				$sql1  = "INSERT INTO porte_feuilles 
				(vendeur,impaye,client ,evaluation,date_enc,id_registre_regl,date_cheque,m_cheque,numero_cheque)
				VALUES ('$vendeur','$impaye1','$objet3','$impaye','$date_open','$id_registre','$date_cheque3','$cheque3','$ref3')";
				db_query($database_name, $sql1);}
				if ($objet4<>""){
				$sql1  = "INSERT INTO porte_feuilles 
				(vendeur,impaye,client ,evaluation,date_enc,id_registre_regl,date_cheque,m_cheque,numero_cheque)
				VALUES ('$vendeur','$impaye1','$objet4','$impaye','$date_open','$id_registre','$date_cheque4','$cheque4','$ref4')";
				db_query($database_name, $sql1);}
				if ($objet5<>""){
				$sql1  = "INSERT INTO porte_feuilles 
				(vendeur,impaye,client ,evaluation,date_enc,id_registre_regl,date_cheque,m_cheque,numero_cheque)
				VALUES ('$vendeur','$impaye1','$objet5','$impaye','$date_open','$id_registre','$date_cheque5','$cheque5','$ref5')";
				db_query($database_name, $sql1);}
				if ($objet6<>""){
				$sql1  = "INSERT INTO porte_feuilles 
				(vendeur,impaye,client ,evaluation,date_enc,id_registre_regl,date_cheque,m_cheque,numero_cheque)
				VALUES ('$vendeur','$impaye1','$objet6','$impaye','$date_open','$id_registre','$date_cheque6','$cheque6','$ref6')";
				db_query($database_name, $sql1);}
				if ($objet7<>""){
				$sql1  = "INSERT INTO porte_feuilles 
				(vendeur,impaye,client ,evaluation,date_enc,id_registre_regl,date_cheque,m_cheque,numero_cheque)
				VALUES ('$vendeur','$impaye1','$objet7','$impaye','$date_open','$id_registre','$date_cheque7','$cheque7','$ref7')";
				db_query($database_name, $sql1);}
				if ($objet8<>""){
				$sql1  = "INSERT INTO porte_feuilles 
				(vendeur,impaye,client ,evaluation,date_enc,id_registre_regl,date_cheque,m_cheque,numero_cheque)
				VALUES ('$vendeur','$impaye1','$objet8','$impaye','$date_open','$id_registre','$date_cheque8','$cheque8','$ref8')";
				db_query($database_name, $sql1);}
				if ($objet9<>""){
				$sql1  = "INSERT INTO porte_feuilles 
				(vendeur,impaye,client ,evaluation,date_enc,id_registre_regl,date_cheque,m_cheque,numero_cheque)
				VALUES ('$vendeur','$impaye1','$objet9','$impaye','$date_open','$id_registre','$date_cheque9','$cheque9','$ref9')";
				db_query($database_name, $sql1);}
				if ($objet10<>""){
				$sql1  = "INSERT INTO porte_feuilles 
				(vendeur,impaye,client ,evaluation,date_enc,id_registre_regl,date_cheque,m_cheque,numero_cheque)
				VALUES ('$vendeur','$impaye1','$objet10','$impaye','$date_open','$id_registre','$date_cheque10','$cheque10','$ref10')";
				db_query($database_name, $sql1);}

				
				
				
			

			break;

			case "update_user":
							$date = dateFrToUs($_REQUEST["date"]);
				list($annee1,$mois1,$jour1) = explode('-', $date); 
				$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
				$mois=date("M",$pdu);$annee=date("Y",$pdu);
				if ($mois=="May"){$mois1="05";}
				if ($mois=="Jun"){$mois1="06";}
				if ($mois=="Jul"){$mois1="07";}
				if ($mois=="Aug"){$mois1="08";}
				if ($mois=="Sep"){$mois1="09";}
				if ($mois=="Oct"){$mois1="10";}
				if ($mois=="Nov"){$mois1="11";}
				if ($mois=="Dec"){$mois1="12";}
				if ($mois=="Jan"){$mois1="01";}
				if ($mois=="Feb"){$mois1="02";}
				if ($mois=="Mar"){$mois1="03";}
				if ($mois=="Apr"){$mois1="04";}
				$result = mysql_query("SELECT bon_sortie FROM registre_reglements where (mois='$mois1' and annee='$annee') ORDER BY bon_sortie DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$dir_eval = $row["bon_sortie"]+1;
				if ($dir_eval<10){$dev="00".$dir_eval;}
				if ($dir_eval>9 and $dir_eval<100) {$dev="0".$dir_eval;}
				if ($dir_eval>=100){$dev=$dir_eval;}
				
				
						if ($valider_caisse==1)
				
				
				{$caisse="MPS";$type=$vendeur;
				
				
//////////////////:espece
		$a="A";$id_registre=$_REQUEST["user_id"];	$total_e=0;$total_c=0;$total_t=0;

		$sql  = "SELECT numero_cheque,client,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece
		, sum(m_effet) as total_effet,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql .= "FROM porte_feuilles where impaye=0 and id_registre_regl='$id_registre' and numero_cheque<>'$a' Group BY id;";
$users11 = db_query($database_name, $sql);
/*while($row = mysql_fetch_array($result))*/
while($row = fetch_array($users11))
{

	$client = $row['client'];
	$total_e = $row['total_e'];
	$total_avoir = $row['total_avoir'];
	$total_diff_prix = $row['total_diff_prix'];
	$total_cheque = $row['total_cheque'];
	$total_espece = $row['total_espece'];
	$total_effet = $row['total_effet'];
	$total_virement = $row['total_virement'];
	$t_espece=$t_espece+$total_espece-$total_avoir-$total_diff_prix;
	
	if ($id_registre==704)
	{$v=0;}
	else{$v=$total_espece-($total_avoir+$total_diff_prix);}
}
	$t_espe=number_format($t_espece,2,',',' ');

	$sql  = "SELECT * ";
	$sql .= "FROM registre_reglements where id='$id_registre' ORDER BY id;";
	$users11 = db_query($database_name, $sql);$user_ = fetch_array($users11);
		$libelle1=$user_["libelle1"];$montant1=$user_["montant1"];$obs=$user_["observation"];
		$libelle2=$user_["libelle2"];$montant2=$user_["montant2"];$libelle="Encaissement sur $vendeur / $obs";
		$libelle3=$user_["libelle3"];$montant3=$user_["montant3"];
		$libelle4=$user_["libelle4"];$montant4=$user_["montant4"];
		$libelle5=$user_["libelle5"];$montant5=$user_["montant5"];
		$libelle6=$user_["libelle6"];$montant6=$user_["montant6"];
		$libelle7=$user_["libelle7"];$montant7=$user_["montant7"];
		$libelle8=$user_["libelle8"];$montant8=$user_["montant8"];
		$objet1=$user_["objet1"];$cheque1=$user_["cheque1"];
		$objet2=$user_["objet2"];$cheque2=$user_["cheque2"];
		$objet3=$user_["objet3"];$cheque3=$user_["cheque3"];
		$objet4=$user_["objet4"];$cheque4=$user_["cheque4"];
		$objet5=$user_["objet5"];$cheque5=$user_["cheque5"];
		$objet6=$user_["objet6"];$cheque6=$user_["cheque6"];
		$objet7=$user_["objet7"];$cheque7=$user_["cheque7"];
		$objet8=$user_["objet8"];$cheque8=$user_["cheque8"];
		$objet9=$user_["objet9"];$cheque9=$user_["cheque9"];
		$objet10=$user_["objet10"];$cheque10=$user_["cheque10"];
		$date_cheque1=dateUsToFr($user_["date_cheque1"]);$ref1=$user_["ref1"];
		$date_cheque2=dateUsToFr($user_["date_cheque2"]);$ref2=$user_["ref2"];
		$date_cheque3=dateUsToFr($user_["date_cheque3"]);$ref3=$user_["ref3"];
		$date_cheque4=dateUsToFr($user_["date_cheque4"]);$ref4=$user_["ref4"];
		$date_cheque5=dateUsToFr($user_["date_cheque5"]);$ref5=$user_["ref5"];
		$date_cheque6=dateUsToFr($user_["date_cheque6"]);$ref6=$user_["ref6"];
		$date_cheque7=dateUsToFr($user_["date_cheque7"]);$ref7=$user_["ref7"];
		$date_cheque8=dateUsToFr($user_["date_cheque8"]);$ref8=$user_["ref8"];
		$date_cheque9=dateUsToFr($user_["date_cheque9"]);$ref9=$user_["ref9"];
		$date_cheque10=dateUsToFr($user_["date_cheque10"]);$ref10=$user_["ref10"];
		$obj1=$objet1."-".$date_cheque1."-".$ref1;
		$obj2=$objet2."-".$date_cheque2."-".$ref2;
		$obj3=$objet3."-".$date_cheque3."-".$ref3;
		$obj4=$objet4."-".$date_cheque4."-".$ref4;
		$obj5=$objet5."-".$date_cheque5."-".$ref5;
		$obj6=$objet6."-".$date_cheque6."-".$ref6;
		$obj7=$objet7."-".$date_cheque7."-".$ref7;
		$obj8=$objet8."-".$date_cheque8."-".$ref8;
		$obj9=$objet9."-".$date_cheque9."-".$ref9;
		$obj10=$objet10."-".$date_cheque10."-".$ref10;
	
	$net=number_format($t_espece-($montant1+$montant2+$montant3+$montant4+$montant5+$montant6+$montant7+$montant8),2,',',' ');
		
	$sql  = "SELECT * ";$t_imp=0;
	$sql .= "FROM porte_feuilles_impayes where tableau='$id_registre' Group BY id;";
	$users11 = db_query($database_name, $sql);
		
	while($row1 = fetch_array($users11))
	{

	$libelle11 = "Encaisst. impayé / ".$row1['client']."/".$row1['numero_cheque_imp'];
	$m_espece_imp = $row1['m_espece'];
	$m_virement_imp = $row1['m_virement'];
	$m_cheque_imp = $row1['m_cheque'];
	/*$t_imp=$t_imp+$m_espece_imp+$m_virement_imp+$m_cheque_imp;*/
	$t_imp=$t_imp+$m_espece_imp;
	$l="";$m_effet_imp=0;
	}
	$cheque=$cheque1+$cheque2+$cheque3+$cheque4+$cheque5+$cheque6+$cheque7+$cheque8+$cheque9+$cheque10;
	/*$cheque=0;*/
	$net_enc=$t_espece-($montant1+$montant2+$montant3+$montant4+$montant5+$montant6+$montant7+$montant8)+$cheque+$t_imp;

////////////////////////
	if ($net_enc>0){$debit=$net_enc;$credit=0;}else{$debit=0;$credit=$net_enc*-1;}
				$id_registre=$_REQUEST["user_id"];
				$sql  = "INSERT INTO journal_caisses ( date,id_registre,caisse,libelle,type,debit,credit ) VALUES ( ";
				$sql .= "'".$date . "',";
				$sql .= "'".$id_registre . "',";
				$sql .= "'".$caisse . "',";
				$sql .= "'".$libelle . "',";
				$sql .= "'".$type . "',";
				$sql .= "'".$debit . "',";
				$sql .= "'".$credit . "');";
				db_query($database_name, $sql);}
				
				else
				{
			$id_registre=$_REQUEST["user_id"];
			$sql = "DELETE FROM journal_caisses WHERE id_registre = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);}		
				
				
				
				

			$sql = "UPDATE registre_reglements SET ";
			$sql .= "service = '" . $_REQUEST["service"] . "', ";
			$sql .= "date = '" . $date . "', ";
			$sql .= "bon_sortie = '" . $dev . "', ";
			$sql .= "valider_caisse = '" . $valider_caisse . "', ";
			$sql .= "mois = '" . $mois1 . "', ";
			$sql .= "annee = '" . $annee . "', ";
			$sql .= "observation = '" . $observation . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			$sql .= "libelle1 = '" . $libelle1 . "', ";
			$sql .= "montant1 = '" . $montant1 . "', ";
			$sql .= "libelle2 = '" . $libelle2 . "', ";
			$sql .= "montant2 = '" . $montant2 . "', ";
			$sql .= "libelle3 = '" . $libelle3 . "', ";
			$sql .= "montant3 = '" . $montant3 . "', ";
			$sql .= "libelle4 = '" . $libelle4 . "', ";
			$sql .= "montant4 = '" . $montant4 . "', ";
			$sql .= "libelle5 = '" . $libelle5 . "', ";
			$sql .= "montant5 = '" . $montant5 . "', ";
			$sql .= "libelle6 = '" . $libelle6 . "', ";
			$sql .= "montant6 = '" . $montant6 . "', ";
			$sql .= "libelle7 = '" . $libelle7 . "', ";
			$sql .= "montant7 = '" . $montant7 . "', ";
			$sql .= "libelle8 = '" . $libelle8 . "', ";
			$sql .= "montant8 = '" . $montant8 . "', ";
			$sql .= "objet1 = '" . $objet1 . "', ";
			$sql .= "cheque1 = '" . $cheque1 . "', ";
			$sql .= "objet2 = '" . $objet2 . "', ";
			$sql .= "cheque2 = '" . $cheque2 . "', ";
			$sql .= "objet3 = '" . $objet3 . "', ";
			$sql .= "cheque3 = '" . $cheque3 . "', ";
			$sql .= "objet4 = '" . $objet4 . "', ";
			$sql .= "cheque4 = '" . $cheque4 . "', ";
			$sql .= "objet5 = '" . $objet5 . "', ";
			$sql .= "cheque5 = '" . $cheque5 . "', ";
			$sql .= "objet6 = '" . $objet6 . "', ";
			$sql .= "cheque6 = '" . $cheque6 . "', ";
			$sql .= "objet7 = '" . $objet7 . "', ";
			$sql .= "cheque7 = '" . $cheque7 . "', ";
			$sql .= "objet8 = '" . $objet8 . "', ";
			$sql .= "cheque8 = '" . $cheque8 . "', ";
			$sql .= "objet9 = '" . $objet9 . "', ";
			$sql .= "cheque9 = '" . $cheque9 . "', ";
			$sql .= "objet10 = '" . $objet10 . "', ";
			$sql .= "cheque10 = '" . $cheque10 . "', ";
			$sql .= "date_cheque1 = '" . $date_cheque1 . "', ";
			$sql .= "ref1 = '" . $ref1 . "', ";
			$sql .= "date_cheque2 = '" . $date_cheque2 . "', ";
			$sql .= "ref2 = '" . $ref2 . "', ";
			$sql .= "date_cheque3 = '" . $date_cheque3 . "', ";
			$sql .= "ref3 = '" . $ref3 . "', ";
			$sql .= "date_cheque4 = '" . $date_cheque4 . "', ";
			$sql .= "ref4 = '" . $ref4 . "', ";
			$sql .= "date_cheque5 = '" . $date_cheque5 . "', ";
			$sql .= "ref5 = '" . $ref5 . "', ";
			$sql .= "date_cheque6 = '" . $date_cheque6 . "', ";
			$sql .= "ref6 = '" . $ref6 . "', ";
			$sql .= "date_cheque7 = '" . $date_cheque7 . "', ";
			$sql .= "ref7 = '" . $ref7 . "', ";
			$sql .= "date_cheque8 = '" . $date_cheque8 . "', ";
			$sql .= "ref8 = '" . $ref8 . "', ";
			$sql .= "date_cheque9 = '" . $date_cheque9 . "', ";
			$sql .= "ref9 = '" . $ref9 . "', ";
			$sql .= "date_cheque10 = '" . $date_cheque10 . "', ";
			$sql .= "ref10 = '" . $ref10 . "', ";
			$sql .= "motif_cancel = '" . $motif_cancel . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);$impaye=1;$id_registre=$_REQUEST["user_id"];
			$sql = "DELETE FROM porte_feuilles WHERE impaye='$impaye' and id_registre_regl = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
				if ($objet1<>""){
				$sql1  = "INSERT INTO porte_feuilles 
				(vendeur,impaye,client ,evaluation,date_enc,id_registre_regl,date_cheque,m_cheque,numero_cheque)
				VALUES ('$vendeur','$impaye','$objet1','$impaye','$date_open','$id_registre','$date_cheque1','$cheque1','$ref1')";
				db_query($database_name, $sql1);}
				if ($objet2<>""){
				$sql1  = "INSERT INTO porte_feuilles 
				(vendeur,impaye,client ,evaluation,date_enc,id_registre_regl,date_cheque,m_cheque,numero_cheque)
				VALUES ('$vendeur','$impaye','$objet2','$impaye','$date_open','$id_registre','$date_cheque2','$cheque2','$ref2')";
				db_query($database_name, $sql1);}
				if ($objet3<>""){
				$sql1  = "INSERT INTO porte_feuilles 
				(vendeur,impaye,client ,evaluation,date_enc,id_registre_regl,date_cheque,m_cheque,numero_cheque)
				VALUES ('$vendeur','$impaye','$objet3','$impaye','$date_open','$id_registre','$date_cheque3','$cheque3','$ref3')";
				db_query($database_name, $sql1);}
				if ($objet4<>""){
				$sql1  = "INSERT INTO porte_feuilles 
				(vendeur,impaye,client ,evaluation,date_enc,id_registre_regl,date_cheque,m_cheque,numero_cheque)
				VALUES ('$vendeur','$impaye','$objet4','$impaye','$date_open','$id_registre','$date_cheque4','$cheque4','$ref4')";
				db_query($database_name, $sql1);}
				if ($objet5<>""){
				$sql1  = "INSERT INTO porte_feuilles 
				(vendeur,impaye,client ,evaluation,date_enc,id_registre_regl,date_cheque,m_cheque,numero_cheque)
				VALUES ('$vendeur','$impaye','$objet5','$impaye','$date_open','$id_registre','$date_cheque5','$cheque5','$ref5')";
				db_query($database_name, $sql1);}
				if ($objet6<>""){
				$sql1  = "INSERT INTO porte_feuilles 
				(vendeur,impaye,client ,evaluation,date_enc,id_registre_regl,date_cheque,m_cheque,numero_cheque)
				VALUES ('$vendeur','$impaye','$objet6','$impaye','$date_open','$id_registre','$date_cheque6','$cheque6','$ref6')";
				db_query($database_name, $sql1);}
				if ($objet7<>""){
				$sql1  = "INSERT INTO porte_feuilles 
				(vendeur,impaye,client ,evaluation,date_enc,id_registre_regl,date_cheque,m_cheque,numero_cheque)
				VALUES ('$vendeur','$impaye','$objet7','$impaye','$date_open','$id_registre','$date_cheque7','$cheque7','$ref7')";
				db_query($database_name, $sql1);}
				if ($objet8<>""){
				$sql1  = "INSERT INTO porte_feuilles 
				(vendeur,impaye,client ,evaluation,date_enc,id_registre_regl,date_cheque,m_cheque,numero_cheque)
				VALUES ('$vendeur','$impaye','$objet8','$impaye','$date_open','$id_registre','$date_cheque8','$cheque8','$ref8')";
				db_query($database_name, $sql1);}
				if ($objet9<>""){
				$sql1  = "INSERT INTO porte_feuilles 
				(vendeur,impaye,client ,evaluation,date_enc,id_registre_regl,date_cheque,m_cheque,numero_cheque)
				VALUES ('$vendeur','$impaye','$objet9','$impaye','$date_open','$id_registre','$date_cheque9','$cheque9','$ref9')";
				db_query($database_name, $sql1);}
				if ($objet10<>""){
				$sql1  = "INSERT INTO porte_feuilles 
				(vendeur,impaye,client ,evaluation,date_enc,id_registre_regl,date_cheque,m_cheque,numero_cheque)
				VALUES ('$vendeur','$impaye','$objet10','$impaye','$date_open','$id_registre','$date_cheque10','$cheque10','$ref10')";
				db_query($database_name, $sql1);}



			
			break;
			
			case "delete_user":
			
			
			// delete user's profile
			$sql = "DELETE FROM registre_reglements WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			$sql = "DELETE FROM porte_feuilles WHERE id_registre_regl = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			$sql = "DELETE FROM journal_caisses WHERE id_registre = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			
			
			
			break;


		} //switch
	} //if
	
	else {$vendeur="";$date1="";$date2="";}
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
	<form id="form" name="form" method="post" action="maj_porte_feuilles.php">
	<td><?php echo "Du : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au : "; ?><input onClick="ds_sh(this);" name="date2" value="<?php echo $date2; ?>" readonly="readonly" style="cursor: text" /></td>
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
	function EditUser(user_id) { document.location = "registre_reglement1.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	if (isset($_REQUEST["action_l"])){
	$date=$_GET['date1'];$vendeur=$_GET['vendeur'];$date2=$_GET['date2'];
	$date_d1=$_GET['date1'];$date_d2=$_GET['date2'];
	$de1=$_GET['date1'];$de2=$_GET['date2'];
	}

	if(isset($_REQUEST["action"]))
	{ $date=dateFrToUs($_POST['date1']);$vendeur=$_POST['vendeur'];$date2=dateFrToUs($_POST['date2']);
	$date_d1=dateFrToUs($_POST['date1']);$date_d2=dateFrToUs($_POST['date2']);
	$de1=dateFrToUs($_POST['date1']);$de2=dateFrToUs($_POST['date2']);}
	
	
	if (isset($_REQUEST["action_l"]) or isset($_REQUEST["action"])){
	$sql  = "SELECT * ";
	$sql .= "FROM registre_reglements where (date between '$date' and '$date2') and vendeur='$vendeur' ORDER BY id;";
	$users11 = db_query($database_name, $sql);



?>


<span style="font-size:24px"><?php echo dateUsToFr($date)."---> ".$vendeur; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Bon Sortie";?></th>
	<th><?php echo "Tableau Enc";?></th>
	<th><?php echo "Encaissé/Eval";?></th>
	<th><?php echo "Encaissé/Fact";?></th>
</tr>

<?php $compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { $id_r=$users_1["id"];$date_enc=$users_1["date"];$vendeur=$users_1["vendeur"];
			$statut=$users_1["statut"];$observation=$users_1["observation"];$dest=$users_1["service"];$valider_caisse=$users_1["valider_caisse"];
			$service=$users_1["service"];$code=$users_1["code_produit"];$id_tableau=$users_1["id"]."/2008";$bon=$users_1["statut"];?><tr>
			<td><a href="JavaScript:EditUser(<?php echo $users_1["id"]; ?>)"><?php echo dateUsToFr($users_1["date"]); ?></A></td>
			<td><?php echo $users_1["observation"]; ?></td>
			<?php $t=$users_1["bon_sortie"]."/".$users_1["mois"]."".$users_1["annee"]; ?>
			<? $sql = "UPDATE porte_feuilles SET ";
			$sql .= "date_enc = '" . $date_enc . "' ";
			$sql .= "WHERE id_registre_regl = " . $id_r . ";";
			db_query($database_name, $sql);?>
			<? echo "<td><a href=\"\\mps\\tutorial\\tableau_encaissement.php?dest=$dest&t=$t&id_registre=$id_r&date_enc=$date_enc&vendeur=$vendeur&bon_sortie=$observation\">".$t."</a></td>";?>
			<?  /*echo "<td><a href=\"tableau_enc.php?dest=$dest&t=$t&id_registre=$id_r&date_enc=$date_enc&vendeur=$vendeur&bon_sortie=$observation\">".$t."</a></td>";*/?>
	<? $sql  = "SELECT * ";
	$sql .= "FROM commandes where id_registre_regl=$id_r ORDER BY date_e;";
	$users = db_query($database_name, $sql);
	$total_g=0;
	while($users_ = fetch_array($users)) { 
		$commande=$users_["commande"];$evaluation=$users_["evaluation"];$client=$users_["client"];$date11=dateUsToFr($users_["date_e"]);
		$numero=$users_["commande"];$sans_remise=$users_["sans_remise"];$remise10=$users_["remise_10"];
		$remise2=$users_["remise_2"];$remise3=$users_["remise_3"];
		$id=$users_["id"];
		$net=$users_["net"];; 
		$total_g=$total_g+$net;
	 }
	$sql  = "SELECT * ";
	$sql .= "FROM factures where id_registre_regl=$id_r ORDER BY date_f;";
	$users = db_query($database_name, $sql);
	$total_gf=0;
	while($users_ = fetch_array($users)) { 
		$net=$users_["montant"];
		$total_gf=$total_gf+$net;
	 }
	 //reports
	 $ev="";$fa="";
 	$sql12  = "SELECT numero_cheque,client,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql12 .= "FROM porte_feuilles where id_registre_regl='$id_r' and facture_n='$fa' Group BY id_registre_regl;";
	$users1111 = db_query($database_name, $sql12);
	$users_111 = fetch_array($users1111);
	$client=$users_111["client"];$total_e=$users_111["total_e"];$total_avoir=$users_111["total_avoir"];
	$total_cheque=$users_111["total_cheque"];$total_espece=$users_111["total_espece"];$total_effet=$users_111["total_effet"];
	$total_diff_prix=$users_111["total_diff_prix"];$total_virement=$users_111["total_virement"];
	$total_eval=$total_espece+$total_cheque+$total_effet+$total_virement-($total_avoir+$total_diff_prix);
	$total_eval=number_format($total_eval,2,',',' ');
	 
	 $ev="";$fa="";
 	$sql12  = "SELECT numero_cheque,client,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql12 .= "FROM porte_feuilles where id_registre_regl='$id_r' and facture_n<>'$fa' Group BY id_registre_regl;";
	$users1111 = db_query($database_name, $sql12);
	$users_111 = fetch_array($users1111);
	$client=$users_111["client"];$total_e=$users_111["total_e"];$total_avoir=$users_111["total_avoir"];
	$total_cheque=$users_111["total_cheque"];$total_espece=$users_111["total_espece"];$total_effet=$users_111["total_effet"];
	$total_diff_prix=$users_111["total_diff_prix"];$total_virement=$users_111["total_virement"];
	$total_fa=$total_espece+$total_cheque+$total_effet+$total_virement-($total_avoir+$total_diff_prix);
	$total_fa=number_format($total_fa,2,',',' ');
			 ?><? 
			$total_gf=number_format($total_gf,2,',',' ');?>
			<? 
			if ($valider_caisse<>1){?><td align="right"><?
			echo "<a href=\"reglements.php?bon_sortie=$observation&id_registre=$id_r&date_enc=$date_enc&vendeur=$vendeur&date1=$de1&date2=$de2\">$total_eval</a></td>";
			 ?><td align="right"><? echo "<a href=\"reglements1.php?id_registre=$id_r&date_enc=$date_enc&vendeur=$vendeur&bon_sortie=$observation&date1=$de1&date2=$de2\">$total_fa</a></td>";}
			 else
			{?><td align="right"><? echo "$total_eval</td>";
			 ?><td align="right"><? echo "$total_fa</td>";}
 } ?>

</table>
</strong>
<p style="text-align:center">
<table class="table2">
<? echo "<td><a href=\"registre_reglement.php?vendeur=$vendeur&date=$date&user_id=0\">"."Ajout Reglement"."</a></td>";?>
<? echo "<td><a href=\"\\mps\\tutorial\\enc_par_vendeur.php?date1=$date_d1&date2=$date_d2&vendeur=$vendeur\">Edition Tableau 1</a></td>";?>
<? echo "<td><a href=\"\\mps\\tutorial\\enc_par_vendeur_non_facture.php?date1=$date_d1&date2=$date_d2&vendeur=$vendeur\">Edition Tableau 2</a></td>";?>
</table>
<? }?>
</body>

</html>