<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ./php/connexion.php');
    exit();
}

// Traitement de l'achat de billets ici
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $match = $_POST['match'];
    $quantite = $_POST['quantite'];

    // Effectuez le traitement nécessaire pour enregistrer l'achat

    echo "<h1>Merci pour votre achat !</h1>";
    echo "<p>Vous avez acheté $quantite billets pour le match $match.</p>";
}
?>
