<?php

include __DIR__ . './../components/connect.php';
include_once __DIR__ . './../functions/pegarEstado.php';

@session_start();

$motoboyId = $_SESSION['motoboy_id'];

if(!isset($motoboyId)){
   header('location: index.php');
};

if(isset($_POST['update_payment'])){

   if(!$_POST['payment_status']){
      header('location: painel.php?redirect=atender-pedido');
      return false;
   }
   

   $pedidos_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   
   $update_status = $conn->prepare("UPDATE `pedidos` SET confirmacao_motoboy = ? WHERE id = ?");
   $update_status->execute([$payment_status, $pedidos_id]);

   header('location: painel.php?redirect=atender-pedido');

}


if(isset($_GET['filter'])){

   $id_filter = $_GET['filter'];

   if($id_filter == "all"){

      $sql = $conn->prepare("SELECT * FROM pedidos WHERE confirmacao_motoboy = ? AND estado_pagamento != ?");
      $sql->execute(['false', '0']);

      if($sql->rowCount() > 0){
      
         $dados_filtrados = $sql->fetchAll(PDO::FETCH_ASSOC);

      } else {
         $dados_filtrados = false;
      }
   }

} else {
   
      $sql = $conn->prepare("SELECT * FROM pedidos WHERE confirmacao_motoboy = ? AND estado_pagamento != ?");
      $sql->execute(['false', '0']);

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

<?php include '../components/motoboy_cabeçalho.php' ?>

<!-- começa a seção de pedidos feitos  -->

<section class="placed-orders">

   <h1 class="heading">Pedidos</h1>

   <div class="box-container">

   <?php
      if(!$dados_filtrados):
         echo "<p class='empty'>Nenhum dado encontrado!</p>";
      else:
      foreach ($dados_filtrados as $dados):
         $all_produts = json_decode($dados['total_produtos'], true);
   ?>
   <div class="box">
      <p> Usuario id : <span><?= $dados['user_id']; ?></span> </p>
      <p> Data : <span><?= $dados['data']; ?></span> </p>
      <p> Nome : <span><?= $dados['nome']; ?></span> </p>
      <p> Email : <span><?= $dados['email']; ?></span> </p>
      <p> Número : <span><?= $dados['contacto']; ?></span> </p>
      <p> Endereço : <span><?= $dados['endereço']; ?></span> </p>
      <p> Produtos total : <span>

      <?php
            foreach($all_produts as $product):
               $produto = $product['pedido'];
               echo "{$produto['nome']} ({$produto['preco']} kz x {$produto['qntd']}), \n";
            endforeach;
      ?>

      </span> </p>
      <p> Preço total : <span>Kz <?= number_format($dados['total_preço'], 2, ",", ".") ; ?></span> </p>
      <p> Metodo de pagamento : <span><?= $dados['metodo']; ?></span> </p>
      <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
         <input type="hidden" name="order_id" value="<?= $dados['id']; ?>">

         <select <?= $dados['estado_pagamento'] == '0' ? 'disabled' : ''; ?> name="payment_status" class="drop-down">
            <option selected disabled value="false">
               <?= pegarEstado($dados['estado_pagamento']); ?>
            </option>
            
            <option value="true">Entregue</option>
         </select>

         <div class="flex-btn">
            <?=
               $dados['estado_pagamento'] != '0' 
                  ? "<input type='submit' value='Confirmar' class='btn' name='update_payment'>" 
                  : '';
            ?>
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