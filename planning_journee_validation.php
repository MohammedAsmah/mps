<?php

	require "config.php";
	require "connect_db.php";
	require "functions.php";
	
	CheckCookie(); // Resets app to the index page if timeout is reached. This function is implemented in functions.php
	$profile_id = GetUserProfile();

	$error_message = "";$du="";$au="";$vendeur="";$remise_1=0;$remise_2=0;$remise_3=0;
	//gets the login
	$sql = "SELECT * FROM rs_data_users WHERE user_id = " . $_COOKIE["bookings_user_id"] . ";";
	$user = db_query($database_name, $sql); $user_ = fetch_array($user);
	
	$user_login = $user_["login"];
	
	?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}

</style>

	<? require "head_cal.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo "" . ""; ?></title>

<link rel="stylesheet" type="text/css" href="css/bootstrap.css">


    <style type="text/css">
        /* some styling for the page */
        body { font-size: 10px; /* for the widget natural size */ }
        #content { font-size: 1.2em; /* for the rest of the page to show at a normal size */
                   font-family: "Lucida Sans Unicode", "Lucida Grande", Verdana, Arial, Helvetica, sans-serif;
                   width: 950px; margin: auto;
        }
        .code { margin: 6px; padding: 9px; background-color: #fdf5ce; border: 1px solid #c77405; }
        fieldset { padding: 0.5em 2em }
        hr { margin: 0.5em 0; clear: both }
        a { cursor: pointer; }
        #requirements li { line-height: 1.6em; }
    </style>

    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-24327002-1']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

        function plusone_clicked() {
            $('#thankyou').fadeIn(300);
        }

        $(document).ready(function() {
            $('#floating_timepicker').timepicker({
                onSelect: function(time, inst) {
                    $('#floating_selected_time').html('You selected ' + time);
                }
            });

            $('#tabs').tabs();

        });


    </script>


<script> 
function blink(ob) 
{ 
if (ob.style.visibility == "visible" ) 
{ 
ob.style.visibility = "hidden"; 
} 
else 
{ 
ob.style.visibility = "visible"; 
} 
} 
setInterval("blink(bl)",500); 
</script> 

<script type="text/javascript"><!--
	function UpdateUser() {
			document.getElementById("form_user").submit();
	}

	function CheckUser() {
			UpdateUser();
	}
	
	function DeleteUser() {
		if(window.confirm("<?php ; ?>\n<?php echo "Confirmer la suppression ?"; ?>")) {
			document.location = "intro.php?action_=delete_user&user_id=<?php echo $_REQUEST["user_id"]; ?>";
		}
	}


--></script>

</head>

<?
	// update or delete are performed only if current user is an admin.
	// this prevents aware users to do nasty things by passing values through the url
	$clients_list = "";
	$sql = "SELECT * FROM  clients ORDER BY client;";
	$temp = db_query($database_name, $sql);
	while($temp_ = fetch_array($temp)) {
		if($h00_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
		
		$clients_list .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";
		$clients_list .= $temp_["client"];
		$clients_list .= "</OPTION>";
	}
	
	$services_list = "Selectionnez Service";
	$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";
	$temp_produit = db_query($database_name, $sql_produit);
	while($temp_produit_ = fetch_array($temp_produit)) {
		if($h00_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$services_list .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list .= $temp_produit_["profile_name"];
		$services_list .= "</OPTION>";
	}
	
	$mode_voucher_list = "Selectionnez Service";
	$sql_produit = "SELECT * FROM modes_vouchers ORDER BY profile_name;";
	$temp_produit = db_query($database_name, $sql_produit);
	while($temp_produit_ = fetch_array($temp_produit)) {
		if($mode_voucher == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }
		
		$mode_voucher_list .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$mode_voucher_list .= $temp_produit_["profile_name"];
		$mode_voucher_list .= "</OPTION>";
	}		
	
	$matricule1=$_GET["matricule"];	
	$list_matricules = "";
	$sql_produit = "SELECT * FROM park ORDER BY id;";
	$temp_produit = db_query($database_name, $sql_produit);
	while($temp_produit_ = fetch_array($temp_produit)) {
		if($matricule1 == $temp_produit_["matricule"]) { $selected = " selected"; } else { $selected = ""; }
		
		$list_matricules .= "<OPTION VALUE=\"" . $temp_produit_["matricule"] . "\"" . $selected . ">";
		$list_matricules .= $temp_produit_["matricule"];
		$list_matricules .= "</OPTION>";
	}		
	
	
	// recherche ville
		
		$matricule=$_GET["matricule"];$date=$_GET["date_jour"];$type_vehicule=$_GET["type_vehicule"];$id_journee=$_GET["id_journee"];
		
		$sql  = "SELECT * ";$vide="";$compt=0;
	$sql .= "FROM planning where id='$id_journee' and matricule='$matricule' ORDER BY id;";
	$usersp1 = db_query($database_name, $sql);$users1 = fetch_array($usersp1);
	$h00_service= $users1["h00_service"]; 
	$h00_client= $users1["h00_client"];
		
	$h01_service= $users1["h01_service"]; 
	$h01_client= $users1["h01_client"];
	
	$h02_service= $users1["h02_service"]; 
	$h02_client= $users1["h02_client"];

	$h03_service= $users1["h03_service"]; 
	$h03_client= $users1["h03_client"];	
	
	$h04_service= $users1["h04_service"]; 
	$h04_client= $users1["h04_client"];
	
	$h05_service= $users1["h05_service"]; 
	$h05_client= $users1["h05_client"];
	
	$h06_service= $users1["h06_service"]; 
	$h06_client= $users1["h06_client"];
	
	$h07_service= $users1["h07_service"]; 
	$h07_client= $users1["h07_client"];
	
	$h08_service= $users1["h08_service"]; 
	$h08_client= $users1["h08_client"];
	
	$h09_service= $users1["h09_service"]; 
	$h09_client= $users1["h09_client"];
	
	$h10_service= $users1["h10_service"]; 
	$h10_client= $users1["h10_client"];
	
	$h11_service= $users1["h11_service"]; 
	$h11_client= $users1["h11_client"];
	
	$h12_service= $users1["h12_service"]; 
	$h12_client= $users1["h12_client"];
	
	$h13_service= $users1["h13_service"]; 
	$h13_client= $users1["h13_client"];
	
	$h14_service= $users1["h14_service"]; 
	$h14_client= $users1["h14_client"];
	
	$h15_service= $users1["h15_service"]; 
	$h15_client= $users1["h15_client"];
	
	$h16_service= $users1["h16_service"]; 
	$h16_client= $users1["h16_client"];
	
	$h17_service= $users1["h17_service"]; 
	$h17_client= $users1["h17_client"];
	
	$h18_service= $users1["h18_service"]; 
	$h18_client= $users1["h18_client"];
	
	$h19_service= $users1["h19_service"]; 
	$h19_client= $users1["h19_client"];
	
	$h20_service= $users1["h20_service"]; 
	$h20_client= $users1["h20_client"];
	
	$h21_service= $users1["h21_service"]; 
	$h21_client= $users1["h21_client"];
	
	$h22_service= $users1["h22_service"]; 
	$h22_client= $users1["h22_client"];
	
	$h23_service= $users1["h23_service"]; 
	$h23_client= $users1["h23_client"];
	
	/////////////////////
	$h00_ref= $users1["h00_ref"]; 
	$h01_ref= $users1["h01_ref"]; 
	$h02_ref= $users1["h02_ref"]; 
	$h03_ref= $users1["h03_ref"]; 
	$h04_ref= $users1["h04_ref"]; 
	$h05_ref= $users1["h05_ref"]; 
	$h06_ref= $users1["h06_ref"]; 
	$h07_ref= $users1["h07_ref"]; 
	$h08_ref= $users1["h08_ref"]; 
	$h09_ref= $users1["h09_ref"]; 
	$h10_ref= $users1["h10_ref"]; 
	$h11_ref= $users1["h11_ref"]; 
	$h12_ref= $users1["h12_ref"]; 
	$h13_ref= $users1["h13_ref"]; 
	$h14_ref= $users1["h14_ref"]; 
	$h15_ref= $users1["h15_ref"]; 
	$h16_ref= $users1["h16_ref"]; 
	$h17_ref= $users1["h17_ref"]; 
	$h18_ref= $users1["h18_ref"]; 
	$h19_ref= $users1["h19_ref"]; 
	$h20_ref= $users1["h20_ref"]; 
	$h21_ref= $users1["h21_ref"]; 
	$h22_ref= $users1["h22_ref"]; 
	$h23_ref= $users1["h23_ref"]; 
	
	////////////////
	
	
	
	$clients_list_00 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h00_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_00 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_00 .= $temp_["client"];$clients_list_00 .= "</OPTION>";}
	$services_list_00 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);	while($temp_produit_ = fetch_array($temp_produit)) {
	if($h00_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_00 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
	$services_list_00 .= $temp_produit_["profile_name"];$services_list_00 .= "</OPTION>";}

	$clients_list_01 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h01_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_01 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_01 .= $temp_["client"];$clients_list_01 .= "</OPTION>";}
	$services_list_01 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h01_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_01 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_01 .= $temp_produit_["profile_name"];$services_list_01 .= "</OPTION>";}

		$clients_list_02 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h02_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_02 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_02 .= $temp_["client"];$clients_list_02 .= "</OPTION>";}
	$services_list_02 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h02_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_02 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_02 .= $temp_produit_["profile_name"];$services_list_02 .= "</OPTION>";}

		$clients_list_03 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h03_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_03 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_03 .= $temp_["client"];$clients_list_03 .= "</OPTION>";}
	$services_list_03 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h03_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_03 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_03 .= $temp_produit_["profile_name"];$services_list_03 .= "</OPTION>";}

		$clients_list_04 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h04_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_04 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_04 .= $temp_["client"];$clients_list_04 .= "</OPTION>";}
	$services_list_04 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h04_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_04 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_04 .= $temp_produit_["profile_name"];$services_list_04 .= "</OPTION>";}
		
		$clients_list_05 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h05_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_05 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_05 .= $temp_["client"];$clients_list_05 .= "</OPTION>";}
	$services_list_05 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h05_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_05 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_05 .= $temp_produit_["profile_name"];$services_list_05 .= "</OPTION>";}

		$clients_list_06 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h06_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_06 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_06 .= $temp_["client"];$clients_list_06 .= "</OPTION>";}
	$services_list_06 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h06_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_06 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_06 .= $temp_produit_["profile_name"];$services_list_06 .= "</OPTION>";}

		$clients_list_07 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h07_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_07 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_07 .= $temp_["client"];$clients_list_07 .= "</OPTION>";}
	$services_list_07 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h07_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_07 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_07 .= $temp_produit_["profile_name"];$services_list_07 .= "</OPTION>";}

		$clients_list_08 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h08_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_08 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_08 .= $temp_["client"];$clients_list_08 .= "</OPTION>";}
	$services_list_08 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h08_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_08 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_08 .= $temp_produit_["profile_name"];$services_list_08 .= "</OPTION>";}
		
		$clients_list_09 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h09_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_09 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_09 .= $temp_["client"];$clients_list_09 .= "</OPTION>";}
	$services_list_09 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h09_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_09 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_09 .= $temp_produit_["profile_name"];$services_list_09 .= "</OPTION>";}
	
	
	
	$clients_list_10 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h10_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_10 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_10 .= $temp_["client"];$clients_list_10 .= "</OPTION>";}
	$services_list_10 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);	while($temp_produit_ = fetch_array($temp_produit)) {
	if($h10_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_10 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
	$services_list_10 .= $temp_produit_["profile_name"];$services_list_10 .= "</OPTION>";}

	$clients_list_11 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h11_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_11 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_11 .= $temp_["client"];$clients_list_11 .= "</OPTION>";}
	$services_list_11 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h11_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_11 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_11 .= $temp_produit_["profile_name"];$services_list_11 .= "</OPTION>";}

		$clients_list_12 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h12_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_12 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_12 .= $temp_["client"];$clients_list_12 .= "</OPTION>";}
	$services_list_12 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h12_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_12 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_12 .= $temp_produit_["profile_name"];$services_list_12 .= "</OPTION>";}

		$clients_list_13 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h13_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_13 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_13 .= $temp_["client"];$clients_list_13 .= "</OPTION>";}
	$services_list_13 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h13_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_13 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_13 .= $temp_produit_["profile_name"];$services_list_13 .= "</OPTION>";}

		$clients_list_14 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h14_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_14 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_14 .= $temp_["client"];$clients_list_14 .= "</OPTION>";}
	$services_list_14 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h14_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_14 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_14 .= $temp_produit_["profile_name"];$services_list_14 .= "</OPTION>";}
		
		$clients_list_15 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h15_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_15 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_15 .= $temp_["client"];$clients_list_15 .= "</OPTION>";}
	$services_list_15 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h15_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_15 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_15 .= $temp_produit_["profile_name"];$services_list_15 .= "</OPTION>";}

		$clients_list_16 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h16_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_16 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_16 .= $temp_["client"];$clients_list_16 .= "</OPTION>";}
	$services_list_16 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h16_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_16 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_16 .= $temp_produit_["profile_name"];$services_list_16 .= "</OPTION>";}

		$clients_list_17 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h17_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_17 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_17 .= $temp_["client"];$clients_list_17 .= "</OPTION>";}
	$services_list_17 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h17_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_17 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_17 .= $temp_produit_["profile_name"];$services_list_17 .= "</OPTION>";}

		$clients_list_18 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h18_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_18 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_18 .= $temp_["client"];$clients_list_18 .= "</OPTION>";}
	$services_list_18 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h18_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_18 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_18 .= $temp_produit_["profile_name"];$services_list_18 .= "</OPTION>";}
		
		$clients_list_19 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h19_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_19 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_19 .= $temp_["client"];$clients_list_19 .= "</OPTION>";}
	$services_list_19 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h19_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_19 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_19 .= $temp_produit_["profile_name"];$services_list_19 .= "</OPTION>";}
	
		$clients_list_20 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h20_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_20 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_20 .= $temp_["client"];$clients_list_20 .= "</OPTION>";}
	$services_list_20 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h20_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_20 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_20 .= $temp_produit_["profile_name"];$services_list_20 .= "</OPTION>";}

		$clients_list_21 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h21_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_21 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_21 .= $temp_["client"];$clients_list_21 .= "</OPTION>";}
	$services_list_21 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h21_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_21 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_21 .= $temp_produit_["profile_name"];$services_list_21 .= "</OPTION>";}

		$clients_list_22 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h22_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_22 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_22 .= $temp_["client"];$clients_list_22 .= "</OPTION>";}
	$services_list_22 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h22_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_22 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_22 .= $temp_produit_["profile_name"];$services_list_22 .= "</OPTION>";}
		
		$clients_list_23 = "";$sql = "SELECT * FROM  clients ORDER BY client;";$temp = db_query($database_name, $sql);while($temp_ = fetch_array($temp)) {if($h23_client == $temp_["client"]) { $selected = " selected"; } else { $selected = ""; }
	$clients_list_23 .= "<OPTION VALUE=\"" . $temp_["client"] . "\"" . $selected . ">";	$clients_list_23 .= $temp_["client"];$clients_list_23 .= "</OPTION>";}
	$services_list_23 = "";$sql_produit = "SELECT * FROM types_services ORDER BY profile_name;";$temp_produit = db_query($database_name, $sql_produit);while($temp_produit_ = fetch_array($temp_produit)) {
		if($h23_service == $temp_produit_["profile_name"]) { $selected = " selected"; } else { $selected = ""; }$services_list_23 .= "<OPTION VALUE=\"" . $temp_produit_["profile_name"] . "\"" . $selected . ">";
		$services_list_23 .= $temp_produit_["profile_name"];$services_list_23 .= "</OPTION>";}

	
		?>



<body style="background:#dfe8ff">
	<? require "body_cal.php";
	?>
<?php if($error_message != "") { echo $error_message . "<p>"; } ?><p>
<span style="font-size:24px"><?php echo ""; ?></span>
<tr>
<?php 
$sql  = "SELECT * ";
			$sql .= "FROM park WHERE matricule = '" . $matricule . "';";
			$user = db_query($database_name, $sql); $user_ = fetch_array($user);

			$marque = $user_["marque"];$type_vehicule = $user_["type_vehicule"];$nbre_places = $user_["nbre_places"];$model = dateUstoFr($user_["model"]);
			$kilometrage = $user_["kilometrage"];$mode = $user_["mode"];$date_km = dateUstoFr($user_["date_km"]);$conducteur = $user_["conducteur"];$assurance = $user_["assurance"];
			$assurance_du = dateUstoFr($user_["assurance_du"]);$assurance_au = dateUstoFr($user_["assurance_au"]);$autorisation = $user_["autorisation"];$autorisation_du = dateUstoFr($user_["autorisation_du"]);
			$autorisation_au = dateUstoFr($user_["autorisation_au"]);
			$visite_technique_du = dateUstoFr($user_["visite_technique_du"]);$visite_technique_au = dateUstoFr($user_["visite_technique_au"]);$km_vidange = $user_["km_vidange"];
			


$titre=$type_vehicule."   Matricule : ".$matricule ."   Conducteur : ".$conducteur."   Date : ".dateUsToFr($date);$datefr=dateUsToFr($date);
?>
<table class="table table-striped">
<td bgcolor="#66CCCC"><?print("<font size=\"4\" face=\"Comic sans MS\" color=\"#0000FF\">Vehicule : $type_vehicule </font>");?></td></tr>
<tr><td bgcolor="#66CCCC"><?print("<font size=\"4\" face=\"Comic sans MS\" color=\"#0000FF\">Matricule : $matricule </font>");?></td>
<tr><td bgcolor="#66CCCC"><?print("<font size=\"4\" face=\"Comic sans MS\" color=\"#0000FF\">Conducteur : $conducteur </font>");?></td>
</table>
<p style="text-align:center">
<span style="font-size:24px"><?php echo "RECAP JOURNEE $datefr "; ?></span>
<? ?>

<tr>
</tr>


<form id="form_user" name="form_user" method="post" action="intro.php">


<tr>

<table class="table table-striped">
		<tr><th>HEURE</th>
       <th>HEURE</th>
       <th>SERVICE</th>
       <th>CLIENT</th>
	   <th>REF CLIENT</th>
	   <th>CONTROLE</th>
	   
		</tr>
		<? $h00_controle= $users1["h00_controle"]; if ($h00_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h00= $users1["h00"]; ?><?php echo $h00; ?></td><td><?php  echo $h00_service; ?></td>
		<td><?php echo $h00_client; ?></td></td><?php echo $h00_ref; ?></td>
		
		<td><?php ?><input type="checkbox" id="h00_controle" name="h00_controle"<?php if($h00_controle) { echo " checked"; } ?>></td>
		<? } else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h00= $users1["h00"]; ?><?php echo $h00; ?></td><td><?php  echo $h00_service; ?></td>
		<td><?php echo $h00_client; ?></td><td><?php echo $h00_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td><input type="hidden" id="h00_controle" name="h00_controle" value="<?php echo $h00_controle; ?>">
		<? }?>
		
		<? $h01_controle= $users1["h01_controle"]; if ($h01_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h01= $users1["h01"]; ?><?php echo $h01; ?></td><td><?php  echo $h01_service; ?></td>
		<td><?php echo $h01_client; ?></td></td><?php echo $h01_ref; ?></td>
		
		<td><?php  ?><input type="checkbox" id="h01_controle" name="h01_controle"<?php if($h01_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h01= $users1["h01"]; ?><?php echo $h01; ?></td><td><?php  echo $h01_service; ?></td>
		<td><?php echo $h01_client; ?></td></td><?php echo $h01_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td>
		<? }?>
		
		<? $h02_controle= $users1["h02_controle"]; if ($h02_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h02= $users1["h02"]; ?><?php echo $h02; ?></td><td><?php  echo $h02_service; ?></td>
		<td><?php echo $h02_client; ?></td></td><?php echo $h02_ref; ?></td>
		
		<td><?php  ?><input type="checkbox" id="h02_controle" name="h02_controle"<?php if($h02_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h02= $users1["h02"]; ?><?php echo $h02; ?></td><td><?php  echo $h02_service; ?></td>
		<td><?php echo $h02_client; ?></td></td><?php echo $h02_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td>
		<? }?>
		
		<? $h03_controle= $users1["h03_controle"]; if ($h03_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h03= $users1["h03"]; ?><?php echo $h03; ?></td><td><?php  echo $h03_service; ?></td>
		<td><?php echo $h03_client; ?></td></td><?php echo $h03_ref; ?></td>
		
		<td><?php  ?><input type="checkbox" id="h03_controle" name="h03_controle"<?php if($h03_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h03= $users1["h03"]; ?><?php echo $h03; ?></td><td><?php  echo $h03_service; ?></td>
		<td><?php echo $h03_client; ?></td></td><?php echo $h03_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td>
		<? }?>
		
		<? $h04_controle= $users1["h04_controle"]; if ($h04_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h04= $users1["h04"]; ?><?php echo $h04; ?></td><td><?php  echo $h04_service; ?></td>
		<td><?php echo $h04_client; ?></td></td><?php echo $h04_ref; ?></td>
		
		<td><?php  ?><input type="checkbox" id="h04_controle" name="h04_controle"<?php if($h04_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h04= $users1["h04"]; ?><?php echo $h04; ?></td><td><?php  echo $h04_service; ?></td>
		<td><?php echo $h04_client; ?></td></td><?php echo $h04_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td>
		<? }?>
		
		<? $h05_controle= $users1["h05_controle"]; if ($h05_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h05= $users1["h05"]; ?><?php echo $h05; ?></td><td><?php  echo $h05_service; ?></td>
		<td><?php echo $h05_client; ?></td></td><?php echo $h05_ref; ?></td>
		
		<td><?php  ?><input type="checkbox" id="h05_controle" name="h05_controle"<?php if($h05_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h05= $users1["h05"]; ?><?php echo $h05; ?></td><td><?php  echo $h05_service; ?></td>
		<td><?php echo $h05_client; ?></td></td><?php echo $h05_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td>
		<? }?>
		
		<? $h06_controle= $users1["h06_controle"]; if ($h06_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h06= $users1["h06"]; ?><?php echo $h06; ?></td><td><?php  echo $h06_service; ?></td>
		<td><?php echo $h06_client; ?></td></td><?php echo $h06_ref; ?></td>
		
		<td><?php  ?><input type="checkbox" id="h06_controle" name="h06_controle"<?php if($h06_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h06= $users1["h06"]; ?><?php echo $h06; ?></td><td><?php  echo $h06_service; ?></td>
		<td><?php echo $h06_client; ?></td></td><?php echo $h06_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td>
		<? }?>
		
		<? $h07_controle= $users1["h07_controle"];if ($h07_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h07= $users1["h07"]; ?><?php echo $h07; ?></td><td><?php  echo $h07_service; ?></td>
		<td><?php echo $h07_client; ?></td></td><?php echo $h07_ref; ?></td>
		
		<td><?php  ?><input type="checkbox" id="h07_controle" name="h07_controle"<?php if($h07_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h07= $users1["h07"]; ?><?php echo $h07; ?></td><td><?php  echo $h07_service; ?></td>
		<td><?php echo $h07_client; ?></td></td><?php echo $h07_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td><input type="hidden" id="h07_controle" name="h07_controle" value="<?php echo $h07_controle; ?>">
		<? }?>
		
		<? $h08_controle= $users1["h08_controle"]; if ($h08_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h08= $users1["h08"]; ?><?php echo $h08; ?></td><td><?php  echo $h08_service; ?></td>
		<td><?php echo $h08_client; ?></td></td><?php echo $h08_ref; ?></td>
		
		<td><?php  ?><input type="checkbox" id="h08_controle" name="h08_controle"<?php if($h08_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h08= $users1["h08"]; ?><?php echo $h08; ?></td><td><?php  echo $h08_service; ?></td>
		<td><?php echo $h08_client; ?></td></td><?php echo $h08_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td>
		<? }?>
		
		<? $h09_controle= $users1["h09_controle"]; if ($h09_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h09= $users1["h09"]; ?><?php echo $h09; ?></td><td><?php  echo $h09_service; ?></td>
		<td><?php echo $h09_client; ?></td></td><?php echo $h09_ref; ?></td>
		
		<td><?php  ?><input type="checkbox" id="h09_controle" name="h09_controle"<?php if($h09_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h09= $users1["h09"]; ?><?php echo $h09; ?></td><td><?php  echo $h09_service; ?></td>
		<td><?php echo $h09_client; ?></td><?php echo $h09_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td>
		<? }?>
		
		<? $h10_controle= $users1["h10_controle"];  if ($h10_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h10= $users1["h10"]; ?><?php echo $h10; ?></td><td><?php  echo $h10_service; ?></td>
		<td><?php echo $h10_client; ?></td><?php echo $h10_ref; ?></td>
		
		<td><?php ?><input type="checkbox" id="h10_controle" name="h10_controle"<?php if($h10_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h10= $users1["h10"]; ?><?php echo $h10; ?></td><td><?php  echo $h10_service; ?></td>
		<td><?php echo $h10_client; ?></td><?php echo $h10_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td><input type="hidden" id="h10_controle" name="h10_controle" value="<?php echo $h10_controle; ?>">
		<? }?>
		
		<? $h11_controle= $users1["h11_controle"]; if ($h11_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h11= $users1["h11"]; ?><?php echo $h11; ?></td><td><?php  echo $h11_service; ?></td>
		<td><?php echo $h11_client; ?></td><?php echo $h11_ref; ?></td>
		
		<td><?php  ?><input type="checkbox" id="h11_controle" name="h11_controle"<?php if($h11_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h11= $users1["h11"]; ?><?php echo $h11; ?></td><td><?php  echo $h11_service; ?></td>
		<td><?php echo $h11_client; ?></td><?php echo $h11_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td>
		<? }?>
		
		<? $h12_controle= $users1["h12_controle"]; if ($h12_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h12= $users1["h12"]; ?><?php echo $h12; ?></td><td><?php  echo $h12_service; ?></td>
		<td><?php echo $h12_client; ?></td><?php echo $h12_ref; ?></td>
		
		<td><?php  ?><input type="checkbox" id="h12_controle" name="h12_controle"<?php if($h12_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h12= $users1["h12"]; ?><?php echo $h12; ?></td><td><?php  echo $h12_service; ?></td>
		<td><?php echo $h12_client; ?></td><?php echo $h12_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td>
		<? }?>
		
		<? $h13_controle= $users1["h13_controle"]; if ($h13_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h13= $users1["h13"]; ?><?php echo $h13; ?></td><td><?php  echo $h13_service; ?></td>
		<td><?php echo $h13_client; ?></td><?php echo $h13_ref; ?></td>
		
		<td><?php  ?><input type="checkbox" id="h13_controle" name="h13_controle"<?php if($h13_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h13= $users1["h13"]; ?><?php echo $h13; ?></td><td><?php  echo $h13_service; ?></td>
		<td><?php echo $h13_client; ?></td><?php echo $h13_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td><input type="hidden" id="h13_controle" name="h13_controle" value="<?php echo $h13_controle; ?>">
		<? }?>
		
		<? $h14_controle= $users1["h14_controle"]; if ($h14_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h14= $users1["h14"]; ?><?php echo $h14; ?></td><td><?php  echo $h14_service; ?></td>
		<td><?php echo $h14_client; ?></td><?php echo $h14_ref; ?></td>
		
		<td><?php  ?><input type="checkbox" id="h14_controle" name="h14_controle"<?php if($h14_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h14= $users1["h14"]; ?><?php echo $h14; ?></td><td><?php  echo $h14_service; ?></td>
		<td><?php echo $h14_client; ?></td><?php echo $h14_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td>
		<? }?>
		
		<? $h15_controle= $users1["h15_controle"]; if ($h15_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h15= $users1["h15"]; ?><?php echo $h15; ?></td><td><?php  echo $h15_service; ?></td>
		<td><?php echo $h15_client; ?></td><?php echo $h15_ref; ?></td>
		
		<td><?php  ?><input type="checkbox" id="h15_controle" name="h15_controle"<?php if($h15_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h15= $users1["h15"]; ?><?php echo $h15; ?></td><td><?php  echo $h15_service; ?></td>
		<td><?php echo $h15_client; ?></td><?php echo $h15_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td>
		<? }?>
		
		<? $h16_controle= $users1["h16_controle"]; if ($h16_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h16= $users1["h16"]; ?><?php echo $h16; ?></td><td><?php  echo $h16_service; ?></td>
		<td><?php echo $h16_client; ?></td><?php echo $h16_ref; ?></td>
		
		<td><?php  ?><input type="checkbox" id="h16_controle" name="h16_controle"<?php if($h16_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h16= $users1["h16"]; ?><?php echo $h16; ?></td><td><?php  echo $h16_service; ?></td>
		<td><?php echo $h16_client; ?></td><?php echo $h16_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td>
		<? }?>
		
		<? $h17_controle= $users1["h17_controle"]; if ($h17_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h17= $users1["h17"]; ?><?php echo $h17; ?></td><td><?php  echo $h17_service; ?></td>
		<td><?php echo $h17_client; ?></td><?php echo $h17_ref; ?></td>
		
		<td><?php  ?><input type="checkbox" id="h17_controle" name="h17_controle"<?php if($h17_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h17= $users1["h17"]; ?><?php echo $h17; ?></td><td><?php  echo $h17_service; ?></td>
		<td><?php echo $h17_client; ?></td><?php echo $h17_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td>
		<? }?>
		
		<?  $h18_controle= $users1["h18_controle"]; if ($h18_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h18= $users1["h18"]; ?><?php echo $h18; ?></td><td><?php  echo $h18_service; ?></td>
		<td><?php echo $h18_client; ?></td><?php echo $h18_ref; ?></td>
		
		<td><?php ?><input type="checkbox" id="h18_controle" name="h18_controle"<?php if($h18_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h18= $users1["h18"]; ?><?php echo $h18; ?></td><td><?php  echo $h18_service; ?></td>
		<td><?php echo $h18_client; ?></td><?php echo $h18_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td>
		<? }?>
		
		<? $h19_controle= $users1["h19_controle"]; if ($h19_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h19= $users1["h19"]; ?><?php echo $h19; ?></td><td><?php  echo $h19_service; ?></td>
		<td><?php echo $h19_client; ?></td><?php echo $h19_ref; ?></td>
		
		<td><?php  ?><input type="checkbox" id="h19_controle" name="h19_controle"<?php if($h19_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h19= $users1["h19"]; ?><?php echo $h19; ?></td><td><?php  echo $h19_service; ?></td>
		<td><?php echo $h19_client; ?></td><?php echo $h19_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td>
		<? }?>
		
		<? $h20_controle= $users1["h20_controle"];  if ($h20_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h20= $users1["h20"]; ?><?php echo $h20; ?></td><td><?php  echo $h20_service; ?></td>
		<td><?php echo $h20_client; ?></td><?php echo $h20_ref; ?></td>
		
		<td><?php ?><input type="checkbox" id="h20_controle" name="h20_controle"<?php if($h20_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h20= $users1["h20"]; ?><?php echo $h20; ?></td><td><?php  echo $h20_service; ?></td>
		<td><?php echo $h20_client; ?></td><?php echo $h20_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td>
		<? }?>
		
		<? $h21_controle= $users1["h21_controle"]; if ($h21_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h21= $users1["h21"]; ?><?php echo $h21; ?></td><td><?php  echo $h21_service; ?></td>
		<td><?php echo $h21_client; ?></td><?php echo $h21_ref; ?></td>
		
		<td><?php  ?><input type="checkbox" id="h21_controle" name="h21_controle"<?php if($h21_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h21= $users1["h21"]; ?><?php echo $h21; ?></td><td><?php  echo $h21_service; ?></td>
		<td><?php echo $h21_client; ?></td><?php echo $h21_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td><input type="hidden" id="h21_controle" name="h21_controle" value="<?php echo $h21_controle; ?>">
		<? }?>
		
		<? $h22_controle= $users1["h22_controle"]; if ($h22_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h22= $users1["h22"]; ?><?php echo $h22; ?></td><td><?php  echo $h22_service; ?></td>
		<td><?php echo $h22_client; ?></td><?php echo $h22_ref; ?></td>
		
		<td><?php  ?><input type="checkbox" id="h22_controle" name="h22_controle"<?php if($h22_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h22= $users1["h22"]; ?><?php echo $h22; ?></td><td><?php  echo $h22_service; ?></td>
		<td><?php echo $h22_client; ?></td><?php echo $h22_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td>
		<? }?>
		
		<? $h23_controle= $users1["h23_controle"]; if ($h23_controle==0){?>
		<tr><td><?php echo " - "; ?></td><td><?php $h23= $users1["h23"]; ?><?php echo $h23; ?></td><td><?php  echo $h23_service; ?></td>
		<td><?php echo $h23_client; ?></td><?php echo $h23_ref; ?></td>
		
		<td><?php  ?><input type="checkbox" id="h23_controle" name="h23_controle"<?php if($h23_controle) { echo " checked"; } ?>></td>
		<? }else {?>		
		<tr><td BGCOLOR="#FE9C03"><?php echo " - "; ?></td><td><?php $h23= $users1["h23"]; ?><?php echo $h23; ?></td><td><?php  echo $h23_service; ?></td>
		<td><?php echo $h23_client; ?></td><td><?php echo $h23_ref; ?></td>
		
		<td><?php  echo "VALIDE"; ?></td>
		<? }?>
		
		
		<script type="text/javascript">
$('#datetimepicker1').datetimepicker({
    format:'d-m-Y H:i',
});

$('#datetimepicker2').datetimepicker({
    format:'d-m-Y H:i',
});

</script>
		
</table>

<center>
<input type="hidden" id="id_journee" name="id_journee" value="<?php echo $_REQUEST["id_journee"]; ?>">
<input type="hidden" id="action_" name="action_" value="<?php $ajout="update_user";echo $ajout; ?>">
<input type="hidden" id="matricule" name="matricule" value="<?php echo $matricule; ?>">
<input type="hidden" id="date" name="date" value="<?php echo $date; ?>">
<input type="hidden" id="mois" name="mois" value="<?php echo $mois; ?>">
 <table class="table3"><tr>

<td><button type="button" onClick="CheckUser()"><?php echo Translate("Update"); ?></button></td>
<td style="width:20px"></td>
</form>

</body>

</html>