<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">

    <title>Modifier Produit</title>

    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>

<?php  require_once 'include/database.php';
         include 'include/nav.php' ?>


<div class="col-md-2 form container my-5"> 

        <?php 
         $id = $_GET['id'];
         $sqlState = $pdo->prepare('SELECT * FROM produit WHERE id=?');
         $sqlState->execute([$id]);
         $produit = $sqlState->fetch(PDO::FETCH_ASSOC);

            if(isset($_POST['modifier'])){
                $libelle = $_POST['libelle'];
                $prix = $_POST['prix'];
                $discount = $_POST['discount'];
                $categorie = $_POST['categorie'];

                if(!empty($libelle) && !empty($prix) && !empty($categorie)){
                    $sqlState = $pdo->prepare('UPDATE produit SET libelle=?,prix=?,discount=?,id_categorie=? WHERE id=?');
                    $update = $sqlState->execute([$libelle,$prix,$discount,$categorie,$id]);
                    if($update){

                        header('location: produits.php');

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

        <h4>Modifier Produit</h4>
    <form method="post">

        <div class="row g-3 align-items-center">
            <input type="hidden" class="form-control" name="id" value="<?php echo $produit['id']?>">

            <label  class="col-form-label">Libelle</label>
            <input type="text" class="form-control" name="libelle" value="<?php echo $produit['libelle']?>">

            <label  class="col-form-label">Prix</label>
            <input type="number" class="form-control" step="0.1" name="prix" min="1" value="<?php echo $produit['prix']?>">

            <label  class="col-form-label">Discount</label>
            <input type="range" class="form-control" name="discount" min="0" max="90" value="<?php echo $produit['discount']?>">

            <?php
                    $categories = $pdo->query('SELECT * FROM categorie')->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <select name="categorie" class="form-control">
                <option value="">choisissez une categorie</option>
                <?php
                    foreach($categories as $categorie){
                      
                      $selected = $produit->id_categorie == $categorie['id']?' selected ':'';
                
                        echo "<option $selected value='".$categorie['id']."'>".$categorie['libelle']."</option>";
                       
                    }
                ?>
            </select>
            
            <input type="submit" value="Modifier Produit" class="btn btn-primary my-4" name="modifier">
        
        </div>

    </form>
</div>


</body>
</html>