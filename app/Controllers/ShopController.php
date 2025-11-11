<?php
require_once __DIR__ . '/../Models/Product.php';
require_once __DIR__ . '/../Models/Cart.php';
require_once __DIR__ . '/../Models/ContactMessage.php';

class ShopController
{
    /**
     * Exibe a página inicial (portal) - AGORA NÃO É MAIS A ROTA PADRÃO '/'
     */
    public function home(): void
    {
        view('home'); // Esta view ainda existe, mas não é mais a rota principal
    }

    /**
     * Exibe a página principal da loja
     */
    public function index(): void
    {
        // Verifica se uma categoria foi passada pela URL (via Roteador)
        if (isset($_GET['category'])) {
            $category = $_GET['category'];
            $products = Product::findByCategory($category);
        } else {
            // Se não, busca todos os produtos
            $products = Product::findAll();
        }

        // 2. Chama a View e passa os dados para ela
        // A função view() já lida com header/footer e extrai os dados.
        // A flash message 'cart_error' será pega diretamente na view.
        view('shop', ['products' => $products]);
    }

    /**
     * Lida com a busca de produtos.
     */
    public function search(): void
    {
        // Pega o termo de busca da URL (ex: /search?q=camiseta)
        $query = trim($_GET['q'] ?? '');

        // Pede ao model para buscar os produtos
        $products = Product::searchByName($query);

        // Reutiliza a view da loja para mostrar os resultados
        // Passa a query para a view, para que possamos mostrar "Resultados para: ..."
        view('shop', ['products' => $products, 'searchQuery' => $query]);
    }

    /**
     * Exibe a página de um único produto
     */
    public function show(): void
    {
        $productId = (int)($_GET['id'] ?? 0);
        $product = Product::findById($productId);

        if (!$product) {
            // Simplesmente redireciona para a loja se o produto não for encontrado
            header('Location: ' . BASE_PATH . '/roupas');
            exit;
        }

        view('product', ['product' => $product]);
    }

    /**
     * Exibe a página de contato
     */
    public function contact(): void
    {
        view('contact');
    }

    /**
     * Processa o formulário de contato (ainda não faz nada, mas a rota existe).
     */
    public function handleContactForm(): void
    {
        // Validação básica
        if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message'])) {
            session()->flash('error', 'Todos os campos são obrigatórios.');
            redirect('/contact');
        }

        // Salva a mensagem no banco de dados
        $success = ContactMessage::create($_POST['name'], $_POST['email'], $_POST['message']);

        if ($success) {
            session()->flash('success', 'Sua mensagem foi enviada com sucesso!');
        }
        redirect('/contact'); // Redireciona em ambos os casos
    }
}