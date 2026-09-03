<?php require __DIR__ . '/../layouts/header.php'; ?>

<h1>Produtos</h1>

<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f4f4;
        margin: 0;
        padding: 40px;
    }

    .container {
        max-width: 1200px;
        margin: auto;
        background: white;
        padding: 30px;
        border-radius: 8px;
    }

    .topo {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    h1 {
        margin: 0;
    }

    .botao {
        display: inline-block;
        padding: 10px 16px;
        background: #333;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        border: none;
        cursor: pointer;
    }

    .botao:hover {
        background: #555;
    }

    .editar {
        background: #2563eb;
    }

    .editar:hover {
        background: #1d4ed8;
    }

    .excluir {
        background: #dc2626;
    }

    .excluir:hover {
        background: #b91c1c;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    th {
        background: #f0f0f0;
    }

    tr:hover {
        background: #f9f9f9;
    }

    .acoes {
        display: flex;
        gap: 8px;
    }

    .acoes form {
        margin: 0;
    }

    .sem-produtos {
        text-align: center;
        padding: 30px;
        color: #666;
    }
</style>
</head>

<body>

    <div class="container">

        <div class="topo">

            <h1>Produtos cadastrados</h1>

            <a
                href="index.php?acao=cadastro"
                class="botao">
                + Novo produto
            </a>

        </div>

        <?php if (empty($produtos)): ?>

            <div class="sem-produtos">
                Nenhum produto cadastrado.
            </div>

        <?php else: ?>

            <table>

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Nome em português</th>
                        <th>Card Game</th>
                        <th>Edição</th>
                        <th>Imagem</th>
                        <th>Raridade</th>
                        <th>Ações</th>
                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($produtos as $produto): ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars($produto['id']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($produto['nome']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($produto['nome_port'] ?? '') ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($produto['nome_cardgame']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($produto['nome_edicao']) ?>
                            </td>
                            <td>
                                <?php if (!empty($produto['imagem'])): ?>

                                    <img
                                        src="imagens/cartas/<?= htmlspecialchars($produto['imagem']) ?>"
                                        alt="<?= htmlspecialchars($produto['nome']) ?>"
                                        class="imagem-produto">

                                <?php else: ?>

                                    <span>Sem imagem</span>

                                <?php endif; ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($produto['raridade'] ?? '') ?>
                            </td>

                            <td>

                                <div class="acoes">

                                    <a
                                        href="index.php?acao=editar&id=<?= $produto['id'] ?>"
                                        class="botao editar">
                                        Editar
                                    </a>

                                    <form
                                        action="index.php?acao=excluir"
                                        method="POST"
                                        onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">

                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?= $produto['id'] ?>">

                                        <button
                                            type="submit"
                                            class="botao excluir">
                                            Excluir
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        <?php endif; ?>

    </div>

</body>
<?php require __DIR__ . '/../layouts/footer.php'; ?>