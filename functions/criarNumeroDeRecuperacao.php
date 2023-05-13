<?php

include_once __DIR__ . './../components/connect.php';

/**
 * Summary of gerarNumeros
 * @return int
 */
function gerarNumeros(){
    return rand(111111, 999999);
}

/**
 * Summary of pegarNumeroRecuperacao
 * @return (string | bool)
 */

function pegarNumeroDeRecuperacao($email){
    
    global $conn;

    $sql = $conn->prepare("SELECT cod_recuperar_senha FROM usuario WHERE email = ? LIMIT 1");
    $sql->execute([$email]);

    if($sql->rowCount() > 0){
        return $sql->fetchColumn();
    }

    return false;
}