<?php
    session_start();
    require_once 'scripts/conexao.php';
    include 'scripts/confirmaLogado.php';
    $id = $_GET['id'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <title>Perfil</title>
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
            echo " <p class='flow-text'>".$_SESSION['nomeServidor']."</p>";  
            //echo " <p class='Heading h2'>Perfil: ".$_GET['nome']."</p>";  
            
            $_SESSION['perfilN'] = $_GET['nome'];
            
            $tp = $_GET['tipo'];
         
            if($tp == 1){ 
                $tp_perfil = "Bloqueados";              
            }
            elseif($tp == 2){
                $tp_perfil = "Liberados";            
            }
            elseif($tp == 3){
                $tp_perfil = "sem controle de acesso.";
            }                                  
            
            
           
         ?>
             
        <div class="row">     
            <form action="scripts/cadastrarSite.php" method="POST" class="col s12">
                <div class="row">
                    <div class="input-field col s6">
                        <input type="text" placeholder="site.com.br" name="site" class="validate">
                        <label for="site">Informe o Site:</label>
                    </div>
                </div>
                        <?php echo "<input type='hidden' name='id_perfil' value='".$id."'' />" ?>
                        <input class="waves-light btn" type="submit" name="Cadastrar" value="Cadastrar" />
            </form>
        </div>
         <?php
            
                

                $querySites = "SELECT * FROM sites where id_perfil=$id ORDER BY site";

                $resultado = mysqli_query($conecta, $querySites);
                ?>
                <table class="striped Heading h6">
                    <thead>
                        <tr>
                            <th>Sites <?php echo $tp_perfil ?></th>
                            <th></th>                                
                        </tr>	
                    </thead>
                    <tbody>                           
                <?php
                while ($rowSites = mysqli_fetch_array($resultado)) {
                    echo "<tr>";
                    echo "<td>".$rowSites['site']."</td>";
                    echo "<td><a class='teal-text' href='scripts/excluirSite.php?id=".$rowSites['id']."&id_perfil=".$rowSites['id_perfil']."&site=".$rowSites['site']."'><i class='material-icons'>delete</i></a></td>";
                    echo "</tr>";
                }                    
            ?>   
                    </tbody>
                </table>
        </div>
    </body>
</html>
