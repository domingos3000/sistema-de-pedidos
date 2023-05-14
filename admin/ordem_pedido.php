<?php

include __DIR__ . './../components/connect.php';
include_once __DIR__ . './../functions/pegarEstado.php';

@session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update_payment'])){

   $pedidos_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $update_status = $conn->prepare("UPDATE `pedidos` SET estado_pagamento = ? WHERE id = ?");
   $update_status->execute([$payment_status, $pedidos_id]);
   $message[] = 'Estado do pedido alterado com sucesso!';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `pedidos` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:ordem_pedido.php');
}

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

   <!-- Link de arquivo CSS personalizado  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_cabeçalho.php' ?>

<!-- começa a seção de pedidos feitos  -->

<section class="placed-orders">

   <h1 class="heading">Pedidos</h1>

   <div class="box-container">

   <?php
      $select_orders = $conn->prepare("SELECT * FROM `pedidos`");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> Usuario id : <span><?= $fetch_orders['user_id']; ?></span> </p>
      <p> Data : <span><?= $fetch_orders['data']; ?></span> </p>
      <p> Nome : <span><?= $fetch_orders['nome']; ?></span> </p>
      <p> Email : <span><?= $fetch_orders['email']; ?></span> </p>
      <p> Número : <span><?= $fetch_orders['contacto']; ?></span> </p>
      <p> Endereço : <span><?= $fetch_orders['endereço']; ?></span> </p>
      <p> Produtos total : <span><?= $fetch_orders['total_produtos']; ?></span> </p>
      <p> Preço total : <span>Kz <?= $fetch_orders['total_preço']; ?></span> </p>
      <p> Metodo de pagamento : <span><?= $fetch_orders['metodo']; ?></span> </p>
      <form action="" method="POST">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">

         <select <?= $fetch_orders['estado_pagamento'] == 'cancelado' ? 'disabled' : ''; ?> name="payment_status" class="drop-down">
            <option selected disabled value="<?= $fetch_orders['estado_pagamento']; ?>">
               <?= pegarEstado($fetch_orders['estado_pagamento']); ?>
            </option>
            
            <option value="1">Pendente</option>
            <option value="2">Processando</option>
            <option value="3">Completado</option>
         </select>

         <div class="flex-btn">
            <input type="submit" value="concluir" class="btn" name="update_payment">
            <a href="ordem_pedido.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('pretende eliminar este pedido?');">excluir</a>
         </div>
      </form>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">Não tem pedidos ainda!</p>';
   }
   ?>

   </div>

</section>

<!-- Termina a seção de pedidos feitos -->









<!-- Link do arquivo JS personalizado  -->
<script src="../js/admin_script.js"></script>

</body>
</html>