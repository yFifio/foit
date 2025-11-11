<?php

// Inclui a classe de conexão
require_once __DIR__ . '/../Core/Database.php';

class Product
{
    public function __construct(
        private int $id,
        private string $name,
        private float $price,
        private ?string $description,
        private ?string $image_path,
        private int $stock_quantity,
        private ?string $category,
        private ?string $size,
        private ?string $color
    ) {
    }

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getPrice(): float { return $this->price; }
    public function getDescription(): ?string { return $this->description; }
    public function getStockQuantity(): int { return $this->stock_quantity; }
    public function getImage(): ?string { return $this->image_path; }
    public function getFormattedPrice(): string {
        return 'R$ ' . number_format($this->price, 2, ',', '.');
    }

    // --- Métodos de Banco de Dados REAIS ---

    /**
     * Busca TODOS os produtos no banco
     * @return Product[]
     */
    public static function findAll(): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM products");
        
        $results = $stmt->fetchAll();
        $products = [];

        // "Hidratar" os resultados: Transformar o array do banco em Objetos Product
        foreach ($results as $row) {
            $products[] = new Product(
                $row['id'],
                $row['name'],
                $row['price'],
                $row['description'] ?? null,
                $row['image_path'],
                $row['stock_quantity'],
                $row['category'] ?? null,
                $row['size'] ?? null,
                $row['color'] ?? null
            );
        }
        
        return $products;
    }

    /**
     * Busca UM produto pelo ID
     * @return Product|null
     */
    public static function findById(int $id): ?Product
    {
        $pdo = Database::getConnection();
        
        // Usamos prepared statements para evitar SQL Injection
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        $row = $stmt->fetch(); // fetch() em vez de fetchAll()

        if ($row === false) {
            return null; // Não encontrou
        }

        // Hidrata o objeto
        return new Product(
            $row['id'],
            $row['name'],
            $row['price'],
            $row['description'] ?? null,
            $row['image_path'],
            $row['stock_quantity'],
            $row['category'] ?? null,
            $row['size'] ?? null,
            $row['color'] ?? null
        );
    }

    /**
     * Busca produtos por categoria.
     * @return Product[]
     */
    public static function findByCategory(string $category): array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM products WHERE category = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$category]);

        $results = $stmt->fetchAll();
        $products = [];

        if (!$results) {
            return [];
        }

        // "Hidratar" os resultados
        foreach ($results as $row) {
            $products[] = new Product(
                $row['id'],
                $row['name'],
                $row['price'],
                $row['description'] ?? null,
                $row['image_path'],
                $row['stock_quantity'],
                $row['category'] ?? null,
                $row['size'] ?? null,
                $row['color'] ?? null
            );
        }
        
        return $products;
    }

    /**
     * Busca produtos por nome (usando LIKE).
     * @return Product[]
     */
    public static function searchByName(string $query): array
    {
        $pdo = Database::getConnection();
        // O uso de '%' permite buscar por partes do nome.
        $sql = "SELECT * FROM products WHERE name LIKE ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['%' . $query . '%']);

        $results = $stmt->fetchAll();
        $products = [];

        if (!$results) {
            return [];
        }

        // "Hidratar" os resultados
        foreach ($results as $row) {
            $products[] = new Product(
                $row['id'],
                $row['name'],
                $row['price'],
                $row['description'] ?? null,
                $row['image_path'],
                $row['stock_quantity'],
                $row['category'] ?? null,
                $row['size'] ?? null,
                $row['color'] ?? null
            );
        }
        
        return $products;
    }

    /**
     * Cria um novo produto no banco de dados.
     * @return bool
     */
    public static function create(string $name, float $price, string $description, ?string $image_path, int $stock, string $category, string $size, string $color): bool
    {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO products (name, price, description, image_path, stock_quantity, category, size, color) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        // Atribuição explícita para ajudar o linter
        return $stmt->execute([$name, $price, $description, $image_path, $stock, $category, $size, $color]);
    }

    /**
     * Atualiza o estoque de um produto.
     * @return bool
     */
    public static function updateStock(int $productId, int $quantitySold): bool
    {
        $pdo = Database::getConnection();
        $sql = "UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ? AND stock_quantity >= ?";
        $stmt = $pdo->prepare($sql);
        // Atribuição explícita para ajudar o linter
        return $stmt->execute([$quantitySold, $productId, $quantitySold]);
    }
}