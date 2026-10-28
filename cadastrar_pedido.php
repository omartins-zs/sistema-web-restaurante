<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && count($_POST) > 0 && isset($_SESSION["codigo_usuario"])) {
    $nome        = trim($_POST["nome_produto"] ?? "");
    $qtd         = (int) ($_POST["qtd_produto"] ?? 1);
    $obs         = trim($_POST["obs_produto"] ?? "");
    $preco       = (float) ($_POST["preco_produto"] ?? 0);
    $cod_usuario = (int) $_SESSION["codigo_usuario"];

    try {
        require_once __DIR__ . '/conexao_bd.php';

        $sql = "INSERT INTO item_pedido (cod_usuario, nome_produto, observacao, preco_und, quantidade) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$cod_usuario, $nome, $obs, $preco, $qtd]);

        $resultado = [
            "msg"   => "Item inserido com sucesso!",
            "cod"   => 1,
            "style" => "alert-success"
        ];
    } catch (PDOException $e) {
        $resultado = [
            "msg"   => "Inserção no banco falhou: " . $e->getMessage(),
            "cod"   => 0,
            "style" => "alert-danger"
        ];
    }
    $conn = null;
}

include __DIR__ . '/pedido.php';
