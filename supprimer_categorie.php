<?php
require_once 'include/database.php';

$id = $_GET['id'];
$sqlstate = $pdo->prepare('DELETE FROM categorie WHERE id=?');
$supprime = $sqlstate->execute([$id]);
header('location: categories.php');




// if(supprime){
//     header('location: categories.php');
// }else{
//     echo "DataBase Error";
// }