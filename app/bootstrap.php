<?php
// Salve em: app/bootstrap.php

// 1. Define Constantes.
// Em um setup padrão onde o DocumentRoot é a pasta /public, o BASE_PATH deve ser vazio.
// Isso simplifica a lógica e remove a dependência de `SCRIPT_NAME`.
define('BASE_PATH', '');

// 2. Inclui o autoloader (se você usar composer) ou helpers
require_once __DIR__ . '/Core/Database.php';
require_once __DIR__ . '/Core/Session.php';
require_once __DIR__ . '/Core/Router.php';
require_once __DIR__ . '/helpers.php'; // Nosso novo arquivo de helpers

// 3. Inclui os Models
require_once __DIR__ . '/Models/Product.php';
require_once __DIR__ . '/Models/User.php';
require_once __DIR__ . '/Models/Cart.php';
require_once __DIR__ . '/Models/Order.php';

// 4. Inicializa a Sessão
// A função session() vem do helpers.php e retorna a instância da classe Session
session(); 

// 5. Carrega as rotas
return Router::load(__DIR__ . '/routes.php');