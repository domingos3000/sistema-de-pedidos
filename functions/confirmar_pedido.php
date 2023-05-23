<?php

include_once __DIR__ . './../components/connect.php';

$id_pedido = isset($_GET['id_pedido']) ? $_GET['id_pedido'] : null;

if(!$id_pedido): 
    header('location: ../pedidos.php'); 
    return false; 
endif;

$procurar_pedido = $conn->prepare("SELECT * FROM pedidos WHERE id = ?");
$procurar_pedido->bindValue(1, $id_pedido);
$procurar_pedido->execute();


if ($procurar_pedido->rowCount() > 0):
    
    $dados = $procurar_pedido->fetch(PDO::FETCH_ASSOC);

    if ($dados['confirmacao_cliente'] == 'false') {

        $sql_cancelar = $conn->prepare("UPDATE pedidos SET confirmacao_cliente = 'true' WHERE id = ?");
        $sql_cancelar->bindValue(1, $id_pedido);
        $sql_cancelar->execute();
        header('location: ../pedidos.php');
    }

else
    echo "Erro na consulta";
endif;