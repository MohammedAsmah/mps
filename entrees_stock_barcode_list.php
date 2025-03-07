<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) ) { 

		if($_REQUEST["action_"] != "delete_user" and $_REQUEST["action_"] != "import") {
			// prepares data to simplify database insert or update
			$produit = $_REQUEST["produit"];$depot_a=$_REQUEST["depot_a"];$depot_c=0;$depot_b=0;
			
			$date = dateFrToUs($_REQUEST["date"]);$date1 = $_REQUEST["date"];$type="production";
	if($_REQUEST["action_"] == "insert_new_user") {	
	
		$produit1 = $_REQUEST["produit1"];$depot_a1=$_REQUEST["depot_a1"];$produit2 = $_REQUEST["produit2"];$depot_a2=$_REQUEST["depot_a2"];
		$produit3 = $_REQUEST["produit3"];$depot_a3=$_REQUEST["depot_a3"];$produit7 = $_REQUEST["produit7"];$depot_a7=$_REQUEST["depot_a7"];
		$produit4 = $_REQUEST["produit4"];$depot_a4=$_REQUEST["depot_a4"];$produit5 = $_REQUEST["produit5"];$depot_a5=$_REQUEST["depot_a5"];
		$produit6 = $_REQUEST["produit6"];$depot_a6=$_REQUEST["depot_a6"];$produit8 = $_REQUEST["produit8"];$depot_a8=$_REQUEST["depot_a8"];
		$produit9 = $_REQUEST["produit9"];$depot_a9=$_REQUEST["depot_a9"]; 
		}
		
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		if($produit <> "") {
	
				$sql  = "INSERT INTO entrees_stock ( produit, date,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $produit . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $depot_a . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			//accessoires
				$id_p=mysql_insert_id();
				$accessoire_1 = "";$accessoire_2 = "";$accessoire_3 = "";$accessoire_4 = "";$accessoire_5 = "";$accessoire_6 = "";
					//accessoires
			$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";
		$userp = db_query($database_name, $sql);
		$user_a = fetch_array($userp);$condit = $user_a["condit"];$id_produit = $user_a["id"];
		
		
		$sql  = "SELECT * ";
		$sql .= "FROM fiches_techniques WHERE id_produit = '$id_produit' ;";
		$userfp = db_query($database_name, $sql);
		while($users1_fp = fetch_array($userfp))
		{
			$emb_separe = $users1_fp["emb_separe"];
			$accessoire_1 = $users1_fp["accessoire"];
			$qte_ac_1 = $users1_fp["qte"]*$depot_a*$condit*-1;
			if ($emb_separe==0){
				$sql  = "INSERT INTO entrees_stock_acc ( id_p,produit, date,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $id_p . "', ";
				$sql .= "'" . $accessoire_1 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $qte_ac_1 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
			
		}
					
				
				
				
			}
		if($produit1 <> "") {		
				$sql  = "INSERT INTO entrees_stock ( produit, date,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $produit1 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $depot_a1 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
				$accessoire_1 = "";$accessoire_2 = "";$accessoire_3 = "";$accessoire_4 = "";$accessoire_5 = "";$accessoire_6 = "";
					//accessoires
				$id_p=mysql_insert_id();
				
					//accessoires
			$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit1' ;";
		$userp = db_query($database_name, $sql);
		$user_a = fetch_array($userp);$condit = $user_a["condit"];$id_produit = $user_a["id"];
		
		
		$sql  = "SELECT * ";
		$sql .= "FROM fiches_techniques WHERE id_produit = '$id_produit' ;";
		$userfp = db_query($database_name, $sql);
		while($users1_fp = fetch_array($userfp))
		{
			$emb_separe = $users1_fp["emb_separe"];
			$accessoire_1 = $users1_fp["accessoire"];
			$qte_ac_1 = $users1_fp["qte"]*$depot_a1*$condit*-1;
			if ($emb_separe==0){
				$sql  = "INSERT INTO entrees_stock_acc ( id_p,produit, date,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $id_p . "', ";
				$sql .= "'" . $accessoire_1 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $qte_ac_1 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
			
		}
					
				
			}
		if($produit2 <> "") {		
				$sql  = "INSERT INTO entrees_stock ( produit, date,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $produit2 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $depot_a2 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
					//accessoires
					$accessoire_1 = "";$accessoire_2 = "";$accessoire_3 = "";$accessoire_4 = "";$accessoire_5 = "";$accessoire_6 = "";
				$id_p=mysql_insert_id();
				
					//accessoires
			$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit2' ;";
		$userp = db_query($database_name, $sql);
		$user_a = fetch_array($userp);$condit = $user_a["condit"];$id_produit = $user_a["id"];
		
		
		$sql  = "SELECT * ";
		$sql .= "FROM fiches_techniques WHERE id_produit = '$id_produit' ;";
		$userfp = db_query($database_name, $sql);
		while($users1_fp = fetch_array($userfp))
		{
			$emb_separe = $users1_fp["emb_separe"];
			$accessoire_1 = $users1_fp["accessoire"];
			$qte_ac_1 = $users1_fp["qte"]*$depot_a2*$condit*-1;
			if ($emb_separe==0){
				$sql  = "INSERT INTO entrees_stock_acc ( id_p,produit, date,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $id_p . "', ";
				$sql .= "'" . $accessoire_1 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $qte_ac_1 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
			
		}
					
				
			}
		if($_REQUEST["produit3"] != "") {	
				$sql  = "INSERT INTO entrees_stock ( produit, date,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $produit3 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $depot_a3 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
					//accessoires
					$accessoire_1 = "";$accessoire_2 = "";$accessoire_3 = "";$accessoire_4 = "";$accessoire_5 = "";$accessoire_6 = "";
				$id_p=mysql_insert_id();
				
					//accessoires
			$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit3' ;";
		$userp = db_query($database_name, $sql);
		$user_a = fetch_array($userp);$condit = $user_a["condit"];$id_produit = $user_a["id"];
		
		
		$sql  = "SELECT * ";
		$sql .= "FROM fiches_techniques WHERE id_produit = '$id_produit' ;";
		$userfp = db_query($database_name, $sql);
		while($users1_fp = fetch_array($userfp))
		{
			$emb_separe = $users1_fp["emb_separe"];
			$accessoire_1 = $users1_fp["accessoire"];
			$qte_ac_1 = $users1_fp["qte"]*$depot_a3*$condit*-1;
			if ($emb_separe==0){
				$sql  = "INSERT INTO entrees_stock_acc ( id_p,produit, date,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $id_p . "', ";
				$sql .= "'" . $accessoire_1 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $qte_ac_1 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
			
		}
					
				
				
			}
		if($_REQUEST["produit4"] != "") {	
				$sql  = "INSERT INTO entrees_stock ( produit, date,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $produit4 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $depot_a4 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
					//accessoires
					$accessoire_1 = "";$accessoire_2 = "";$accessoire_3 = "";$accessoire_4 = "";$accessoire_5 = "";$accessoire_6 = "";
				$id_p=mysql_insert_id();
				
					//accessoires
			$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit4' ;";
		$userp = db_query($database_name, $sql);
		$user_a = fetch_array($userp);$condit = $user_a["condit"];$id_produit = $user_a["id"];
		
		
		$sql  = "SELECT * ";
		$sql .= "FROM fiches_techniques WHERE id_produit = '$id_produit' ;";
		$userfp = db_query($database_name, $sql);
		while($users1_fp = fetch_array($userfp))
		{
			$emb_separe = $users1_fp["emb_separe"];
			$accessoire_1 = $users1_fp["accessoire"];
			$qte_ac_1 = $users1_fp["qte"]*$depot_a4*$condit*-1;
			if ($emb_separe==0){
				$sql  = "INSERT INTO entrees_stock_acc ( id_p,produit, date,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $id_p . "', ";
				$sql .= "'" . $accessoire_1 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $qte_ac_1 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
			
		}
					
				
				
			}
		if($_REQUEST["produit5"] != "") {	
				$sql  = "INSERT INTO entrees_stock ( produit, date,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $produit5 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $depot_a5 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
					//accessoires
					$accessoire_1 = "";$accessoire_2 = "";$accessoire_3 = "";$accessoire_4 = "";$accessoire_5 = "";$accessoire_6 = "";
				$id_p=mysql_insert_id();
				
					//accessoires
			$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit5' ;";
		$userp = db_query($database_name, $sql);
		$user_a = fetch_array($userp);$condit = $user_a["condit"];$id_produit = $user_a["id"];
		
		
		$sql  = "SELECT * ";
		$sql .= "FROM fiches_techniques WHERE id_produit = '$id_produit' ;";
		$userfp = db_query($database_name, $sql);
		while($users1_fp = fetch_array($userfp))
		{
			$emb_separe = $users1_fp["emb_separe"];
			$accessoire_1 = $users1_fp["accessoire"];
			$qte_ac_1 = $users1_fp["qte"]*$depot_a5*$condit*-1;
			if ($emb_separe==0){
				$sql  = "INSERT INTO entrees_stock_acc ( id_p,produit, date,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $id_p . "', ";
				$sql .= "'" . $accessoire_1 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $qte_ac_1 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
			
		}
					
				
				
			}
		if($_REQUEST["produit6"] != "") {	
				$sql  = "INSERT INTO entrees_stock ( produit, date,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $produit6 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $depot_a6 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
					//accessoires
					$accessoire_1 = "";$accessoire_2 = "";$accessoire_3 = "";$accessoire_4 = "";$accessoire_5 = "";$accessoire_6 = "";
				$id_p=mysql_insert_id();
				
					//accessoires
			$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit6' ;";
		$userp = db_query($database_name, $sql);
		$user_a = fetch_array($userp);$condit = $user_a["condit"];$id_produit = $user_a["id"];
		
		
		$sql  = "SELECT * ";
		$sql .= "FROM fiches_techniques WHERE id_produit = '$id_produit' ;";
		$userfp = db_query($database_name, $sql);
		while($users1_fp = fetch_array($userfp))
		{
			$emb_separe = $users1_fp["emb_separe"];
			$accessoire_1 = $users1_fp["accessoire"];
			$qte_ac_1 = $users1_fp["qte"]*$depot_a6*$condit*-1;
			if ($emb_separe==0){
				$sql  = "INSERT INTO entrees_stock_acc ( id_p,produit, date,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $id_p . "', ";
				$sql .= "'" . $accessoire_1 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $qte_ac_1 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
			
		}
					
				
			}
		if($_REQUEST["produit7"] != "") {	
				$sql  = "INSERT INTO entrees_stock ( produit, date,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $produit7 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $depot_a7 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
					//accessoires
					$accessoire_1 = "";$accessoire_2 = "";$accessoire_3 = "";$accessoire_4 = "";$accessoire_5 = "";$accessoire_6 = "";
				$id_p=mysql_insert_id();
				
					//accessoires
			$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit7' ;";
		$userp = db_query($database_name, $sql);
		$user_a = fetch_array($userp);$condit = $user_a["condit"];$id_produit = $user_a["id"];
		
		
		$sql  = "SELECT * ";
		$sql .= "FROM fiches_techniques WHERE id_produit = '$id_produit' ;";
		$userfp = db_query($database_name, $sql);
		while($users1_fp = fetch_array($userfp))
		{
			$emb_separe = $users1_fp["emb_separe"];
			$accessoire_1 = $users1_fp["accessoire"];
			$qte_ac_1 = $users1_fp["qte"]*$depot_a7*$condit*-1;
			if ($emb_separe==0){
				$sql  = "INSERT INTO entrees_stock_acc ( id_p,produit, date,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $id_p . "', ";
				$sql .= "'" . $accessoire_1 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $qte_ac_1 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
			
		}
					
				
				
			}
		if($_REQUEST["produit8"] != "") {	
				$sql  = "INSERT INTO entrees_stock ( produit, date,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $produit8 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $depot_a8 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
					//accessoires
					$accessoire_1 = "";$accessoire_2 = "";$accessoire_3 = "";$accessoire_4 = "";$accessoire_5 = "";$accessoire_6 = "";
				$id_p=mysql_insert_id();
				
					//accessoires
			$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit8' ;";
		$userp = db_query($database_name, $sql);
		$user_a = fetch_array($userp);$condit = $user_a["condit"];$id_produit = $user_a["id"];
		
		
		$sql  = "SELECT * ";
		$sql .= "FROM fiches_techniques WHERE id_produit = '$id_produit' ;";
		$userfp = db_query($database_name, $sql);
		while($users1_fp = fetch_array($userfp))
		{
			$emb_separe = $users1_fp["emb_separe"];
			$accessoire_1 = $users1_fp["accessoire"];
			$qte_ac_1 = $users1_fp["qte"]*$depot_a8*$condit*-1;
			if ($emb_separe==0){
				$sql  = "INSERT INTO entrees_stock_acc ( id_p,produit, date,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $id_p . "', ";
				$sql .= "'" . $accessoire_1 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $qte_ac_1 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
			
		}
					
				
				
			}
		if($_REQUEST["produit9"] != "") {	
				$sql  = "INSERT INTO entrees_stock ( produit, date,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $produit9 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $depot_a9 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
				$id_p=mysql_insert_id();
				
					//accessoires
					$accessoire_1 = "";$accessoire_2 = "";$accessoire_3 = "";$accessoire_4 = "";$accessoire_5 = "";$accessoire_6 = "";
			$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit9' ;";
		$userp = db_query($database_name, $sql);
		$user_a = fetch_array($userp);$condit = $user_a["condit"];$id_produit = $user_a["id"];
		
		
		$sql  = "SELECT * ";
		$sql .= "FROM fiches_techniques WHERE id_produit = '$id_produit' ;";
		$userfp = db_query($database_name, $sql);
		while($users1_fp = fetch_array($userfp))
		{
			$emb_separe = $users1_fp["emb_separe"];
			$accessoire_1 = $users1_fp["accessoire"];
			$qte_ac_1 = $users1_fp["qte"]*$depot_a9*$condit*-1;
			if ($emb_separe==0){
				$sql  = "INSERT INTO entrees_stock_acc ( id_p,produit, date,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $id_p . "', ";
				$sql .= "'" . $accessoire_1 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $qte_ac_1 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
			
		}
					
				
			}
			
			$vide="";
				$sql = "DELETE FROM entrees_stock WHERE produit = '" . $vide . "';";
				db_query($database_name, $sql);
				
			break;

			case "update_user":
			$accessoire_1 = "";$accessoire_2 = "";$accessoire_3 = "";$accessoire_4 = "";$accessoire_5 = "";$accessoire_6 = "";
			$marron=$_REQUEST["marron"];$beige=$_REQUEST["beige"];$gris=$_REQUEST["gris"];$marron_b=$_REQUEST["marron_b"];$beige_b=$_REQUEST["beige_b"];$gris_b=$_REQUEST["gris_b"];
			$sql = "UPDATE entrees_stock SET ";
			$sql .= "produit = '" . $_REQUEST["produit"] . "', ";
			$sql .= "depot_a = '" . $_REQUEST["depot_a"] . "', ";
			$sql .= "marron = '" . $_REQUEST["marron"] . "', ";
			$sql .= "beige = '" . $_REQUEST["beige"] . "', ";
			$sql .= "gris = '" . $_REQUEST["gris"] . "', ";
			$sql .= "marron_b = '" . $_REQUEST["marron_b"] . "', ";
			$sql .= "beige_b = '" . $_REQUEST["beige_b"] . "', ";
			$sql .= "gris_b = '" . $_REQUEST["gris_b"] . "', ";
			$sql .= "date = '" . $date . "' ";
			$sql .= "WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			$sql = "DELETE FROM entrees_stock_acc WHERE id_p = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
						//accessoires
			$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit = '$produit' ;";$id_p=$_REQUEST["user_id"];
		$userp = db_query($database_name, $sql);
		$user_a = fetch_array($userp);$condit = $user_a["condit"];$id_produit = $user_a["id"];
		
		
		$sql  = "SELECT * ";
		$sql .= "FROM fiches_techniques WHERE id_produit = '$id_produit' ;";
		$userfp = db_query($database_name, $sql);
		while($users1_fp = fetch_array($userfp))
		{
			$emb_separe = $users1_fp["emb_separe"];
			$accessoire_1 = $users1_fp["accessoire"];
			$qte_ac_1 = $users1_fp["qte"]*$depot_a*$condit*-1;
			if ($emb_separe==0){
				$sql  = "INSERT INTO entrees_stock_acc ( id_p,produit, date,depot_a,type,depot_b ) VALUES ( ";
				$sql .= "'" . $id_p . "', ";
				$sql .= "'" . $accessoire_1 . "', ";
				$sql .= "'" . $date . "', ";
				$sql .= "'" . $qte_ac_1 . "', ";
				$sql .= "'" . $type . "', ";
				$sql .= $depot_b . ");";db_query($database_name, $sql);
			}
			
		}		
			
			
			
			
			break;
			
			case "delete_user":
			
			// delete user's profile
			$sql = "DELETE FROM entrees_stock WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			$sql = "DELETE FROM entrees_stock_acc WHERE id_p = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			
			break;

			case "import":

			echo "importation en cours";
			break;


		}

	$vide="";
				$sql = "DELETE FROM entrees_stock WHERE produit = '" . $vide . "';";
				db_query($database_name, $sql);
		//switch
	} //if
	
	
	// recherche ville
	?>
	
	<?
	
		$action="Recherche";
			if(isset($_REQUEST["action"]) or isset($_REQUEST["action_"])){}else{
	?>
	<form id="form" name="form" method="post" action="entrees_stock.php">
	<table><td><?php echo "Date: "; ?><input onClick="ds_sh(this);" name="date" readonly="readonly" style="cursor: text" />
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td></td></table>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]) or isset($_REQUEST["action_"])){

	$sql  = "SELECT * ";$type="production";$date=dateFrToUs($_POST['date']);
	$sql .= "FROM entrees_stock where date='$date' and type='$type' ORDER BY date;";
	$users = db_query($database_name, $sql);}
	else
	{	$sql  = "SELECT date,produit,sum(depot_a+depot_b) As depot_a ";$type="production";$dj=date("Y-m-d");
	$sql .= "FROM entrees_stock where type='$type' and date='$dj' group by produit ORDER BY date;";
	$users = db_query($database_name, $sql);}

	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "ENTREE PRODUCTION"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "entree_stock.php?user_id=" + user_id; }
--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "ENTREE PRODUCTION"; ?></span>


<table class="table2">

<tr>
	<th><?php echo "DATE";?></th>
	<th><?php echo "Article : "; ?></th>
	<th><?php echo "Quantite"; ?></th>
	
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<? $user_id=$users_["id"];$date1=dateUsToFr($users_["date"]);echo "<tr><td><a href=\"entree_stock.php?user_id=$user_id&date=$date1\">$date1</a></td>";
/*
<td><a href="JavaScript:EditUser(<?php $user_id=$users_["id"]; ?>)"><?php $datefr=dateUsToFr($users_["date"]);?></A></td>*/?>

<?  $produit=$users_["produit"];$sql  = "SELECT * ";
		$sql .= "FROM produits WHERE produit='$produit' Order BY produit;";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);
		$couleurs=$user_["couleurs"];

?>
<td><?php echo $users_["produit"]; ?></td>
<td style="text-align:left"><?php echo $users_["depot_a"]; ?></td>

<?php } ?>

</table>

<p style="text-align:center">
<table><tr><td>
<? if ($date=="--" or $date==""){}else{echo "<a href=\"entree_stock.php?date=$date&user_id=0\">Ajout Production</a></td>";}?></tr><tr>
<td><? /*echo "<a href=\"entree_stock.php?date=$date&user_id=20000000\">Importation Production</a></td>";*/?></tr>
</table>
</body>

</html>