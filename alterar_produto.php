<?php

if (count($_POST) > 0) {
    // 1. Pegar os valores do formulario
    $nome = $_POST["nome_produto"];
    $categoria = $_POST["categoria_produto"];
    $valor = $_POST["valor_produto"];
    $foto = $_POST["foto_produto"];
    $info = $_POST["info_produto"];
    $cod_prod = $_POST["cod_prod"];

    try {
        // 2. Conexao com banco de dados 
        include("conexao_bd.php");

        // 3. Inseri os dados no BD
        $sql = "UPDATE produto SET nome = ?, categoria = ?, valor = ?, info_adicional = ?, data_hora = now() WHERE codigo = ?";
        $stmt = $conn->prepare($sql); // STMT = Consulta
        $stmt->execute([$nome, $categoria, $valor, $info, $cod_prod]);

        // TODO substituido pelo redirecionamento
        $resultado["msg"] = "Item alterado com sucesso!";
        $resultado["cod"] = 1;
        $resultado["style"] = "alert-success";
    } catch (PDOException $e) {
        $resultado["msg"] = "Erro ao inserir produto no banco de dados: " . $e->getMessage();
        $resultado["cod"] = 0;
        $resultado["style"] = "alert-danger";
    }
    $conn = null;
}
header("Location: produto.php");