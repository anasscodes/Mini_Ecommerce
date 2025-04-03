<?php 
    require_once '../include/database.php';
    $id = $_GET['id'];
    $sqlState = $pdo->prepare("SELECT * FROM categorie WHERE id=?");
    $sqlState->execute([$id]);
    $categorie = $sqlState->fetch(PDO::FETCH_ASSOC);

    $sqlState = $pdo->prepare("SELECT * FROM produit WHERE id_categorie=?");
    $sqlState->execute([$id]);
    $produits = $sqlState->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">

    <title>Categorie | <?php echo $categorie['libelle'] ?> </title>

    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>
<?php include '../include/nav_front.php' ?>

<div class=" container my-5 w-50"> 

     <h3><?php echo $categorie['libelle'] ?></h3>
     <div class="container my-4">
    <div class="row">
        <?php if (!empty($produits)) { ?>
            <?php foreach($produits as $produit) { ?>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <img src="<?php echo htmlspecialchars($produit->image); ?>" class="card-img-top" alt="Image de <?php echo htmlspecialchars($produit->libelle); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($produit->libelle); ?></h5>
                            <p class="card-text"><?php echo number_format($produit->prix, 2); ?> MAD</p>
                            <p class="card-text"><small class="text-body-secondary">Ajouter Le <?php echo date("d/m/Y", strtotime($produit->date_creation)); ?></small></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p class="text-center">Aucun produit disponible.</p>
        <?php } ?>
    </div>
</div>

</div>


</body>
</html>