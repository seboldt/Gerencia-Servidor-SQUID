<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <title>Login</title>
    </head>
    <body class="row card-panel blue-grey lighten-5">
        <div class="col s3 card-panel teal lighten-1" style="position: absolute; left: 35%;top: 20%;">
            <center><form action="scripts/confirmaSenha.php" method="POST">
               <br /> <input type="text" placeholder="Usuário" name="user" /><br />
                <input type="password" placeholder="Senha" name="senha" /><br />
                <input type="submit" class="btn waves-effect waves-teal" value="Entrar" />         
                </form><br /></center>
        </div>
    </body>
</html>