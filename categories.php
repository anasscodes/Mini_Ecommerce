<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Samara - Catégories</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon" />
  <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <style>
    body {
      background: linear-gradient(135deg, #f8f9fa, #e0e7ff);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding-top: 70px; /* navbar fix */
    }
    .navbar {
      position: fixed;
      top: 0; left: 0; right: 0;
      background: rgba(255,255,255,0.9);
      backdrop-filter: blur(10px);
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      z-index: 1030;
    }
    .container {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    h2 {
      color: #2c3e50;
      margin-bottom: 20px;
      font-weight: 700;
    }
    .btn-primary {
      border-radius: 8px;
      font-weight: 600;
    }
    table {
      border-radius: 12px;
      overflow: hidden;
      background: white;
    }
    table thead {
      background: #f3f4f6;
    }
    table thead th {
      color: #34495e;
      font-weight: 600;
    }
    table tbody tr:hover {
      background-color: #f1f5f9;
    }
    .table i {
      font-size: 22px;
      color: #0d6efd;
    }
    .btn-sm {
      border-radius: 6px;
      padding: 5px 10px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }
    .btn-modifier {
      background-color: #0d6efd;
      color: white;
      border: none;
    }
    .btn-modifier:hover {
      background-color: #0b5ed7;
      color: white;
    }
    .btn-supprimer {
      background-color: #dc3545;
      color: white;
      border: none;
    }
    .btn-supprimer:hover {
      background-color: #bb2d3b;
      color: white;
    }
    .btn-sm i {
      font-size: 16px;
    }
  </style>
</head>
<body>

<?php include 'include/nav.php'; ?>

<div class="container my-5">
  <h2><i class="fas fa-tags me-2"></i>Liste des Catégories</h2>
  <a href="produit.php" class="btn btn-primary mb-3"><i class="fas fa-plus me-1"></i> Ajouter Produit</a>
  
  <div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
      <thead>
        <tr>
          <th>#ID</th>
          <th>Libellé</th>
          <th>Description</th>
          <th>Icône</th>
          <th>Date Création</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          require_once 'include/database.php';
          $categories = $pdo->query('SELECT * FROM categorie')->fetchAll(PDO::FETCH_ASSOC);
          foreach ($categories as $categorie): ?>
          <tr>
            <td><?= htmlspecialchars($categorie['id']) ?></td>
            <td><?= htmlspecialchars($categorie['libelle']) ?></td>
            <td><?= htmlspecialchars($categorie['description']) ?></td>
            <td><i class="<?= htmlspecialchars($categorie['icone']) ?>"></i></td>
            <td><?= htmlspecialchars($categorie['date-creation']) ?></td>
            <td>
            <a href="modifier_categorie.php?id=<?= $categorie['id'] ?>" class="btn btn-primary btn-sm" title="Modifier"><i class="fas fa-edit text-white"></i></a>
            <a href="supprimer_categorie.php?id=<?= $categorie['id'] ?>" onclick="return confirm('Voulez-vous vraiment supprimer la catégorie <?= addslashes($categorie['libelle']) ?> ?');" class="btn btn-danger btn-sm" title="Supprimer"><i class="fas fa-trash text-white"></i></a>

            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
