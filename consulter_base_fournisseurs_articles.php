<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$ty="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>	
<script type="text/javascript">
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
xmlhttp.open("GET","getfrsarticle.php?q="+str,true);
xmlhttp.send();
}
</script>

</head>
<body>
<?
	$client_list = "";
	$sql = "SELECT * FROM  articles_commandes ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($profile_name == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$client_list .= $temp_["produit"];
		$client_list .= "</OPTION>";
	}
?>
<form>
<select onkeydown="return liDown(this);" id="users" name="users" onchange="showUser(this.value)"><?php echo $client_list; ?></select>
</form>
<br />
<div id="txtHint"><b>Resultat Recherche</b></div>

</body>
</html> 
