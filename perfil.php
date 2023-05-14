<?php

include __DIR__ . './components/connect.php';

@session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>perfil</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- link de arquivo css personalizado -->
   <link rel="stylesheet" href="./css/animate.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- seção de cabeçalho começa -->
<?php include 'components/usuario_cabeçalho.php'; ?>
<!-- seção de cabeçalho termina -->

<section class="user-details">

   <div class="user">
      <?php
         
      ?>
      <img src="images/user-icon.png" alt="">
      <p><i class="fas fa-user"></i><span><span><?= $fetch_profile['nome']; ?></span></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['contacto']; ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email']; ?></span></p>
      <a href="editar_perfil.php" class="btn">editar informações</a>
      <p class="address"><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['endereço'] == ''){echo 'por favor insira o seu endereço';}else{echo $fetch_profile['endereço'];} ?></span></p>
      <a href="editar_endereço.php" class="btn">editar endereço</a>
   </div>

</section>










<?php include 'components/footer.php'; ?>







<!-- link de arquivo js personalizado -->
<script src="js/script.js"></script>

</body>
</html>