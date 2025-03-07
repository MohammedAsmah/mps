<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$employe = $_REQUEST["employe"];$ref = $_REQUEST["ref"];$service = $_REQUEST["service"];
			$poste = $_REQUEST["poste"];if(isset($_REQUEST["statut"])) { $statut = 1; } else { $statut = 0; }
			$t_h_normales = $_REQUEST["t_h_normales"];$t_h_25 = $_REQUEST["t_h_25"];$t_h_50 = $_REQUEST["t_h_50"];
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO employes ( code, employe,service,statut,poste )
				 VALUES ('$ref','$employe','$service','$statut','$poste')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE employes SET ref = '$ref',employe = '$employe',t_h_normales='$t_h_normales',
				t_h_25='$t_h_25',t_h_50='$t_h_50',valide=1,statut='$statut' WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM employes WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	$date1="";$action="recherche";$employe="";
	$profiles_list_employe = "";
	$sql43 = "SELECT * FROM employes ORDER BY employe;";
	$temp = db_query($database_name, $sql43);
	while($temp_ = fetch_array($temp)) {
		if($employe == $temp_["employe"]) { $selected = " selected"; } else { $selected = ""; }
		
		$profiles_list_employe .= "<OPTION VALUE=\"" . $temp_["employe"] . "\"" . $selected . ">";
		$profiles_list_employe .= $temp_["employe"];
		$profiles_list_employe .= "</OPTION>";
	}
	if(isset($_REQUEST["action"])){}else{ ?>
	<form id="form" name="form" method="post" action="etat_pointage_globale_cloture.php">
	<td><?php echo "Date : "; ?><input onClick="ds_sh(this);" name="date1" value="<?php echo $date1; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Employe : "; ?></td><td><select id="employe" name="employe"><?php echo $profiles_list_employe; ?></select></td>
	<input type="submit" id="action" name="action" value="<?php echo $action; ?>">
	</form>
	
	<? }
	$vide="";
	if(isset($_REQUEST["action"]))
	{ $date1=dateFrToUs($_POST['date1']);$employe=$_POST['employe'];
	$sql  = "SELECT * ";$occ="occasionnelles";$per="permanents";
	$sql .= "FROM journal_paie where employe='$employe' and du='$date1' ORDER BY service DESC ,employe ASC;";
	$users = db_query($database_name, $sql);}
	
	else
	{$sql  = "SELECT * ";
	$sql .= "FROM journal_paie where employe='$vide' ORDER BY service DESC ,employe ASC;";
	$users = db_query($database_name, $sql);}
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste "; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "employe2.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">
<? require "body_cal.php";?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php $date_e=date("d/m/Y h:m:s");echo ""; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Nom et Prenom ";?></th>
	<th><?php echo "H.N";?></th>
	<th><?php echo "H.25%";?></th>
	<th><?php echo "H.50%";?></th>
	<th><?php echo "H.100%";?></th>
	<th><?php echo "Total H.";?></th>
	<th><?php echo "Controle";?></th>	
	
</tr>

<?php $tr=0;$ser="";while($users_ = fetch_array($users)) { ?><tr>
<? if ($tr==0 and $ser<>$users_["service"])
{?><tr><td bgcolor="#66CCCC"><?php $ser==$users_["service"];$tr=1;echo $users_["service"];?></td></tr><? }?>

<td><?php echo $users_["employe"];?></td>
<td align="right"><?php echo number_format($users_["t_h_normales"],2,',',' '); ?></td>
<td align="right"><?php echo number_format($users_["t_h_25"],2,',',' '); ?></td>
<td align="right"><?php echo number_format($users_["t_h_50"],2,',',' '); ?></td>
<td align="right"><?php echo number_format($users_["t_h_100"],2,',',' '); ?></td>
<td align="right"><?php $tt=$users_["t_h_normales"]+($users_["t_h_25"]*1.25)+($users_["t_h_50"]*1.50);
echo number_format($tt,2,',',' ');?></td>
<td></td>
<? if ($ser<>$users_["service"]){$ser=$users_["service"];$tr=0;}?>
<?php } ?>

</table>



<p style="text-align:center">


</body>

</html>