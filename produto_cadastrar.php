<?php

if (count($_POST) > 0) {
    session_start();

    require_once('produto/Produto.php');

    $produto = new Produto();

    $resultado = $produto->inserir($_POST);
}
include("produto.php");