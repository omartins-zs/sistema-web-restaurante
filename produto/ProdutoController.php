<?php

require_once('Produto.php');
class ProdutoController
{
    function selecionar($codigo = null)
    {
        $produto = new Produto();
        return $produto->selecionar($codigo);
    }

    function cadastrar($valores)
    {
        $produto = new Produto();
        $resultado = $produto->inserir($valores);
    }
}