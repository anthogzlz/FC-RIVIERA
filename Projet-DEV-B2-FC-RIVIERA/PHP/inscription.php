<?php
session_start();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['birthdate']) && isset($_POST['telephone']) && isset($_POST['passwd'])) {
        $prenom = htmlspecialchars($_POST['prenom']);
        $nom = htmlspecialchars($_POST['nom']);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $birthdate = $_POST['birthdate'];

        $telephone = htmlspecialchars($_POST['telephone']);
        $passwd = $_POST['passwd'];

        if ($email && !empty($passwd)) {
            $passwd = password_hash($passwd, PASSWORD_DEFAULT);

            require_once 'database.php';

            try {
                $query = "INSERT INTO users (prenom, nom, email, birthdate, telephone, passwd) VALUES (:prenom, :nom, :email, :birthdate, :telephone, :passwd)";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':prenom', $prenom);
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':birthdate', $birthdate);
                $stmt->bindParam(':telephone', $telephone);
                $stmt->bindParam(':passwd', $passwd);

                if ($stmt->execute()) {
                    $message = "Inscription réussie. Vous pouvez maintenant vous connecter.";
                } else {
                    $message = "Une erreur s'est produite lors de l'inscription. Veuillez réessayer.";
                }
            } catch (PDOException $e) {
                $message = 'Erreur d\'inscription : ' . $e->getMessage();
            }
        } else {
            $message = "Le champ de mot de passe est vide ou l'email est invalide.";
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
    <?php include 'navbar.php'; ?>
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
