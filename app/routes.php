<?php
// Salve em: app/routes.php
// $router é definido no bootstrap.php

// Rotas públicas
$router->get('/', 'ShopController@index'); // Agora a rota principal vai direto para a loja
$router->get('/roupas', 'ShopController@index');
$router->get('/product/{id}', 'ShopController@show'); // Rota dinâmica!
$router->get('/category/{category}', 'ShopController@index'); // Rota de categoria
$router->get('/search', 'ShopController@search');
$router->post('/contact', 'ShopController@handleContactForm');
$router->get('/contact', 'ShopController@contact');

// Rotas do Carrinho
$router->get('/cart', 'CartController@index');
$router->get('/cart_add/{id}', 'CartController@add');
$router->get('/cart_remove/{id}', 'CartController@remove');

// Rotas de Autenticação
$router->get('/login', 'AuthController@showLoginForm');
$router->post('/login', 'AuthController@login');
$router->get('/register', 'AuthController@showRegisterForm');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');

// Rotas de Checkout
$router->get('/checkout', 'OrderController@showCheckoutForm');
$router->post('/process_order', 'OrderController@processOrder');
$router->get('/order/success', 'OrderController@showSuccessPage');

// Rotas de Admin (Protegidas no controller)
$router->get('/admin', 'AdminController@dashboard');
$router->get('/admin/products/add', 'AdminController@showAddProductForm');
$router->get('/admin/messages', 'AdminController@showMessages');
$router->get('/admin/messages/mark_read/{id}', 'AdminController@markMessageAsRead');

// **BUG FIX:** A rota do form estava errada, agora ela aponta para cá.
$router->post('/admin/products/add', 'AdminController@addProduct');