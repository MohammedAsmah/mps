

<?php

// --- On écrit un script JS pour qu'il soit interprété dans l'objet
// --- XHR au retour du script
echo "alert('Valeur a enregistrer dans la base : ".$_POST["donnee"]."');";
// --- Mais on peut faire toute sorte de chose,
// --- Comme mettre à jour sa base de donnée,
// --- sélectionner dans la base et retourner des résultats pour mettre
// --- à jour graphiquement une interface, et ce, 
// --- sans le moindre rechargement de page que ce soit !

?>
