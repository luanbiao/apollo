<?php

require_once 'conexaoClass.php';

class Categorias {
    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
    }

    public function criarCategoria($nome) {
        $sql = "INSERT INTO categorias (nome) VALUES (?)";
        return $this->executarQuery($sql, [$nome]);
    }

    public function consultarCategoria($id) {
        $sql = "SELECT * FROM categorias WHERE id = ?";
        return $this->executarQuery($sql, [$id])->fetch(PDO::FETCH_ASSOC);
    }

    public function removerCategoria($id) {
        $sql = "DELETE FROM categorias WHERE id = ?";
        return $this->executarQuery($sql, [$id]);
    }

    public function alterarCategoria($id, $novoNome) {
        $sql = "UPDATE categorias SET nome = ? WHERE id = ?";
        return $this->executarQuery($sql, [$novoNome, $id]);
    }

    public function contarCategorias() {
        $sql = "SELECT COUNT(*) FROM categorias";
        return $this->executarQuery($sql)->fetchColumn();
    }

    public function mostrarCategorias() {
        $sql = "SELECT * FROM categorias";
        return $this->executarQuery($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    private function executarQuery($sql, $params = []) {
        try {
            $stmt = $this->conexao->getConexao()->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            return false;
        }
    }
}

?>
