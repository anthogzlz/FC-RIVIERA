<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FC Riviera - Accueil</title>
    <link rel="stylesheet" href="../CSS/navbar.css">
</head>

<body>
    <header>
        <nav>
            <div class="menu-container">
                <div class="menu-toggle">&#9776;</div>
                <div class="logo-container">
                    <a href="index.php"><img src="../assets/logo.png" alt="Logo FC Riviera"></a>
                </div>
                <ul class="menu left-menu">
                    <li><a href="effectif.php">EFFECTIF</a></li>
                    <li><a href="calendrier.php">CALENDRIER</a></li>
                    <li><a href="classement.php">CLASSEMENT</a></li>
                    <li><a href="forum.php">FORUM</a></li>
                </ul>
                <ul class="menu right-menu">
                    <li><a href="ligue.php">LIGUE</a></li>
                    <li><a href="billetterie.php">BILLETTERIE</a></li>
                    <?php
                    if (isset($_SESSION['user'])) {
                        echo '<li><a href="reservations.php">MES RÉSERVATIONS</a></li>';
                        echo '<li><a href="../PHP/deconnexion.php">DECONNEXION</a></li>';
                    } else {
                        echo '<li><a href="../PHP/connexion.php">CONNEXION</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </header>

    <script>
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('.menu-container').classList.toggle('active');
        });
    </script>
</body>

</html>
