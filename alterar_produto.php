<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && count($_POST) > 0) {
    require_once __DIR__ . '/produto/ProdutoController.php';

    $produtoControl = new ProdutoController();
    $_SESSION["flash_resultado"] = $produtoControl->atualizar($_POST);

    header("Location: produto.php");
    exit;
}

header("Location: produto.php");
exit;
