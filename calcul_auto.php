<html>
<head>
<script type="text/javascript">
function calcul(){
                var prix = Number(document.getElementById("heuresI").value);
 
                var quantite = Number(document.getElementById("txhoraire").value);
 
                var ttc = Number(prix * quantite);
                document.getElementById("ttc").value = ttc;
				alert("test");
            }
 
</script>
</head>
<body>
<form name="fact">
 
<label>heures :</label><input type="text" SIZE="1" name="heuresI" id="heuresI" onblur="calcul()">
<label>Taux horaire TTC :</label><input type="text" SIZE="1" name="txhoraire" id="txhoraire" onblur="calcul()" >
 
 
		<label>Total facture TTC :</label><input type="text" SIZE="33" STYLE="text-decoration:none;;color: #FF0000;" name="ttc" id="ttc"><br/><br/>		
 
 
<label>Mode de paiment :</label><select name="mode">
		<option value="cheque"> Cheque</option>
			</select><br/><br/>		
<label><input type="submit" value="Enregistrer" name="recfacture"></label><br><br>
</form>
</body>
</html>