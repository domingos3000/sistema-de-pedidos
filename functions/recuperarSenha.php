<?php
@session_start();

include_once __DIR__ . './../components/connect.php';

$email = isset($_POST["email"]) ? $_POST["email"] : null;
$codigo_confirmacao = isset($_POST["codigo_confirmacao"]) ? $_POST["codigo_confirmacao"] : null;

if($email == null OR $codigo_confirmacao == null):
    echo "Não podes ter acesso!";
    header("location: ../recuperar_senha.php");
endif;

// Acessando o banco de dados...

$sql = $conn->prepare("SELECT cod_recuperar_senha FROM usuario WHERE email = ? LIMIT 1");
$sql->bindValue(1, $email);

if($sql->execute()):

    $codigoBD = $sql->fetchColumn(); // Pegando somente o valor da primeira coluna

    if($codigo_confirmacao != $codigoBD){
        $_SESSION["mensagens"][] = "Código de confirmação incorreto! Tente novamente.";
        header("location: ./../recuperar_senha.php"); 
        return false;
    }

    $_SESSION['autorizacao'] = ["email" => $email, "status" => true];
    $_SESSION["mensagens"][] = "Crie uma nova senha";
    header("location: ./../introduzir_nova_senha.php");

endif;