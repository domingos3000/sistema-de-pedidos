<?php

include __DIR__ . './components/connect.php';

@session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

if(isset($_POST['submit'])){

   $address = $_POST['flat'] .', '.$_POST['building'].', '.$_POST['area'].', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] ;
   $address = filter_var($address, FILTER_SANITIZE_STRING);

   $update_address = $conn->prepare("UPDATE `usuario` set endereço = ? WHERE id = ?");
   $update_address->execute([$address, $user_id]);

   $message[] = 'endereço salvo!';

}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>editar endereço</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- link de arquivo css personalizado -->
   <link rel="stylesheet" href="./css/animate.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/usuario_cabeçalho.php' ?>

<section class="form-container">

   <form action="" method="post">
      <h3>A sua morada</h3>
      <input type="text" class="box" placeholder="Apartamento." required maxlength="50" name="flat">
      <input type="text" class="box" placeholder="edificio." required maxlength="50" name="building">
      <input type="text" class="box" placeholder="nome da área" required maxlength="50" name="area">
      <!--<input type="text" class="box" placeholder="nome da cidade" required maxlength="50" name="town">-->
      <input type="text" class="box" placeholder="nome da cidade" required maxlength="50" name="city"> 
      <input type="text" class="box" placeholder="nome do estado" required maxlength="50" name="state">
      <input type="text" class="box" placeholder="nome do país" required maxlength="50" name="country">
     <!-- <input type="number" class="box" placeholder="Código PIN" required max="999999" min="0" maxlength="6" name="pin_code"> -->
      <input type="submit" value="salvar endereço" name="submit" class="btn">
   </form>

</section>










<?php include 'components/footer.php' ?>







<!-- link de arquivo js personalizado -->
<script src="js/script.js"></script>

</body>
</html>