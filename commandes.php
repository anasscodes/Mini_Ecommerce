<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">

    <title>Liste des Commandes </title>

    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"  />

</head>
<body>

<?php include 'include/nav.php' ?>


<div class=" container my-5"> 
    <h2>Liste des Commandes</h2>
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
                require_once 'include/database.php';
                $commandes = $pdo->query('SELECT commend.*, utilisateur.login as "login" FROM commend INNER JOIN utilisateur ON commend.id_client = utilisateur.id ORDER BY commend.date_creation DESC')->fetchAll(PDO::FETCH_ASSOC);
                foreach($commandes as $commend){
                    ?>
                    <tr>
                        <td><?php echo $commend['id']?></td>
                        <td><?php echo $commend['login']?></td>
                        <td><?php echo $commend['total']?> MAD</td>
                        <td><?php echo $commend['date_creation']?></td>
                        <td><a class="btn btn-primary btn-sm" href="commande.php?id=<?php echo $commend['id'] ?>"> Afficher details</a></td>
                        

                    </tr>
                    <?php
                }
            ?>
        </tbody>
        
    </table>

</div>


</body>
</html>