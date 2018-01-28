<?php
session_start();
require_once 'conexao.php';
//include 'confirmaLogado.php';
include ('Net/SSH2.php');

$perfil = $_POST['ds_perfil'];
$tipo = $_POST['tipo'];
$servidor = $_POST['servidor'];

                $id = $_GET['id'];
                $querySelect = "SELECT * FROM tb_servidores where id=$id";
                $resultado = mysqli_query($conecta, $querySelect);
          
                $row = mysqli_fetch_array($resultado);
                echo "<br />";
                echo $row['IP'];
                echo "<br />";
                
                $ssh = new Net_SSH2($_SESSION['IP'], $_SESSION['port']);
                if (!$ssh->login($_SESSION['user'], $_SESSION['passwd'])) {
                    exit('Não Logado');
                }
echo "Criando Perfil $perfil - Tipo: $tipo"; 
#ACESSA TUDO EXETO OQ ESTA BLOQUEADO
if($tipo == 1){
    
    #PERFIL USUARIO 
    $ssh->exec("touch /squid/etc/regras/usr_$perfil");
    $ssh->exec("touch /squid/etc/regras/url_$perfil"); 
    $ssh->exec("echo 'acl usr_$perfil proxy_auth \"/squid/etc/regras/usr_$perfil\"' >> /squid/etc/perfilBloqueados.conf");
    $ssh->exec("echo 'acl url_$perfil url_regex -i \"/squid/etc/regras/url_$perfil\"' >> /squid/etc/perfilBloqueados.conf");
    $ssh->exec("####");
    $ssh->exec("####");
    
    #ACCESS.CONF
    $ssh->exec("echo 'http_access deny usr_$perfil url_$perfil' >> /squid/etc/accessBloqueados.conf");
    $ssh->exec("echo 'http_access allow usuarios usr_$perfil' >> /squid/etc/accessUsuarios.conf");
    
}
#ACESSA APENAS SITES QUE ESTAO NO ARQUIVO COMO LIBERADOS
elseif($tipo == 2){
  #PERFIL USUARIO
    $ssh->exec("touch /squid/etc/regras/usr_$perfil");
    $ssh->exec("touch /squid/etc/regras/url_$perfil"); 
    $ssh->exec("echo 'acl usr_$perfil proxy_auth \"/squid/etc/regras/usr_$perfil\"' >> /squid/etc/perfilLiberados.conf");
    $ssh->exec("echo 'acl url_$perfil url_regex -i \"/squid/etc/regras/url_$perfil\"' >> /squid/etc/perfilLiberados.conf");
    $ssh->exec("####");
    $ssh->exec("####");
    
  #ACCESS.CONF
    $ssh->exec("echo 'http_access deny usr_$perfil !url_$perfil' >> /squid/etc/accessLiberados.conf");
    $ssh->exec("echo 'http_access allow usuarios usr_$perfil' >> /squid/etc/accessUsuarios.conf");
}
#ACESSO FULL
elseif($tipo == 3){
    #PERFIL USUARIO
    $ssh->exec("touch /squid/etc/regras/usr_$perfil");
    $ssh->exec("echo 'acl usr_$perfil proxy_auth \"/squid/etc/regras/usr_$perfil\"' >> /squid/etc/perfilLivre.conf");
    
    #ACCESS.CONF
    $ssh->exec("echo 'http_access allow usr_$perfil' >> /squid/etc/accessLivre.conf");
    $ssh->exec("echo 'http_access allow usuarios usr_$perfil' >> /squid/etc/accessUsuarios.conf");
    $ssh->exec("####");
}
    #RECONFiGUrA SQuID
    $ssh->exec("/squid/sbin/squid -k reconfigure");

$query = "INSERT INTO perfil(ds_perfil, tp_perfil, id_servidor) VALUES('$perfil', $tipo, $servidor);";
$insert = mysqli_query($conecta, $query);

header('location:../server.php?id='.$servidor.'');

?>