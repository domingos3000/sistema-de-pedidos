<?php

include __DIR__ . './../components/connect.php';

@session_start();

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = $_POST['pass'];
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_motoboy = $conn->prepare("SELECT * FROM `motoboy` WHERE email = ? AND senha = ? LIMIT 1");
   $select_motoboy->execute([$email, $pass]);
   
   if($select_motoboy->rowCount() > 0){
      $fetch_motoboy_id = $select_motoboy->fetch(PDO::FETCH_ASSOC);
      $_SESSION['motoboy_id'] = $fetch_motoboy_id['id'];

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
      <p>predefinido nome de usuario = <span>admin</span> & senha = <span>111</span></p>

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
      <p>predefinido nome de usuario = <span>motoboy001@gmail.com</span> & senha = <span>123</span></p>
      
      <input type="text" name="email" maxlength="20" required placeholder="Insira o nome de usuario" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="Insira a senha" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Iniciar a sessão" name="submit" class="btn">
   </form>

</section>

<!-- seção do formulário de login do administrador termina -->











</body>
</html>