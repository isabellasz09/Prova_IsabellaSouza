

<?php


require_once 'conexao.php';


// GARANTE QUE O USUARIO ESTEJA LOGADO
if(!isset($_SESSION['usuario'])){


    header("Location: login.php");
    exit();
}


// OBTENDO O NOME DO PERFIL DO USUARIO LOGADO


$id_perfil = $_SESSION['perfil'];
$sqlPerfil = "SELECT nome_perfil FROM perfil WHERE id_perfil = :id_perfil";
$stmtPerfil = $pdo->prepare($sqlPerfil);
$stmtPerfil->bindParam(":id_perfil",$id_perfil);
$stmtPerfil->execute();
$perfil = $stmtPerfil->fetch(PDO::FETCH_ASSOC);
$nome_perfil = $perfil["nome_perfil"];


// DEFINIÇÃO DAS PERMISSOES POR PERFIL


$permissoes = [
    1=>["Cadastrar"=>["cadastro_usuario.php","cadastro_perfil.php","cadastro_cliente.php","cadastro_produto.php","cadastro_fornecedor.php","cadastro_funcionario.php"],
        "Buscar"=>["buscar_usuario.php","buscar_perfil.php","buscar_cliente.php","buscar_produto.php","buscar_fornecedor.php","buscar_funcionario.php"],
        "Alterar"=>["alterar_usuario.php","alterar_perfil.php","alterar_cliente.php","alterar_produto.php","alterar_fornecedoro.php","alterar_funcionario.php"],
        "Excluir"=>["excluir_usuario.php","excluir_perfil.php","excluir_cliente.php","excluir_produto.php","excluir_fornecedor.php","excluir_funcionario.php"]],
   
    2=>["Cadastrar"=>["cadastro_cliente.php",],
        "Buscar"=>["buscar_cliente.php","buscar_produto.php","buscar_fornecedor.php"],
        "Alterar"=>["alterar_cliente.php","alterar_fornecedor.php"]],
   
    3=>["Cadastrar"=>["cadastro_produto.php","cadastro_fornecedor.php"],
        "Buscar"=>["buscar_cliente.php","buscar_produto.php","buscar_fornecedor.php"],
        "Alterar"=>["alterar_produto.php","alterar_fornecedor.php"],
        "Excluir"=>["excluir_produto.php"]],


    4=>["Cadastrar"=>["cadastro_cliente.php"],
        "Buscar"=>["buscar_produto.php"],
        "Alterar"=>["alterar_cliente.php"]],


];


// OBTENDO AS OPCOES DISPONIVEIS PARA O PERFIL LOGADO
$opcoes_menu = $permissoes[$id_perfil];
?>
    <nav>
        <ul class="menu">
            <?php foreach($opcoes_menu as $categoria=>$arquivos):?>
                <li>
                </li>
                <li class="dropdown">
                    <a href="#"><?=$categoria?></a>
                    <ul class="dropdown-menu">
                        <?php foreach($arquivos as $arquivo):?>
                            <li>
                                <a href="<?=$arquivo?>"><?= ucfirst(str_replace("_", " ",basename($arquivo,".php")))?></a>
                            </li>
                        <?php endforeach;?>
                           
                        </ul>
                </li>
            <?php endforeach;?>
        </ul>
    </nav>



