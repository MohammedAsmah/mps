<?php

?>

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
	<script type="text/javascript" src="/AJAX/ajax.js"></script>
	<script type="text/javascript">
	/************************************************************************************************************
	Ajax client lookup
	Copyright (C) 2006  DTHMLGoodies.com, Alf Magne Kalleland
	
	This library is free software; you can redistribute it and/or
	modify it under the terms of the GNU Lesser General Public
	License as published by the Free Software Foundation; either
	version 2.1 of the License, or (at your option) any later version.
	
	This library is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
	Lesser General Public License for more details.
	
	You should have received a copy of the GNU Lesser General Public
	License along with this library; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
	
	Dhtmlgoodies.com., hereby disclaims all copyright interest in this script
	written by Alf Magne Kalleland.
	
	Alf Magne Kalleland, 2006
	Owner of DHTMLgoodies.com
	
	
	************************************************************************************************************/	
	var ajax = new sack();
	var currentClientID=false;
	function getClientData()
	{
		var clientId = document.getElementById('clientID').value.replace(/[^0-9]/g,'');
		if(clientId.length==4 && clientId!=currentClientID){
			currentClientID = clientId
			ajax.requestFile = 'getClient.php?getClientId='+clientId;	// Specifying which file to get
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

--></script>

</head>

<body style="background:#dfe8ff">



<form name="clientForm" action="client_search.php" method="post">	
	<fieldset>
		<legend>Client information</legend>
		<table>
			<tr>
				<td><label for="clientID">Client ID:</label></td>
				<td><input name="clientID" id="clientID" size="5" maxlength="4"></td>
			</tr>
			<tr>
				<td><label for="firstname">First name:</label></td>
				<td><input name="firstname" id="firstname" size="20" maxlength="255"></td>
			</tr>
			<tr>
				<td><label for="lastname">Last name:</label></td>
				<td><input name="lastname" id="lastname" size="20" maxlength="255"></td>
			</tr>
			<tr>
				<td><label for="address">Address:</label></td>
				<td><input name="address" id="address" size="20" maxlength="255"></td>
			</tr>
			<tr>
				<td><label for="zipCode">Zipcode:</label></td>
				<td><input name="zipCode" id="zipCode" size="4" maxlength="5"></td>
			</tr>
			<tr>
				<td><label for="city">City:</label></td>
				<td><input name="city" id="city" size="20" maxlength="255"></td>
			</tr>
			<tr>
				<td><label for="country">Country:</label></td>
				<td><input name="country" id="country" size="20" maxlength="255"></td>
			</tr>
		</table>	
	</form>
	<p>In this script, AJAX is used to autofill the form fields after a valid client ID is entered. Valid client IDs in this example are 1001,1002,1003 and 1004.</p>
	</fieldset>

</center>

</form>

</body>

</html>