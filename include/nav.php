<?php 

session_start();
$connecte = false;
if(isset($_SESSION['utilisateur'])){
  $connecte = true;
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
          <a class="nav-link active" aria-current="page" href="index.php">Ajouter utilisateur</a>
        </li>

        <?php
          if($connecte){
            ?>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="categories.php">Liste des Categories</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="categorie.php">Ajouter Categorie</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="produit.php">Ajouter Produit</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="deconnexion.php">Deconnexion</a>
            </li>
            <?php
          }else{
          ?>

        <li class="nav-item">
          <a class="nav-link" href="connexion.php">Connexion</a>
        </li>

            <?php
          }

          ?>

      </ul>
    </div>
  </div>
</nav>