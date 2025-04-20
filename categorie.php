<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">

    <title>Samara Categorie</title>

    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>

<?php include 'include/nav.php' ?>


<div class="col-md-2 form container my-5"> 

        <?php 
        if(isset($_POST['ajouter'])){
            $libelle = $_POST['libelle'];
            $description = $_POST['description'];
            $icone = $_POST['icone'];

        if(!empty($libelle) && !empty($description)){
            require_once 'include/database.php';
            $sqlState = $pdo->prepare('INSERT INTO categorie(libelle,description,icone) VALUES(?,?,?)');
            $sqlState->execute([$libelle,$description,$icone]);
            header('location: categories.php');
        }else{
        ?>
          <div class="alert alert-danger">
            libelle , description sont obligatoire!.
          </div>

            <?php
            }
        }

        ?>

        <h4>Ajouter Categorie</h4>
    <form method="post">

        <div class="row g-3 align-items-center">

            <label  class="col-form-label">Libelle</label>
        
            <input type="text" class="form-control" name="libelle">

            <label  class="col-form-label">Description</label>
        
            <textarea class="form-control" name="description" ></textarea>

            <label  class="col-form-label">Icône</label>
        
            <input type="text" class="form-control" name="icone">
    
            <input type="submit" value="Ajouter Categorie" class="btn btn-primary my-4" name="ajouter">
        
        </div>

    </form>
</div>


</body>
</html>