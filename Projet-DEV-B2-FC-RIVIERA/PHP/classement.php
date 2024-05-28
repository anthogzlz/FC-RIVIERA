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
<?php include 'database.php'; ?>

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
                try {
                    $sql = "SELECT * FROM equipe ORDER BY points DESC, differencebut DESC";
                    $stmt = $db->query($sql);
                    $rank = 1;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
                } catch(PDOException $e) {
                    echo "Erreur : " . $e->getMessage();
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
