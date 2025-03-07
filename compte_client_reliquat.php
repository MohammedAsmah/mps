<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$client = $_GET["client"];$user_id = $_GET["user_id"];$id = $_GET["id"];
	
	
	
	// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM vendeurs WHERE id = " . $_GET["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		
		$vendeur = $user_["vendeur"];

	if($id == "0") {

		
		
	} else {

		if ($_REQUEST["action_"] == "update")
		{
			$user_id = $_POST["user_id"];
			$sql  = "SELECT * ";
		$sql .= "FROM vendeurs WHERE id = " . $_POST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);$vendeur = $user_["vendeur"];

		
		
			$client = $_POST["client"];$id = $_POST["id"];if (isset($_POST["reliquat"])){$encaiss=1;}else{$encaiss=0;}
			$reliquat = $_POST["reliquat"];
			$obs_reliquat = $_POST["obs_reliquat"];
			$sql = "UPDATE commandes SET ";
			$sql .= "obs_reliquat = '" . $obs_reliquat . "', ";
			$sql .= "encaiss = '" . $encaiss . "', ";
			$sql .= "reliquat = '" . $reliquat . "' ";
			
			$sql .= "WHERE id = " . $id . ";";
			db_query($database_name, $sql);
			
		}
	
		
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM clients WHERE client = " . '$client' . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		
		$plafond = number_format($user_["plafond"],2,',',' ');//$vendeur = $user_["vendeur_nom"];
		
		}
	


	// extracts profile list
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "compte_vendeur_client.php?client=" + client; }
	
--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo "Relevé Compte $client  Plafond : $plafond Edité le ".date("d/m/Y"); ?></span>

<span style="font-size:24px"><? echo "<a href=\"compte_vendeur.php?user_id=$user_id\">$vendeur</a>";?></span>


<table class="table2"><tr><td style="text-align:center">

	<center>

	


<p style="text-align:center">

<center>


</center>


<?
	$sql  = "SELECT id,evaluation,client,date_e,sum(net) As total_net,sum(reliquat) As total_reliquat ";$date_enc="2011-01-01";
	$sql .= "FROM commandes where client='$client' and id='$id' group by id ORDER BY date_e;";
	$users = db_query($database_name, $sql);
?>
<table class="table2">

<tr>
	
	<th><?php echo "Date";?></th>
	<th><?php echo "evaluation";?></th>
	<th><?php echo "Montant ";?></th>
	<th><?php echo "Encompte";?></th>
</tr>

<?php $ca=0;$reliquat=0;
			

while($users_ = fetch_array($users)) { ?>
<? $client=$users_["client"];$d=dateUsToFr($users_["date_e"]);$encompte_client=$users_["total_reliquat"];$net=$users_["total_net"];?>
<?php $vendeur=$users_["vendeur"];$id=$users_["id"];

if ($encompte_client>0){$ca=$ca+$net;$reliquat=$reliquat+$encompte_client;?>

<tr>
<? echo "<td><a href=\"payer_evaluation.php?user_id=$user_id&id=$id&client=$client\">$d</a></td>";?>

<td><?php echo $users_["evaluation"];?></td>
<td align="right"><?php echo number_format($net,2,',',' ');?></td>
<td align="right"><?php echo number_format($encompte_client,2,',',' ');?></td></tr>
<? }?>
				
<? } 


?>
<td></td><td></td>
<td align="right"><?php echo number_format($ca,2,',',' ');?></td>
<td align="right"><?php echo number_format($reliquat,2,',',' ');?></td>
</table>




<span style="font-size:24px"><?php echo "Relevé Compte $vendeur Plafond : $plafond Edité le ".date("d/m/Y"); ?></span>

<table class="table2"><tr><td style="text-align:center">

	<center>

	

<p style="text-align:center">

<center>


</center>


<?
	$sql  = "SELECT client,date_e,sum(net) As total_net,sum(reliquat) As total_reliquat ";$date_enc="2011-01-01";
	$sql .= "FROM commandes where vendeur='$vendeur' group by client ORDER BY client;";
	$users = db_query($database_name, $sql);
?>
<table class="table2">

<tr>
	
	<th><?php echo "Client";?></th>
	
	<th><?php echo "Encompte";?></th>
</tr>

<?php $ca=0;$reliquat=0;
			

while($users_ = fetch_array($users)) { ?>
<? $client=$users_["client"];$d=$users_["date_e"];$net=$users_["net"];$encompte_client=$users_["total_reliquat"];$net=$users_["total_net"];?>
<?php $vendeur=$users_["vendeur"];$ca=$ca+$net;$reliquat=$reliquat+$encompte_client;

if ($encompte_client>0){?>

<tr>
<? echo "<td><a href=\"compte_client_reliquat.php?user_id=$user_id&client=$client\">$client</a></td>";?>

<td align="right"><?php echo number_format($encompte_client,2,',',' ');?></td></tr>
<? }?>
				
<? } 


?>
<td></td>

<td align="right"><?php echo number_format($reliquat,2,',',' ');?></td>
</table>


</body>

</html>