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

if(isset($_GET['filter'])){

   $id_filter = $_GET['filter'];

   if($id_filter == "all"){

      $sql = $conn->prepare("SELECT * FROM pedidos");
      $sql->execute();

      if($sql->rowCount() > 0){
      
         $dados_filtrados = $sql->fetchAll(PDO::FETCH_ASSOC);

      } else {
         $dados_filtrados = false;
      }

   } else {

      $sql = $conn->prepare("SELECT * FROM pedidos WHERE estado_pagamento = ?");
      $sql->execute([$id_filter]);
   
      if($sql->rowCount() > 0){
         
         $dados_filtrados = $sql->fetchAll(PDO::FETCH_ASSOC);
         
      } else {
         $dados_filtrados = false;
      }
   }

} else {
   
   $sql = $conn->prepare("SELECT * FROM pedidos");
   $sql->execute();

   if($sql->rowCount() > 0){
      $dados_filtrados = $sql->fetchAll(PDO::FETCH_ASSOC);
   }
    else {
      $dados_filtrados = false;
   }
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
      if(!$dados_filtrados):
         echo "<p class='empty'>Nenhum dado encontrado!</p>";
      else:
      foreach ($dados_filtrados as $dados):
   ?>
   <div class="box">
      <p> Usuario id : <span><?= $dados['user_id']; ?></span> </p>
      <p> Data : <span><?= $dados['data']; ?></span> </p>
      <p> Nome : <span><?= $dados['nome']; ?></span> </p>
      <p> Email : <span><?= $dados['email']; ?></span> </p>
      <p> Número : <span><?= $dados['contacto']; ?></span> </p>
      <p> Endereço : <span><?= $dados['endereço']; ?></span> </p>
      <p> Produtos total : <span><?= $dados['total_produtos']; ?></span> </p>
      <p> Preço total : <span>Kz <?= $dados['total_preço']; ?></span> </p>
      <p> Metodo de pagamento : <span><?= $dados['metodo']; ?></span> </p>
      <form action="" method="POST">
         <input type="hidden" name="order_id" value="<?= $dados['id']; ?>">

         <select <?= $dados['estado_pagamento'] == '0' ? 'disabled' : ''; ?> name="payment_status" class="drop-down">
            <option selected disabled value="<?= $dados['estado_pagamento']; ?>">
               <?= pegarEstado($dados['estado_pagamento']); ?>
            </option>
            
            <option value="1">Pendente</option>
            <option value="2">Processando</option>
            <option value="3">Completado</option>
         </select>

         <div class="flex-btn">

            <?=

               $dados['estado_pagamento'] != '0' 
                  ? "<input type='submit' value='concluir' class='btn' name='update_payment'>" 
                  : '';
            
            ?>

            <a href="ordem_pedido.php?delete=<?= $dados['id']; ?>" class="delete-btn" onclick="return confirm('pretende eliminar este pedido?');">excluir</a>
         </div>
      </form>
   </div>

      <?php
         endforeach;
         endif;
      ?>

   </div>

</section>

<!-- Termina a seção de pedidos feitos -->









<!-- Link do arquivo JS personalizado  -->
<script src="../js/admin_script.js"></script>

</body>
</html>