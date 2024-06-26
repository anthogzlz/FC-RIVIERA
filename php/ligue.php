<?php
include 'database.php';
session_start();

// Vérifiez si une session est active
if (!isset($_SESSION['user_id'])) {
    // Si aucune session n'est active, redirigez vers la page de connexion
    header("Location: connexion.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ligue du FC Riviera</title>
    <link rel="stylesheet" href="../css/ligue.css"> <!-- Assurez-vous que ce chemin est correct -->
</head>

<body>

    <?php include "navbar.php"; ?>

    <div class="sidebar">
        <a href="?page=jeu" class="tab <?php echo (isset($_GET['page']) && $_GET['page'] == 'jeu') ? 'active' : ''; ?>">Jeu</a>
        <a href="?page=classement" class="tab <?php echo (isset($_GET['page']) && $_GET['page'] == 'classement') ? 'active' : ''; ?>">Classement</a>
    </div>

    <div class="content">
        <?php
        // Calculer les points pour chaque utilisateur
        $sql_update_scores = "UPDATE predictions p
            INNER JOIN calendrier c ON p.match_number = c.id_match
            SET p.points = CASE
                WHEN p.home_score = c.home_team_goal AND p.away_score = c.away_team_goal THEN 100
                WHEN p.home_score = c.home_team_goal OR p.away_score = c.away_team_goal THEN 30
                ELSE 0
            END +
            CASE WHEN p.mom_prono = c.manofthematch THEN 50 ELSE 0 END";
        $db->query($sql_update_scores);

        if (isset($_GET['page']) && $_GET['page'] == 'jeu') {
            // Récupérer le match avec l'ID 1 du calendrier
            $sql = "SELECT c.id_match, c.home_team, e1.nom_equipe AS home_team_name, c.away_team, e2.nom_equipe AS away_team_name
                    FROM calendrier c
                    INNER JOIN equipe e1 ON c.home_team = e1.id_equipe
                    INNER JOIN equipe e2 ON c.away_team = e2.id_equipe
                    WHERE c.id_match = 1";
            $result = $db->query($sql);

            if ($result === FALSE) {
                echo "Erreur dans la requête SQL : " . $db->errorInfo()[2];
            } else {
                if ($result->rowCount() > 0) {
                    $match = $result->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div class="game-container">
                        <h3>Jeu de Prédiction de Football</h3>
                        <p>Faites vos pronostics sur le match qui opposera <?php echo $match['home_team_name']; ?> vs
                            <?php echo $match['away_team_name']; ?> et gagnez des points!
                        </p>
                        <div class="form-container">
                            <form method="post" action="">
                                <label for="home_score">Score de l'équipe à domicile
                                    (<?php echo $match['home_team_name']; ?>):</label>
                                <input type="number" id="home_score" name="home_score" required><br><br>
                                <label for="away_score">Score de l'équipe à l'extérieur
                                    (<?php echo $match['away_team_name']; ?>):</label>
                                <input type="number" id="away_score" name="away_score" required><br><br>

                                <label for="homme_match">Homme du match côté FC Riviera:</label>
                                <select id="homme_match" name="homme_match">
                                    <option value="" disabled selected>Choisissez un joueur</option>
                                    <?php
                                    // Récupérer les joueurs de l'effectif du FC Riviera
                                    $sql_joueurs = "SELECT id_joueur, nom_joueur FROM effectif WHERE id_equipe = ?";
                                    $stmt_joueurs = $db->prepare($sql_joueurs);
                                    $equipe_fc_riviera_id = 3; // ID de l'équipe FC Riviera
                                    $stmt_joueurs->execute([$equipe_fc_riviera_id]);
                                    $result_joueurs = $stmt_joueurs->fetchAll(PDO::FETCH_ASSOC);

                                    // Vérifier si des joueurs sont récupérés
                                    if ($stmt_joueurs->rowCount() > 0) {
                                        // Afficher les options pour chaque joueur
                                        foreach ($result_joueurs as $row_joueur) {
                                            // Afficher les noms des joueurs
                                            echo "<option value='{$row_joueur['id_joueur']}'>{$row_joueur['nom_joueur']}</option>";
                                        }
                                    } else {
                                        echo "<option value=''>Aucun joueur trouvé</option>";
                                    }
                                    ?>
                                </select>

                                <br><br>

                                <input type="hidden" name="match_id" value="<?php echo $match['id_match']; ?>">
                                <input type="submit" name="submit" value="Soumettre">
                            </form>
                        </div>
                    </div>
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        // Vérifier si l'homme du match est sélectionné
                        if (isset($_POST['homme_match']) && !empty($_POST['homme_match'])) {
                            $match_id = $_POST['match_id'];
                            $user_id = $_SESSION['user_id']; // Utilisez l'ID de l'utilisateur connecté
        
                            // Vérifier si l'utilisateur a déjà pronostiqué sur ce match
                            $sql_check_prediction = "SELECT * FROM predictions WHERE user_id = ? AND match_number = ?";
                            $stmt_check_prediction = $db->prepare($sql_check_prediction);
                            $stmt_check_prediction->execute([$user_id, $match_id]);
                            $result_check_prediction = $stmt_check_prediction->fetchAll(PDO::FETCH_ASSOC);

                            if (count($result_check_prediction) > 0) {
                                echo "Vous avez déjà pronostiqué sur ce match.";
                            } else {
                                // L'utilisateur n'a pas encore pronostiqué sur ce match, nous pouvons insérer le pronostic
                                $home_score_prono = $_POST['home_score'];
                                $away_score_prono = $_POST['away_score'];
                                $homme_match_prono = $_POST['homme_match']; // ID de l'homme du match
        
                                // Obtenez les scores réels du match
                                $sql_get_real_scores = "SELECT home_team_goal, away_team_goal, manofthematch FROM calendrier WHERE id_match = ?";
                                $stmt_get_real_scores = $db->prepare($sql_get_real_scores);
                                $stmt_get_real_scores->execute([$match_id]);
                                $real_scores = $stmt_get_real_scores->fetch(PDO::FETCH_ASSOC);

                                // Calculer les points
                                $points = 0;

                                // Vérifier si le pronostiqueur a correctement deviné le nombre de buts pour l'une ou les deux équipes
                                if ($home_score_prono == $real_scores['home_team_goal']) {
                                    $points += 30;
                                }
                                if ($away_score_prono == $real_scores['away_team_goal']) {
                                    $points += 30;
                                }

                                // Vérifier si le pronostiqueur a correctement deviné l'homme du match
                                if ($homme_match_prono == $real_scores['manofthematch']) {
                                    $points += 50;
                                }

                                // Insérer le pronostic dans la base de données
                                $sql_insert_prediction = "INSERT INTO predictions (user_id, match_number, home_score, away_score, mom_prono, points) VALUES (?, ?, ?, ?, ?, ?)";
                                $stmt_insert_prediction = $db->prepare($sql_insert_prediction);

                                if ($stmt_insert_prediction->execute([$user_id, $match_id, $home_score_prono, $away_score_prono, $homme_match_prono, $points])) {
                                    echo "Pronostic enregistré avec succès!";
                                } else {
                                    echo "Erreur: " . $sql_insert_prediction . "<br>" . $db->errorInfo()[2];
                                }
                            }
                        } else {
                            echo "Veuillez sélectionner l'homme du match.";
                        }
                    }
                } else {
                    echo "<p>Aucun match trouvé dans le calendrier.</p>";
                }
            }
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
                        $sql = "SELECT p.user_id, SUM(p.points) as total_points, u.prenom, u.nom 
                        FROM predictions p 
                        INNER JOIN users u ON p.user_id = u.id_user 
                        GROUP BY p.user_id, u.prenom, u.nom
                        ORDER BY total_points DESC";
                        $result = $db->query($sql);

                        if ($result->rowCount() > 0) {
                            $rang = 1;
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr><td>{$rang}</td><td>{$row['prenom']} {$row['nom']}</td><td>{$row['total_points']}</td></tr>";
                                $rang++;
                            }
                        } else {
                            echo "<tr><td colspan='3'>Aucun score disponible</td></tr>";
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

    <?php $db = null; ?>

</body>

</html>
