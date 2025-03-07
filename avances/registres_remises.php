<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$user_name=GetUserName();
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$login = $user_["login"];
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
			$service="";
			$banque=$_REQUEST["banque"];
			$date_open=$_REQUEST["date_open"];
			$user_open=$user_name;
			$observation="";
			$motif_cancel="";
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
				$result = mysql_query("SELECT bon_sortie FROM registre_remises where (mois='$mois1' and annee='$annee') ORDER BY bon_sortie DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$dir_eval = $row["bon_sortie"]+1;
				if ($dir_eval<10){$dev="00".$dir_eval;}
				if ($dir_eval>9 and $dir_eval<100) {$dev="0".$dir_eval;}
				if ($dir_eval>=100){$dev=$dir_eval;}

				$type_service="SEJOURS ET CIRCUITS";

				$sql  = "INSERT INTO registre_remises (date,service,banque,bon_sortie,mois,annee,date_open,user_open,objet1,cheque1,date_cheque1,ref1,
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
				 VALUES 	('$date','$service','$banque','$dev','$mois1','$annee','$date_open','$user_open',
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
			
				
				if(isset($_REQUEST["locked"])) { $locked = 1; } else { $locked = 0; }
				if ($id_registre==0){}else{
				if ($locked==0){
				$sql  = "SELECT * ";
				$sql .= "FROM porte_feuilles_factures where remise=0 and m_cheque>0 and date_cheque<='$date' ORDER BY id;";
				$users = db_query($database_name, $sql);
				?><table><?
				while($users_ = fetch_array($users)) { $id=$users_["id"];$m_cheque=$users_["m_cheque"];
					$numero_cheque=$users_["numero_cheque"];$id_porte_feuille=$users_["id_porte_feuille"];$client=$users_["client"];
					//echo "<tr><td>$m_cheque</td><td>$numero_cheque</td></tr>";
					$sql = "UPDATE porte_feuilles_factures SET ";$remise=1;
					$sql .= "numero_remise = '" . $id_registre . "', ";
					$sql .= "remise_bq = '" . $banque . "', ";
					$sql .= "date_remise = '" . $date . "', ";
					/*$sql .= "date_cheque = '" . $date . "', ";*/
					$sql .= "remise = '" . $remise . "' ";
					$sql .= "WHERE id = " . $id . ";";
					db_query($database_name, $sql);
					
					////////////////////////////
					$sql = "UPDATE porte_feuilles SET ";$remise=1;
					$sql .= "numero_remise = '" . $id_registre . "', ";
					$sql .= "remise_bq = '" . $banque . "', ";
					$sql .= "date_remise = '" . $date . "', ";
					$sql .= "remise = '" . $remise . "' ";
					//$sql .= "WHERE client='$client' and numero_cheque = " . $numero_cheque . ";";
					$sql .= "WHERE remise=0 and numero_cheque = " . $numero_cheque . ";";
					db_query($database_name, $sql);
					
					 }
					
					 }
					 
									 
					 
					 }
					 ?></table>



			<? 

			break;

			case "update_user":
				$d_impaye1 = dateFrToUs($_REQUEST["d_impaye1"]);
				$d_impaye2 = dateFrToUs($_REQUEST["d_impaye2"]);
				$d_impaye3 = dateFrToUs($_REQUEST["d_impaye3"]);
				$d_impaye4 = dateFrToUs($_REQUEST["d_impaye4"]);
				if(isset($_REQUEST["r_impaye1"])) { $r_impaye1 = 1; } else { $r_impaye1 = 0; }
				if(isset($_REQUEST["r_impaye2"])) { $r_impaye2 = 1; } else { $r_impaye2 = 0; }
				if(isset($_REQUEST["r_impaye3"])) { $r_impaye3 = 1; } else { $r_impaye3 = 0; }
				if(isset($_REQUEST["r_impaye4"])) { $r_impaye4 = 1; } else { $r_impaye4 = 0; }
				
				
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
				$result = mysql_query("SELECT bon_sortie FROM registre_remises where (mois='$mois1' and annee='$annee') ORDER BY bon_sortie DESC LIMIT 0,1"); 
				$row = mysql_fetch_array($result); 
				$dir_eval = $row["bon_sortie"]+1;
				if ($dir_eval<10){$dev="00".$dir_eval;}
				if ($dir_eval>9 and $dir_eval<100) {$dev="0".$dir_eval;}
				if ($dir_eval>=100){$dev=$dir_eval;}

			$sql = "UPDATE registre_remises SET ";
			$sql .= "date = '" . $date . "', ";
			$sql .= "observation = '" . $observation . "', ";
			$sql .= "banque = '" . $banque . "', ";
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
			
			$sql .= "r_impaye1 = '" . $r_impaye1 . "', ";
			$sql .= "r_impaye2 = '" . $r_impaye2 . "', ";
			$sql .= "r_impaye3 = '" . $r_impaye3 . "', ";
			$sql .= "r_impaye4 = '" . $r_impaye4 . "', ";
			
			$sql .= "d_impaye1 = '" . $d_impaye1 . "', ";
			$sql .= "d_impaye2 = '" . $d_impaye2 . "', ";
			$sql .= "d_impaye3 = '" . $d_impaye3 . "', ";
			$sql .= "d_impaye4 = '" . $d_impaye4 . "', ";

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
				$sql  = "SELECT * ";
				$sql .= "FROM porte_feuilles_factures where remise=1 and numero_remise=$id_registre ORDER BY id;";
				$users = db_query($database_name, $sql);
				
				while($users_ = fetch_array($users)) { $id=$users_["id"];$m_cheque=$users_["m_cheque"];$numero_cheque=$users_["numero_cheque"];$id_porte_feuille=$users_["id_porte_feuille"];
					$sql = "UPDATE porte_feuilles_factures SET ";$remise=1;
					$sql .= "date_remise = '" . $date . "', ";
					$sql .= "remise = '" . $remise . "' ";
					$sql .= "WHERE id = " . $id . ";";
					db_query($database_name, $sql);

					/////////////////
					$sql = "UPDATE porte_feuilles SET ";$remise=1;
					$sql .= "date_remise = '" . $date . "', ";
					$sql .= "remise = '" . $remise . "' ";
					$sql .= "WHERE id = " . $id_porte_feuille . ";";
					db_query($database_name, $sql);
					
					 }

					
			break;
			
			case "delete_user":
				$id_registre=$_REQUEST["user_id"];
				$sql  = "SELECT * ";
				$sql .= "FROM porte_feuilles_factures where remise=1 and numero_remise=$id_registre ORDER BY id;";
				$users = db_query($database_name, $sql);$nr=0;$date1="0000-00-00";$remise=0;
				
				while($users_ = fetch_array($users)) { 
				$id=$users_["id"];$m_cheque=$users_["m_cheque"];$numero_cheque=$users_["numero_cheque"];$id_porte_feuille=$users_["id_porte_feuille"];
					$sql = "UPDATE porte_feuilles_factures SET ";
					$sql .= "date_remise = '" . $date1 . "', ";
					$sql .= "date_remise_e = '" . $date1 . "', ";
					$sql .= "numero_remise = '" . $nr . "', ";
					$sql .= "numero_remise_e = '" . $nr . "', ";
					$sql .= "remise = '" . $remise . "', ";
					$sql .= "remise = '" . $remise_e . "' ";
					$sql .= "WHERE id = " . $id . ";";
					db_query($database_name, $sql);
					
					
					//////////
					$sql = "UPDATE porte_feuilles SET ";
					$sql .= "date_remise = '" . $date1 . "', ";
					$sql .= "date_remise_e = '" . $date1 . "', ";
					$sql .= "numero_remise = '" . $nr . "', ";
					$sql .= "numero_remise_e = '" . $nr . "', ";
					$sql .= "remise = '" . $remise . "', ";
					$sql .= "remise = '" . $remise_e . "' ";
					$sql .= "WHERE id = " . $id_porte_feuille . ";";
					db_query($database_name, $sql);
					

					 }
				$sql  = "SELECT * ";
				$sql .= "FROM porte_feuilles_factures where remise_e=1 and numero_remise_e=$id_registre ORDER BY id;";
				$users1 = db_query($database_name, $sql);$nr=0;$date1="0000-00-00";$remise=0;
				
				while($users_ = fetch_array($users1)) { 
				$id=$users_["id"];$m_cheque=$users_["m_cheque"];$numero_cheque=$users_["numero_cheque"];$id_porte_feuille=$users_["id_porte_feuille"];
					$sql = "UPDATE porte_feuilles_factures SET ";
					$sql .= "date_remise_e = '" . $date1 . "', ";
					//$sql .= "date_echeance = '" . $date1 . "', ";
					$sql .= "numero_remise_e = '" . $nr . "', ";
					$sql .= "remise_e = '" . $remise . "' ";
					$sql .= "WHERE id = " . $id . ";";
					db_query($database_name, $sql);
					
					///////////////////
					$sql = "UPDATE porte_feuilles SET ";
					$sql .= "date_remise_e = '" . $date1 . "', ";
					//$sql .= "date_echeance = '" . $date1 . "', ";
					$sql .= "numero_remise_e = '" . $nr . "', ";
					$sql .= "remise_e = '" . $remise . "' ";
					$sql .= "WHERE id = " . $id_porte_feuille . ";";
					db_query($database_name, $sql);
					
					
					 }
									
			
			// delete user's profile
			$sql = "DELETE FROM registre_remises WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			$profile_id = GetUserProfile();	$user_name=GetUserName();$date_time=date("y-m-d h:m:s");
			$table_name="registre_remises";$record=$_REQUEST["user_id"];
				$sql  = "INSERT INTO deleted_files ( user,date_time,table_name,record ) VALUES ( ";
				$sql .= "'" . $user_name . "', ";
				$sql .= "'" . $date_time . "', ";
				$sql .= "'" . $table_name . "', ";
				$sql .= "'" . $record . "');";

				db_query($database_name, $sql);
			
			break;


		} //switch
	} //if		
	
	else {$banque="";$date1="";$date2="";}
	
	
	

////////////////////////////////////////////////

	
	if(isset($_REQUEST["action_"]) and $_REQUEST["action_"] != "delete_user") { $date1 = $_REQUEST["date"];}
	else {$banque="";$date1="";}
	$action="recherche";
	$banque_list = "";
	$sql = "SELECT * FROM  rs_data_banques ORDER BY banque;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($banque == $temp_["banque"]) { $selected = " selected"; } else { $selected = ""; }
		
		$banque_list .= "<OPTION VALUE=\"" . $temp_["banque"] . "\"" . $selected . ">";
		$banque_list .= $temp_["banque"];
		$banque_list .= "</OPTION>";
	}

	
	
	/////////////////////////////////////////////////////////////////////////////////////////////majg
	
	
	////////////////////////////////////////tableau
	if(isset($_REQUEST["Submit2"])) {?>
	
	<table class="table2">
	<?
	
	$t2=$_POST['utilities2'];$id_r=$_POST['id_r'];$date_remise_e=$_POST['date_remise_e'];
	reset($t2);$type_remise_effet=0;$remise=1;$selectionne=1;$m_effet_v=0;
	while (list($key, $val) = each($t2))
	 {   $val=stripslashes($val); 
	 
	 //
			$sql  = "SELECT id,id_porte_feuille,selectionne,client_tire,sum(m_effet) as total_effet,numero_effet,client_tire_e,v_banque_e,facture_n,client,date_echeance,type_remise_effet ";
			$sql .= "FROM porte_feuilles_factures where numero_effet='$val' ORDER BY id;";
			$users13 = db_query($database_name, $sql);$users1_3 = fetch_array($users13);$id_porte_feuille=$users1_3["id_porte_feuille"];$client=$users1_3["client_tire_e"];$numero_effet=$users1_3["numero_effet"];
			$m_effet=$users1_3["total_effet"];
								
					$sql = "UPDATE porte_feuilles_factures SET ";
					$sql .= "numero_remise_e = '" . $id_r . "', ";
					$sql .= "date_remise_e = '" . $date_remise_e . "', ";
					$sql .= "type_remise_effet = '" . $type_remise_effet . "', ";
					$sql .= "remise_e = '" . $remise . "' ";
					$sql .= "WHERE numero_effet = '" . $val . "';";
					db_query($database_name, $sql);
					
					////////////
					$sql = "UPDATE porte_feuilles SET ";
					$sql .= "numero_remise_e = '" . $id_r . "', ";
					$sql .= "date_remise_e = '" . $date_remise_e . "', ";
					$sql .= "remise_e = '" . $remise . "' ";
					$sql .= "WHERE numero_effet = " . $val . ";";
					db_query($database_name, $sql);
					?>
	<tr><td><? echo $numero_effet."</td><td>".$id_r."</td><td>".$date_remise_e."</td><td>".$client."</td>";?>
	<td align="right"><?php echo number_format($m_effet,2,',',' ');$m_effet_v=$m_effet_v+$m_effet;?></td></tr>	
	
		
	<?				
					
	 }?>
<tr><td></td><td></td><td></td><td></td>
<td align="right"><?php echo number_format($m_effet_v,2,',',' '); ?></td>	 
 </table>
	
	<? }
	
	////////////////////////////////////////////////////////////////////////////////////
	
	
	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="registres_remises.php">
	<td><?php echo "Du : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au : "; ?><input onClick="ds_sh(this);" name="date2" value="<?php echo $date2; ?>" readonly="readonly" style="cursor: text" /></td>
	<TR><td><?php echo "Banque Verssement : "; ?></td><td><select id="banque" name="banque"><?php echo $banque_list; ?></select></td></TR>
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
	function EditUser(user_id) { document.location = "registre_remise.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<? 	if (isset($_REQUEST["action_l"])){
	$date=$_GET['date1'];$banque=$_GET['banque'];$date2=$_GET['date2'];
	$date_d1=$_GET['date1'];$date_d2=$_GET['date2'];
	$de1=$_GET['date1'];$de2=$_GET['date2'];
	}

	if(isset($_REQUEST["action"]))
	{ $date=dateFrToUs($_POST['date1']);$banque=$_POST['banque'];$date2=dateFrToUs($_POST['date2']);
	$date_d1=dateFrToUs($_POST['date1']);$date_d2=dateFrToUs($_POST['date2']);
	$de1=dateFrToUs($_POST['date1']);$de2=dateFrToUs($_POST['date2']);}
	
	
	if (isset($_REQUEST["action_l"]) or isset($_REQUEST["action"])){
	$sql  = "SELECT * ";
	$sql .= "FROM registre_remises where (date between '$date' and '$date2') and banque='$banque' ORDER BY date;";
	$users11 = db_query($database_name, $sql);



?>


<span style="font-size:24px"><?php echo dateUsToFr($date)."---> ".$banque; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date Remise";?></th>
	<th><?php echo "Numero Remise";?></th>
	<th><?php echo "Cheques";?></th>
	
	<th><?php echo "Effets/Enc";?></th><th><?php echo "Effets/Escpt";?></th>
	<th><?php echo "Ajout";?></th>
</tr>

<?php 
$compteur1=0;$total_g=0;$t_cheque=0;$t_eff=0;$t_eff1=0;
while($users_1 = fetch_array($users11)) { $id_r=$users_1["id"];$date_enc=$users_1["date"];$banque=$users_1["banque"];
			$statut=$users_1["statut"];$observation=$users_1["observation"];$dest=$users_1["service"];$date_remise=$users_1["date"];
			$service=$users_1["service"];$code=$users_1["code_produit"];$id_tableau=$users_1["id"]."/2008";$bon=$users_1["statut"];?><tr>
			<td><a href="JavaScript:EditUser(<?php echo $users_1["id"]; ?>)"><?php echo dateUsToFr($users_1["date"]); ?></A></td>
			<?php $t=$users_1["bon_sortie"]."/".$users_1["mois"]."".$users_1["annee"]; 
			$sql  = "SELECT * ";$a="";$date_d="2010-08-01";$date_dn="0000-00-00";
			$sql .= "FROM porte_feuilles_factures where numero_remise=$id_r and m_cheque<>0 and remise=1 and numero_cheque<>'$a'   ORDER BY id;";
			$users = db_query($database_name, $sql);
			$total_g=0;
			while($users_ = fetch_array($users)) { 
				$m_cheque=$users_["m_cheque"];
				$total_g=$total_g+$m_cheque;
			 }
			 $t_cheque=$t_cheque+$total_g;
			$total_c=number_format($total_g,2,',',' ');
			
			$sql  = "SELECT * ";
			$sql .= "FROM porte_feuilles_factures where numero_remise_e=$id_r and m_effet<>0 and remise_e=1 ORDER BY id;";
			$users1 = db_query($database_name, $sql);
			$total_e_enc=0;$total_e_escompte=0;
			while($users1_ = fetch_array($users1)) { 
				$m_effet=$users1_["m_effet"];$numero_remise_e=$users1_["numero_remise"];$id=$users1_["id"];
				$remise_e=$users1_["remise"];$date_remise_e=$users1_["date_remise"];$type_remise_effet=$users1_["type_remise_effet"];
				if ($type_remise_effet==0){
				$total_e_enc=$total_e_enc+$m_effet;
				}
				if ($type_remise_effet==1){
				$total_e_escompte=$total_e_escompte+$m_effet;
				}
				
				
				
			 }
			 $t_eff=$t_eff+$total_e_enc;$t_eff1=$t_eff1+$total_e_escompte;
			$total_ef=number_format($total_e_enc,2,',',' ');$total_ef1=number_format($total_e_escompte,2,',',' ');
			?>
			<td align="right"
			<? 
			echo "<td><a href=\"\\mps\\tutorial\\tableau_remise.php?dest=$dest&t=$t&id_registre=$id_r&date_enc=$date_enc&banque=$banque&bon_sortie=$observation\">".$t."</a></td>";
			echo "<td align=\"right\"><a href=\"registre_remise_details.php?id_registre=$id_r\">".$total_c."</a></td>
			<td align=\"right\"><a href=\"registre_remise_details_e.php?id_registre=$id_r\">".$total_ef."</a></td>
			<td align=\"right\"><a href=\"registre_remise_details_e.php?id_registre=$id_r\">".$total_ef1."</a></td>
			<td><a href=\"registre_remise_details1.php?date_remise=$date_remise&id_registre=$id_r\">"."cheque"."</a></td>
			<td><a href=\"registre_remise_details1_e.php?date_remise=$date_remise&id_registre=$id_r\">"."Effet"."</a></td>
			";
			$ajout="ajout";echo "<td align=\"right\"><a href=\"registre_remise_globale.php?date_remise=$date_remise&id_registre=$id_r\">".$ajout."</a></td>";
 } 
 ?>

<tr><td></td><td></td>
<td><? 			echo "Sous-Total Effets :";?></td>
<td align="right"><? 			echo number_format($t_eff,2,',',' ');?></td>
<td align="right"><? 			echo number_format($t_eff1,2,',',' ');?></td><td></td><td></td>
<tr><td></td><td></td><td align="right">
<? 			echo number_format($t_cheque,2,',',' ');?></td>
<td align="center" colspan="2"><? 			echo number_format($t_eff1+$t_eff,2,',',' ');?></td><td></td><td></td>

</table>
</strong>
<p style="text-align:center">
<table class="table2">
<? echo "<td><a href=\"registre_remise.php?banque=$banque&date=$date&user_id=0\">"."Ajout Remise"."</a></td>";?>
<? echo "<td><a href=\"registres_remises_apercu.php?date=$date&user_id=0\">"."Apercu Remise"."</a></td>";?>
</table>

<? }?>
</body>

</html>