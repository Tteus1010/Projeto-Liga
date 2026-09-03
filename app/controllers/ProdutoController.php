<?php

require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . '/../models/CardGame.php';
require_once __DIR__ . '/../models/Edicao.php';

class ProdutoController
{
    private Produto $produto;
    private CardGame $cardGame;
    private Edicao $edicao;

    public function __construct()
    {
        $this->produto = new Produto();
        $this->cardGame = new CardGame();
        $this->edicao = new Edicao();
    }

    public function cadastro(): void
    {
        $cardGames = $this->cardGame->listar();

        require __DIR__ . '/../views/produto/cadastro.php';
    }

    public function listarEdicoes(): void
    {
        $cardGameId = (int) ($_GET['cardgame'] ?? 0);

        header('Content-Type: application/json');

        if ($cardGameId <= 0) {
            echo json_encode([]);
            exit;
        }

        $edicoes = $this->edicao->listarPorCardGame($cardGameId);

        echo json_encode($edicoes);
        exit;
    }

    public function criar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?acao=cadastro');
            exit;
        }

        $nome = trim($_POST['nome'] ?? '');
        $nomePort = trim($_POST['nome_port'] ?? '');
        $cardGame = (int) ($_POST['cardgame'] ?? 0);
        $edicao = (int) ($_POST['edicao'] ?? 0);
        $raridade = trim($_POST['raridade'] ?? '');

        $imagem = '';

        if (isset($_FILES['imagem'])) {
            $imagem = $this->salvarImagem($_FILES['imagem']);
        }

        if (
            empty($nome) ||
            $cardGame <= 0 ||
            $edicao <= 0
        ) {
            die('Preencha os campos obrigatórios.');
        }

        $this->produto->criar(
            $nome,
            $nomePort,
            $cardGame,
            $edicao,
            $imagem,
            $raridade
        );

        header('Location: index.php?acao=listar');
        exit;
    }

    public function listar(): void
    {
        $produtos = $this->produto->listar();

        require __DIR__ . '/../views/produto/lista.php';
    }

    public function editar(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            die('Produto inválido.');
        }

        $produto = $this->produto->buscarPorId($id);

        if (!$produto) {
            die('Produto não encontrado.');
        }

        $cardGames = $this->cardGame->listar();

        $edicoes = $this->edicao->listarPorCardGame(
            (int) $produto['cardgame']
        );

        require __DIR__ . '/../views/produto/editar.php';
    }

    public function atualizar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?acao=listar');
            exit;
        }

        $id = (int) ($_POST['id'] ?? 0);

        $nome = trim($_POST['nome'] ?? '');
        $nomePort = trim($_POST['nome_port'] ?? '');
        $cardGame = (int) ($_POST['cardgame'] ?? 0);
        $edicao = (int) ($_POST['edicao'] ?? 0);
        $raridade = trim($_POST['raridade'] ?? '');

        if (
            $id <= 0 ||
            empty($nome) ||
            $cardGame <= 0 ||
            $edicao <= 0
        ) {
            die('Dados inválidos.');
        }

        $produtoAtual = $this->produto->buscarPorId($id);

        if (!$produtoAtual) {
            die('Produto não encontrado.');
        }

        $imagem = $produtoAtual['imagem'] ?? '';

        if (
            isset($_FILES['imagem']) &&
            $_FILES['imagem']['error'] === UPLOAD_ERR_OK
        ) {
            $novaImagem = $this->salvarImagem($_FILES['imagem']);

            if ($novaImagem !== '') {
                $imagem = $novaImagem;
            }
        }

        $this->produto->atualizar(
            $id,
            $nome,
            $nomePort,
            $cardGame,
            $edicao,
            $imagem,
            $raridade
        );

        header('Location: index.php?acao=listar');
        exit;
    }

    public function excluir(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?acao=listar');
            exit;
        }

        $id = (int) ($_POST['id'] ?? 0);

        if ($id <= 0) {
            die('Produto inválido.');
        }

        $this->produto->excluir($id);

        header('Location: index.php?acao=listar');
        exit;
    }
    private function salvarImagem(array $arquivo): string
    {
        if (
            !isset($arquivo['error']) ||
            $arquivo['error'] !== UPLOAD_ERR_OK
        ) {
            return '';
        }

        // Limite de 5 MB
        if ($arquivo['size'] > 5 * 1024 * 1024) {
            die('A imagem deve ter no máximo 5 MB.');
        }

        // Verifica o tipo real do arquivo
        $finfo = new finfo(FILEINFO_MIME_TYPE);

        $tipo = $finfo->file($arquivo['tmp_name']);

        $tiposPermitidos = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp'
        ];

        if (!isset($tiposPermitidos[$tipo])) {
            die('Formato de imagem inválido. Use JPG, PNG ou WEBP.');
        }

        $extensao = $tiposPermitidos[$tipo];

        // Nome único
        $nomeArquivo = bin2hex(random_bytes(16)) . '.' . $extensao;

        $pasta = __DIR__ . '/../../public/imagens/cartas/';

        if (!is_dir($pasta)) {
            mkdir($pasta, 0775, true);
        }

        $destino = $pasta . $nomeArquivo;

        if (!move_uploaded_file($arquivo['tmp_name'], $destino)) {
            die('Não foi possível salvar a imagem.');
        }

        return $nomeArquivo;
    }
}
