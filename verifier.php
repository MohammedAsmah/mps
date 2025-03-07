<?
//
// VERIFICATION EN LIVE DU PSEUDO
//

// CONNECION SQL
mysql_connect("localhost", "root", "");
mysql_select_db("mps2009");

// VERIFICATION
$result = mysql_query("SELECT produit FROM produits WHERE produit='".$_GET["produit"]."'");
if(mysql_num_rows($result)>=1)
echo "1";
else
echo "2";
?>

