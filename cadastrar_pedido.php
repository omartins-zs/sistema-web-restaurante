<?php

session_start();

if (count($_POST) > 0) {
    // 1. Pegar os valores do formulario
    $nome = $_POST["nome_produto"];
    $qtd = $_POST["qtd_produto"];
    $obs = $_POST["obs_produto"];
    $preco = $_POST["preco_produto"];
    $cod_usuario = $_SESSION["codigo_usuario"];

    // Pegar o codigo do usuario logado (chave estrangeira)

    try {
        // 2. Conexao com banco de dados 
        include("conexao_bd.php");

        // 3. Inseri os dados no BD
        $sql = "INSERT INTO item_pedido (cod_usuario, nome_produto, observacao, preco_und, quantidade) VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($sql); // STMT = Consulta
        $stmt->execute([$cod_usuario, $nome, $obs, $preco, $qtd]);

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
include("pedido.php");