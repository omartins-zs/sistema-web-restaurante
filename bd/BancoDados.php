<?php

class BancoDados
{
    private $servername;
    private $port;
    private $dbname;
    private $username;
    private $password;

    public function __construct()
    {
        $this->carregarEnv();
        $this->servername = $this->obterConfig('DB_HOST', '127.0.0.1');
        $this->port       = $this->obterConfig('DB_PORT', '3307');
        $this->dbname     = $this->obterConfig('DB_DATABASE', 'restaurante-bd');
        $this->username   = $this->obterConfig('DB_USERNAME', 'root');
        $this->password   = $this->obterConfig('DB_PASSWORD', '');
    }

    private function carregarEnv()
    {
        $envPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';
        if (!file_exists($envPath)) {
            return;
        }

        $linhas = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($linhas as $linha) {
            $linha = trim($linha);
            if ($linha === '' || strpos($linha, '#') === 0 || strpos($linha, '=') === false) {
                continue;
            }
            list($chave, $valor) = explode('=', $linha, 2);
            $chave = trim($chave);
            $valor = trim($valor, " \t\n\r\0\x0B\"'");

            if (!isset($_ENV[$chave]) && getenv($chave) === false) {
                $_ENV[$chave] = $valor;
                putenv("$chave=$valor");
            }
        }
    }

    private function obterConfig($chave, $padrao)
    {
        if (isset($_ENV[$chave]) && $_ENV[$chave] !== '') {
            return $_ENV[$chave];
        }
        $env = getenv($chave);
        if ($env !== false && $env !== '') {
            return $env;
        }
        return $padrao;
    }

    public function conectar()
    {
        try {
            $dsn = "mysql:host={$this->servername};port={$this->port};dbname={$this->dbname};charset=utf8mb4";
            $conn = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
            return $conn;
        } catch (PDOException $e) {
            // Fallback automático para porta 3306 em ambiente local se 3307 não responder
            if ($this->port === '3307' && ($this->servername === '127.0.0.1' || $this->servername === 'localhost')) {
                $dsnFallback = "mysql:host={$this->servername};port=3306;dbname={$this->dbname};charset=utf8mb4";
                $conn = new PDO($dsnFallback, $this->username, $this->password, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
                return $conn;
            }
            throw $e;
        }
    }
}
