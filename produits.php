<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Samara - Liste Produits</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">

  <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

  <style>
    body {
      background: linear-gradient(120deg, #f2f6fc, #e3ebf5);
      font-family: 'Segoe UI', sans-serif;
      padding-top: 70px;
    }

    .navbar {
      position: fixed;
      top: 0;
      width: 100%;
      background-color: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(8px);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
      z-index: 1000;
    }

    .container {
      background-color: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(6px);
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    h2 {
      color: #0d6efd;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .btn-primary {
      margin-bottom: 20px;
      border-radius: 8px;
      font-weight: 500;
    }

    .table {
      border-radius: 12px;
      overflow: hidden;
      background-color: #fff;
    }

    .table th {
      background-color: #f1f3f5;
      color: #495057;
    }

    .table td img {
      border-radius: 6px;
      border: 1px solid #dee2e6;
    }

    .btn-sm {
      border-radius: 6px;
    }
  </style>
</head>
<body>

<?php include 'include/nav.php'; ?>

<div class="container my-5">
  <h2><i class="fas fa-box-open me-2"></i>Liste des Produits</h2>
  <a href="categorie.php" class="btn btn-primary"><i class="fas fa-plus-circle me-1"></i> Ajouter Catégorie</a>

  <div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
      <thead>
        <tr>
          <th>#ID</th>
          <th>Libellé</th>
          <th>Prix</th>
          <th>Remise</th>
          <th>Catégorie</th>
          <th>Image</th>
          <th>Date Création</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          require_once 'include/database.php';
          $categories = $pdo->query("SELECT produit.*, categorie.libelle as 'categorie_libelle' FROM produit INNER JOIN categorie ON produit.id_categorie = categorie.id")->fetchAll(PDO::FETCH_OBJ);
          foreach ($categories as $produit) {
            $prix = $produit->prix;
            $discount = $produit->discount;
            $prixFinal = $prix - (($prix * $discount) / 100);
        ?>
        <tr>
          <td><?= $produit->id ?></td>
          <td><?= $produit->libelle ?></td>
          <td><?= number_format($produit->prix, 2) ?> MAD</td>
          <td><?= $produit->discount ?>%</td>
          <td><?= $produit->categorie_libelle ?></td>
          <td>
            <img src="upload/produits/<?= $produit->image ?>" width="70" alt="<?= $produit->libelle ?>">
          </td>
          <td><?= $produit->date_creation ?></td>
          <td>
            <a href="modifier_produit.php?id=<?= $produit->id ?>" class="btn btn-sm btn-primary mb-1"><i class="fas fa-edit"></i></a>
            <a href="supprimer_produit.php?id=<?= $produit->id ?>" onclick="return confirm('Voulez-vous vraiment supprimer le produit <?= $produit->libelle ?> ?');" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
