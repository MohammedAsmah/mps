<?php
require ('../Metier/Machine.php');
require ('../Service/MachineService.php');
if(isset($_GET["ids"])){
    $MachineS = new MachineService();
    if($MachineS->deletefile($_GET["ids"])){
        unlink($_GET["chemin"]);
        header('location: searchforfile.php?id='.$_GET["id"].'&&idarticle='.$_GET["idarticle"]);
    }else{
        ?><script>window.close()</script><?php
    }
}

?>