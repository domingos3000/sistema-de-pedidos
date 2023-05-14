<?php

include __DIR__ . './components/connect.php';

@session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `usuario` WHERE email = ? AND senha = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['id'];
      $_SESSION["mensagens"][] = 'Logado com sucesso!';
      header('location:home.php');
      return;
   }else{
      $_SESSION["mensagens"][] = 'O nome de usuario ou senha está incorrecta!';
   }

}

include_once __DIR__ . "./components/cabecalho_publico.php";

?>


<section class="form-container">

   <form action="" method="post">
      <h3>Iniciar sessão</h3>
      <input type="email" name="email" required placeholder="insira o seu email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="insira sua senha" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="inciar a sessão" name="submit" class="btn">
      <p>Não tem nenhuma conta ainda? <a href="registro.php">registrar agora</a> | <a href="recuperar_senha.php" target="_blank">Recuperar minha senha</a></p>
   </form>

</section>











<?php include 'components/footer.php'; ?>






<!-- link de arquivo js personalizado -->
<script src="js/script.js"></script>

</body>
</html>