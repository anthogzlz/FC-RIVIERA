<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $match = $_POST['match'];
    $quantite = $_POST['quantite'];


    echo "<h1>Merci pour votre achat !</h1>";
    echo "<p>Vous avez acheté $quantite billets pour le match $match.</p>";
}
?>
