<?php

require_once 'conexaoClass.php';

class Midias {
    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
    }

    public function criarMidia($nome, $descricao, $caminho, $thumb, $preview, $dataLancamento, $duracao, $temporada, $episodio, $titulosId) {
      /*  $sql = "INSERT INTO midias (nome, descricao, caminho, dataLancamento, duracao, temporada, episodio, titulosId) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        return $this->executarQuery($sql, [$nome, $descricao, $caminho, $dataLancamento, $duracao, $temporada, $episodio, $titulosId]);*/

        $sql = "INSERT INTO midias (nome, descricao, caminho, thumb, preview, dataLancamento, duracao, temporada, episodio, titulosId) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Execute the INSERT query
$result = $this->executarQuery($sql, [$nome, $descricao, $caminho, $thumb, $preview, $dataLancamento, $duracao, $temporada, $episodio, $titulosId]);

// Check if the query was successful
if ($result) {
    // Retrieve the last inserted ID
    $lastInsertId = $this->conexao->getConexao()->lastInsertId();

    // Update the record with the calculated caminho value
    $newCaminho = $lastInsertId . ".mp4";
    $newThumb = $lastInsertId . ".png";
    $newPreview = $lastInsertId . ".mp4";
    $updateSql = "UPDATE midias SET caminho = ?, thumb = ?, preview = ? WHERE id = ?";
    $this->executarQuery($updateSql, [$newCaminho, $newThumb, $newPreview, $lastInsertId]);
}

return $result;
    }
    

    public function consultarMidia($id) {
        $sql = "SELECT * FROM midias WHERE id = ?";
        return $this->executarQuery($sql, [$id])->fetch(PDO::FETCH_ASSOC);
    }

    public function removerMidia($id) {
        $sql = "DELETE FROM midias WHERE id = ?";
        return $this->executarQuery($sql, [$id]);
    }

    public function alterarMidia($id, $novoNome, $novaDescricao, $novoCaminho, $novaDataLancamento, $novaDuracao, $novaTemporada, $novoEpisodio, $novoTitulosId) {
        $sql = "UPDATE midias SET nome = ?, descricao = ?, caminho = ?, dataLancamento = ?, duracao = ?, temporada = ?, episodio = ?, titulosId = ? 
                WHERE id = ?";
        return $this->executarQuery($sql, [$novoNome, $novaDescricao, $novoCaminho, $novaDataLancamento, $novaDuracao, $novaTemporada, $novoEpisodio, $novoTitulosId, $id]);
    }

    public function contarMidias() {
        $sql = "SELECT COUNT(*) FROM midias";
        return $this->executarQuery($sql)->fetchColumn();
    }

    public function mostrarMidias() {
        $sql = "SELECT * FROM midias";
        return $this->executarQuery($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function mostrarMidiasTitulos($idTitulo){
        $sql = "SELECT * from midias WHERE titulosId = ?";
        return $this->executarQuery($sql, [$idTitulo])->fetchAll(PDO::FETCH_ASSOC);;
    }

    public function mostrarMidiasCategorias($catId){
        // Consulta para obter os títulos associados à categoria
        $sql = "SELECT * FROM titulos WHERE catId = ?";
        $titulos = $this->executarQuery($sql, [$catId])->fetchAll(PDO::FETCH_ASSOC);
    
        // Inicializa um array para armazenar as mídias associadas aos títulos
        $midiasAssociadas = array();
    
        // Para cada título encontrado, obtenha as mídias associadas
        foreach ($titulos as $titulo) {
            $titulosId = $titulo['id'];
            $sql = "SELECT * FROM midias WHERE titulosId = ?";
            $midiasDoTitulo = $this->executarQuery($sql, [$titulosId])->fetchAll(PDO::FETCH_ASSOC);
    
            // Adiciona as mídias associadas ao array
            $midiasAssociadas = array_merge($midiasAssociadas, $midiasDoTitulo);
        }
    
        return $midiasAssociadas;
    }
    

    public function consultarMidiasEpisodios($nome, $temporada, $episodio){
        $sql = "SELECT * FROM midias WHERE nome = ? AND temporada = ? AND episodio = ?";
        
        try {
            $stmt = $this->executarQuery($sql, [$nome, $temporada, $episodio]);
            return $stmt !== false && $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function extrairThumbMidia($filename){
        $inputFile = './vids/' . $filename;
            $uploadsFolder = 'titulos/midias/thumbs/';
        
            if (!file_exists($uploadsFolder)) {
                mkdir($uploadsFolder, 0777, true);
            }
                $thumbnailFile = $uploadsFolder . pathinfo($inputFile, PATHINFO_FILENAME) . '-thumbnail.png';
                $command = "C:\\xampp\\htdocs\\apollo\\ffmpeg\\bin\\ffmpeg -i \"$inputFile\" -ss 00:00:05 -vframes 1 -q:v 2 \"$thumbnailFile\"";
                exec($command, $output, $returnCode);

    }

    public function extrairPreviewMidia($filename){
        $inputFile = './vids/' . $filename;
        $uploadsFolder = './titulos/midias/previews/';

        if (!file_exists($uploadsFolder)) {
            mkdir($uploadsFolder, 0777, true);
        }
    
        $outputFile = $uploadsFolder . pathinfo($inputFile, PATHINFO_FILENAME) . '-preview.mp4';
    
        $command = "C:\\xampp\\htdocs\\apollo\\ffmpeg\\bin\\ffmpeg -i \"$inputFile\" -ss 0 -t 15 -c:v libx265 -c:a aac -strict experimental -movflags faststart \"$outputFile\" > output.log 2>&1";
        exec($command, $output, $returnCode);
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
