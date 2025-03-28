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
    <h2>Liste des Categories</h2>
    <a href="produit.php" class="btn btn-primary">Ajouter Produit</a>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#ID</th>
                <th>Libelle</th>
                <th>Description</th>
                <th>Date Creation</th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                require_once 'include/database.php';
                $categories = $pdo->query('SELECT * FROM categorie')->fetchAll(PDO::FETCH_ASSOC);
                foreach($categories as $categorie){
                    ?>
                    <tr>
                        <td><?php echo $categorie['id']?></td>
                        <td><?php echo $categorie['libelle']?></td>
                        <td><?php echo $categorie['description']?></td>
                        <td><?php echo $categorie['date-creation']?></td>
                        <td>
                            <a href="modifier_categorie.php?id=<?php echo $categorie['id'] ?>" class="btn btn-primary btn-sm">Modifier</a>
                            <a href="supprimer_categorie.php?id=<?php echo $categorie['id'] ?>" onclick="return confirm('Voulez vous vraiment supprimer la categorie <?php echo $categorie['libelle']?> ');" class="btn btn-danger btn-sm">Supprimer</a>
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