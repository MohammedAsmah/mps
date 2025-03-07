<?php

$servername = "datamjpmps.mysql.db";
$username = "datamjpmps";
$password = "Marwane06";
$dbname = "datamjpmps";
$table = "Employees";

$action = $_POST["action"];
//$action = "CREATE_TABLE";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error){
	die("Connection failed: " . $conn->connect_error);
}

if ("CREATE_TABLE" == $action) {
	$sql = "CREATE TABLE IF NOT EXISTS $table (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	first_name VARCHAR(30) NOT NULL, last_name VARCHAR(30) NOT NULL)";

	if($conn->query($sql) == TRUE){
		echo "success";
	}else
	{
		echo "error";
	}
	$conn->close();
	return;
}

////////////////////
if ("GET_ALL" == $action){
	$db_data = "SELECT id,first_name, last_name from $table ORDER BY id DESC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0 ){
		while($row = $result->fetch_assoc()){
			$db_data[] = $row;
		}
		echo json_encode($db_data);
	}else{
		echo "error";
	}
	$conn->close();
	return;
}

////////////////
if("ADD_EMP" == $action){
	$first_name = $_POST["first_name"];
	$last_name = $_POST["last_name"];
	$sql = "INSERT INTO $table (first_name, last_name) VALUES ('$first_name', '$last_name')";
	$result = $conn->query($sql);
	if($conn->query($sql) == TRUE){
		echo "success";
	}else
	{
		echo "error";
	}
	$conn->close();
	return;
}

///////////////////
if("UPDATE_EMP" == $action){
	$emp_id = $_POST['$emp_id'];
	$first_name = $_POST["first_name"];
	$last_name = $_POST["last_name"];
	$sql = "UPDATE $table SET first_name = '$first_name', last_name = '$last_name' WHERE id = '$emp_id'";
	$result = $conn->query($sql);
	if($conn->query($sql) == TRUE){
		echo "success";
	}else
	{
		echo "error";
	}
	$conn->close();
	return;
}

if("DELETE_EMP" == $action){
	$emp_id = $_POST['$emp_id'];
	$first_name = $_POST["first_name"];
	$last_name = $_POST["last_name"];
	$sql = "DELETE FROM $table WHERE id = $emp_id";
	$result = $conn->query($sql);
	if($conn->query($sql) == TRUE){
		echo "success";
	}else
	{
		echo "error";
	}
	$conn->close();
	return;
}

