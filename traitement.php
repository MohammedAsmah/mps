

<?php

// --- On �crit un script JS pour qu'il soit interpr�t� dans l'objet
// --- XHR au retour du script
echo "alert('Valeur a enregistrer dans la base : ".$_POST["donnee"]."');";
// --- Mais on peut faire toute sorte de chose,
// --- Comme mettre � jour sa base de donn�e,
// --- s�lectionner dans la base et retourner des r�sultats pour mettre
// --- � jour graphiquement une interface, et ce, 
// --- sans le moindre rechargement de page que ce soit !

?>
