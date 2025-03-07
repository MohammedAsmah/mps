<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_name=GetUserName();
	$user_id = $_REQUEST["user_id"];
	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "";

		$lp = "";
		$date=dateUsToFr($_GET["date"]);
		$type_service = "SEJOURS ET CIRCUITS";
		$service = "";
		$banque =$_GET["banque"];
		$statut = "";$locked = 0;
		$user_open = $user_name;
		$date_open = "";
		$observation="";
		$motif_cancel="";
		$libelle1="";$montant1=0;$libelle2="";$montant2=0;$libelle3="";$montant3=0;$libelle4="";$montant4=0;$libelle5="";$montant5=0;
		$libelle6="";$montant6=0;$libelle7="";$montant7=0;$libelle8="";$montant8=0;
		$objet1="";$cheque1=0;$objet2="";$cheque2=0;$objet3="";$cheque3=0;$objet4="";$cheque4=0;$objet5="";$cheque5=0;
		$objet6="";$cheque6=0;$objet7="";$cheque7=0;$objet8="";$cheque8=0;$objet9="";$cheque9=0;$objet10="";$cheque10=0;
		$date_cheque1="";$ref1="";$date_cheque2="";$ref2="";$date_cheque3="";$ref3="";$date_cheque4="";$ref4="";$date_cheque5="";$ref5="";
		$date_cheque6="";$ref6="";$date_cheque7="";$ref7="";$date_cheque8="";$ref8="";$date_cheque9="";$ref9="";$date_cheque10="";$ref10="";
	} else {

		$action_ = "update_user";
		$action1_ = "update_detail";
	
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM registre_remises WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		$title = "";
		$r_impaye1=$user_["r_impaye1"];$r_impaye2=$user_["r_impaye2"];$r_impaye3=$user_["r_impaye3"];$r_impaye4=$user_["r_impaye4"];
		$d_impaye1=dateUsToFr($user_["d_impaye1"]);$d_impaye2=dateUsToFr($user_["d_impaye2"]);$d_impaye3=dateUsToFr($user_["d_impaye3"]);
		$d_impaye4=dateUsToFr($user_["d_impaye4"]);$remise_vers_tresorerie=$user_["remise_vers_tresorerie"];$remise_vers_tresorerie1=$user_["remise_vers_tresorerie1"];
		
		
		
		$date=dateUsToFr($user_["date"]);
		$service = $user_["service"];
		$banque = $user_["banque"];
		$statut = $user_["statut"];
		$user_open = $user_["user_open"];
		$date_open = $user_["date_open"];
		$observation=$user_["observation"];
		$type_service="SEJOURS ET CIRCUITS";
		$motif_cancel=$user_["motif_cancel"];$id=$_REQUEST["user_id"];
		$libelle1=$user_["libelle1"];$montant1=$user_["montant1"];
		$libelle2=$user_["libelle2"];$montant2=$user_["montant2"];
		$libelle3=$user_["libelle3"];$montant3=$user_["montant3"];
		$libelle4=$user_["libelle4"];$montant4=$user_["montant4"];
		$libelle5=$user_["libelle5"];$montant5=$user_["montant5"];
		$libelle6=$user_["libelle6"];$montant6=$user_["montant6"];
		$libelle7=$user_["libelle7"];$montant7=$user_["montant7"];
		$libelle8=$user_["libelle8"];$montant8=$user_["montant8"];
		$objet1=$user_["objet1"];$cheque1=$user_["cheque1"];
		$objet2=$user_["objet2"];$cheque2=$user_["cheque2"];
		$objet3=$user_["objet3"];$cheque3=$user_["cheque3"];
		$objet4=$user_["objet4"];$cheque4=$user_["cheque4"];
		$objet5=$user_["objet5"];$cheque5=$user_["cheque5"];
		$objet6=$user_["objet6"];$cheque6=$user_["cheque6"];
		$objet7=$user_["objet7"];$cheque7=$user_["cheque7"];
		$objet8=$user_["objet8"];$cheque8=$user_["cheque8"];
		$objet9=$user_["objet9"];$cheque9=$user_["cheque9"];
		$objet10=$user_["objet10"];$cheque10=$user_["cheque10"];
		$date_cheque1=dateUsToFr($user_["date_cheque1"]);$ref1=$user_["ref1"];
		$date_cheque2=dateUsToFr($user_["date_cheque2"]);$ref2=$user_["ref2"];
		$date_cheque3=dateUsToFr($user_["date_cheque3"]);$ref3=$user_["ref3"];
		$date_cheque4=dateUsToFr($user_["date_cheque4"]);$ref4=$user_["ref4"];
		$date_cheque5=dateUsToFr($user_["date_cheque5"]);$ref5=$user_["ref5"];
		$date_cheque6=dateUsToFr($user_["date_cheque6"]);$ref6=$user_["ref6"];
		$date_cheque7=dateUsToFr($user_["date_cheque7"]);$ref7=$user_["ref7"];
		$date_cheque8=dateUsToFr($user_["date_cheque8"]);$ref8=$user_["ref8"];
		$date_cheque9=dateUsToFr($user_["date_cheque9"]);$ref9=$user_["ref9"];
		$date_cheque10=dateUsToFr($user_["date_cheque10"]);$ref10=$user_["ref10"];
	}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . $title; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
			UpdateUser();
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "registres_remises_tresorerie.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">

<?		
	$banque_list = "";
	$sql = "SELECT * FROM  rs_data_banques ORDER BY banque;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($banque == $temp_["banque"]) { $selected = " selected"; } else { $selected = ""; }
		
		$banque_list .= "<OPTION VALUE=\"" . $temp_["banque"] . "\"" . $selected . ">";
		$banque_list .= $temp_["banque"];
		$banque_list .= "</OPTION>";
	}
	
?>

<form id="form_user" name="form_user" method="post" action="registres_remises_tresorerie.php">

<table class="table2">

		<tr>
		<td><?php echo "Date	:"; ?></td><td><input type="text" id="date" name="date" value="<?php echo $date; ?>"></td>
		</tr>
		<td>
		<?php echo "Banque		:"; ?></td><td>
		<select id="banque" name="banque"><?php echo $banque_list; ?></select></td>
		<tr><? //if($user_id == "0") {?>
		<td><input type="checkbox" id="remise_vers_tresorerie" name="remise_vers_tresorerie"<?php if($remise_vers_tresorerie) { echo " checked"; } ?>></td><td>
		<?php echo "Valider Remise cheques vers Tresorerie"; ?></td>
		</tr><? //} ?>
		<tr><? //if($user_id == "0") {?>
		<td><input type="checkbox" id="remise_vers_tresorerie1" name="remise_vers_tresorerie1"<?php if($remise_vers_tresorerie1) { echo " checked"; } ?>></td><td>
		<?php echo "Valider Remise effets vers Tresorerie"; ?></td>
		</tr><? //} ?>
	</table>
	

<center>
<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="user_open" name="user_open" value="<?php echo $user_open; ?>">
<input type="hidden" id="date_open" name="date_open" value="<?php echo $date_open; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">

  <table class="table3"><tr>

<?php if($user_id != "0") { ?>
<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td style="width:20px"></td>
<?php } else { ?>
<td><button type="button"  onClick="CheckUser()"><?php echo Translate("OK"); ?></button></td>
<?php 
} ?>
</tr></table>
</center>

</form>

</body>

</html>