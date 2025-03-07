<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
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
               else if(texte = file('http://www.editeurjavascript.com/scripts/exemples/verifpseudo.php?pseudo='+escape(pseudo)))
                         {
          if(texte == 1)
               writediv('<span style="color:#cc0000"><b>'+pseudo+' :</b> ce pseudo est deja pris</span>');
          else if(texte == 2)
               writediv('<span style="color:#1A7917"><b>'+pseudo+' :</b> ce pseudo est libre</span>');
          else
               writediv('');
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
</script>


<head>
<title>AJAX</title>
</head>
<body>
<form action="">
<input type="text" name="pseudo" onKeyUp="verifPseudo(this.value)" />
<div id="pseudobox"></div>
</form>
</body>
</html>

