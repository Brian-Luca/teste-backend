<?php

require_once "php/verifica_sessao.php";
require_once 'php/conexao.php';

if (isset($_COOKIE['login'])) {
    header('Location: login.php');
}

if (mb_strpos($_SESSION['perm'], '2') === false){
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/form.css">
</head>

<body>
    <div id="site">
        <header>
            <a class="voltar" href="index.php"><img src="images/voltar.svg"></a>
            <h1 class="total">Salvar novo usuário</h1>
            <figure></figure>
            <a class="sair" href="login.php">sair</a>
        </header>
        <form action="php/cadastrar.php" method="POST" class="cadastro">
            <div class="input">
                <label for="input_nome">Nome:</label>
                <input type="text" id="input_nome" name="nome" placeholder="Digite um nome" required>
            </div>
            <div class="input">
                <label for="input_cpf">CPF:</label>
                <input type="text" id="input_cpf" name="cpf" placeholder="Digite um CPF" required
                pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" title="Digite um CPF no formato: xxx.xxx.xxx-xx" oninput="addChar(this)"
                maxlength="14" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
            </div>
            <div class="input">
                <label for="input_email">E-mail:</label>
                <input type="email" id="input_email" name="email" placeholder="Digite um e-mail" required>
            </div>
            <div class="input">
                <label for="input_senha">Senha:</label>
                <input type="password" id="input_senha" name="senha" placeholder="Digite uma senha" required>
            </div>

            <div class="select">
                <label for="input_status">Status</label>
                <select name="status" id="input_status" required>
                    <option value="">Escolha uma opção</option>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                </select>
                <div class="seta"><img src="images/seta.svg" alt=""></div>
            </div>

            <h2>Permissão</h2>
            <div class="permissao" style="user-select: none;">
                <div class="checkbox" style="pointer-events: none; opacity: 0.5;">
                    <input type="checkbox" id="input_permissao_login" name="permissao[]" checked value="login">
                    <div class="check"><img src="images/check.svg"></div>
                    <label for="input_permissao_login">Login</label>
                </div>
                <div class="checkbox">
                    <input type="checkbox" id="input_permissao_usuario_add" name="permissao[]" value="usuario_add">
                    <div class="check"><img src="images/check.svg"></div>
                    <label for="input_permissao_usuario_add">Add usuário</label>
                </div>
                <div class="checkbox">
                    <input type="checkbox" id="input_permissao_usuario_editar" name="permissao[]" value="usuario_editar">
                    <div class="check"><img src="images/check.svg"></div>
                    <label for="input_permissao_usuario_editar">Editar usuário</label>
                </div>
                <div class="checkbox">
                    <input type="checkbox" id="input_permissao_usuario_deletar" name="permissao[]" value="usuario_deletar">
                    <div class="check"><img src="images/check.svg"></div>
                    <label for="input_permissao_usuario_deletar">Deletar usuário</label>
                </div>
            </div>

            <button>SALVAR</button>
        </form>
    </div>
    <script src="js/cpf.js"></script>
</body>

</html>
