<?php
require_once 'include/database.php';
include 'include/nav.php';

$id = $_GET['id'];
$sqlState = $pdo->prepare('SELECT * FROM produit WHERE id=?');
$sqlState->execute([$id]);
$produit = $sqlState->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['modifier'])) {
    $libelle = $_POST['libelle'];
    $prix = $_POST['prix'];
    $discount = $_POST['discount'];
    $categorie = $_POST['categorie'];
    $description = $_POST['description'];

    $filename = '';
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $filename = uniqid() . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], 'upload/produits/' . $filename);
    }

    if (!empty($libelle) && !empty($prix) && !empty($categorie)) {
        if (!empty($filename)) {
            $query = 'UPDATE produit SET libelle=?, prix=?, discount=?, id_categorie=?, description=?, image=? WHERE id=?';
            $sqlState = $pdo->prepare($query);
            $update = $sqlState->execute([$libelle, $prix, $discount, $categorie, $description, $filename, $id]);
        } else {
            $query = 'UPDATE produit SET libelle=?, prix=?, discount=?, id_categorie=?, description=? WHERE id=?';
            $sqlState = $pdo->prepare($query);
            $update = $sqlState->execute([$libelle, $prix, $discount, $categorie, $description, $id]);
        }

        if ($update) {
            header('location: produits.php');
            exit();
        } else {
            $error = "Erreur lors de la mise à jour du produit.";
        }
    } else {
        $error = "Les champs libellé, prix et catégorie sont obligatoires.";
    }
}

$categories = $pdo->query('SELECT * FROM categorie')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier Produit</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
  <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <style>
    body {
      background: linear-gradient(to right, #f8f9fa, #dceeff);
      padding-top: 20px;
      font-family: 'Segoe UI', sans-serif;
    }
    .form-container {
      max-width: 700px;
      margin: auto;
      background: white;
      padding: 35px;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #0d6efd;
      font-weight: 700;
      margin-bottom: 25px;
    }
    .form-label {
      font-weight: 600;
    }
    .btn-primary {
      width: 100%;
      font-weight: bold;
      border-radius: 10px;
    }
    .form-img-preview {
      margin-top: 10px;
      width: 100%;
      max-width: 250px;
      border-radius: 8px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

<div class="container my-5">
  <div class="form-container">
    <h2><i class="fas fa-edit me-2"></i>Modifier le Produit</h2>

    <?php if (!empty($error)) : ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $produit['id'] ?>">

      <div class="mb-3">
        <label class="form-label">Libellé</label>
        <input type="text" class="form-control" name="libelle" value="<?= htmlspecialchars($produit['libelle']) ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Prix</label>
        <input type="number" step="0.1" min="1" class="form-control" name="prix" value="<?= $produit['prix'] ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Discount</label>
        <input type="range" class="form-range" name="discount" min="0" max="90" value="<?= $produit['discount'] ?>">
        <span><?= $produit['discount'] ?>%</span>
      </div>

      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description"><?= htmlspecialchars($produit['description']) ?></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Image</label>
        <input type="file" class="form-control" name="image">
        <img src="upload/produits/<?= $produit['image'] ?>" class="form-img-preview mt-2" alt="Image produit">
      </div>

      <div class="mb-3">
        <label class="form-label">Catégorie</label>
        <select name="categorie" class="form-select">
          <option value="">Choisissez une catégorie</option>
          <?php foreach ($categories as $categorie): 
              $selected = $produit['id_categorie'] == $categorie['id'] ? 'selected' : '';
          ?>
            <option value="<?= $categorie['id'] ?>" <?= $selected ?>>
              <?= htmlspecialchars($categorie['libelle']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <button type="submit" name="modifier" class="btn btn-primary">
        <i class="fas fa-check-circle me-2"></i>Modifier le Produit
      </button>
    </form>
  </div>
</div>

<script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
