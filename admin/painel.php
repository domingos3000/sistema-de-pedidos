<?php

include __DIR__ . './../components/connect.php';

@session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Painel administrativo</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Link de arquivo CSS personalizado  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_cabeçalho.php' ?>

<!-- A seção Painel de administração é iniciada  -->

<section class="dashboard">

   <h1 class="heading">Painel administrativo</h1>

   <div class="box-container">

   <div class="box">
      <h3>Bem-vindo/a!</h3>
      <p><?= $fetch_profile['nome']; ?></p>
      <a href="editar_perfil.php" class="btn">Editar senha</a>
   </div>

   <div class="box">
      <?php
         $total_pendings = 0;
         $select_pendings = $conn->prepare("SELECT * FROM `pedidos` WHERE estado_pagamento = ?");
         $select_pendings->execute(['pendente']);
         while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
            $total_pendings += $fetch_pendings['total_preço'];
         }
      ?>
      <h3><span>Kz</span><?= $total_pendings; ?><span></span></h3>
      <p>total pendentes</p>
      <a href="ordem_pedido.php" class="btn">Ver pedidos</a>
   </div>

   <div class="box">
      <?php
         $total_completes = 0;
         $select_completes = $conn->prepare("SELECT * FROM `pedidos` WHERE estado_pagamento = ?");
         $select_completes->execute(['completado']);
         while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
            $total_completes += $fetch_completes['total_preço'];
         }
      ?>
      <h3><span>Kz</span><?= $total_completes; ?><span></span></h3>
      <p>total completados</p>
      <a href="ordem_pedido.php" class="btn">Ver pedidos</a>
   </div>

   <div class="box">
      <?php
         $select_orders = $conn->prepare("SELECT * FROM `pedidos`");
         $select_orders->execute();
         $numbers_of_orders = $select_orders->rowCount();
      ?>
      <h3><?= $numbers_of_orders; ?></h3>
      <p>total de pedidos</p>
      <a href="ordem_pedido.php" class="btn">Ver pedidos</a>
   </div>

   <div class="box">
      <?php
         $select_products = $conn->prepare("SELECT * FROM `produtos`");
         $select_products->execute();
         $numbers_of_products = $select_products->rowCount();
      ?>
      <h3><?= $numbers_of_products; ?></h3>
      <p>produtos adicionados</p>
      <a href="produtos.php" class="btn">Ver produtos</a>
   </div>

   <div class="box">
      <?php
         $select_users = $conn->prepare("SELECT * FROM `usuario`");
         $select_users->execute();
         $numbers_of_users = $select_users->rowCount();
      ?>
      <h3><?= $numbers_of_users; ?></h3>
      <p>Contas usuarios</p>
      <a href="contas_usuario.php" class="btn">Ver todas</a>
   </div>

   <div class="box">
      <?php
         $select_admins = $conn->prepare("SELECT * FROM `admin`");
         $select_admins->execute();
         $numbers_of_admins = $select_admins->rowCount();
      ?>
      <h3><?= $numbers_of_admins; ?></h3>
      <p>administradores</p>
      <a href="conta_administrador.php" class="btn">Ver todos</a>
   </div>

   <div class="box">
      <?php
         $select_messages = $conn->prepare("SELECT * FROM `mensagem`");
         $select_messages->execute();
         $numbers_of_messages = $select_messages->rowCount();
      ?>
      <h3><?= $numbers_of_messages; ?></h3>
      <p>Nova mensagem</p>
      <a href="messages.php" class="btn">Ver todas</a>
   </div>

   </div>

</section>

<!-- A seção Painel de administração termina -->









<!-- Link do arquivo JS personalizado  -->
<script src="../js/admin_script.js"></script>

</body>
</html>