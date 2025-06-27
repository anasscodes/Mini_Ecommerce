<?php
require_once 'include/database.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $sql = $pdo->prepare("SELECT * FROM categorie WHERE id = ?");
    $sql->execute([$id]);
    $categorie = $sql->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['modifier'])) {
    $libelle = $_POST['libelle'];
    $description = $_POST['description'];
    $icone = $_POST['icone'];

    if (!empty($libelle) && !empty($description)) {
        $sql = $pdo->prepare("UPDATE categorie SET libelle = ?, description = ?, icone = ? WHERE id = ?");
        $sql->execute([$libelle, $description, $icone, $id]);
        header("Location: categories.php");
        exit();
    } else {
        $error = "Les champs libellé et description sont obligatoires.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier Catégorie</title>
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
      max-width: 600px;
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
  </style>
</head>
<body>

<!-- Navbar normal (non-fixed) -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="index.php"><i class="fas fa-store"></i> Samara</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="categories.php">Catégories</a></li>
        <li class="nav-item"><a class="nav-link" href="produit.php">Produits</a></li>
        <li class="nav-item"><a class="nav-link" href="commandes.php">Commandes</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container my-5">
  <div class="form-container">
    <h2><i class="fas fa-edit me-2"></i>Modifier la Catégorie</h2>

    <?php if (!empty($error)) : ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
      <input type="hidden" name="id" value="<?= $categorie['id'] ?>">

      <div class="mb-3">
        <label class="form-label">Libellé</label>
        <input type="text" class="form-control" name="libelle" value="<?= htmlspecialchars($categorie['libelle']) ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description"><?= htmlspecialchars($categorie['description']) ?></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Icône (classe FontAwesome)</label>
        <input type="text" class="form-control" name="icone" value="<?= htmlspecialchars($categorie['icone']) ?>">
      </div>

      <button type="submit" name="modifier" class="btn btn-primary">
        <i class="fas fa-check-circle me-2"></i>Modifier la Catégorie
      </button>
    </form>
  </div>
</div>

<script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
