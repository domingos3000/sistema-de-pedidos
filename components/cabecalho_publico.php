<?php
@session_start();

include __DIR__ . './connect.php';
include __DIR__ . './../functions/mensagens_flash.php';


if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include __DIR__ . './add_carrinho.php';

?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>
        <?= isset($tituloDaPagina) 
            ? $tituloDaPagina
            : "Sistema de pedidos";
        ?> 
    </title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- link de arquivo css personalizado -->
   <link rel="stylesheet" href="./css/animate.min.css">
   <link rel="stylesheet" href="./css/style.css">

</head>
<body>

<header class="header">

   <section class="flex">

      <a href="home.php" class="logo">Gerenciador de pedidos</a>

      <nav class="navbar">
         <a href="home.php">Página inicial</a>
         <a href="sobre.php">Sobre</a>
         <a href="menu.php">Menu</a>
         <a href="pedidos.php">Pedidos</a>
         <a href="contacto.php">Contacto</a>
      </nav>

      <div class="icons">
         <?php
         $count_cart_items = $conn->prepare("SELECT * FROM `compras` WHERE user_id = ?");
         $count_cart_items->execute([$user_id]);
         $total_cart_items = $count_cart_items->rowCount();
         ?>
         <a href="busca.php"><i class="fas fa-search"></i></a>
         <a href="carrinho.php"><i class="fas fa-shopping-cart"></i><span>(
               <?= $total_cart_items; ?>)
            </span></a>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <div class="profile">
         <?php
         $select_profile = $conn->prepare("SELECT * FROM `usuario` WHERE id = ?");
         $select_profile->execute([$user_id]);
         if ($select_profile->rowCount() > 0) {
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <p class="name">
               <?= $fetch_profile['nome']; ?>
            </p>
            <div class="flex">
               <a href="perfil.php" class="btn">Perfil</a>
               <a href="components/user_logout.php" onclick="return confirm('Terminar a sessão?');"
                  class="delete-btn">Terminar</a>
            </div>
            <p class="account">
               <a href="login.php">Iniciar sessão</a> ou
               <a href="registro.php">registrar</a>
            </p>
            <?php
         } else {
            ?>
            <p class="name">Por favor inicie sessão primeiro!</p>
            <a href="login.php" class="btn">iniciar sessão</a>
            <?php
         }
         ?>
      </div>

   </section>

</header>

<?php include_once __DIR__ . './html_mensagens_flash.php'; ?>