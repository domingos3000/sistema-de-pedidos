<?php

include __DIR__ . './../components/connect.php';

@session_start();

$motoboyId = $_SESSION['motoboy_id'];
$redirectAtenderPedido = isset($_GET['redirect']) ? $_GET['redirect'] : false;

if(!isset($motoboyId)){
   header('location: index.php');
}

if($redirectAtenderPedido == 'atender-pedido'){
   header('location: atender-pedido.php');
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

<?php include '../components/motoboy_cabeçalho.php' ?>

<!-- A seção Painel de administração é iniciada  -->

<section class="dashboard">

   <h1 class="heading">Painel administrativo</h1>

   <div class="box-container">

   <div class="box">
      <h3>Bem-vindo/a!</h3>
      <p><?= $fetch_profile['nome']; ?></p>
   </div>

   <div class="box">
      <?php
         $total_pendings = 0;
         $select_pendings = $conn->prepare("SELECT * FROM pedidos WHERE confirmacao_motoboy = ? AND estado_pagamento != ?");
         $select_pendings->execute(['false', '0']);
         $count_pendings = $select_pendings->rowCount();
      ?>
      <h3> <?= $count_pendings; ?> </h3>
      <p>Total a ser entregue</p>
      
      <?= $count_pendings > 0
         ? "<a href='atender-pedido.php' class='btn'>Atender</a>"
         : "<a  class='btn' data-disabled >Ver pedidos</a>"
      ?>

   </div>

   </div>

</section>

<!-- A seção Painel de administração termina -->









<!-- Link do arquivo JS personalizado  -->
<script src="../js/admin_script.js"></script>

</body>
</html>