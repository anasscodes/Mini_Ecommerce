<div>
    <?php 
        $idUtilisateur = $_SESSION['utilisateur']['id'];
        $qty = $_SESSION['panier'][$idUtilisateur][$idProduit] ?? 0;
        $btn = $qty == 0 ? 'Ajouter' : 'Modifier' ;
        
    ?>

    <form method="post" class="counter d-flex" action="panier.php">
        <button onclick="return false;" class="btn btn-primary mx-2 counter-moins">-</button>
        <input type="hidden" name="id" value="<?php echo $idProduit ?>">
        <input class="form-control" value="<?php echo $qty ?>" type="number" name="qty" id="qty" max="99">
        <button onclick="return false;" class="btn btn-primary mx-2 counter-plus">+</button>
        <input class="btn btn-success" type="submit" value="<?php echo $btn ?>" name="ajouter">
        
        <!-- ????Had supprimer khassni ne9adha ma khadamch fiha click -->
        <input formaction="supprimer_panier.php" class="btn btn-danger" type="submit" value="Supprimer" name="supprimer">
        
    </form>
     
</div>
