<?php
session_start();
require_once 'conexao.php';

if($_SESSION['perfil']!=1 && $_SESSION['perfil']!=2){
    echo "<script> alert('Acesso negado!');window.location.href='principal.php';</script>";
    exit();

}

//INICIALIZA A VARIAVEL PARA EVITAR ERROS
$fornecedor = [];

//SE O FORMULARIO FOR ENVIADO, BUSCA PELO ID OU NOME
if($_SERVER["REQUEST_METHOD"]=="POST" && !empty($_POST['busca'])){
    $busca = trim($_POST['busca']);

    //VERIFICA SE A BUSCA É UM NUMERO (id) OU UM NOME
    if(is_numeric($busca)){
        $sql = "SELECT * FROM fornecedor WHERE id_fornecedor = :busca ORDER BY nome_fornecedor ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca',$busca,PDO::PARAM_INT);

    }else{
        $sql="SELECT * FROM fornecedor WHERE nome_fornecedor LIKE :busca_nome ORDER BY nome_fornecedor ASC";
        $stmt = $pdo->prepare($sql);
        $stmt ->bindValue(':busca_nome', "$busca%",PDO::PARAM_STR);
    }
}else{
        $sql="SELECT * FROM fornecedor ORDER BY nome_fornecedor ASC";
        $stmt = $pdo->prepare($sql);
}
$stmt->execute();
$fornecedor = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar fornecedor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
</head>
<body>
<?php include 'menu.php';?> 
    <br>
    <h2>Lista de fornecedor</h2>
    <!-- FORMULARIO PARA BUSCAR fornecedor -->
     <form action="buscar_fornecedor.php" method="POST">
        <label for="busca">Digite o ID ou o NOME(opcional):</label>
        <input type="text" id="busca" name="busca">
        <button type="submit">Pesquisar</button>
     </form>

     <?php if(!empty($fornecedor)):?>
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
            <?php foreach($fornecedor as $fornecedor):?>
                <tr>
                    <td><?=htmlspecialchars($fornecedor['id_fornecedor'])?></td>
                    <td><?=htmlspecialchars($fornecedor['nome_fornecedor'])?></td>
                    <td><?=htmlspecialchars($fornecedor['endereco'])?></td>
                    <td><?=htmlspecialchars($fornecedor['telefone'])?></td>
                    <td><?=htmlspecialchars($fornecedor['email'])?></td>
                    <td><?=htmlspecialchars($fornecedor['contato'])?></td>
                    <td>
                        <a href="alterar_fornecedor.php?id=<?=htmlspecialchars($fornecedor['id_fornecedor'])?>">Alterar</a>
                        <a href="excluir_fornecedor.php?id=<?=htmlspecialchars($fornecedor['id_fornecedor'])?>"onclick="return confirm('tem certeza que deseja excluir este fornecedor')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
        </table>

        <?php else:?>
            <p>Nenhum fornecedor encontrado.</p>
        <?php endif;?>
        <a href="principal.php">Voltar</a>
</body>
</html>

