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
    <link rel="stylesheet" href="../css/effectif.css">
</head>
<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>

    <h2>Effectif du FC Riviera</h2>
    <div class="team">
        <?php
        include 'database.php';

        try {
            $sql = "SELECT * FROM effectif";
            $stmt = $db->query($sql);

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
        } catch(PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        ?>
    </div>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>
</body>
</html>
