<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "sistema_cadastro";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se ocorreu um erro na conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>

