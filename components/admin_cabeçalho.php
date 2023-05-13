<?php
if(isset($mensagem)){
   foreach($mensagem as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="painel.php" class="logo">Admin<span>Painel</span></a>

      <nav class="navbar">
         <a href="painel.php">Página inicial</a>
         <a href="produtos.php">produtos</a>
         <a href="ordem_pedido.php">Pedidos</a>
         <a href="conta_administrador.php">admins</a>
         <a href="contas_usuario.php">usuario</a>
         <a href="messages.php">mensagem</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile['nome']; ?></p>
         <a href="editar_perfil.php" class="btn">Editar senha</a>
         <div class="flex-btn">
            <a href="admin_login.php" class="option-btn">Entrar</a>
            <a href="registrar_admin.php" class="option-btn">registrar</a>
         </div>
         <a href="../components/admin_logout.php" onclick="return confirm('Vai querer mesmo terminar a sessão?');" class="delete-btn">Terminar</a>
      </div>

   </section>

</header>