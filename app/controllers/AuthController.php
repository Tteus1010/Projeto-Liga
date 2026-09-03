<?php

require_once __DIR__ . '/../models/Usuario.php';

class AuthController
{
    private Usuario $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario = trim($_POST['usuario'] ?? '');
            $senha = $_POST['senha'] ?? '';

            if (empty($usuario) || empty($senha)) {
                $erro = 'Informe usuário e senha.';

                require __DIR__ . '/../views/auth/login.php';
                return;
            }

            $usuarioEncontrado = $this->usuario->buscarPorUsuario($usuario);

            if (
                !$usuarioEncontrado ||
                !$usuarioEncontrado['ativo'] ||
                !password_verify($senha, $usuarioEncontrado['senha'])
            ) {
                $erro = 'Usuário ou senha inválidos.';

                require __DIR__ . '/../views/auth/login.php';
                return;
            }

            session_regenerate_id(true);

            $_SESSION['usuario_id'] = $usuarioEncontrado['id'];
            $_SESSION['usuario_nome'] = $usuarioEncontrado['nome'];
            $_SESSION['usuario_usuario'] = $usuarioEncontrado['usuario'];

            header('Location: index.php?acao=listar');
            exit;
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();

        header('Location: index.php?acao=login');
        exit;
    }
}