<?php
include 'conexao.php';

session_start();

if (isset($_SESSION['usuario'])) {
header("location:paginaInicial.php");
die();
}

include 'conexao.php';
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
  <title>Login</title>
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

    <form class="form-entrar" action="login.php" method="post">
        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
        </svg>

        <i class="fa-solid fa-user"  alt="" width="100" height="100"></i>
        <h1 class="h3 mb-3 font-weight-normal">Usuario</h1>
        <div class="row g-3">
        <div class="col"><br>
        <input type="mail" class="form-control" placeholder="email@email.com" name="email" required>
        </div>
        <div class="col"><br>
        <input type="password" class="form-control" placeholder="senha" name="senha" required>
        </div>
        </div>
        <br>    <button class="btn btn-lg btn-warning btn-block" name="login"type="submit">Sign in</button>
    </form>

</section>
</div>
</div>
</div>
</section>
</body>
</html>
<?php

if (isset($_POST['login'])) {

  $email=$_POST['email'];
  $senha=$_POST['senha'];

  $sqlLogin="SELECT id_usuario, sn_usuario, email_usuario from trabalhopi.tb_usuario where email_usuario='$email' and sn_usuario='$senha';";
  $result=pg_query($conexao, $sqlLogin);
  $cont=pg_num_rows($result);
  
  if ($cont==0) {
    echo "<script>
            alert('Infelizmente este usuario não foi encontrado :( tente novamente )');
            window.location.href='login.php';
          </script>";
  }else {
    $_SESSION['']= true;
    
    $exec=pg_query($conexao,$sqlLogin);
    while ($dados=pg_fetch_array($exec)){
      $_SESSION['usuario']= $dados['id_usuario'];
    }
    echo "<script>
            alert('Login efetuado com secesso!');
            window.location.href='paginaInicial.php';
          </script>";
  }
}
 ?>