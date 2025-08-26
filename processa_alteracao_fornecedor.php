<?php
    session_start();
    require_once 'conexao.php';


    // VERIFICA SE O fornecedor TEM PERMISSÃO
    if($_SESSION['perfil'] != 1){
        echo "<script>alert('Acesso Negado'); window.location.href='principal.php';</script>";        
        exit();
    }
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $id_fornecedor = $_POST['id_fornecedor'];
        $nome = $_POST['nome'];
        $endereco = $_POST['endereco'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $nome_contato = $_POST['nome_contato'];
        $id_perfil = $_POST['id_perfil'];
        $nova_senha = !empty($_POST['nova_senha']) ? password_hash($_POST['nova_senha'], PASSWORD_DEFAULT) : null;
    }
    // ATUALIZA OS DADOS DO fornecedor
    if($nova_senha){
        $sql = "UPDATE fornecedor SET nome = :nome, endereco = :endereco, telefone = :telefone, email = :email, nome_contato = :nome_contato, id_perfil = :id_perfil, senha = :senha where id_fornecedor = :id";
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(":senha", $nova_senha);
    } else {
        $sql = "UPDATE fornecedor SET nome = :nome, endereco = :endereco, telefone = :telefone, email = :email, nome_contato = :nome_contato, id_perfil = :id_perfil where id_fornecedor = :id";
        $stmt = $pdo -> prepare($sql);
    }
    $stmt -> bindParam(":nome", $nome);
    $stmt -> bindParam(":endereco", $endereco);
    $stmt -> bindParam(":telefone", $telefone);
    $stmt -> bindParam(":email", $email);
    $stmt -> bindParam(":nome_contato", $nome_contato);
    $stmt -> bindParam(":id_perfil", $id_perfil);
    $stmt -> bindParam(":id", $id_fornecedor);


    if ($stmt -> execute()) {
        echo "<script> alert('fornecedor Atualizado com Sucesso.');window.location.href='buscar_fornecedor.php'; </script>";
    } else {
        echo "<script> alert('Erro ao Atualizar fornecedor'); window.location.href='alterar_fornecedor.php'; </script>";
    }
?>