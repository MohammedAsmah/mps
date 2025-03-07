<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>


<style type="text/css">
	body{
		background-repeat:no-repeat;
		font-family: Trebuchet MS, Lucida Sans Unicode, Arial, sans-serif;
		height:100%;
		background-color: #FFF;
		margin:0px;
		padding:0px;
		background-image:url('/images/heading3.gif');
		background-repeat:no-repeat;
		padding-top:85px;
	}
	
	fieldset{
		width:500px;
		margin-left:10px;
	}

	</style>
	<script type="text/javascript" src="ajax.js"></script>
	<script type="text/javascript">

	var ajax = new sack();
	var currentClientID=false;
	function getClientData()
	{
		var clientId = document.getElementById('clientID').value.replace(/[^0-9]/g,'');
		if(clientId.length==4 && clientId!=currentClientID){
			currentClientID = clientId
			ajax.requestFile = 'getProduit.php?getClientId='+clientId;	// Specifying which file to get
			ajax.onCompletion = showClientData;	// Specify function that will be executed after file has been found
			ajax.runAJAX();		// Execute AJAX function			
		}
		
	}
	
	function showClientData()
	{
		var formObj = document.forms['clientForm'];	
		eval(ajax.response);
	}
	
	
	function initFormEvents()
	{
		document.getElementById('clientID').onblur = getClientData;
		document.getElementById('clientID').focus();
	}
	
	
	window.onload = initFormEvents;
	</script>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>

<body style="background:#dfe8ff">
<? 		
	require "config.php";
	require "connect_db.php";
	
	$produit_list = "";
	$sql = "SELECT * FROM  produits where dispo=1 ORDER BY produit;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($produit == $temp_["produit"]) { $selected = " selected"; } else { $selected = ""; }
		
		$produit_list .= "<OPTION VALUE=\"" . $temp_["produit"] . "\"" . $selected . ">";
		$produit_list .= $temp_["produit"];
		$produit_list .= "</OPTION>";
	}
?>

<form name="clientForm" action="ajax-client_lookup.php" method="post">	
	<fieldset>
		<legend>Client information</legend>
		<table>
			<tr><td><label for="clientID">Produit:</label></td>
		<td><select id="clientID" name="clientID"><?php echo $produit_list; ?></select></td>
		<td align="center"><input type="text" id="quantite10" name="quantite10" style="width:160px" value="<?php echo $quantite10; ?>"></td>
		</tr>
			
			<tr>
				<td><label for="firstname">Condit</label></td>
				<td><input name="condit" id="condit" size="20" maxlength="255"></td>
			</tr>
			<tr>
				<td><label for="lastname">Prix unit</label></td>
				<td><input name="prix" id="prix" size="20" maxlength="255"></td>
			</tr>
			
		</table>	
	</form>
	</fieldset>

</form>

</body>

</html>