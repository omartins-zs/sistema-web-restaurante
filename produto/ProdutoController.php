<?php

require_once __DIR__ . '/Produto.php';

class ProdutoController
{
    private $produto;

    public function __construct()
    {
        $this->produto = new Produto();
    }

    public function selecionar($codigo = null)
    {
        return $this->produto->selecionar($codigo);
    }

    public function cadastrar($valores)
    {
        return $this->produto->inserir($valores);
    }

    public function atualizar($valores)
    {
        return $this->produto->atualizar($valores);
    }

    public function remover($codigo)
    {
        return $this->produto->remover($codigo);
    }
}
