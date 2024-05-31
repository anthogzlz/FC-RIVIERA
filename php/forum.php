<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum FC Riviera</title>
    <link rel="stylesheet" href="../css/forum.css">
</head>
<body>

<?php include 'navbar.php'; ?>
<?php include 'database.php'; ?>

<div class="forum-container">
    <h1>Forum</h1>

    <form action="forum.php" method="POST">
        <input type="text" name="title" placeholder="Titre du sujet" required>
        <button type="submit" name="add_topic">Ajouter un sujet</button>
    </form>

    <?php
    if (isset($_POST['add_topic'])) {
        $title = $_POST['title'];
        $sql = "INSERT INTO topics (title, user_id) VALUES (:title, :user_id)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':user_id', $user_id);
        if ($stmt->execute()) {
            echo "<p>Nouveau sujet ajouté avec succès.</p>";
        } else {
            echo "<p>Erreur: Impossible d'ajouter le sujet.</p>";
        }
    }

    if (isset($_POST['add_comment'])) {
        $topic_id = $_POST['topic_id'];
        $comment = $_POST['comment'];
        $sql = "INSERT INTO comments (topic_id, comment, user_id) VALUES (:topic_id, :comment, :user_id)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':topic_id', $topic_id);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':user_id', $user_id);
        if ($stmt->execute()) {
            echo "<p>Commentaire ajouté avec succès.</p>";
        } else {
            echo "<p>Erreur: Impossible d'ajouter le commentaire.</p>";
        }
    }
    ?>

    <div class="topics-list">
        <?php
        $sql = "SELECT t.*, u.prenom AS prenom FROM topics t JOIN users u ON t.user_id = u.id_user ORDER BY t.created_at DESC";
        $stmt = $db->query($sql);

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='topic'>";
                echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
                echo "<p>Créé par " . htmlspecialchars($row['prenom']) . " le " . $row['created_at'] . "</p>";

                echo "<form action='forum.php' method='POST'>";
                echo "<input type='hidden' name='topic_id' value='" . $row['id'] . "'>";
                echo "<textarea name='comment' placeholder='Votre commentaire' required></textarea>";
                echo "<button type='submit' name='add_comment'>Ajouter un commentaire</button>";
                echo "</form>";

                $sql_comments = "SELECT c.*, u.prenom AS user_prenom FROM comments c JOIN users u ON c.user_id = u.id_user WHERE topic_id = :topic_id ORDER BY c.created_at DESC";
                $stmt_comments = $db->prepare($sql_comments);
                $stmt_comments->bindParam(':topic_id', $row['id']);
                $stmt_comments->execute();

                if ($stmt_comments->rowCount() > 0) {
                    echo "<div class='comments'>";
                    while ($comment_row = $stmt_comments->fetch(PDO::FETCH_ASSOC)) {
                        echo "<div class='comment'>";
                        echo "<p>" . htmlspecialchars($comment_row['comment']) . "</p>";
                        echo "<small>Posté par " . htmlspecialchars($comment_row['user_prenom']) . " le " . $comment_row['created_at'] . "</small>";
                        echo "</div>";
                    }
                    echo "</div>";
                } else {
                    echo "<p>Aucun commentaire.</p>";
                }

                echo "</div>";
            }
        } else {
            echo "<p>Aucun sujet trouvé.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
