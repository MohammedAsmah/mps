<?php
require ('../Metier/Machine.php');
require ('../Service/MachineService.php');
if(isset($_GET["id"])){
    $MachineS = new MachineService();
    if($MachineS->deletearticle($_GET["id"])){
        header('location: listearticle.php?delete=ok');
    }else{
        header('location: listearticle.php?delete=non');
    }
}

?>