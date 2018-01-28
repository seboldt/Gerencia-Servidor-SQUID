<?php
    require_once 'conexao.php';
    include 'mostrarErros.php';
    
    $user = $_POST['user'];
    $senha = $_POST['senha'];
    $redirect = "home.php";
    
    
    $sql = "select * from user where user = '$user' and password = '$senha'";
    $result = mysqli_query($conecta, $sql);
    
    if(mysqli_num_rows($result) > 0){
        session_start();
        
        $_SESSION['login'] = $user;
        $_SESSION['senha'] = $senha;
        header('location:../home.php');
    }
    
    else{
        session_destroy();
        unset($_SESSION['login']);
        unset($_SESSION['senha']);
        echo"<script language='javascript' type='text/javascript'>alert('Confirme usuário e senha!');window.location.href='../index.php'</script>";
    }
    
    mysqli_free_result($result);
    mysqli_close($conecta);
    
    
    mysqli_close();
?>