<?php
    session_start();

    require_once 'conexao.php';

    // VERIFICA SE O fornecedor TEM PERMISSÃO
    // SUPONDO QUE O PERFIL '1' SEJA O 'ADM'
    if($_SESSION['perfil'] != 1){
        echo "Acesso negado!";
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nome_fornecedor = $_POST['nome_fornecedor'];
        $endereco = $_POST['endereco'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $contato = $_POST['contato'];
        
        
        $query = "INSERT INTO fornecedor (nome_fornecedor, endereco, telefone, email, contato) VALUES (:nome_fornecedor, :endereco, :telefone, :email, :contato)";

        $stmt = $pdo -> prepare($query);

        $stmt -> bindParam(":nome_fornecedor", $nome_fornecedor);
        $stmt -> bindParam(":endereco", $endereco);
        $stmt -> bindParam(":telefone", $telefone);
        $stmt -> bindParam(":email", $email);
        $stmt -> bindParam(":contato", $nome_contato);
        

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
    <?php include 'menu.php';?>
    <h2>Cadastro fornecedor</h2>

    <form action="cadastro_fornecedor.php" method="POST">
        <label for="nome_fornecedor">Nome:</label>
            <input type="text" id="nome_fornecedor" name="nome_fornecedor" required>

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" required>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="contato">Nome de Contato:</label>
            <input type="text" id="contato" name="contato" required>


        <button type="submit">Cadastrar</button>
        <button type="reset">Cancelar</button>
    </form>

    <a href="principal.php">Voltar</a>
</body>
</html>