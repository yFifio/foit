<?php
// Salve em: public/index.php (REESCRITO)

// 1. Carrega o bootstrap (que inicializa tudo e retorna o roteador)
$router = require __DIR__ . '/../app/bootstrap.php';

// 2. Pega a URI e o Método da requisição
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// 3. Deixa o roteador lidar com a requisição
try {
    $router->handle($uri, $method);
} catch (\Exception $e) {
    // Em produção, isso deve ser uma página de erro bonita
    echo "Erro no aplicativo: " . $e->getMessage();
}