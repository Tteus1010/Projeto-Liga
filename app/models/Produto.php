<?php

require_once __DIR__ . '/../config/Database.php';

class Produto
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    // READ - Listar todos
    public function listar(): array
    {
        $sql = "
            SELECT
                p.id,
                p.nome,
                p.nome_port,
                p.cardgame,
                p.edicao,
                p.imagem,
                p.raridade,
                c.nome AS nome_cardgame,
                e.nome AS nome_edicao
            FROM produto p
            INNER JOIN cardgame c ON c.id = p.cardgame
            INNER JOIN edicao e ON e.id = p.edicao
            ORDER BY p.id DESC
        ";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    // READ - Buscar um produto
    public function buscarPorId(int $id): ?array
    {
        $sql = "
            SELECT
                id,
                nome,
                nome_port,
                cardgame,
                edicao,
                imagem,
                raridade
            FROM produto
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        $produto = $stmt->fetch();

        return $produto ?: null;
    }

    // CREATE
    public function criar(
        string $nome,
        string $nomePort,
        int $cardGame,
        int $edicao,
        string $imagem,
        string $raridade
    ): bool {
        $sql = "
            INSERT INTO produto
            (
                nome,
                nome_port,
                cardgame,
                edicao,
                imagem,
                raridade
            )
            VALUES
            (
                :nome,
                :nome_port,
                :cardgame,
                :edicao,
                :imagem,
                :raridade
            )
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'nome' => $nome,
            'nome_port' => $nomePort,
            'cardgame' => $cardGame,
            'edicao' => $edicao,
            'imagem' => $imagem,
            'raridade' => $raridade
        ]);
    }

    // UPDATE
    public function atualizar(
        int $id,
        string $nome,
        string $nomePort,
        int $cardGame,
        int $edicao,
        string $imagem,
        string $raridade
    ): bool {
        $sql = "
            UPDATE produto
            SET
                nome = :nome,
                nome_port = :nome_port,
                cardgame = :cardgame,
                edicao = :edicao,
                imagem = :imagem,
                raridade = :raridade
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'nome' => $nome,
            'nome_port' => $nomePort,
            'cardgame' => $cardGame,
            'edicao' => $edicao,
            'imagem' => $imagem,
            'raridade' => $raridade
        ]);
    }

    // DELETE
    public function excluir(int $id): bool
    {
        $sql = "DELETE FROM produto WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }
}