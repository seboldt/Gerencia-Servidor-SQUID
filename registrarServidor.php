<?php
    session_start();
    require_once 'scripts/conexao.php';
    include 'scripts/confirmaLogado.php';

?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <title>Registrar Servidor</title>
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
             <div class="row">
       <form action="scripts/cadastrarServidor.php" method="POST" class="col s12">
            <div class="row">
                <div class="input-field col s6">
                    <input type="text" name="nome" />
                    <label for="nome">Nome do Servidor</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input type="text" name="user" />
                    <label for="user">Usuário</label>
                </div>            
                <div class="input-field col s6">
                    <input type="password" name="senha" />
                     <label for="senha">Senha</label> 
                </div>
            </div>
           <div class="row">
                <div class="input-field col s6">
                    <input type="text" name="ip" />
                    <label for="ip">IP</label>
                </div>
                <div class="input-field col s6">
                    <input type="text" name="porta" />
                    <label for="porta">Porta</label>
                </div>
           </div>
            <input class="waves-light btn" type="submit" value="Cadastrar" />         
        </form>
             </div>
        </div>
    </body>
</html>
