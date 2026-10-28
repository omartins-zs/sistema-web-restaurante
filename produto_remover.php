<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

if (isset($_SESSION["codigo_usuario"]) && $_SESSION["codigo_usuario"] > 0) {
    if (isset($_GET["cod_prod"]) && (int) $_GET["cod_prod"] > 0) {
        $cod_prod = (int) $_GET["cod_prod"];

        require_once __DIR__ . '/produto/ProdutoController.php';

        $produtoControl = new ProdutoController();
        $resultado = $produtoControl->remover($cod_prod);

        echo json_encode($resultado);
        exit;
    }
}

http_response_code(403);
echo json_encode([
    "msg"   => "Operação não permitida!",
    "cod"   => 0,
    "style" => "alert-danger"
]);
