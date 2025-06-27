<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Liste des Commandes</title>
  <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon" />
  <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet" />
  <style>
    body {
      background: #f0f2f5;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding-bottom: 50px;
    }
    h2 {
      color: #2c3e50;
      font-weight: 700;
      margin: 2rem 0 1rem 0;
      text-align: center;
    }
    .order-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgb(0 0 0 / 0.1);
      padding: 1.5rem 2rem;
      margin-bottom: 1.5rem;
      transition: transform 0.2s ease;
    }
    .order-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgb(0 0 0 / 0.15);
    }
    .order-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #e1e4e8;
      padding-bottom: 0.5rem;
      margin-bottom: 1rem;
      font-size: 1.1rem;
      font-weight: 600;
      color: #34495e;
    }
    .order-details {
      display: flex;
      flex-wrap: wrap;
      gap: 1.5rem;
      font-size: 0.95rem;
      color: #555;
    }
    .order-details div {
      min-width: 140px;
    }
    .btn-details {
      background-color: #2980b9;
      color: white;
      border: none;
      padding: 0.4rem 1.1rem;
      border-radius: 30px;
      font-weight: 600;
      font-size: 0.9rem;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }
    .btn-details:hover {
      background-color: #1c5980;
      color: white;
      text-decoration: none;
    }
    .btn-details i {
      font-size: 1rem;
    }
  </style>
</head>
<body>

<?php include 'include/nav.php'; ?>

<div class="container">
  <h2>Liste des Commandes</h2>

  <?php
    require_once 'include/database.php';
    $commandes = $pdo->query('
      SELECT commend.*, utilisateur.login as login 
      FROM commend 
      INNER JOIN utilisateur ON commend.id_client = utilisateur.id 
      ORDER BY commend.date_creation DESC
    ')->fetchAll(PDO::FETCH_ASSOC);

    if (!$commandes) {
      echo "<p class='text-center text-muted mt-5'>Aucune commande trouvée.</p>";
    } else {
      foreach ($commandes as $commend):
  ?>
    <div class="order-card">
      <div class="order-header">
        <span>Commande #<?= htmlspecialchars($commend['id']) ?></span>
        <a href="commande.php?id=<?= $commend['id'] ?>" class="btn-details" title="Afficher détails">
          <i class="fas fa-info-circle"></i> Détails
        </a>
      </div>
      <div class="order-details">
        <div><strong>Client :</strong> <?= htmlspecialchars($commend['login']) ?></div>
        <div><strong>Total :</strong> <?= number_format($commend['total'], 2, ',', ' ') ?> MAD</div>
        <div><strong>Date :</strong> <?= htmlspecialchars($commend['date_creation']) ?></div>
      </div>
    </div>
  <?php endforeach; } ?>

</div>

<script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
