<?php
require_once 'include/database.php';
$idCommande = $_GET['id'];
$sqlState = $pdo->prepare('
    SELECT commend.*, utilisateur.login as "login" 
    FROM commend 
    INNER JOIN utilisateur ON commend.id_client = utilisateur.id 
    WHERE commend.id = ?
    ORDER BY commend.date_creation DESC
');
$sqlState->execute([$idCommande]);
$commend = $sqlState->fetch(PDO::FETCH_ASSOC);

$sqlStateLigneCommandes = $pdo->prepare('
    SELECT ligne_commend.*, produit.libelle, produit.image 
    FROM ligne_commend 
    INNER JOIN produit ON ligne_commend.id_produit = produit.id    
    WHERE ligne_commend.id_command = ?
');
$sqlStateLigneCommandes->execute([$idCommande]);
$lignesCommande = $sqlStateLigneCommandes->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Commande #<?= htmlspecialchars($commend['id']) ?></title>
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon" />
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            background: #f9fafb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-header {
            background-color: #0d6efd;
            color: white;
            font-weight: 600;
            font-size: 1.25rem;
        }
        .btn-validate {
            background-color: #198754;
            border: none;
            color: white;
        }
        .btn-validate:hover {
            background-color: #146c43;
            color: white;
        }
        .btn-cancel {
            background-color: #dc3545;
            border: none;
            color: white;
        }
        .btn-cancel:hover {
            background-color: #b02a37;
            color: white;
        }
        table thead {
            background-color: #0d6efd;
            color: white;
        }
        table tbody tr:hover {
            background-color: #e7f1ff;
        }
        img.product-img {
            border-radius: 6px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<?php include 'include/nav.php' ?>

<div class="container my-5">

    <div class="card shadow-sm mb-4">
        <div class="card-header">
            Détails de la commande #<?= htmlspecialchars($commend['id']) ?>
        </div>
        <div class="card-body">
            <p><strong>Client :</strong> <?= htmlspecialchars($commend['login']) ?></p>
            <p><strong>Total :</strong> <?= number_format($commend['total'], 2, ',', ' ') ?> MAD</p>
            <p><strong>Date :</strong> <?= htmlspecialchars($commend['date_creation']) ?></p>
            <div>
                <?php if ($commend['valide'] == 0) : ?>
                    <a href="valider_commande.php?id=<?= $commend['id'] ?>&etat=1" class="btn btn-validate me-2">
                        <i class="fas fa-check-circle"></i> Valider la commande
                    </a>
                <?php else : ?>
                    <a href="valider_commande.php?id=<?= $commend['id'] ?>&etat=0" class="btn btn-cancel me-2">
                        <i class="fas fa-times-circle"></i> Annuler la commande
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <h3 class="mb-3">Produits commandés :</h3>

    <table class="table table-hover align-middle shadow-sm bg-white rounded">
        <thead>
            <tr>
                <th>#ID</th>
                <th>Produit</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lignesCommande as $ligne) : ?>
                <tr>
                    <td><?= htmlspecialchars($ligne['id']) ?></td>
                    <td>
                        <img src="upload/produits/<?= htmlspecialchars($ligne['image']) ?>" alt="<?= htmlspecialchars($ligne['libelle']) ?>" width="60" height="60" class="product-img me-2" />
                        <?= htmlspecialchars($ligne['libelle']) ?>
                    </td>
                    <td><?= number_format($ligne['prix'], 2, ',', ' ') ?> MAD</td>
                    <td><?= (int)$ligne['quantité'] ?></td>
                    <td><?= number_format($ligne['prix'] * $ligne['quantité'], 2, ',', ' ') ?> MAD</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
