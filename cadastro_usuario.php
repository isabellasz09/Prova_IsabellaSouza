<?php
session_start();
require 'conexao.php';

//GARANTE QUE O USUARIO ESTEJA LOGADO 
if($_SESSION['perfil']!=1){
    echo "Acesso negado";
    exit();
}
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'],PASSWORD_DEFAULT);
    $id_perfil = $_POST['id_perfil'];

    $sql = "INSERT INTO usuario(nome, email, senha, id_perfil) VALUES(:nome, :email, :senha, :id_perfil)";
    $stmtPerfil ->bindParam(':nome',$nome);
    $stmtPerfil ->bindParam(':email',$email);
    $stmtPerfil ->bindParam(':senha',$senha);
    $stmtPerfil ->bindParam(':id_perfil',$id_perfil);
  
    if($stmt->execute()){

    };
}
