<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Projeto Liga - Login</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            font-family: Arial, sans-serif;
            background: #f2f2f2;
        }

        .login-container {
            width: 380px;
            padding: 35px;

            background: white;

            border-radius: 10px;

            box-shadow:
                0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .login-container h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .campo {
            margin-bottom: 20px;
        }

        .campo label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        .campo input {
            width: 100%;
            padding: 12px;

            border: 1px solid #ccc;
            border-radius: 6px;

            font-size: 15px;
        }

        .botao {
            width: 100%;
            padding: 12px;

            border: none;
            border-radius: 6px;

            background: #222;
            color: white;

            font-size: 16px;
            cursor: pointer;
        }

        .botao:hover {
            opacity: 0.9;
        }

        .erro {
            padding: 10px;
            margin-bottom: 20px;

            background: #ffe5e5;
            color: #b00000;

            border-radius: 5px;

            text-align: center;
        }

    </style>
</head>

<body>

<div class="login-container">

    <h1>Projeto Liga</h1>

    <?php if (!empty($erro)): ?>

        <div class="erro">
            <?= htmlspecialchars($erro) ?>
        </div>

    <?php endif; ?>

    <form action="index.php?acao=login" method="POST">

        <div class="campo">

            <label for="usuario">
                Usuário
            </label>

            <input
                type="text"
                id="usuario"
                name="usuario"
                required
                autocomplete="username"
            >

        </div>

        <div class="campo">

            <label for="senha">
                Senha
            </label>

            <input
                type="password"
                id="senha"
                name="senha"
                required
                autocomplete="current-password"
            >

        </div>

        <button
            type="submit"
            class="botao"
        >
            Entrar
        </button>

    </form>

</div>

</body>

</html>