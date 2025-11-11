<style>
    .product-detail { text-align: center; }
    .product-detail h2 { font-size: 1.5rem; margin-bottom: 1rem; }
    .product-detail p { font-size: 1.2rem; margin-bottom: 2rem; }
    .product-detail a { border: 1px solid #fff; padding: 10px 20px; }
</style>

<div class="product-detail">
    <h2><?php echo htmlspecialchars($product->getName()); ?></h2>
    <p><?php echo $product->getFormattedPrice(); ?></p>

    <!-- Futuramente, aqui pode ir uma imagem -->
    <!-- <img src="<?php echo htmlspecialchars($product->getImage()); ?>" alt=""> -->

    <a href="<?php echo BASE_PATH; ?>/cart_add/<?php echo $product->getId(); ?>">adicionar ao carrinho</a>
</div>