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
            <a class="nav-link active text-dark fw-bold" aria-current="page" href="suasPerguntas.php">Suas Perguntas</a>
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
        <br><br><h2 class="jumbotron-heading">Perguntas</h2><br><br>
      </div>
    </section>

    <?php
         $sqlDadosPergunta="SELECT usuario.nm_usuario, pergunta.id_pergunta, pergunta.id_usuario, pergunta.titulo_pergunta, pergunta.texto_pergunta, pergunta.data_pergunta 
         from trabalhopi.tb_pergunta pergunta, trabalhopi.tb_usuario usuario where
         pergunta.id_usuario=usuario.id_usuario 
         group by pergunta.id_pergunta, usuario.nm_usuario,  pergunta.id_usuario, pergunta.titulo_pergunta, pergunta.texto_pergunta, pergunta.data_pergunta
         order by pergunta.data_pergunta desc;
        ";

        $resultPergunta=pg_query($conexao, $sqlDadosPergunta);
        if($resultPergunta){

            while ($dados=pg_fetch_array($resultPergunta)){
                $id_pergunta=$dados['id_pergunta'];
                $nm_usuarioPergunta=$dados['nm_usuario'];
                $titulo_pergunta=$dados['titulo_pergunta']; 
                $texto_pergunta=$dados['texto_pergunta']; 
                $data_pergunta=$dados['data_pergunta'];

                $sqlDadosComentario=" SELECT usuario.nm_usuario, comentario.id_usuario, comentario.id_comentario, comentario.data_comentario,  comentario.texto_comentario
                                    from TRABALHOPI.tb_comentario comentario , TRABALHOPI.tb_usuario usuario
                                     where
                                        comentario.id_usuario=usuario.id_usuario AND
                                        comentario.id_pergunta='$id_pergunta'
                                        group by  comentario.id_usuario, comentario.id_comentario, usuario.nm_usuario,comentario.data_comentario,comentario.texto_comentario ;
                    
                    ";
                $resultComentario=pg_query($conexao, $sqlDadosComentario);

                echo "
                        <section class='jumbotron'>
                        <div class='card'>
                            <div class='card-header'>
                                <strong>".$titulo_pergunta."</strong>
                            </div>
                            <div class='card-body'>
                                <blockquote class='blockquote mb-0'>
                                    <p> ".$texto_pergunta."</p>
                                    <footer class='blockquote-footer'>".$nm_usuarioPergunta." | <cite title='Source Title'>".$data_pergunta."</cite></footer>
                                </blockquote>

                            <form action='paginaInicial.php' method='post'>
                                <div class='mb-3'>  
                                    <textarea class='form-control' id='exampleFormControlTextarea1' rows='3' name='textoComentarioAdicionar'></textarea>
                                </div>
                                <button class='btn btn-md btn-warning btn-block' name='comentar' type='submit' value =".$id_pergunta." >Comentar</button>
                            </form>

                                

                            </div>";
                    
                    while ($dadosComentario=pg_fetch_array($resultComentario)){
                        $nm_usuarioComentario=$dadosComentario['nm_usuario'];
                        $texto_comentario=$dadosComentario['texto_comentario']; 
                        $data_comentario=$dados['data_pergunta'];
                    
                        echo"
                        </div>
                            <div class='container bg-secondary'>
                                <li class='list-group-item '>
                                    <p '><strong>".$nm_usuarioComentario."</strong></p>
                                    <p>".$texto_comentario."</p>
                                    <footer class='blockquote-footer'><cite title='Source Title'>".$data_comentario."</cite></footer>
                                </li>
                            </div>
                        ";
                    }
                echo"   </div>
                    </section>
                ";

            }
        }
    ?>
</body>
</html>

<?php 
if(isset($_POST['comentar'])){
    $comentario= $_POST['textoComentarioAdicionar'];
    $pergunta= $_POST['comentar'];
    $usuario=$id_usuario;
    $data= date('d/m/Y');
    $data=explode("/",$data);
    $data=$data[0]."-".$data[1]."-".$data[2];

    $sqlExiste="SELECT comentario.id_comentario from trabalhopi.tb_comentario comentario where texto_comentario='$comentario' and data_comentario='$data';";
    $result=pg_query($conexao, $sqlExiste);
    $cont=pg_num_rows($result);

    if($cont==0){
        $insertComentario=" INSERT into trabalhopi.tb_comentario (id_usuario,id_pergunta,texto_comentario,data_comentario) 
            values ('$id_usuario','$pergunta','$comentario','$data');
        ";
        pg_query($conexao, $insertComentario);
    }
}
?>
