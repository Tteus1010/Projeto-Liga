<?php require __DIR__ . '/../layouts/header.php'; ?>

<h1>Cadastrar Produto</h1>

<!-- formulário -->

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
        }

        h1 {
            margin-top: 0;
        }

        .campo {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }

        button {
            padding: 12px 20px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="container">

        <h1>Cadastrar Produto</h1>

        <form
            action="index.php?acao=criar"
            method="POST"
            enctype="multipart/form-data">

            <div class="campo">
                <label for="nome">
                    Nome da carta
                </label>

                <input
                    type="text"
                    id="nome"
                    name="nome"
                    required>
            </div>

            <div class="campo">
                <label for="nome_port">
                    Nome em português
                </label>

                <input
                    type="text"
                    id="nome_port"
                    name="nome_port">
            </div>

            <div class="campo">
                <label for="cardgame">
                    Card Game
                </label>

                <select
                    id="cardgame"
                    name="cardgame"
                    required>

                    <option value="">
                        Selecione um Card Game
                    </option>
                    <pre>
<?php
var_dump($cardGames);
?>
</pre>
                    <?php foreach ($cardGames as $cardGame): ?>

                        <option value="<?= $cardGame['id'] ?>">
                            <?= htmlspecialchars($cardGame['nome']) ?>
                        </option>

                    <?php endforeach; ?>

                </select>
            </div>

            <div class="campo">
                <label for="edicao">
                    Edição
                </label>

                <select
                    id="edicao"
                    name="edicao"
                    required
                    disabled>

                    <option value="">
                        Selecione primeiro o Card Game
                    </option>

                </select>
            </div>

            <div class="campo">
                <label for="raridade">
                    Raridade
                </label>

                <input
                    type="text"
                    id="raridade"
                    name="raridade">
            </div>

            <div class="campo">
                <label for="imagem">
                    Imagem
                </label>

                <input
                    type="file"
                    id="imagem"
                    name="imagem"
                    accept="image/*">
            </div>

            <button type="submit">
                Cadastrar Produto
            </button>

        </form>

    </div>
    <script>
const cardGameSelect = document.getElementById('cardgame');
const edicaoSelect = document.getElementById('edicao');

cardGameSelect.addEventListener('change', async function () {

    const cardGameId = this.value;

    // Nenhum Card Game selecionado
    if (!cardGameId) {

        edicaoSelect.disabled = true;

        edicaoSelect.innerHTML = `
            <option value="">Selecione primeiro o Card Game</option>
        `;

        return;
    }

    // Card Game selecionado
    edicaoSelect.disabled = true;

    edicaoSelect.innerHTML = `
        <option value="">Carregando...</option>
    `;

    try {

        const resposta = await fetch(
            `index.php?acao=listar-edicoes&cardgame=${cardGameId}`
        );

        if (!resposta.ok) {
            throw new Error('Erro ao carregar edições.');
        }

        const edicoes = await resposta.json();

        edicaoSelect.innerHTML = `
            <option value="">Selecione uma edição</option>
        `;

        edicoes.forEach(edicao => {

            const option = document.createElement('option');

            option.value = edicao.id;
            option.textContent = edicao.nome;

            edicaoSelect.appendChild(option);
        });

        if (edicoes.length === 0) {

            edicaoSelect.innerHTML = `
                <option value="">Nenhuma edição encontrada</option>
            `;

            edicaoSelect.disabled = true;

            return;
        }

        // Habilita somente se encontrou edições
        edicaoSelect.disabled = false;

    } catch (erro) {

        console.error(erro);

        edicaoSelect.innerHTML = `
            <option value="">Erro ao carregar edições</option>
        `;

        edicaoSelect.disabled = true;
    }
});
</script>
<?php require __DIR__ . '/../layouts/footer.php'; ?>