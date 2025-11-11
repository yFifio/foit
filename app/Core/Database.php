<?php

class Database
{
    // Configurações do banco de dados
    private static string $host = '127.0.0.1'; // ou 'localhost'
    private static string $dbName = 'foit';
    private static string $user = 'root'; // <-- Mude para seu usuário
    private static string $pass = '323099'; // <-- Mude para sua senha
    private static string $charset = 'utf8mb4';

    // A instância (Singleton) da conexão PDO
    private static ?PDO $pdo = null;

    /**
     * Construtor privado para prevenir múltiplas instâncias
     */
    private function __construct() {}

    /**
     * O método estático que obtém a conexão.
     * @return PDO
     */
    public static function getConnection(): PDO
    {
        // Se a conexão ainda não foi criada...
        if (self::$pdo === null) {
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$dbName . ";charset=" . self::$charset;
            
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lança exceções em erros
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Retorna arrays associativos
                PDO::ATTR_EMULATE_PREPARES   => false,                  // Usa "prepared statements" reais
            ];

            try {
                // ...cria a nova conexão
                self::$pdo = new PDO($dsn, self::$user, self::$pass, $options);
            } catch (\PDOException $e) {
                // Se a conexão falhar, lança um erro
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        }

        // Retorna a conexão existente
        return self::$pdo;
    }
}