<?php
@session_start();

include __DIR__ . './functions/criarNumeroDeRecuperacao.php';
include __DIR__ . './functions/email/enviarCodigoRecuperacaoSenha.php';

$email_user = isset($_POST['email']) ? $_POST['email'] : "";

if(isset($_POST['email'])):
    
    $sql_search = $conn->prepare("SELECT nome, cod_recuperar_senha FROM usuario WHERE email = ?");
    $sql_search->execute([$email_user]);

    if($sql_search->rowCount() > 0):
        
        $dados =  $sql_search->fetchAll(PDO::FETCH_ASSOC)[0]; 
        $name_user = $dados["nome"];
        $cod_user =  $dados["cod_recuperar_senha"];

    endif;

    if(enviarEmailParaUsuario($email_user, $name_user, $cod_user)){

        $_SESSION["mensagens"][] = "Código enviado via email! Insira-o no campo abaixo";

    } else {

        $_SESSION["mensagens"][] = "Ocorreu um erro ao enviar o código! Certifique-se de que estejas conectado a internet. Ou tente mais tarde.";
    }

endif;

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="./css/style.css">
    <title>Recuperar senha</title>
</head>
<body>

    <?php include_once __DIR__ . './components/html_mensagens_flash.php'; ?>

    <?php if(isset($_POST['email']) AND pegarNumeroDeRecuperacao($_POST['email'])): ?>

        <section class="form-container">

            <form action="./functions/recuperarSenha.php" method="POST">
                <h3>Código enviado via email</h3>
                <input type="text" name="codigo_confirmacao" required placeholder="Código" class="box" maxlength="8" oninput="this.value = this.value.replace(/\s/g, '')">
                <input type="hidden" value="<?= $_POST['email'] ?>" name="email"/>
                <input type="submit" value="Validar" name="submit" class="btn">
            </form>

        </section>

    <?php else: ?>
         
        <section class="form-container">

            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <h3>Esqueci minha senha</h3>
                <input type="email" name="email" required placeholder="Informe seu email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                <input type="submit" value="Pedir código" name="submit" class="btn">
            </form>

        </section>
        
    <?php endif; ?>

    
</body>
</html>