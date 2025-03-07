<?php

require_once('ripcord.php');
// Odoo server credentials
$odoo_url = 'http://51.38.114.78:8069';  // URL of your Odoo server
$db = 'mps_jaouda_erp';                  // Odoo database name
$username = 'abdelaali.jabbour@gmail.com';                 // Odoo username
$password = 'odoo@mps';                 // Odoo password
$emparray = array();
$url = 'http://51.38.114.78:8069';
$db = 'mps_jaouda_erp';
$username = 'abdelaali.jabbour@gmail.com';
$password = 'odoo@mps';

require_once('ripcord.php');

$common = ripcord::client($url.'/xmlrpc/2/common');
$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");
$partners = $models->execute_kw(
    $db,
    $uid,
    $password,
    'res.partner',
    'search',
    array(
        array(
            array('is_company', '=', true)
            
        )
    )
);

echo('RESULT:<br/>');
foreach ($partners as $partner) {
    echo $partner.'<br/>';
}

$customer_ids = $models->execute_kw(
    $db, // DB name
    $uid, // User id, user login name won't work here
    $password, // User password
    'hr.employee', // Model name
    'search', // Function name
    array( // Search domain
        array( // Search domain conditions
            array('active', '=', true)) // Query condition
        )
 );

$customers = $models->execute_kw($db, $uid, $password, 'hr.employee',
    'read',  // Function name
    array($customer_ids), // An array of record ids
    array('fields'=>array('name')) // Array of wanted fields
);
echo ("<p><strong>Found customers:</strong><br/>");
foreach ($customers as &$customer){
    echo ("{$customer[name]}<br/>");
	$emparray[] = $customer;
}
echo ("</p>");
echo json_encode($emparray);

/*

// XML-RPC endpoints for Odoo
$common_url = "$odoo_url/xmlrpc/2/common";
$object_url = "$odoo_url/xmlrpc/2/object";
//$common_url->version();

// Function to make XML-RPC requests
function xmlrpc_request($url, $method, $params) {
    $request = xmlrpc_encode_request($method, $params);
    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: text/xml",
            'content' => $request
        ]
    ]);
    $file = file_get_contents($url, false, $context);
    return xmlrpc_decode($file);
}

// Step 1: Authenticate to get the User ID
$uid = xmlrpc_request($common_url, 'authenticate', [$db, $username, $password, []]);

if (!$uid) {
    die("Authentication failed");
}


$ids = $models->execute_kw($db, $uid, $password, 'res.partner', 'search', array(array(array('is_company', '=', true))), array('limit'=>1));
$records = $models->execute_kw($db, $uid, $password, 'res.partner', 'read', array($ids));
// count the number of fields fetched by default
$cp=count($records[0]);
echo $cp;

*/



// Step 2: Search and read records from a specific model (e.g., 'res.partner')
/*$model = 'res.partner';
$domain = [['city', '=', 'MARRAKECH']];  // Example: only retrieve companies
$fields = ['name', 'email', 'phone'];   // Fields to fetch
$params = [$db, $uid, $password, $model, 'search_read',$domain,['fields' => $fields, 'limit' => 5]];

// Fetch the records
$records = xmlrpc_request($object_url, 'execute_kw', $params);
echo $records;
if (is_array($records)) {
    // Display the records
    foreach ($records as $record) {
        echo "<tr><td> " . $record['name'] . "</td>";
        echo "<td> " . $record['work_email'] . "</td>";
        echo "<td> " . $record['phone'] . "</td></tr>";
        
    }
} else {
    echo "Failed to fetch records.\n";
}*/

?>