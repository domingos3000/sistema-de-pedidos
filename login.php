<?php
@session_start();

include_once __DIR__ . './components/connect.php';


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

   if($select_user->rowCount() > 0):

      if(intval($row["acesso"]) <= 0):
         $_SESSION["mensagens"][] = "Infelizmente você foi bloqueado por errar a senha três vezes seguidas!";
         $_SESSION["mensagens"][] = "Crie uma nova senha";
      
      else:
         $_SESSION['user_id'] = $row['id'];
         $_SESSION["mensagens"][] = 'Logado com sucesso!';

         if($row["acesso"] != "3"):
            $stmt = $conn->prepare("UPDATE usuario SET acesso = ? WHERE id = ?");
            $stmt->execute([3, $row['id']]);
         endif;
         
         header('location:home.php');
         return;
      endif; 
   
   else:
      $stmt = $conn->prepare("SELECT acesso, id FROM usuario WHERE email = ?");
      $stmt->execute([$email]);

      if($stmt->rowCount() > 0):
         $user = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
         $user_id = $user["id"];
         $count_acess = intval($user["acesso"]) - 1;

         if($user["acesso"] > 0):
            $stmt = $conn->prepare("UPDATE usuario SET acesso = ? WHERE id = ?");
            $stmt->execute([$count_acess, $user_id]);

            $_SESSION["mensagens"][] = "Resta(m) $count_acess tentativa(s)";
         
         else:
            $_SESSION["mensagens"][] = "Infelizmente você foi bloqueado por errar a senha três vezes seguidas!";
         endif;
      endif;

      $_SESSION["mensagens"][] = 'O nome de usuario ou senha está incorrecta!';
   endif;

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