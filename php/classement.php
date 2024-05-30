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
    <title>Classement des équipes</title>
    <link rel="stylesheet" href="../css/classement.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="classement-container">
    <div class="classement-content">
        <h1>Classement des équipes</h1>
        <table>
            <thead>
                <tr>
                    <th>Rang</th>
                    <th>Logo</th>
                    <th>Équipe</th>
                    <th>Points</th>
                    <th>Buts Pour</th>
                    <th>Buts Contre</th>
                    <th>Différence de Buts</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Connexion à la base de données
                $servername = "sql7.freesqldatabase.com";
                $username = "sql7710600";
                $password = "pH8mCPUC9c";
                $dbname = "sql7710600";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Vérification de la connexion
                if ($conn->connect_error) {
                    die("Erreur de connexion à la base de données: " . $conn->connect_error);
                }

                // Récupération des données des équipes classées
                $sql = "SELECT * FROM equipe ORDER BY points DESC, differencebut DESC";
                $result = $conn->query($sql);

                // Affichage des données dans le tableau
                $rank = 1;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $rankClass = "rank-" . $rank;
                        echo "<tr class='$rankClass'>";
                        echo "<td><span class='rank-number'>" . $rank . "</span></td>";
                        echo "<td><img src='" . $row['logo'] . "' alt='Logo'></td>";
                        echo "<td>" . $row['nom_equipe'] . "</td>";
                        echo "<td>" . $row['points'] . "</td>";
                        echo "<td>" . $row['butpour'] . "</td>";
                        echo "<td>" . $row['butcontre'] . "</td>";
                        echo "<td>" . $row['differencebut'] . "</td>";
                        echo "</tr>";
                        $rank++;
                    }
                } else {
                    echo "<tr><td colspan='7'>Aucune équipe trouvée.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
// Fermeture de la connexion à la base de données
$conn->close();
?>
    <footer>
    <?php include 'footer.php'; ?>
    </footer>

</body>
</html>
