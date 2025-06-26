<?php 
session_start();
require_once '../include/database.php';

if (!isset($_GET['id'])) {
    echo "ID du produit manquant.";
    exit;
}

$id = $_GET['id'];
$sqlState = $pdo->prepare("SELECT * FROM produit WHERE id=?");
$sqlState->execute([$id]);
$produit = $sqlState->fetch(PDO::FETCH_ASSOC);

if (!$produit) {
    echo "Produit introuvable.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($produit['libelle']) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../images/logo.png">
  <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/counter.css">
  <style>
    body {
      background: linear-gradient(to right, #f8f9fa, #e0f7fa);
      font-family: 'Segoe UI', sans-serif;
    }
    .product-wrapper {
      background-color: #fff;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.08);
      margin-top: 40px;
    }
    .product-img {
      width: 100%;
      border-radius: 12px;
      object-fit: cover;
      max-height: 400px;
    }
    .price-original {
      text-decoration: line-through;
      color: #dc3545;
      font-weight: bold;
    }
    .price-final {
      color: #28a745;
      font-size: 1.5rem;
      font-weight: bold;
      margin-left: 10px;
    }
    .discount-badge {
      background-color: #ffc107;
      color: #000;
      font-weight: bold;
      padding: 5px 10px;
      border-radius: 5px;
      margin-left: 10px;
    }
    .product-description {
      color: #555;
      margin-top: 15px;
      font-size: 1rem;
    }
    .divider {
      border-top: 1px solid #ddd;
      margin: 20px 0;
    }
  </style>
</head>
<body>

<?php include '../include/nav_front.php'; ?>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10 product-wrapper">
      <div class="row">
        <div class="col-md-6 mb-4">
          <img src="../upload/produits/<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['libelle']) ?>" class="product-img">
        </div>
        <div class="col-md-6">
          <h2 class="fw-bold"><?= htmlspecialchars($produit['libelle']) ?></h2>

          <?php if (!empty($produit['discount'])): ?>
            <div class="d-flex align-items-center mt-2">
              <span class="price-original"><?= number_format($produit['prix'], 2) ?> MAD</span>
              <span class="price-final">
                <?= number_format($produit['prix'] - ($produit['prix'] * $produit['discount'] / 100), 2) ?> MAD
              </span>
              <span class="discount-badge">-<?= htmlspecialchars($produit['discount']) ?>%</span>
            </div>
          <?php else: ?>
            <div class="mt-2">
              <span class="price-final"><?= number_format($produit['prix'], 2) ?> MAD</span>
            </div>
          <?php endif; ?>

          <div class="product-description"><?= nl2br(htmlspecialchars($produit['description'])) ?></div>

          <div class="divider"></div>

          <?php 
            $idProduit = $produit['id'];
            $idUtilisateur = $_SESSION['utilisateur']['id'] ?? null;
            include '../include/front/counter.php'; 
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="../assets/js/counter.js"></script>

</body>
</html>