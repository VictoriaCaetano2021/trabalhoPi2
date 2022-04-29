<?php
include 'conexao.php';

session_start();

if (isset($_SESSION['usuario'])) {
header("location:inserirPergunta.php");
die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>Pagina Inicial - Apresentação</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-dark ">
  <div class="container-fluid ">
    <a class="navbar-brand text-white" href="index.php">INSIDE.</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-white">
        <li class="nav-item">
          <a class="nav-link active text-white" aria-current="page" href="index.php">voltar</a>
         </li>
        <li class="nav-item"> 
        <button type="button" name="sair"class="btn btn-dark" href="?usuarioLogOut" ><a class="text-decoration-none text-white"href="?usuarioLogOut">Sair</a></button>
        </li>
      </ul>
      
    </div>
  </div>
</nav>
    <section class="jumbotron text-center bg-dark text-white">
      <div class="container">
      <h1 style="color:#DBB522;" class="jumbotron-heading ">INSIDE.</h1> <br>
      </div>
    </section>
    <br>
    <section class="jumbotron text-center">
        <div class="container">
        <div class="container col-md-5 mx-auto">
        <div class="shadow-lg p-3 mb-5 bg-white  rounded">
    <section class="jumbotron  text-center "><br><br>

    <form class="form-entrar" action="criarUsuario.php" method="post">
        <h1 class="h3 mb-3 font-weight-normal">Novo Usuario</h1>
        <h5>Preencha o formulário e seja um insider</h5>
        <div class="row g-3">
        <div class="col"><br>
            <input type="text" class="form-control"class="form-control" name="nome" placeholder="Nome" required><br>
            <input type="mail" class="form-control" placeholder="Email" name="email" required><br>
            <input type="password" class="form-control" placeholder="Senha Segura" name="senha" required><br>
            <input type="password" class="form-control" placeholder="Confirme a senha" name="confirmaSenha" required><br>
        </div>
        </div>
        <br>    
        <br>    <button class="btn btn-lg btn-warning btn-block" name="enviar" type="submit">Criar</button>
    </form>

</section>
</div>
</div>
</div>
</section>
</body>
</html>

<?php

  if (isset($_POST['enviar'])) {

    $email=$_POST['email'];
    $nome=$_POST['nome'];
    $senha=$_POST['senha'];
    $confirmaSenha=$_POST['confirmaSenha'];

    if($senha==$confirmaSenha){

        $sqlCriaUsuario="SELECT email_usuario from trabalhopi.tb_usuario where email_usuario='$email';";
        $result=pg_query($conexao, $sqlCriaUsuario);
        $cont=pg_num_rows($result);

        if($cont==0){
          $sqlCriaUsuario="INSERT INTO TRABALHOPI.TB_USUARIO(NM_USUARIO, EMAIL_USUARIO, SN_USUARIO) VALUES ('$nome','$email','$senha');";
          pg_query($conexao, $sqlCriaUsuario);
          echo "<script>
                   alert('Usuario criado com sucesso! :D Faça login e tenha a esperiêcia completa de ser um INSIDER ');
                   window.location.href='login.php';
                 </script>";
        }else{
          echo "<script>
                   alert('Usuario já existe! tente novamente');
                </script>";
        }
    }
}

?>