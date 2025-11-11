<style>
    .cart-page h2 { text-align: left; }
    .cart-page .cart-total { text-align: right; margin-top: 2rem; font-size: 1.2rem; }
    .cart-page .empty-cart { text-align: center; margin-top: 2rem; }
</style>

<div class="cart-page">
    <h2>carrinho</h2>

    <?php if (empty($cart->getItems())): ?>
        <p class="empty-cart">seu carrinho está vazio.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($cart->getItems() as $item): ?>
                <li class="cart-item">
                    <div class="cart-item-info">
                       <span><?php echo htmlspecialchars($item['product']->getName()); ?> (x<?php echo $item['quantity']; ?>)</span>
                    </div>
                    <a href="<?php echo BASE_PATH; ?>/cart_remove/<?php echo $item['product']->getId(); ?>">[x] remover</a>
                </li>
            <?php endforeach; ?>
        </ul>
        <h3 class="cart-total">Total: <?php echo $cart->getFormattedTotal(); ?></h3>

        <div style="text-align: right; margin-top: 20px;">
            <a href="<?php echo BASE_PATH; ?>/checkout" class="form-button" style="display: inline-block; width: auto; text-decoration: none;">Finalizar Compra</a>
        </div>

    <?php endif; ?>
</div>