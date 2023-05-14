<?php

include __DIR__ . './../components/connect.php';

@session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_admin = $conn->prepare("DELETE FROM `admin` WHERE id = ?");
   $delete_admin->execute([$delete_id]);
   header('location:admin_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contas de administradores</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- link de arquivo css personalizado -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_cabeçalho.php' ?>

<!-- seção de contas de administradores é iniciada -->

<section class="accounts">

   <h1 class="heading">conta de administradores</h1>

   <div class="box-container">

   <div class="box">
      <p>registrar novo admin</p>
      <a href="registrar_admin.php" class="option-btn">registrar</a>
   </div>

   <?php
      $select_account = $conn->prepare("SELECT * FROM `admin`");
      $select_account->execute();
      if($select_account->rowCount() > 0){
         while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <p> administrador id : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> nome de usúario : <span><?= $fetch_accounts['nome']; ?></span> </p>
      <div class="flex-btn">
         <a href="conta_administrador.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('Eliminar esta conta?');">excluir</a>
         <?php
            if($fetch_accounts['id'] == $admin_id){
               echo '<a href="editar_perfil.php" class="option-btn">Editar</a>';
            }
         ?>
      </div>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">não há contas disponíveis</p>';
   }
   ?>

   </div>

</section>

<!-- seção de contas de administradores é terminada -->



















<!-- link de arquivo js personalizado -->
<script src="../js/admin_script.js"></script>

</body>
</html>