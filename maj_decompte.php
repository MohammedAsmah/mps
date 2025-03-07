<?php


	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php

	$user_id = $_REQUEST["user_id"];

	if($user_id == "0") {

		$action_ = "insert_new_user";

		$title = "Nouveau Client";

		$ref = "";$service="";
		$employe = "";$bulletin=0;$poste="";
		$t_h_100="";$t_h_normales="";$t_h_25="";$t_h_50="";$manual=0;
		
	} else {

		$action_ = "update_user";
		
		// gets user infos
		$sql  = "SELECT * ";
		$sql .= "FROM employes WHERE id = " . $_REQUEST["user_id"] . ";";
		$user = db_query($database_name, $sql); $user_ = fetch_array($user);

		
		$bulletin = $user_["bulletin"];$employe = $user_["employe"];
		

		
		
		}
	

	// extracts profile list
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
		if(document.getElementById("employe").value == 0 ) {
			
			UpdateUser();
		} else {
			UpdateUser();
		}
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "maj_decomptes.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<body style="background:#dfe8ff">


<form id="form_user" name="form_user" method="post" action="maj_decomptes.php">

<table class="table2"><tr><td style="text-align:center">

	<center>

	<table class="table3">
				
		
		<tr>
		<td bgcolor="#66CCCC"><?php echo "Nom Employe : "; ?></td><td bgcolor="#66CCCC"><?php echo $employe; ?></td></tr>
		<tr><td bgcolor="#66CCCC"><?php echo "Bulletin "; ?></td><td  bgcolor="#66CCCC"><input type="text" id="bulletin" name="bulletin" style="width:100px" value="<?php echo $bulletin; ?>"></td>
		</tr>
	
		</table>
		

<p style="text-align:center">

<center>

<input type="hidden" id="user_id" name="user_id" value="<?php echo $_REQUEST["user_id"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php echo $action_; ?>">

<input type="hidden" id="employe" name="employe" value="<?php echo $employe; ?>">


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
