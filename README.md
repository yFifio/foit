# Foit E-commerce
> "loja de roupas"

Um projeto de e-commerce de streetwear construído do zero em **PHP 8+** puro, seguindo o padrão de arquitetura **MVC (Model-View-Controller)**. Este projeto utiliza um roteador personalizado, gerenciamento de sessão e conexão segura com o banco de dados via PDO.

---

## 🚀 Funcionalidades

O sistema é dividido em duas áreas principais: a loja pública e o painel de administração.

### Loja (Pública)
* **Navegação e Descoberta:** Vitrine principal, filtragem por categoria e busca de produtos.
* **Autenticação:** Sistema completo de registro e login de usuários.
* **Carrinho de Compras:** Adicione, remova e visualize itens.
* **Checkout:** Processo de finalização de compra com atualização de estoque.
* **Contato:** Formulário de contato que salva as mensagens para o admin.

### Painel de Administração (`/admin`)
* **Dashboard:** Painel com estatísticas de receita, total de pedidos e usuários.
* **Gerenciamento de Produtos:** Formulário para adicionar novos produtos com upload de imagem.
* **Mensagens:** Visualização e gerenciamento das mensagens de contato recebidas.

---

## 🔧 Guia de Instalação

Siga estes passos para configurar o ambiente de desenvolvimento local.

### 1. Pré-requisitos

* **Servidor Local:** (XAMPP, WAMP, MAMP, etc.)
* **PHP** (versão 8.0 ou superior)
* **MySQL**
* **Apache** (com `mod_rewrite` ativado)
* **Git**

### 2. Clonar o Repositório

```bash
# Clone o projeto
git clone [https://github.com/seu-usuario/foit.git](https://github.com/seu-usuario/foit.git)

# Entre na pasta do projeto
cd foit
3. Configuração do Banco de Dados
O projeto está configurado para um banco de dados chamado foit.

A. Crie o Banco de Dados Execute o seguinte comando no seu cliente MySQL (como Admin do XAMPP, DBeaver, etc.):

SQL

CREATE DATABASE foit CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
B. Importe as Tabelas Copie e execute o script SQL abaixo para criar todas as tabelas necessárias (users, products, orders, order_items, contact_messages).

SQL

USE foit;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB;

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `category` varchar(100) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `shipping_address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_purchase` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;
C. Atualize as Credenciais Abra o arquivo app/Core/Database.php. As credenciais estão codificadas diretamente. Altere-as para corresponder à sua configuração local (especialmente a senha).

PHP

// app/Core/Database.php
private static string $host = '127.0.0.1';
private static string $dbName = 'foit';
private static string $user = 'root'; // <-- Mude se necessário
private static string $pass = '323099'; // <-- MUDE ESTA LINHA
4. Configuração do Servidor Web (Apache)
Este projeto usa "URLs Amigáveis" (ex: /login em vez de /login.php). Para isso, seu servidor web deve estar configurado para apontar para a pasta public/, e não para a raiz do projeto.

A. Ative o mod_rewrite Certifique-se de que o mod_rewrite esteja ativado no seu httpd.conf do Apache. (No XAMPP, geralmente já vem ativado).

B. Configure o Virtual Host (Recomendado) A forma correta é configurar um Virtual Host.

Abra o arquivo httpd-vhosts.conf do seu Apache.

Adicione a seguinte configuração (ajuste o caminho C:/... para onde você clonou o projeto):

Apache

<VirtualHost *:80>
    DocumentRoot "C:/caminho/para/seu/projeto/foit/public"
    ServerName foit.local
    <Directory "C:/caminho/para/seu/projeto/foit/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
Salve o arquivo e reinicie o Apache.

(Opcional) Adicione 127.0.0.1 foit.local ao seu arquivo hosts para acessar por esse nome.

Se você não fizer isso, pode precisar acessar o site por http://localhost/foit/public/, o que pode quebrar alguns links.

5. Acesse o Site
Se você configurou o Virtual Host, acesse: http://foit.local

Se não, tente: http://localhost/foit/public/

📦 Acesso ao Admin
Para testar o painel de administração:

Registre uma conta na página /register.

Acesse seu banco de dados na tabela users.

Encontre o usuário que você acabou de criar e mude o valor da coluna is_admin de 0 para 1.

Faça login novamente. Agora você verá o link "Admin" no cabeçalho e poderá acessar http://foit.local/admin.
