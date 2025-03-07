<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	
	
	// extracts profile list

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">
<link href="Templates/css.css" rel="stylesheet" type="text/css">
<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
		if(document.getElementById("produit").value == "" ) {
			alert("<?php echo "Nom Produit !"; ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression de ce produit ?"; ?>")) {
			document.location = "produits.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

//--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php $produit = $_REQUEST["produit"];$jour=date("d/m/y");echo "Article : $produit  au $jour  "; ?></span>

<table class="table2">
<TD>DATE</TD>
<TD bgcolor="#66CCFF"> MPS</TD>
<TD bgcolor="#FF9999">JAOUDA</TD>
<TD bgcolor="#FF9999"> TOTAL </TD>
</TR>
<? 			
	
			$sql1  = "SELECT * ";
			$sql1 .= "FROM mvt_stock_produits where produit='$produit' ORDER BY date;";
			$users11 = db_query($database_name, $sql1);
			while($users11_ = fetch_array($users11)) { 
					$depot_a=$users11_["depot_a"];$depot_b=$users11_["depot_b"];$date=dateUsToFr($users11_["date"]);?>
			
			
			
			<tr><td><?php echo $date; ?></td>	
			<td align="right"><?php echo $depot_a; ?></td>
			<td align="right"><?php echo $depot_b; ?></td>
			<td align="right"><?php echo $depot_a+$depot_b; ?></td>
			</tr>
			
			
			

				<?

			}
			
	?>
	

</table>	


</body>

</html>