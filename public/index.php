<?php

session_start();

require_once __DIR__ . '/../app/controllers/ProdutoController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/middleware/AuthMiddleware.php';

$produtoController = new ProdutoController();
$authController = new AuthController();

$acao = $_GET['acao'] ?? 'login';

switch ($acao) {

    // =========================
    // AUTENTICAÇÃO
    // =========================

    case 'login':
        $authController->login();
        break;

    case 'logout':
        $authController->logout();
        break;


    // =========================
    // PRODUTOS
    // =========================

    case 'cadastro':
        AuthMiddleware::verificar();
        $produtoController->cadastro();
        break;

    case 'criar':
        AuthMiddleware::verificar();
        $produtoController->criar();
        break;

    case 'listar':
        AuthMiddleware::verificar();
        $produtoController->listar();
        break;

    case 'listar-edicoes':
        AuthMiddleware::verificar();
        $produtoController->listarEdicoes();
        break;

    case 'editar':
        AuthMiddleware::verificar();
        $produtoController->editar();
        break;

    case 'atualizar':
        AuthMiddleware::verificar();
        $produtoController->atualizar();
        break;

    case 'excluir':
        AuthMiddleware::verificar();
        $produtoController->excluir();
        break;


    // =========================
    // ERRO
    // =========================

    default:
        http_response_code(404);
        echo 'Página não encontrada.';
        break;
}