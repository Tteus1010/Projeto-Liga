<?php

require_once __DIR__ . '/../config/Database.php';

class CardGame
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function listar(): array
    {
        $sql = "SELECT id, nome FROM cardgame ORDER BY nome";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    public function buscarPorId(int $id): ?array
    {
        $sql = "SELECT id, nome FROM cardgame WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        $cardGame = $stmt->fetch();

        return $cardGame ?: null;
    }

    public function criar(string $nome): bool
    {
        $sql = "INSERT INTO cardgame (nome) VALUES (:nome)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'nome' => $nome
        ]);
    }
}