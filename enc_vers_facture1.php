<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
	$error_message = "";
	$id_p=$_GET['id'];$reference=$_GET['reference'];
	$m_cheque = 0;
		$m_espece = 0;
		$m_effet = 0;
		
	
	if(isset($_REQUEST["action_"])) {
	
		
		$id = $_REQUEST["id"];
		$reference = $_REQUEST["reference"];
		$id_p = $_REQUEST["id_p"];
		$action_ = $_REQUEST["action_"];		
		
		if($_REQUEST["action_"] != "delete") {
		$m_cheque = $_REQUEST["m_cheque"];
		$m_espece = $_REQUEST["m_espece"];
		$m_effet = $_REQUEST["m_effet"];
		$date_f = dateFrToUs($_REQUEST["date_f"]);
		$facture_n = $_REQUEST["facture_n"];
		}
		
				switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
			break;

			case "update":
			$id=$_REQUEST["id"];
			$sql = "UPDATE porte_feuilles_factures SET date_f='$date_f',facture_n='$facture_n,m_cheque = '$m_cheque',m_espece = '$m_espece',m_effet = '$m_effet'
			 WHERE id = '$id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete":
			

			// delete user's profile
			
			$sql  = "SELECT *";
			$sql .= "FROM porte_feuilles_factures WHERE id = " . $_REQUEST["id"] . ";";
			$users11 = db_query($database_name, $sql);$users_1 = fetch_array($users11);
			$id_p=$users_1["id_porte_feuille"];
			
			
			$sql = "DELETE FROM porte_feuilles_factures WHERE id = " . $_REQUEST["id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
		
		
		
	
	
	
	
	
	
	}
	
	/*echo $action_."   ".$id."   ".$reference."    ".$id_p;*/
	
	
	
	
	
	
	

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "Detail Evaluation"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
			UpdateUser();
	}

--></script>

<style type="text/css">
<!--
.Style1 {color: #FF0000}
-->
</style>
</head>

<body style="background:#dfe8ff">

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>



<tr>
		
		<table class="table2">
		<th><?php echo "Facture";?></th>
	<th><?php echo "Client";?></th>
	<th><?php echo "M.Esp";?></th>
	<th><?php echo "M.Cheque";?></th>
	<th><?php echo "M.Effet";?></th>
	<th><?php echo "Total Enc";?></th>
		
	<?
	///////////////
	$sql  = "SELECT * ";$t=0;
	$sql .= "FROM porte_feuilles_factures where id_porte_feuille='$id_p' ORDER BY id;";
	$users111 = db_query($database_name, $sql);
	while($users_11 = fetch_array($users111)) 
	{ $fact=$users_11["facture_n"];$date_facture_4_c=$users_11["date_f"];
		
		if ($fact>9039){
		$sql  = "SELECT * ";
		$sql .= "FROM factures2016 where numero='$fact' order BY id;";
		$users = db_query($database_name, $sql);
		
		}else
		{if ($fact<10){$zero="000";}
		if ($fact>=10 and $fact<100){$zero="00";}
		if ($fact>=100 and $fact<1000){$zero="0";}
		if ($fact>=1000 and $fact<10000){$zero="";}
		if ($date_facture_4_c>="2018-01-01" and $date_facture_4_c<"2019-01-01"){$factures="factures2018";$exe4=$zero.$fact."/18";}
		if ($date_facture_4_c>="2017-01-01" and $date_facture_4_c<"2018-01-01"){$factures="factures";$exe4=$zero.$fact."/17";}
		if ($date_facture_4_c>="2019-01-01" and $date_facture_4_c<"2020-01-01"){$factures="factures2019";$exe4=$zero.$fact."/19";}
		if ($date_facture_4_c>="2020-01-01" and $date_facture_4_c<"2021-01-01"){$factures="factures2020";$exe4=$zero.$fact."/20";}
		if ($date_facture_4_c>="2021-01-01" and $date_facture_4_c<"2022-01-01"){$factures="factures2021";$exe4=$zero.$fact."/21";}
		if ($date_facture_4_c>="2022-01-01" and $date_facture_4_c<"2023-01-01"){$factures="factures2022";$exe4=$zero.$fact."/22";}
		if ($date_facture_4_c>="2023-01-01" and $date_facture_4_c<"2024-01-01"){$factures="factures2023";$exe4=$zero.$fact."/23";}
		if ($date_facture_4_c>="2024-01-01" and $date_facture_4_c<"2025-01-01"){$factures="factures2024";$exe4=$zero.$fact."/24";}
		if ($date_facture_4_c>="2025-01-01" and $date_facture_4_c<"2026-01-01"){$factures="factures2025";$exe4=$zero.$fact."/25";}
		if ($date_facture_4_c>="2026-01-01" and $date_facture_4_c<"2027-01-01"){$factures="factures2026";$exe4=$zero.$fact."/26";}
		
		$sql  = "SELECT * ";
		$sql .= "FROM ".$factures." where numero='$fact' order BY id;";
		$users = db_query($database_name, $sql);
		
		}
		
		
	
		$t=$t+$users_11["m_cheque"]+$users_11["m_espece"]+$users_11["m_effet"];$id1=$users_11["id"];?>
		<? echo "<tr><td><a href=\"enc_vers_facture2.php?id_p=$id_p&id=$id1&reference=$reference\">$exe4</a></td>";?>
		
		<td align="left"><?php $clt=$users_11["client"];print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$clt </font>");?></td>
		<td align="right"><?php $esp=number_format($users_11["m_espece"],2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$esp </font>");?></td>
		<td align="right"><?php $chq=number_format($users_11["m_cheque"],2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$chq </font>");?></td>
		<td align="right"><?php $eff=number_format($users_11["m_effet"],2,',',' ');print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$eff </font>");?></td>
		<td align="right"><?php $tchq=number_format($users_11["m_cheque"]+$users_11["m_espece"]+$users_11["m_effet"],2,',',' ');
			print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tchq </font>");
			 ?></td>	</tr>	
	<?	
	
	}
	?>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td><? echo "Toal : ";?></td>
	<td align="right"><?php $tchq=number_format($t,2,',',' ');
			print("<font size=\"1\" face=\"Comic sans MS\" color=\"#000033\">$tchq </font>");
			 ?></td></tr>
	
	</table>

        <p>&nbsp;</p>
  <tr>
  <p style="text-align:center">
    


<p style="text-align:center">
</body>

</html>