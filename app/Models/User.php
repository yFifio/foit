<?php

require_once __DIR__ . '/../Core/Database.php';

class User
{
    public function __construct(
        private int $id,
        private string $name,
        private string $email,
        private string $password, // A senha (hash)
        private bool $is_admin
    ) {
    }

    // Getters
    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
    public function getPassword(): string { return $this->password; }
    public function isAdmin(): bool { return $this->is_admin; }

    public static function findByEmail(string $email): ?User
    {
        $pdo = Database::getConnection(); //
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch();

        if ($row === false) {
            return null;
        }

        return new User($row['id'], $row['name'], $row['email'], $row['password'], (bool)$row['is_admin']);
    }

    public static function create(string $name, string $email, string $password): bool
    {
        // Verifica se o email já existe
        if (self::findByEmail($email)) {
            return false; // Email já cadastrado
        }

        // Criptografa a senha antes de salvar
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $pdo = Database::getConnection(); //
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        
        // CORREÇÃO: Variáveis redundantes removidas
        return $stmt->execute([$name, $email, $hashedPassword]);
    }

    public static function countAll(): int
    {
        $pdo = Database::getConnection(); //
        $stmt = $pdo->query("SELECT COUNT(*) FROM users");
        return $stmt->fetchColumn();
    }
}