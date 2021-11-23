<?php
// 1. Pegar os valores do formulario

// 2. Conexao com banco de dados 
$servername = "localhost";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$servername;dbname=restaurante-bd", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Conexão realizada com sucesso";
} catch(PDOException $e) {
  echo "CConexão falhou: " . $e->getMessage();
}
// 3. Verificar se email e senha estao no bando de dados
