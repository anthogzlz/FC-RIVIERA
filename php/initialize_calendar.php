<?php
include './php/database.php';

// Exemple d'insertion de matchs dans la table calendrier avec des places disponibles
$matches = [
    ['id_match' => 1, 'match_name' => 'Match 1', 'places_dispos' => 100],
    ['id_match' => 2, 'match_name' => 'Match 2', 'places_dispos' => 100],
    ['id_match' => 3, 'match_name' => 'Match 3', 'places_dispos' => 100]
];

foreach ($matches as $match) {
    $stmt = $db->prepare("INSERT INTO calendrier (id_match, match_name, places_dispos) VALUES (?, ?, ?)");
    $stmt->execute([$match['id_match'], $match['match_name'], $match['places_dispos']]);
}

echo "Matchs insérés avec succès.";
?>
