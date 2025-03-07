<?php
/* Replace the data in these two lines with data for your db connection */
$connection = mysql_connect("localhost","root","");  
mysql_select_db("mps2009",$connection);

if(isset($_GET['getClientId'])){  
  $res = mysql_query("select * from ajax_client where clientID='".$_GET['getClientId']."'") or die(mysql_error());
  if($inf = mysql_fetch_array($res)){
    echo "formObj.firstname.value = '".$inf["firstname"]."';\n";    
    echo "formObj.lastname.value = '".$inf["lastname"]."';\n";    
    echo "formObj.address.value = '".$inf["address"]."';\n";    
    echo "formObj.zipCode.value = '".$inf["zipCode"]."';\n";    
    echo "formObj.city.value = '".$inf["city"]."';\n";    
    echo "formObj.country.value = '".$inf["country"]."';\n";    
    
  }else{
    echo "formObj.firstname.value = '';\n";    
    echo "formObj.lastname.value = '';\n";    
    echo "formObj.address.value = '';\n";    
    echo "formObj.zipCode.value = '';\n";    
    echo "formObj.city.value = '';\n";    
    echo "formObj.country.value = '';\n";      
  }    
}
?> 