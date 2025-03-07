<?php
include("include/phpgrid.php");

$hostName = "localhost";
$userName = "root";
$password = "";
$dbName	  = "phoebesoft";
?>
<html>
<head>
<title>phpGrid - Example 8</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php
$dg = new C_DataGrid($hostName, $userName, $password, $dbName);
 
$dg -> set_gridpath     ("include/");
$dg -> set_sql          ("SELECT * FROM Grid_Employees");
$dg -> set_sql_table    ("Grid_Employees");
$dg -> set_sql_key      ("EmployeeId");

// change column titles
$dg -> set_col_title    ("EmployeeId", "Employee ID");
$dg -> set_col_title    ("LastName", "Last Name");
$dg -> set_col_title    ("FirstName", "First Name");

// set background and mouse over color
$dg -> set_alt_bgcolor  ("#ffffff, #e9eff2");
$dg -> set_onmouseover  ("lightyellow");

// hide a column
$dg -> set_col_hidden   ("Notes");

// display URL as hyperlink
$dg -> set_col_link    ("ReportsTo",                         
						"/query.php?EmployeeId=",                         
						"EmployeeId",                         
						"target='_new'"); 

// set page size
$dg -> set_page_size(20);

// make the datagrid editable
$dg -> set_allow_actions(true);
$dg -> set_theme("royal");
$dg -> display();
?>

</body>
</html>
