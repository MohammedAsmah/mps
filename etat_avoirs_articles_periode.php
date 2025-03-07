<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$date="";$date_f="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;
		$date="";$action="Recherche";	
	$profiles_list_vendeur = "";$vendeur="";

	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$profiles_list_client;
	$sql1 = "SELECT * FROM clients ORDER BY client;";
	$temp = db_query($database_name, $sql1);
	while($temp_ = fetch_array($temp)) {
		if($client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_client .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$profiles_list_client .= $temp_["client"];
		$profiles_list_client .= "</OPTION>";
	}
	$destination="";
	
	
	
	
	
	
		if(isset($_REQUEST["action"])){}else{
	?>
	<form id="form" name="form" method="post" action="etat_avoirs_articles_periode.php">
	<table>
	<td><?php echo "Du: "; ?><input onClick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au: "; ?><input onClick="ds_sh(this);" name="date2" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Ordre de Tri : "; ?>
	<select id="tri" name="tri">
	<option value="Article">Article</option>
	<option value="Quantite">Quantite</option>
	</select>
	<select id="ordretri" name="ordretri">
	<option value="Croissant">Croissant</option>
	<option value="Decroissant">Decroissant</option>
	</select>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{$date=dateFrToUs($_POST['date']);$date_f=dateFrToUs($_POST['date']);$date2=dateFrToUs($_POST['date2']);
	$ordretri=$_POST['ordretri'];$tri=$_POST['tri'];$destination=$_POST['destination'];$date_au=$_POST['date2'];$date_du=$_POST['date'];
		
		if ($tri=="Article"){if ($ordretri=="Croissant"){
		$sql  = "SELECT produit,prix_unit,condit,sum(quantite) as quantite ";
		$sql .= "FROM detail_avoirs where date between '$date' and '$date2' group by produit ORDER BY produit;";
		$users = db_query($database_name, $sql);
		}
		else
		{
		$sql  = "SELECT produit,prix_unit,condit,sum(quantite) as quantite ";
		$sql .= "FROM detail_avoirs where date between '$date' and '$date2' group by produit ORDER BY produit DESC;";
		$users = db_query($database_name, $sql);
		}
		}
		
		if ($tri=="Quantite"){if ($ordretri=="Croissant"){
		$sql  = "SELECT produit,prix_unit,condit,sum(quantite) as quantite ";
		$sql .= "FROM detail_avoirs where date between '$date' and '$date2' group by produit ORDER BY quantite;";
		$users = db_query($database_name, $sql);
		}
		else
		{
		$sql  = "SELECT produit,prix_unit,condit,sum(quantite) as quantite ";
		$sql .= "FROM detail_avoirs where date between '$date' and '$date2' group by produit ORDER BY quantite DESC;";
		$users = db_query($database_name, $sql);
		}
		}
		
		}
	
	
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Avoirs"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo "liste Avoirs Du $date_du Au $date_au "; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Produit";?></th>
	
	<th><?php echo "Quantite Avoir";?></th>
	<th><?php echo "Quantite Vendu";?></th>
	<th><?php echo "Pourcentage";?></th>
	<th><?php echo "Valeur";?></th>
	
	</tr>

<?php 


	$m=0;$total=0;
	
	while($users1_ = fetch_array($users)) { ?><tr>
<?php $produit=$users1_["produit"]; $id=$users1_["id"];
		$m=$users1_["quantite"]*$users1_["condit"];$p=$users1_["prix_unit"]*$m;$total=$total+$p;?>
		
		
		
		<? 
		$sql1  = "SELECT produit,prix_unit,condit,sum(quantite) as quantite ";
		$sql1 .= "FROM detail_commandes where date between '$date' and '$date2' and produit='$produit' group by produit ORDER BY quantite DESC;";
		$users1 = db_query($database_name, $sql1);$users1_1 = fetch_array($users1);
		$achats=$users1_1["quantite"]*$users1_1["condit"];
		
		if ($achats==0){?>
		
		<td bgcolor="#FF0000"><?php echo $users1_["produit"]; ?></td>
		<td align="center"><?php $q= $users1_["quantite"]*$users1_["condit"]; ?>
		<? echo "<a href=\"etat_avoirs_articles_periode_details.php?produit=$produit&date=$date&date2=$date2&qt=$q\">$q</a></td>";?>
		<td align="center">
		<? echo "$achats</td>";?>
		<td align="center"><?php $p100=0;@$p100=$m/$achats*100;echo number_format($p100,2,',',' ')." % "; ?></td>
		<td align="right"><?php echo number_format($p,2,',',' '); ?></td>
		<? } else {?>
		<td><?php echo $users1_["produit"]; ?></td>
		<td align="center"><?php $q= $users1_["quantite"]*$users1_["condit"]; ?>
		<? echo "<a href=\"etat_avoirs_articles_periode_details.php?produit=$produit&date=$date&date2=$date2&qt=$q\">$q</a></td>";?>
		<td align="center">
		<? echo "$achats</td>";?>
		<td align="center"><?php $p100=0;@$p100=$m/$achats*100;echo number_format($p100,2,',',' ')." % "; ?></td>
		<td align="right"><?php echo number_format($p,2,',',' '); ?></td>
		<? }?>
		
	<?}?>

	
</tr><td></td><td></td><td></td><td></td>
<td align="right"><?php $total=$total*0.90;$total=$total*0.98;echo number_format($total,2,',',' '); ?></td>
</table>

<? 
		$sql  = "SELECT sum(net) as net ";
		$sql .= "FROM commandes where date_e between '$date' and '$date2' group by vendeur ORDER BY date_e;";
		$users1 = db_query($database_name, $sql);
		while($users11_ = fetch_array($users1)) { 
				$ca=$ca+$users11_["net"]; 
			}
?>
<tr>
<table class="table2">
<td></td><td></td><td></td><td align="right">C.A TOTAL</td>
<td align="right"><?php echo number_format($ca,2,',',' '); ?></td>
<tr><td></td><td></td><td></td><td align="right"> % </td>
<td align="right"><?php echo @number_format($total/$ca*100,2,',',' '); ?></td>
</table>
</tr>
<p style="text-align:center">


</body>

</html>