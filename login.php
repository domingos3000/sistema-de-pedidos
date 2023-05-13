<?php

include __DIR__ . './components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `usuario` WHERE email = ? AND senha = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['id'];
      header('location:home.php');
   }else{
      $message[] = 'O nome de usuario ou senha está incorrecta!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

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
      <h3>Iniciar sessão</h3>
      <input type="email" name="email" required placeholder="insira o seu email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="insira sua senha" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="inciar a sessão" name="submit" class="btn">
      <p>Não tem nenhuma conta ainda? <a href="registro.php">registrar agora</a> | <a href="recuperar_senha.php" target="_blank">Recuperar minha senha</a></p>
   </form>

</section>











<?php include 'components/footer.php'; ?>






<!-- link de arquivo js personalizado -->
<script src="js/script.js"></script>

</body>
</html>