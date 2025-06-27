<?php
require_once 'include/database.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Samara - Ajouter Produit</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">

  <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

  <style>
    body {
      background: linear-gradient(to right, #f1f4f7, #ffffff);
      font-family: 'Segoe UI', sans-serif;
      padding-top: 70px;
    }

    .navbar {
      position: fixed;
      top: 0;
      width: 100%;
      background-color: rgba(255, 255, 255, 0.75);
      backdrop-filter: blur(10px);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
      z-index: 1000;
    }

    .form-container {
      background-color: rgba(255, 255, 255, 0.75);
      backdrop-filter: blur(12px);
      max-width: 700px;
      margin: 50px auto;
      padding: 35px 30px;
      border-radius: 16px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    h4 {
      text-align: center;
      margin-bottom: 25px;
      color: #0d6efd;
      font-weight: bold;
    }

    label {
      margin-top: 12px;
      font-weight: 600;
    }

    .form-control,
    select {
      border-radius: 8px;
    }

    .btn-primary {
      margin-top: 20px;
      width: 100%;
      font-weight: bold;
      border-radius: 8px;
    }

    .alert {
      font-size: 15px;
    }
  </style>
</head>
<body>

<?php include 'include/nav.php'; ?>

<div class="form-container">

  <?php 
    if (isset($_POST['ajouter'])) {
      $libelle = $_POST['libelle'];
      $prix = $_POST['prix'];
      $discount = $_POST['discount'];
      $categorie = $_POST['categorie'];
      $description = $_POST['description'];
      $date = date('Y-m-d');
      $filename = 'produit.png';

      if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $filename = uniqid() . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], 'upload/produits/' . $filename);
      }

      if (!empty($libelle) && !empty($prix) && !empty($categorie)) {
        $sqlState = $pdo->prepare('INSERT INTO produit VALUES(null,?,?,?,?,?,?,?)');
        $inserted = $sqlState->execute([$libelle, $prix, $discount, $categorie, $date, $description, $filename]);
        if ($inserted) {
          header('location: produits.php');
        } else {
          echo '<div class="alert alert-danger">❌ Une erreur est survenue !</div>';
        }
      } else {
        echo '<div class="alert alert-danger">⚠️ Libellé, prix, catégorie sont obligatoires !</div>';
      }
    }
  ?>

  <h4>Ajouter Produit</h4>

  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Libellé</label>
      <input type="text" class="form-control" name="libelle" placeholder="ex: Pomme Rouge">
    </div>

    <div class="mb-3">
      <label>Prix</label>
      <input type="number" class="form-control" step="0.1" name="prix" min="1" placeholder="ex: 15.5">
    </div>

    <div class="mb-3">
      <label>Remise (%)</label>
      <input type="range" class="form-control" name="discount" min="0" max="90">
    </div>

    <div class="mb-3">
      <label>Image</label>
      <input type="file" class="form-control" name="image">
    </div>

    <div class="mb-3">
      <label>Description</label>
      <textarea class="form-control" name="description" placeholder="Description du produit..."></textarea>
    </div>

    <div class="mb-3">
      <label>Catégorie</label>
      <select name="categorie" class="form-control">
        <option value="">-- Choisissez une catégorie --</option>
        <?php
          $categories = $pdo->query('SELECT * FROM categorie')->fetchAll(PDO::FETCH_ASSOC);
          foreach ($categories as $categorie) {
            echo "<option value='" . $categorie['id'] . "'>" . $categorie['libelle'] . "</option>";
          }
        ?>
      </select>
    </div>

    <button type="submit" name="ajouter" class="btn btn-primary">
      <i class="fas fa-plus-circle me-2"></i> Ajouter Produit
    </button>
  </form>
</div>

<script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
