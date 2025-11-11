<?php

require_once __DIR__ . '/../Models/Product.php';
require_once __DIR__ . '/../Models/Order.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/ContactMessage.php';


class AdminController
{
    public function __construct()
    {
        // --- CORREÇÃO AQUI ---
        // Use o helper session()->get()
        if (session()->get('is_admin') !== true) {
            redirect('/login'); // Use o helper redirect()
        }
        // --- FIM DA CORREÇÃO ---
    }

    /**
     * Exibe o painel de administração com estatísticas.
     */
    public function dashboard(): void
    {
        // 1. Buscar os dados para o painel
        $orderStats = Order::getStatistics();
        $totalUsers = User::countAll();
        $unreadMessages = ContactMessage::countUnread();
        $bestSellingProducts = Order::getBestSellingProducts(5);

        // 2. Formatar a receita para exibição
        $formattedRevenue = 'R$ ' . number_format($orderStats['total_revenue'] ?? 0, 2, ',', '.');

        // 3. Renderizar a view do painel
        view('admin/dashboard', [
            'orderStats' => $orderStats,
            'totalUsers' => $totalUsers,
            'unreadMessages' => $unreadMessages,
            'bestSellingProducts' => $bestSellingProducts,
            'formattedRevenue' => $formattedRevenue,
        ]);
    }

    /**
     * Exibe a página com as mensagens de contato.
     */
    public function showMessages(): void
    {
        $messages = ContactMessage::findAll();
        view('admin/messages', ['messages' => $messages]);
    }

    /**
     * Marca uma mensagem como lida.
     */
    public function markMessageAsRead(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            ContactMessage::markAsRead($id);
        }
        redirect('/admin/messages');
    }

    /**
     * Exibe o formulário para adicionar um novo produto.
     */
    public function showAddProductForm(): void
    {
        view('admin/add_product');
    }

    /**
     * Processa o formulário e adiciona um novo produto.
     */
    public function addProduct(): void
    {
        // 1. Validação básica dos dados do formulário
        $name = $_POST['name'] ?? '';
        $price = (float)($_POST['price'] ?? 0);
        $stock = (int)($_POST['stock'] ?? 0);
        $description = $_POST['description'] ?? '';
        $category = $_POST['category'] ?? '';
        $size = $_POST['size'] ?? '';
        $color = $_POST['color'] ?? '';

        if (empty($name) || $price <= 0 || $stock < 0) {
            session()->flash('error', 'Nome, preço e estoque são obrigatórios.');
            redirect('/admin/products/add');
            return;
        }

        // 2. Lida com o upload da imagem
        $image_path = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/images/products/';
            // Garante que o nome do arquivo seja único para evitar sobreposições
            $filename = uniqid() . '-' . basename($_FILES['image']['name']);
            $targetFile = $uploadDir . $filename;

            // Cria o diretório se ele não existir
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                // Salva o caminho relativo que será usado na tag <img>
                $image_path = '/images/products/' . $filename;
            } else {
                session()->flash('error', 'Falha ao fazer upload da imagem.');
                redirect('/admin/products/add');
                return;
            }
        }

        // 3. Cria o produto no banco de dados
        $success = Product::create($name, $price, $description, $image_path, $stock, $category, $size, $color);

        if ($success) {
            session()->flash('success', 'Produto adicionado com sucesso!');
            redirect('/admin'); // Redireciona para o dashboard
        } else {
            session()->flash('error', 'Ocorreu um erro ao adicionar o produto.');
            // Se o produto falhou em ser criado, deleta a imagem que foi upada
            if ($image_path && file_exists($targetFile)) {
                unlink($targetFile);
            }
            redirect('/admin/products/add');
        }
    }
}