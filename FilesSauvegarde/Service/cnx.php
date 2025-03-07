<?php
class  connexion {
    private $db;
    function __construct()
    {
        $username = "datamjpbase21";
        $password="Marwane2006Z";

        $dsname="mysql:host=datamjpbase21.mysql.db;dbname=datamjpbase21";
        try{
            $this -> db = new PDO($dsname,$username,$password);

        }catch (PDOException $e){
            echo  "Error database ".$e->getMessage();
        }
    }
    function getdb(){
        return $this ->db;
    }

}
?>