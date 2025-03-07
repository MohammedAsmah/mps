<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$employe = $_REQUEST["employe"];$ref = $_REQUEST["ref"];$service = $_REQUEST["service"];$poste = $_REQUEST["poste"];
			$poste = $_REQUEST["poste"];if(isset($_REQUEST["statut"])) { $statut = 1; } else { $statut = 0; }
			$t_h_normales = $_REQUEST["t_h_normales"];$t_h_25 = $_REQUEST["t_h_25"];$t_h_50 = $_REQUEST["t_h_50"];
			if(isset($_REQUEST["manual"])) { $manual = 1; } else { $manual = 0; }
				$sam_m = $_REQUEST["sam_m"];$dim_m = $_REQUEST["dim_m"];$lun_m = $_REQUEST["lun_m"];$mar_m = $_REQUEST["mar_m"];
			$mer_m = $_REQUEST["mer_m"];$jeu_m = $_REQUEST["jeu_m"];$ven_m = $_REQUEST["ven_m"];
			$sam_s = $_REQUEST["sam_s"];$dim_s = $_REQUEST["dim_s"];$lun_s = $_REQUEST["lun_s"];$mar_s = $_REQUEST["mar_s"];
			$mer_s = $_REQUEST["mer_s"];$jeu_s = $_REQUEST["jeu_s"];$ven_s = $_REQUEST["ven_s"];
			$sam_sup = $_REQUEST["sam_sup"];$dim_sup = $_REQUEST["dim_sup"];$lun_sup = $_REQUEST["lun_sup"];$mar_sup = $_REQUEST["mar_sup"];
			$mer_sup = $_REQUEST["mer_sup"];$jeu_sup = $_REQUEST["jeu_sup"];$ven_sup = $_REQUEST["ven_sup"];
			if(isset($_REQUEST["valide"])) { $valide = 1; } else { $valide = 0; }
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO employes ( code, employe,service,statut,poste )
				 VALUES ('$ref','$employe','$service','$statut','$poste')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE employes SET ref = '$ref',employe = '$employe',t_h_normales='$t_h_normales',
				t_h_25='$t_h_25',t_h_50='$t_h_50',valide='$valide',poste='$poste',manual='$manual',statut='$statut', 
				sam_m='$sam_m',dim_m='$dim_m',lun_m='$lun_m',mar_m='$mar_m',mer_m='$mer_m',jeu_m='$jeu_m',ven_m='$ven_m',
			sam_s='$sam_s',dim_s='$dim_s',lun_s='$lun_s',mar_s='$mar_s',mer_s='$mer_s',jeu_s='$jeu_s',ven_s='$ven_s',
			sam_sup='$sam_sup',dim_sup='$dim_sup',lun_sup='$lun_sup',mar_sup='$mar_sup',mer_sup='$mer_sup',jeu_sup='$jeu_sup',ven_sup='$ven_sup'
			
				WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM employes WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";$occ="occasionnelles";$per="permanents";$vide="";
	$sql .= "FROM employes where employe<>'$vide' and statut=0 and (service='$occ' or service='$per') ORDER BY service,date_entree;";
	$users = db_query($database_name, $sql);$erreur=0;$compteur=0;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "employe22.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "CARTE DE POINTAGE "; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Nom et Prenom ";?></th>
	<th><?php echo "H.N";?></th>
	<th><?php echo "H.25%";?></th>
	<th><?php echo "H.50%";?></th>
	<th><?php echo "H.100%";?></th>
	<th><?php echo "Total H.";?></th>	
	<th><?php echo "Controle";?></th>		
</tr>

<?php while($user_ = fetch_array($users)) { ?><tr>
<? $compteur=$compteur+1;$date_entree=dateUsToFr($user_["date_entree"]);if ($user_["controle"]==0){?>
<td><a href="JavaScript:EditUser(<?php echo $user_["id"]; ?>)"><?php echo $user_["employe"]." - ".$date_entree;?></A></td>
<? } else {$erreur=$erreur+1;?>
<td bgcolor="#FF3333"><a href="JavaScript:EditUser(<?php echo $user_["id"]; ?>)"><?php echo $user_["employe"]." - ".$date_entree;?></A></td>
<? }

		$ref = $user_["ref"];$service = $user_["service"];
		$employe = $user_["employe"];$statut=$user_["statut"];$poste=$user_["poste"];
		$t_h_normales=$user_["t_h_normales"];$t_h_25=$user_["t_h_25"];$t_h_50=$user_["t_h_50"];
		$t_h_100=$user_["t_h_100"];$manual=$user_["manual"];$valide=$user_["valide"];
		$sam_s=$user_["sam_s"];$dim_s=$user_["dim_s"];$lun_s=$user_["lun_s"];$mar_s=$user_["mar_s"];
		$mer_s=$user_["mer_s"];$jeu_s=$user_["jeu_s"];$ven_s=$user_["ven_s"];
		$sam_m=$user_["sam_m"];$dim_m=$user_["dim_m"];$lun_m=$user_["lun_m"];$mar_m=$user_["mar_m"];
		$mer_m=$user_["mer_m"];$jeu_m=$user_["jeu_m"];$ven_m=$user_["ven_m"];
		$sam_sup=$user_["sam_sup"];$dim_sup=$user_["dim_sup"];$lun_sup=$user_["lun_sup"];$mar_sup=$user_["mar_sup"];
		$mer_sup=$user_["mer_sup"];$jeu_sup=$user_["jeu_sup"];$ven_sup=$user_["ven_sup"];$heures=$user_["heures"];
		if ($sam_m==0){$sam_m="";}if ($dim_m==0){$dim_m="";}if ($lun_m==0){$lun_m="";}
		if ($mar_m==0){$mar_m="";}if ($mer_m==0){$mer_m="";}if ($jeu_m==0){$jeu_m="";}if ($ven_m==0){$ven_m="";}
		if ($sam_s==0){$sam_s="";}if ($dim_s==0){$dim_s="";}if ($lun_s==0){$lun_s="";}
		if ($mar_s==0){$mar_s="";}if ($mer_s==0){$mer_s="";}if ($jeu_s==0){$jeu_s="";}if ($ven_s==0){$ven_s="";}
		if ($sam_sup==0){$sam_sup="";}if ($dim_sup==0){$dim_sup="";}if ($lun_sup==0){$lun_sup="";}
		if ($mar_sup==0){$mar_sup="";}if ($mer_sup==0){$mer_sup="";}if ($jeu_sup==0){$jeu_sup="";}if ($ven_sup==0){$ven_sup="";}
		

?>
<table class="table2">
		<tr><td></td><td align "center"><? echo " Sam "?></td>
		<td align "center"><? echo " Dim "?></td>
		<td align "center"><? echo " Lun "?></td>
		<td align "center"><? echo " Mar "?></td>
		<td align "center"><? echo " Mer "?></td>
		<td align "center"><? echo " Jeu "?></td>
		<td align "center"><? echo " Ven "?></td></tr>
		
		<tr><td><? echo "Heures Normales Matin : "?></td>
		<td><?php echo $sam_m; ?></td>
		<td><?php echo $dim_m; ?></td>
		<td><?php echo $lun_m; ?></td>
		<td><?php echo $mar_m; ?></td>
		<td><?php echo $mer_m; ?></td>
		<td><?php echo $jeu_m; ?></td>
		<td><?php echo $ven_m; ?></td></tr>
	<tr><td><? echo "Heures Normales Soir : "?></td>
		<td><?php echo $sam_s; ?></td>
		<td><?php echo $dim_s; ?></td>
		<td><?php echo $lun_s; ?></td>
		<td><?php echo $mar_s; ?></td>
		<td><?php echo $mer_s; ?></td>
		<td><?php echo $jeu_s; ?></td>
		<td><?php echo $ven_s; ?></td></tr>
	<tr><td><? echo "Heures Supplementaires : "?></td>
		<td><?php echo $sam_sup; ?></td>
		<td><?php echo $dim_sup; ?></td>
		<td><?php echo $lun_sup; ?></td>
		<td><?php echo $mar_sup; ?></td>
		<td><?php echo $mer_sup; ?></td>
		<td><?php echo $jeu_sup; ?></td>
		<td><?php echo $ven_sup; ?></td></tr>		
		</table>
		<tr><td></td></tr>
<?php } ?>
<tr><td><? echo "Erreur pointage : $erreur / $compteur";?></td></tr>
</table>

<p style="text-align:center">


</body>

</html>