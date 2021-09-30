<?php

/*CONEXÃO COM O BANCO DE DADOS*/
require('../database/conexao.php');

/*TRATAMENTO DOS DADOS VINDOS DO FORMULÁRIO

- TIPOS DE AÇÃO;
- EXECUÇÃO DOS PROCESSOS DA AÇÃO SOLICITADA
*/

switch ($_POST['acao']) {
    case 'inserir':
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
    
    default:
        # code...
        break;
}

/**/


//switch case trabalha apenas com igualdade, diferentemente da estrutura if e else
?>