<?php

include __DIR__ . './../components/connect.php';

@session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);

   $qntd = $_POST['qntd'];
   $qntd = filter_var($qntd, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../imagem_editada/'.$image;

   $select_products = $conn->prepare("SELECT * FROM `produtos` WHERE nome = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message[] = 'Já existe um produto com o mesmo nome!';
   }else{
      if($image_size > 2000000){
         $message[] = 'O tamanho da imagem é demasiado';
      }else{
         move_uploaded_file($image_tmp_name, $image_folder);

         $insert_product = $conn->prepare("INSERT INTO `produtos`(nome, categoria, preço, imagem, disponivel) VALUES(?,?,?,?,?)");
         $insert_product->execute([$name, $category, $price, $image, $qntd]);

         $message[] = 'novo produto adicionado com sucesso!';
      }

   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `produtos` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../imagem_editada/'.$fetch_delete_image['image']);
   $delete_product = $conn->prepare("DELETE FROM `produtos` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `compras` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   header('location:produtos.php');

}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>produtos</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Link de arquivo CSS personalizado  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_cabeçalho.php' ?>

<!-- A seção Adicionar Produtos é iniciada  -->

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Adicionar produtos</h3>
      <input type="text" required placeholder="Insira o nome do produto" name="name" maxlength="100" class="box">
      <input type="number" min="0" required placeholder="Insira o preço do produto" name="price" onkeypress="if(this.value.length == 10) return false;" class="box">
      <input type="number" min="0" required placeholder="Insira a quantidade disponível" name="qntd" onkeypress="if(this.value.length == 10) return false;" class="box">
      <select name="category" class="box" required>
         <option value="" disabled selected>seleciona a categoria --</option>
         <option value="prato principal">Prato principal</option>
         <option value="comida">Comida</option>
         <option value="bebida">Bebida</option>
         <option value="sobremesa">Sobremesas</option>
      </select>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <input type="submit" value="Adicionar produto" name="add_product" class="btn">
   </form>

</section>

<!-- Adicionar Extremidades da Seção Produtos -->

<!-- Mostrar produtos começa a seção  -->

<section class="show-products" style="padding-top: 0;">

   <div class="box-container">

   <?php
      $show_products = $conn->prepare("SELECT * FROM `produtos`");
      $show_products->execute();
      if($show_products->rowCount() > 0){
         while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <img src="../imagem_editada/<?= $fetch_products['imagem']; ?>" alt="">
      <div class="flex">
         <div class="price"><span>kz </span><?= $fetch_products['preço']; ?><span></span></div>
         <div class="category"><?= $fetch_products['categoria']; ?></div>
      </div>
      <div class="name"><?= $fetch_products['nome']; ?></div>
      <div class="flex-btn">
         <a href="editar_produto.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Editar</a>
         <a href="produtos.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('vai querer eliminar este produto?');">Excluir</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">nenhum produto adicionado ainda!</p>';
      }
   ?>

   </div>

</section>

<!-- Mostrar Fim da Seção de Produtos -->










<!-- Link do arquivo JS personalizado  -->
<script src="../js/admin_script.js"></script>

</body>
</html>