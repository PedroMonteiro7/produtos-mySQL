<?php

/*
PARAMETROS DE CONEXAO MYSQLI
1 - host -> onde o banco de dados está rodando
2 - user -> usuário do banco de dados 
3 - password -> senha do usuário do banco de dados
4 - database -> nome do banco de dados
*/

//escrever constante com letras maiúsculas é uma boaprática, não regra
const HOST = 'localhost';
const USER = 'root';
const PASSWORD = 'bcd127';
const DATABASE = 'icatalogo';

$conexao = mysqli_connect(HOST, USER, PASSWORD, DATABASE);

if($conexao === false) {

    die(mysqli_connect_error());

}

// echo '<pre>';
// var_dump($conexao);
// echo '</pre>';

?>