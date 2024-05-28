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
    <title>Ligue du FC Riviera</title>
    <link rel="stylesheet" href="../css/ligue.css"> 
    
</head>
<body>

<?php include "navbar.php"; ?>

<div class="sidebar">
    <a href="?page=jeu" class="tab <?php echo (isset($_GET['page']) && $_GET['page'] == 'jeu') ? 'active' : ''; ?>">Jeu</a>
    <a href="?page=classement" class="tab <?php echo (isset($_GET['page']) && $_GET['page'] == 'classement') ? 'active' : ''; ?>">Classement</a>
</div>

<div class="content">
    <?php
    if (isset($_GET['page']) && $_GET['page'] == 'jeu') {
    ?>
        <div class="game-container">
            <h3>Jeu de Prédiction de Football</h3>
            <p>Devinez les scores des prochains matchs et gagnez des points!</p>
            <div class="form-container">
                <form method="post">
                    <label for="match1">Pronostic pour le match 1:</label>
                    <input type="text" id="match1" name="match1"><br><br>
                    <label for="match2">Pronostic pour le match 2:</label>
                    <input type="text" id="match2" name="match2"><br><br>
                    <input type="submit" name="submit" value="Soumettre">
                </form>
            </div>
        </div>
    <?php
    } elseif (isset($_GET['page']) && $_GET['page'] == 'classement') {
    ?>
        <div class="scoreboard">
            <h3>Tableau des Scores</h3>
            <table>
                <thead>
                    <tr>
                        <th>Rang</th>
                        <th>Nom du Supporter</th>
                        <th>Points</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $scores = [
                        ["rang" => 1, "nom" => "Supporter1", "points" => 100],
                        ["rang" => 2, "nom" => "Supporter2", "points" => 80],
                        ["rang" => 3, "nom" => "Supporter3", "points" => 60],
                    ];
                    foreach ($scores as $score) {
                        echo "<tr><td>{$score['rang']}</td><td>{$score['nom']}</td><td>{$score['points']}</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php
    } else {
    ?>
        <h2>Bienvenue dans la Ligue du FC Riviera</h2>
        <p>Veuillez sélectionner une option dans la barre latérale.</p>
    <?php
    }
    ?>
</div>

    <footer>
    <?php include 'footer.php'; ?>
    </footer>

</body>
</html>
