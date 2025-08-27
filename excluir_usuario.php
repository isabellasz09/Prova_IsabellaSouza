<?php
    session_start();

    require_once 'conexao.php';

    // VERIFICA SE O USUARIO TEM PERMISSAO DE adm
    if($_SESSION['perfil'] != 1) {
        echo "<script> alert('Acesso Negado!'); window.location.href='index.php'; </script>";
        exit();
    }

    // INCIALIZA AS VARIAVEIS
    $usuarios = null;

    // BUSCA TODOS OS USUARIOS CADASTRADOS EM ORDEM ALFABETICA
    $query = "SELECT * FROM usuario ORDER BY nome ASC";
    
    $stmt = $pdo -> prepare($query);
    $stmt -> execute();
    $usuarios = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    // SE UM id FOR PASSADO VIA GET, EXCLUI O usuario
    if(isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id_usuario = $_GET['id'];

        // EXCLUI O USUARIO DO BANCO DE DADOS
        $query = "DELETE FROM usuario WHERE id_usuario = :id";

        $stmt = $pdo -> prepare($query);
        $stmt -> bindParam(":id", $id_usuario, PDO::PARAM_INT);
        
        if($stmt -> execute()) {
            echo "<script> alert('Usuário excluido com sucesso!'); window.location.href='buscar_usuario.php'; </script>";
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="scripts.js"></script>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>
    <?php include 'menu.php';?>
    <br>
    <h2>Excluir Usuário</h2>
    <br>
    <br>   
    <?php if(!empty($usuarios)): ?>
        <table border "1" class="table">
        <thead>   
        <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Perfil</th>
                <th scope="col">Ações</th>
            </tr>
            </thead>
            
            <?php foreach($usuarios as $usuario): ?>
                <tr>
                    <td> <?= htmlspecialchars($usuario['id_usuario']); ?></td>
                    <td> <?= htmlspecialchars($usuario['nome']); ?></td>
                    <td> <?= htmlspecialchars($usuario['email']); ?></td>
                    <td> <?= htmlspecialchars($usuario['id_perfil']); ?></td>
                    <td> 
                        <a href="excluir_usuario.php?id=<?= htmlspecialchars($usuario['id_usuario']) ?>" onclick="return confirm('Você tem certea que deseja excluí-lo?')">Excluir</a>
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