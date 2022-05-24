<?php

session_start();

require_once 'conexao.php';
$conexao = Conexao::getInstance();

$_SESSION['page'] = isset($_POST['page']) && is_numeric($_POST['page']) ? (int)$_POST['page'] : 1;

$_SESSION['records_per_page'] = 6;

$palavra = filter_input(INPUT_POST, 'palavra', FILTER_UNSAFE_RAW);
$palavra = preg_replace('/(?<!^)\'(?!$)/', '', $palavra);

$stmt = $conexao->prepare("SELECT * FROM usuario WHERE nome LIKE '%{$palavra}%' ORDER BY nome LIMIT :current_page, :record_per_page");
$stmt->bindValue(':current_page', ($_SESSION['page'] - 1) * $_SESSION['records_per_page'], PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $_SESSION['records_per_page'], PDO::PARAM_INT);
$stmt->execute();

$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

$_SESSION['num_usuarios'] = $conexao->query("SELECT COUNT(*) FROM usuario WHERE nome LIKE '%{$palavra}%'")->fetchColumn();

if(!empty($usuarios)){
    foreach ($usuarios as $usuario) : ?>
        <li class="dado">
            <div class="texto nome"><?=mb_convert_case($usuario['nome'], MB_CASE_TITLE, 'UTF-8')?></div>
            <div class="texto cpf"><?= $usuario['cpf'] ?></div>
            <div class="texto email"><?=ucfirst($usuario['email'])?></div>
            <div class="texto data"><?= $usuario['data_atualizacao'] ?></div>
            <div class="texto status"><?= $usuario['status'] ? 'Ativo' : 'Inativo' ?></div>
            <?php
                if (mb_strpos($_SESSION['perm'], '3') !== false){?>
                <div class="editar" style="user-select: none;"><a href="edit.php?id=<?=$usuario['id']?>"><img src="images/editar.svg"></a></div>
                <?php
                } else { ?>
                    <div class="editar" style="user-select: none; cursor: no-drop;"><img src="images/editar.svg"></div>
                <?php
                }
            ?>
            <?php
                if (mb_strpos($_SESSION['perm'], '4') !== false){?>
                <div class="deletar" style="user-select: none; cursor: pointer" onclick="deletarModal('<?= $usuario['id'] ?>')"><img src="images/deletar.svg"></div>
                <?php
                } else { ?>
                    <div class="deletar" style="user-select: none; cursor: no-drop;"><img src="images/deletar.svg"></div>
                <?php
                }
            ?>
    
        </li>
    <?php endforeach;
    if (isset($_SESSION['page'])) { ?>
    <hr>
    <input type="hidden" class="VCValue" value="<?= $_SESSION['page'] ?>">
    <p class="resultado"><?= $_SESSION['num_usuarios'] ?> resultados</p>
    <?php if ($_SESSION['page'] > 1) : ?>
        <a style="cursor: pointer;" class="voltarCrud">Anterior</a>
    <?php endif; ?>
    <?php if ($_SESSION['page'] * $_SESSION['records_per_page'] < $_SESSION['num_usuarios']) : ?>
        <a style="cursor: pointer;" class="seguinteCrud">Próxima</a>
    <?php endif; ?>
    <?php }
} else {
	echo 
    "<li class='dado'>". 
    "<div class='texto nome'>Nenhum usuário encontrado...</div>".
    "</li class='dado'>";
    if (isset($_SESSION['page'])) { ?>
        <hr>
        <input type="hidden" class="VCValue" value="<?= $_SESSION['page'] ?>">
        <p class="resultado"><?= $_SESSION['num_usuarios'] ?> resultados</p>
        <?php if ($_SESSION['page'] > 1) : ?>
            <a style="cursor: pointer;" class="voltarCrud">Anterior</a>
        <?php endif; ?>
        <?php if ($_SESSION['page'] * $_SESSION['records_per_page'] < $_SESSION['num_usuarios']) : ?>
            <a style="cursor: pointer;" class="seguinteCrud">Próxima</a>
        <?php endif; ?>
    <?php }
} 