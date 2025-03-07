<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";$action="Recherche";$date="";$date1="";$du="";$au="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	/*if(isset($_REQUEST["action"])){}else{

	$sql  = "SELECT * ";
	$sql .= "FROM factures ORDER BY id;";
	$users = db_query($database_name, $sql);
	while($users_ = fetch_array($users)) { 
	$client=$users_["client"];$id=$users_["id"];$f=$users_["numero"];$d=$users_["date_f"];$client_se=Trim($client);
	$sql1  = "SELECT * ";$f1=$users_["id"]+9040;
	$sql1 .= "FROM detail_factures where facture='$f' ORDER BY produit;";
	$users1 = db_query($database_name, $sql1);$non_favoris=0;
	while($users1_ = fetch_array($users1)) { $id1=$users1_["id"];
			$sql = "UPDATE detail_factures SET ";
			$sql .= "date_f = '" . $d . "' ";
			$sql .= "WHERE id = " . $id1 . ";";
			db_query($database_name, $sql);}
	}		
	}*/


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "Traitement encours merci patientez" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">


</head>

<body style="background:#dfe8ff">
		<? require "body_cal.php";?>

	<?
	
			if(isset($_REQUEST["action"])){}else{
	$profiles_list_famille = "";$famille="";
	$sql1 = "SELECT * FROM familles_articles ORDER BY profile_name;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($famille == $temp_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_famille .= "<OPTION VALUE=\"" . $temp_["profile_name"] . "\"" . $selected . ">";
		$profiles_list_famille .= $temp_["profile_name"];
		$profiles_list_famille .= "</OPTION>";
	}
	

	?>
	<form id="form" name="form" method="post" action="despatching_articles_factures.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" />
	<td><?php echo "Famille : "; ?><select id="famille" name="famille"><?php echo $profiles_list_famille; ?></select></td>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{
	
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];
	$du=$_POST['date'];$au=$_POST['date1'];$famille=$_POST['famille'];

	$sql  = "SELECT produit,quantite,condit,date_f,sum(quantite*condit) As total_quantite ,sum(quantite) As t_quantite ";
	$sql .= "FROM detail_factures where date_f between '$date' and '$date1' GROUP BY produit order by t_quantite;";
	$users = db_query($database_name, $sql);
	
	
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Despatching Articles sur factures $du au $au"; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Article";?></th>
	<th><?php echo "Paquets";?></th>
	<th><?php echo "Quantite FACTURE";?></th>
	
</tr>

<?php $debit=0;$credit=0;$t=0;$s=0;$t_poids2=0;$t_poids1=0;
while($users_ = fetch_array($users)) { ?>
<?php $p=$users_["produit"];$q=$users_["total_quantite"];		
		$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$p' ";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);$poids=$user_["poids"];$famille_p=$user_["type"];
		$poids1 = $user_["poids"]*$q;$id=$user_["id"];
		if ($famille_p==$famille and $famille<>""){?><tr><td><? 
				echo $users_["produit"];?></td><? $date_f=$users_["date_f"];
				list($annee1,$mois1,$jour1) = explode('-', $date_f); 
				$pdu = mktime(0,0,0,$mois1,$jour1,$annee1);$mois=date("M",$pdu); 
				?>
<td align="right"><?php echo $users_["t_quantite"];?></td>
<td align="right"><?php echo $users_["total_quantite"];?></td>

<?php } ?>
<?php } ?>
<tr>


</tr>
</table>

<?php } ?>

<p style="text-align:center">

</body>

</html>