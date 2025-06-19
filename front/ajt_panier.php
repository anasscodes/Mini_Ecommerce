<?php 
session_start();
require_once '../include/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
  <link rel="stylesheet" href="../assets/css/counter.css">
  <title>Panier</title>

  <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css"> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>
<body>

<?php include '../include/nav_front.php' ?>

<div class="container my-5 w-80"> 
  <?php 
    $idUtilisateur = $_SESSION['utilisateur']['id'] ?? null;
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

        $sqlStateCommand = $pdo->prepare("INSERT INTO commend (id_client, total) VALUES (?, ?)");
        $sqlStateCommand->execute([$idUtilisateur, $total]);
        $idCommend = $pdo->lastInsertId();

        foreach ($prixProduit as $id => $prod) {
            $sql .= "(:id_produit$id, $idCommend, :prix$id, :quantite$id, :total$id),";
        }

        $sql = rtrim($sql, ',');

        $sqlState = $pdo->prepare($sql);
        foreach ($prixProduit as $id => $prod) {
            $sqlState->bindParam(":id_produit$id", $prod['id_produit'], PDO::PARAM_INT);
            $sqlState->bindParam(":prix$id", $prod['prix'], PDO::PARAM_STR);
            $sqlState->bindParam(":quantite$id", $prod['quantite'], PDO::PARAM_INT);
            $sqlState->bindParam(":total$id", $prod['total'], PDO::PARAM_STR);
        }

        $inserted = $sqlState->execute();
        if ($inserted) {
            $_SESSION['panier'][$idUtilisateur] = [];
            echo '<div class="alert alert-success">Votre commande a été validée avec succès !</div>';
        } else {
            echo '<div class="alert alert-danger">Erreur lors de la validation de la commande.</div>';
        }
    }
  ?>

  <h3>Panier (<?php echo count($panier); ?>)</h3>
  <div class="container my-4">
    <div class="row">
      <?php if (!empty($produits)) : ?>
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Image</th>
              <th>Libelle</th>
              <th>Quantité</th>
              <th>Prix</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $total = 0;
              foreach ($produits as $produit): 
                $idProduit = $produit['id'];
                $quantite = $panier[$idProduit] ?? 0;
                $totalProduit = $produit['prix'] * $quantite;
                $total += $totalProduit;
            ?>
              <tr>
                <td><?php echo htmlspecialchars($produit['id']); ?></td>
                <td><img width="80" src="../upload/produits/<?php echo htmlspecialchars($produit['image']); ?>" alt=""></td>
                <td><?php echo htmlspecialchars($produit['libelle']); ?></td>
                <td><?php include '../include/front/counter.php'; ?></td>
                <td><?php echo htmlspecialchars($produit['prix']); ?> MAD</td>
                <td><?php echo htmlspecialchars($totalProduit); ?> MAD</td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="5" class="text-end"><strong>Total</strong></td>
              <td><?php echo $total; ?> MAD</td>
            </tr>
            <tr>
              <td colspan="6" class="text-end">
                <form method="POST">
                  <input type="submit" class="btn btn-success" name="valider" value="Valider la commande">
                  <input onclick="return confirm('Voulez-vous vraiment vider le panier ?')" type="submit" class="btn btn-danger" name="vider" value="Vider le panier">
                </form>
              </td>
            </tr>
          </tfoot>
        </table>
      <?php else: ?>
        <div class="alert alert-warning">Votre panier est vide !</div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script src="../assets/js/counter.js"></script>
</body>
</html>
