<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$numero = $_REQUEST["numero"];$client = $_REQUEST["client"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$produit = "";
		$quantite = "";
		$prix_unit = "";
		$condit = "";$sans_remise = 0;
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM detail_factures WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$produit = $user_["produit"];
		$quantite = $user_["quantite"];
		$prix_unit = $user_["prix_unit"];
		$condit = $user_["condit"];$sans_remise = $user_["sans_remise"];
		
		}

	// extracts profile list
	$produit_list = "";
	$sql = "SELECT * FROM  produits ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list .= $temp_["produit"];
		$produit_list .= "</OPTION>";
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
		if(document.getElementById("produit").value == "" ) {
			alert("<?php echo Translate("champs indispensables !"); ?>");
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "maj_factures.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

function showUser(str)
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
xmlhttp.open("GET","recherche_prix_article_facture.php?q="+str,true);
xmlhttp.send();
}

function showUser(str)
{
if (str=="")
  {
  document.getElementById("txtHint1").innerHTML="";
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
    document.getElementById("txtHint1").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_prix_article_facture.php?q="+str,true);
xmlhttp.send();
}

--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="maj_factures.php">

	<table class="table3">
		<tr>
		<td><?php echo "Produit : "; ?></td><td><select id="produit" name="produit" onchange="showUser(this.value)"><?php echo $produit_list; ?></select></td>
	
		</tr>
		<tr><td>
		
		<div id="txtHint"></div></td>
		
		<tr>
		<td><?php echo "Quantite"; ?></td><td align="center"><input type="text" id="quantite" name="quantite" style="width:160px" value="<?php echo $quantite; ?>"></td>
		</tr>
		<tr><td>
		
		<div id="txtHint1"></div></td>
		
		<tr>
				<td><?php echo "Test : ".$tp; ?></td>
		</tr>
		<tr><td><input type="checkbox" id="sans_remise" name="sans_remise"<?php if($sans_remise) { echo " checked"; } ?>></td><td>Article sans Remises</td>
		</tr>
	</table>

<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="numero" name="numero" value="<?php echo $numero; ?>">
<input type="hidden" id="client" name="client" value="<?php echo $client; ?>">
<input type="hidden" id="prix_unit" name="prix_unit" value="<?php echo $prix_unit; ?>">
<input type="hidden" id="condit" name="condit" value="<?php echo $condit; ?>">
<input type="hidden" id="montant" name="montant" value="<?php echo $mt; ?>">
<table class="table3"><tr>

<?php if($user_id != "0") { $action_maj="update_user";$action_sup="delete_user";?>

<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td><button type="button" onClick="DeleteUser()"><?php echo Translate("Delete"); ?></button></td>

<?php } else { ?>

<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td> 
<?php 
} ?>
</tr></table>
</center>

</form>

</body>

</html>