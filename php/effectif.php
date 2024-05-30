<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FC Riviera - Effectif</title>
    <link rel="stylesheet" href="./css/effectif.css">
</head>
<body>
    <header>
        <?php include './php/navbar.php'; ?>
    </header>

    <h2>Effectif du FC Riviera</h2>
    <div class="team">
        <?php
        // Inclure la connexion à la base de données
        include './php/database.php';

        // Requête pour récupérer les joueurs de l'effectif
        $sql = "SELECT * FROM effectif";
        $result = $conn->query($sql);

        // Affichage des joueurs dans la liste
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='player'>";
                echo "<img src='" . $row['img_nationalite'] . "' alt='Logo' class='nationality'>";
                echo "<p><strong>" . $row['nom_joueur'] . "</strong></p>";
                echo "<p>Poste : " . $row['poste_joueur'] . "</p>";
                echo "<p>Numéro : " . $row['numero_joueur'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucun joueur trouvé dans l'effectif.</p>";
        }

        // Fermeture de la connexion à la base de données
        $conn->close();
        ?>
    </div>

    <footer>
        <?php include './php/footer.php'; ?>
    </footer>
</body>
</html>
