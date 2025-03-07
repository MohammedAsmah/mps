

	<form method="post" enctype="multipart/form-data" action="import_requete_factures_rs.php">
	<table width="628" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#eeeeee">
    <tr>
      <td width="219"><font size=3><b>Selectionner votre fichier *.csv :</b></font></td>
      <td width="244" align="center"><input type="file" name="userfile" value="userfile"></td>
      <td width="137" align="center">
        <input type="submit" value="Envoyer" name="envoyer">
      </td>
    </tr>
	</table>
		<tr><? echo "<td><a href=\"\\mps\\tutorial\\edition_factures_rs.php\">Imprimer Factures</a></td>";?>

	</form>





