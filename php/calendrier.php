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
    <title>FC Riviera - Calendrier</title>
    <link rel="stylesheet" href="../css/calendrier.css">
</head>

<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>

    <h2>Calendrier du FC Riviera</h2>

    <div class="calendrier">
        <?php
        // Connexion à la base de données
        include 'database.php';

        // Récupérer les matchs du FC Riviera (équipe numéro 3) dans l'ordre chronologique
        $equipe_nom = "FC Riviera";
        $sql = "SELECT c.*, e1.nom_equipe AS home_team_nom, e2.nom_equipe AS away_team_nom, e1.logo AS home_team_logo, e2.logo AS away_team_logo FROM calendrier c
                INNER JOIN equipe e1 ON c.home_team = e1.id_equipe
                INNER JOIN equipe e2 ON c.away_team = e2.id_equipe
                WHERE e1.nom_equipe = '$equipe_nom' OR e2.nom_equipe = '$equipe_nom'
                ORDER BY c.date";
        $result = $db->query($sql);

        // Afficher les matchs
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="match-box">
                    <div class="match-date"><?php echo $row["date"]; ?></div>
                    <div class="match-details">
                        <h3>
                            <img src="<?php echo $row["home_team_logo"]; ?>" alt="<?php echo $row["home_team_nom"]; ?>" class="team-logo">
                            <?php echo $row["home_team_nom"]; ?>
                            vs
                            <?php echo $row["away_team_nom"]; ?>
                            <img src="<?php echo $row["away_team_logo"]; ?>" alt="<?php echo $row["away_team_nom"]; ?>" class="team-logo">
                        </h3>
                    </div>
                </div>
            <?php
            }
        } else {
            echo "Aucun match trouvé pour le FC Riviera.";
        }
        ?>
    </div>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>

</body>

</html>
