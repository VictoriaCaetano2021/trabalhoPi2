<?php 
include 'conexao.php'; ?>
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
  <title>Fórum Inside</title><!-- procurar como adicionar icone no titulo da pagina-->
</head>
<body style="background-color:#DBB522;">

  <nav class="navbar navbar-expand-lg navbar-light bg-dark ">
    <div class="container-fluid ">
      <a class="navbar-brand text-white" href="#">INSIDE.</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-white">
          <li class="nav-item">
            <a class="nav-link active text-white" aria-current="page" href="login.php">login</a>
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
    <h3 class="text-white">
      O <strong>melhor</strong> forum oline do Brasil.
    </h3><br><br>
    <a href="criarUsuario.php"><button class="btn btn-outline-warning" type="submit">Criar Usuario</button></a> <br>
    <br>
    </h3><br>
    </div>
</section>
<br><br>
<section>

<div class="row featurette">
  <div class="col-md-7">
    <h2 class="featurette-heading text-end">O primeiro forúm do Brasil<span class="text-muted text-end">Participe agora</span></h2>
    <p class="lead text-end">um texto bem legar sobre como a comunicação atraves de foruns é divertida</p>
  </div>
  <div class="col-md-5">
    <img src="trofeu.png" >
  </div>
</div>  
</section>
</body>
</html>