<?php
session_start();
require_once 'conexao.php';


//VERIFICA SE O fornecedor TEM PERMISSAO adm
if($_SESSION['perfil'] != 1){
    echo "<script> alert('Acesso negado!'); window.location.href='index.php'; </script>";
    exit();
}

//INICIALIZA AS VARIAVEIS
$fornecedor = null;


//SE O FORMULARIO FOR ENVIADO, BUSCA O fornecedor PELO id OU PELO nome
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if (!empty($_POST['busca_fornecedor'])){
    $busca = trim($_POST['busca_fornecedor']);

    //VERIFICA SE A BUSCA É UM NUMERO (id) OU UM NOME
    if(is_numeric($busca)){
        $sql = "SELECT * FROM fornecedor WHERE id_fornecedor = :busca";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca',$busca,PDO::PARAM_INT);

    }else{
        $sql="SELECT * FROM fornecedor WHERE nome_fornecedor LIKE :busca_nome";
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':busca_nome', "$busca%",PDO::PARAM_STR);
    }
    $stmt->execute();
    $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);

    //SE O fornecedor NÃO FOR ENCONTRADO, EXIBE UM ALERTA
    if(!$fornecedor){
        echo "<script> alert('fornecedor não encontrado!');</script>";
    }

}
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar fornecedor</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Certifique-se que o java script está sendo carregado -->
    <script src="scripts.js"></script>
</head>
<body>
<?php include 'menu.php';?>
<br>
<h2>Alterar fornecedor</h2>
    <!-- FORMULARIO PARA BUSCA fornecedor -->
     <form action="alterar_fornecedor.php" method="POST">
        <label for="busca_fornecedor">Digite o ID ou o NOME do fornecedor:</label>
        <input type="text" id="busca_fornecedor" name="busca_fornecedor" required onkeyup="buscarSugestoes()">
        <div id="sugestoes"></div>
        <button type="submit">Buscar</button>
     </form>

    <?php if($fornecedor): ?>
        <form action="processa_alteracao_fornecedor.php" method="POST">
            <input type="hidden" name="id_fornecedor" value="<?=htmlspecialchars($fornecedor['id_fornecedor'])?>">
            
            <label for="nome_fornecedor">nome_fornecedor:</label>
            <input type="text" id="name" name="nome_fornecedor" value="<?=htmlspecialchars($fornecedor['nome_fornecedor'])?>"required>

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" value="<?=htmlspecialchars($fornecedor['endereco'])?>" required>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" value="<?=htmlspecialchars($fornecedor['telefone'])?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required value="<?=htmlspecialchars($fornecedor['email'])?>">

            <label for="contato">Nome de Contato:</label>
            <input type="text" id="contato" name="contato" value="<?=htmlspecialchars($fornecedor['contato'])?>" required>

            <!-- SE O fornecedor LOGADO FOR ADM, EXIBIR OPÇÃO DE ALTERAR SENHA -->
             
                <button type="submit">Alterar</button>
                <button type="reset">Cancelar</button>
        </form>
        <?php endif; ?>
        <a href="index.php">Voltar</a>
</body>
</html>