<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Samara Connexion</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon" />
  <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <style>
    body {
      background: url('https://images.pexels.com/photos/8422728/pexels-photo-8422728.jpeg?_gl=1*xn01mu*_ga*MTU3MTc3MTI2NC4xNzI0MDY0Nzcx*_ga_8JE65Q40S6*czE3NTA5NzU2MDgkbzckZzEkdDE3NTA5Nzc1ODkkajE0JGwwJGgw') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding-top: 90px; /* Espace pour navbar */
    }

    .navbar {
      background-color: rgba(255, 255, 255, 0.7) !important;
      backdrop-filter: blur(8px);
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
    }

    .navbar .navbar-brand,
    .navbar .nav-link {
      color: #333 !important;
    }

    .navbar .nav-link:hover {
      color: #0d6efd !important;
    }

    .form-container {
      max-width: 420px;
      margin: auto;
      background: rgba(255, 255, 255, 0.75);
      padding: 35px 30px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    h4 {
      text-align: center;
      margin-bottom: 25px;
      color: #0d6efd;
      font-weight: 700;
    }

    .btn-primary {
      font-weight: bold;
    }

    .alert {
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

<?php include 'include/nav.php'; ?>

<div class="form-container">
  <?php
    if(isset($_POST['connexion'])){
      $login = trim($_POST['login']);
      $pwd = trim($_POST['password']);

      if($login !== '' && $pwd !== '') {
        require_once 'include/database.php';
        $sqlState = $pdo->prepare('SELECT * FROM utilisateur WHERE login = ? AND password = ?');
        $sqlState->execute([$login, $pwd]);

        if($sqlState->rowCount() >= 1){
          $_SESSION['utilisateur'] = $sqlState->fetch();
          header('Location: admin.php');
          exit;
        } else {
          echo '<div class="alert alert-danger text-center">Login ou mot de passe incorrect.</div>';
        }
      } else {
        echo '<div class="alert alert-danger text-center">Les champs sont obligatoires.</div>';
      }
    }
  ?>

  <h4><i class="fas fa-sign-in-alt me-2"></i>Connexion</h4>
  <form method="post" novalidate>
    <div class="mb-3">
      <label for="login" class="form-label">Login</label>
      <input type="text" id="login" name="login" class="form-control" required autofocus />
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Mot de passe</label>
      <input type="password" id="password" name="password" class="form-control" required />
    </div>
    <button type="submit" name="connexion" class="btn btn-primary w-100">
      <i class="fas fa-sign-in-alt me-2"></i> Se connecter
    </button>
  </form>
</div>

<script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>