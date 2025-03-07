<?php
session_start();
//unset($_SESSION["test"]);
session_destroy();
header('location: login.php');
?>