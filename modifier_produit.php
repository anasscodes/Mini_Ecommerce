<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">

    <title>Modifier Produit</title>

    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"  />
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
                $description = $_POST['description'];

                $filename='';
                if(!empty($_FILES['image']['name'])){
                    $image = $_FILES['image']['name'];
                    $filename = uniqid().$image;
                    move_uploaded_file($_FILES['image']['tmp_name'], 'upload/produits/' . $filename );
                }

                if(!empty($libelle) && !empty($prix) && !empty($categorie)){
                    if(!empty($filename)){
                        $query = 'UPDATE produit SET libelle=?,prix=?,discount=?,id_categorie=?,description=?,image=? WHERE id=?';
                        $sqlState = $pdo->prepare($query);
                        $update = $sqlState->execute([$libelle,$prix,$discount,$categorie,$description,$filename,$id]);
                    }else{
                        $query = 'UPDATE produit SET libelle=?,prix=?,discount=?,id_categorie=?,description=? WHERE id=?';
                        $sqlState = $pdo->prepare($query);
                        $update = $sqlState->execute([$libelle,$prix,$discount,$categorie,$description,$id]);
                    }
                    
                    
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
    <form method="post" enctype="multipart/form-data">

        <div class="row g-3 align-items-center">
            <input type="hidden" class="form-control" name="id" value="<?php echo $produit['id']?>">

            <label  class="col-form-label">Libelle</label>
            <input type="text" class="form-control" name="libelle" value="<?php echo $produit['libelle']?>">

            <label  class="col-form-label">Prix</label>
            <input type="number" class="form-control" step="0.1" name="prix" min="1" value="<?php echo $produit['prix']?>">

            <label  class="col-form-label">Discount</label>
            <input type="range" class="form-control" name="discount" min="0" max="90" value="<?php echo $produit['discount']?>">

            <label  class="col-form-label">Description</label>
            <textarea class="form-control" name="description" > <?php echo $produit['description']?> </textarea>

            <label  class="col-form-label">Image</label>
            <input type="file" class="form-control" name="image">
            <img width="250" class="img img-fluid" src="upload/produits/<?php echo $produit['image']?>"><br>
            <?php
            
            ?>

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