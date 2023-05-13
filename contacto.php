<?php

include __DIR__ . './components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `mensagem` WHERE nome = ? AND email = ? AND contacto = ? AND mensagem = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'mensagem já enviada!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `mensagem`(user_id, nome, email, contacto, mensagem) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'mensagem enviada com sucesso!';

   }

}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contacto</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- link de arquivo css personalizado -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- seção de cabeçalho começa -->
<?php include 'components/usuario_cabeçalho.php'; ?>
<!-- seção de cabeçalho termina -->

<div class="heading">
   <h3>contacta-nos</h3>
   <p><a href="home.php">Página inicial</a> <span> / contacto</span></p>
</div>

<!-- seção de contacto começa -->

<section class="contact">

   <div class="row">

      <div class="image">
         <img src="images/contact-img.svg" alt="">
      </div>

      <form action="" method="post">
         <h3>Escreva-nos!</h3>
         <input type="text" name="name" maxlength="50" class="box" placeholder="Insira o seu nome" required>
         <input type="number" name="number" min="0" max="9999999999" class="box" placeholder="Insira o seu número" required maxlength="10">
         <input type="email" name="email" maxlength="50" class="box" placeholder="Insira o seu email" required>
         <textarea name="msg" class="box" required placeholder="Insira a sua mensagem" maxlength="500" cols="30" rows="10"></textarea>
         <input type="submit" value="enviar a mensagem" name="send" class="btn">
      </form>

   </div>

</section>

<!-- seção de contato termina -->










<!-- seção de rodapé começa -->
<?php include 'components/footer.php'; ?>
<!-- seção de rodapé termina -->








<!-- link de arquivo js personalizado -->
<script src="js/script.js"></script>

</body>
</html>