<?php
session_start();
$email = $_POST['email'] ?? null;

if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("E-mail invalide !");
}

// Connexion à ta base de données
$pdo = new PDO('mysql:host=localhost;dbname=kyudoalk2', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Vérifie si cet email a déjà voté pour cette catégorie
$type = $_POST['vote_type'] ?? '';
$stmt = $pdo->prepare("SELECT COUNT(*) FROM quizz_alk WHERE email = ? AND type_vote = ?");
$stmt->execute([$email, $type]);
$dejaVote = $stmt->fetchColumn() > 0;

if ($dejaVote) {
    die("Tu as déjà voté pour cette catégorie.");
}

// Ensuite, insérer le vote (à adapter selon ton système)
foreach ($_POST as $key => $value) {
    if (strpos($key, 'choice_') === 0) {
        $stmt = $pdo->prepare("INSERT INTO quizz_alk (email, type_vote, choix) VALUES (?, ?, ?)");
        $stmt->execute([$email, $type, $value]);
    }
}

echo "Merci pour ton vote !";

