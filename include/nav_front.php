<?php
// Make sure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$idUtilisateur = isset($_SESSION['utilisateur']['id']) ? $_SESSION['utilisateur']['id'] : null;
$panierCount = 0;

if ($idUtilisateur !== null && isset($_SESSION['panier'][$idUtilisateur]) && is_array($_SESSION['panier'][$idUtilisateur])) {
    $panierCount = count($_SESSION['panier'][$idUtilisateur]);
}
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">E-commerce</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Liste des Categories</a>
        </li>
      </ul>
    </div>
    <a class="btn float-end" href="ajt_panier.php">
      <i class="fa-solid fa-cart-shopping"></i> Panier (<?php echo $panierCount; ?>)
    </a>
  </div>
</nav>