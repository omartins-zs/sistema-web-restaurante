<?php

require_once __DIR__ . '/../bd/BancoDados.php';

class Produto
{
    private $codigo;
    private $nome;
    private $categoria;
    private $valor;
    private $foto;
    private $info;
    private $cod_usuario;

    private $banco_dados;

    public function __construct()
    {
        $this->banco_dados = new BancoDados();
    }

    public function pegar_valores_post($valores)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->codigo      = isset($valores["cod_prod"]) ? (int) $valores["cod_prod"] : 0;
        $this->nome        = trim($valores["nome_produto"] ?? "");
        $this->categoria   = trim($valores["categoria_produto"] ?? "");
        $this->valor       = $valores["valor_produto"] ?? 0;
        $this->foto        = $valores["foto_produto"] ?? "";
        $this->info        = trim($valores["info_produto"] ?? "");
        $this->cod_usuario = $_SESSION["codigo_usuario"] ?? null;
    }

    public function selecionar($codigo = null)
    {
        try {
            $conn = $this->banco_dados->conectar();

            if (!empty($codigo) && (int) $codigo > 0) {
                $consulta = $conn->prepare("SELECT * FROM produto WHERE situacao = 'HABILITADO' AND codigo = :codigo ORDER BY codigo DESC");
                $codInt = (int) $codigo;
                $consulta->bindParam(':codigo', $codInt, PDO::PARAM_INT);
            } else {
                $consulta = $conn->prepare("SELECT * FROM produto WHERE situacao = 'HABILITADO' ORDER BY codigo DESC");
            }

            $consulta->execute();
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $resultado = [];
        }
        $conn = null;

        return $resultado;
    }

    public function inserir($produto)
    {
        $this->pegar_valores_post($produto);

        try {
            $conn = $this->banco_dados->conectar();

            $sql = "INSERT INTO produto (nome, categoria, valor, foto, info_adicional, codigo_usuario, situacao) VALUES (?, ?, ?, ?, ?, ?, 'HABILITADO')";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$this->nome, $this->categoria, $this->valor, $this->foto, $this->info, $this->cod_usuario]);

            $resultado = [
                "msg"   => "Produto inserido com sucesso!",
                "cod"   => 1,
                "style" => "alert-success"
            ];
        } catch (PDOException $e) {
            $resultado = [
                "msg"   => "Erro ao inserir produto no banco de dados: " . $e->getMessage(),
                "cod"   => 0,
                "style" => "alert-danger"
            ];
        }
        $conn = null;
        return $resultado;
    }

    public function atualizar($produto)
    {
        $this->pegar_valores_post($produto);

        try {
            $conn = $this->banco_dados->conectar();

            $sql = "UPDATE produto SET nome = ?, categoria = ?, valor = ?, info_adicional = ?, data_hora = now() WHERE codigo = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$this->nome, $this->categoria, $this->valor, $this->info, $this->codigo]);

            $resultado = [
                "msg"   => "Item alterado com sucesso!",
                "cod"   => 1,
                "style" => "alert-success"
            ];
        } catch (PDOException $e) {
            $resultado = [
                "msg"   => "Erro ao alterar produto no banco de dados: " . $e->getMessage(),
                "cod"   => 0,
                "style" => "alert-danger"
            ];
        }
        $conn = null;
        return $resultado;
    }

    public function remover($codigo)
    {
        try {
            $conn = $this->banco_dados->conectar();

            $sql = "UPDATE produto SET situacao = 'DESABILITADO' WHERE codigo = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([(int) $codigo]);

            $resultado = [
                "msg"   => "Item removido com sucesso!",
                "cod"   => 1,
                "style" => "alert-success"
            ];
        } catch (PDOException $e) {
            $resultado = [
                "msg"   => "Erro ao remover produto no banco de dados: " . $e->getMessage(),
                "cod"   => 0,
                "style" => "alert-danger"
            ];
        }
        $conn = null;
        return $resultado;
    }
}
