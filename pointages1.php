<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";
	$error_message = "";	$du="";$au="";$action="Recherche";$du1="";$au1="";

	
		if(isset($_REQUEST["action"]))
	{}else
	{
?>
	<form id="form" name="form" method="post" action="pointages1.php">
	<td><?php echo "Du : "; ?><input onClick="ds_sh(this);" name="du" value="<?php echo $du; ?>" readonly="readonly" style="cursor: text" /></td>
	<td><?php echo "Au : "; ?><input onClick="ds_sh(this);" name="au" value="<?php echo $au; ?>" readonly="readonly" style="cursor: text" /></td>
	<tr>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }
	if(isset($_REQUEST["action"]))
	{
	 $du=dateFrToUs($_POST['du']);$au=dateFrToUs($_POST['au']);$du1=$_POST['du'];$au1=$_POST['au'];
	}
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	if(isset($_REQUEST["action_"]) && $profile_id == 1) { 

		if($_REQUEST["action_"] != "delete_user") {
			// prepares data to simplify database insert or update
			$last_name = $_REQUEST["last_name"];$last_name1 = $_REQUEST["last_name1"];$login = $_REQUEST["login"];
			$remarks = $_REQUEST["remarks"];$remise2 = $_REQUEST["remise2"];$remise3 = $_REQUEST["remise3"];
			$vendeur = $_REQUEST["vendeur"];$ville = $_REQUEST["ville"];$patente = $_REQUEST["patente"];$inputation = $_REQUEST["inputation"];
		}
		
		switch($_REQUEST["action_"]) {

			case "insert_new_user":
			
		
				$sql  = "INSERT INTO pointeuse ( ref, client, patente,inputation,remise2,remise3,ville,vendeur_nom,adrresse )
				 VALUES ('$login','$last_name','$patente','$inputation','$remise2','$remise3','$ville','$vendeur','$remarks')";

				db_query($database_name, $sql);
			

			break;

			case "update_user":
			$user_id=$_REQUEST["user_id"];
			$sql = "UPDATE clients SET remise2 = '$remise2',patente = '$patente',inputation = '$inputation',remise3 = '$remise3',adrresse = '$remarks',
			client = '$last_name' , vendeur_nom = '$vendeur',ville = '$ville' WHERE id = '$user_id'";
			db_query($database_name, $sql);
			
			
			break;
			
			case "delete_user":
			

			// delete user's profile
			$sql = "DELETE FROM clients WHERE id = " . $_REQUEST["user_id"] . ";";
			db_query($database_name, $sql);
			break;


		} //switch
	} //if
	
	$sql  = "SELECT id,name,date,sum(lun) as t_lun ,sum(mar) as t_mar,sum(mer) as t_mer,sum(jeu) 
	as t_jeu,sum(ven) as t_ven,sum(sam) as t_sam,sum(dim) as t_dim,sum(heures) as t_heures ";
	$sql .= "FROM pointeuse where date between '$du' and '$au' group by name ORDER BY id;";
	$users = db_query($database_name, $sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>
	<? require "head_cal.php";?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . "liste Pointage"; ?></title>

<link rel="stylesheet" type="text/css" href="styles.css">

<script type="text/javascript"><!--
	function EditUser(user_id) { document.location = "pointage.php?user_id=" + user_id; }

--></script>

</head>

<body style="background:#dfe8ff">
	<? require "body_cal.php";?>

<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>

<span style="font-size:24px"><?php echo "Etat Pointage Du $du1 au $au1"; ?></span>

<table class="table2">

<tr>
	<th><?php echo "Code";?></th>
	<th><?php echo "Nom";?></th>
	<th><?php echo "Ven";?></th>
	<th><?php echo "Sam";?></th>
	<th><?php echo "Dim";?></th>
	<th><?php echo "Lun";?></th>
	<th><?php echo "Mar";?></th>
	<th><?php echo "Mer";?></th>
	<th><?php echo "Jeu";?></th>
	<th><?php echo "Normales";?></th>
	<th><?php echo "Sup";?></th>
	<th><?php echo "Total";?></th>
</tr>

<?php while($users_ = fetch_array($users)) { ?><tr>
<td><?php echo $users_["id"];?></td>
<td><?php echo $users_["name"]; ?></td>
<td><?php echo $users_["t_ven"]; ?></td>
<td><?php echo $users_["t_sam"]; ?></td>
<td><?php echo $users_["t_dim"]; ?></td>
<td><?php echo $users_["t_lun"]; ?></td>
<td><?php echo $users_["t_mar"]; ?></td>
<td><?php echo $users_["t_mer"]; ?></td>
<td><?php echo $users_["t_jeu"]; ?></td>
<td><?php $normales=$users_["t_ven"]+$users_["t_sam"]+$users_["t_dim"]+$users_["t_lun"]+$users_["t_mar"]+$users_["t_mer"]+$users_["t_jeu"];echo $normales; ?></td>
<td><?php echo $users_["t_heures"]-$normales; ?></td>
<td><?php echo $users_["t_heures"]; ?></td>
<?php } ?>

</table>

<p style="text-align:center">

</body>

</html>