<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$qte_tige1=0;

	if($user_id == "0" or $user_id=="20000000") {

		if ($user_id == "0"){
		$action_ = "insert_new_user";$date = dateUsToFr($_REQUEST["date"]);}
		if($user_id == "20000000"){$date = dateUsToFr($_REQUEST["date"]);
		$action_ = "import";}

		$title = "";

		$produit = "";$depot_a="";$produit1 = "";$depot_a1="";$produit2 = "";$depot_a2="";$produit3 = "";$depot_a3="";
		$produit4 = "";$depot_a4="";$produit5 = "";$depot_a5="";$produit6 = "";$depot_a6="";$produit7 = "";$depot_a7="";
		$qte=0;$depot_b=0;$depot_c=0;$produit8 = "";$depot_a8="";$produit9 = "";$depot_a9="";
		
	
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM entrees_stock WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "";

		$produit = $user_["produit"];$qte = $user_["qte"];$date = dateUsToFr($user_["date"]);
		$depot_a = $user_["depot_a"];$depot_b = $user_["depot_b"];$depot_c = $user_["depot_c"];
		$marron = $user_["marron"];$beige = $user_["beige"];$gris = $user_["gris"];
		$marron_b = $user_["marron_b"];$beige_b = $user_["beige_b"];$gris_b = $user_["gris_b"];
		
	}
	$profiles_list_article = "";
	$sql4 = "SELECT * FROM produits where enproduction=1 and dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article .= $temp_["produit"];
		$profiles_list_article .= "</OPTION>";
	}
	if($user_id == "0") {
	$profiles_list_article1 = "";
	$sql41 = "SELECT * FROM produits where enproduction=1 and dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit1 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article1 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article1 .= $temp_["produit"];
		$profiles_list_article1 .= "</OPTION>";
	}
	$profiles_list_article2 = "";
	$sql42 = "SELECT * FROM produits where enproduction=1 and dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit2 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article2 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article2 .= $temp_["produit"];
		$profiles_list_article2 .= "</OPTION>";
	}
	$profiles_list_article3 = "";
	$sql43 = "SELECT * FROM produits where enproduction=1 and dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit3 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article3 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article3 .= $temp_["produit"];
		$profiles_list_article3 .= "</OPTION>";
	}
	$profiles_list_article4 = "";
	$sql44 = "SELECT * FROM produits where enproduction=1 and dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit4 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article4 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article4 .= $temp_["produit"];
		$profiles_list_article4 .= "</OPTION>";
	}
	$profiles_list_article5 = "";
	$sql45 = "SELECT * FROM produits where enproduction=1 and dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit5 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article5 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article5 .= $temp_["produit"];
		$profiles_list_article5 .= "</OPTION>";
	}
	$profiles_list_article6 = "";
	$sql46 = "SELECT * FROM produits where enproduction=1 and dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit6 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article6 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article6 .= $temp_["produit"];
		$profiles_list_article6 .= "</OPTION>";
	}
	$profiles_list_article7 = "";
	$sql47 = "SELECT * FROM produits where enproduction=1 and dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit7 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article7 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article7 .= $temp_["produit"];
		$profiles_list_article7 .= "</OPTION>";
	}
	$profiles_list_article8 = "";
	$sql48 = "SELECT * FROM produits where enproduction=1 and dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit8 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article8 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article8 .= $temp_["produit"];
		$profiles_list_article8 .= "</OPTION>";
	}
	$profiles_list_article9 = "";
	$sql49 = "SELECT * FROM produits where enproduction=1 and dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql4);
	while($temp_ = fetch_array($temp)) {
		if($produit9 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_article9 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$profiles_list_article9 .= $temp_["produit"];
		$profiles_list_article9 .= "</OPTION>";
	}
	}
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
			alert("<?php echo "Nom Produit !"; ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression de ce produit ?"; ?>")) {
			document.location = "entrees_stock.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}
//--></script>

</head>

<body style="background:#dfe8ff">


<form id="form_user" name="form_user" method="post" action="entrees_stock_barcode.php">

      
		<? if($user_id != "20000000") {?>
        	<table width="671" class="table3">

		<tr>
		<td><td><?php echo "Date"; ?></td><td><input type="text" id="date" name="date" style="width:160px" value="<?php echo $date; ?>"></td>
		<tr><td style="text-align:center"><input type="text" id="barecode" name="barecode" onchange="showUserb(this.value)" style="width:100px" value="<?php echo $barecode; ?>"></td>
		<tr><td><?php echo "Article : "; ?></td><td align="right" style="width:160px"><div id="txtHint"></div></td>
		<td><td><?php echo "Quantite"; ?></td><td><input type="text" id="depot_a" name="depot_a" style="width:140px" value="<?php echo $depot_a; ?>"></td>
		
		</tr>
		</table>	
		<? }?>
     

<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">

<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">

<table class="table3"><tr>

<?php if($user_id != "0" and $user_id != "20000000") { ?>
<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td style="width:20px"></td>
<td><button type="button" onClick="DeleteUser()"><?php echo Translate("Delete"); ?></button></td>
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php } ?>
</tr></table>

</center>

</form>

</body>

</html>