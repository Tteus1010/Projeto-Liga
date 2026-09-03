<?php

class Database
{
    private string $host;
    private string $database;
    private string $user;
    private string $password;

    public function __construct()
    {
        $this->host = getenv('DB_HOST') ?: 'mysql';
        $this->database = getenv('DB_DATABASE') ?: 'db_projliga';
        $this->user = getenv('DB_USER') ?: 'root';
        $this->password = getenv('DB_PASSWORD') ?: 'root';
    }

    public function connect(): PDO
    {
        try {
            $pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4",
                $this->user,
                $this->password
            );

            $pdo->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            $pdo->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );

            return $pdo;

        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados." . $e->getMessage());
        }
    }
}