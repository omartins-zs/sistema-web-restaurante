<?php

if (count($_GET) > 0) {
    // 1. Pegar os valores do formulario
    $cod_prod = $_GET["cod_prod"];

    try {
        // 2. Conexao com banco de dados 
        include("conexao_bd.php");

        // 3. Inseri os dados no BD
        $sql = "UPDATE produto SET situacao = 'Desabilitado' WHERE codigo = ?";
        $stmt = $conn->prepare($sql); // STMT = Consulta
        $stmt->execute([$cod_prod]);

        // Para mostrar na Tela se esta vindo os dados
        // echo "<pre>";
        // print_r($result['produtos']);
        // echo "</pre>";

        // TODO substituido pelo redirecionamento
        $resultado["msg"] = "Item removido com sucesso!";
        $resultado["cod"] = 1;
        $resultado["style"] = "alert-success";
    } catch (PDOException $e) {
        $resultado["msg"] = "Erro ao inserir produto no banco de dados: " . $e->getMessage();
        $resultado["cod"] = 0;
        $resultado["style"] = "alert-danger";
    }
}

try {
    include("conexao_bd.php");

    // 3. Faz um SELECT para pegar os produtos armazenadosno BD e traz os dados do BD
    $consulta = $conn->prepare("SELECT * FROM produto");
    $consulta->execute();

    $result['produtos'] = $consulta->fetchAll();
} catch (PDOException $e) {
    $resultado["msg"] = "Erro ao remover produto no banco de dados: " . $e->getMessage();
    $resultado["cod"] = 0;
    $resultado["style"] = "alert-danger";
}

$conn = null;
include("produto.php");