<?php

require_once "php/verifica_sessao.php";
require_once 'php/conexao.php';

if (isset($_COOKIE['login'])) {
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <div id="site">
        <header>
            <h1>USUÁRIOS</h1>
            <form class="busca" action="">
                <i><img src="images/lupa.svg"></i>
                <input type="text" id="pesquisa" name="pesquisa" placeholder="Pesquisar...">
            </form>
            <figure></figure>
            <a class="sair" href="php/logout.php">sair</a>
        </header>

        <ul>
            <li class="titulo">
                <div class="texto nome">Nome</div>
                <div class="texto cpf">CPF</div>
                <div class="texto email">E-MAIL</div>
                <div class="texto data">DATA</div>
                <div class="texto status">STATUS</div>
                <div class="editar"></div>
                <div class="deletar"></div>
            </li>
            <div class="resultado">

            </div>
        </ul>
        <div class="pagina" style="user-select: none;">

        </div>
        <?php
            if (mb_strpos($_SESSION['perm'], '2') !== false){?>
                <a href="form.php" style="user-select: none;" class="botao_add">Adicionar novo</a>
            <?php
            } else { ?>
                 <a class="botao_add" style="user-select: none; cursor: no-drop;">Adicionar novo</a>
            <?php
            }
        ?>
    </div>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script>
        console.log($(document));
        $(document).ready(function(){
            $.post("php/lista.php", {}, function(retorna){
                retorna = retorna.split("<hr>");
                $(".resultado").html(retorna[0]);
                $(".pagina").html(retorna[1]);
            });
        })
        function deletarModal($id) {
            if(confirm('Tem certeza que deseja APAGAR este Usuario?')) {
                $.post("php/delete.php", {id: $id}).done(function () {
                    $.post("php/lista.php", {refresh: "sim"}, function(retorna){
                        retorna = retorna.split("<hr>");
                        $(".resultado").html(retorna[0]);
                        $(".pagina").html(retorna[1]);
                    });
                });
            }
        }
        $("body").on('click', '.voltarCrud', function() {
            $.post("php/lista.php", {page: (parseInt($(".VCValue").val()) - 1)}, function(retorna){
                retorna = retorna.split("<hr>");
                $(".resultado").html(retorna[0]);
                $(".pagina").html(retorna[1]);
            });
        })

        $("body").on('click', '.seguinteCrud', function() {
            $.post("php/lista.php", {page: (parseInt($(".VCValue").val()) + 1)}, function(retorna){
                retorna = retorna.split("<hr>");
                $(".resultado").html(retorna[0]);
                $(".pagina").html(retorna[1]);
            });
        })
        $("#pesquisa").on('input', function(){
            var pesquisa = $(this).val();
            console.log(pesquisa);
            var dados = {
                palavra : pesquisa
            }
            $.post("php/pesq.php", dados,function(retorna){
                retorna = retorna.split("<hr>");
                $(".resultado").html(retorna[0]);
                $(".pagina").html(retorna[1]);
            });
        });
    </script>
</body>

</html>
