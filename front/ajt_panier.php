<?php 
session_start();
require_once '../include/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/counter.css">
    <title>Panier</title>

    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"  />
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

</head>
<body>

<?php include '../include/nav_front.php' ?>

<div class="container my-5 w-80"> 

    <h3>Panier</h3>
    <div class="container my-4">
        <div class="row">

<?php

$idUtilisateur = $_SESSION['utilisateur']['id'] ?? null;
$panier = $_SESSION['panier'][$idUtilisateur] ?? [];

if (!empty($panier)) {

    $idProduitsArray = array_keys($panier);

    if (!empty($idProduitsArray)) {

        $idProduits = implode(',', array_map('intval', $idProduitsArray));
        $stmt = $pdo->query("SELECT * FROM produit WHERE id IN ($idProduits)");
        $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($produits)) {
            // Si produits disponibles, afficher la liste
            ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Imag</th>
                        <th scope="col">Libelle</th>
                        <th scope="col">Quantité</th>
                        <th scope="col">Prix</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
            <?php 
            $total = 0;

            foreach ($produits as $produit): 
                $idProduit = $produit['id'];
                $totalProduit = $produit['prix'] * $panier[$idProduit];
                $total += $totalProduit ;
                ?>
                
                <tr>
                        <td ><?php echo htmlspecialchars($produit['id']); ?></td>
                        <td ><img width="80px" src="../upload/produits/<?php echo htmlspecialchars($produit['image']);?>" alt=""></td>
                        <td ><?php echo htmlspecialchars($produit['libelle']); ?></td>
                        <td ><?php include'../include/front/counter.php' ?></td>
                        <td ><?php echo htmlspecialchars($produit['prix']); ?> MAD</td>
                        <td ><?php echo htmlspecialchars($totalProduit); ?> MAD</td>
                </tr>

            <?php endforeach; ?>

            <tfoot>
                <tr>
                    <td colspan="5" align="right"><strong>Total</strong></td>
                    <td><?php echo $total ?> MAD</td>
                </tr>
                <tr>
                    <td colspan="6" align="right">
                        <?php 
                            if(isset($_POST['vider'])){
                                $_SESSION['panier'][$idUtilisateur] = [];
                            }
                        ?>
                        <form method="POST">
                            <input type="submit" class="btn btn-success" name="valider" value="Valider la commande">
                            <input onclick="return confirm('Voulez vous vraiment vider le panier ?!')" type="submit" class="btn btn-danger" name="vider" value="Vider le panier">
                        </form>
                    </td>
                   
                </tr>
            </tfoot>

            </table>
            <?php
        } else {
            echo '<div class="alert alert-warning" role="alert">Votre panier est vide !!</div>';
        }

    } else {
        echo '<div class="alert alert-warning" role="alert">Votre panier est vide !!</div>';
    }

} else {
    echo '<div class="alert alert-warning" role="alert">Votre panier est vide !!</div>';
}
?>

        </div>
    </div>
</div>

<script src="../assets/js/counter.js"></script>
</body>
</html>
