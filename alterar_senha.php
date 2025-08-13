<?php
session_start();
require 'conexao.php';

//GARANTE QUE O USUARIO ESTEJA LOGADO 
if(!isset($_SESSION['id_usuario'])){
    echo "<script>alert('Acesso Negado);
        window.location.href='login.php';</script>";
}
?>