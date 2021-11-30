<?php


try {

    include("conexao_bd.php");

    // 3. Faz um SELECT para pegar os produtos armazenadosno BD e traz os dados do BD
    $consulta = $conn->prepare("SELECT * FROM produto");
    $consulta->execute();

    $produtos = $consulta->fetchAll();
} catch (PDOException $e) {
    $resultado["msg"] = "Erro ao selecionar produto no banco de dados: " . $e->getMessage();
    $resultado["cod"] = 0;
    $resultado["style"] = "alert-danger";
}

$conn = null;