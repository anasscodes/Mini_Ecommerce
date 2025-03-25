<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">

    <title>Samara Produit</title>

    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>

<?php  require_once 'include/database.php';
         include 'include/nav.php' ?>


<div class="col-md-2 form container my-5"> 

        <?php 
            if(isset($_POST['ajouter'])){
                $libelle = $_POST['libelle'];
                $prix = $_POST['prix'];
                $discount = $_POST['discount'];
                $categorie = $_POST['categorie'];
                $date = date('Y-m-d');

                if(!empty($libelle) && !empty($prix) && !empty($categorie)){
                    $sqlState = $pdo->prepare('INSERT INTO produit VALUES(null,?,?,?,?,?)');
                    $inserted = $sqlState->execute([$libelle,$prix,$discount,$categorie,$date]);
                    if($inserted){

                    ?>
                        <div class="alert alert-success" role="alert">
                            Le Produit <?php echo $libelle ?> est bien ajoutée.
                        </div>
                    <?php

                    }else{
                        ?>
                            <div class="alert alert-danger" role="alert">
                                 ERREUR (30024) !.
                            </div>  
                        <?php
                    }
                }else{
                    ?>
                        <div class="alert alert-danger" role="alert">
                            libelle, prix, categorie sont obligatoire!.
                        </div>
                    <?php
                }
            }

        ?>

        <h4>Ajouter Produit</h4>
    <form method="post">

        <div class="row g-3 align-items-center">

            <label  class="col-form-label">Libelle</label>
            <input type="text" class="form-control" name="libelle">

            <label  class="col-form-label">Prix</label>
            <input type="number" class="form-control" step="0.1" name="prix" min="1">

            <label  class="col-form-label">Discount</label>
            <input type="range" class="form-control" name="discount" min="0" max="90">

            <?php
                    $categories = $pdo->query('SELECT * FROM categorie')->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <select name="categorie" >
                <option value="">choisissez une categorie</option>
                <?php
                    foreach($categories as $categorie){
                        echo "<option value='".$categorie['id']."'>".$categorie['libelle']."</option>";
                    }
                ?>
            </select>
            
            <input type="submit" value="Ajouter Produit" class="btn btn-primary my-4" name="ajouter">
        
        </div>

    </form>
</div>


</body>
</html>