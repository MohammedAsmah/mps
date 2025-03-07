<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$caisse="";$action="Recherche";$date="";$date1="";$du="";$au="";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$profiles_list_vendeur="";
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
	<form id="form" name="form" method="post" action="palmares_clients_com1.php">
	<td><?php echo "Du : "; ?><input onclick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><?php echo "Au : "; ?><input onclick="ds_sh(this);" name="date1" readonly="readonly" style="cursor: text" />
	<td><?php echo "Vendeur: "; ?></td><td><select id="vendeur" name="vendeur"><?php echo $profiles_list_vendeur; ?></select></td>
	
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{
	
	$date=dateFrToUs($_POST['date']);$du=$_POST['date'];$date1=dateFrToUs($_POST['date1']);$au=$_POST['date1'];$vendeur=$_POST['vendeur'];
		
	
	$du=$_POST['date'];$au=$_POST['date1'];$encours="encours";$vide="";

	if ($vendeur==""){
	$sql  = "SELECT commande,client,secteur,vendeur,date,escompte,sum(net) As total ";
	$sql .= "FROM commandes where date_e between '$date' and '$date1' and evaluation<>'$vide' and evaluation<>'$encours' and escompte<>0 GROUP BY client order by total DESC;";
	}else
	{
	$sql  = "SELECT commande,client,secteur,vendeur,date,escompte,sum(net) As total ";
	$sql .= "FROM commandes where date_e between '$date' and '$date1' and evaluation<>'$vide' and evaluation<>'$encours' and escompte<>0 and vendeur='$vendeur' GROUP BY client order by total DESC;";
	}
	$users = db_query($database_name, $sql);
	
	
	?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Palmares Clients $du au $au $vendeur"; ?></span>

<p style="text-align:center">


<table class="table2">

<tr>
	<th><?php echo "Client";?></th>
	<th><?php echo "Vendeur";?></th>
	<th><?php echo "Destination";?></th>
	<th><?php echo "C.A ";?></th>
	<th><?php echo "Mt Escompte";?></th>
	
</tr>

<?php $debit=0;$credit=0;$t=0;$s=0;$t=0;$net_avoir=0;
while($users_ = fetch_array($users)) { $client=$users_["client"];$total=$users_["total"];$clt= "<a href=\"palmares_clients_com1_detail.php?vendeur=$vendeur&client=$client&du=$date&au=$date1\">$client</a>";?><tr><td>
<? print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$clt </font>");?></td>
<td align="left"><?php echo $users_["vendeur"];?></td>
<td align="left"><?php echo $users_["secteur"];?></td>
<td align="right"><?php $t=$t+$users_["total"];echo number_format($users_["total"],2,',',' ');$brut=$users_["total"]/((100-$users_["escompte"])/100);?></td>
<td align="right"><? $c=$c+($brut*$users_["escompte"]/100);echo number_format(($brut*$users_["escompte"]/100),2,',',' ');?></td>
<?php } ?>
<tr>
<td></td><td></td><td></td>
<td align="right"><?php echo number_format($t,2,',',' ');?></td>
<td align="right"><?php echo number_format($c,2,',',' ');?></td>
</tr>
</table>

<?php } ?>

<p style="text-align:center">

</body>

</html>