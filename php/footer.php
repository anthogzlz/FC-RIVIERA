<footer id="footer">
    <link rel="stylesheet" href="../css/footer.css">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section about">
                <h2>À Propos</h2>
                <div class="contact">
                    <span><i class="fas fa-envelope"></i> contact@fcriviera.com</span>
                </div>
                <div class="socials">
                    <a href="#" class="facebook"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <div class="footer-section contact-form">
                <h2>Contactez-nous</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="email" name="email" class="text-input contact-input" placeholder="Votre adresse e-mail...">
                    <textarea name="message" class="text-input contact-input" placeholder="Votre message..."></textarea>
                    <button type="submit" class="btn btn-big contact-btn">
                        <i class="fas fa-envelope"></i>
                        Envoyer
                    </button>
                </form>
                <?php
include 'database.php';

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère les données du formulaire
    $email = $_POST['email'];
    $message = $_POST['message'];

    try {
        // Prépare et exécute la requête SQL pour insérer les données dans la base de données
        $sql = "INSERT INTO messages (email, message) VALUES (:email, :message)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);
        $stmt->execute();
        echo "Message envoyé avec succès.";
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
}
?>

            </div>
        </div>
        <div class="footer-bottom">
            &copy; FC Riviera - Tous droits réservés - 2024
        </div>
    </div>
</footer>
