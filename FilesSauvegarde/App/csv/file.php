<?php
    require('../../Metier/Machine.php');
    require('../../Service/MachineService.php');
    $machine = new MachineService();

    $row = 1;
    if (($handle = fopen("lsmachine.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle)) !== FALSE) {
            $num = count($data);

            $row++;
            for ($c=0; $c < $num; $c++) {
                $details = explode(";",$data[$c]);
                echo "<br>";
                echo $details[0];
               //$machine->addmachinecsv($details[0]);
                if($details[0] != null){
                    $machine->addmachinecsv($details[0]);
                }
            }
        }
        fclose($handle);
    }
?>