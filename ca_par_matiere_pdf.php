<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();
		$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$user_login = $user_["login"];$stii=0;$ligne=0;

	
	$error_message = "";	$du="";$au="";$action="Recherche";$du1="";$au1="";
			$sql = "TRUNCATE TABLE `report_mat`  ;";
			db_query($database_name, $sql);
			$sql = "TRUNCATE TABLE `tableau_matiere`  ;";
			db_query($database_name, $sql);
	
		if(isset($_REQUEST["action"]))
	{
	$du=dateFrToUs($_POST['du']);$au=dateFrToUs($_POST['au']);$du1=$_POST['du'];$au1=$_POST['au'];
	$debut_exercice=dateFrToUs($_POST['du']);$fin_exercice=dateFrToUs($_POST['au']);
	echo "<td><a href=\"matiere_pdf.php?du=$du&au=$au\">Imprimer</a></td>";
			
	}else
	{
?>
	<form id="form" name="form" method="post" action="ca_par_matiere_pdf.php">
	<td><?php echo "Du : "; ?><input type="text" id="du" name="du" value="<?php echo $du; ?>" size="15"></td>
	<td><?php echo "Au : "; ?><input type="text" id="au" name="au" value="<?php echo $au; ?>" size="15"></td>
	<tr>
	<td><input type="submit" id="action" name="action" value="<?php echo $action; ?>"></td>
	</form>
	
	<? }?>
	
	
	</body>

</html>