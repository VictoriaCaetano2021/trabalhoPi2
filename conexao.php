
<?php

$servidor = "200.19.1.18";
$usuario = "victoriacaetano";
$senha ="123";
$port="5432";
$conexao = pg_connect("host=$servidor port=$port dbname=$usuario  user=$usuario password=$senha") or 
die ("Não foi possível conectar ao servidor PostGreSQL");

// $servidor = "192.168.20.18";
// $usuario = "victoriacaetano";
// $senha ="123";
// $port="5432";
// $conexao = pg_connect("host=$servidor port=$port dbname=$usuario  user=$usuario password=$senha") or 
// die ("Não foi possível conectar ao servidor PostGreSQL");

?>