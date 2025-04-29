<?php 
        session_start();
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
    <link rel="stylesheet" href="../assets/css/counter.css">
    <title>Categorie | <?php echo $categorie['libelle'] ?> </title>

    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"  />

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

</head>
<body>
<?php include '../include/nav_front.php' ?>

<div class=" container my-5 w-80 "> 

     <h3><?php echo $categorie['libelle'] ?> <span class="<?php echo $categorie['icone'] ?>"></span></h3>
     <div class="container my-4">
    <div class="row">
        <?php if (!empty($produits)) { ?>
            <?php foreach($produits as $produit) { 
                $idProduit = $produit->id;
                ?>
                <div class="col-md-4 ">
                    <div class="card mb-3">
                        <img  src="../upload/produits/<?php echo htmlspecialchars($produit->image); ?>" class="card-img-top w-50 mx-auto" alt="Image de <?php echo htmlspecialchars($produit->libelle); ?>">
                        <div class="card-body ">
                            <a href="produit.php?id=<?php echo ($idProduit);?>" class="btn stretched-link">Affichage Produits</a>
                            <h5 class="card-title"><?php echo htmlspecialchars($produit->libelle); ?></h5>
                            <p class="card-text"><?php echo ($produit->description); ?></p>
                            <p class="card-text"><?php echo number_format($produit->prix, 2); ?> MAD</p>
                            <p class="card-text"><small class="text-body-secondary">Ajouter Le <?php echo date("d/m/Y", strtotime($produit->date_creation)); ?></small></p>
                        </div>
                        <div class="card-footer" style="z-index: 10">

                            <?php include '../include/front/counter.php' ?>
                            
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <h4 class="text-center alert alert-info" role="alert">Aucun produit disponible.</h4>
        <?php } ?>
    </div>
</div>

</div>

<script src="../assets/js/counter.js"></script>

</body>
</html>