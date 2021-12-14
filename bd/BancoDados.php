<?php


class BancoDados
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";

    public function conectar()
    {
        $conn = new PDO("mysql:host=$this->servername;dbname=restaurante-bd", $this->username, $this->password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //   echo "Conexão realizada com sucesso"; 
        return $conn;
    }
}