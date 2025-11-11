<?php
// Salve em: app/helpers.php

/**
 * @return Session
 * Retorna a instância da sessão (e a inicializa se necessário).
 */
function session(): Session
{
    static $session = null;
    if ($session === null) {
        $session = new Session();
    }
    return $session;
}

/**
 * Retorna o caminho completo de um asset.
 */
function base_path(string $path = ''): string
{
    return BASE_PATH . ($path === '' ? '' : '/' . ltrim($path, '/'));
}

/**
 * Redireciona para uma nova página e morre.
 */
function redirect(string $path): void
{
    header('Location: ' . base_path($path));
    exit;
}

/**
 * Retorna para a página anterior.
 */
function redirect_back(): void
{
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? base_path('/')));
    exit;
}

/**
 * Abstrai o carregamento de uma View (Header + View + Footer).
 */
function view(string $name, array $data = []): void
{
    // Transforma as chaves do array em variáveis
    // Ex: ['products' => $list] vira a variável $products
    extract($data);

    // Carrega os "partials"
    require __DIR__ . "/Views/partials/header.php";
    require __DIR__ . "/Views/{$name}.view.php";
    require __DIR__ . "/Views/partials/footer.php";
}