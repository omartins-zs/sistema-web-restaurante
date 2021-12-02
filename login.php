<?php

if (count($_POST) > 0) {
    // 1. Pegar os valores do formulario
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // 2. Conexao com banco de dados 
    $servername = "localhost";
    $username = "root";
    $password = "";

    try {
        include("conexao_bd.php");

        // 3. Verifica se email e senha estao no bando de dados
        $stmt = $conn->prepare("SELECT * FROM usuario WHERE situacao='Habilitado' AND email=:email AND senha=md5(:senha)");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR); // STMT = Consulta
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->fetchAll();
        $qtd_usuarios = count($result);
        if ($qtd_usuarios == 1) {
            $_SESSION["email_usuario"] = $email;
            $_SESSION["nome_usuario"] = $result[0]["senha"];
            header("Location: pedido.php");
        } else if ($qtd_usuarios == 0) {
            $resultado["msg"] = "Email e Senha nao conferem...";
            $resultado["cod"] = 0;
        }
    } catch (PDOException $e) {
        echo "Conexão falhou: " . $e->getMessage();
    }
    $conn = null;
}
include("index.php");