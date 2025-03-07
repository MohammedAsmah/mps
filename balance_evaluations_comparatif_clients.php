<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
$valeur=3600;
set_time_limit($valeur);
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";$action="Recherche";$date="";$date1="";$du="";$au="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$vendeur="";$profiles_list_vendeur="";
	$sql1 = "SELECT * FROM vendeurs ORDER BY vendeur;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($vendeur == $temp_["vendeur"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_vendeur .= "<OPTION VALUE=\"" . $temp_["vendeur"] . "\"" . $selected . ">";
		$profiles_list_vendeur .= $temp_["vendeur"];
		$profiles_list_vendeur .= "</OPTION>";
	}

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

	<?
	
			if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="balance_evaluations_comparatif_clients.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" />
		<td><?php echo "Vendeur: "; ?></td><td><select id="vendeur" name="vendeur"><?php echo $profiles_list_vendeur; ?></select></td>

	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{
	
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];
	$du=$_POST['date'];$au=$_POST['date1'];$encours="encours";$t1=0;$t2=0;$t3=0;
	list($annee1,$mois1,$jour1) = explode('-', $date); $vendeur=$_POST['vendeur'];
	$pdu = mktime(0,0,0,$mois1,$jour1,$annee1); 
	list($annee11,$mois11,$jour11) = explode('-', $date1); 
	$pau = mktime(0,0,0,$mois11,$jour11,$annee11); 
	$jour=date("d",$pdu);$mois=date("m",$pdu);$annee=date("Y",$pdu);
	$jour1=date("d",$pau);$mois1=date("m",$pau);$annee1=date("Y",$pau);
	$d1=$jour."/".$mois."/".$annee1;$d2=$jour1."/".$mois1."/".$annee1;
	$annee_1=$annee-1;$annee_2=$annee-2;$annee_3=$annee-3;$annee_0=$annee-0;
	$d1_exe_1=$annee_1."-".$mois."-".$jour;$d2_exe_1=$annee_1."-".$mois1."-".$jour1;
	$d1_exe_2=$annee_2."-".$mois."-".$jour;$d2_exe_2=$annee_2."-".$mois1."-".$jour1;?>
	
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Comparatif Clients  $jour/$mois  au  $jour1/$mois1 "; ?></span>

<p style="text-align:center">
	<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo $annee_0;?></th>
	<th><?php echo $annee_1;?></th>
	<th><?php echo $annee_2;?></th>
	<th><?php echo $annee_3;?></th>
</tr>

	
	<?
	$sql  = "SELECT * ";
	$sql .= "FROM clients where vendeur_nom='$vendeur' order BY client;";
	$users_v = db_query($database_name, $sql);
while($users_v1 = fetch_array($users_v)) { ?><tr>
	
	<? $client=$users_v1["client"];?>

	<? 
	$sql  = "SELECT produit,client,date,sum(valeur) As total_net ";
	$sql .= "FROM detail_commandes where date between '$date' and '$date1' and client='$client' and escompte_exercice=0 GROUP BY client;";
	$users = db_query($database_name, $sql);
	
	$sql  = "SELECT produit,client,date,sum(valeur) As total_net ";
	$sql .= "FROM detail_commandes where date between '$d1_exe_1' and '$d2_exe_1'and client='$client' and escompte_exercice=0 GROUP BY client;";
	$users1 = db_query($database_name, $sql);
	
	$sql  = "SELECT produit,client,date,sum(valeur) As total_net ";
	$sql .= "FROM detail_commandes where date between '$d1_exe_2' and '$d2_exe_2' and client='$client' and escompte_exercice=0 GROUP BY client;";
	$users2 = db_query($database_name, $sql);
	?>




<?php 
$users_ = fetch_array($users); $users_1 = fetch_array($users1);$users_2 = fetch_array($users2);
echo "<td>$client</td>";
?>
<td align="right"><?php echo number_format($users_["total_net"],2,',',' ');$t1=$t1+$users_["total_net"];?></td>
<td align="right"><?php echo number_format($users_1["total_net"],2,',',' ');$t2=$t2+$users_1["total_net"];?></td>
<td align="right"><?php echo number_format($users_2["total_net"],2,',',' ');$t3=$t3+$users_2["total_net"];?></td>

<?php } ?>
<tr><td align="right"><?php echo "Totaux : ";?></td>
<td align="right"><?php echo number_format($t1,2,',',' ');?></td>
<td align="right"><?php echo number_format($t2,2,',',' ');?></td>
<td align="right"><?php echo number_format($t3,2,',',' ');?></td>

</table>
<?php } ?>

<p style="text-align:center">

</body>

</html>