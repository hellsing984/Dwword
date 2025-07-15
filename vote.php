<?php
require 'db.php';

$email = trim($_POST['email'] ?? '');
$voteType = $_POST['vote_type'] ?? '';
$choices = array_filter($_POST, function ($key) {
    return strpos($key, 'choice_') === 0;
}, ARRAY_FILTER_USE_KEY);

if (empty($email) || empty($voteType) || empty($choices)) {
    http_response_code(400);
    echo "❌ Tous les champs sont requis.";
    exit;
}

// Insère l'email validé dans la table voters (uniquement s'il n'existe pas déjà)
$stmt = $pdo->prepare("INSERT IGNORE INTO voters (email) VALUES (?)");
$stmt->execute([$email]);

// Vérifie si l'utilisateur a déjà voté pour ce type
$stmt = $pdo->prepare("SELECT COUNT(*) FROM votes WHERE email = ? AND vote_type = ?");
$stmt->execute([$email, $voteType]);
if ($stmt->fetchColumn() > 0) {
    echo "⚠️ Votre vote a étes pris en charge  : " . htmlspecialchars($voteType);
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO votes (email, vote_type, category_label, selected_image, voted_at)
    VALUES (?, ?, ?, ?, NOW())
");

foreach ($choices as $value) {
    list($categoryLabel, $selectedImage) = explode('|', $value);
    $stmt->execute([$email, $voteType, $categoryLabel, $selectedImage]);
}

header("Location: index.php");
exit;
?>
