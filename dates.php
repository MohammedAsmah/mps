<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Document sans titre</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?

function dateUsToFr ($datetime) {
        sscanf($datetime, "%4s-%2s-%2s", $y, $mo, $d);
        return $d.'/'.$mo.'/'.$y;
}

function dateFrToUs ($datetime) {
        sscanf($datetime, "%2s/%2s/%4s", $d, $mo, $y);
        return $y.'-'.$mo.'-'.$d;
}
$date='02/11/2006';
$date1='07/11/06';
$date2='2006-11-02';

echo dateFrToUs($date);echo"<br>";
echo dateFrToUs($date1); echo"<br>";
echo dateUsToFr($date2);echo"<br>";
?>

</body>
</html>
