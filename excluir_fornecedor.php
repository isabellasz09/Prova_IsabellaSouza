<?php
    session_start();

    require_once 'conexao.php';

    // VERIFICA SE O fornecedor TEM PERMISSAO DE adm
    if($_SESSION['perfil'] != 1) {
        echo "<script> alert('Acesso Negado!'); window.location.href='index.php'; </script>";
        exit();
    }

    // INCIALIZA AS VARIAVEIS
    $fornecedor = null;

    // BUSCA TODOS OS fornecedor CADASTRADOS EM ORDEM ALFABETICA
    $query = "SELECT * FROM fornecedor ORDER BY nome_fornecedor ASC";
    
    $stmt = $pdo -> prepare($query);
    $stmt -> execute();
    $fornecedores = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    // SE UM id FOR PASSADO VIA GET, EXCLUI O fornecedor
    if(isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id_fornecedor = $_GET['id'];

        // EXCLUI O fornecedor DO BANCO DE DADOS
        $query = "DELETE FROM fornecedor WHERE id_fornecedor = :id";

        $stmt = $pdo -> prepare($query);
        $stmt -> bindParam(":id", $id_fornecedor, PDO::PARAM_INT);
        
        if($stmt -> execute()) {
            echo "<script> alert('Usuário excluido com sucesso!'); window.location.href='buscar_fornecedor.php'; </script>";
        } else {
            echo "<script> alert('Erro ao excluir usuário!'); </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Usuário</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="scripts.js"></script>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>
    <?php include 'menu.php';?>
    <br>
    <h2>Excluir Usuário</h2>
    <br>
    <br>   
    <?php if(!empty($fornecedores)): ?>
        <table border "1" class="table">
        <thead>   
        <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Endereço</th>
                <th scope="col">Telefone</th>
                <th scope="col">Email</th>
                <th scope="col">Nome Contato</th>
                <th scope="col">Ações</th>
            </tr>
            </thead>
            
            <?php foreach($fornecedores as $fornecedor): ?>
                <tr>
                <td><?=htmlspecialchars($fornecedor['id_fornecedor'])?></td>
                    <td><?=htmlspecialchars($fornecedor['nome_fornecedor'])?></td>
                    <td><?=htmlspecialchars($fornecedor['endereco'])?></td>
                    <td><?=htmlspecialchars($fornecedor['telefone'])?></td>
                    <td><?=htmlspecialchars($fornecedor['email'])?></td>
                    <td><?=htmlspecialchars($fornecedor['contato'])?></td>
                    <td> 
                        <a href="excluir_fornecedor.php?id=<?= htmlspecialchars($fornecedor['id_fornecedor']) ?>" onclick="return confirm('Você tem certea que deseja excluí-lo?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum consagrado encontrado!</p>
    <?php endif; ?>

    <a href="index.php">Voltar</a>
</body>
</html>