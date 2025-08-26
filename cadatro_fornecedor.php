<?php
    session_start();

    require_once 'conexao.php';

    // VERIFICA SE O fornecedor TEM PERMISSÃO
    // SUPONDO QUE O PERFIL '1' SEJA O 'ADM'
    if($_SESSION['perfil'] != 1){
        echo "Acesso negado!";
        exit();
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $id_fornecedor = $_POST['id_fornecedor'];
        $nome = $_POST['nome'];
        $endereco = $_POST['endereco'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $nome_contato = $_POST['nome_contato'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $id_perfil = $_POST['id_perfil'];
        
        $query = "INSERT INTO fornecedor (nome, endereco, telefone, email, nome_contato, senha, id_perfil) VALUES (:nome, :endereco, :telefone, :email, :nome_contato, :senha, :id_perfil)";

        $stmt = $pdo -> prepare($query);

        $stmt -> bindParam(":nome", $nome);
        $stmt -> bindParam(":endereco", $endereco);
        $stmt -> bindParam(":telefone", $telefone);
        $stmt -> bindParam(":email", $email);
        $stmt -> bindParam(":nome_contato", $nome_contato);
        $stmt -> bindParam(":id_perfil", $id_perfil);
        $stmt -> bindParam(":id", $id_fornecedor);

        if ($stmt -> execute()) {
            echo "<script> alert('fornecedor cadastrado com sucesso!'); </script>";
        } else {
            echo "<script> alert('Erro ao cadastrar o fornecedor!'); </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro fornecedor</title>

    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
</head>
<body>
    <?php include 'menu.php'?>
    <h2>Cadastro fornecedor</h2>

    <form action="cadastro_fornecedor.php" method="POST">
        <label for="nome">Nome:</label>
            <input type="text" id="name" name="nome" required>

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" required>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="nome_contato">Nome de Contato:</label>
            <input type="text" id="name_contato" name="nome_contato" required>

        <label for="id_perfil">Perfil:</label>
        <select name="id_perfil" id="id_perfil">
            <option value="1">Administrador</option>
            <option value="2">Secretária</option>
            <option value="3">Almoxarife</option>
            <option value="4">Cliente</option>
        </select>

        <button type="submit">Cadastrar</button>
        <button type="reset">Cancelar</button>
    </form>

    <a href="principal.php">Voltar</a>
</body>
</html>