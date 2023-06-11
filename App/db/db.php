<?php

function db(){
    $db_name = 'mysql:host=localhost;dbname=pedidos-online';
    $user_name = 'root';
    $user_password = '';

    return new \PDO($db_name, $user_name, $user_password);

}

