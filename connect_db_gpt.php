<?php
$host = 'datamjpmps.mysql.db'; // Votre hôte, généralement localhost
$dbname = 'datamjpmps'; // Le nom de votre base de données
$username = 'datamjpmps'; // Votre utilisateur MySQL
$password = 'Marwane06'; // Votre mot de passe MySQL

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}
?>
