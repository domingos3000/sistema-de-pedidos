<?php

include __DIR__ . './../components/connect.php';

@session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   if(!empty($name)){
      $select_name = $conn->prepare("SELECT * FROM `admin` WHERE nome = ?");
      $select_name->execute([$name]);
      if($select_name->rowCount() > 0){
         $message[] = 'nome de usuário já tomado!';
      }else{
         $update_name = $conn->prepare("UPDATE `admin` SET nome = ? WHERE id = ?");
         $update_name->execute([$name, $admin_id]);
      }
   }

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $select_old_pass = $conn->prepare("SELECT senha FROM `admin` WHERE id = ?");
   $select_old_pass->execute([$admin_id]);
   $fetch_prev_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);
   $prev_pass = $fetch_prev_pass['senha'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = sha1($_POST['confirm_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   if($old_pass != $empty_pass){
      if($old_pass != $prev_pass){
         $message[] = 'senha antiga não correspondida!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'confirmar senha não correspondida!';
      }else{
         if($new_pass != $empty_pass){
            $update_pass = $conn->prepare("UPDATE `admin` SET senha = ? WHERE id = ?");
            $update_pass->execute([$confirm_pass, $admin_id]);
            $message[] = 'senha alterada com sucesso!';
         }else{
            $message[] = 'Por favor insira a nova senha!';
         }
      }
   }

}

?>

<!DOCTYPE html>
<html lang="Pt-br">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Editar senha</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- link de arquivo css personalizado -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_cabeçalho.php' ?>

<!-- seção de atualização do perfil de administrador começa -->

<section class="form-container">

   <form action="" method="POST">
      <h3>Editar senha</h3>
      <input type="text" name="name" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" placeholder="<?= $fetch_profile['nome']; ?>">
      <input type="password" name="old_pass" maxlength="20" placeholder="Insira senha antiga" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" maxlength="20" placeholder="Insira nova senha" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" maxlength="20" placeholder="Confirma a senha" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Concluir" name="submit" class="btn">
   </form>

</section>

<!-- seção de atualização do perfil de administrador termina -->









<!-- link de arquivo js personalizado -->
<script src="../js/admin_script.js"></script>

</body>
</html>