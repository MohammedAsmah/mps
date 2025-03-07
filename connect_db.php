<?php


	// Connects to database according the selected connection type
	function db_query($db_name, $sql) {

		global $db_connection_type, $db_server_address, $db_user, $db_password;	
	
		switch($db_connection_type) {
			
			case "odbc":
			$db_connection = odbc_connect($db_name, $db_user, $db_password);
			$result = odbc_exec($db_connection, $sql);
			break;

			case "mysql":

			$hostname_smoby = "datamjpmps.mysql.db"; // nom de votre serveur
			$database_smoby = "datamjpmps"; // nom de votre base de données
			$username_smoby = "datamjpmps"; // nom d'utilisateur (root par défaut) !!! 
			$password_smoby = "Marwane06"; // mot de passe (aucun par défaut mais il est conseillé d'en mettre un)
					
			$db = mysql_pconnect($hostname_smoby, $username_smoby, $password_smoby) or trigger_error(mysql_error(),E_USER_ERROR); 
			mysql_select_db($database_smoby,$db);
			$result= mysql_query($sql);
			
			}

		return $result;
	}

	function db_query_jp($db_name, $sql) {

		global $db_connection_type, $db_server_address, $db_user, $db_password;	
	
		switch($db_connection_type) {
			
			case "odbc":
			$db_connection = odbc_connect($db_name, $db_user, $db_password);
			$result = odbc_exec($db_connection, $sql);
			break;

			case "mysql":

			$hostname_smoby = "datamjpjaouda.mysql.db"; // nom de votre serveur
			$database_smoby = "datamjpjaouda"; // nom de votre base de données
			$username_smoby = "datamjpjaouda"; // nom d'utilisateur (root par défaut) !!! 
			$password_smoby = "Marwane06"; // mot de passe (aucun par défaut mais il est conseillé d'en mettre un)
					
			$db = mysql_pconnect($hostname_smoby, $username_smoby, $password_smoby) or trigger_error(mysql_error(),E_USER_ERROR); 
			mysql_select_db($database_smoby,$db);
			$result= mysql_query($sql);
			
			}

		return $result;
	}
	
	
	function fetch_array($array) {
	
		global $db_connection_type;

		switch($db_connection_type) {

			case "odbc":
			$result = odbc_fetch_array($array);
			break;

			case "mysql":
			$result = mysql_fetch_array($array);
		}
		
		return $result;
	}
?>
