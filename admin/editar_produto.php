<?php

include __DIR__ . './../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $preço = $_POST['price'];
   $preço = filter_var($preço, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);

   $update_product = $conn->prepare("UPDATE `produtos` SET nome = ?, categoria = ?, preço = ? WHERE id = ?");
   $update_product->execute([$name, $category, $preço, $pid]);

   $message[] = 'produto atualizado!';

   $old_image = $_POST['old_image'];
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../imagem_editada/'.$image;

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'O tamanho da imagem é demasiado!';
      }else{
         $update_image = $conn->prepare("UPDATE `produtos` SET image = ? WHERE id = ?");
         $update_image->execute([$image, $pid]);
         move_uploaded_file($image_tmp_name, $image_folder);
         unlink('../imagem_editada/'.$old_image);
         $message[] = 'imagem adicionada!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Editar produto</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- link de arquivo css personalizado -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_cabeçalho.php' ?>

<!-- seção de atualização do produto é iniciada -->

<section class="update-product">

   <h1 class="heading">Editar produto</h1>

   <?php
      $update_id = $_GET['update'];
      $show_products = $conn->prepare("SELECT * FROM `produtos` WHERE id = ?");
      $show_products->execute([$update_id]);
      if($show_products->rowCount() > 0){
         while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="old_image" value="<?= $fetch_products['imagem']; ?>">
      <img src="../imagem_editada/<?= $fetch_products['imagem']; ?>" alt="">
      <span>Editar nome</span>
      <input type="text" required placeholder="Insira o nome do produto" name="name" maxlength="100" class="box" value="<?= $fetch_products['nome']; ?>">
      <span>Editar preço</span>
      <input type="number" min="0" max="9999999999" required placeholder="Insira o preço" name="price" onkeypress="if(this.value.length == 10) return false;" class="box" value="<?= $fetch_products['preço']; ?>">
      <span>Editar categoria</span>
      <select name="category" class="box" required>
         <option selected value="<?= $fetch_products['categoria']; ?>"><?= $fetch_products['categoria']; ?></option>
         <option value="prato principal">Prato principal</option>
         <option value="comida">Comida</option>
         <option value="bebida">Bebida</option>
         <option value="sobremesa">sobremesas</option>
      </select>
      <span>Editar imagem</span>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
      <div class="flex-btn">
         <input type="submit" value="Concluir" class="btn" name="update">
         <a href="produtos.php" class="option-btn">Voltar</a>
      </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">nenhum produto adicionado ainda!</p>';
      }
   ?>

</section>

<!-- seção de atualização do produto é terminada -->










<!-- link de arquivo js personalizado -->
<script src="../js/admin_script.js"></script>

</body>
</html>