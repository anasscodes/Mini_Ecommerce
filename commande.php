<?php
require_once 'include/database.php';
$idCommande =  $_GET['id'] ;
  $sqlState = $pdo->prepare('SELECT commend.*, utilisateur.login as "login" FROM commend INNER JOIN utilisateur ON commend.id_client = utilisateur.id 
  WHERE commend.id = ?
  ORDER BY commend.date_creation DESC');
$sqlState->execute([$idCommande]);
  $commend = $sqlState->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">

    <title>Commande <?= $commend['id']?> </title>

    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"  />

</head>
<body>

<?php include 'include/nav.php' ?>


<div class=" container my-5"> 
    <h2>Commandes :</h2>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#ID</th>
                <th>Client</th>
                <th>Total</th>
                <th>Date</th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            //    $sqlStateLigneCommandes = $pdo->prepare('SELECT ligne_commend.*, produit.libelle, produit.image FROM ligne_commend 
            //         INNER JOIN produit ON ligne_commend.id_produit = produit.id    
            //               WHERE id_commande = ? ');
            //    $sqlStateLigneCommandes->execute([$idCommande]);
            //   $lignesCommande = $sqlStateLigneCommandes->fetchAll(PDO::FETCH_ASSOC);

            $sqlStateLigneCommandes = $pdo->prepare(' SELECT ligne_commend.*, produit.libelle, produit.image 
  FROM ligne_commend 
  INNER JOIN produit ON ligne_commend.id_produit = produit.id    
  WHERE ligne_commend.id_command = ?
');
$sqlStateLigneCommandes->execute([$idCommande]);
$lignesCommande = $sqlStateLigneCommandes->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <tr>
                        <td><?php echo $commend['id']?></td>
                        <td><?php echo $commend['login']?></td>
                        <td><?php echo $commend['total']?> MAD</td>
                        <td><?php echo $commend['date_creation']?></td>
                        <td>
                            <?php if($commend['valide'] == 0) : ?>
                            <a class="btn btn-success btn-sm" href="valider_commande.php?id=<?= $commend['id']?>&etat=1">Valider la Commande</a>
                            <?php else: ?>
                            <a class="btn btn-danger btn-sm" href="valider_commande.php?id=<?= $commend['id']?>&etat=0">Annuler la Commande</a>
                            <?php endif; ?>
                        </td>

                    </tr>
                    <?php
                
            ?>
        </tbody>
        
    </table>
        <hr>
        <h2>Produits :</h2>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#ID</th>
                <th>Produit</th>
                <th>prix unitaire</th>
                <th>Quantite</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
          <?php 
    foreach($lignesCommande as $ligne){
        ?>
        <tr>
            <td><?php echo $ligne['id']?></td>
            <td>
                <img src="upload/produits/<?php echo $ligne['image']?>" width="50" height="50" alt="">
                <?php echo $ligne['libelle']?>
            </td>
            <td><?php echo $ligne['prix']?> MAD</td>
            <td><?php echo $ligne['quantité']?></td>
            <td><?php echo $ligne['prix'] * $ligne['quantité']?> MAD</td>
            <!-- <td>
                <a class="btn btn-success btn-sm" href="valider_commande.php">Valider la Commande</a>
            </td> -->
        </tr>
        <?php
    }
?>
            </tbody>

    </table>

</div>


</body>
</html>