<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">

    <title>Samara Liste </title>

    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>

<?php include 'include/nav.php' ?>


<div class=" container my-5"> 
    <h2>Liste des Produits</h2>
    <a href="categorie.php" class="btn btn-primary">Ajouter Categorie</a>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#ID</th>
                <th>Libelle</th>
                <th>Prix</th>
                <th>Discount</th>
                <th>Categorie</th>
                <th>Date Creation</th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                require_once 'include/database.php';
                $categories = $pdo->query("SELECT produit.*,categorie.libelle as 'categorie_libelle' FROM produit INNER JOIN categorie ON produit.id_categorie = categorie.id")->fetchAll(PDO::FETCH_OBJ);
                foreach($categories as $produit){
                    $prix = $produit->prix;
                    $discount = $produit->discount;
                    $prixFinal = $prix - (($prix*$discount)/100);
                    ?>
                    <tr>
                        <td><?= $produit->id?></td>
                        <td><?= $produit->libelle?></td>
                        <td><?= $produit->prix?> MAD</td>
                        <td><?= $produit->discount?> %</td>
                        <td><?= $produit->categorie_libelle?></td>
                        <td><?= $produit->date_creation?></td>
                        <td>
                            <input type="submit" class="btn btn-primary btn-sm" value="Modifier">
                            <input type="submit" class="btn btn-danger btn-sm" value="Supprimer">
                        </td>

                    </tr>
                    <?php
                }
            ?>
        </tbody>
        
    </table>

</div>


</body>
</html>