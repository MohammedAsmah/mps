<?php


	// Connects to database according the selected connection type
	function db_query($db_name, $sql) {

		global $db_connection_type, $db_server_address, $db_user, $db_password;	
	
		switch($db_connection_type) {
			
			case "odbc":
			$db_connection = odbc_connect($db_name, $db_user, $db_password);
			$result = odbc_exec($db_connection, $sql);
			break;

			/*case "mysql":
			$db_connection = mysql_pconnect($db_server_address, $db_user, $db_password);
			if (!$db_connection) {
   				die('Impossible de se connecter : ' . mysql_error());
				}	
			//*$result = mysql_query($db_name, $sql, $db_connection);
			// Rendre la base de données foo, la base courante
			mysql_select_db($db_name, $db_connection);
				if (!$result) {
   				die ('Impossible de sélectionner la base de données : ' . mysql_error());
				}*/

			case "mysql":
			// paramètres de connexion
			$hostname_smoby = "mysql5-1.business"; // nom de votre serveur
			$database_smoby = "datamjpmps"; // nom de votre base de données
			$username_smoby = "datamjpmps"; // nom d'utilisateur (root par défaut) !!! 
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
