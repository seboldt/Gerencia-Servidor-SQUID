<?php
session_start();   
require_once 'conexao.php';
//include 'confirmaLogado.php';
include ('Net/SSH2.php');

$id = $_GET['id'];
$id_perfil = $_GET['id_perfil'];
$site = $_GET['site'];

$queryPerfil = "SELECT * FROM perfil where id=$id_perfil";
$resultado = mysqli_query($conecta, $queryPerfil);
$rowPerfil = mysqli_fetch_array($resultado);
        
 $dsPerfil = $rowPerfil['ds_perfil'];
 
 $ssh = new Net_SSH2($_SESSION['IP'], $_SESSION['port']);
    if (!$ssh->login($_SESSION['user'], $_SESSION['passwd'])) {
        exit('Não Logado');
    }

$ssh->exec("sed -i /$site/d /squid/etc/regras/url_$dsPerfil");
$ssh->exec('/squid/sbin/squid -k reconfigure');



$sql = "delete from sites where id = $id";

mysqli_query($conecta, $sql);

header('location:../perfil.php?id='.$id_perfil.'');

?>