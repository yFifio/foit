<?php
// app/Controllers/CartController.php (REESCRITO)

class CartController
{
    /**
     * Exibe a página do carrinho
     */
    public function index(): void
    {
        $cart = new Cart();
        view('cart', ['cart' => $cart]); // Passa os dados para o helper
    }

    /**
     * Adiciona um item ao carrinho
     */
    public function add(): void
    {
        $productId = (int)$_GET['id']; // O Roteador colocou o ID aqui
        $product = Product::findById($productId);

        if ($product) {
            $cart = new Cart();
            $success = $cart->add($product, 1);

            if (!$success) {
                session()->flash('cart_error', 'Estoque insuficiente para o produto selecionado.');
            }
        }
        
        // Redireciona de volta para a loja
        redirect('/roupas');
    }

    /**
     * Remove um item do carrinho
     */
    public function remove(): void
    {
        $productId = (int)$_GET['id'];
        $cart = new Cart();
        $cart->remove($productId);
        
        redirect('/cart');
    }
}