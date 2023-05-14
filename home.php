<?php

include __DIR__ . './components/connect.php';

@session_start();

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
   <title>Pagina inicial</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- link de arquivo css personalizado -->
   <link rel="stylesheet" href="./css/animate.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/usuario_cabeçalho.php'; ?>



<section class="hero">

   <div class="swiper hero-slider">

      <div class="swiper-wrapper">

         <div class="swiper-slide slide">
            <div class="content">
               <span>Pedidos online</span>
               <h3>Variedade de produtos</h3>
               <a href="menu.php" class="btn">ver menu</a>
            </div>
            <div class="image">
               <img src="images/home-img-1.png" alt="">
            </div>
         </div>

         <div class="swiper-slide slide">
            <div class="content">
               <span>Pedido online</span>
               <h3>Tão perto de si</h3>
               <a href="menu.php" class="btn">ver menu</a>
            </div>
            <div class="image">
               <img src="images/home-img-2.png" alt="">
            </div>
         </div>

         <div class="swiper-slide slide">
            <div class="content">
               <span>Pedido online</span>
               <h3>Obrigado pela escolha</h3>
               <a href="menu.php" class="btn">ver menu</a>
            </div>
            <div class="image">
               <img src="images/home-img-3.png" alt="">
            </div>
         </div>

      </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

<section class="category">

   <h1 class="titulo">Nossa categoria</h1>

   <div class="box-container">

      <a href="categoria.php?category=comida" class="box">
         <img src="images/cat-1.png" alt="">
         <h3>Comida</h3>
      </a>

      <a href="categoria.php?category=prato principal" class="box">
         <img src="images/cat-2.png" alt="">
         <h3>Prato principal</h3>
      </a>

      <a href="categoria.php?category=bebida" class="box">
         <img src="images/cat-3.png" alt="">
         <h3>Bebidas</h3>
      </a>

      <a href="categoria.php?category=sobremesa" class="box">
         <img src="images/cat-4.png" alt="">
         <h3>sobremesas</h3>
      </a>

   </div>

</section>




<section class="products">

   <h1 class="titulo">Produtos recentes</h1>

   <div class="box-container">

      <?php
         $select_products = $conn->prepare("SELECT * FROM `produtos` LIMIT 6");
         $select_products->execute();
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_products['nome']; ?>">
         <input type="hidden" name="price" value="<?= $fetch_products['preço']; ?>">
         <input type="hidden" name="image" value="<?= $fetch_products['imagem']; ?>">
         <a href="visualização.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
         <img src="imagem_editada/<?= $fetch_products['imagem']; ?>" alt="">
         <a href="categoria.php?category=<?= $fetch_products['categoria']; ?>" class="cat"><?= $fetch_products['categoria']; ?></a>
         <div class="name"><?= $fetch_products['nome']; ?></div>
         <div class="flex">
            <div class="price"><span>Kz</span><?= $fetch_products['preço']; ?></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
         </div>
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">nenhum produto adicionado ainda!</p>';
         }
      ?>

   </div>

   <div class="more-btn">
      <a href="menu.php" class="btn">ver tudo</a>
   </div>

</section>


















<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- link de arquivo js personalizado -->
<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".hero-slider", {
   loop:true,
   grabCursor: true,
   effect: "flip",
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
});

</script>

</body>
</html>