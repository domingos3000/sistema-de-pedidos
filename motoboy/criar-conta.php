<?php

@session_start();
include_once __DIR__ . './../vendor/autoload.php';

use App\Motoboy\Motoboy;


if(isset($_POST['submit'])){

   $nome = $_POST['nome'];
   $nome = filter_var($nome, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = $_POST['pass'];
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   new Motoboy($nome, $email, $pass);
   
   Motoboy::register();
   header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Iniciar sessão</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- link de arquivo css personalizado -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<!-- seção do formulário de login do administrador começa -->

<section class="form-container">

   <?php include_once __DIR__ . './../components/html_mensagens_flash.php'; ?>

   <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
      <h3>Criar Conta</h3>
      <!-- <p>predefinido nome de usuario = <span>motoboy001@gmail.com</span> & senha = <span>123</span></p> -->
      
      <input type="text" name="nome" required placeholder="Insira o nome completo" class="box">
      <input type="text" name="email"  required placeholder="Insira o seu email" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="Insira a senha" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Criar" name="submit" class="btn">
      <p><a href="index.php">Iniciar sessão</a></p>

   </form>

</section>

<!-- seção do formulário de login do administrador termina -->

</body>
</html>