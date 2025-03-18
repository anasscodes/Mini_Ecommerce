<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">

    <title>Samara</title>

    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>

<?php include 'include/nav.php' ?>


<div class="col-md-2 form container my-5"> 

    <?php 
                if(isset($_POST['connexion'])){
                    $login = $_POST['login'];
                    $pwd = $_POST['password'];

                    if(!empty($login) && !empty($pwd)){
                        require_once 'include/database.php';

                        $sqlState = $pdo->prepare('SELECT * FROM utilisateur WHERE login=? AND password=?');
                        $sqlState->execute([$login,$pwd]);
                            if($sqlState->rowCount()>=1){
                                session_start();
                                $_SESSION['utilisateur'] = $sqlState->fetch();
                                //redirection
                            header('location: admin.php');
                            
                    }else{

                    ?>

                                <div class="alert alert-danger">
                                    login ou password incorrectes.
                                </div>

                    <?php
    
                    }

                }else{

                    ?>
                        <div class="alert alert-danger">
                            login , password sont obligatoire!.
                        </div>

                    <?php

                }
            }
    ?>

        <h4>Connexion</h4>
    <form method="post">

        <div class="row g-3 align-items-center">

            <label  class="col-form-label">Login</label>
        
            <input type="text" class="form-control" name="login">

            <label  class="col-form-label">Password</label>
        
            <input type="password" class="form-control" name="password">
    
            <input type="submit" value="Connexion" class="btn btn-primary my-4" name="connexion">
        
        </div>

    </form>
</div>


</body>
</html>