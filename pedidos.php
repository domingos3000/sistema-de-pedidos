<?php

include __DIR__ . './components/connect.php';
include_once __DIR__ . './functions/pegarEstado.php';

@session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Pedidos</title>

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

<div class="heading">
   <h3>Pedidos</h3>
   <p><a href="html.php">Página inicial</a> <span> / Pedidos</span></p>
</div>

<section class="orders">

   <h1 class="titulo">Teus pedidos</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">por favor inicie a sessão antes, para visualizar os pedidos</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `pedidos` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>Data : <span><?= $fetch_orders['data']; ?></span></p>
      <p>Nome : <span><?= $fetch_orders['nome']; ?></span></p>
      <p>Email : <span><?= $fetch_orders['email']; ?></span></p>
      <p>Número : <span><?= $fetch_orders['contacto']; ?></span></p>
      <p>Endereço : <span><?= $fetch_orders['endereço']; ?></span></p>
      <p>Metodo de pagamento : <span><?= $fetch_orders['metodo']; ?></span></p>
      <p>Seu pedido : <span><?= $fetch_orders['total_produtos']; ?></span></p>
      <p>Preço total : <span>Kz<?= $fetch_orders['total_preço']; ?></span></p>

      <p>Estado do pagamento : <span style="color:<?php ?>"><?= pegarEstado($fetch_orders['estado_pagamento']); ?></span> </p>
      
      <?php if($fetch_orders['estado_pagamento'] == '1' && $fetch_orders['confirmacao_cliente'] != "true"): ?>
         <a class="btn-cancelar-pedido" href="functions/cancelar_pedido.php?id_pedido=<?= $fetch_orders['id']; ?>">
               Cancelar pedido
         </a>

      <?php endif; ?>

      <?php if($fetch_orders['confirmacao_cliente'] != 'true' && $fetch_orders['estado_pagamento'] == '2'): ?>
            <a class="btn-cancelar-pedido ok" href="functions/confirmar_pedido.php?id_pedido=<?= $fetch_orders['id']; ?>">
                  Confirmar como recebido
            </a>
         <?php endif; ?>
   </div>

   


   <?php
      }
      }else{
         echo '<p class="empty">nenhum pedido feito ainda!</p>';
      }
      }
   ?>

   </div>

</section>










<!-- seção de rodapé começa -->
<?php include 'components/footer.php'; ?>
<!-- seção de rodapé termina -->






<!-- link de arquivo js personalizado -->
<script src="js/script.js"></script>

</body>
</html>