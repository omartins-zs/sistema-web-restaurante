<?php

class Produto
{
    private $codigo;
    private $nome;
    private $categoria;
    private $valor;
    private $foto;
    private $info;
    private $cod_usuario;

    function pegar_valores_post($valores)
    {
        session_start();

        $this->nome = $$valores["nome_produto"];
        $this->categoria = $$valores["categoria_produto"];
        $this->valor = $$valores["valor_produto"];
        $this->foto = $$valores["foto_produto"];
        $this->info = $$valores["info_produto"];
        $this->cod_usuario = $_SESSION["codigo_usuario"];
    }

    function inserir($valores)
    {
        $this->pegar_valores_post($valores);

        try {
            // 2. Conexao com banco de dados 
            include("conexao_bd.php");

            $sql = "INSERT INTO produto ( nome, categoria, valor, foto,info_adicional, codigo_usuario) VALUES (?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql); // STMT = Consulta
            $stmt->execute([$this->nome, $this->categoria, $this->valor, $this->foto, $this->info, $this->cod_usuario]);

            $resultado["msg"] = "Produto inserido com sucesso!";
            $resultado["cod"] = 1;
            $resultado["style"] = "alert-success";
        } catch (PDOException $e) {
            $resultado["msg"] = "Erro ao inserir produto no banco de dados: " . $e->getMessage();
            $resultado["cod"] = 0;
            $resultado["style"] = "alert-danger";
        }
        $conn = null;

        return $resultado;
    }
}