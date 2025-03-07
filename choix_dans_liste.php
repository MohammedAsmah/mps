<HTML><HEAD>
<script type="text/javascript">
<!--
/*
Script téléchargé du Coin Web de QuentinC
http://www.quentinc.net/

Nom du script : Liste avec recherche clavier

Catégorie : Formulaires
Date de dernière modification : Lundi 23 janvier 2006 15:30
URL exact : /javascript/script39-liste-avec-recherche-clavier/

Vous trouverez d'autres scripts à l'adresse : 
http://www.quentinc.net/javascript/

© 2002-2006, QuentinC
Vous pouvez utiliser, modifier et redistribuer ce script, à condition de laisser les présents commentaires intacts, et de ne pas l'utiliser à des fins commerciales.
*/
var timer = null;
var chaine
= "";
function startsWith (str1, str2) {
var k = str1.substring(0, str2.length);
return (str2.toLowerCase() == k.toLowerCase());
}
function
liDown (list) {

var c = event.keyCode;
if (c < 48 && c!=32) return true;

var s = String.fromCharCode(c);
chaine += s;
var n = list.selectedIndex;
var
ok = false;

if (chaine.length > 1 && startsWith(list.options[n].text, chaine)) ok=true;

for (var i=n+1; i < list.options.length && !ok; i++)
{
if (startsWith(list.options[i].text, chaine)) { n = i; ok = true; }
}
for (var i=0; i < n && !ok; i++) {
if (startsWith(list.options[i].text,
chaine)) { n = i; ok = true; }
}
list.selectedIndex = n;


if (timer!=null) clearTimeout(timer);
timer = setTimeout("clearChaine();",
5000);
return false;
}
function clearChaine () { chaine=""; }

// -->
</script>
</head>
<body>
<form>
<select onkeydown="return liDown(this);">
<option>Argent</option>
<option>Beige</option>
<option>Blanc</option>
<option>Blanc
cassé</option>
<option>Bleu</option>
<option>Brun</option>
<option>Cramoisi</option>
<option>Cyan</option>
<option>Gris clair</option>
<option>Gris
foncé</option>
<option>Jaune</option>
<option>Magenta</option>
<option>Noir</option>
<option>Olive</option>
<option>Or</option>
<option>Orange</option>
<option>Rose</option>
<option>Rouge</option>
<option>Vert</option>
<option>Violet</option>
</select>
</form>
</body>
</html>
