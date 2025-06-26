<?php 
session_start();
require_once '../include/database.php';
$id = $_GET['id'];
$sqlState = $pdo->prepare("SELECT * FROM categorie WHERE id=?");
$sqlState->execute([$id]);
$categorie = $sqlState->fetch(PDO::FETCH_ASSOC);

$sqlState = $pdo->prepare("SELECT * FROM produit WHERE id_categorie=?");
$sqlState->execute([$id]);
$produits = $sqlState->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Categorie | <?= htmlspecialchars($categorie['libelle']) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
  <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }

    h3 {
      color: #333;
      font-weight: 700;
    }

    .product-card {
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 10px;
      transition: all 0.3s ease;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .product-card:hover {
      transform: scale(1.03);
      box-shadow: 0 15px 25px rgba(0,0,0,0.12);
    }

    .product-img {
      width: 100%;
      height: 220px;
      object-fit: cover;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }

    .product-body {
      padding: 15px;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
    }

    .product-title {
      font-size: 1.1rem;
      font-weight: 600;
      color: #222;
      margin-bottom: 0.5rem;
    }

    .product-desc {
      font-size: 0.9rem;
      color: #666;
      min-height: 60px;
      margin-bottom: 1rem;
      flex-grow: 1;
    }

    .product-price {
      color: #28a745;
      font-size: 1.1rem;
      font-weight: 700;
      margin-bottom: 0.8rem;
    }

    /* Footer متقسم عموديا */
    .product-footer {
      padding: 15px;
      border-top: 1px solid #eee;
      background-color: #f9f9f9;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 10px;
      border-bottom-left-radius: 10px;
      border-bottom-right-radius: 10px;
    }

    /* زر رؤية المنتج أسفل */
    .btn-buy {
      background-color: #28a745;
      color: white;
      border-radius: 5px;
      padding: 7px 20px;
      font-size: 1rem;
      width: 100%;
      text-align: center;
      transition: background-color 0.3s ease;
      text-decoration: none;
    }

    .btn-buy:hover {
      background-color: #218838;
      color: white;
      text-decoration: none;
    }

    /* فورم التحكم في الكمية (counter.php) */
    .counter-form {
      display: flex;
      justify-content: center;
      gap: 10px;
      width: 100%;
      max-width: 180px;
    }

    .counter-form button {
      flex: 1;
      padding: 5px 0;
      border-radius: 5px;
      border: 1px solid #28a745;
      background-color: #28a745;
      color: white;
      font-size: 1.2rem;
      cursor: pointer;
      transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .counter-form button:hover {
      background-color: #218838;
      border-color: #1e7e34;
    }

    .counter-form input {
      width: 50px;
      text-align: center;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
      pointer-events: none;
      background-color: #fff;
    }
  </style>
</head>

<body>

<?php include '../include/nav_front.php'; ?>

<div class="container py-5">
  <h3 class="mb-4 text-center"><?= htmlspecialchars($categorie['libelle']) ?> 
    <span class="<?= htmlspecialchars($categorie['icone']) ?>"></span>
  </h3>

  <div class="row g-4">
    <?php if (!empty($produits)) { ?>
      <?php foreach($produits as $produit): 
        $idProduit = $produit->id;
      ?>
      <div class="col-md-4 d-flex">
        <div class="product-card w-100 d-flex flex-column">
          <img src="../upload/produits/<?= htmlspecialchars($produit->image) ?>" class="product-img" alt="<?= htmlspecialchars($produit->libelle) ?>">
          <div class="product-body">
            <h5 class="product-title"><?= htmlspecialchars($produit->libelle) ?></h5>
            <p class="product-desc"><?= htmlspecialchars($produit->description) ?></p>
            <p class="product-price"><?= number_format($produit->prix, 2) ?> MAD</p>
          </div>
          <div class="product-footer">
            <?php include '../include/front/counter.php'; ?>
            <a href="produit.php?id=<?= $idProduit ?>" class="btn-buy mt-2">
              Voir produit <i class="fas fa-eye ms-1"></i>
            </a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    <?php } else { ?>
      <div class="col-12">
        <div class="alert alert-info text-center">Aucun produit trouvé pour cette catégorie.</div>
      </div>
    <?php } ?>
  </div>
</div>

<?php include '../include/footer.php'; ?>

<script src="../assets/js/counter.js"></script>
</body>
</html>