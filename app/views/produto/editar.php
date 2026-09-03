<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="pagina">

    <div class="cabecalho-pagina">

        <div>
            <h1>Editar Produto</h1>
            <p>Atualize as informações e a imagem do produto.</p>
        </div>

        <a
            href="index.php?acao=listar"
            class="botao-voltar"
        >
            ← Voltar
        </a>

    </div>


    <form
        action="index.php?acao=atualizar"
        method="POST"
        enctype="multipart/form-data"
        class="form-produto"
    >

        <input
            type="hidden"
            name="id"
            value="<?= $produto['id'] ?>"
        >


        <!-- INFORMAÇÕES -->

        <div class="card-form">

            <div class="card-titulo">
                <h2>Informações do produto</h2>
                <span>Dados principais</span>
            </div>


            <div class="form-grid">

                <div class="campo campo-full">

                    <label for="nome">
                        Nome
                    </label>

                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        value="<?= htmlspecialchars($produto['nome']) ?>"
                        placeholder="Digite o nome do produto"
                        required
                    >

                </div>


                <div class="campo campo-full">

                    <label for="nome_port">
                        Nome em Português
                    </label>

                    <input
                        type="text"
                        id="nome_port"
                        name="nome_port"
                        value="<?= htmlspecialchars($produto['nome_port'] ?? '') ?>"
                        placeholder="Digite o nome em português"
                    >

                </div>


                <div class="campo">

                    <label for="cardgame">
                        Card Game
                    </label>

                    <select
                        name="cardgame"
                        id="cardgame"
                        required
                    >

                        <option value="">
                            Selecione
                        </option>

                        <?php foreach ($cardGames as $cardGame): ?>

                            <option
                                value="<?= $cardGame['id'] ?>"
                                <?= $produto['cardgame'] == $cardGame['id'] ? 'selected' : '' ?>
                            >
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
                        name="edicao"
                        id="edicao"
                        required
                    >

                        <option value="">
                            Selecione uma edição
                        </option>

                        <?php foreach ($edicoes as $edicao): ?>

                            <option
                                value="<?= $edicao['id'] ?>"
                                <?= $produto['edicao'] == $edicao['id'] ? 'selected' : '' ?>
                            >
                                <?= htmlspecialchars($edicao['nome']) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <div class="campo">

                    <label for="raridade">
                        Raridade
                    </label>

                    <input
                        type="text"
                        id="raridade"
                        name="raridade"
                        value="<?= htmlspecialchars($produto['raridade'] ?? '') ?>"
                        placeholder="Ex.: Comum, Rara, Mítica..."
                    >

                </div>

            </div>

        </div>


        <!-- IMAGEM -->

        <div class="card-form">

            <div class="card-titulo">
                <h2>Imagem do produto</h2>
                <span>JPG, PNG ou WEBP — máximo 5 MB</span>
            </div>


            <div class="imagem-area">

                <div class="preview-container">

                    <?php if (!empty($produto['imagem'])): ?>

                        <img
                            id="previewImagem"
                            src="imagens/cartas/<?= htmlspecialchars($produto['imagem']) ?>"
                            alt="Imagem do produto"
                        >

                    <?php else: ?>

                        <div
                            id="previewVazio"
                            class="preview-vazio"
                        >
                            <span>📷</span>
                            <p>Nenhuma imagem</p>
                        </div>

                        <img
                            id="previewImagem"
                            src=""
                            alt="Preview da imagem"
                            style="display: none;"
                        >

                    <?php endif; ?>

                </div>


                <div class="upload-area">

                    <label for="imagem" class="upload-label">

                        <span class="upload-icon">
                            📁
                        </span>

                        <strong>
                            Alterar imagem
                        </strong>

                        <small>
                            Clique para selecionar uma nova imagem
                        </small>

                    </label>

                    <input
                        type="file"
                        id="imagem"
                        name="imagem"
                        accept="image/jpeg,image/png,image/webp"
                        class="input-imagem-edicao"
                    >

                    <p id="nomeArquivo" class="nome-arquivo">
                        Nenhum arquivo selecionado
                    </p>

                </div>

            </div>

        </div>


        <!-- AÇÕES -->

        <div class="acoes-form">

            <a
                href="index.php?acao=listar"
                class="botao-cancelar"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="botao-salvar"
            >
                ✓ Salvar alterações
            </button>

        </div>

    </form>

</div>


<script>

const cardGameSelect = document.getElementById('cardgame');
const edicaoSelect = document.getElementById('edicao');

const imagemInput = document.getElementById('imagem');
const previewImagem = document.getElementById('previewImagem');
const previewVazio = document.getElementById('previewVazio');
const nomeArquivo = document.getElementById('nomeArquivo');


/*
|--------------------------------------------------------------------------
| Alteração do Card Game
|--------------------------------------------------------------------------
*/

cardGameSelect.addEventListener('change', async function () {

    const cardGameId = this.value;

    if (!cardGameId) {

        edicaoSelect.disabled = true;

        edicaoSelect.innerHTML = `
            <option value="">
                Selecione primeiro o Card Game
            </option>
        `;

        return;
    }

    edicaoSelect.disabled = true;

    edicaoSelect.innerHTML = `
        <option value="">
            Carregando...
        </option>
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
            <option value="">
                Selecione uma edição
            </option>
        `;

        edicoes.forEach(edicao => {

            const option = document.createElement('option');

            option.value = edicao.id;
            option.textContent = edicao.nome;

            edicaoSelect.appendChild(option);

        });

        if (edicoes.length === 0) {

            edicaoSelect.innerHTML = `
                <option value="">
                    Nenhuma edição encontrada
                </option>
            `;

            edicaoSelect.disabled = true;

            return;
        }

        edicaoSelect.disabled = false;

    } catch (erro) {

        console.error(erro);

        edicaoSelect.innerHTML = `
            <option value="">
                Erro ao carregar edições
            </option>
        `;

        edicaoSelect.disabled = true;
    }

});


/*
|--------------------------------------------------------------------------
| Preview da imagem
|--------------------------------------------------------------------------
*/

imagemInput.addEventListener('change', function () {

    const arquivo = this.files[0];

    if (!arquivo) {

        nomeArquivo.textContent =
            'Nenhum arquivo selecionado';

        return;
    }

    nomeArquivo.textContent = arquivo.name;

    const leitor = new FileReader();

    leitor.onload = function (evento) {

        previewImagem.src = evento.target.result;
        previewImagem.style.display = 'block';

        if (previewVazio) {
            previewVazio.style.display = 'none';
        }

    };

    leitor.readAsDataURL(arquivo);

});

</script>


<?php require __DIR__ . '/../layouts/footer.php'; ?>