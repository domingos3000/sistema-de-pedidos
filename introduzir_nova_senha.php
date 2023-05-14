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
    <title>Recuperar senha</title>
</head>
<body>

        <form action="./functions/alterarSenha.php" method="POST">
            <div class="input-box">
                <label>Nova senha</label>
                <input type="text" placeholder="Introduza uma nova senha" name="nova_senha">
            </div>

            <button type="submit">Alterar senha</button>
        </form>
    
</body>
</html>