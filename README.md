# Projeto Liga

Sistema web para gerenciamento de produtos relacionados a Card Games, desenvolvido em PHP com MySQL, Docker e JavaScript.

O projeto possui autenticação de usuários, cadastro, edição, listagem e exclusão de produtos, além de upload de imagens e carregamento dinâmico de edições de acordo com o Card Game selecionado.

---

## Tecnologias utilizadas

- PHP 8.4
- Apache
- MySQL 8.4
- HTML5
- CSS3
- JavaScript
- PDO
- Docker
- Docker Compose
- Git / GitHub

---

## Funcionalidades

### Autenticação

- Tela de login
- Validação de usuário e senha
- Senhas armazenadas utilizando `password_hash`
- Controle de sessão
- Proteção das páginas através de middleware
- Logout

### Gerenciamento de produtos

- Cadastro de produtos
- Listagem de produtos
- Edição de produtos
- Exclusão de produtos
- Associação com Card Game
- Associação com Edição
- Cadastro de raridade
- Nome original e nome em português

### Imagens

- Upload de imagens dos produtos
- Formatos aceitos:
  - JPG
  - PNG
  - WEBP
- Limite de 5 MB
- Geração de nomes únicos para os arquivos
- Visualização da imagem cadastrada
- Preview da nova imagem durante a edição

### Edições

As edições são carregadas dinamicamente de acordo com o Card Game selecionado.

Por exemplo:

1. O usuário seleciona um Card Game.
2. O sistema consulta as edições relacionadas.
3. O campo de Edição é atualizado automaticamente.
4. Enquanto nenhum Card Game for selecionado, o campo de Edição permanece desabilitado.

---

# Requisitos

Para executar o projeto, é necessário ter instalado:

- Docker
- Docker Compose
- Git

Não é necessário instalar PHP ou MySQL diretamente na máquina, pois ambos são executados através dos containers Docker.

---

# Inicialização do projeto

## 1. Clonar o repositório

```bash
git clone https://github.com/Tteus1010/Projeto-Liga.git

Usuário: admin
Senha: 123456

## 2. Configurar variáveis de ambiente

Copie o arquivo de exemplo e ajuste se necessário:

```bash
cp .env.example .env
```

## 3. Subir os containers

```bash
docker compose up -d --build
```

Esse comando builda a imagem PHP/Apache e sobe os containers da aplicação (porta `8080`) e do MySQL (porta `3307`), em segundo plano.

## 4. Acessar o projeto

http://localhost:8080


## Credenciais de teste (seed)

> Usuário criado automaticamente pelo seed do banco, apenas para ambiente de desenvolvimento.

- Usuário: `admin`
- Senha: `123456`