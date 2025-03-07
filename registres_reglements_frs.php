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
			$date_valeur="";
			$reference="";
			$vendeur=$_REQUEST["vendeur"];
			$date_open=$_REQUEST["date_open"];
			$user_open=$user_name;
			$observation=$_REQUEST["observation"];
			$mode=$_REQUEST["mode"];
			$montant_total=$_REQUEST["montant_total"];
			$date_valeur=dateFrToUs($_REQUEST["date_valeur"]);$date_v=$_REQUEST["date_valeur"];
			$reference=$_REQUEST["reference"];
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
		

				$sql  = "INSERT INTO registre_reglements_frs (date,vendeur,date_open,user_open,observation,mode,montant_total,date_valeur,reference)
				 VALUES ('$date','$vendeur','$date_open','$user_open','$observation','$mode','$montant_total','$date_valeur','$reference')";

				db_query($database_name, $sql);$id_registre=mysql_insert_id();$impaye="impaye";$impaye1=1;$e_e=1;
				
			break;

			case "update_user":
				$date = dateFrToUs($_REQUEST["date"]);
				$id_registre=$_REQUEST["user_id"];
				
			$sql = "UPDATE registre_reglements_frs SET ";
			
			$sql .= "date = '" . $date . "', ";
			$sql .= "vendeur = '" . $vendeur . "', ";
			$sql .= "mode = '" . $mode . "', ";
			$sql .= "montant_total = '" . $montant_total . "', ";
			$sql .= "date_valeur = '" . $date_valeur . "', ";
			$sql .= "reference = '" . $reference . "', ";
			$sql .= "observation = '" . $observation . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			if ($reference<>""){$ref_reg=$mode." ".$reference." ".$date_v;
			$sql = "UPDATE achats_mat SET ";$p=0;$v=1;
			$sql .= "validation = " . $v . ", ";
			$sql .= "preparation = " . $p . ", ";
			$sql .= "reference = '" . $ref_reg . "' ";
			$sql .= "WHERE id_registre_regl = '" . $id_registre . "';";
			db_query($database_name, $sql);
			$sql = "UPDATE porte_feuilles_frs SET ";$p=0;$v=1;
			$sql .= "mode_reg = '" . $ref_reg . "', ";
			$sql .= "paye_le = '" . $date . "', ";
			$sql .= "mode = '" . $mode . "' ";
			$sql .= "WHERE id_registre_regl = '" . $id_registre . "';";
			db_query($database_name, $sql);
			}
			
			
						
			break;
			
			case "delete_user":
			
			
			// delete user's profile
			$sql = "DELETE FROM registre_reglements_frs WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			$sql = "DELETE FROM porte_feuilles_frs WHERE id_registre_regl = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			$sql = "UPDATE achats_mat SET ";$p=0;$v="";
			$sql .= "validation = " . $p . ", ";
			$sql .= "preparation = " . $p . ", ";
			$sql .= "id_registre_regl = " . $p . ", ";
			$sql .= "reference = '" . $v . "' ";
			$sql .= "WHERE id_registre_regl = '" . $_REQUEST["user_id"] . "';";
			db_query($database_name, $sql);
			
			$profile_id = GetUserProfile();	$user_name=GetUserName();$date_time=date("y-m-d h:m:s");
			$table_name="registre_reglements";$record=$_REQUEST["user_id"];
				$sql  = "INSERT INTO deleted_files ( user,date_time,table_name,record ) VALUES ( ";
				$sql .= "'" . $user_name . "', ";
				$sql .= "'" . $date_time . "', ";
				$sql .= "'" . $table_name . "', ";
				$sql .= "'" . $record . "');";

				db_query($database_name, $sql);
			
			
			break;


		} //switch
	} //if
	
	else {$vendeur="";$date1="";$date2="";}
	if(isset($_REQUEST["action_"]) and $_REQUEST["action_"] != "delete_user") { $date1 = $_REQUEST["date"];}
	else {$vendeur="";$date1="";}
	$action="recherche";
	$vendeur_list = "";
	$sql = "SELECT * FROM  rs_data_fournisseurs ORDER BY last_name;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["last_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$vendeur_list .= "<OPTION VALUE=\"" . $temp_["last_name"] . "\"" . $selected . ">";
		$vendeur_list .= $temp_["last_name"];
		$vendeur_list .= "</OPTION>";
	}

	
	?>
	<? if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="registres_reglements_frs.php">
	<td><?php echo "Du : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au : "; ?><input onClick="ds_sh(this);" name="date2" value="<?php echo $date2; ?>" readonly="readonly" style="cursor: text" /></td>
	<TR><td><?php echo "Fournisseur		:"; ?></td><td><select id="vendeur" name="vendeur"><?php echo $vendeur_list; ?></select></td></TR>
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
	function EditUser(user_id) { document.location = "registre_reglement_frs.php?user_id=" + user_id; }
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
	$sql .= "FROM registre_reglements_frs where (date between '$date' and '$date2') and vendeur='$vendeur' ORDER BY id;";
	$users11 = db_query($database_name, $sql);



?>


<span style="font-size:24px"><?php $vendeur; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Date";?></th>
	<th><?php echo "Reglements";?></th>
	<th><?php echo "Observations";?></th>
	
</tr>

<?php $compteur1=0;$total_g=0;
while($users_1 = fetch_array($users11)) { $id_r=$users_1["id"];$date_enc=$users_1["date"];$frs=$users_1["vendeur"];$date_valeur=$users_1["date_valeur"];
			$statut=$users_1["statut"];$observation=$users_1["observation"];$dest=$users_1["service"];$valider_caisse=$users_1["valider_caisse"];
			$service=$users_1["service"];$code=$users_1["code_produit"];$id_tableau=$users_1["id"]."/2008";$bon=$users_1["statut"];
			
			
			/*$sql = "UPDATE porte_feuilles_frs SET ";
			
			$sql .= "paye_le = '" . $date_enc . "' ";
			
			$sql .= "WHERE id_registre_regl = '" . $id_r . "';";
			db_query($database_name, $sql);*/
			
			
			
			//reports
	 $ev="";$fa="";$reference=$users_1["reference"];$total_e=0;
 	$sql12  = "SELECT numero_cheque,client,sum(montant_e) as total_e,sum(m_cheque) as total_cheque,sum(m_espece) as total_espece, sum(m_effet) as total_effet
	,sum(m_avoir) as total_avoir,sum(m_diff_prix) as total_diff_prix,sum(m_virement) as total_virement ";
	$sql12 .= "FROM porte_feuilles_frs where id_registre_regl='$id_r' Group BY id_registre_regl;";
	$users1111 = db_query($database_name, $sql12);
	$users_111 = fetch_array($users1111);
	$client=$users_111["client"];$total_e=$users_111["total_e"];$total_avoir=$users_111["total_avoir"];
	$total_cheque=$users_111["total_cheque"];$total_espece=$users_111["total_espece"];$total_effet=$users_111["total_effet"];
	$total_diff_prix=$users_111["total_diff_prix"];$total_virement=$users_111["total_virement"];
	$total_eval=$total_espece+$total_cheque+$total_effet+$total_virement-($total_avoir+$total_diff_prix);
	$total_eval=number_format($total_eval,2,',',' ');?>
	<tr><td>
			<? $d=dateUsToFr($users_1["date"]);
			
			
			echo "<a href=\"registre_reglement_frs.php?user_id=$id_r&net=$total_e\">$d</a></td>";?>

			<?php $observation=$users_1["observation"]; ?>
			<? 
	
				if ($reference==0 or $reference==""){
			 
			?><td align="right">
			<? echo "<a href=\"reglements_frs.php?bon_sortie=$observation&id_registre=$id_r&date_enc=$date_enc&vendeur=$vendeur&date1=$de1&date2=$de2\">Total : $total_e</a></td>";
			} else
			{ ?><td align="right"><? echo "Total : ".$total_e."</td>";}
			 ?><td align="right"><? echo "<a href=\"reglements_frs.php?bon_sortie=$observation&id_registre=$id_r&date_enc=$date_enc&vendeur=$vendeur&date1=$de1&date2=$de2\">Total : $total_e</a></td>";
			
 } ?>

</table>
</strong>
<p style="text-align:center">
<table class="table2">
<? echo "<td><a href=\"registre_reglement_frs.php?vendeur=$vendeur&date=$date&user_id=0\">"."Ajout Reglement frs"."</a></td>";?>
</table>
<? }?>
</body>

</html>