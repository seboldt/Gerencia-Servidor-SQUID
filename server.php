<?php
    session_start();
    require_once 'scripts/conexao.php';
    include 'scripts/confirmaLogado.php';
    include ('Net/SSH2.php');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <title>Logado</title>
    </head>
    <body class="row blue-grey lighten-5">

        <div class="col s12 teal lighten-2">           
            
            <p class="flow-text">Bem vindo <?php echo $_SESSION['login'];?></p>
            <a class="waves-effect waves-light btn" href="scripts/deslogar.php">Sair</a>   <br /> <br />         
        </div>        
        <div class="col s3 teal lighten-4">        
         <?php 

                $querySelect = "SELECT * FROM tb_servidores";
                $resultado = mysqli_query($conecta, $querySelect);
            ?>
             <table class="striped Heading h6">
                        <thead>
                            <tr>
                                <th>Servidor</th>
                                <th></th>
                                <th><a class="waves-effect waves-light btn" href="registrarServidor.php"> <i class="material-icons">add</i></a></th>
                            </tr>	
                        </thead>
                        <tbody>              
            <?php
                while ($row = mysqli_fetch_array($resultado)){
                    echo "<tr>";
                    echo "<td><b><a class='teal-text' href='server.php?id=".$row['id']."'  >".$row['ds_nome']."</a></b></td><td><a class='teal-text' href='alterarServidor.php?id=".$row['id']."'><i class='material-icons'>edit</i></a></td><td><a class='teal-text' href='scripts/excluirServidor.php?id=".$row['id']."'><i class='material-icons'>delete</i></a></td><br />";
                    echo "</tr>";
                }

            ?> 
                             </tbody>
                    </table>
                <br />
        </div>
        <div class="col s9">
            <?php 

                $id = $_GET['id'];
                $querySelect = "SELECT * FROM tb_servidores where id=$id";
                $resultado = mysqli_query($conecta, $querySelect);
          
                $row = mysqli_fetch_array($resultado);
                
                echo "<br />";
                echo " <p class='flow-text'>".$row['ds_nome']."</p>";
                
                $_SESSION['nomeServidor'] = $row['ds_nome'];
                $_SESSION['IP'] = $row['IP'];
                $_SESSION['port'] = $row['porta'];
                $_SESSION['user'] = $row['user'];
                $_SESSION['passwd'] = $row['senha'];
               
                
                $ssh = new Net_SSH2($_SESSION['IP'], $_SESSION['port']);
                if (!$ssh->login($_SESSION['user'], $_SESSION['passwd'])) {
                    exit(" <p class='flow-text'>".$row['IP']." não está respondendo.</p>");
                }
                
                echo "<table class='striped Heading h6'>";
                echo "  <thead>";
                echo "      <tr>";
                echo "          <th>Perfil</th>";
                echo "          <th></th>";
                echo "          <th><a class='waves-effect waves-light btn' href='cadastrarPerfil.php?id=".$row['id']."'> <i class='material-icons'>add</i></a></th>";
                echo "       </tr>";
                echo "   </thead>";
                echo "   <tbody>";
                
                #PERFIL

                $queryPerfil = "SELECT * FROM perfil where id_servidor=$id order by ds_perfil";

                $resultado = mysqli_query($conecta, $queryPerfil);

                while ($rowPerfil = mysqli_fetch_array($resultado)) {
                    echo "       <tr>";
                    echo "<td>".$rowPerfil['ds_perfil']."</td><td><a class='teal-text' href='perfil.php?id=".$rowPerfil['id']."&nome=".$rowPerfil['ds_perfil']."&tipo=".$rowPerfil['tp_perfil']."'><i class='material-icons'>edit</i></a></td><td><a class='teal-text' href='scripts/excluirPerfil.php?id=".$rowPerfil['id']."'><i class='material-icons'>delete</i></a></td>";
                    echo "        </tr>";
                }            
                echo "    </tbody>";
                echo "</table>";
            ?>
        </div>

    </body>
</html>
