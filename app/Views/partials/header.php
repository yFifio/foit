<?php
// Salve este novo conteúdo em: app/Views/partials/header.php
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foit</title>
    <link rel="stylesheet" href="<?php echo base_path('/css/style.css'); ?>">
    <!-- Adiciona a fonte 'Space Mono' do Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Barra de Pesquisa (inicialmente oculta) -->
        <div id="search-overlay" class="search-overlay">
            <button id="close-search" class="close-search-btn">&times;</button>
            <form action="<?php echo base_path('/search'); ?>" method="GET" class="search-form">
                <input type="search" name="q" placeholder="O que você procura?" autofocus>
                <button type="submit">Buscar</button>
            </form>
        </div>

        <header>
            
            <div class="header-left">
                <!-- Adicionado ID para o JavaScript -->
                <a href="#" id="search-icon" style="font-size: 1.5rem;">🔍</a> 
            </div>

            <div class="header-center">
                <div class="site-logo">
                    <a href="<?php echo base_path('/roupas'); ?>">
                        <img src="<?php echo base_path('/images/foit.png'); ?>" alt="Foit Logo">
                    </a>
                </div>
            </div>

            <div class="header-right">
                <div class="header-icons">
                    <?php if ($userName = session()->get('user_name')): ?>
                        <span class="welcome-message">Seja bem vindo, <?php echo htmlspecialchars(explode(' ', $userName)[0]); ?></span>
                        <a href="<?php echo base_path('/logout'); ?>" title="Logout">Sair</a>
                    <?php else: ?>
                        <a href="<?php echo base_path('/login'); ?>" title="Login/Registrar">👤</a>
                    <?php endif; ?>

                    <?php if (session()->get('is_admin')): ?>
                        <a href="<?php echo base_path('/admin'); ?>" title="Dashboard">Admin</a>
                    <?php endif; ?>

                    <a href="<?php echo base_path('/cart'); ?>" title="Carrinho">🛒</a>
                </div>
            </div>

        </header>

        <main>