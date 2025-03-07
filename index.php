<?php

$ip=$_SERVER["REMOTE_ADDR"];
	/* if($ip=="41.251.252.38" or $ip=="196.92.6.253" ) { */
		
	require "config.php";
	require "connect_db_updated.php";
	require "functions.php";
	

	$session_timeout = param_extract("session_timeout");

	if(isset($_REQUEST["action_"])) {
		
		switch($_REQUEST["action_"]) {

			case "login":

			$sql  = "SELECT user_id FROM rs_data_users ";
			$sql .= "WHERE login = '" . $_REQUEST["user"] . "' ";
			$sql .= "AND password = '" . $_REQUEST["password"] . "';";
			$user = db_query($database_name, $sql);
			///////////////////////////////////
			
			
			if($user_ = fetch_array($user)) {
				// login successful -> sets the cookie
				
				if($session_timeout != 0) {
					setcookie("bookings_user_id", $user_["user_id"], (time() + $session_timeout));
				} else {
					setcookie("bookings_user_id", $user_["user_id"]);
				}
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql);
	//////////////////////
	
	$user_ = fetch_array($user);
	
	$login = $user_["login"];$tout = $user_["tout"];$menu1 = $user_["menu1"];$menu2 = $user_["menu2"];$menu3 = $user_["menu3"];
	$menu4 = $user_["menu4"];$menu5 = $user_["menu5"];$menu6 = $user_["menu6"];
	$menu7 = $user_["menu7"];$menu8 = $user_["menu8"];$menu9 = $user_["menu9"];$menu10 = $user_["menu10"];$menu11 = $user_["menu11"];$menu12 = $user_["menu12"];
	$menu13 = $user_["menu13"];

		

			} else {
				// login/password incorrect
				$error_message = "Login/password incorrect ";
				
			}

			break;
			
			case "delog":
			// wipes the cookie
			setcookie ("bookings_user_id", "", time() - 3600);

		} // switch

} // isset

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title></title>

<meta name="author" content=""> 
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="robots" content="index,nofollow">

<link rel="stylesheet" type="text/css" href="styles.css">

<?php if(isset($_REQUEST["action_"])) { ?>

<script type="text/javascript"><!--
	
	document.location = "index.php?rand=<?php echo rand(1,1000); ?>";
	
--></script>

</head>

<body></body>

</html>

<?php } else { ?>

</head>

<?php if(isset($_COOKIE["bookings_user_id"])) { // cookie is set : user is already logged ?>


<frameset cols="350,*">
	<frame name="left_frame" src="menu.php">
	<frame name="middle_frame" src="intro.php">
</frameset><noframes></noframes>

<body>

<?php } else { // no cookie : shows login form ?>

<center>

<form id="login_form" name="login_form" method="post" action="index.php">

	<table class="table3">
	<tr><td style="height:30px"></td></tr>
	<tr><td style="font-size:24px"><span style="font-size:12px"></span></td></tr>

	<tr><td>

		<table style="background: #efefef;"><tr><td style="padding:15px; border: 2px groove;">
			
			<table class="table3"><tr>
				<td style="text-align:right"><?php echo "Utilisateur" ?> :</td><td><input type="text" id="user" name="user"></td>
			</tr><tr>
				<td style="text-align:right"><?php echo "Mot de Passe" ?> :</td><td><input type="password" id="password" name="password"></td>
			</tr><tr><td style="height:15px" colspan="2"></td></tr><tr>
				
				<td colspan="2" style="text-align:center"><input type="submit" value="OK"></td>
				
			</tr>
			<td><? $ip=$_SERVER["REMOTE_ADDR"];echo "MPS ";?></td><td></td>
			
			</table>

		</td></tr></table>

	</td></tr></table>

	<?php if(isset($error_message)) { ?><p style="color:#ff0000"><?php echo $error_message; ?></p><?php } ?>

	<input type="hidden" name="action_" value="login">

</form>

<table><tr>
<td colspan="3"style="height:20px"></td>
</tr><tr>
</table>

</center>

</body>

<?php } }

/* } */
/* else
{ echo "ERROR X2541 § SERVER NOT FOUND ";

$to = "abdelaali.jabbour@gmail.com";
$subject = "connexion hors site";

$time_edition=date("Y-m-d H:i:s");
$ipcon = $ip." at ".$time_edition;

$message="<html><head></head><body>".$ipcon."</body></html>";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

mail($to, $subject, $message, $headers);




} */


?>

</html>
