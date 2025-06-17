<?php
session_start();

if (!isset($_SESSION['utilisateur'])) {
    header('Location: ../connexion.php');
    exit();
}

$id = trim($_POST['id']);
$idUtilisateur = $_SESSION['utilisateur']['id'];

if (isset($_SESSION['panier'][$idUtilisateur][$id])) {
    unset($_SESSION['panier'][$idUtilisateur][$id]);
}

// Redirection l page li ja mnha luser
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>