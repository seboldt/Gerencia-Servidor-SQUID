<?php
session_start();
require_once 'conexao.php';
//include 'confirmaLogado.php';
include ('Net/SSH2.php');

$idPerfil = $_POST['id_perfil'];
$site = $_POST['site'];


        $ssh = new Net_SSH2($_SESSION['IP'], $_SESSION['port']);
        if (!$ssh->login($_SESSION['user'], $_SESSION['passwd'])) {
                exit('Não Logado');
        }
        
        
        $queryPerfil = "SELECT * FROM perfil where id=$idPerfil";
        $resultado = mysqli_query($conecta, $queryPerfil);
        $rowPerfil = mysqli_fetch_array($resultado);
        
        $dsPerfil = $rowPerfil['ds_perfil'];
        $ssh->exec('echo "'.$site.'" >> /squid/etc/regras/url_'.$dsPerfil.'');
        $ssh->exec('/squid/sbin/squid -k reconfigure');
        
        
$query = "INSERT INTO sites(id_perfil, site) VALUES($idPerfil, '$site');";
$insert = mysqli_query($conecta, $query);

header('location:../cadastrarSites.php?id='.$idPerfil.'');

?>