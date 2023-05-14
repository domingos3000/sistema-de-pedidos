<?php

include __DIR__ . './../components/connect.php';

@session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `mensagem` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:messages.php');
}

?>

<!DOCTYPE html>
<html lang="Pt-br">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>mensagem</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- link de arquivo css personalizado -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_cabeçalho.php' ?>

<!-- seção de mensagens começa -->

<section class="messages">

   <h1 class="heading">mensagem</h1>

   <div class="box-container">

   <?php
      $select_messages = $conn->prepare("SELECT * FROM `mensagem`");
      $select_messages->execute();
      if($select_messages->rowCount() > 0){
         while($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> Nome : <span><?= $fetch_messages['nome']; ?></span> </p>
      <p> Número : <span><?= $fetch_messages['contacto']; ?></span> </p>
      <p> Email : <span><?= $fetch_messages['email']; ?></span> </p>
      <p> mensagem : <span><?= $fetch_messages['mensagem']; ?></span> </p>
      <a href="messages.php?delete=<?= $fetch_messages['id']; ?>" class="delete-btn" onclick="return confirm('Tem certeza que quer excluir esta mensagem?');">excluir</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">Não tem nenhuma mensagem</p>';
      }
   ?>

   </div>

</section>

<!-- seção de mensagens termina -->









<!-- link de arquivo js personalizado -->
<script src="../js/admin_script.js"></script>

</body>
</html>