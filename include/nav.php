<?php 
if (session_status() === PHP_SESSION_NONE) session_start(); 

$connecte = false;
if (isset($_SESSION['utilisateur'])) {
  $connecte = true;
}
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">E-commerce</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
      data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <!-- Navigation à gauche -->
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">
            <i class="fas fa-user-plus"></i> Ajouter utilisateur
          </a>
        </li>

        <?php if ($connecte): ?>
          <li class="nav-item">
            <a class="nav-link" href="produits.php">
              <i class="fas fa-box"></i> Liste des Produits
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="categories.php">
              <i class="fas fa-layer-group"></i> Liste des Catégories
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="categorie.php">
              <i class="fas fa-plus-square"></i> Ajouter Catégorie
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="produit.php">
              <i class="fas fa-plus-circle"></i> Ajouter Produit
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="commandes.php">
              <i class="fas fa-receipt"></i> Commandes
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="deconnexion.php">
              <i class="fas fa-sign-out-alt"></i> Déconnexion
            </a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="connexion.php">
              <i class="fas fa-sign-in-alt"></i> Connexion
            </a>
          </li>
        <?php endif; ?>
      </ul>

      <!-- Bouton Retour Client -->
      <div class="d-flex">
        <a href="http://localhost/Project-Ecommerce/Front1/" class="btn btn-outline-dark me-2">
          Accés Site 
        </a>
      </div>
    </div>
  </div>
</nav>
