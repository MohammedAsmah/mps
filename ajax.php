<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>AJAX</title>

<script type="text/javascript">
function writediv(texte)
{
document.getElementById('pseudobox').innerHTML = texte;
}

function verifPseudo(pseudo)
{
if(pseudo != '')
{
if(pseudo.length<2)
writediv('<span style="color:#cc0000"><b>'+pseudo+' :</b> ce pseudo est trop court</span>');
else if(pseudo.length>30)
writediv('<span style="color:#cc0000"><b>'+pseudo+' :</b> ce pseudo est trop long</span>');
else if(texte = file('verifpseudo.php?pseudo='+escape(pseudo)))
{
if(texte == 1)
writediv('<span style="color:#cc0000"><b>'+pseudo+' :</b> ce pseudo est deja pris</span>');
else if(texte == 2)
writediv('<span style="color:#1A7917"><b>'+pseudo+' :</b> ce pseudo est libre</span>');
else
writediv(texte);
}
}

}

function file(fichier)
{
if(window.XMLHttpRequest) // FIREFOX
xhr_object = new XMLHttpRequest();
else if(window.ActiveXObject) // IE
xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
else
return(false);
xhr_object.open("GET", fichier, false);
xhr_object.send(null);
if(xhr_object.readyState == 4) return(xhr_object.responseText);
else return(false);
}


function mysql_to_js($requete, $nomtabjs) {
	// Requ�te mysql
	$req = mysql_query($requete)
	or die('Erreur SQL !<br>'.$req.'<br>'.mysql_error());
	
	$taille = mysql_num_rows($req);
	// Ecriture de la d�claration du tableau javascript si la requ�te
	// contient quelque chose, sinon d�claration d'un tableau null.
	$numfields = mysql_num_fields($req);
	if($numfields > 0) {
		
		// D�claration de la variable tableau.
		echo("var ".$nomtabjs." = new Array(".$numfields.");\n");
		// D�claration des tableaux de valeurs pour chaque champs.
		for($i=0; $i<$numfields; $i++) {
			echo($nomtabjs."['".mysql_field_name($req, $i)."'] = new Array(".$taille.");\n");
		}
		
		if($taille>0) {
			// D�claration du reste des valeurs du r�sultat de la requ�te.
			$i=0;
			while($data = mysql_fetch_assoc($req)) {
				foreach($data as $key => $value) {
					echo($nomtabjs."['".mysql_escape_string($key)."'][".$i."] = '".mysql_escape_string($value)."';\n");
				}
				$i++;
			}
		}
	}
	else echo("var ".$nomtabjs." = null;\n");
}


</script>

</head>
<body>

<form action="">
<input type="text" name="pseudo" onKeyUp="verifPseudo(this.value)" />
<div id="pseudobox"></div>
</form>

</body>
</html>
