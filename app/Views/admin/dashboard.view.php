<style>
    .dashboard { max-width: 1000px; margin: 2rem auto; }
    .dashboard h2 { text-align: left; margin-bottom: 2rem; }
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 2rem; }
    .stat-card { background-color: #1a1a1a; border: 1px solid #333; padding: 20px; text-align: center; }
    .stat-card h3 { margin-top: 0; font-size: 1rem; color: #aaa; }
    .stat-card p { font-size: 2rem; font-weight: bold; margin: 0; }
    .dashboard-section { border: 1px solid #333; padding: 20px; }
    .dashboard-section h3 { margin-top: 0; }
    .chart-container { width: 70%; max-width: 400px; margin: auto; position: relative; }
</style>

<div class="dashboard">
    <h2>painel do administrador</h2>

    <!-- Botões de Ação -->
    <div style="display: flex; gap: 1rem; margin-bottom: 2rem;">
        <a href="<?php echo base_path('/admin/products/add'); ?>" class="form-button" style="text-decoration: none;">adicionar novo produto</a>
        <a href="<?php echo base_path('/admin/messages'); ?>" class="form-button" style="text-decoration: none;">ver mensagens</a>
    </div>
    
    
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
    </div>

    <!-- Seção de Produtos Mais Vendidos -->
    <div class="dashboard-section">
        <h3>produtos mais vendidos</h3>
        <div class="chart-container">
            <canvas id="bestSellingChart"></canvas>
        </div>
    </div>

</div>

<!-- Inclui a biblioteca Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Pega os dados dos produtos mais vendidos que o PHP nos forneceu
    // --- GRÁFICO 1: PRODUTOS MAIS VENDIDOS ---
    const bestSellingData = <?php echo json_encode($bestSellingProducts); ?>;

    // Prepara os arrays de nomes (labels) e quantidades (data) para o gráfico
    const labels = bestSellingData.map(product => product.name);
    const data = bestSellingData.map(product => product.total_sold);

    // Cores para cada fatia do gráfico
    const backgroundColors = [
        'rgba(255, 99, 132, 0.7)',
        'rgba(54, 162, 235, 0.7)',
        'rgba(255, 206, 86, 0.7)',
        'rgba(75, 192, 192, 0.7)',
        'rgba(153, 102, 255, 0.7)',
    ];

    // Pega o elemento <canvas>
    const ctxProducts = document.getElementById('bestSellingChart').getContext('2d');

    // Cria o novo gráfico do tipo 'doughnut'
    new Chart(ctxProducts, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                label: 'Unidades Vendidas',
                data: data,
                backgroundColor: backgroundColors,
                borderColor: '#1a1a1a', // Cor da borda entre as fatias
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top', // Posição da legenda
                    labels: {
                        color: '#fff' // Cor do texto da legenda
                    }
                }
            }
        }
    });

});
</script>