<?php
    session_start();
    require_once 'conexao.php';


    // VERIFICA SE O fornecedor TEM PERMISSÃO
    if($_SESSION['perfil'] != 1){
        echo "<script>alert('Acesso Negado'); window.location.href='index.php';</script>";        
        exit();
    }
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $id_fornecedor = $_POST['id_fornecedor'];
        $nome_fornecedor = $_POST['nome_fornecedor'];
        $endereco = $_POST['endereco'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $contato = $_POST['contato'];
    }
    // ATUALIZA OS DADOS DO fornecedor
    
    $sql = "UPDATE fornecedor SET nome_fornecedor = :nome_fornecedor, endereco = :endereco, telefone = :telefone, email = :email, contato = :contato where id_fornecedor = :id";
    $stmt = $pdo -> prepare($sql);

    $stmt -> bindParam(":nome_fornecedor", $nome_fornecedor);
    $stmt -> bindParam(":endereco", $endereco);
    $stmt -> bindParam(":telefone", $telefone);
    $stmt -> bindParam(":email", $email);
    $stmt -> bindParam(":contato", $contato);
    $stmt -> bindParam(":id", $id_fornecedor);


    if ($stmt -> execute()) {
        echo "<script> alert('Fornecedor Atualizado com Sucesso.');window.location.href='buscar_fornecedor.php'; </script>";
    } else {
        echo "<script> alert('Erro ao Atualizar fornecedor'); window.location.href='alterar_fornecedor.php'; </script>";
    }
?>