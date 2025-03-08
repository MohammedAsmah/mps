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
				// Use prepared statements to prevent SQL injection
				$sql = "SELECT user_id FROM rs_data_users WHERE login = ? AND password = ?";
				$stmt = $mysqli->prepare($sql);
			
				if (!$stmt) {
					die("SQL Error: " . $mysqli->error);
				}
			
				// Bind parameters
				$stmt->bind_param("ss", $_REQUEST["user"], $_REQUEST["password"]);
				$stmt->execute();
				$result = $stmt->get_result();
			
				if ($user_ = $result->fetch_assoc()) {
					// Login successful -> set the cookie
					if ($session_timeout != 0) {
						setcookie("bookings_user_id", $user_["user_id"], time() + $session_timeout);
					} else {
						setcookie("bookings_user_id", $user_["user_id"]);
					}
			
					// Fetch user details
					$sql = "SELECT * FROM rs_data_users WHERE user_id = ?";
					$stmt = $mysqli->prepare($sql);
					$stmt->bind_param("i", $user_["user_id"]);
					$stmt->execute();
					$user_result = $stmt->get_result();
					$user_ = $user_result->fetch_assoc();
			
					// Assign user details to variables
					$login = $user_["login"];
					$tout = $user_["tout"];
					$menu1 = $user_["menu1"];
					$menu2 = $user_["menu2"];
					$menu3 = $user_["menu3"];
					$menu4 = $user_["menu4"];
					$menu5 = $user_["menu5"];
					$menu6 = $user_["menu6"];
					$menu7 = $user_["menu7"];
					$menu8 = $user_["menu8"];
					$menu9 = $user_["menu9"];
					$menu10 = $user_["menu10"];
					$menu11 = $user_["menu11"];
					$menu12 = $user_["menu12"];
					$menu13 = $user_["menu13"];
				} else {
					// Login/password incorrect
					$error_message = "Login/password incorrect";
				}
				break;

			/* case "login":

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

			break; */
			
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
<script src="https://cdn.tailwindcss.com"></script>
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

<body class="bg-blue-100">

<?php } else { // no cookie : shows login form ?>

	<div class="min-h-screen bg-blue-100 flex flex-col items-center  justify-center">
		<div class="w-full max-w-md bg-white p-8 rounded-lg flex flex-col justify-center items-center shadow-lg">
        <!-- Company Title -->
        <h1 class="text-4xl font-bold text-blue-600 mb-8">MPS</h1>

        <!-- Login Form -->
        <form id="login_form" name="login_form" method="post" action="index.php" class="w-full flex flex-col justify-center items-center">
            <div class="mb-8 w-full">
                <label for="user" class="block text-gray-800 text-sm font-bold mb-2">Utilisateur :</label>
                <input type="text" id="user" name="user" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>
            <div class="mb-8 w-full">
                <label for="password" class="block text-gray-800 text-sm font-bold mb-2">Mot de Passe :</label>
                <input type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                    Connexion
                </button>
            </div>
            <?php if (isset($error_message)) { ?>
                <p class="text-red-500 text-xs italic mt-4"><?php echo $error_message; ?></p>
            <?php } ?>
            <input type="hidden" name="action_" value="login">
        </form>
		</div>
    </div>

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
