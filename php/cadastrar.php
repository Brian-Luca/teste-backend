<?php
session_start();

require_once 'conexao.php';
require_once 'uuid.php';

$conexao = Conexao::getInstance();

date_default_timezone_set('America/Sao_Paulo');

$nome = (isset($_POST['nome']) && !empty($_POST['nome'])) ? strtolower($_POST["nome"]) : '';

$cpf = (isset($_POST['cpf']) && !empty($_POST['cpf'])) ? $_POST["cpf"] : '';

$uuid = uuid(sha1($cpf), $nome);

$email = (isset($_POST['email']) && !empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) ? strtolower(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)) : '';

$senha = (isset($_POST['senha']) && !empty($_POST['senha'])) ? $_POST['senha'] : '';
$hash = password_hash($senha, PASSWORD_DEFAULT);

$status = (isset($_POST['status']) && !empty($_POST['status'])) ? $_POST['status'] : '';

$perms = (isset($_POST['permissao']) && !empty($_POST['permissao'])) ? $_POST['permissao'] : '';
$permissao = '1-';
foreach ($perms as $perm) {
    switch ($perm) {
        case 'usuario_add':
            $permissao .= '2-';
            break;
        case 'usuario_editar':
            $permissao .= '3-';
            break;
        case 'usuario_deletar':
            $permissao .= '4-';
            break;
    }
}

if (isset($uuid) && isset($nome) && isset($cpf) && isset($email) && isset($hash) && isset($permissao) && isset($status))
{
    $stmt = $conexao->prepare('INSERT INTO usuario (`uuid`, `nome`, `cpf`, `email`, `senha`, `permissao`, `data_criacao`, `data_atualizacao`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bindValue(1, $uuid);
    $stmt->bindValue(2, $nome);
    $stmt->bindValue(3, $cpf);
    $stmt->bindValue(4, $email);
    $stmt->bindValue(5, $hash);
    $stmt->bindValue(6, $permissao);
    $stmt->bindValue(7, date("Y-m-d H:i:s"));
    $stmt->bindValue(8, date("Y-m-d H:i:s"));
    $stmt->bindValue(9, $status);
    $stmt->execute();
    header('Location: ../index.php');
}
?>