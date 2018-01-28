<?php
session_start();
require_once 'conexao.php';
//include 'confirmaLogado.php';

$id_servidor = $_POST['id'];
$nome = $_POST['nome'];
$user = $_POST['user'];
$senhaServidor = $_POST['senha'];
$ip = $_POST['ip'];
$porta = $_POST['porta'];
        
    echo $id_servidor;
    
        //$query = "update tb_servidores set ds_nome='$nome' where id=$id;";
        $query = "UPDATE tb_servidores SET ds_nome='$nome', IP='$ip', porta=$porta, user='$user', senha='$senhaServidor' WHERE id=$id_servidor;";
        $insert = mysqli_query($conecta, $query);

        if($insert){
            echo"<script language='javascript' type='text/javascript'>alert('Servidor alterado com sucesso!');window.location.href='../home.php'</script>";
        }
        else{
            echo"<script language='javascript' type='text/javascript'>alert('Não foi possível cadastrar servidor');window.location.href='../home.php'</script>";
        }
?>