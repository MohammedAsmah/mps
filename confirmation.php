<?php

include('config_up.php');
require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	$date_time=date("y-m-d h:m:s");$date_confirmation=date("y-m-d h:m:s");
// Passkey that got from link
			
			$passkey=$_GET['passkey'];$confirme=1;$statut="commande encours";

			$sql = "UPDATE detail_bon_besoin SET ";
			$sql .= "date_confirmation = '" . $date_confirmation . "', ";
			$sql .= "confirme = '" . $confirme . "', ";
			$sql .= "statut = '" . $statut . "' ";
			$sql .= "WHERE confirm_code = '" . $passkey . "';";
			db_query($database_name, $sql);


echo "BON OK POUR COMMANDE";



?>