<?php

include __DIR__ . './components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include __DIR__ . './components/add_carrinho.php';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Visualização Rápida</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- link de arquivo css personalizado -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/usuario_cabeçalho.php'; ?>

<section class="quick-view">

   <h1 class="titulo">Visualização rápida</h1>

   <?php
      $pid = $_GET['pid'];
      $select_products = $conn->prepare("SELECT * FROM `produtos` WHERE id = ?");
      $select_products->execute([$pid]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_products['nome']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_products['preço']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_products['imagem']; ?>">
      <img src="imagem_editada/<?= $fetch_products['imagem']; ?>" alt="">
      <a href="categoria.php?category=<?= $fetch_products['categoria']; ?>" class="cat"><?= $fetch_products['categoria']; ?></a>
      <div class="name"><?= $fetch_products['nome']; ?></div>
      <div class="flex">
         <div class="price"><span>kz</span><?= $fetch_products['preço']; ?></div>
         <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
      </div>
      <button type="submit" name="add_to_cart" class="cart-btn">adicionar ao cartão</button>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">nenhum produto adicionado ainda!</p>';
      }
   ?>

</section>
















<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- link de arquivo js personalizado -->
<script src="js/script.js"></script>


</body>
</html>