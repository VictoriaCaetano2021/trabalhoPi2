<?php
include 'conexao.php';
session_start();

if (!isset($_SESSION['usuario'])) {
header("location:login.php");
session_destroy();
}

if (isset($_GET['sair'])) {
    header("location:index.php");
    session_destroy();
}

$id_usuario=$_SESSION['usuario'];

$sqlDadosUsuario="SELECT nm_usuario , email_usuario from trabalhopi.tb_usuario where id_usuario='$id_usuario';";
$result=pg_query($conexao, $sqlDadosUsuario);
while ($dados=pg_fetch_array($result)){
    $nm_usuario=$dados['nm_usuario'];
    $email_usuario=$dados['email_usuario'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem Vindo</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-warning ">
  <div class="container-fluid ">
    <a class="navbar-brand text-dark" href="#"><strong>INSIDE.</strong></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-white">
        <li class="nav-item">
            <a class="nav-link active text-dark fw-bold" aria-current="page" href="paginaInicial.php">Perguntas</a>
        </li>
          <li class="nav-item"> 
          <form class="d-flex">
        <button type="button" class="btn btn-warning" ><a class="text-decoration-none text-dark fw-bold"href="?sair">Sair</a></button>
        </form>
        </li>
      </ul>
      <?php 
        echo" 
            <h1 class='navbar-text'>
                Olá ".$nm_usuario." !
            </h1>
        ";
      ?>
    </div>
  </div>
</nav>
    <section class="jumbotron text-center bg-dark text-light">
      <div class="container">
        <br><br><h2 class="jumbotron-heading">Suas perguntas</h2><br><br>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCadastroPergunta">
            Criar nova pergunta
        </button><br><br>
        <button type='button' class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#modalEditaPergunta'>
            Ediar uma pergunta<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-edit-3'><path d='M12 20h9'></path><path d='M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z'></path></svg>
        </button>
        <br><br>
      </div>
    </section>

    <?php
         $sqlDadosPergunta="SELECT usuario.nm_usuario, pergunta.id_pergunta, pergunta.id_usuario, pergunta.titulo_pergunta, pergunta.texto_pergunta, pergunta.data_pergunta 
                             from trabalhopi.tb_pergunta pergunta, trabalhopi.tb_usuario usuario 
                             where pergunta.id_usuario='$id_usuario' and 
                             pergunta.id_usuario=usuario.id_usuario order by pergunta.data_pergunta desc;
        ";

        $resultPergunta=pg_query($conexao, $sqlDadosPergunta);
        $cont=pg_num_rows($resultPergunta);
        if($cont){

            while ($dados=pg_fetch_array($resultPergunta)){
                $id_pergunta=$dados['id_pergunta'];
                $nm_usuarioPergunta=$dados['nm_usuario'];
                $titulo_pergunta=$dados['titulo_pergunta']; 
                $texto_pergunta=$dados['texto_pergunta']; 
                $data_pergunta=$dados['data_pergunta'];

                $sqlDadosComentario=" SELECT usuario.nm_usuario, comentario.texto_comentario, data_comentario 
                                            from trabalhopi.tb_comentario comentario, trabalhopi.tb_usuario usuario
                                            where comentario.id_usuario=usuario.id_usuario and
                                            comentario.id_pergunta= '$id_pergunta' order by comentario.data_comentario desc;                 
                    ";
                $resultComentario=pg_query($conexao, $sqlDadosComentario);

                echo "
                        <section class='jumbotron'>
                        <div class='card'>
                            <div class='card-header'>
                                <strong>".$titulo_pergunta." - id: ".$id_pergunta."</strong>
                            </div>
                            <div class='card-body'>
                                <blockquote class='blockquote mb-0'>
                                    <p> ".$texto_pergunta."</p>
                                    <footer class='blockquote-footer'>".$nm_usuarioPergunta." | <cite title='Source Title'>".$data_pergunta."</cite></footer>
                                </blockquote>
                            </div>
                            
                            
                            </div>
                          </div>

                            ";
                    
                    while ($dadosComentario=pg_fetch_array($resultComentario)){
                        $nm_usuarioComentario=$dadosComentario['nm_usuario'];
                        $texto_comentario=$dadosComentario['texto_comentario']; 
                        $data_comentario=$dados['data_pergunta'];
                    
                        echo"
                            <div class='container'>
                                    <div class='row'>
                                        <div class='col-12'>
                                            <p '><strong>".$nm_usuarioComentario."</strong></p>
                                            <p>".$texto_comentario."</p>
                                            <footer class='blockquote-footer'><cite title='Source Title'>".$data_comentario."</cite></footer>
                                        </div>
                                    </div>
                            </div>   
                        ";
                    }
                echo"   </div>
                    </section>
                ";

            }
        }else{
            echo"
            <section class='jumbotron text-center '>
              <div class='container'>
                <br><br><h2 class='jumbotron-heading'>Você não tem perguntas ainda :(</h2><br><br>
                <br><br>
              </div>
            </section>
            ";
        }
    ?>
<!-- Modal cadastro -->
<div class="modal fade" id="modalCadastroPergunta" tabindex="-1" aria-labelledby="modalCadastroPergunta" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCadastroPergunta">Criar pergunda</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">

        <form action="suasPerguntas.php" method="post">

            <label for="exampleFormControlLabel1" class="form-label">titulo</label>
            <input class="form-control" type="text" placeholder="Default input" aria-label="default input example" name="tituloPergunta">

            <label for="exampleFormControlTextarea1" class="form-label" >Pergunta</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="textoPergunta" rows="3"></textarea>  
            <button class="btn btn-md btn-warning btn-block" name="criaPergunta"type="submit">Cadastrar</button>
        </form>
        </div>
    </div>
  </div>
</div>

<!-- Modal alterar -->
<div class="modal fade" id="modalEditaPergunta" tabindex="-1" aria-labelledby="modalEditaPergunta" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditaPergunta">modalEditaPergunta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
           <form action="suasPerguntas.php" method="post">
                <div class="mb-3">
                    <p>selecione quais campos deseja alterar</p>
                    <input type="checkbox" name="checkexcluir" id=""><strong>Excluir pergunta</strong><br> 
                    <input type="checkbox" name="checktitulo" id="">titulo <br>
                    <input type="checkbox" name="checktexto" id="">texto <br> 
                    <label for="exampleFormControlLabel1" class="form-label">id da pergunta</label>
                    <input class="form-control" type="text" placeholder="Default input" aria-label="default input example" name="idPergunta">

                    <label for="exampleFormControlLabel1" class="form-label">titulo</label>

                    <input class="form-control" type="text" placeholder="Default input" aria-label="default input example" name="tituloPergunta">

                    <label for="exampleFormControlTextarea1" class="form-label">texto</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="textoPergunta"></textarea>
                </div>
                <button class="btn btn-md btn-warning btn-block" name="editaPergunta"type="submit">Editar</button>
           </form>
        </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>


        
</body>
</html>

<?php 

if(isset($_POST['editaPergunta'])){

    $titulo=$_POST['tituloPergunta'];
    $id=$_POST['idPergunta'];
    $texto=$_POST['textoPergunta'];  
    $data= date('d/m/Y');
   $data=explode("/",$data);
   $data=$data[0]."-".$data[1]."-".$data[2];
    

   if(isset($_POST['checktexto'])){

    $updatePergunta=" UPDATE trabalhopi.tb_pergunta set texto_pergunta='$texto' where id_pergunta='$id' and id_usuario='$id_usuario';
        ";
    pg_query($conexao,$updatePergunta);
   }

   if(isset($_POST['checktitulo'])){
    $updatePergunta=" UPDATE trabalhopi.tb_pergunta set titulo_pergunta='$titulo' where id_pergunta='$id' and id_usuario='$id_usuario';
        ";

    pg_query($conexao,$updatePergunta);

   }
   if(isset($_POST['checkexcluir'])){

    $updatePergunta=" DELETE FROM trabalhopi.tb_pergunta WHERE id_pergunta = '$id' and id_usuario='$id_usuario';
        ";
    pg_query($conexao,$updatePergunta);
   }
    
}

if(isset($_POST['criaPergunta'])){

  $titulo=$_POST['tituloPergunta'];
  $texto=$_POST['textoPergunta'];  
  $data= date('d/m/Y');
 $data=explode("/",$data);
 $data=$data[0]."-".$data[1]."-".$data[2];
  
    $sqlExiste="SELECT pergunta.id_pergunta from trabalhopi.tb_pergunta pergunta where titulo_pergunta='$titulo' and texto_pergunta='$texto' and data_pergunta='$data';";
    $result=pg_query($conexao, $sqlExiste);
    $cont=pg_num_rows($result);

    if($cont==0){
        $insertPergunta=" INSERT into trabalhopi.tb_pergunta (id_usuario,titulo_pergunta,texto_pergunta,data_pergunta) 
                    values ('$id_usuario','$titulo','$texto',
                            '$data');
                        ";
    pg_query($conexao, $insertPergunta);

    }
}
?>