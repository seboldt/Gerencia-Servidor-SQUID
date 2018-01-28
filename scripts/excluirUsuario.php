<?php
session_start();   
require_once 'conexao.php';
//include 'confirmaLogado.php';
include ('Net/SSH2.php');


$id_usuario = $_GET['id'];
$usuario = $_GET['usuario'];
$id_perf = $_GET['id_perfil'];

$queryPerfil = "SELECT * FROM perfil where id=$id_perf";
$resultado = mysqli_query($conecta, $queryPerfil);
$rowPerfil = mysqli_fetch_array($resultado);
        
 $dsPerfil = $rowPerfil['ds_perfil'];
 
 $ssh = new Net_SSH2($_SESSION['IP'], $_SESSION['port']);
    if (!$ssh->login($_SESSION['user'], $_SESSION['passwd'])) {
        exit('Não Logado');
    }

$ssh->exec("htpasswd -D /squid/etc/regras/squid_passwd $usuario");
$ssh->exec("sed -i /$usuario/d /squid/etc/regras/usr_$dsPerfil");
$ssh->exec('/squid/sbin/squid -k reconfigure');

echo $usuario."teste";

$sql = "delete from user_perfil where id_usuario= $id_usuario";

mysqli_query($conecta, $sql);

header('location:../perfil.php?id='.$id_perf.'');

?>