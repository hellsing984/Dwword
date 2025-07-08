<?php
// Récupérer les données envoyées en POST
$voteType = $_POST['vote_type'] ?? null;
$choice = $_POST['choice'] ?? null;

if (!$voteType || !$choice) {
    http_response_code(400);
    echo "Données manquantes";
    exit;
}

// Fichier de stockage des votes
$file = 'votes.json';

// Lire les votes existants
if (file_exists($file)) {
    $votesData = json_decode(file_get_contents($file), true);
    if (!is_array($votesData)) {
        $votesData = [];
    }
} else {
    $votesData = [];
}

// Ajouter le nouveau vote (avec timestamp)
$votesData[] = [
    'vote_type' => $voteType,
    'choice' => $choice,
    'timestamp' => date('Y-m-d H:i:s')
];

// Enregistrer dans le fichier
file_put_contents($file, json_encode($votesData, JSON_PRETTY_PRINT));

// Rediriger ou afficher un message de succès
header('Location: index.html'); // adapter le nom de ta page principale
exit;
?>


