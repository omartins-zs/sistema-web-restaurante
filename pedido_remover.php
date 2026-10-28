<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

if (isset($_SESSION["codigo_usuario"]) && $_SESSION["codigo_usuario"] > 0) {
    if (isset($_GET["cod_item"]) && (int) $_GET["cod_item"] > 0) {
        $cod_item = (int) $_GET["cod_item"];

        try {
            require_once __DIR__ . '/bd/BancoDados.php';
            $bd = new BancoDados();
            $conn = $bd->conectar();

            $stmt = $conn->prepare("DELETE FROM item_pedido WHERE codigo = ?");
            $stmt->execute([$cod_item]);

            echo json_encode([
                "msg"   => "Item de pedido excluído com sucesso!",
                "cod"   => 1,
                "style" => "alert-success"
            ]);
            exit;
        } catch (PDOException $e) {
            echo json_encode([
                "msg"   => "Erro ao remover item: " . $e->getMessage(),
                "cod"   => 0,
                "style" => "alert-danger"
            ]);
            exit;
        }
    }
}

http_response_code(403);
echo json_encode([
    "msg"   => "Operação não permitida!",
    "cod"   => 0,
    "style" => "alert-danger"
]);
