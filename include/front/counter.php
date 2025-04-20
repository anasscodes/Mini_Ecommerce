<div class="counter d-flex w-50 ">
    <?php 
        $idUtilisateur = $_SESSION['utilisateur']['id'];
        $qty = $_SESSION['panier'][$idUtilisateur][$idProduit] ?? 0;
        $btn = $qty == 0 ? 'Ajouter' : 'Modifier' ;
    ?>

    <form method="post" class="counter d-flex w-50 mx-auto" action="panier.php">
        <button onclick="return false;" class="btn btn-primary mx-2 counter-moins">-</button>
        <input type="hidden" name="id" value="<?php echo $idProduit ?>">
        <input class="form-control" value="<?php echo $qty ?>" type="number" name="qty" id="qty" max="99">
        <button onclick="return false;" class="btn btn-primary mx-2 counter-plus">+</button>
        <input class="btn btn-success" type="submit" value="<?php echo $btn ?>" name="ajouter">
    </form>
     
</div>
