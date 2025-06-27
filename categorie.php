<?php
require_once 'include/database.php';

if (isset($_POST['ajouter'])) {
  $libelle = $_POST['libelle'];
  $description = $_POST['description'];
  $icone = $_POST['icone'];

  if (!empty($libelle) && !empty($description)) {
    $sqlState = $pdo->prepare('INSERT INTO categorie(libelle, description, icone) VALUES(?, ?, ?)');
    $sqlState->execute([$libelle, $description, $icone]);
    header('location: categories.php');
    exit(); // ضروري توقف التنفيذ هنا
  } else {
    $error = "⚠️ Libellé et description sont obligatoires !";
  }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Samara - Ajouter Catégorie</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon" />
  <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

  <style>
    body {
      background: linear-gradient(to right, #e3f2fd, #f8f9fa);
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding-top: 70px;
      min-height: 100vh;
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
      max-width: 600px;
      margin: 50px auto;
      padding: 35px 30px;
      border-radius: 16px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease-in-out;
    }

    h4 {
      text-align: center;
      margin-bottom: 30px;
      color: #0d6efd;
      font-weight: 700;
    }

    label {
      font-weight: 600;
      margin-top: 12px;
    }

    .form-control {
      border-radius: 8px;
    }

    .btn-primary {
      margin-top: 20px;
      width: 100%;
      border-radius: 8px;
      font-weight: bold;
      font-size: 16px;
    }

    .form-header {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 20px;
      color: #0d6efd;
    }

    .form-header i {
      font-size: 22px;
    }

    .alert {
      font-size: 15px;
    }
  </style>
</head>
<body>

<?php include 'include/nav.php'; ?>

<div class="form-container">
  <?php if (!empty($error)) : ?>
    <div class="alert alert-danger text-center"><?= $error ?></div>
  <?php endif; ?>

  <div class="form-header">
    <i class="fas fa-tags"></i>
    <h4>Ajouter une Catégorie</h4>
  </div>

  <form method="post">
    <div class="mb-3">
      <label for="libelle" class="form-label">Libellé</label>
      <input type="text" class="form-control" name="libelle" id="libelle" placeholder="ex: Fruits">
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea class="form-control" name="description" id="description" placeholder="ex: Produits frais..."></textarea>
    </div>

    <div class="mb-3">
      <label for="icone" class="form-label">Icône (classe FontAwesome)</label>
      <input type="text" class="form-control" name="icone" id="icone" placeholder="ex: fas fa-apple-alt">
    </div>

    <button type="submit" name="ajouter" class="btn btn-primary">
      <i class="fas fa-plus-circle me-2"></i>Ajouter Catégorie
    </button>
  </form>
</div>

<script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
