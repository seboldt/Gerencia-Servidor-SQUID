<?php
session_start();
require_once 'conexao.php';
//include 'confirmaLogado.php';
include ('Net/SSH2.php');

$id = $_POST['perfil'];
$usuario = $_POST['ds_user'];
$senha = $_POST['ds_senha'];

                
                $querySelect = "SELECT * FROM perfil where id=$id";
                $resultado = mysqli_query($conecta, $querySelect);
          
                $row = mysqli_fetch_array($resultado);
                
                $usrPerfil = $row['ds_perfil'];
                
                $ssh = new Net_SSH2($_SESSION['IP'], $_SESSION['port']);
                if (!$ssh->login($_SESSION['user'], $_SESSION['passwd'])) {
                    exit('Não Logado');
                }


    $ssh->exec("htpasswd -b /squid/etc/regras/squid_passwd $usuario $senha");
    $ssh->exec("echo '$usuario' >> /squid/etc/regras/usr_$usrPerfil"); 

    #RECONFiGUrA SQuID
    $ssh->exec("/squid/sbin/squid -k reconfigure");

$query = "INSERT INTO user_perfil(ds_usuario, id_perfil) VALUES('$usuario', $id);";
$insert = mysqli_query($conecta, $query);

header('location:../listarUsuarios.php?id='.$id);

?>