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

        // TODO substituido pelo redirecionamento
        $resultado["msg"] = "Item inserido com sucesso!";
        $resultado["cod"] = 1;
        $resultado["style"] = "alert-success";
    } catch (PDOException $e) {
        $resultado["msg"] = "Inserção no banco falhou: " . $e->getMessage();
        $resultado["cod"] = 0;
        $resultado["style"] = "alert-danger";
    }
    $conn = null;
}
include("produto.php");
