<script>
  
  
  
  var l1    = f.elements["list1"];   
2 var l2    = f.elements["list2"];   
3 var index = l1.selectedIndex;   
4 if(index < 1)   
5    l2.options.length = 0;   
6 else {   
7    var xhr_object = null;   
8        
9    if(window.XMLHttpRequest) // Firefox   
10       xhr_object = new XMLHttpRequest();   
11    else if(window.ActiveXObject) // Internet Explorer   
12       xhr_object = new ActiveXObject("Microsoft.XMLHTTP");   
13    else { // XMLHttpRequest non supporté par le navigateur   
14       alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");   
15       return;   
16    }   
17   
18    xhr_object.open("POST", "species.php", true);   
19        
20    xhr_object.onreadystatechange = function() {   
21       if(xhr_object.readyState == 4)   
22          eval(xhr_object.responseText);   
23    }   
24   
25    xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded");   
26    var data = "family="+escape(l1.options[index].value)+"&form="+f.name+"&select=list2";   
27    xhr_object.send(data);   
28 }  
</script>

 
