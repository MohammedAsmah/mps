<?php
/* Replace the data in these two lines with data for your db connection */
$connection = mysql_connect("localhost","root","");  
mysql_select_db("mps2009",$connection);

if(isset($_GET['getClientId'])){  
  $res = mysql_query("select * from produits where produit='".$_GET['getClientId']."'") or die(mysql_error());
  if($inf = mysql_fetch_array($res)){
    echo "formObj.condit.value = '".$inf["condit"]."';\n";    
    echo "formObj.prix.value = '".$inf["prix"]."';\n";    
        
  }else{
    echo "formObj.condit.value = '';\n";    
    echo "formObj.prix.value = '';\n";    
    
  }    
}
?> 