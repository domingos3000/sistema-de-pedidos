<?php

include __DIR__ . './../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE nome = ?");
   $select_admin->execute([$name]);
   
   if($select_admin->rowCount() > 0){
      $message[] = 'Já existe um usuario com o mesmo nome!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm passowrd not matched!';
      }else{
         $insert_admin = $conn->prepare("INSERT INTO `admin`(nome, senha) VALUES(?,?)");
         $insert_admin->execute([$name, $cpass]);
         $message[] = 'novo administrador adicionado!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>registrar</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Link de arquivo CSS personalizado  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_cabeçalho.php' ?>

<!-- Iniciar seção Registrar administrador  -->

<section class="form-container">

   <form action="" method="POST">
      <h3>novo registro</h3>
      <input type="text" name="name" maxlength="20" required placeholder="Insira o seu nome" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="Insira a sua senha" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" maxlength="20" required placeholder="Confirma a sua senha" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="registrar agora" name="submit" class="btn">
   </form>

</section>

<!-- A seção register admin termina -->
















<!-- Link do arquivo JS personalizado -->
<script src="../js/admin_script.js"></script>

</body>
</html>