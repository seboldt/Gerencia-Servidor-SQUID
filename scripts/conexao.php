<?php 

$conecta = mysqli_connect('127.0.0.1', 'root', 'qwe123', 'tcc', '3306');

if(!$conecta){
    print 'Não foi possivel conectar ao banco de dados.';
}
?>