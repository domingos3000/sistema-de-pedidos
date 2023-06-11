<?php

@session_start();
include_once __DIR__ . './../vendor/autoload.php';

use App\Motoboy\Motoboy;

if(isset($_SESSION['motoboy_id'])) header("location: painel.php");

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = $_POST['pass'];
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   
   if(Motoboy::login($email, $pass)){
      header("location: painel.php");
   }else{
      header("location: {$_SERVER['PHP_SELF']}");
   }
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

   <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
      <h3>Iniciar sessão</h3>
      
      <input type="text" name="email" maxlength="20" required placeholder="Insira o nome de usuario" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="Insira a senha" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Iniciar a sessão" name="submit" class="btn">
      
      <p><a href="criar-conta.php">Criar uma nova conta</a></p>
   </form>

</section>

<!-- seção do formulário de login do administrador termina -->

</body>
</html>