<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">

    <title>Samara Admin</title>

    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"  />
</head>
<body>

<?php include 'include/nav.php' ?>


<div class="col-md-2 form container my-5"> 

       <?php 
            if(!isset($_SESSION['utilisateur'])){

                header('location: connexion.php');
            }

       ?>

       <h3>BONJOUR  <?php echo $_SESSION['utilisateur']['login'] ?> </h3>
    
</div>


</body>
</html>