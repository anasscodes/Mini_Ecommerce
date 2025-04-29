
<?php
        session_start();

        if (!isset($_SESSION['utilisateur'])) {
            header('Location: ../connexion.php');
            exit();
        }


        $id = urlencode(trim($_POST['id']));
        $idUtilisateur = $_SESSION['Utilisateur']['id'];
        unset($_SESSION['panier'][$idUtilisateur][$id]);
        header("Location:".$_SERVER['HTTP_REFERER']);
        
?>


