<?php
session_start();

require_once 'conexao.php';

setcookie("login", 1);

$conexao = Conexao::getInstance();

$login = (isset($_POST['login']) && !empty($_POST['login'])) ? $_POST["login"] : '';
$senha = (isset($_POST['senha']) && !empty($_POST['senha'])) ? $_POST['senha'] : '';

$stmt = $conexao->prepare('SELECT * FROM usuario WHERE cpf = ? LIMIT 1');
$stmt->bindValue(1, $login);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (empty($usuario)) {
    $aviso = array('codigo' => '0', 'mensagem' => 'Informações incorretas!');
    echo json_encode($aviso);
    exit();
}

if($usuario['status'] == 0){
    $aviso = array('codigo' => '0', 'mensagem' => 'Conta inativa!');
    echo json_encode($aviso);
    exit();
}

if (!empty($usuario) && password_verify($senha, $usuario['senha']) && $usuario['status']) :
    $_SESSION['id'] = $usuario['id'];
    $_SESSION['nome'] = $usuario['nome'];
    $_SESSION['perm'] = $usuario['permissao'];
    $_SESSION['logado'] = 'SIM';
else :
    $_SESSION['logado'] = 'NAO';
    $aviso = array('codigo' => '0', 'mensagem' => 'Informações incorretas!');
    echo json_encode($aviso);
    exit();
endif;


if ($_SESSION['logado'] == 'SIM' && $usuario['status']) :
    $aviso = array('codigo' => 1, 'mensagem' => 'Logado com sucesso!');
    echo json_encode($aviso);
    exit();
else :
    $aviso = array('codigo' => '0', 'mensagem' => 'Usuário não autorizado!');
    echo json_encode($aviso);
    exit();
endif;