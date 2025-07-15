<?php
// Paramètres de connexion
$host = 'localhost';
$dbname = 'hunter_vote'; // nom de la base que tu as créée
$username = 'root';      // identifiant par défaut sous WAMP/XAMPP
$password = '';          // mot de passe vide par défaut

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
