<?php

if (count($_POST) > 0) {
    // 1. Pegar os valores do formulario
    $nome = $_POST["nome_produto"];
    $categoria = $_POST["categoria_produto"];
    $valor = $_POST["valor_produto"];
    $foto = $_POST["foto_produto"];
    $info = $_POST["info_produto"];

    try {
        // 2. Conexao com banco de dados 
        include("conexao_bd.php");

        // 3. Inseri os dados no BD
        $sql = "INSERT INTO produto ( nome, categoria, valor, foto,info_adicional, codigo_usuario) VALUES (?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql); // STMT = Consulta
        $stmt->execute([$nome, $categoria, $valor, $foto, $info, null]);

        // Para mostrar na Tela se esta vindo os dados
        // echo "<pre>";
        // print_r($result['produtos']);
        // echo "</pre>";

        // TODO substituido pelo redirecionamento
        $resultado["msg"] = "Item inserido com sucesso!";
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
    $resultado["msg"] = "Erro ao selecionar produto no banco de dados: " . $e->getMessage();
    $resultado["cod"] = 0;
    $resultado["style"] = "alert-danger";
}

$conn = null;
include("produto.php");