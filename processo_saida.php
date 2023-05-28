<?php

include __DIR__ . './components/connect.php';
include_once __DIR__ . './functions/gerando-id-unico.php';

@session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `compras` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      if($address == ''){
         $_SESSION['mensagens'][] = 'por favor, adicione o seu endereço!';
      }else{

         $idUnico = gerandoIdUnico();
         
         $insert_order = $conn->prepare("INSERT INTO `pedidos`(id, user_id, nome, contacto, email, metodo, endereço, total_produtos, total_preço, estado_pagamento) VALUES(?,?,?,?,?,?,?,?,?, 1)");
         $insert_order->execute([$idUnico, $user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

         // $delete_cart = $conn->prepare("UPDATE `produtos` SET `disponivel` = ? WHERE `id` = ?");
         // $delete_cart->execute([$user_id]);

         $delete_cart = $conn->prepare("DELETE FROM `compras` WHERE user_id = ?");
         $delete_cart->execute([$user_id]);

         $_SESSION['mensagens'][] = 'pedido feito com sucesso!';
      }
      
   }else{
      $_SESSION['mensagens'][] = 'seu carrinho está vazio';
   }

}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Processos de saída</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- link de arquivo css personalizado -->
   <link rel="stylesheet" href="./css/animate.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- seção de cabeçalho começa -->
<?php 
include __DIR__ . './components/usuario_cabeçalho.php'; 
include __DIR__ . './components/html_mensagens_flash.php';
?>
<!-- seção de cabeçalho termina -->

<div class="heading">
   <h3>Processos de saída</h3>
   <p><a href="home.php">Página inicial</a> <span> / Processos de saída</span></p>
</div>

<section class="checkout">

   <h1 class="titulo">resumo do pedido</h1>

<form action="" method="post">

   <div class="cart-items">
      <h3>item do carrinho</h3>
      <?php
         $grand_total = 0;
         $cart_items = [];
         $select_cart = $conn->prepare("SELECT * FROM `compras` WHERE user_id = ?");
         $select_cart->execute([$user_id]);

         if($select_cart->rowCount() > 0):
            $fetch_cart = $select_cart->fetchAll(PDO::FETCH_ASSOC);
            $grand_total = 0;
            $total_products = array();

            foreach ($fetch_cart as $cart):
               $grand_total += $cart['preço'] * $cart['quantidade'];

               $total_products[] = ['pedido' => [
                  'id_compra' => $cart['id'],
                  'nome' => $cart['nome'],
                  'qntd' => $cart['quantidade'],
                  'preco' => $cart['preço'],
                  'subtotal' => $cart['quantidade'] * $cart['preço']
              ]];
         ?>
            <p><span class="name"><?= $cart['nome']; ?></span><span class="price">Kz <?= $cart['preço']; ?> x <?= $cart['quantidade']; ?></span></p>
         
         <?php
               endforeach;
               $total_products = json_encode($total_products);
            else:
               echo '<p class="empty">O seu carrinho está vazio!</p>';
            endif;
         ?>

      <p class="grand-total"><span class="name">total:</span><span class="price">Kz <?= $grand_total; ?></span></p>
      <a href="carrinho.php" class="btn">ver o cartão</a>
   </div>

   <input type="hidden" name="total_products" value='<?= $total_products; ?>' >
   <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
   <input type="hidden" name="name" value="<?= $fetch_profile['nome'] ?>">
   <input type="hidden" name="number" value="<?= $fetch_profile['contacto'] ?>">
   <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
   <input type="hidden" name="address" value="<?= $fetch_profile['endereço'] ?>">

   <div class="user-info">
      <h3>suas informações</h3>
      <p><i class="fas fa-user"></i><span><?= $fetch_profile['nome'] ?></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['contacto'] ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
      <a href="editar_perfil.php" class="btn">editar informações</a>
      <h3>endereço da entrega</h3>
      <p><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['endereço'] == ''){echo 'por favor insira o seu endereço';}else{echo $fetch_profile['endereço'];} ?></span></p>
      <a href="editar_endereço.php" class="btn">editar endereço</a>
      <select name="method" class="box" required>
         <option value="" disabled selected>seleciona o metodo de pagamento --</option>
         <option value="dinheiro na entrega">dinheiro na entrega</option>
         <option value="cartão de crédito">cartão de crédito</option>
         <option value="Paypal">Paypal</option>
         <option value="E-kwanza">E-kwanza</option>
      </select>
      <input type="submit" value="concluir" class="btn <?php if($fetch_profile['endereço'] == ''){echo 'disabled';} ?>" style="width:100%; background:var(--red); color:var(--white);" name="submit">
   </div>

</form>
   
</section>









<!-- seção de rodapé começa -->
<?php include 'components/footer.php'; ?>
<!-- seção de rodapé termina -->






<!-- link de arquivo js personalizado -->
<script src="js/script.js"></script>

</body>
</html>