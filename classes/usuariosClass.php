<?php

require_once 'conexaoClass.php';


class Usuarios {
    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
    }

    public function criarUsuario($login, $email, $senha, $ativo) {
        $loginExists = $this->verificarExistenciaUsuario('login', $login);
        $emailExists = $this->verificarExistenciaUsuario('email', $email);
    
        if ($loginExists) {
            return "Login já registrado";
        }
    
        if ($emailExists) {
            return "E-mail já registrado";
        }
    
        $hashedSenha = password_hash($senha, PASSWORD_DEFAULT);
    
        $sql = "INSERT INTO usuarios (login, email, senha, ativo) VALUES (?, ?, ?, ?)";
        $stmt = $this->executarQuery($sql, [$login, $email, $hashedSenha, $ativo]);
        
        return "Cadastrado com sucesso";
    }
    
    private function verificarExistenciaUsuario($field, $value) {
        $sql = "SELECT COUNT(*) AS count FROM usuarios WHERE $field = ?";
        $stmt = $this->executarQuery($sql, [$value]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result['count'] > 0;
    }
    
    public function consultarAdmin($login){
        $sql = "SELECT admin FROM usuarios WHERE login = ?";
        return $this->executarQuery($sql, [$login])->fetch(PDO::FETCH_ASSOC);
    }
    

    public function consultarUsuario($login) {
        $sql = "SELECT * FROM usuarios WHERE login = ?";
        return $this->executarQuery($sql, [$login])->fetch(PDO::FETCH_ASSOC);
    }

    public function removerUsuario($id) {
        $sql = "DELETE FROM usuarios WHERE id = ?";
        return $this->executarQuery($sql, [$id]);
    }

    public function alterarUsuario($id, $login, $email, $ativo) {
       // $hashedSenha = password_hash($novaSenha, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET login = ?, email = ?, ativo = ? WHERE id = ?";
        return $this->executarQuery($sql, [$login, $email, $ativo, $id]);
    }

    public function loginUsuario($login, $senha) {
        $usuario = $this->consultarUsuario($login);

        if (!$usuario) {
            return "Usuário não encontrado";
        }
    
        if ($usuario['ativo'] !== "Sim") {
            return "Usuário não ativo";
        }
    
        if (!password_verify($senha, $usuario['senha'])) {
            return "Senha incorreta";
        }
    
        // Login successful, update token and login timestamp
        $token = bin2hex(random_bytes(32));
        $sql = "UPDATE usuarios SET token = ?, dataLogin = ? WHERE login = ?";
        $stmt = $this->executarQuery($sql, [$token, date('Y-m-d H:i:s'), $usuario['login']]);
    
        return $token;
    }
    

    public function contarUsuarios() {
        $sql = "SELECT COUNT(*) FROM usuarios";
        return $this->executarQuery($sql)->fetchColumn();
    }

    public function mostrarUsuarios() {
        $sql = "SELECT * FROM usuarios";
        return $this->executarQuery($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    private function executarQuery($sql, $params = []) {
        try {
            $stmt = $this->conexao->getConexao()->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            // Log or handle the error as needed
            error_log("Erro de consulta: " . $e->getMessage());
            return false;
        }
    }
    
}

?>
