<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit();
}

include 'database.php';

$stmt_matches = $db->prepare("SELECT id_match, match_name, places_dispo FROM calendrier WHERE home_team = ?");
$stmt_matches->execute([3]); 
$matches = $stmt_matches->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_match = $_POST['match'];
    $id_user = $_SESSION['user']['id_user']; 
    $places_reserves = $_POST['places'];

    if ($places_reserves > 8) {
        echo "Erreur : Vous ne pouvez réserver que 8 places au maximum.";
        exit();
    }

    $stmt_check = $db->prepare("SELECT places_dispo FROM calendrier WHERE id_match = ?");
    $stmt_check->execute([$id_match]);
    $match = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if ($match) {
        $places_dispo = $match['places_dispo'];
        if ($places_reserves > $places_dispo) {
            echo "Erreur : il n'y a pas assez de places disponibles.";
            exit();
        }

        $stmt = $db->prepare("INSERT INTO reservations (id_match, id_user, places_prises) VALUES (?, ?, ?)");
        $stmt->execute([$id_match, $id_user, $places_reserves]);

        $stmt_update = $db->prepare("UPDATE calendrier SET places_dispo = places_dispo - ? WHERE id_match = ?");
        $stmt_update->execute([$places_reserves, $id_match]);

        $to = $_SESSION['user']['email'];
        $subject = "Confirmation de réservation de billets";
        $message = "Bonjour,\n\nVous avez réservé ".$places_reserves." billet(s) pour le match ".$id_match.".\n\nMerci pour votre réservation!\n\nCordialement,\nFC Riviera";
        $headers = "From: Votre Nom <votre-email@example.com>";

        mail($to, $subject, $message, $headers);

        echo "Réservation réussie! Un e-mail de confirmation a été envoyé à ".$_SESSION['user']['email'].".";
    } else {
        echo "Erreur : le match sélectionné n'existe pas.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billetterie</title>
    <link rel="stylesheet" href="../css/billetterie.css">
</head>
<body>
    <?php include 'navbar.php'; ?> 
    <h2>Billetterie</h2>
    <?php
    foreach ($matches as $match) {
        echo "<div class='match-box'>";
        echo "<div class='match-date'>" . $match['match_name'] . "</div>";
        echo "<div class='match-details'>";
        echo "<div class='match-teams'>";
   
        $stmt_teams = $db->prepare("SELECT nom_equipe, logo FROM equipe WHERE id_equipe IN (SELECT home_team FROM calendrier WHERE id_match = ?) OR id_equipe IN (SELECT away_team FROM calendrier WHERE id_match = ?)");
        $stmt_teams->execute([$match['id_match'], $match['id_match']]);
        $teams = $stmt_teams->fetchAll(PDO::FETCH_ASSOC);
        foreach ($teams as $team) {
            echo "<img class='team-logo' src='" . $team['logo'] . "' alt='" . $team['nom_equipe'] . "'>";
            echo "<h3>" . $team['nom_equipe'] . "</h3>";
        }
        echo "</div>";
        echo "<p>Places disponibles : <span>" . $match['places_dispo'] . "</span></p>";
        
        echo "<form method='POST' action='".htmlspecialchars($_SERVER["PHP_SELF"])."'>";
        echo "<input type='hidden' name='match' value='".$match['id_match']."'>";
        echo "<label for='places'>Nombre de places :</label>";
        echo "<input type='number' id='places' name='places' min='1' max='".$match['places_dispo']."' required>";
        echo "<input type='submit' value='Réserver'>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
    }
    ?>
    <footer>
        <?php include 'footer.php'; ?>
    </footer>
</body>
</html>
