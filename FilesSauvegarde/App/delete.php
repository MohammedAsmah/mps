<?php
require ('../Metier/Machine.php');
require ('../Service/MachineService.php');
if(isset($_GET["id"])){
    $MachineS = new MachineService();
    if($MachineS->delete($_GET["id"])){
        header('location: index.php?delete=ok');
    }else{
        header('location: index.php?delete=non');
    }
}

?>