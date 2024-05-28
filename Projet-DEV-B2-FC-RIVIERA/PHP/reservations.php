<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit();
}

include 'database.php';

$id_user = $_SESSION['user']['id_user'];
$stmt_reservations = $db->prepare("SELECT r.id_resa, r.places_prises, c.match_name, c.date FROM reservations r JOIN calendrier c ON r.id_match = c.id_match WHERE r.id_user = ?");
$stmt_reservations->execute([$id_user]);
$reservations = $stmt_reservations->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Réservations</title>
    <link rel="stylesheet" href="../css/reservations.css"> 
</head>
<body>
    <?php include 'navbar.php'; ?>
    <h2>Mes Réservations</h2>

    <div class="reservations">
        <?php if (count($reservations) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Match</th>
                        <th>Date</th>
                        <th>Places réservées</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td><?php echo $reservation['match_name']; ?></td>
                            <td><?php echo $reservation['date']; ?></td>
                            <td><?php echo $reservation['places_prises']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucune réservation trouvée.</p>
        <?php endif; ?>
    </div>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>
</body>
</html>
