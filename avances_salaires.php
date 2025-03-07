<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) ) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$employe = $_REQUEST["employe"];$montant = $_REQUEST["montant"];$echeance = $_REQUEST["echeance"];
			$date = dateFrToUs($_REQUEST["date"]);$motif = $_REQUEST["motif"];$debut = dateFrToUs($_REQUEST["debut"]);
			$mode = $_REQUEST["mode"];$montant_echeance = $_REQUEST["montant_echeance"];
			$nombre_echeances = $_REQUEST["nombre_echeances"];$solde = $_REQUEST["montant"];
		
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO avances_salaires ( employe,motif,montant,solde,echeance,date,debut,mode,nombre_echeances,montant_echeance )
				 VALUES ('$employe','$motif','$montant','$solde','$echeance','$date','$debut','$mode','$nombre_echeances','$montant_echeance')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			/*$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE avances_salaires SET montant = '$montant',employe = '$employe',echeance = '$echeance'
			,date = '$date',motif = '$motif',debut = '$debut'
			,nombre_echeances = '$nombre_echeances',mode = '$mode',montant_echeances = '$montant_echeances'  
			 
			WHERE id = '$user_id'";
			db_query($database_name, $sql);*/
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			/*$sql = "DELETE FROM avances_salaires WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);*/
			break;


		} //switch
	} //if
	
	/*$sql  = "SELECT * ";$occ="occasionnelles";$per="permanents";$vide="";
	$sql .= "FROM avances_salaires where montant>0 ORDER BY employe;";
	$users = db_query($database_name, $sql);*/
	
	$sql  = "SELECT * ";$occ="Occasionnelles";$per="permanents";$vide="";
	$sql .= "FROM employes where statut=0 and (service='$occ' or service='$per') ORDER BY service ,date_entree;";
	$users = db_query($database_name, $sql);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "avance_salaire.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Avances / Salaires "; ?></span>

<table class="table2">

<tr>
	
	<th><?php echo "Nom";?></th>
	<th><?php echo "Report";?></th>
	<th><?php echo "Avances";?></th>
	<th><?php echo "Retraits";?></th>
	<th><?php echo "Soldes";?></th>
	<th><?php echo "Retraits";?></th>
	<th><?php echo "Avances";?></th>
</tr>

<?php $m=0;$r=0;while($users_ = fetch_array($users)) { ?>

<? $employe=$users_["employe"];$id=$users_["id"];
$type="avance";

////////////////
				
				
				
				// delete user's profile
				/*$d="2011-07-22";
			$sql = "DELETE FROM avances_employes WHERE date_avance='$d' and employe = '" . $employe . "';";
			db_query($database_name, $sql);*/
//////////////////
	
	$sql  = "SELECT * ";
	$sql .= "FROM avances_salaires where employe='$employe' ORDER BY employe;";
	$users2 = db_query($database_name, $sql);$ssa=0;
	while($users_2 = fetch_array($users2)) {
	$ssa=$ssa+$users_2["montant"];}
	

	$sql  = "SELECT * ";
	$sql .= "FROM avances_employes where employe='$employe' and type='$type' ORDER BY id;";
	$users22 = db_query($database_name, $sql);$ss=0;
	while($users_22 = fetch_array($users22)) {
	$ss=$ss+$users_22["montant"];}
	
	$sql  = "SELECT * ";$type="retrait";
	$sql .= "FROM avances_employes where employe='$employe' and type='$type' ORDER BY id;";
	$users222 = db_query($database_name, $sql);$sss=0;
	while($users_222 = fetch_array($users222)) {
	$sss=$sss+$users_222["montant"];}
	
	
	
	/*$type="avance";$date_av="2024-06-14";$prelevement=1500;
				$sql  = "INSERT INTO avances_employes ( employe,date_avance,montant,type )
				 VALUES ('$employe','$date_av','$prelevement','$type')";
				db_query($database_name, $sql);*/
	
	
	
	/*$solde=$users_["montant"]+$ss-$sss;*/
	$solde=$ssa+$ss-$sss;
//if ($solde<>0){

				/*$type="retrait";$date_av="2013-05-03";if ($employe=="SAFIHI LAHCEN"){$prelevement=150;}else{$prelevement=100;}
				$sql  = "INSERT INTO avances_employes ( employe,date_avance,montant,type )
				 VALUES ('$employe','$date_av','$prelevement','$type')";
				db_query($database_name, $sql);

               /* $type="retrait";$date_av="2012-12-07";if ($employe=="SAFIHI LAHCEN"){$prelevement=150;}else{$prelevement=100;}
				$sql  = "INSERT INTO avances_employes ( employe,date_avance,montant,type )
				 VALUES ('$employe','$date_av','$prelevement','$type')";
				db_query($database_name, $sql);*/
				
				
	
echo "<tr><td><a href=\"avance_salaire.php?employe=$employe&solde=$solde\">$employe</a></td>";?>


<td align="right"><?php $r=$r+$ssa;echo number_format($ssa,2,',',' '); ?></td>
<? $employe=$users_["employe"];
	
?>
<td align="right"><?php $tss=$tss+$ss;echo number_format($ss,2,',',' '); ?></td>
<td align="right"><?php $tsss=$tsss+$sss;echo number_format($sss,2,',',' '); ?></td>
<td align="right"><?php $m=$m+($ssa+$ss-$sss);echo number_format($ssa+$ss-$sss,2,',',' '); ?></td>
<td bgcolor="#66CCCC"><? echo "<a href=\"retraits_employes.php?employe=$employe\">Màj</a></td>";?>
<td bgcolor="#66CCCC"><? echo "<a href=\"avances_employes.php?employe=$employe\">Màj</a></td>";?>


<?php //} ?>


<?php } ?>
<tr><td></td>
<td align="right"><?php echo number_format($r,2,',',' '); ?></td>
<td align="right"><?php echo number_format($tss,2,',',' '); ?></td>
<td align="right"><?php echo number_format($tsss,2,',',' '); ?></td>
<td align="right"><?php echo number_format($m,2,',',' '); ?></td>
<td></td><td></td><td></td></tr>
</table>

<p style="text-align:center">


</body>

</html>