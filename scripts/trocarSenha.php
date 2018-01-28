<?php
session_start();
require_once 'conexao.php';
//include 'confirmaLogado.php';
include ('Net/SSH2.php');

$id = $_POST['id'];
$usuario = $_POST['usuario'];
$senha = $_POST['ds_senha'];

                
                
                $ssh = new Net_SSH2($_SESSION['IP'], $_SESSION['port']);
                if (!$ssh->login($_SESSION['user'], $_SESSION['passwd'])) {
                    exit('Não Logado');
                }

    $ssh->exec("htpasswd -b /squid/etc/regras/squid_passwd $usuario $senha");

    #RECONFiGUrA SQuID
    $ssh->exec("/squid/sbin/squid -k reconfigure");

header('location:../home.php');

?>