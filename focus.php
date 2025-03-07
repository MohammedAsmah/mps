<!DOCTYPE html> 
<html> 

<head> 
	<title>Set focus to the first form field</title> 
</head> 

<body> 
	<h1> 
		<center>Welcome to GFG</center> 
	</h1> 
	<center> 
		<form id="Form" action="./js/filehandling.js" method="post">
   <input id="here" maxlength="13" placeholder="scan..." type="text" tabindex="1" required autofocus>
   <input id="subHere" type="submit">
</form>
<script src="https://code.jquery.com/jquery-2.2.4.js"></script>

<script>
  $('#here').keyup(function(){
      if(this.value.length ==13){
      $('#subHere').click();
      }
  });
</script>
	</center> 
</body> 

</html> 
