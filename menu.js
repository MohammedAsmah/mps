<!--// Michel Deboom septembre 2004 menu largeur auto,flèches txt
var delai,menu,pos,cl,dul,db,pause=1500;D=document;ctl=wul1=fix=decal=0;opt=1
ie=D.all?1:0;op=window.opera?1:0;strict= D.compatMode=="CSS1Compat"?1:0;

// paramétrage :
var id_menu='menu'
var cl1="mh";// style du menu : "mh" = horizontal; "mn" = vertical; "vd" vertical à droite
// flèches pour niveau horizontal, vertical ou vertical à droite
var flh='...'; var flg='&#8250;'; var fld='&#8249;';
var flc=8 ;// espace pour la flèche
//correction bug padding+border ie et opéra non strict 
var da=10 // des liens
var dul=(ie&!strict)?4:0; // des ul
var danc=(ie&!strict)?10:0;// hauteur du div "ancre_menu"
var code="chmel2" // code personnalisé  à remplacer par le votre
var pos1="a";// "a" = menu ancré ; "f" = fixe
// couleurs :
var ahover = "#FFF"; var fondhover = "green" // des liens survolés
var asuivi = "green"; var fondsuivi = "#e5fff0" // des liens suivis
var fondmenu0 = "#dac6ff"
var fondmenu1 = "#ffe263" // sous-menus

// On stocke dans window.name les paramètres utilisateur style et position.
if (window.name.substr(3,code.length)==code) {classe=window.name.substr(0,2);pos=window.name.substr(2,1)}
else {classe=cl1;pos=pos1;window.name=cl1+pos1+code;}

window.onload=function(){initMenu()};

// Feuille de style
//niveau 0
css='<style type="text\/css">\/*<![CDATA[*\/'
// les liens
css+='.mn a,.mh a,.vd a{display:block;margin:0;padding:2px '+da/2+'px;'
css+='  text-decoration:none;line-height:1.1em; }'
css+='#menu a:hover,#menu a:active, #menu a:focus{'
css+=' background-color:'+fondhover+';border:2px inset;padding:0 3px;color:'+ahover+';}'

//général :
css+='#menu li{display:inline;} '/* bug IE */
css+='.mh li{float:left;}'
css+='.mh{;height:1.5em}'
css+='.vd{text-align:right;right:1.2em;}'/*marge du body*/
css+='.mn,.mn ul,.mh,.mh ul,.vd,.vd ul{position:absolute;margin:0;padding:0;'
css+='  border:2px outset #DDF4EC; background-color:'+fondmenu0+';z-index:9}'

// le div ancre_menu :
css+='#ancre_menu {padding:.5em .5em 0 0;margin:0;}'
css+='.anc_mh{float:none}'
css+='.anc_mn{float:left}'
css+='.anc_vd{float:right;}'

/*1er niveau*/
css+='.mh li li{float:none;}' 
css+='#menu ul{visibility:hidden;background-color:'+fondmenu1+';}'
css+='.mh ul{margin-top:.4em}'
css+='.vd ul,.mn ul{margin-top:-1.5em}'

/* 2éme niveau et suivants */
css+='.mh ul ul { margin-top:-1.5em;}'

/* les flèches */
css+='.fh,.fl{font-size:80%;color:red;}'
css+='.fl{position:absolute;}'
css+='a:hover .fl,a:active .fl,a:focus .fl,a:hover .fh,a:active .fh,a:focus .fh{color:'+ahover+';}'
css+='.suivi{background-color:'+fondsuivi+';} '    /* couleur du suivi */
css+='.suivi,.suivi .fl,.suivi .fh{color:'+asuivi+'}'
css+='\/*]]>*\/<\/style>'

function initMenu(){
  de=ie&!op&&strict?D.documentElement:D.body //exception IE6 strict
  fx=ie&!op?de.clientWidth:innerWidth-20  //l fenêtre
  menu=D.getElementById(id_menu);
  wul=[] // tableau des largeurs de sous-menus
  as=menu.getElementsByTagName('a');
  sousMenu=menu.getElementsByTagName('ul');
  elem=document.getElementsByTagName('select');
  
  // ajoute a href="#" dans les li sans lien .
  lis=menu.getElementsByTagName('li');
  for(i=0;i<lis.length;i++){var L=lis[i];var A=D.createElement('a');
    A.innerHTML=L.firstChild.nodeValue;A.setAttribute("href","#");
    if(L.firstChild.tagName!="A"){L.replaceChild(A,L.firstChild);
    }
  }
  //ajoute un id aux sousMenu du menu
 	for(j=0;j<sousMenu.length;j++){sousMenu[j].id="ul"+j;wul[j]=0
  }
  //construction du menu :
	for(i=0;i<as.length;i++){
    lien=as[i];wa=lien.offsetWidth;
    //lien vers sous-menu 
    smenu=lien.parentNode.getElementsByTagName('ul')[0]?1:0;
   	if (smenu){
      fl=D.createElement("div");fl.className="fl";/*flèches*/
      wa+=flc;lien.onmouseover=lien.onfocus=af_a;lien.appendChild(fl)
      }
    // 1er niveau horizontal 
    if(lien.parentNode.parentNode.id==id_menu){
      if(classe=="mh"){ if(smenu&&lien.innerHTML!="")lien.innerHTML+=flh;
        wa=lien.offsetWidth;wul1+=wa+da;     
        }            
      else { // vertical
        if(wa>wul1){wul1=wa+da;};config_v()
      }
    }
    //autres niveaux verticaux
    else {
      n=eval(lien.parentNode.parentNode.id.substr(2,2));
      if(wa>wul[n]){wul[n]=wa;};config_v()
    }
    //ajoute les évènements.
		lien.onmouseover=lien.onfocus=af_a; lien.onmouseout=ef_delai;
  }

  //fixe la largeur du 1er menu :
  if(wul1)menu.style.width=wul1+dul+"px";

  //largeur des sous-menu verticaux et de leurs liens :
  for(var x=0;x<wul.length;x++){
    ula=sousMenu[x].getElementsByTagName('a');dda=(ie&!strict)?da:0;
    for(var i=0;i<ula.length;i++){ula[i].style.width=wul[x]+dda+"px";
    }
  sousMenu[x].style.width=wul[x]+da+dul+"px";
  }
  lien.onblur=D.onclick=eftout // pour navigation clavier IE
  menu.className=classe; //activation retardée de la feuille de style

  // replace les flèches des menus verticaux au bons endroits.
  span = menu.getElementsByTagName('span');
	for(i=0;i<span.length;i++){A=span[i].parentNode;c=span[i].style;
    if(span[i].className=="fl"){
      c.top=A.offsetTop+2+"px";c.left=(classe=="vd")?4+"px":A.offsetWidth-8+"px";
    }
  }
  if(opt){(pos=="a")?ancremenu():initFix();}
}

function config_v(){ // ajoute les fléches aux items verticaux
  if(smenu)lien.innerHTML=(classe=="vd")?'<span class="fl">'+fld+'</span>'+lien.innerHTML:
  lien.innerHTML+'<span class="fl">'+flg+'</span>&nbsp;';
}

function initFix(){
  with(menu.style){top=-200+"px";zIndex="10";visibility="hidden";
    if(classe=="vd"){right=0;margin=0} else left=0;
  }
  // flèche toujours présente
  ancre=D.createElement("div");D.body.appendChild(ancre);
  ancre.innerHTML=(classe=="vd")?"&nbsp; "+fld+"&nbsp;":"&nbsp;"+flg+" &nbsp;";
  with(ancre.style){top=0;position="absolute";color="red";display="block";
   (classe=="vd")?right=0:left=0;
  }
  ancre.onmouseover=ancre.onfocus=function(){menu.style.visibility="visible";
  }
  fix=1;fixmenu()
}
function fixmenu(){
  sy=ie?db.scrollTop:pageYOffset;y=menu.offsetTop;dy=y-sy;y=sy+parseInt(dy*.9);
  if(dy!=0){voirSelect('hidden');menu.style.visibility="visible"}
  else if(ctl==0){voirSelect('visible');menu.style.visibility="hidden";}
  menu.style.top=ancre.style.top=y+"px";setTimeout('fixmenu()',20);
}
function ancremenu(){ancre=D.getElementById('ancre_menu');
  if(ancre){
  ancre.appendChild(menu);ancre.className="anc_"+classe;
  with(ancre.style){
    height=menu.offsetHeight+danc+'px';width=menu.offsetWidth+dul+'px';
    }
  }
  else initFix();
}
function chgStyle(){
cl1=D.getElementById('sty').value;pos1=D.getElementById('pos').value;
if(cl1==classe&&pos1==pos){alert("SVP changez au moins un champs !")}
else window.name=cl1+pos1+code;location.reload();
}

function af_a(){ctl=1;
ul_parent=this.parentNode.parentNode;
ul=this.parentNode.getElementsByTagName('ul')[0];
ef(ul_parent); // cache tout après l'ul parent
if(ul){ul.style.visibility="visible";// montre l'ul enfant
  (classe=="vd")?ul.style.right="100%":
  (classe=="mh"&&ul_parent.id!=id_menu)||(classe=="mn")?ul.style.left="100%":0;
  this.className="suivi"; // marquage du suivi de lien 
  voirSelect('hidden'); 
  }
}

function ef(ul) { //cache les uls qui suivent cet ul.
  clearTimeout(delai);
  var li=ul.getElementsByTagName('li');
  for(i=0;i<li.length;i++){
    var ul=li[i].getElementsByTagName('ul')[0];
    if(ul){ul.style.visibility="hidden";
      li[i].firstChild.className=""; //rétabli le marquage initial
}}}

function eftout(){ef(menu);decal=0;
if(fix){ctl=0;menu.style.visibility="hidden";
//if(window.Event)menu.style.top=sy-1+"px"/*bug NS7 Moz1*/;
  } 
voirSelect('visible');
}

function ef_delai(){delai=setTimeout('eftout()',pause);
}

// bug ie corrigé : cache les <select> quand le menu est visible
function voirSelect(v){
if(ie&!op){for(i=0;i<elem.length;i++)elem[i].style.visibility=v;}
}
D.write(css) // écrit la feuille de style
//-->