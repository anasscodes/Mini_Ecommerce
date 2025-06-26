<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Samara | Ajouter Utilisateur</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon" />
  <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <style>
    body {
      background: url('https://images.pexels.com/photos/264636/pexels-photo-264636.jpeg?_gl=1*doh1nb*_ga*MTU3MTc3MTI2NC4xNzI0MDY0Nzcx*_ga_8JE65Q40S6*czE3NTA5NzU2MDgkbzckZzEkdDE3NTA5NzU2MDkkajU5JGwwJGgw') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      min-height: 100vh;
    }

    .form-wrapper {
      background-color: rgba(255, 255, 255, 0.9); /* خلفية بيضاء شفافة */
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.05);
      max-width: 500px;
      margin: 60px auto;
    }

    h4 {
      font-weight: bold;
      color: #333;
      margin-bottom: 25px;
    }

    .btn-primary {
      background-color: #007bff;
      font-weight: bold;
    }

    .input-group-text {
      background-color: #f1f1f1;
    }

    .alert {
      margin-top: 15px;
    }
  </style>
</head>
<body>

<?php include 'include/nav.php'; ?>

<div class="container">
  <div class="form-wrapper">

    <?php 
      if(isset($_POST['ajouter'])){
          $login = $_POST['login'];
          $pwd = $_POST['password'];

          if(!empty($login) && !empty($pwd)){
              require_once 'include/database.php';
              $date = date('Y-m-d');
              $sqlState = $pdo->prepare('INSERT INTO utilisateur VALUES(null,?,?,?)');
              $sqlState->execute([$login,$pwd,$date]);
              header('location: connexion.php');
              exit;
          } else {
              echo '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i> Login et mot de passe sont obligatoires.</div>';
          }
      }
    ?>

    <h4><i class="fas fa-user-plus me-2"></i>Ajouter un utilisateur</h4>
    
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Login</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-user"></i></span>
          <input type="text" class="form-control" name="login" placeholder="Nom d'utilisateur" />
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Mot de passe</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
          <input type="password" class="form-control" name="password" placeholder="Mot de passe" />
        </div>
      </div>

      <div class="d-grid">
        <button type="submit" name="ajouter" class="btn btn-primary">
          <i class="fas fa-plus-circle me-2"></i>Ajouter utilisateur
        </button>
      </div>
    </form>
  </div>
</div>

</body>
</html>