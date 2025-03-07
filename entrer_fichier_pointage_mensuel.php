

	<form method="post" enctype="multipart/form-data" action="import_requete_pointage_mensuel.php">
	<table width="628" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#eeeeee">
    <? $d="";?>
	<tr>
      <td width="219"><font size=3><b>Selectionner votre fichier *.csv :</b></font></td>
      <td width="244" align="center"><input type="file" name="userfile" value="userfile"></td>
      <td width="244" align="center"><input type="text" name="debut" value="<? echo $d;?>"></td>
	  <td width="137" align="center">
        <input type="submit" value="Envoyer" name="envoyer">
      </td>
    </tr>
	</table>
	</form>





