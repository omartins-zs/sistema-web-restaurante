<?php

require_once __DIR__ . '/../bd/BancoDados.php';

class Usuario
{
    private $banco_dados;

    public function __construct()
    {
        $this->banco_dados = new BancoDados();
    }

    public function selecionar($filtro = null)
    {
        try {
            $conn = $this->banco_dados->conectar();

            if (is_array($filtro)) {
                $sql = "SELECT * FROM usuario WHERE situacao = :situacao AND email = :email AND (senha = md5(:senha_md5) OR senha = :senha_plain)";
                $stmt = $conn->prepare($sql);
                $situacao = isset($filtro["situacao"]) ? $filtro["situacao"] : "Habilitado";
                $email    = trim($filtro["email"] ?? "");
                $senha    = $filtro["senha"] ?? "";

                $stmt->bindParam(':situacao', $situacao, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':senha_md5', $senha, PDO::PARAM_STR);
                $stmt->bindParam(':senha_plain', $senha, PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } elseif (!empty($filtro) && is_numeric($filtro)) {
                $stmt = $conn->prepare("SELECT * FROM usuario WHERE codigo = :codigo");
                $stmt->bindParam(':codigo', $filtro, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $stmt = $conn->prepare("SELECT * FROM usuario WHERE situacao = 'Habilitado'");
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return [];
        }
    }

    public function inserir($valores)
    {
        try {
            $conn = $this->banco_dados->conectar();
            $sql = "INSERT INTO usuario (nome, email, senha, situacao) VALUES (?, ?, md5(?), 'Habilitado')";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                trim($valores["nome"] ?? ""),
                trim($valores["email"] ?? ""),
                $valores["senha"] ?? ""
            ]);

            return [
                "msg"   => "Usuário cadastrado com sucesso!",
                "cod"   => 1,
                "style" => "alert-success"
            ];
        } catch (PDOException $e) {
            return [
                "msg"   => "Erro ao cadastrar usuário: " . $e->getMessage(),
                "cod"   => 0,
                "style" => "alert-danger"
            ];
        }
    }
}
