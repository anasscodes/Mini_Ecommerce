<?php 
include_once 'include/database.php';
$id = $_GET['id'];
$etat = $_GET['etat'];
$sqlState = $pdo->prepare('UPDATE commend SET valide = ? WHERE id = ?'); 
$sqlState->execute([$etat, $id]);
header('location: commande.php?id=' . $id);
exit();
?>