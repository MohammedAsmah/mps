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


<script>
function valider(){
  elt=document.forms['formSaisie'].elements['prenom'];
  if(elt.value != "") {
    return true;alert("Saisissez le pr�nom");
  }
  else {
    alert("Saisissez le pr�nom");
    return false;
  }
}
</script>




<form action="url_page_suivante" method="get" name="formSaisie">
  <p>
    <label for="prenom">Saisissez votre pr�nom :</label>
    <input type="text" name="prenom" id="prenom" onchange="return valider()" />
	<input type="text" name="nom" id="nom" onchange="return valider()" />
    <input type="submit" value="Ok" />
  </p>
</form>


<script type="text/javascript">
//<![CDATA[

function afficher(frm){
  alert("Vous avez tap� : " + frm.elements['prenom'].value)
}
//]]>
</script>

<form>
  <p>

    <label for="prenom">Saisissez votre pr�nom :</label>
    <input type="text" name="prenom" id="prenom" onChange="afficher(this.form)" />
    <input type="button" value="Afficher"  />
    <input type="submit" value="Ok" />

  </p>
</form>


