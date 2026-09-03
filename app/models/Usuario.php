<?php

require_once __DIR__ . '/../config/Database.php';

class Usuario
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function buscarPorUsuario(string $usuario): ?array
    {
        $sql = "
            SELECT
                id,
                nome,
                usuario,
                senha,
                ativo
            FROM usuario
            WHERE usuario = :usuario
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'usuario' => $usuario
        ]);

        $usuarioEncontrado = $stmt->fetch();

        return $usuarioEncontrado ?: null;
    }

    public function criar(
        string $nome,
        string $usuario,
        string $senha
    ): bool {
        $sql = "
            INSERT INTO usuario
            (
                nome,
                usuario,
                senha
            )
            VALUES
            (
                :nome,
                :usuario,
                :senha
            )
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'nome' => $nome,
            'usuario' => $usuario,
            'senha' => password_hash($senha, PASSWORD_DEFAULT)
        ]);
    }
}