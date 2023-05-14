<?php
@session_start();

if((!isset($_SESSION['autorizacao']) AND $_SESSION['autorizacao'] != true) OR $_SESSION['autorizacao'] != true):
    header('location: recuperar_senha.php');
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

        <section class="form-container">

            <form action="./functions/alterarSenha.php" method="POST">
                <h3>Nova senha</h3>
                <input type="text" name="nova_senha" required placeholder="Crie uma nova senha" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                <input type="submit" value="Alterar" name="submit" class="btn">
            </form>

        </section>
    
</body>
</html>