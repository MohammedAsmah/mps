<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content=
    "text/html; charset=us-ascii" />
    <title>
     Dom
    </title>
  </head>
  <body>
		<div id="test"></div>
		<script>
		 var balise=document.getElementById("test");
		  var balise1=document.getElementById("test1");
		 var baliseInput=document.createElement("input");
		 baliseInput.setAttribute("type","text");
		 baliseInput.setAttribute("value","Nom");
		 baliseInput.setAttribute("id","monNom");
		 var baliseInput1=document.createElement("input");
		 baliseInput1.setAttribute("type","text");
		 baliseInput1.setAttribute("value","Nom1");
		 baliseInput1.setAttribute("id","monNom1");
		 
		 var texteDiv = document.createTextNode("Recuperer input");
		 var baliseDiv=document.createElement("div");
		 addEvent( baliseDiv,'change', recuperer );
		 baliseDiv.appendChild(texteDiv);
		 
		 balise.appendChild(baliseInput);
		 balise.appendChild(baliseDiv);
		 balise1.appendChild(baliseInput);
		 balise1.appendChild(baliseDiv);
		 
		 function recuperer()
		 {
		  var baliseInput=document.getElementById("monNom");
		  var baliseInput1=document.getElementById("monNom1");
			var valeurInput=baliseInput.value;
			alert(valeurInput);
			
		 }
		 
		 
     function addEvent( obj, type, fn ) 
		 {
      if ( obj.attachEvent ) 
			{
       obj['e'+type+fn] = fn;
       obj[type+fn] = function(){obj['e'+type+fn]( window.event );}
       obj.attachEvent( 'on'+type, obj[type+fn] );
      } 
			else
			{
       obj.addEventListener( type, fn, false );
      }
		 }
     function removeEvent( obj, type, fn ) 
		 {
      if ( obj.detachEvent ) 
			{
       obj.detachEvent( 'on'+type, obj[type+fn] );
       obj[type+fn] = null;
      } 
			else
			{
       obj.removeEventListener( type, fn, false );
			}
     }
		</script>
  </body>
</html>
