<?php

class AuthMiddleware
{
    public static function verificar(): void
    {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?acao=login');
            exit;
        }
    }
}