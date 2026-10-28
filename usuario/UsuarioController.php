<?php

require_once __DIR__ . '/Usuario.php';

class UsuarioController
{
    private $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    public function selecionar($codigo = null)
    {
        return $this->usuario->selecionar($codigo);
    }

    public function cadastrar($valores)
    {
        return $this->usuario->inserir($valores);
    }

    public function login($valores)
    {
        $email = trim($valores["email"] ?? "");
        $senha = $valores["senha"] ?? "";

        if ($email === "" || $senha === "") {
            return [
                "msg"   => "Preencha seu e-mail e senha para entrar.",
                "cod"   => 0,
                "style" => "alert-danger"
            ];
        }

        $filtro = [
            "email"    => $email,
            "senha"    => $senha,
            "situacao" => "Habilitado"
        ];

        $usuarios = $this->usuario->selecionar($filtro);

        if (is_array($usuarios) && count($usuarios) === 1) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            session_regenerate_id(true);

            $_SESSION["email_usuario"]  = $usuarios[0]["email"];
            $_SESSION["nome_usuario"]   = $usuarios[0]["nome"];
            $_SESSION["codigo_usuario"] = $usuarios[0]["codigo"];

            header("Location: produto.php");
            exit;
        }

        return [
            "msg"   => "E-mail ou senha inválidos, ou usuário desabilitado.",
            "cod"   => 0,
            "style" => "alert-danger"
        ];
    }
}
