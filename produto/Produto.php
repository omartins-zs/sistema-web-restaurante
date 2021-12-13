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
        if (!isset($_SESSION['codigo_usuario'])) session_start();
        $this->codigo = isset($valores["cod_prod"]) ?  $valores["cod_prod"] : 0;
        $this->nome = $valores["nome_produto"];
        $this->categoria = $valores["categoria_produto"];
        $this->valor = $valores["valor_produto"];
        $this->foto = $valores["foto_produto"];
        $this->info = $valores["info_produto"];
        $this->cod_usuario = $_SESSION["codigo_usuario"];
    }

    function selecionar($codigo = null)
    {
        $where_cod = "";
        if (isset($codigo) && $codigo > 0) {
            $where_cod = " AND codigo = " . $codigo;
        }
        try {
            include("conexao_bd.php");

            // 3. Faz um SELECT para pegar os produtos armazenadosno BD e traz os dados do BD
            $consulta = $conn->prepare("SELECT * FROM produto WHERE situacao = 'HABILITADO'" . $where_cod);
            $consulta->execute();

            $resultado = $consulta->fetchAll();
        } catch (PDOException $e) {
            $resultado["msg"] = "Erro ao selecionar produto no banco de dados: " . $e->getMessage();
            $resultado["cod"] = 0;
            $resultado["style"] = "alert-danger";
        }
        $conn = null;

        return $resultado;
    }

    function inserir($produto)
    {
        $this->pegar_valores_post($produto);

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

    function atualizar($produto)
    {
        $this->pegar_valores_post($produto);

        try {
            // 2. Conexao com banco de dados 
            include("conexao_bd.php");

            // 3. Inseri os dados no BD
            $sql = "UPDATE produto SET nome = ?, categoria = ?, valor = ?, info_adicional = ?, data_hora = now() WHERE codigo = ?";
            $stmt = $conn->prepare($sql); // STMT = Consulta
            $stmt->execute([$this->nome, $this->categoria, $this->valor, $this->info, $this->codigo]);

            // TODO substituido pelo redirecionamento
            $resultado["msg"] = "Item alterado com sucesso!";
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
    function remover($codigo)
    {
        try {
            // 2. Conexao com banco de dados 
            include("conexao_bd.php");

            // 3. Remove os dados no BD(Coloca como "DESABILITADO")
            $sql = "UPDATE produto SET situacao = 'Desabilitado' WHERE codigo = ?";
            $stmt = $conn->prepare($sql); // STMT = Consulta
            $stmt->execute([$codigo]);

            // Para mostrar na Tela se esta vindo os dados
            // echo "<pre>";
            // print_r($result['produtos']);
            // echo "</pre>";

            // TODO substituido pelo redirecionamento
            $resultado["msg"] = "Item removido com sucesso!";
            $resultado["cod"] = 1;
            $resultado["style"] = "alert-success";
        } catch (PDOException $e) {
            $resultado["msg"] = "Erro ao inserir produto no banco de dados: " . $e->getMessage();
            $resultado["cod"] = 0;
            $resultado["style"] = "alert-danger";
        }
    }
}