<?php
session_start();

require_once 'conexao.php';
require_once 'uuid.php';

if(isset($_GET['id'])){

    $conexao = Conexao::getInstance();

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $stmt = $conexao->prepare('SELECT * FROM usuario WHERE id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    date_default_timezone_set('America/Sao_Paulo');

    $nome = (isset($_POST['nome']) && !empty($_POST['nome'])) ? strtolower($_POST["nome"]) : $usuario['nome'];

    $cpf = (isset($_POST['cpf']) && !empty($_POST['cpf'])) ? $_POST["cpf"] : $usuario['cpf'];

    $uuid = uuid(sha1($cpf), $nome);

    $email = (isset($_POST['email']) && !empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) ? strtolower(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)) : $usuario['email'];

    $hash = (isset($_POST['senha']) && !empty($_POST['senha'])) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : $usuario['senha'];

    $status = (isset($_POST['status']) && !empty($_POST['status'])) ? $_POST['status'] : $usuario['status'];

    $perms = (isset($_POST['permissao']) && !empty($_POST['permissao'])) ? $_POST['permissao'] : $usuario['permissao'];
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
        $stmt = $conexao->prepare('UPDATE IGNORE `usuario` SET `uuid` = ?, `nome` = ?, `cpf` = ?, `email` = ?, `senha` = ?, `permissao` = ?, `data_atualizacao` = ?, `status` = ?');
        $stmt->bindValue(1, $uuid);
        $stmt->bindValue(2, $nome);
        $stmt->bindValue(3, $cpf);
        $stmt->bindValue(4, $email);
        $stmt->bindValue(5, $hash);
        $stmt->bindValue(6, $permissao);
        $stmt->bindValue(7, date("Y-m-d H:i:s"));
        $stmt->bindValue(8, $status);
        $stmt->execute();
        header('Location: ../index.php');
    }
}
?>