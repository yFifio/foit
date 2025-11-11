<?php

require_once __DIR__ . '/../Models/Cart.php';
require_once __DIR__ . '/../Models/Order.php';

class OrderController
{
    /**
     * Verifica as pré-condições para o checkout (usuário logado, carrinho não vazio).
     */
    private function checkPrerequisites(Cart $cart): int
    {
        $userId = session()->get('user_id');

        if (!$userId) {
            redirect('/login');
        }

        if (empty($cart->getItems())) {
            redirect('/cart');
        }
        
        // CORREÇÃO P1006: Garante que o linter saiba que é um int
        return (int)$userId;
    }

    /**
     * Exibe o formulário de checkout com endereço e pagamento.
     */
    public function showCheckoutForm(): void
    {
        $cart = new Cart();
        $this->checkPrerequisites($cart);
        view('checkout', ['cart' => $cart]);
    }

    /**
     * Processa a finalização da compra após o preenchimento do formulário.
     */
    public function processOrder(): void
    {
        $cart = new Cart();
        $userId = $this->checkPrerequisites($cart); // $userId agora é um int

        // Validação básica
        if (!isset($_POST['address'], $_POST['city'], $_POST['zipcode'], $_POST['payment_method'])) {
            session()->flash('error', 'Dados do formulário em falta.');
            redirect('/checkout');
        }

        // --- CORREÇÃO DE SINTAXE (LINHA 57) ---
        // Use PONTOS ( . ) para concatenar, não vírgulas ( , )
        $address = trim($_POST['address'] . ', ' . $_POST['city'] . ' - ' . $_POST['zipcode']);
        // --- FIM DA CORREÇÃO ---

        $paymentMethod = trim($_POST['payment_method']);

        // A linha 59 (ou 61) não dará mais erro, pois $userId é um int
        $success = Order::createFromCart($userId, $cart, $address, $paymentMethod);

        if ($success) {
            $cart->clear();
            redirect('/order/success');
        }

        session()->flash('error', 'Falha ao processar o pedido. Tente novamente.');
        redirect('/checkout');
    }

    /**
     * Exibe a página de sucesso após a finalização do pedido.
     */
    public function showSuccessPage(): void
    {
        view('order_success');
    }
}