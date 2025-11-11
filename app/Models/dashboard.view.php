<?php require __DIR__ . '/../partials/header.php'; ?>

<style>
    .dashboard { max-width: 1000px; margin: 0 auto; }
    .dashboard h2 { text-align: left; margin-bottom: 2rem; }
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 2rem; }
    .stat-card { background-color: #1a1a1a; border: 1px solid #333; padding: 20px; text-align: center; }
    .stat-card h3 { margin-top: 0; font-size: 1rem; color: #aaa; }
    .stat-card p { font-size: 2rem; font-weight: bold; margin: 0; }
    .dashboard-section { border: 1px solid #333; padding: 20px; }
    .dashboard-section h3 { margin-top: 0; }
    .dashboard-section ul { list-style: none; padding: 0; }
    .dashboard-section li { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #222; }
    .dashboard-section li:last-child { border-bottom: none; }
</style>

<div class="dashboard">
    <h2>painel do administrador</h2>

    <!-- Grade de Estatísticas Rápidas -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>receita total</h3>
            <p><?php echo $formattedRevenue; ?></p>
        </div>
        <div class="stat-card">
            <h3>pedidos totais</h3>
            <p><?php echo htmlspecialchars($orderStats['total_orders']); ?></p>
        </div>
        <div class="stat-card">
            <h3>usuários cadastrados</h3>
            <p><?php echo htmlspecialchars($totalUsers); ?></p>
        </div>
        <div class="stat-card">
            <h3>novas mensagens</h3>
            <p>
                <a href="<?php echo base_path('/admin/messages'); ?>" style="text-decoration: none; color: #fff;"><?php echo htmlspecialchars($unreadMessages); ?></a>
            </p>
        </div>
    </div>

    <!-- Seção de Produtos Mais Vendidos -->
    <div class="dashboard-section">
        <h3>produtos mais vendidos</h3>
        <ul>
            <?php foreach ($bestSellingProducts as $product): ?>
                <li>
                    <span><?php echo htmlspecialchars($product['name']); ?></span>
                    <strong><?php echo htmlspecialchars($product['total_sold']); ?> vendidos</strong>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>