<?php 
session_start();
require_once '../include/database.php';
if (!isset($_SESSION['utilisateur'])) {
    header('Location: ../connexion.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Panier</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
  <style>
    body {
      background: linear-gradient(135deg, #f7f9fc, #e0e7ff);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h2 {
      font-weight: 600;
      color: #4f8ef7;
    }

    .produit-img {
      width: 70px;
      height: 70px;
      object-fit: cover;
      border-radius: 50%;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }

    .produit-img:hover {
      transform: scale(1.1);
    }

    .btn-custom {
      min-width: 160px;
      transition: all 0.3s ease;
    }

    .btn-custom:hover {
      transform: scale(1.03);
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .table {
      background-color: #ffffff;
      border-radius: 10px;
      overflow: hidden;
    }

    .table th {
      background-color: #4f8ef7 !important;
      color: white;
    }

    .shadow-sm {
      box-shadow: 0 0 12px rgba(0,0,0,0.05) !important;
    }

    .alert {
      border-radius: 8px;
    }
  </style>
</head>
<body>

<?php include '../include/nav_front.php'; ?>

<div class="container py-5">
  <h2 class="mb-4 text-center"><i class="fas fa-shopping-cart me-2"></i>Votre panier</h2>

  <?php
    $idUtilisateur = $_SESSION['utilisateur']['id'];
    $panier = $_SESSION['panier'][$idUtilisateur] ?? [];
    $produits = [];

    if (!empty($panier)) {
        $idProduitsArray = array_keys($panier);
        if (!empty($idProduitsArray)) {
            $idProduits = implode(',', array_map('intval', $idProduitsArray));
            $stmt = $pdo->query("SELECT * FROM produit WHERE id IN ($idProduits)");
            $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    if (isset($_POST['vider'])) {
        $_SESSION['panier'][$idUtilisateur] = [];
    }

    if (isset($_POST['valider']) && !empty($produits)) {
        $sql = 'INSERT INTO ligne_commend (id_produit, id_command, prix, quantité, total) VALUES ';
        $total = 0;
        $prixProduit = [];

        foreach ($produits as $produit) {
            $idProduit = $produit['id'];
            $quantite = $panier[$idProduit] ?? 0;
            $totalProduit = $produit['prix'] * $quantite;
            $total += $totalProduit;
            $prixProduit[$idProduit] = [
                'id_produit' => $idProduit,
                'quantite' => $quantite,
                'prix' => $produit['prix'],
                'total' => $totalProduit
            ];
        }

        $sqlCommand = $pdo->prepare("INSERT INTO commend (id_client, total) VALUES (?, ?)");
        $sqlCommand->execute([$idUtilisateur, $total]);
        $idCommend = $pdo->lastInsertId();

        foreach ($prixProduit as $id => $prod) {
            $sql .= "(:id_produit$id, $idCommend, :prix$id, :quantite$id, :total$id),";
        }
        $sql = rtrim($sql, ',');
        $sqlInsert = $pdo->prepare($sql);
        foreach ($prixProduit as $id => $prod) {
            $sqlInsert->bindParam(":id_produit$id", $prod['id_produit']);
            $sqlInsert->bindParam(":prix$id", $prod['prix']);
            $sqlInsert->bindParam(":quantite$id", $prod['quantite']);
            $sqlInsert->bindParam(":total$id", $prod['total']);
        }

        $success = $sqlInsert->execute();
        if ($success) {
            $_SESSION['panier'][$idUtilisateur] = [];
            echo '<div class="alert alert-success">Commande validée avec succès !</div>';
        } else {
            echo '<div class="alert alert-danger">Erreur lors de la validation de la commande.</div>';
        }
    }
  ?>

  <?php if (!empty($produits)): ?>
    <div class="table-responsive">
      <table class="table table-hover table-bordered text-center align-middle shadow-sm">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Libellé</th>
            <th>Quantité</th>
            <th>Prix</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php $total = 0; ?>
          <?php foreach ($produits as $produit): 
            $idProduit = $produit['id'];
            $quantite = $panier[$idProduit];
            $totalProduit = $produit['prix'] * $quantite;
            $total += $totalProduit;
          ?>
          <tr>
            <td><?= $idProduit ?></td>
            <td><img src="../upload/produits/<?= htmlspecialchars($produit['image']) ?>" class="produit-img" alt=""></td>
            <td><?= htmlspecialchars($produit['libelle']) ?></td>
            <td><?php include '../include/front/counter.php'; ?></td>
            <td><?= $produit['prix'] ?> MAD</td>
            <td><strong class="text-success"><?= $totalProduit ?> MAD</strong></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot class="table-light">
          <tr>
            <td colspan="5" class="text-end fw-bold">Total général :</td>
            <td class="fw-bold text-primary"><?= $total ?> MAD</td>
          </tr>
        </tfoot>
      </table>
    </div>

    <div class="d-flex justify-content-between flex-wrap gap-3 mt-4">
      <form method="POST">
        <button type="submit" name="valider" class="btn btn-success btn-custom">
          <i class="fas fa-check-circle me-1"></i> Valider la commande
        </button>
      </form>
      <form method="POST" onsubmit="return confirm('Confirmer la suppression du panier ?');">
        <button type="submit" name="vider" class="btn btn-danger btn-custom">
          <i class="fas fa-trash me-1"></i> Vider le panier
        </button>
      </form>
    </div>

  <?php else: ?>
    <div class="alert alert-warning text-center py-4 my-5">
      <i class="fas fa-info-circle fa-2x mb-2"></i><br>
      Votre panier est vide !
    </div>
  <?php endif; ?>

</div>

<?php include '../include/footer.php'; ?>


<script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="../assets/js/counter.js"></script>
</body>
</html>