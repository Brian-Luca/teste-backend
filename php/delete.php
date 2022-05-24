<?php

require_once 'conexao.php';
$conexao = Conexao::getInstance();

$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$sql = 'DELETE FROM `usuario` WHERE `usuario`.`id` = ?';
$stmt = $conexao->prepare($sql);
$stmt->bindValue(1, $id);
$stmt->execute();