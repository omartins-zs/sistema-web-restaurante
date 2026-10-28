<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/usuario/UsuarioController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && count($_POST) > 0) {
    try {
        $usuarioControl = new UsuarioController();
        $resultado = $usuarioControl->login($_POST);
    } catch (Exception $e) {
        $resultado = [
            "msg"   => "Erro ao conectar ao banco de dados: " . $e->getMessage(),
            "cod"   => 0,
            "style" => "alert-danger"
        ];
    }
}

include __DIR__ . '/index.php';
