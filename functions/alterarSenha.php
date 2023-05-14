<?php
@session_start();

include_once __DIR__ . './../components/connect.php';
include_once __DIR__ . "./criarNumeroDeRecuperacao.php";

$email = $_SESSION['autorizacao']["email"];
$nova_senha = $_POST["nova_senha"];


$sql = $conn->prepare("SELECT id, email FROM usuario WHERE email = ? LIMIT 1");
$sql->execute([$email]);

if($sql->rowCount() > 0):

    $id_user = $sql->fetchColumn();
    $senha_criptografada = sha1($nova_senha);
    $gerar_novo_codigo = gerarNumeros();

    $sql = $conn->prepare("UPDATE usuario SET senha = ?, cod_recuperar_senha = ? WHERE id = ? AND email = ? LIMIT 1");
    $sql->execute([$senha_criptografada, $gerar_novo_codigo, $id_user, $email]);
    
    if($sql->rowCount() > 0){

        unset($_SESSION['autorizacao']);
        
        $_SESSION["mensagens"][] = "Senha alterada com sucesso!";

        $stmt = $conn->prepare("UPDATE usuario SET acesso = ? WHERE id = ?");
        $stmt->execute([3, $id_user]);

        header("location: ./../login.php");
        return;
    }

    unset($_SESSION['autorizacao']);
    $_SESSION["mensagens"][] = "Falha no sistema! Tente mais tarde.";
    header("location: ./../");

else:
    unset($_SESSION['autorizacao']);
    $_SESSION["mensagens"][] = "Usuário não existe!";
    header("location: ./../");
endif;