<?php
require_once 'Product.php';

class Cart
{
    private array $items = [];

    // Carrega o carrinho a partir da Sessão
    public function __construct()
    {
        if (isset($_SESSION['cart_items'])) {
            $this->items = $_SESSION['cart_items'];
        }
    }

    public function add(Product $product, int $quantity = 1): bool
    {
        $productId = $product->getId();
        $stockAvailable = $product->getStockQuantity(); //
        $currentQuantityInCart = $this->items[$productId]['quantity'] ?? 0;

        // Verifica se a quantidade desejada excede o estoque
        if (($currentQuantityInCart + $quantity) > $stockAvailable) {
            return false; // Falha: Estoque insuficiente
        }

        if (isset($this->items[$productId])) {
            $this->items[$productId]['quantity'] += $quantity;
            $this->items[$productId]['product_id'] = $productId;
        } else {
            $this->items[$productId] = ['product_id' => $productId, 'quantity' => $quantity];
        }
        $this->save();

        return true; // Sucesso
    }
    
    public function remove(int $productId): void
    {
        unset($this->items[$productId]);
        $this->save();
    }

    public function clear(): void
    {
        $this->items = [];
        $this->save();
    }

    private function save(): void
    {
        $_SESSION['cart_items'] = $this->items;
    }

    public function getItems(): array
    {
        $hydratedItems = [];
        if (empty($this->items)) {
            return [];
        }

        foreach ($this->items as $item) {
            if (!isset($item['product_id']) || empty($item['product_id'])) {
                continue; 
            }

            $product = Product::findById((int)$item['product_id']); //
            if ($product) {
                $hydratedItems[$product->getId()] = ['product' => $product, 'quantity' => $item['quantity']];
            }
        }
        return $hydratedItems;
    }

    // Código morto removido (getStockQuantity)

    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->getItems() as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }
        return $total;
    }

    public function getFormattedTotal(): string
    {
        return 'R$ ' . number_format($this->getTotal(), 2, ',', '.');
    }
}