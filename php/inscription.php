<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification que tous les champs du formulaire sont remplis
    if (isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['birthdate']) && isset($_POST['telephone']) && isset($_POST['passwd'])) {
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $birthdate = $_POST['birthdate'];
        $telephone = $_POST['telephone'];
        $passwd = $_POST['passwd'];

        // Fonction pour vérifier la complexité du mot de passe
        function is_password_strong($password) {
            $length = strlen($password) >= 8;
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);

            return $length && $uppercase && $lowercase && $number && $specialChars;
        }

        if (!empty($passwd) && is_password_strong($passwd)) {
            require_once ('database.php');

            try {
                // Connexion à la base de données
                // $db = new PDO('mysql:host=sql7.freesqldatabase.com;dbname=sql7710600', 'sql7710600', 'pH8mCPUC9c');
                // $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                include 'database.php';

                // Vérification si l'adresse e-mail existe déjà
                $query_check_email = "SELECT COUNT(*) FROM users WHERE email = :email";
                $stmt_check_email = $db->prepare($query_check_email);
                $stmt_check_email->bindParam(':email', $email);
                $stmt_check_email->execute();
                $email_exists = $stmt_check_email->fetchColumn();

                if ($email_exists) {
                    $message = "Cette adresse e-mail est déjà associée à un compte. Veuillez en choisir une autre.";
                } else {
                    // Préparation de la requête pour insérer l'utilisateur dans la base de données
                    $query = "INSERT INTO users (prenom, nom, email, birthdate, telephone, passwd) VALUES (:prenom, :nom, :email, :birthdate, :telephone, :passwd)";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam(':prenom', $prenom);
                    $stmt->bindParam(':nom', $nom);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':birthdate', $birthdate);
                    $stmt->bindParam(':telephone', $telephone);
                    $stmt->bindParam(':passwd', password_hash($passwd, PASSWORD_DEFAULT)); // Hachage du mot de passe

                    // Exécution de la requête
                    if ($stmt->execute()) {
                        // Redirection vers la page de connexion après succès
                        header("Location: connexion.php");
                        exit();
                    } else {
                        $message = "Une erreur s'est produite lors de l'inscription. Veuillez réessayer.";
                    }
                }
            } catch (PDOException $e) {
                // En cas d'erreur lors de la requête SQL, affichez l'erreur
                echo 'Erreur d\'inscription : ' . $e->getMessage();
            }
        } else {
            $message = "Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.";
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
    <title>Inscription</title>
    <link rel="stylesheet" href="../css/inscription.css">
</head>

<body>
    <?php include 'navbar.php'; ?> <!-- Inclusion de la barre de navigation -->
    <h2>Inscription</h2>
    <?php if (!empty($message)) { ?>
        <p><?php echo $message; ?></p>
    <?php } ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="prenom">Prénom:</label><br>
        <input type="text" id="prenom" name="prenom" required><br>

        <label for="nom">Nom:</label><br>
        <input type="text" id="nom" name="nom" required><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>

        <label for="birthdate">Date de naissance:</label><br>
        <input type="date" id="birthdate" name="birthdate" required><br>

        <label for="telephone">Téléphone:</label><br>
        <input type="text" id="telephone" name="telephone" required><br>

        <label for="password">Mot de passe:</label><br>
        <input type="password" id="password" name="passwd" required><br>

        <input type="submit" value="S'inscrire">
    </form>

    <p>Déjà inscrit ? <a href="connexion.php">Se connecter</a></p>

    <footer>
    <?php include 'footer.php'; ?>
    </footer>
    
</body>

</html>
