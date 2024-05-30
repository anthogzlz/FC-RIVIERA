<?php
session_start();

// Vérifier si une session est déjà active
if (isset($_SESSION['user_id'])) {
    // Redirection vers la page index.php si une session est active
    header("Location: index.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification de l'existence des champs du formulaire
    if (isset($_POST['email']) && isset($_POST['passwd'])) {
        $email = $_POST['email'];
        $passwd = $_POST['passwd'];
        
        // Vérification des informations de connexion dans la base de données
        require_once('database.php');
        
        try {
            // Connexion à la base de données
            $db = new PDO('mysql:host=sql7.freesqldatabase.com;dbname=sql7710600', 'sql7710600', 'pH8mCPUC9c');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Préparation de la requête pour récupérer l'utilisateur avec cet email
            $query = "SELECT * FROM users WHERE email = :email";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($passwd, $user['passwd'])) {
                // Connexion réussie
                $_SESSION['user'] = [
                    'id_user' => $user['id_user'],
                    'email' => $user['email']
                ];
                $_SESSION['user_id'] = $user['id_user']; // Ajoutez cette ligne pour la compatibilité avec ligue.php
                $_SESSION['message'] = "Vous êtes connecté en tant que " . $user['email'];
                header("Location: index.php");
                exit();
            } else {
                // Identifiants incorrects
                $message = "Identifiants incorrects. Veuillez réessayer.";
            }
        } catch (PDOException $e) {
            // En cas d'erreur lors de la requête SQL, affichez l'erreur
            echo 'Erreur de connexion : ' . $e->getMessage();
        }
    } else {
        $message = "Tous les champs du formulaire doivent être remplis.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../css/connexion.css">
</head>
<body>
    <?php include 'navbar.php'; ?> <!-- Inclusion de la barre de navigation -->
    <h2>Connexion</h2>
    <?php if (!empty($message)) { ?>
        <p><?php echo $message; ?></p>
    <?php } ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>

        <label for="passwd">Mot de passe:</label><br>
        <input type="password" id="passwd" name="passwd" required><br>

        <input type="submit" value="Se connecter">
    </form>

    <p>Pas encore inscrit ? <a href="inscription.php">S'inscrire</a></p>
    
    <footer>
    <?php include 'footer.php'; ?>
    </footer>

</body>
</html>
