<?php

require "connect_db_gpt.php";

$montant_cible = 11000.00; // Le montant cible de la facture

// Initialisation du montant total de la facture
$montant_facture = 0.00;

// Tableau pour stocker les produits sélectionnés
$produits_facture = [];

// Fonction pour obtenir un produit aléatoire
$article="article";
function getProduitAleatoire($pdo) {
    $sql = "SELECT * FROM produits where dispo=1 and dispo_stock=1 and facturation = 0 and famille='$article' and fictif=0 ORDER BY RAND() LIMIT 1";
    $stmt = $pdo->query($sql);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Ajouter des produits jusqu'à atteindre le montant cible
while ($montant_facture < $montant_cible) {
    $produit = getProduitAleatoire($pdo);$qte=rand(1,100);
    $montant_facture += $produit['prix']*$produit['condit']*$qte;
    $produits_facture[] = $produit;
}

// Afficher les produits ajoutés à la facture
echo "Facture générée :<br>";
foreach ($produits_facture as $produit) {
    echo "Produit: " . $produit['produit'] . " | Prix: " . $produit['prix'] . "€<br>";
}

echo "<br><strong>Montant total de la facture : " . number_format($montant_facture, 2) . "€</strong>";
?>
