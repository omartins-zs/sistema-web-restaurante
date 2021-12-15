<?php

require_once('Usuario.php');
class UsuarioController
{
    private $usuario;

    function __construct()
    {
        $this->usuario = new Usuario();
    }
    function selecionar($codigo = null)
    {
        return $this->usuario->selecionar($codigo);
    }

    function cadastrar($valores)
    {
        $resultado = $this->usuario->inserir($valores);
    }
}