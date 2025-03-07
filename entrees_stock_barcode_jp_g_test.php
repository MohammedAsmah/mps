<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$user_id=0;$action_="insert_new_user";$date=date("Y-m-d");$datefr=date("d-m-Y");$date_ins=date("Y-m-d h:i:sa");$id_registre=$_GET["id_registre"];
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) ) { 

		if($_REQUEST["action_"] != "delete_user" and $_REQUEST["action_"] != "import") {
			// prepares data to simplify database insert or update
			$barecode = $_REQUEST["barecode"];$id_registre = $_REQUEST["id_registre"];
			$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE barecode = '$barecode' ;";$id_p=$_REQUEST["user_id"];
		$userp = db_query($database_name, $sql);
		$user_a = fetch_array($userp);$condit = $user_a["condit"];$id_produit = $user_a["id"];$produit = $user_a["produit"];$palette = $user_a["palette"];
			
			$depot_a=$_REQUEST["depot_a"];$depot_c=0;$depot_b=0;
			if ($depot_a>0){}else{$depot_a = $palette;}
			
			;$type="production";
			
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		if($produit <> "") {
	
				$sql  = "INSERT INTO entrees_stock_test ( produit, date,id_registre,date_ins,depot_b,type,depot_a ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $date . "', ";$sql .= "'" . $id_registre . "', ";
				$sql .= "'" . $date_ins . "', ";
				$sql .= "'" . $depot_a . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
				
				
					$barecode = "";$depot_a="";
			}
		
							
			break;

			case "update_user":
			
			
					
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM entrees_stock_test WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			$sql = "DELETE FROM entrees_stock_acc WHERE id_p = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			break;

			case "import":

			echo "importation en cours";
			break;


		}

	$vide="";
				$sql = "DELETE FROM entrees_stock_test WHERE produit = '" . $vide . "';";
				db_query($database_name, $sql);
		//switch
	} //if
	
	
	// recherche ville
	?>
	
	
	
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "ENTREE PRODUCTION"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">



<style>
.mycontainer {
  width:100%;
  overflow:auto;
}
.mycontainer div {
  width:33%;
  float:left;
}
</style>


<script type="text/javascript"><!--
	function showUserb(str)
{
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_article_barecode.php?q="+str,true);
xmlhttp.send();

}

function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
		
		if(document.getElementById("barecode").value == "" ) {
			alert("<?php echo "Scan article !"; ?>");
		} else {
			UpdateUser();
		}
		
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression de ce produit ?"; ?>")) {
			document.location = "entrees_stock_barcode_jp_g_test.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}
	
	$('form input').on('change', function() {
    $(this).closest('form').submit();
});
	
--></script>

</head>
	
	<? $barecode = "";$depot_a=1;?>
	
	
	
	
	
	<form id="form" name="form" method="post" action="entrees_stock_barcode_jp_g_test.php">
	
	<div>
	<h1 style="color:blue;"><?php echo $date_ins." ---->BON DE SORTIE ".$id_registre; ?></h1>
	<label for="barecode">Bare code:</label>
  <input type="text" id="barecode" name="barecode"  size="50" onchange="this.form.submit()" value="<?php echo $barecode; ?>" tabindex="1" required autofocus><br><br>
  
  
</div>

<div id="txtHint">
  <h1><?php echo "Article : "; ?></h1>
  
</div>

<div>
  <h1><?php echo "Quantite"; ?></h1>
  <p><input type="text" id="depot_a" name="depot_a" size="30" style="width:140px" value="<?php echo $depot_a; ?>"></p>
  
</div>
	
	
	
	
	
	
<p style="text-align:center">

<center>


<input type="hidden" id="date" name="date" value="<?php echo $date; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="id_registre" name="id_registre" value="<?php echo $id_registre; ?>">

<table class="table3"><tr>


</tr></table>

</center>

</form>

	
	<? 
	$sql  = "SELECT produit, date,date_ins,sum(depot_b) As depot_b,type,sum(depot_a) As depot_a ";$type="production";$dj=date("Y-m-d");
	$sql .= "FROM entrees_stock_test where type='$type' and date='$dj' and id_registre='$id_registre' group by produit ORDER BY produit;";
	$users = db_query($database_name, $sql);

	
?>



<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "SORTIE STOCK"; ?></span>


<table class="table2">

<tr>
	
	<th><?php echo "Article  "; ?></th>
	<th><?php echo "Photo  "; ?></th>
	<th><?php echo "QUANTITE"; ?></th>
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<? $user_id=$users_["id"];$date1=dateUsToFr($users_["date"]);

?>

<td style="font-size:20px"><?php echo $users_["produit"]; $produit=$users_["produit"];
$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$userp = db_query($database_name, $sql);
		$user_a = fetch_array($userp);$condit = $user_a["condit"];$photo=$user_a["image"];
?></td>

<td style="font-size:20px"><?php echo $users_["depot_b"]; ?></td>
<? print("<td><img src=\"./$photo\" alt=\"\" style=\"width:40px;height:40px;\" border=\"1\"></td>");?>


<?php } ?>

</table>

<p style="text-align:center">
<table><tr><td>
<? //if ($date=="--" or $date==""){}else{echo "<a href=\"entree_stock_barcode.php?date=$date&user_id=0\">Ajout Production</a></td>";}?></tr><tr>
<td><? /*echo "<a href=\"entree_stock.php?date=$date&user_id=20000000\">Importation Production</a></td>";*/?></tr>
</table>
</body>

</html>