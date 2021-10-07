<?php

session_start();

/*CONEXÃO COM O BANCO DE DADOS*/
require('../database/conexao.php');

/*FUNÇÃO DE VALIDAÇÃO*/
function validarCampos() {

    $erros = [];

    if(!isset($_POST['descricao']) || $_POST['descricao'] == ""){

        $erros[] = "O campo descrição é de preenchimento obrigatório";

    }

    return $erros;

}

/*TRATAMENTO DOS DADOS VINDOS DO FORMULÁRIO

- TIPOS DE AÇÃO;
- EXECUÇÃO DOS PROCESSOS DA AÇÃO SOLICITADA
*/

switch ($_POST['acao']) {
    case 'inserir':

        //CHAMADA DA FUNÇÃO VALIDAÇÃO DE ERROS:
        $erros = validarCampos();

        //VERIFICAR SE EXISTEM ERROS:
        if(count($erros) > 0) {

            $_SESSION["erros"] = $erros;

            header('location:index.php');

            exit;

        }

        // echo 'inserir'; exit;
        $descricao = $_POST['descricao'];

        /*MONTAGEM DA INSTRUÇÃO SQL DE INSERÇÃO DE DADOS:*/
        $sql = "INSERT INTO tbl_categoria (descricao) VALUES ('$descricao')";
        // echo $sql;exit;

        /*
        mysql_query parametros:
        1 - Uma conexão aberta e válida
        2 - Uma instrução sql válida*/

        $resultado = mysqli_query($conexao, $sql);

        header('location:index.php');

        // echo '<pre>';
        // var_dump($resultado);
        // echo '</pre>';

        break;

    case 'deletar':

        $categoriaId = $_POST['categoriaId'];

        $sql = "DELETE FROM tbl_categoria WHERE id = $categoriaId";

        $resultado = mysqli_query($conexao, $sql);

        header('location:index.php');

        break;

    case 'editar':

        $id = $_POST["id"];
        $descricao = $_POST["descricao"];

        $sql = "UPDATE tbl_categoria SET descricao = '$descricao' WHERE id = $id";
        
        $resultado = mysqli_query($conexao, $sql);

        header('location:index.php');

        break;
    
    default:
        # code...
        break;
}

/**/


//switch case trabalha apenas com igualdade, diferentemente da estrutura if e else
?>