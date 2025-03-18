

<?php

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=localhost;dbname=ecommerce", "root", "");

    // Définir le mode d'erreur de PDO sur Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connexion réussie !";
} catch (PDOException $e) {
    // Affichage de l'erreur en cas d'échec
    echo "Erreur de connexion : " . $e->getMessage();
}

?>