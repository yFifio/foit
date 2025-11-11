<?php

require_once __DIR__ . '/../Core/Database.php';

class Order
{
    /**
     * Cria um novo pedido no banco de dados a partir de um carrinho.
     *
     * @param int $userId O ID do usuário que está fazendo a compra.
     * @param Cart $cart O objeto do carrinho com os itens.
     * @param string $shippingAddress O endereço de entrega.
     * @param string $paymentMethod O método de pagamento.
     * @return bool Retorna true em caso de sucesso, false em caso de falha.
     */
    public static function createFromCart(int $userId, Cart $cart, string $shippingAddress, string $paymentMethod): bool
    {
        $pdo = Database::getConnection();

        try {
            $pdo->beginTransaction();

            // 1. Inserir na tabela 'orders' com os novos campos
            $sql = "INSERT INTO orders (user_id, total_price, shipping_address, payment_method) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$userId, $cart->getTotal(), $shippingAddress, $paymentMethod]);
            $orderId = $pdo->lastInsertId();

            // 2. Inserir cada item na tabela 'order_items'
            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase) VALUES (?, ?, ?, ?)");
            foreach ($cart->getItems() as $item) {
                $product = $item['product'];
                $stmt->execute([$orderId, $product->getId(), $item['quantity'], $product->getPrice()]);

                // 3. Atualizar o estoque do produto
                $stockUpdated = Product::updateStock($product->getId(), $item['quantity']);
                if (!$stockUpdated) {
                    // Se a atualização do estoque falhar (ex: estoque insuficiente), desfaz tudo.
                    throw new \Exception("Falha ao atualizar o estoque para o produto ID: " . $product->getId());
                }
            }

            $pdo->commit();
            return true;

        } catch (\Exception $e) { // Captura tanto PDOException quanto a exceção de estoque
            $pdo->rollBack();
            // Loga o erro real para o desenvolvedor
            error_log("Falha ao criar pedido: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Retorna estatísticas básicas de pedidos.
     * @return array
     */
    public static function getStatistics(): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("
            SELECT
                COUNT(*) as total_orders,
                SUM(total_price) as total_revenue
            FROM orders
        ");
        $stats = $stmt->fetch();

        return [
            'total_orders' => $stats['total_orders'] ?? 0,
            'total_revenue' => $stats['total_revenue'] ?? 0.0,
        ];
    }

    /**
     * Retorna os produtos mais vendidos.
     * @return array
     */
    public static function getBestSellingProducts(int $limit = 5): array
    {
        $pdo = Database::getConnection();
        // Usar prepared statements é mais seguro e evita erros de análise estática.
        $sql = "SELECT p.name, SUM(oi.quantity) as total_sold 
                FROM order_items oi 
                JOIN products p ON oi.product_id = p.id 
                GROUP BY oi.product_id, p.name 
                ORDER BY total_sold DESC 
                LIMIT :limit";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT); // Informa ao PDO que o limit é um número inteiro.
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
