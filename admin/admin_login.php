<?php

include __DIR__ . './../components/connect.php';

session_start();

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE nome = ? AND senha = ?");
   $select_admin->execute([$name, $pass]);
   
   if($select_admin->rowCount() > 0){
      $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
      $_SESSION['admin_id'] = $fetch_admin_id['id'];
      header('location:painel.php');
   }else{
      $message[] = 'O nome de usuario ou a senha deve estar incorreta!';
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

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<!-- seção do formulário de login do administrador começa -->

<section class="form-container">

   <form action="" method="POST">
      <h3>Iniciar sessão</h3>
      <p>predefinido nome de usuario = <span>admin</span> & senha = <span>111</span></p>
      <input type="text" name="name" maxlength="20" required placeholder="Insira o nome de usuario" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="Insira a senha" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Iniciar a sessão" name="submit" class="btn">
   </form>

</section>

<!-- seção do formulário de login do administrador termina -->











</body>
</html>