<?php
session_start();
require_once 'conexao.php';

if($_SESSION['perfil']!=1 && $_SESSION['perfil']!=2){
    echo "<script> alert('Acesso negado!');window.location.href='index.php';</script>";
    exit();

}

//INICIALIZA A VARIAVEL PARA EVITAR ERROS
$usuarios = [];

//SE O FORMULARIO FOR ENVIADO, BUSCA PELO ID OU NOME
if($_SERVER["REQUEST_METHOD"]=="POST" && !empty($_POST['busca'])){
    $busca = trim($_POST['busca']);

    //VERIFICA SE A BUSCA É UM NUMERO (id) OU UM NOME
    if(is_numeric($busca)){
        $sql = "SELECT * FROM usuario WHERE id_usuario = :busca ORDER BY nome ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca',$busca,PDO::PARAM_INT);

    }else{
        $sql="SELECT * FROM usuario WHERE nome LIKE :busca_nome ORDER BY nome ASC";
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':busca_nome', "$busca%",PDO::PARAM_STR);
    }
}else{
        $sql="SELECT * FROM usuario ORDER BY nome ASC";
        $stmt=$pdo->prepare($sql);
}
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
</head>
<body>
    <?php include 'menu.php';?>
    <br>
    <h2>Lista de Usuarios</h2>
    <!-- FORMULARIO PARA BUSCAR USUARIO -->
     <form action="buscar_usuario.php" method="POST">
        <label for="busca">Digite o ID ou o NOME(opcional):</label>
        <input type="text" id="busca" name="busca">
        <button type="submit">Pesquisar</button>
     </form>

     <?php if(!empty($usuarios)):?>
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
            <?php foreach($usuarios as $usuario):?>
                <tr>
                    <td><?=htmlspecialchars($usuario['id_usuario'])?></td>
                    <td><?=htmlspecialchars($usuario['nome'])?></td>
                    <td><?=htmlspecialchars($usuario['email'])?></td>
                    <td><?=htmlspecialchars($usuario['id_perfil'])?></td>
                    <td>
                        <a href="alterar_usuario.php?id=<?=htmlspecialchars($usuario['id_usuario'])?>">Alterar</a>
                        <a href="excluir_usuario.php?id=<?=htmlspecialchars($usuario['id_usuario'])?>"onclick="return confirm('tem certeza que deseja excluir este usuario')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
        </table>

        <?php else:?>
            <p>Nenhum usuario encontrado.</p>
        <?php endif;?>
        <a href="index.php">Voltar</a>
</body>
</html>

