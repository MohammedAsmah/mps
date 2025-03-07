<?PHP 

//include class, create new Formitable, set primary key field name 
include("Formitable.class.php"); 
$newForm = new Formitable( mysql_connect("mysql5-1.business","datamjpmps","Marwane06"),"datamjpmps","formitable_demo " ); 

$newForm->setPrimaryKey("ID"); 

//call submit method if form has been submitted 
if( isset($_POST['submit']) ) $newForm->submitForm(); 

//otherwise continuing with form customizations 
else { 
     
    //retrieve a record for update if GET var set 
    if( isset($_GET['ID']) ) $newForm->getRecord($_GET['ID']); 
     
    //hide primary key field, force a few field types 
    $newForm->hideField("ID"); 
    $newForm->forceTypes(array("foods","day_of_week"),array("checkbox","radio")); 

    //get data pairs from another table 
    $newForm->normalizedField("toon","formitable_toons","ID","name","pkey ASC"); 
     
    //set custom field labels 
    $newForm->labelFields( array("f_name","l_name","description","pets","foods","color","day_of_week","b_day","toon"), 
                         array("First Name","Last Name","About Yourself","Your Pets","Favorite Foods","Favorite Color","Favorite Day","Your Birthday","Favorite Cartoon") ); 

    //output form 
    $newForm->printForm(); 

} 

?>