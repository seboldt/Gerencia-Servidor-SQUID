<?php
    if ( !isset($_SESSION['login']) and !isset($_SESSION['senha']) ) {
	
	session_destroy();

	//Limpa
	unset ($_SESSION['login']);
	unset ($_SESSION['senha']);
	
	 
	header('location:index.php');
}
?>