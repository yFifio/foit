<?php
// Salve este novo conteúdo em: app/Views/shop.view.php
// (Não precisa de header.php ou footer.php aqui, o helper 'view()' já cuida disso)
?>

<?php if ($cartError = session()->getFlash('cart_error')): ?>
    <p class="error-message" style="text-align: center; margin-bottom: 1rem;"><?php echo htmlspecialchars($cartError); ?></p>
<?php endif; ?>


<div class="main-layout">
    
    <aside class="sidebar-nav">
        <ul>
            <li class="has-submenu">
                <a href="#" id="brands-toggle">Marcas +</a>
                <ul class="submenu" id="brands-submenu">
                    <li><a href="#">Supreme</a></li>
                    <li><a href="#">Stüssy</a></li>
                    <li><a href="#">BAPE (A Bathing Ape)</a></li>
                    <li><a href="#">Off-White</a></li>
                    <li><a href="#">Palace Skateboards</a></li>
                    <li><a href="#">Kith</a></li>
                    <li><a href="#">Fear of God</a></li>
                    <li><a href="#">Carhartt WIP</a></li>
                    <li><a href="#">Nike</a></li>
                    <li><a href="#">Adidas Originals</a></li>
                </ul>
            </li>
            <li><a href="<?php echo base_path('/category/novo'); ?>">Novo</a></li>
            <li><a href="<?php echo base_path('/category/usado'); ?>">Usado</a></li>
            <li><a href="<?php echo base_path('/category/tenis'); ?>">Tênis</a></li>
            <li><a href="<?php echo base_path('/category/camisetas'); ?>">Camisetas</a></li>
            <li><a href="<?php echo base_path('/category/moletom'); ?>">Moletom</a></li>
            <li><a href="<?php echo base_path('/category/jaquetas'); ?>">Jaquetas</a></li>
            <li><a href="<?php echo base_path('/category/calcas'); ?>">Calças</a></li>
            <li><a href="<?php echo base_path('/category/shorts'); ?>">Shorts</a></li>
            <li><a href="<?php echo base_path('/category/bones'); ?>">Bonés</a></li>
            <li><a href="<?php echo base_path('/category/oculos'); ?>">Óculos</a></li>
            <hr style="border-color: #222; margin: 10px 0;">
            <li><a href="<?php echo base_path('/contact'); ?>">Contato</a></li>
        </ul>
    </aside>

    <div class="product-listing">
        <?php if (isset($searchQuery) && $searchQuery !== ''): ?>
            <h2>Resultados para "<?php echo htmlspecialchars($searchQuery); ?>"</h2>
        <?php else: ?>
            <h2>Mostruário</h2>
        <?php endif; ?>

        <?php if (empty($products)): ?>
            <p style="text-align: center; margin-top: 2rem;">Nenhum produto encontrado.</p>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <a href="<?php echo base_path('/product/' . $product->getId()); ?>">
                            <img src="<?php echo base_path('/images/' . htmlspecialchars($product->getImage() ?? 'placeholder.png')); ?>" alt="<?php echo htmlspecialchars($product->getName()); ?>">
                            <div class="product-card-info">
                                <span class="product-name"><?php echo htmlspecialchars($product->getName()); ?></span>
                                <span class="product-price"><?php echo $product->getFormattedPrice(); ?></span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>

</div>