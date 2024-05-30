<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    // Redirigez vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: /php/connexion.php');
    exit();
}


// Inclure la connexion à la base de données
include '/php/database.php';

// Récupérer les matchs existants à domicile uniquement
$stmt_matches = $db->prepare("SELECT id_match, match_name, places_dispo FROM calendrier WHERE home_team = ?");
$stmt_matches->execute([3]); // Remplacez $equipe_id par l'ID de l'équipe à domicile
$matches = $stmt_matches->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_match = $_POST['match'];
    $id_user = $_SESSION['user']['id_user']; // Utiliser l'ID de l'utilisateur stocké dans la session
    $places_reserves = $_POST['places']; // Nombre de places réservées par l'utilisateur

    // Vérifier si le match existe et récupérer les places disponibles
    $stmt_check = $db->prepare("SELECT places_dispo FROM calendrier WHERE id_match = ?");
    $stmt_check->execute([$id_match]);
    $match = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if ($match) {
        $places_dispo = $match['places_dispo'];
        if ($places_reserves > $places_dispo) {
            echo "Erreur : il n'y a pas assez de places disponibles.";
            exit();
        }

        // Insérer la réservation dans la base de données
        $stmt = $db->prepare("INSERT INTO reservations (id_match, id_user, places_prises) VALUES (?, ?, ?)");
        $stmt->execute([$id_match, $id_user, $places_reserves]);

        // Mettre à jour le nombre de places disponibles dans le calendrier
        $stmt_update = $db->prepare("UPDATE calendrier SET places_dispo = places_dispo - ? WHERE id_match = ?");
        $stmt_update->execute([$places_reserves, $id_match]);

        // Envoi de l'email de confirmation
        $to = $_SESSION['user']['email'];
        $subject = "Confirmation de réservation de billets";
        $message = "Bonjour,\n\n";
        $message .= "Vous avez réservé ".$places_reserves." billet(s) pour le match ".$id_match.".\n\n";
        $message .= "Merci pour votre réservation!\n\n";
        $message .= "Cordialement,\nFC Riviera";
        $headers = "From: Votre Nom <votre-email@example.com>"; // Remplacez par votre adresse e-mail

        // Envoyer l'e-mail
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
    <link rel="stylesheet" href="./css/billetterie.css">
</head>
<body>
    <?php include './php/navbar.php'; ?> <!-- Inclusion de la barre de navigation -->
    <h2>Billetterie</h2>
    <?php
    foreach ($matches as $match) {
        echo "<div class='match-box'>";
        echo "<div class='match-date'>" . $match['match_name'] . "</div>";
        echo "<div class='match-details'>";
        echo "<div class='match-teams'>";
        // Récupérer et afficher les logos des équipes
        $stmt_teams = $db->prepare("SELECT nom_equipe, logo FROM equipe WHERE id_equipe IN (SELECT home_team FROM calendrier WHERE id_match = ?) OR id_equipe IN (SELECT away_team FROM calendrier WHERE id_match = ?)");
        $stmt_teams->execute([$match['id_match'], $match['id_match']]);
        $teams = $stmt_teams->fetchAll(PDO::FETCH_ASSOC);
        foreach ($teams as $team) {
            echo "<img class='team-logo' src='" . $team['logo'] . "' alt='" . $team['nom_equipe'] . "'>";
            echo "<h3>" . $team['nom_equipe'] . "</h3>";
        }
        echo "</div>";
        echo "<p>Places disponibles : <span>" . $match['places_dispo'] . "</span></p>";
        // Formulaire pour la réservation
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
        <?php include './php/footer.php'; ?>
    </footer>
</body>
</html>
