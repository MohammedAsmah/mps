<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$type="effets_oc";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$designation = $_REQUEST["designation"];$banque = $_REQUEST["banque"];
			$montant_echeance = $_REQUEST["montant_echeance"];$nbr_echeances = $_REQUEST["nbr_echeances"];
			$date_debut = dateFrToUs($_REQUEST["date_debut"]);
			$echeance = $_REQUEST["echeance"];
			
			list($annee1,$mois1,$jour1) = explode('-', $date_debut); 
			$debut = mktime(0,0,0,$mois1,$jour1,$annee1); 
			$duree=$nbr_echeances*$echeance*24*60*60;
			$fin=$debut+$duree;
			$date_fin=date("d/m/y",$fin);
			$nbr_annees=($nbr_echeances*$echeance)/12/30;$t=mktime(0,0,0,$mois1,$jour1,$annee1+$nbr_annees);$fin=date("d/m/y",$t-(31*24*60*60));
			$date_fin=dateFrToUs($fin);
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO credits_previsionnels ( designation, banque, date_obtention,montant_echeance,nbr_echeances,date_debut,date_fin,echeance,type )
				 VALUES ('$designation','$banque','$date_debut','$montant_echeance','$nbr_echeances','$date_debut','$date_fin','$echeance','$type')";
				db_query($database_name, $sql);$id_credit=mysql_insert_id();

				$sql  = "INSERT INTO echeancier_previsionnel ( id_credit, designation,montant_echeance, date_echeance,type,banque )
				 VALUES ('$id_credit','$designation','$montant_echeance','$date_debut','$type','$banque')";
				db_query($database_name, $sql);

				for ($i=1;$i<$nbr_echeances;$i++){
				$mois1=$mois1+($echeance/30);if ($mois1>=13){$mois1=$mois1-12;$annee1=$annee1+1;}
				$t1=mktime(0,0,0,$mois1,$jour1,$annee1);$fin_f=date("d/m/y",$t1);
				$date_echeance=dateFrToUs($fin_f);
				$sql  = "INSERT INTO echeancier_previsionnel ( id_credit,designation, montant_echeance, date_echeance,type,banque )
				 VALUES ('$id_credit','$designation','$montant_echeance','$date_echeance','$type','$banque')";
				db_query($database_name, $sql);
				}
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			
			/*if ($_REQUEST["date_debut"]=="0000-00-00") {*/
			
			$sql = "UPDATE credits_previsionnels SET designation = '$designation',banque = '$banque',date_obtention = '$date_debut',montant = '$montant',montant_echeance = '$montant_echeance',nbr_echeances = '$nbr_echeances' , date_debut = '$date_debut',date_fin = '$date_fin',echeance = '$echeance' WHERE id = '$user_id'";
			db_query($database_name, $sql);

			$sql = "DELETE FROM echeancier_previsionnel WHERE id_credit = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);$id_credit=$_REQUEST["user_id"];

				$sql  = "INSERT INTO echeancier_previsionnel ( id_credit, designation,montant_echeance, date_echeance,type,banque )
				 VALUES ('$id_credit','$designation','$montant_echeance','$date_debut','$type','$banque')";
				db_query($database_name, $sql);

				for ($i=1;$i<$nbr_echeances;$i++){
				$mois1=$mois1+($echeance/30);if ($mois1>=13){$mois1=$mois1-12;$annee1=$annee1+1;}
				$t1=mktime(0,0,0,$mois1,$jour1,$annee1);$fin_f=date("d/m/y",$t1);
				$date_fin_f=dateFrToUs($fin_f);
				$sql  = "INSERT INTO echeancier_previsionnel ( id_credit, designation,montant_echeance, date_echeance,type,banque )
				 VALUES ('$id_credit','$designation','$montant_echeance','$date_fin_f','$type','$banque')";
				db_query($database_name, $sql);
				}

			/*}
			else
			{*/
			
			/*$sql = "DELETE FROM echeancier_previsionnel WHERE id_credit = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);$id_credit=$_REQUEST["user_id"];
			$sql = "DELETE FROM credits_previsionnels WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);$id_credit=$_REQUEST["user_id"];

				$sql  = "INSERT INTO echeances_credits ( id_credit, designation,montant_echeance, date_echeance,type,banque )
				 VALUES ('$id_credit','$designation','$montant_echeance','$date_debut','$type','$banque')";
				db_query($database_name, $sql);
				*/
			/*}*/
			
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM credits_previsionnels WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
						$sql = "DELETE FROM echeancier_previsionnel WHERE id_credit = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);$id_credit=$_REQUEST["user_id"];

			break;


		} //switch
	} //if
	
	$sql  = "SELECT * ";
	$sql .= "FROM credits_previsionnels where type='$type' ORDER BY date_debut;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php  ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "echeancier_previsionnel.php?user_id=" + user_id; }
	function EditUser1(user_id) { document.location = "echeancier_credit.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php  ?></span>

<table class="table2">

<tr>
	<th><?php echo "Designation";?></th>
	<th><?php echo "Montant";?></th>
	<th><?php echo "Banque";?></th>
	<th><?php echo "Echeance";?></th>
	<th><?php echo "Details";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><a href="JavaScript:EditUser(<?php echo $users_["id"]; ?>)"><?php echo $users_["designation"];?></A></td>
<td><?php echo $users_["montant_echeance"]; ?></td>
<td><?php echo $users_["banque"]; ?></td>
<td><?php echo dateUsToFr($users_["date_debut"]); ?></td>
<td><a href="JavaScript:EditUser1(<?php echo $users_["id"]; ?>)"><?php echo "Details";?></A></td>
<?php } ?>

</table>

<p style="text-align:center">

<button onClick="EditUser(0)"><?php echo Translate("Add"); ?></button>
<tr>
</tr>

</body>

</html>