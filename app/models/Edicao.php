<?php

require_once __DIR__ . '/../config/Database.php';

class Edicao
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function listar(): array
    {
        $sql = "
            SELECT 
                e.id,
                e.nome,
                e.cardgame,
                e.id_edicao,
                c.nome AS nome_cardgame
            FROM edicao e
            INNER JOIN cardgame c ON c.id = e.cardgame
            ORDER BY e.nome
        ";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    public function listarPorCardGame(int $cardGameId): array
    {
        $sql = "
        SELECT id, nome, id_edicao
        FROM edicao
        WHERE cardgame = :cardgame
        ORDER BY nome
    ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'cardgame' => $cardGameId
        ]);

        return $stmt->fetchAll();
    }

    public function buscarPorId(int $id): ?array
    {
        $sql = "
            SELECT 
                id,
                nome,
                cardgame,
                id_edicao
            FROM edicao
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        $edicao = $stmt->fetch();

        return $edicao ?: null;
    }

    public function criar(
        string $nome,
        int $cardGame,
        string $idEdicao
    ): bool {
        $sql = "
            INSERT INTO edicao
            (
                nome,
                cardgame,
                id_edicao
            )
            VALUES
            (
                :nome,
                :cardgame,
                :id_edicao
            )
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'nome' => $nome,
            'cardgame' => $cardGame,
            'id_edicao' => $idEdicao
        ]);
    }
}
