<?php 
session_start(); 
if (!isset($_SESSION['utilisateur'])) {
    header('location: connexion.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Samara Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon" />

  <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

  <style>
    body {
      background: url('https://images.pexels.com/photos/30688912/pexels-photo-30688912.jpeg?_gl=1*ji7uqi*_ga*MTU3MTc3MTI2NC4xNzI0MDY0Nzcx*_ga_8JE65Q40S6*czE3NTA5NzU2MDgkbzckZzEkdDE3NTA5NzYwOTAkajU4JGwwJGgw') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      min-height: 100vh;
      padding-top: 70px; 
      display: flex;
      justify-content: center;
      align-items: center;
      padding-left: 15px;
      padding-right: 15px;
      color: #333;
    }

    .navbar {
      background-color: rgba(255, 255, 255, 0.6) !important;
      box-shadow: 0 2px 10px rgba(0,0,0,0.07);
      backdrop-filter: blur(8px);
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1030;
      transition: background-color 0.3s ease;
    }

    .navbar .navbar-brand,
    .navbar .nav-link {
      color: #333 !important;
      font-weight: 600;
    }

    .navbar .nav-link:hover {
      color: #0d6efd !important;
    }

    .admin-box {
      background-color: rgba(255, 255, 255, 0.6);
      max-width: 600px;
      width: 100%;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.05);
      text-align: center;
    }

    .admin-icon {
      font-size: 50px;
      color: #0d6efd;
      margin-bottom: 20px;
    }

    .btn-logout {
      margin-top: 30px;
      background-color: #dc3545;
      border: none;
      font-weight: 600;
      padding: 12px 28px;
      font-size: 1.1rem;
      color: white;
      border-radius: 6px;
      text-decoration: none;
      display: inline-block;
      transition: background-color 0.3s ease;
    }

    .btn-logout:hover {
      background-color: #c82333;
      color: white;
      text-decoration: none;
    }
  </style>
</head>
<body>

<?php include 'include/nav.php'; ?>

<div class="admin-box">
  <i class="fas fa-user-shield admin-icon"></i>
  <h3>Bonjour, <strong><?= htmlspecialchars($_SESSION['utilisateur']['login']) ?></strong></h3>
  <p>Bienvenue dans votre espace d'administration.</p>
  <a href="deconnexion.php" class="btn-logout">
    <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
  </a>
</div>

<script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>