<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">

    <title>Samara</title>

    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>
<?php include '../include/nav_front.php' ?>

<div class=" container my-5 w-50"> 

        <h3>Liste des categories</h3>

        <?php 
            require_once '../include/database.php';
            $categories = $pdo->query("SELECT * FROM categorie")->fetchAll(PDO::FETCH_OBJ);
        ?>

        <ul class="list-group list-group-flush">
           <?php
            foreach($categories as $categorie){
            ?>
                <li class="list-group-item">
                    <a class="btn btn-light" href="categorie.php?id=<?php echo $categorie->id ?>">
                        <?php echo $categorie->libelle ?>
                    </a>
                </li>
            <?php
           }
           ?>
           
        </ul>
    
</div>


</body>
</html>