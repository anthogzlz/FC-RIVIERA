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
    <title>FC Riviera - Accueil</title>
    <link rel="stylesheet" href="./CSS/style.css">
</head>

<body>
    <header>
        <?php include './php/navbar.php'; ?>
    </header>

    <div class="banner">
        <h1>FC RIVIERA</h1>
    </div>

    <main>
        <section>
            <h2>Actualités</h2>
            <article>
                <h3>Victoire du FC Riviera contre le FC Zurich</h3>
                <p>Le FC Riviera a remporté son dernier match contre le FC Zurich sur le score de 3-1. Les buts ont été marqués par Dupont, Durand et Martin. Prochain match contre le FC Bâle.</p>
            </article>
            <article>
                <h3>Recrutement</h3>
                <p>Le FC Riviera est à la recherche de nouveaux talents pour la saison prochaine. Si vous êtes intéressé, n'hésitez pas à nous contacter.</p>
            </article>
        </section>
    </main>


    <!-- Script JavaScript pour afficher l'e-mail de l'utilisateur connecté dans la console -->
    <script>
        // Vérifie si une session est ouverte
        <?php if(isset($_SESSION['email'])) { ?>
            console.log("Session ouverte avec l'e-mail : <?php echo $_SESSION['email']; ?>");
        <?php } else { ?>
            console.log("Aucune session ouverte.");
        <?php } ?>
    </script>

    <footer>
    <?php include './php/footer.php'; ?>
    </footer>
    
</body>
</html>
