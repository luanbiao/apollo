<?php

class Conexao {
    private $host = "localhost";
    private $usuario = "root";
    private $senha = "";
    private $banco = "apollo";
    private $conexao;

    public function __construct() {
        try {
            $this->conexao = new PDO("mysql:host=$this->host;dbname=$this->banco", $this->usuario, $this->senha);
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }

    public function getConexao() {
        return $this->conexao;
    }
}

?>
