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
    function login($valores)
    {
        // 1. Pegar os valores do formulario
        $filtro = array();
        $filtro["email"] = $valores["email"];
        $filtro["senha"] = $valores["senha"];
        $filtro["situacao"] = "Habilitado";

        $usuario = $this->usuario->selecionar($filtro);


        if (count($usuario) == 1) {
            session_start();
            $_SESSION["email_usuario"] =
                $valores["email"];
            $_SESSION["nome_usuario"] = $usuario[0]["nome"];
            $_SESSION["codigo_usuario"] = $usuario[0]["codigo"];

            header("Location: produto.php");
        } else if (count($usuario) == 0) {
            $resultado["msg"] = "Email e Senha nao conferem...";
            $resultado["cod"] = 0;

            return $resultado;
        }
    }
}