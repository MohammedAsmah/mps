<?php
set_time_limit(0);
	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();$datej=date("d/m/Y H:i:s");
	$user_name=GetUserName();
	$error_message = "";
	$type_service="SEJOURS ET CIRCUITS";
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$user_login = $user_["login"];
	
	?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">



</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>
	
	<form method="post" enctype="multipart/form-data" action="import_requete_commande.php">
	<table width="628" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#eeeeee">
    <? $date1="";$fin="";?>
	<tr>
      <td width="219"><font size=3><b>Selectionner votre fichier *.csv :</b></font></td>
      <td width="244" align="center"><input type="file" name="userfile" value="userfile"></td>
      <td><?php echo "Date : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	  
	  <td width="137" align="center">
        <input type="submit" value="Envoyer" name="envoyer">
      </td>
    </tr>
	</table>
	</form>
	</body>
	
</html>






