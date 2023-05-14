<?php

include __DIR__ . './components/connect.php';

@session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_carrinho.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>menu</title>

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
   <h3>nosso menu</h3>
   <p><a href="home.php">Página inicial</a> <span> / menu</span></p>
</div>

<!-- seção de menu começa -->

<section class="products">

   <h1 class="titulo">Menu</h1>

   <div class="box-container">

      <?php
         $select_products = $conn->prepare("SELECT * FROM `produtos`");
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
            <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2"">
         </div>
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">nenhum produto adicionado ainda!</p>';
         }
      ?>

   </div>

</section>


<!-- seção de menu termina -->
























<!-- seção de rodapé começa -->
<?php include 'components/footer.php'; ?>
<!-- seção de rodapé termina -->








<!-- link de arquivo js personalizado -->
<script src="js/script.js"></script>

</body>
</html>