<?php
@session_start();
@include_once __DIR__ . './../components/connect.php';

$id_pedido = $_GET['id_pedido'];

$procurar_pedido = $conn->prepare("SELECT * FROM pedidos WHERE id = ?");
$procurar_pedido->bindValue(1, $id_pedido);
$procurar_pedido->execute();


if ($procurar_pedido->rowCount() > 0) {
    
    $dados = $procurar_pedido->fetch(PDO::FETCH_ASSOC);

    if ($dados['estado_pagamento'] == '1') {

        $sql_cancelar = $conn->prepare("UPDATE pedidos SET estado_pagamento = '0' WHERE id = ?");
        $sql_cancelar->bindValue(1, $id_pedido);
        $sql_cancelar->execute();
        $_SESSION["mensagens"][] = 'Pedido cancelado com sucesso!';
        header('location: ../pedidos.php');
    }

} else {
    $_SESSION["mensagens"][] = 'Erro interno! Iremos resolve-lo o mais breve possível.';
    header('location: ../pedidos.php');
}