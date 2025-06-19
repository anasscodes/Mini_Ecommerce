<?php 
  session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil | Samara</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
    }
    .hero {
      background: url('https://images.unsplash.com/photo-1606788075761-962cdb73ebda?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
      height: 90vh;
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
    .list-group-item a {
      display: block;
      padding: 0.75rem 1rem;
      color: #212529;
      text-decoration: none;
      transition: background 0.3s ease;
    }
    .list-group-item a:hover {
      background-color: #f8f9fa;
    }
  </style>
</head>
<body>

<?php include '../include/nav_front.php'; ?>

<!-- Hero section -->
<section class="hero">
  <div class="hero-content">
    <h1 class="display-4">Bienvenue chez Samara</h1>
    <p class="lead">Choisissez votre catégorie préférée et découvrez nos produits.</p>
  </div>
</section>

<!-- Liste des catégories -->
<div class="container my-5 w-50"> 
  <h3><i class="fa-solid fa-list"></i> Liste des catégories</h3>

  <?php 
    require_once '../include/database.php';
    $categories = $pdo->query("SELECT * FROM categorie")->fetchAll(PDO::FETCH_OBJ);
  ?>

  <ul class="list-group list-group-flush">
    <?php foreach($categories as $categorie): ?>
      <li class="list-group-item">
        <a class="btn btn-light w-100 text-start" href="categorie.php?id=<?php echo $categorie->id ?>">
          <i class="<?php echo $categorie->icone ?> me-2"></i> <?php echo $categorie->libelle ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
