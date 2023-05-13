<?php

if(isset($_POST['add_to_cart'])){

   if($user_id == ''){
      header('location:login.php');
   }else{

      $pid = $_POST['pid'];
      $pid = filter_var($pid, FILTER_SANITIZE_STRING);
      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $preço = $_POST['price'];
      $preço = filter_var($preço, FILTER_SANITIZE_STRING);
      $image = $_POST['image'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);
      $qty = $_POST['qty'];
      $qty = filter_var($qty, FILTER_SANITIZE_STRING);

      $check_cart_numbers = $conn->prepare("SELECT * FROM `compras` WHERE nome = ? AND user_id = ?");
      $check_cart_numbers->execute([$name, $user_id]);

      if($check_cart_numbers->rowCount() > 0){
         $message[] = 'já adicionado ao carrinho!';
      }else{
         $insert_cart = $conn->prepare("INSERT INTO `compras`(user_id, pid, nome, preço, quantidade, imagem) VALUES(?,?,?,?,?,?)");
         $insert_cart->execute([$user_id, $pid, $name, $preço, $qty, $image]);
         $message[] = 'adicionado ao carrinho!';
         
      }

   }

}

?>