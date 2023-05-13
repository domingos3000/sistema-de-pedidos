<?php

include __DIR__ . './components/connect.php';
include_once __DIR__ . './functions/criarNumeroDeRecuperacao.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `usuario` WHERE email = ? OR contacto = ?");
   $select_user->execute([$email, $number]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $message[] = 'email ou o contacto já existe!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirmar senha não correspondida!';
      }else{

         $numRecuperacao = gerarNumeros();

         $insert_user = $conn->prepare("INSERT INTO `usuario`(nome, email, contacto, senha, cod_recuperar_senha) VALUES(?,?,?,?,?)");
         $insert_user->execute([$name, $email, $number, $cpass, $numRecuperacao]);
         $select_user = $conn->prepare("SELECT * FROM `usuario` WHERE email = ? AND senha = ?");
         $select_user->execute([$email, $pass]);
         $row = $select_user->fetch(PDO::FETCH_ASSOC);
         if($select_user->rowCount() > 0){
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');
         }
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>registrar</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- link de arquivo css personalizado -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- seção de cabeçalho começa -->
<?php include 'components/usuario_cabeçalho.php'; ?>
<!-- seção de cabeçalho termina -->

<section class="form-container">

   <form action="" method="post">
      <h3>registrar agora</h3>
      <input type="text" name="name" required placeholder="insira o nome" class="box" maxlength="50">
      <input type="email" name="email" required placeholder="insira o email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="number" name="number" required placeholder="insira o número" class="box" min="0" max="9999999999" maxlength="10">
      <input type="password" name="pass" required placeholder="insira a senha" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="confirma a senha" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="registrar agora" name="submit" class="btn">
      <p>Já tem uma conta? <a href="login.php">Iniciar a sessão</a></p>
   </form>

</section>











<?php include 'components/footer.php'; ?>







<!-- link de arquivo js personalizado -->
<script src="js/script.js"></script>

</body>
</html>