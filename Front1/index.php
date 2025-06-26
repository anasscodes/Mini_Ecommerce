<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Accueil | Samara</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Bootstrap + Font Awesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <!-- Style personnalisé -->
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #F2FDF3, #F2FDF3); /* uniforme */
      color: #1c1c1c;
    }

    .hero {
      background: url('https://images.pexels.com/photos/1092730/pexels-photo-1092730.jpeg?_gl=1*nyp28*_ga*MTU3MTc3MTI2NC4xNzI0MDY0Nzcx*_ga_8JE65Q40S6*czE3NTA0NTg3NTUkbzYkZzEkdDE3NTA0NTg5NzEkajkkbDAkaDA.') center/cover no-repeat;
      height: 85vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-align: center;
      position: relative;
    }

    .hero::before {
      content: '';
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      z-index: 1;
    }

    .hero-content {
      position: relative;
      z-index: 2;
    }

    #categories {
      padding: 60px 0;
      background: #F2FDF3; /* couleur fruits douce */
    }

    .category-card {
      transition: 0.3s ease-in-out;
      border-radius: 12px;
      background: #ffffff;
      border: 1px solid #e0e0e0;
      box-shadow: 0 0 0 transparent;
    }

    .category-card:hover {
      transform: scale(1.03);
      border-color: #54B948;
      box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
      background: #ffffff;
    }

    .category-card a {
      display: flex;
      align-items: center;
      padding: 20px 25px;
      color: #1c1c1c;
      text-decoration: none;
      font-size: 1.1rem;
      font-weight: 500;
    }

    .category-card i {
      color: #54B948;
      font-size: 24px;
      margin-right: 12px;
    }

    h3.section-title {
      color: #1c1c1c;
      font-weight: bold;
      border-left: 6px solid #54B948;
      padding-left: 15px;
      margin-bottom: 40px;
    }

    .btn.btn-light.btn-lg {
      background-color: #54B948;
      border: none;
      color: white;
      font-weight: bold;
      padding: 12px 30px;
      transition: background 0.3s ease;
    }

    .btn.btn-light.btn-lg:hover {
      background-color: #e74c3c;
      color: white;
    }
  </style>
</head>

<body>

<?php include '../include/nav_front.php'; ?>

<!-- Section Hero -->
<section class="hero">
  <div class="hero-content">
    <h1 class="display-4 fw-bold">Bienvenue chez Samara</h1>
    <p class="lead">Découvrez nos meilleures catégories de produits frais</p>
    <a href="#categories" class="btn btn-light btn-lg mt-3">
      <i class="fa fa-arrow-down me-2"></i> Voir les catégories
    </a>
  </div>
</section>

<!-- Nos Catégories -->
<section id="categories" class="container">
  <h3 class="section-title"><i class="fa-solid fa-list"></i> Nos Catégories</h3>

  <?php 
    require_once '../include/database.php';
    $categories = $pdo->query("SELECT * FROM categorie")->fetchAll(PDO::FETCH_OBJ);
  ?>

  <div class="row">
    <?php foreach($categories as $categorie): ?>
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="category-card">
          <a href="categorie.php?id=<?php echo $categorie->id ?>">
            <i class="<?php echo $categorie->icone ?>"></i>
            <?php echo $categorie->libelle ?>
          </a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php include '../include/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>