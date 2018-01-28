<?php
session_start();
require_once 'conexao.php';
//include 'confirmaLogado.php';
include ('Net/SSH2.php');

$id = $_GET['id'];

$ssh = new Net_SSH2($_SESSION['IP'], $_SESSION['port']);
    if (!$ssh->login($_SESSION['user'], $_SESSION['passwd'])) {
        exit('Não Logado');
}

$queryPerfil = "SELECT * FROM perfil where id=$id";

$resultado = mysqli_query($conecta, $queryPerfil);

$rowPerfil = mysqli_fetch_array($resultado);
$perfil = $rowPerfil['ds_perfil'];
$tipo = $rowPerfil['tp_perfil'];
        
if($tipo == 1){
    $ssh->exec("rm -rf /squid/etc/regras/usr_$perfil");
    $ssh->exec("rm -rf /squid/etc/regras/url_$perfil");
    
    ##PERFIL.CONF
    $ssh->exec("sed -i /'acl usr_$perfil '/d /squid/etc/perfilBloqueados.conf");
    $ssh->exec("sed -i /'acl url_$perfil '/d /squid/etc/perfilBloqueados.conf");
    
    ##ACCESS.CONF
    $ssh->exec("sed -i /'http_access deny usr_$perfil url_$perfil'/d /squid/etc/accessBloqueados.conf");
    $ssh->exec("sed -i /'http_access allow usuarios usr_$perfil'/d /squid/etc/accessUsuarios.conf");
    
}
elseif($tipo == 2){
    $ssh->exec("rm -rf /squid/etc/regras/usr_$perfil");
    $ssh->exec("rm -rf /squid/etc/regras/url_$perfil");
    
    ##PERFIL.CONF
    $ssh->exec("sed -i /'acl usr_$perfil '/d /squid/etc/perfilLiberados.conf");
    $ssh->exec("sed -i /'acl url_$perfil '/d /squid/etc/perfilLiberados.conf");
    
    ##ACCESS.CONF
    $ssh->exec("sed -i /'http_access deny usr_$perfil !url_$perfil'/d /squid/etc/accessLiberados.conf");
    $ssh->exec("sed -i /'http_access allow usuarios usr_$perfil'/d /squid/etc/accessUsuarios.conf");
}
elseif($tipo == 3){
    $ssh->exec("rm -rf /squid/etc/regras/usr_$perfil");
    
    ##PERFIL.CONF
    $ssh->exec("sed -i /'acl usr_$perfil '/d /squid/etc/perfilLivre.conf");
    
    ##ACCESS.CONF
    $ssh->exec("sed -i /'http_access allow usr_$perfil'/d /squid/etc/accessLivre.conf");
    $ssh->exec("sed -i /'http_access allow usuarios usr_$perfil'/d /squid/etc/accessUsuarios.conf");
}




$ssh->exec('/squid/sbin/squid -k reconfigure');




$sql = "delete from perfil where id = $id";

mysqli_query($conecta, $sql);

$redirect = '../home.php';
header("location:$redirect");

?>