<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];$numero = $_REQUEST["numero"];$client = $_REQUEST["client"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$produit = "-";$barecode="";
		$quantite = "";
		$prix = "";$prix1 = "";$prix2 = "";$prix3 = "";$prix4 = "";$prix5 = "";$prix6 = "";$prix7 = "";$prix8 = "";
		$prix9 = "";$prix10 = "";$prix11 = "";$prix12 = "";$prix13 = "";$prix14 = "";$prix15 = "";$prix16 = "";$prix17 = "";
		$prix18 = "";$prix19 = "";$prix20 = "";
		$condit = "";$sans_remise = 0;
		$produit1 = "-";
		$quantite1 = "";
		$produit2 = "-";
		$quantite2 = "";
		$produit3 = "-";
		$quantite3 = "";
		$produit4 = "-";
		$quantite4 = "";
		$produit5 = "-";
		$quantite5 = "";
		$produit6 = "-";
		$quantite6 = "";
		$produit7 = "-";
		$quantite7 = "";
		$produit8 = "-";
		$quantite8 = "";
		$produit9 = "-";
		$quantite9 = "";
		$produit10 = "-";
		$quantite10 = "";
		$produit11 = "-";$quantite11 = "";
		$produit12 = "-";$quantite12 = "";
		$produit13 = "-";$quantite13 = "";$produit14 = "";$quantite14 = "";$produit15 = "";$quantite15 = "";
		$produit16 = "-";$quantite16 = "";$produit17 = "";$quantite17 = "";$produit18 = "";$quantite18 = "";
		$produit19 = "-";$quantite19 = "";$produit20 = "";$quantite20 = "";

		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM detail_avoirs WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "details";

		$produit = $user_["produit"];
		$quantite = $user_["quantite"];
		$prix_unit = $user_["prix_unit"];
		$condit = $user_["condit"];$sans_remise = $user_["sans_remise"];
		
		}

	// extracts profile list
	$produit_list = "";
	$sql = "SELECT * FROM  produits where facturation=0 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list .= $temp_["produit"];
		$produit_list .= "</OPTION>";
	}
	
	if($user_id == "0") {
	$produit_list1 = "";
	$sql = "SELECT * FROM  produits where facturation=0 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit1 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list1 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list1 .= $temp_["produit"];
		$produit_list1 .= "</OPTION>";
	}
		$produit_list2 = "";
	$sql = "SELECT * FROM  produits where facturation=0 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit2 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list2 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list2 .= $temp_["produit"];
		$produit_list2 .= "</OPTION>";
	}
	$produit_list3 = "";
	$sql = "SELECT * FROM  produits where facturation=0 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit3 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list3 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list3 .= $temp_["produit"];
		$produit_list3 .= "</OPTION>";
	}
		$produit_list4 = "";
	$sql = "SELECT * FROM  produits where facturation=0 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit4 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list4 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list4 .= $temp_["produit"];
		$produit_list4 .= "</OPTION>";
	}
	$produit_list5 = "";
	$sql = "SELECT * FROM  produits where facturation=0 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit5 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list5 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list5 .= $temp_["produit"];
		$produit_list5 .= "</OPTION>";
	}
		$produit_list6 = "";
	$sql = "SELECT * FROM  produits where facturation=0 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit6 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list6 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list6 .= $temp_["produit"];
		$produit_list6 .= "</OPTION>";
	}
		$produit_list7 = "";
	$sql = "SELECT * FROM  produits where facturation=0 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit7 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list7 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list7 .= $temp_["produit"];
		$produit_list7 .= "</OPTION>";
	}
		$produit_list8 = "";
	$sql = "SELECT * FROM  produits where facturation=0 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit8 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list8 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list8 .= $temp_["produit"];
		$produit_list8 .= "</OPTION>";
	}
	$produit_list9 = "";
	$sql = "SELECT * FROM  produits where facturation=0 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit9 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list9 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list9 .= $temp_["produit"];
		$produit_list9 .= "</OPTION>";
	}
		$produit_list10 = "";
	$sql = "SELECT * FROM  produits where facturation=0 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit10 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list10 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list10 .= $temp_["produit"];
		$produit_list10 .= "</OPTION>";
	}
	
			$produit_list11 = "";
	$sql = "SELECT * FROM  produits where facturation=0 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit11 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list11 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list11 .= $temp_["produit"];
		$produit_list11 .= "</OPTION>";
	}
		$produit_list12 = "";
	$sql = "SELECT * FROM  produits where facturation=0 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit12 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list12 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list12 .= $temp_["produit"];
		$produit_list12 .= "</OPTION>";
	}
		$produit_list13 = "";
	$sql = "SELECT * FROM  produits where facturation=0 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit13 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list13 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list13 .= $temp_["produit"];
		$produit_list13 .= "</OPTION>";
	}
		$produit_list14 = "";
	$sql = "SELECT * FROM  produits where facturation=0 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit14 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list14 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list14 .= $temp_["produit"];
		$produit_list14 .= "</OPTION>";
	}
		$produit_list15 = "";
	$sql = "SELECT * FROM  produits where facturation=0 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit15 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list15 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list15 .= $temp_["produit"];
		$produit_list15 .= "</OPTION>";
	}
		$produit_list16 = "";
	$sql = "SELECT * FROM  produits where facturation=0 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit16 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list16 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list16 .= $temp_["produit"];
		$produit_list16 .= "</OPTION>";
	}
		$produit_list17 = "";
	$sql = "SELECT * FROM  produits where facturation=0 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit17 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list17 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list17 .= $temp_["produit"];
		$produit_list17 .= "</OPTION>";
	}
		$produit_list18 = "";
	$sql = "SELECT * FROM  produits where facturation=0 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit18 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list18 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list18 .= $temp_["produit"];
		$produit_list18 .= "</OPTION>";
	}
		$produit_list19 = "";
	$sql = "SELECT * FROM  produits where facturation=0 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit19 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list19 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list19 .= $temp_["produit"];
		$produit_list19 .= "</OPTION>";
	}

			$produit_list20 = "";
	$sql = "SELECT * FROM  produits where facturation=0 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit20 == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list20 .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list20 .= $temp_["produit"];
		$produit_list20 .= "</OPTION>";
	}

	
	
	
	
	
	
	
	}
	
	
	
	
	
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<script type="text/javascript">
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
xmlhttp.open("GET","recherche_prix_article_barecode.php?q="+str,true);
xmlhttp.send();
}
function showUserp(str)
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
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}
function showUser1(str)
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
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}
function showUser2(str)
{
if (str=="")
  {
  document.getElementById("txtHint2").innerHTML="";
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
    document.getElementById("txtHint2").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}

function showUser3(str)
{
if (str=="")
  {
  document.getElementById("txtHint3").innerHTML="";
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
    document.getElementById("txtHint3").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}

function showUser4(str)
{
if (str=="")
  {
  document.getElementById("txtHint4").innerHTML="";
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
    document.getElementById("txtHint4").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}

function showUser5(str)
{
if (str=="")
  {
  document.getElementById("txtHint5").innerHTML="";
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
    document.getElementById("txtHint5").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}

function showUser6(str)
{
if (str=="")
  {
  document.getElementById("txtHint6").innerHTML="";
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
    document.getElementById("txtHint6").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}

function showUser7(str)
{
if (str=="")
  {
  document.getElementById("txtHint7").innerHTML="";
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
    document.getElementById("txtHint7").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}

function showUser8(str)
{
if (str=="")
  {
  document.getElementById("txtHint8").innerHTML="";
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
    document.getElementById("txtHint8").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}

function showUser9(str)
{
if (str=="")
  {
  document.getElementById("txtHint9").innerHTML="";
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
    document.getElementById("txtHint9").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}

function showUser10(str)
{
if (str=="")
  {
  document.getElementById("txtHint10").innerHTML="";
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
    document.getElementById("txtHint10").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}

function showUser11(str)
{
if (str=="")
  {
  document.getElementById("txtHint11").innerHTML="";
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
    document.getElementById("txtHint11").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}

function showUser12(str)
{
if (str=="")
  {
  document.getElementById("txtHint12").innerHTML="";
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
    document.getElementById("txtHint12").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}

function showUser13(str)
{
if (str=="")
  {
  document.getElementById("txtHint13").innerHTML="";
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
    document.getElementById("txtHint13").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}

function showUser14(str)
{
if (str=="")
  {
  document.getElementById("txtHint14").innerHTML="";
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
    document.getElementById("txtHint14").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}

function showUser15(str)
{
if (str=="")
  {
  document.getElementById("txtHint15").innerHTML="";
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
    document.getElementById("txtHint15").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}


function showUser16(str)
{
if (str=="")
  {
  document.getElementById("txtHint16").innerHTML="";
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
    document.getElementById("txtHint16").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}

function showUser17(str)
{
if (str=="")
  {
  document.getElementById("txtHint17").innerHTML="";
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
    document.getElementById("txtHint17").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}

function showUser18(str)
{
if (str=="")
  {
  document.getElementById("txtHint18").innerHTML="";
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
    document.getElementById("txtHint18").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}

function showUser19(str)
{
if (str=="")
  {
  document.getElementById("txtHint19").innerHTML="";
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
    document.getElementById("txtHint19").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}

function showUser20(str)
{
if (str=="")
  {
  document.getElementById("txtHint20").innerHTML="";
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
    document.getElementById("txtHint20").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}

function showUser21(str)
{
if (str=="")
  {
  document.getElementById("txtHint21").innerHTML="";
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
    document.getElementById("txtHint21").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","recherche_prix_article.php?q="+str,true);
xmlhttp.send();
}




</script>



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
			document.location = "enregistrer_panier_avoir.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}

	function UpdatePrice() {
		document.forms["form_user"].elements["prix"].value=document.getElementById("t1").value;

	}
	
--></script>

</head>

<body style="background:#dfe8ff">

<span style="font-size:24px"><?php echo $title; ?></span>

<form id="form_user" name="form_user" method="post" action="enregistrer_panier_avoir.php">

	<table class="table2">
		<? if($user_id == "0") {?>
		<tr><td><?php echo "codebare  "; ?></td>
		<td><?php echo "produit  "; ?></td>
		<td><?php echo "Quantite  "; ?></td>
		<td><?php echo "Prix Unit  "; ?></td>
		<td><?php echo "Prix Modif.  "; ?></td>
		</tr>
		

		<? /*<td><select onkeydown="return liDown(this);" id="produit" name="produit"><?php echo $produit_list; ?></select></td>
		*/?>
		<tr><td align="center"><input type="text" id="barecode" name="barecode" onchange="showUserb(this.value)" style="width:160px" value="<?php echo $barecode; ?>"></td>
		<td><select id="produit" name="produit" onchange="showUserc(this.value)"><?php echo $produit_list; ?></select></td>
		<td align="center"><input type="text" id="quantite" name="quantite" style="width:160px" value="<?php echo $quantite; ?>"></td>
		<td align="right"><div id="txtHint"></div></td>
		<td align="center"><input type="text" id="prix" name="prix" value="<?php echo $prix; ?>" style="width:70px"></td>
		
		 

		</tr>
		<tr>
		<td><select id="produit1" name="produit1" onchange="showUser1(this.value)"><?php echo $produit_list1; ?></select></td>
		<td align="center"><input type="text" id="quantite1" name="quantite1" style="width:160px" value="<?php echo $quantite1; ?>"></td>
		<td><div id="txtHint1"></div></td>		
		<td align="center"><input type="text" id="prix1" name="prix1" style="width:70px"></td>

		</tr>
		<tr>
		<td><select id="produit2" name="produit2" onchange="showUser2(this.value)"><?php echo $produit_list2; ?></select></td>
		<td align="center"><input type="text" id="quantite2" name="quantite2" style="width:160px" value="<?php echo $quantite2; ?>"></td>
		<td><div id="txtHint2"></div></td><td align="center"><input type="text" id="prix2" name="prix2" style="width:70px"></td>
		</tr>
		<tr>
		<td><select id="produit3" name="produit3" onchange="showUser3(this.value)"><?php echo $produit_list3; ?></select></td>
		<td align="center"><input type="text" id="quantite3" name="quantite3" style="width:160px" value="<?php echo $quantite3; ?>"></td>
		<td><div id="txtHint3"></div></td><td align="center"><input type="text" id="prix3" name="prix3" style="width:70px"></td>
		</tr>
		<tr>
		<td><select id="produit4" name="produit4" onchange="showUser4(this.value)"><?php echo $produit_list4; ?></select></td>
		<td align="center"><input type="text" id="quantite4" name="quantite4" style="width:160px" value="<?php echo $quantite4; ?>"></td>
		<td><div id="txtHint4"></div></td><td align="center"><input type="text" id="prix4" name="prix4" style="width:70px"></td>
		</tr>
		<tr>
		<td><select id="produit5" name="produit5" onchange="showUser5(this.value)"><?php echo $produit_list5; ?></select></td>
		<td align="center"><input type="text" id="quantite5" name="quantite5" style="width:160px" value="<?php echo $quantite5; ?>"></td>
		<td><div id="txtHint5"></div></td><td align="center"><input type="text" id="prix5" name="prix5" style="width:70px"></td></tr>
		<tr>
		<td><select id="produit6" name="produit6" onchange="showUser6(this.value)"><?php echo $produit_list6; ?></select></td>
		<td align="center"><input type="text" id="quantite6" name="quantite6" style="width:160px" value="<?php echo $quantite6; ?>"></td>
		<td><div id="txtHint6"></div></td><td align="center"><input type="text" id="prix6" name="prix6" style="width:70px"></td></tr>
		<tr>
		<td><select id="produit7" name="produit7" onchange="showUser7(this.value)"><?php echo $produit_list7; ?></select></td>
		<td align="center"><input type="text" id="quantite7" name="quantite7" style="width:160px" value="<?php echo $quantite7; ?>"></td>
		<td><div id="txtHint7"></div></td><td align="center"><input type="text" id="prix7" name="prix7" style="width:70px"></td></tr>
		<tr>
		<td><select id="produit8" name="produit8" onchange="showUser8(this.value)"><?php echo $produit_list8; ?></select></td>
		<td align="center"><input type="text" id="quantite8" name="quantite8" style="width:160px" value="<?php echo $quantite8; ?>"></td>
		<td><div id="txtHint8"></div></td><td align="center"><input type="text" id="prix8" name="prix8" style="width:70px"></td></tr>
		<tr>
		<td><select id="produit9" name="produit9" onchange="showUser9(this.value)"><?php echo $produit_list9; ?></select></td>
		<td align="center"><input type="text" id="quantite9" name="quantite9" style="width:160px" value="<?php echo $quantite9; ?>"></td>
		<td><div id="txtHint9"></div></td><td align="center"><input type="text" id="prix9" name="prix9" style="width:70px"></td></tr>
		<tr>
		<td><select id="produit10" name="produit10" onchange="showUser10(this.value)"><?php echo $produit_list10; ?></select></td>
		<td align="center"><input type="text" id="quantite10" name="quantite10" style="width:160px" value="<?php echo $quantite10; ?>"></td>
		<td><div id="txtHint10"></div></td><td align="center"><input type="text" id="prix10" name="prix10" style="width:70px"></td></tr>
		
		<tr>
		<td><select id="produit11" name="produit11" onchange="showUser11(this.value)"><?php echo $produit_list11; ?></select></td>
		<td align="center"><input type="text" id="quantite11" name="quantite11" style="width:160px" value="<?php echo $quantite11; ?>"></td>
		<td><div id="txtHint11"></div></td><td align="center"><input type="text" id="prix11" name="prix11" style="width:70px"></td></tr>
		<tr>
		<td><select id="produit12" name="produit12" onchange="showUser12(this.value)"><?php echo $produit_list12; ?></select></td>
		<td align="center"><input type="text" id="quantite12" name="quantite12" style="width:160px" value="<?php echo $quantite12; ?>"></td>
		<td><div id="txtHint12"></div></td><td align="center"><input type="text" id="prix12" name="prix12" style="width:70px"></td></tr>
		<tr>
		<td><select id="produit13" name="produit13" onchange="showUser13(this.value)"><?php echo $produit_list13; ?></select></td>
		<td align="center"><input type="text" id="quantite13" name="quantite13" style="width:160px" value="<?php echo $quantite13; ?>"></td>
		<td><div id="txtHint13"></div></td><td align="center"><input type="text" id="prix13" name="prix13" style="width:70px"></td></tr>
		<tr>
		<td><select id="produit14" name="produit14" onchange="showUser14(this.value)"><?php echo $produit_list14; ?></select></td>
		<td align="center"><input type="text" id="quantite14" name="quantite14" style="width:160px" value="<?php echo $quantite14; ?>"></td>
		<td><div id="txtHint14"></div></td><td align="center"><input type="text" id="prix14" name="prix14" style="width:70px"></td></tr>
		<tr>
		<td><select id="produit15" name="produit15" onchange="showUser15(this.value)"><?php echo $produit_list15; ?></select></td>
		<td align="center"><input type="text" id="quantite15" name="quantite15" style="width:160px" value="<?php echo $quantite15; ?>"></td>
		<td><div id="txtHint15"></div></td><td align="center"><input type="text" id="prix15" name="prix15" style="width:70px"></td></tr>
		<tr>
		<td><select id="produit16" name="produit16" onchange="showUser16(this.value)"><?php echo $produit_list16; ?></select></td>
		<td align="center"><input type="text" id="quantite16" name="quantite16" style="width:160px" value="<?php echo $quantite16; ?>"></td>
		<td><div id="txtHint16"></div></td><td align="center"><input type="text" id="prix16" name="prix16" style="width:70px"></td></tr>
		<tr>
		<td><select id="produit17" name="produit17" onchange="showUser17(this.value)"><?php echo $produit_list17; ?></select></td>
		<td align="center"><input type="text" id="quantite17" name="quantite17" style="width:160px" value="<?php echo $quantite17; ?>"></td>
		<td><div id="txtHint17"></div></td><td align="center"><input type="text" id="prix17" name="prix17" style="width:70px"></td></tr>
		<tr>
		<td><select id="produit18" name="produit18" onchange="showUser18(this.value)"><?php echo $produit_list18; ?></select></td>
		<td align="center"><input type="text" id="quantite18" name="quantite18" style="width:160px" value="<?php echo $quantite18; ?>"></td>
		<td><div id="txtHint18"></div></td><td align="center"><input type="text" id="prix18" name="prix18" style="width:70px"></td></tr>
		<tr>
		<td><select id="produit19" name="produit19" onchange="showUser19(this.value)"><?php echo $produit_list19; ?></select></td>
		<td align="center"><input type="text" id="quantite19" name="quantite19" style="width:160px" value="<?php echo $quantite19; ?>"></td>
		<td><div id="txtHint19"></div></td><td align="center"><input type="text" id="prix19" name="prix19" style="width:70px"></td></tr>
		<tr>
		<td><select id="produit20" name="produit20" onchange="showUser20(this.value)"><?php echo $produit_list20; ?></select></td>
		<td align="center"><input type="text" id="quantite20" name="quantite20" style="width:160px" value="<?php echo $quantite20; ?>"></td>
		<td><div id="txtHint20"></div></td><td align="center"><input type="text" id="prix20" name="prix20" style="width:70px"></td></tr>
		
		
		
		
		
		
	<? }?>	

	<? if($user_id <> "0") {?>
		<tr>
		<td><?php echo "produit : "; ?></td><td><select id="produit" name="produit" onchange="showUser21(this.value)"><?php echo $produit_list; ?></select></td>
		<td><div id="txtHint21"></div></td>
		</tr>
		<tr>
		<td><?php echo "Quantite"; ?></td><td align="center"><input type="text" id="quantite" name="quantite" style="width:160px" value="<?php echo $quantite; ?>"></td>
		</tr>
		<tr><td><?php echo "Paquet"; ?></td><td align="center"><input type="text" id="condit" name="condit" style="width:160px" value="<?php echo $condit; ?>"></td>
		</tr>
		<tr><td><?php echo "Prix Unit"; ?></td><td align="center"><input type="text" id="prix_unit" name="prix_unit" style="width:160px" value="<?php echo $prix_unit; ?>"></td>
		
		</tr>
		<tr><td><input type="checkbox" id="sans_remise" name="sans_remise"<?php if($sans_remise) { echo " checked"; } ?>></td><td>Article sans Remises</td>
		</tr>	
		<? }?>	

	</table>

<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">
<input type="hidden" id="numero" name="numero" value="<?php echo $numero; ?>">
<input type="hidden" id="client" name="client" value="<?php echo $client; ?>">
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