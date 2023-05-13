<?php

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

endif;

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar senha</title>
</head>
<body>

    <?php if(isset($_POST['email']) AND pegarNumeroDeRecuperacao($_POST['email'])): ?>

        <?php 




        if(enviarEmailParaUsuario($email_user, $name_user, $cod_user)){
            echo "<p>Código enviado com sucesso no seu email!</p>";
        }

        ?>

        <form action="./functions/recuperarSenha.php" method="POST">
            <div class="input-box">
                <label>Código</label>
                <input type="text" placeholder="Insira o código de confirmação" name="codigo_confirmacao">
                <input type="hidden" value="<?= $_POST['email'] ?>" name="email"/>
            </div>

            <button type="submit">Validar</button>
        </form>

    <?php else: ?>

        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="input-box">
                <label>Email</label>
                <input type="text" placeholder="Insira seu email" name="email">
            </div>

            <button type="submit">Pedir codigo</button>
         </form>
        
    <?php endif; ?>

    
</body>
</html>