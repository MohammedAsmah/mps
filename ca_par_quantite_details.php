<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";	$du=$_GET["du"];$au=$_GET["au"];$matiere=$_GET["matiere"];
	$du1=dateUsToFr($_GET["du"]);$au1=dateUsToFr($_GET["au"]);
	$du=$_GET["du"];$au=$_GET["au"];
	
	
?>
</table>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "produit.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:18px"><?php echo " CA par Quantite :  du : $du1 au $au1 : $matiere"; ?></span>

<table class="table2">
<td bgcolor="#66FFCC"><? echo "Facture";?></td>
<td bgcolor="#66FFCC"><? echo "Client";?></td>
<td bgcolor="#66FFCC"><? echo "Date";?></td>
<td bgcolor="#66FFCC"><? echo "Quantite";?></td>
<td bgcolor="#66FFCC"><? echo "Conditionnement";?></td>
<td bgcolor="#66FFCC"><? echo "Prix Unit";?></td>
<td bgcolor="#66FFCC"><? echo "Total Quantité";?></td>
<?	

	if ($du>"2018-12-31"){
		
	if ($du>="2017-01-01" and $au<"2018-01-01"){$factures="factures";$exe="/17";$detail_factures="detail_factures2017";}
	if ($du>="2018-01-01" and $au<"2019-01-01"){$factures="factures2018";$exe="/18";$detail_factures="detail_factures2018";}
	
	if ($du>="2019-01-01" and $au<"2020-01-01"){$factures="factures2019";$exe="/19";$detail_factures="detail_factures2019";}
	if ($du>="2020-01-01" and $au<"2021-01-01"){$factures="factures2020";$exe="/20";$detail_factures="detail_factures2020";}
	if ($du>="2021-01-01" and $au<"2022-01-01"){$factures="factures2021";$exe="/21";$detail_factures="detail_factures2021";}
	if ($du>="2022-01-01" and $au<"2023-01-01"){$factures="factures2022";$exe="/22";$detail_factures="detail_factures2022";}
	if ($du>="2023-01-01" and $au<"2024-01-01"){$factures="factures2023";$exe="/23";$detail_factures="detail_factures2023";}
	if ($du>="2024-01-01" and $au<"2025-01-01"){$factures="factures2024";$exe="/24";$detail_factures="detail_factures2024";}
	if ($du>="2025-01-01" and $au<"2026-01-01"){$factures="factures2025";$exe="/25";$detail_factures="detail_factures2025";}
	if ($du>="2026-01-01" and $au<"2027-01-01"){$factures="factures2026";$exe="/26";$detail_factures="detail_factures2026";}	
		
		
		
		
		
	$sql1  = "SELECT * ";$m=0;
	$sql1 .= "FROM ".$detail_factures." where produit='$matiere' and (date_f between '$du' and '$au' ) ORDER BY facture;";
	}
	else
	{
	$sql1  = "SELECT * ";$m=0;
	$sql1 .= "FROM detail_factures where produit='$matiere' and (date_f between '$du' and '$au' ) ORDER BY facture;";
	}
	
	
	$users11 = db_query($database_name, $sql1);
	while($users11_ = fetch_array($users11)) { 
			$qte=($users11_["quantite"]*$users11_["condit"]);
			
			
			
			
			
			
	{?>	<tr>
	<td align="center"><? echo $users11_["facture"];?></td>
	
	<? $sql  = "SELECT * ";$id=$users11_["facture"];
		$sql .= "FROM ".$factures." WHERE id = " . $id . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$client = $user_["client"];$editee = $user_["editee"];$date_f = $user_["date_f"];
		
		/////////////////////
	/*	$idp=$users11_["id"]);
			$quantite=10;
			$condit=15;
			$prix_unit=30;
			$produit="TABLE MIDA ARTISANALE";
			$produit1="TABOURET FLEURIE GM";
			$matiere="POLYPROPYLENE";$poids=1210;
			$quantite1=1;
			$condit1=10;
			$prix_unit1=28;
		$sql = "UPDATE detail_factures2020 SET ";
			$sql .= "quantite = '" . $quantite . "', ";
			$sql .= "condit = '" . $condit . "', ";
			$sql .= "prix_unit = '" . $prix_unit . "', ";
			$sql .= "produit = '" . $produit . "' ";
			$sql .= "WHERE id = " . $idp . ";";
			db_query($database_name, $sql);
	
	$sql  = "INSERT INTO detail_factures2020 ( facture,date_f, produit, matiere,poids,quantite,prix_unit,condit ) VALUES ( ";
				$sql .= "'" . $id . "', ";
				$sql .= "'" . $date_f . "', ";
				$sql .= "'" . $produit1 . "', ";
				$sql .= "'" . $matiere . "', ";
				$sql .= "'" . $poids . "', ";
				$sql .= "'" . $quantite1 . "', ";
				$sql .= "'" . $prix_unit1 . "', ";
				$sql .= "'" . $condit1 . "');";

				db_query($database_name, $sql);
		
		*/
		
		
		
		
		
	?>
	
	
	
	
	
	<td align="center"><? echo $client;?></td>
	<td align="center"><? echo dateUsToFr($users11_["date_f"]);?></td>
	<td align="center"><? echo $users11_["quantite"];?></td>
	<td align="center"><? echo $users11_["condit"];?></td>
	<td align="center"><? echo $users11_["prix_unit"];?></td>
	<td align="center"><? echo $users11_["remise10"]."-".$users11_["remise2"]."-".$users11_["remise3"];?></td>
	<td align="right"><? echo $qte;?></td>
	<td align="right"><? echo $editee;?></td></tr>
	
	<? $m=$m+$qte; ?><? }
	 ?>
	<? }?>
	<td></td><td></td><td></td><td></td><td></td><td></td><td align="right"><? echo $m;?></td>

	

</table>

<tr>
<table class="table2">
<td bgcolor="#66FFCC"><? echo "client";?></td>
<td bgcolor="#66FFCC"><? echo "c.a";?></td>

<?	

	if ($du>"2018-12-31"){
	$sql12  = "SELECT editee,client,sum(quantite*condit) As quantite ";$m=0;
	$sql12 .= "FROM ".$detail_factures." where produit='$matiere' and (date_f between '$du' and '$au' ) group BY client;";
	}
	else
	{
	$sql12  = "SELECT client,sum(quantite*condit) As quantite ";$m=0;
	$sql12 .= "FROM detail_factures where produit='$matiere' and (date_f between '$du' and '$au' ) group BY client;";
	}
	$users112 = db_query($database_name, $sql12);
	while($users112_ = fetch_array($users112)) { 
			$qte=$users112_["quantite"];$editee=$users112_["editee"];
	if ($editee==1){?>	<tr>
	<td align="center" bgcolor="#66FFCC"><? echo $users112_["client"];?></td>
	<td align="center" bgcolor="#66FFCC"><? echo $users112_["quantite"];?></td>
	
	
	<? } else {?> 
	<tr>
	<td align="center"><? echo $users112_["client"];?></td>
	<td align="center"><? echo $users112_["quantite"];?></td>
	
	
	<? }
	
	 }?>



</table>

</body>

</html>