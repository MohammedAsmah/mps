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
xmlhttp.open("GET","getuser.php?q="+str,true);
xmlhttp.send();
}
</script>
</head>
<body>
<?
require "config.php";
	require "connect_db.php";
	require "functions.php";

	$client_list = "";
	$sql = "SELECT * FROM  clients ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$client_list .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$client_list .= $temp_["client"];
		$client_list .= "</OPTION>";
	}
?>
<form>
<select onkeydown="return liDown(this);" id="users" name="users" onchange="showUser(this.value)"><?php echo $client_list; ?></select>
</form>
<br />
<div id="txtHint"><b>Person info will be listed here.</b></div>

</body>
</html> 
