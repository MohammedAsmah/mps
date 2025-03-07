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
<td bgcolor="#66FFCC"><? echo "Article";?></td>
<td bgcolor="#66FFCC"><? echo "Quantite";?></td>
<td bgcolor="#66FFCC"><? echo "Prix Unit";?></td>
<td bgcolor="#66FFCC" colspan="3"><? echo "Remises";?></td>
<td bgcolor="#66FFCC"><? echo "Total";?></td>
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
		
		
		
		
		
	$sql1  = "SELECT * ";$mt=0;$qt=0;
	$sql1 .= "FROM ".$detail_factures." where (date_f between '$du' and '$au' ) ORDER BY facture;";
	}
	else
	{
	$sql1  = "SELECT * ";$mt=0;$qt=0;
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
		
	
		
		
		
	?>
	
	
	
	
	
	<td align="center"><? echo $client;?></td>
	<td align="center"><? echo dateUsToFr($users11_["date_f"]);?></td>
	<td align="center"><? echo $users11_["produit"];?></td>
	<td align="center"><? echo $users11_["quantite"]*$users11_["condit"];?></td>
	<td align="center"><? echo $users11_["prix_unit"];?></td>
	<td align="center"><? echo $users11_["remise10"];?></td>
	<td align="center"><? echo $users11_["remise2"];?></td>
	<td align="center"><? echo $users11_["remise3"];?></td>
	<td align="right"><?  echo number_format($users11_["prix_unit_net"],2,'.',' ');?></td>
	
	</tr>
	
	<? $qt=$qt+$qte;$mt=$mt+$users11_["prix_unit_net"]; ?><? }
	 ?>
	<? }?>
	<tr>
	<td></td><td></td><td></td><td></td>
	<td align="right"><? echo $qt;?></td>
	<td></td><td></td><td></td><td></td><td align="right"><? echo number_format($mt,2,'.',' ');?></td>

	

</table>

</body>

</html>