<?php
session_start();
require_once 'conexao.php';


//VERIFICA SE O USUARIO TEM PERMISSAO adm
if($_SESSION['perfil'] != 1){
    echo "<script> alert('Acesso negado!'); window.location.href='principal.php'; </script>";
    exit();
}

//INICIALIZA AS VARIAVEIS
$usuario = null;


//SE O FORMULARIO FOR ENVIADO, BUSCA O USUARIO PELO id OU PELO nome
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if (!empty($_POST['busca_usuario'])){
    $busca = trim($_POST['busca_usuario']);

    //VERIFICA SE A BUSCA É UM NUMERO (id) OU UM NOME
    if(is_numeric($busca)){
        $sql = "SELECT * FROM usuario WHERE id_usuario = :busca";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca',$busca,PDO::PARAM_INT);

    }else{
        $sql="SELECT * FROM usuario WHERE nome LIKE :busca_nome";
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':busca_nome', "$busca%",PDO::PARAM_STR);
    }
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    //SE O USUARIO NÃO FOR ENCONTRADO, EXIBE UM ALERTA
    if(!$usuario){
        echo "<script> alert('Usuario não encontrado!');</script>";
    }

}
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Usuario</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Certifique-se que o java script está sendo carregado -->
    <script src="scripts.js"></script>
</head>
<body>
<?php include 'menu.php';?>
<br>
<h2>Alterar Usuarios</h2>
    <!-- FORMULARIO PARA BUSCA USUARIO -->
     <form action="alterar_usuario.php" method="POST">
        <label for="busca_usuario">Digite o ID ou o NOME do usuario:</label>
        <input type="text" id="busca_usuario" name="busca_usuario" required onkeyup="buscarSugestoes()">
        <div id="sugestoes"></div>
        <button type="submit">Buscar</button>
     </form>

    <?php if($usuario): ?>
        <form action="processa_alteracao_usuario.php" method="POST">
            <input type="hidden" name="id_usuario" value="<?=htmlspecialchars($usuario['id_usuario'])?>">
            
            <label for="nome">Nome:</label>
            <input type="text" id="name" name="nome" value="<?=htmlspecialchars($usuario['nome'])?>"required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?=htmlspecialchars($usuario['email'])?>"required>

            <label for="id_perfil">Perfil:</label>
            <select name="id_perfil" id="id_perfil">
                <option value="1"<?=$usuario['id_perfil']==1 ?'selected':''?>>Adminitrador</option>
                <option value="2"<?=$usuario['id_perfil']==1 ?'selected':''?>>Secretaria</option>
                <option value="3"<?=$usuario['id_perfil']==1 ?'selected':''?>>Almoxarife</option>
                <option value="4"<?=$usuario['id_perfil']==1 ?'selected':''?>>Cliente</option>
            </select>

            <!-- SE O USUARIO LOGADO FOR ADM, EXIBIR OPÇÃO DE ALTERAR SENHA -->
             <?php if($_SESSION['perfil'] == 1 ): ?>
                <label for="nova_senha">Nova senha: </label>
                <input type="password" id="nova_senha" name="nova_senha">
             <?php endif;?>
                <button type="submit">Alterar</button>
                <button type="reset">Cancelar</button>
        </form>
        <?php endif; ?>
        <a href="principal.php">Voltar</a>
</body>
</html>