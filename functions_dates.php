<?php

	

function dateUsToFr ($datetime) {
        sscanf($datetime, "%4s-%2s-%2s", $y, $mo, $d);
        return $d.'/'.$mo.'/'.$y;
}

function dateFrToUs ($datetime) {
        sscanf($datetime, "%2s/%2s/%4s", $d, $mo, $y);
        return $y.'-'.$mo.'-'.$d;
}
function dateUsToFr1 ($datetime) {
        sscanf($datetime, "%2s-%2s-%2s", $y, $mo, $d);
        return $d.'/'.$mo.'/'."20".$y;
}

function dateFrToUs1 ($datetime) {
        sscanf($datetime, "%2s/%2s/%2s", $d, $mo, $y);
        return "20".$y.'-'.$mo.'-'.$d;
}

?>