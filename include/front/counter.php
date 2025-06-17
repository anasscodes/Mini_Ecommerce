<div>
    <?php 
        $idUtilisateur = $_SESSION['utilisateur']['id'];
        $qty = $_SESSION['panier'][$idUtilisateur][$idProduit] ?? 0;
        $btn = $qty == 0 ? 'fa-cart-plus' : 'fa-pen';
    ?>

    <form method="post" class="d-flex align-items-center justify-content-between" action="panier.php" style="gap: 1rem;">

        <!-- Minus + input + Plus (حافظ على الكود الأصلي) -->
        <div class="d-flex align-items-center">
            <!-- Bouton moins -->
            <button onclick="return false;" class="btn btn-outline-primary mx-2 counter-moins" title="Moins">
                <i class="fas fa-minus"></i>
            </button>

            <!-- Champ quantité -->
            <input type="hidden" name="id" value="<?php echo $idProduit ?>">
            <input class="form-control text-center" value="<?php echo $qty ?>" type="number" name="qty" id="qty" max="99" style="width: 80px;">

            <!-- Bouton plus -->
            <button onclick="return false;" class="btn btn-outline-primary mx-2 counter-plus" title="Plus">
                <i class="fas fa-plus"></i>
            </button>
        </div>

        <!-- Ajouter/Modifier و Supprimer -->
        <div class="d-flex align-items-center" style="gap: 0.5rem;">
            <button class="btn btn-success mx-2" type="submit" name="ajouter" title="<?php echo $qty == 0 ? 'Ajouter' : 'Modifier'; ?>">
                <i class="fas <?php echo $btn; ?>"></i>
            </button>

            <?php if($qty != 0): ?>
                <button formaction="supprimer_panier.php" class="btn btn-danger" type="submit" name="supprimer" title="Supprimer">
                    <i class="fas fa-trash-alt"></i>
                </button>
            <?php endif; ?>
        </div>

    </form>
</div>