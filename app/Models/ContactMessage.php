<?php

require_once __DIR__ . '/../Core/Database.php';

class ContactMessage
{
    /**
     * Cria uma nova mensagem de contato no banco de dados.
     */
    public static function create(string $name, string $email, string $message): bool
    {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$name, $email, $message]);
    }

    /**
     * Busca todas as mensagens de contato, das mais novas para as mais antigas.
     * @return array
     */
    public static function findAll(): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    /**
     * Conta o número de mensagens não lidas.
     * @return int
     */
    public static function countUnread(): int
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = FALSE");
        return $stmt->fetchColumn();
    }

    /**
     * Marca uma mensagem como lida.
     * @return bool
     */
    public static function markAsRead(int $id): bool
    {
        $pdo = Database::getConnection();
        $sql = "UPDATE contact_messages SET is_read = TRUE WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}