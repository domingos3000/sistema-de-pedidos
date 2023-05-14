<?php

include __DIR__ . './connect.php';

@session_start();
session_unset();
session_destroy();

session_start();
$_SESSION["mensagens"][] = "Você deslogou. Volte sempre!";
header('location:../home.php');

?>