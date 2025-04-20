<?php 
        session_start();
    require_once '../include/database.php';

    // Vérifier si l'ID du produit est passé dans l'URL
    if (!isset($_GET['id'])) {
        echo "ID du produit manquant.";
        exit; // Si l'ID n'est pas présent, on arrête l'exécution du script
    }

    // Récupérer l'ID du produit depuis l'URL
    $id = $_GET['id'];

    // Préparer la requête SQL pour récupérer le produit
    $sqlState = $pdo->prepare("SELECT * FROM produit WHERE id=?");
    $sqlState->execute([$id]);

    // Récupérer le produit sous forme de tableau associatif
    $produit = $sqlState->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le produit existe
    if (!$produit) {
        echo "Produit introuvable."; // Afficher un message si le produit n'est pas trouvé
        exit; // Si le produit n'existe pas, on arrête l'exécution du script
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Produit | <?php echo htmlspecialchars($produit['libelle']); ?> </title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"  />
    <link rel="stylesheet" href="../assets/css/counter.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>
<body>
<?php include '../include/nav_front.php' ?>

<div class="container my-5 w-50">
    <!-- Affichage du produit -->
    <h3><?php echo htmlspecialchars($produit['libelle']); ?></h3>
    <div class="container my-4">
        <div class="row">
            <div class="col-md-6">
                <img class="img img-fluid w-75" src="../upload/produits/<?php echo htmlspecialchars($produit['image']); ?>" alt="Image de <?php echo htmlspecialchars($produit['libelle']); ?>">
            </div>
            <div class="col-md-6">
                <?php
                    $discount = $produit['discount'];
                    $prix = $produit['prix'];
                ?>
                <div class="d-flex align-items-center">
                    <h1 class="w-100"><?php echo htmlspecialchars($produit['libelle']); ?></h1>
                    <?php
                    if (!empty($produit['discount'])) {
                        ?>
                        <p>
                            <span class="badge text-bg-success"> - <?php echo htmlspecialchars($discount); ?> %</span>
                        </p>
                        <?php
                    }
                    ?>
                </div>
                <hr>

                <p><?php echo htmlspecialchars($produit['description']); ?></p>

                <hr>
                <div class="d-flex">
                    <?php
                    if (!empty($discount)) {
                        $total = $prix - (($prix * $discount) / 100);
                        ?>
                        <h5 class="mx-1">
                            <span class="badge text-bg-danger"> <strike><?php echo htmlspecialchars($prix); ?> MAD</strike> </span>
                        </h5>

                        <h5 class="mx-1">
                            <span class="badge text-bg-success"><?php echo htmlspecialchars($total); ?> MAD </span>
                        </h5>

                        <?php
                    } else {
                        $total = $prix;
                        ?>
                        <span class="badge text-bg-success"> <?php echo htmlspecialchars($prix); ?> MAD </span>
                        <?php
                    }
                    ?>
                </div>
                <hr>
                <?php 
                    $idProduit = $produit['id'];
                include '../include/front/counter.php' ?>
            </div>
        </div>
    </div>
</div>

<script src="../assets/js/counter.js"></script>

</body>
</html>
