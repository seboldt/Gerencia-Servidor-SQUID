<?php
session_start();
require_once 'conexao.php';
//include 'confirmaLogado.php';

$nome = $_POST['nome'];
$user = $_POST['user'];
$senhaServidor = $_POST['senha'];
$ip = $_POST['ip'];
$porta = $_POST['porta'];


$sql = "select * from tb_servidores where IP = '$ip'";

$result = mysqli_query($conecta, $sql);

 if(mysqli_num_rows($result) == 0){

 
        $query = "INSERT INTO tb_servidores(ds_nome, user, senha, IP, porta) VALUES('$nome', '$user', '$senhaServidor', '$ip', $porta);";
        $insert = mysqli_query($conecta, $query);

        if($insert){
            echo"<script language='javascript' type='text/javascript'>alert('Servidor cadastrado com sucesso!');window.location.href='../home.php'</script>";
        }
        else{
            echo"<script language='javascript' type='text/javascript'>alert('Não foi possível cadastrar servidor');window.location.href='../home.php'</script>";
        }
    }
    
    else {
     echo"<script language='javascript' type='text/javascript'>alert('Servidor já cadastrado');window.location.href='../home.php'</script>";
    }

?>