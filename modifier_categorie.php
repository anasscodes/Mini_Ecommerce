<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">

    <title>Samara Cat_Modifier</title>

    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>

<?php include 'include/nav.php' ?>


<div class="col-md-2 form container my-5"> 

        <?php 
        require_once 'include/database.php';
        $sqlState = $pdo->prepare('SELECT * FROM categorie WHERE id=?');
        $id = $_GET['id'];
        $sqlState->execute([$id]);
        $categorie = $sqlState->fetch(PDO::FETCH_ASSOC);
            if(isset($_POST['modifier'])){
                $libelle = $_POST['libelle'];
                $description = $_POST['description'];
            if(!empty($libelle) && !empty($description)){
                $sqlState = $pdo->prepare('UPDATE categorie SET libelle=? , description=? WHERE id=?');
                $sqlState->execute([$libelle,$description,$id]);
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

        <h4>Modifier Cat</h4>
    <form method="post">

        <div class="row g-3 align-items-center">
             <input type="hidden" class="form-control" name="id" value="<?php echo $categorie['id']?>">
            
            <label  class="col-form-label">Libelle</label>
        
            <input type="text" class="form-control" name="libelle" value="<?php echo $categorie['libelle']?>">

            <label  class="col-form-label">Description</label>
        
            <textarea class="form-control" name="description" ><?php echo $categorie['description']?></textarea>
    
            <input type="submit" value="Modifier Categorie" class="btn btn-primary my-4" name="modifier">
        
        </div>

    </form>
</div>


</body>
</html>