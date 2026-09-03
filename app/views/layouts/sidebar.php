<aside class="sidebar">

    <div class="logo">
        Projeto Liga
    </div>

    <nav>

        <a href="index.php?acao=listar">
            📦 Produtos
        </a>

        <a href="index.php?acao=cadastro">
            ➕ Novo Produto
        </a>

    </nav>

    <div class="sidebar-footer">

        <div class="usuario-logado">
            <?= htmlspecialchars($_SESSION['usuario_nome'] ?? 'Usuário') ?>
        </div>

        <a href="index.php?acao=logout">
            🚪 Sair
        </a>

    </div>

</aside>