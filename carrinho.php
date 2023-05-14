<?php

include __DIR__ . './components/connect.php';

@session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `compras` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
   $message[] = 'item apagado!';
}

if(isset($_POST['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `compras` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   // header('location:cart.php');
   $message[] = 'excluiu tudo do carrinho!';
}

if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `compras` SET quantidade = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'Quantidade de carrinho atualizada';
}

$grand_total = 0;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Carrinho de Compras</title>

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
   <h3>Carrinho de Compras</h3>
   <p><a href="home.php">Página inicial</a> <span> / carrinho</span></p>
</div>

<!-- seção de carrinho de compras começa -->

<section class="products">

   <h1 class="titulo">o seu carrinho</h1>

   <div class="box-container">

      <?php
         $grand_total = 0;
         $select_cart = $conn->prepare("SELECT * FROM `compras` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
         <a href="visualização.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
         <button type="submit" class="fas fa-times" name="delete" onclick="return confirm('pretende eliminar este item?');"></button>
         <img src="imagem_editada/<?= $fetch_cart['imagem']; ?>" alt="">
         <div class="name"><?= $fetch_cart['nome']; ?></div>
         <div class="flex">
            <div class="price"><span>Kz</span><?= $fetch_cart['preço']; ?></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantidade']; ?>" maxlength="2">
            <button type="submit" class="fas fa-edit" name="update_qty"></button>
         </div>
         <div class="sub-total"> sub total : <span>Kz<?= $sub_total = ($fetch_cart['preço'] * $fetch_cart['quantidade']); ?></span> </div>
      </form>
      <?php
               $grand_total += $sub_total;
            }
         }else{
            echo '<p class="empty">o seu carrinho está vazio</p>';
         }
      ?>

   </div>

   <div class="cart-total">
      <p>total : <span>Kz<?= $grand_total; ?></span></p>
      <a href="processo_saida.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">proseguir com a compra</a>
   </div>

   <div class="more-btn">
      <form action="" method="post">
         <button type="submit" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" name="delete_all" onclick="return confirm('quer mesmo apagar todos item do seu carrinho?');">Apagar todos</button>
      </form>
      <a href="menu.php" class="btn">continue fazendo compras</a>
   </div>

</section>

<!-- seção do carrinho de compras termina -->










<!-- seção de rodapé começa -->
<?php include 'components/footer.php'; ?>
<!-- seção de rodapé termina -->








<!-- link de arquivo js personalizado -->
<script src="js/script.js"></script>

</body>
</html>