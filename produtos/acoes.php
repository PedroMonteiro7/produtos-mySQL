<?php

    session_start();

    require("../database/conexao.php");

    /*FUNÇÕES DE VALIDAÇÃO*/
    function validarCampos() {

        //ARRAY DAS MENSAGENS DE ERRO:
        $erros = [];

        //VALIDAÇÃO DE DESCRIÇÃO
        if(!isset($_POST['descricao']) || $_POST['descricao'] == ""){
            $erros[] = "O campo descrição é de preenchimento obrigatório.";
        }

        //VALIDAÇÃO DE PESO
        if(!isset($_POST['peso']) || $_POST['peso'] == ""){
            $erros[] = "O campo peso é de preenchimento obrigatório.";
        } elseif (!is_numeric(str_replace(',', '.', $_POST['peso']))) { //se não for um valor numérico, a mensagem de erro é exibida. Replace troca , por .
            $erros[] = "O campo peso deve preenchido apenas com números.";
        }

        //VALIDAÇÃO DE QUANTIDADE
        if(!isset($_POST['quantidade']) || $_POST['quantidade'] == ""){
            $erros[] = "O campo quantidade é de preenchimento obrigatório.";
        } elseif (!is_numeric(str_replace(',', '.', $_POST['quantidade']))) { 
            $erros[] = "O campo quantidade deve preenchido apenas com números.";
        }

        //VALIDAÇÃO DE COR
        if(!isset($_POST['cor']) || $_POST['cor'] == ""){
            $erros[] = "O campo cor é de preenchimento obrigatório.";
        }

        //VALIDAÇÃO DE TAMANHO
        if(!isset($_POST['tamanho']) || $_POST['tamanho'] == ""){
            $erros[] = "O campo tamanho é de preenchimento obrigatório.";
        }

        //VALIDAÇÃO DE VALOR
        if(!isset($_POST['valor']) || $_POST['valor'] == ""){
            $erros[] = "O campo valor é de preenchimento obrigatório.";
        } elseif (!is_numeric(str_replace(',', '.', $_POST['valor']))) { 
            $erros[] = "O campo valor deve preenchido apenas com números.";
        }

        //VALIDAÇÃO DE DESCONTO
        if(!isset($_POST['desconto']) || $_POST['desconto'] == ""){
            $erros[] = "O campo desconto é de preenchimento obrigatório.";
        } elseif (!is_numeric(str_replace(',', '.', $_POST['desconto']))) { 
            $erros[] = "O campo desconto deve preenchido apenas com números.";
        }

        //VALIDAÇÃO DE CATEGORIA
        if(!isset($_POST['categoria']) || $_POST['categoria'] == ""){
            $erros[] = "O campo categoria é de preenchimento obrigatório.";
        }

        //VALIDAÇÃO DA IMAGEM
        if ($_FILES['foto']['error'] == UPLOAD_ERR_NO_FILE) {
            $erros[] = "O arquivo deve ser uma imagem.";
        } else {
            $imagemInfos = getimagesize($_FILES['foto']['tmp']);

            if ($_FILES['foto']['size'] > 1024 * 1024 * 2) {
                $erros[] = "O arquivo não pode ser maior que 2MB";
            }

            $width = $imagemInfos[0];
            $height = $imagemInfos[1];

            if ($width != $height) {
                $erros[] = "A imagem precisa ser quadrada";
            }
        }

        return $erros;

}

    switch ($_POST["acao"]) {

        case 'inserir' :

            //CHAMADA DA FUNÇÃO VALIDAÇÃO DE ERROS:
            $erros = validarCampos();

            //VERIFICAR SE EXISTEM ERROS:
            if(count($erros) > 0) {

            $_SESSION["erros"] = $erros;

            // var_dump($erros);exit;

            header('location: novo/index.php');

            exit;

            }
            
            //TRATAMENTO DA IMAGEM PARA UPLOAD
            echo '<pre>';
            var_dump($_FILES);
            echo '</pre>';

            //RECUPERA O NOME DO ARQUIVO
            $nomeArquivo = $_FILES["foto"]["name"];

            //RECUPERAR A EXTENSÃO DO ARQUIVO
            $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);

            //DEFINIR UM NOVO NOME PARA O ARQUIVO DE IMAGEM
            $novoNome = md5(microtime()) . "." . $extensao;
            /*md5 codifica o texto/nome em um código string e depois é passado,
            com o microtime, para o formato timestamp (código gerado a partir da data e hora)*/

            // echo $nomeArquivo;
            // echo "<br>";
            // echo $novoNome;

            //UPLOAD DO ARQUIVO
            move_uploaded_file($_FILES["foto"]["tmp_name"], "fotos/$novoNome");
            //arquivo vindo do formulário, arquivo temporário e novo nome

            /*INSERÇÃO DE DADOS NA BASE DE DADOS DO MYSQL:*/

            //RECEBIMENTO DOS DADOS
            $descricao = $_POST["descricao"];
            $peso = $_POST["peso"];
            $quantidade = $_POST["quantidade"];
            $cor = $_POST["cor"];
            $tamanho = $_POST["tamanho"];
            $valor = $_POST["valor"];
            $desconto = $_POST["desconto"];
            $categoriaId = $_POST["categoria"];

            //CRIAÇÃO DA INSTRUÇÃO SQL DE INSERÇÃO:
            $sql = "INSERT INTO tbl_produto (descricao, peso, quantidade, cor, tamanho, valor, desconto, imagem, categoria_id) 
                VALUES ('$descricao', $peso, $quantidade, '$cor', '$tamanho', $valor, $desconto, '$novoNome', $categoriaId)";

            //EXECUÇÃO DO SQL DE INSERÇÃO:
            $resultado = mysqli_query($conexao, $sql);

            //REDIRECIONAR PARA INDEX
            header("location: index.php");

            break;

        case 'deletar':

            $produtoId = $_POST['produtoId'];

            $sql = "DELETE FROM tbl_produto WHERE id = $produtoId";

            $resultado = mysqli_query($conexao, $sql);

            header('location:index.php');

            break;    
        
        default:
            # code...
            break;
    }



?>