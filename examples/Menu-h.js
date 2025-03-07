//************ Menu Principal ************//
Color0M  = '#FFFFFF' //Couleur du texte
Color1M  = '#000000' //Couleur Arrière
Color2M  = '#6699CC' //Couleur Arrière Surbrillance
Color3M  = '#FF00FF' //Couleur Bordure ????
PosY     = -20       //Distance entre le haut de l'écran et le menu
LargeurM = 110       //Largeur
HauteurM =  30       //Hauteur
AlignM   = 'center'  //'center','right','left'
FontM    = 'Verdana' //Police
SizeM    =  13       //Taille de la Police
WeightM  = 'bold'    //Epaisseur de la Police
CursorM  = 'default' //Curseur-> default,hand...

menu = new Array
i=0
//--------[Texte/Html]------------------[ Adresse ]--------------------------//
menu[i++]='HomePage'   ;menu[i++]='#'
menu[i++]='Actualités' ;menu[i++]='http://ActuFr.com'
menu[i++]='JavaScript' ;menu[i++]='http://www.javascriptfr.com'
menu[i++]='CPP'        ;menu[i++]='http://www.cppfrance.com'

//************ Sous-Menus ************//
Color0S  = '#FFFFFF' //Couleur du texte
Color1S  = '#555555' //Couleur Arrière
Color2S  = '#6699FF' //Couleur Arrière Surbrillance
Color3S  = '#FFFF00' //Couleur Bordure
EnLigne  =   0       //1:pour ranger sur une seule ligne  0:en colonne
LargeurS = 150       //Largeur
HauteurS =  20       //Hauteur
AlignS   = 'center'  //'center','right','left'
FontS    = 'Verdana' //Police
SizeS    =  10       //Taille de la Police
WeightS  = 'bold'    //Epaisseur de la Police
FonduS   =   1       //1:Fondu, 0:aucun
CursorS  = 'default' //Curseur-> default,hand...

k=-1; zlien=new Array

i=0; zlien[++k]=new Array
//------------[Texte/Html]------------------[ Adresse ]-------------------------------//
zlien[k][i++]='MultiDesk';zlien[k][i++]='http://multidesk.pass-x.com/'
i=0; zlien[++k]=new Array  //   Pas de Sous-Menus pour le menu principal 'Mon Compte'
//zlien[k][i++]='...'    ;zlien[k][i++]='http://...'
//zlien[k][i++]='...'    ;zlien[k][i++]='http://...'
i=0; zlien[++k]=new Array
zlien[k][i++]='Code'     ;zlien[k][i++]='http://www.javascriptfr.com/listecodes.aspx'
zlien[k][i++]='Forum'    ;zlien[k][i++]='http://www.javascriptfr.com/forum.v2.aspx'
zlien[k][i++]='Emploi'   ;zlien[k][i++]='http://www.javascriptfr.com/emploi.aspx'
i=0; zlien[++k]=new Array
zlien[k][i++]='Code'     ;zlien[k][i++]='http://www.cppfrance.com/listecodes.aspx'
zlien[k][i++]='Forum'    ;zlien[k][i++]='http://www.cppfrance.com/forum.v2.aspx'
zlien[k][i++]='Emploi'   ;zlien[k][i++]='http://www.cppfrance.com/emploi.aspx'
zlien[k][i++]='Livres'   ;zlien[k][i++]='http://www.cppfrance.com/500.aspx?aspxerrorpath=/livres.aspx'

//************ Fin des paramètres, Début du programme ************//
document.write('<style>')
document.write('.ejmenu  {background:'+Color1M+';text-align:'+AlignM+';font:'+WeightM+' '+SizeM+' '+FontM+';color:'+Color0M+';cursor:'+CursorM+'}')
document.write('.ejsmenu {background:'+Color1S+';text-align:'+AlignS+';font:'+WeightS+' '+SizeS+' '+FontS+';color:'+Color0S+';cursor:'+CursorS+'}')
document.write('</style>')

function fadeIn(obj)
{ obj.style.filter="blendTrans(duration=1)"
  if(obj.filters.blendTrans.status!=1)
  { obj.filters.blendTrans.Apply()
    obj.style.visibility="visible"
    obj.filters.blendTrans.Play()
  }
}

document.onclick     = function() { skn.visibility='hidden' }
document.onmousemove = function() { dgt.top=document.body.scrollTop+PosY; dgt.visibility='visible' }
window.onscroll      = function() { dgt.visibility=skn.visibility='hidden' }

function pop(msg,pos)
{ skn.visibility="hidden"
  skn.top=document.body.scrollTop+PosY+HauteurM
  if(!msg.length) return
  if(EnLigne)
  { content="<TABLE style='border-collapse:collapse;'WIDTH="+LargeurM*menu.length/2+" bordercolor="+Color3S+" BORDER=1><TR>"
    for(pass=0;pass<msg.length;pass+=2) content+="<TD onMouseDown='location.href=\""+msg[pass+1]+"\"' onMouseOver=\"this.style.background='"+Color2S+"'\" onMouseOut=\"this.style.background='"+Color1S+"'\" HEIGHT="+HauteurS+" CLASS=ejsmenu>"+msg[pass]+"</TD>"
  } else
  { skn.left=pos-1
    content="<TABLE style='border-collapse:collapse;'WIDTH="+LargeurS+" bordercolor="+Color3S+" BORDER=1>"    
    for(pass=0;pass<msg.length;pass+=2) content+="<TR><TD WIDTH="+LargeurS+" onMouseDown='location.href=\""+msg[pass+1]+"\"' onMouseOver=\"this.style.background='"+Color2S+"'\" onMouseOut=\"this.style.background='"+Color1S+"'\" HEIGHT="+HauteurS+" CLASS=ejsmenu>"+msg[pass]+"</TD></TR>"
  }
  document.getElementById("topdeck").innerHTML=content+"</TR></TABLE>"
  if(document.all && FonduS)  fadeIn(topdeck); else skn.visibility="visible";
}

document.write('<DIV style="position:relative"><DIV style="POSITION:absolute;VISIBILITY:hidden;z-index:15" id=topdeck></DIV><TABLE ID=topmenu style="position:absolute;border-collapse:collapse;" bordercolor='+Color3M+' BORDER=1 WIDTH='+LargeurM*menu.length/2 +' HEIGHT='+HauteurM+'><tr>')
skn=document.getElementById('topdeck').style
dgt=document.getElementById('topmenu').style
for(pass=0;pass<menu.length/2;pass++) document.write("<TD WIDTH="+LargeurM+" onMouseDown='location.href=\""+menu[pass*2+1]+"\"' onMouseOver='this.style.background=\""+Color2M+"\";pop(zlien["+pass+"],this.offsetLeft)' onMouseOut='this.style.background=\""+Color1M+"\"' CLASS=ejmenu>"+menu[pass*2]+"</TD>")
document.write('</TR></TABLE></DIV>')
dgt.top=document.body.scrollTop+PosY