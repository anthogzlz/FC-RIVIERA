<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FC Riviera - Accueil</title>
    <link rel="stylesheet" href="./CSS/navbar.css">
</head>

<body>
    <header>
        <nav>
            <div class="menu-container">
                <div class="menu-toggle">&#9776;</div>
                <div class="logo-container">
                    <a href="../index.php"><img src="/assets/logo.png" alt="Logo FC Riviera"></a>
                </div>
                <ul class="menu left-menu">
                    <li><a href="./php/effectif.php">EFFECTIF</a></li>
                    <li><a href="./php/calendrier.php">CALENDRIER</a></li>
                    <li><a href="/php/classement.php">CLASSEMENT</a></li>
                </ul>
                <ul class="menu right-menu">
                    <li><a href="/php/forum.php">FORUM</a></li>
                    <li><a href="/php/ligue.php">LIGUE</a></li>
                    <li><a href="/php/billetterie.php">BILLETTERIE</a></li>
                    <?php
                    if (isset($_SESSION['user'])) {
                        echo '<li><a href="/php/reservations.php">MES RÉSERVATIONS</a></li>';
                        echo '<li><a href="/php/deconnexion.php">DECONNEXION</a></li>';
                    } else {
                        echo '<li><a href="/php/connexion.php">CONNEXION</a></li>';
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
