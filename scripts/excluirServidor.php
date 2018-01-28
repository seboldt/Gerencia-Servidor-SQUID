<?php
session_start();
require_once 'conexao.php';
//include 'confirmaLogado.php';

$id = $_GET['id'];

$sql = "delete from tb_servidores where id = $id";

mysqli_query($conecta, $sql);

 $redirect = '../home.php';
 header("location:$redirect");

?>