<?php

require_once 'conexaoClass.php';

class Titulos {
    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
    }

    public function criarTitulo($nome, $thumb, $preview, $catId) {
        try {
            // Verificar se o título já existe
            $verificarNomeSql = "SELECT COUNT(*) as count FROM titulos WHERE nome = ?";
            $resultado = $this->executarQuery($verificarNomeSql, [$nome]);
    
            // Extrair o resultado da contagem
            $count = $resultado->fetch(PDO::FETCH_ASSOC)['count'];
    
            if ($count > 0) {
                // O título já existe, retornar uma mensagem de erro
                return ['success' => false, 'message' => 'Title with the same name already exists'];
            }
    
            // Se o título não existe, inserir na tabela
            $inserirTituloSql = "INSERT INTO titulos (nome, thumb, preview, catId, dataCriacao) VALUES (?, ?, ?, ?, NOW())";
          //  $this->executarQuery($inserirTituloSql, [$nome, $thumb, $preview, $catId]);
    
            // Execute the INSERT query
            $result = $this->executarQuery($inserirTituloSql, [$nome, $thumb, $preview, $catId]);

            // Check if the query was successful
            if ($result) {
                // Retrieve the last inserted ID
                $lastInsertId = $this->conexao->getConexao()->lastInsertId();

                // Update the record with the calculated caminho value
                $novoThumb = $lastInsertId . ".png";
                $novoPreview = $lastInsertId . ".mkv";
                $updateSql = "UPDATE titulos SET thumb = ?, preview = ? WHERE id = ?";
                $this->executarQuery($updateSql, [$novoThumb, $novoPreview, $lastInsertId]);
            }

//return $result;



            return ['success' => true, 'message' => 'Title created successfully'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error creating title: ' . $e->getMessage()];
        }
    }
    
    
        

    public function consultarTitulo($id) {
        $sql = "SELECT * FROM titulos WHERE id = ?";
        return $this->executarQuery($sql, [$id])->fetch(PDO::FETCH_ASSOC);
    }

 

    public function removerTitulo($id) {
        $sql = "DELETE FROM titulos WHERE id = ?";
        return $this->executarQuery($sql, [$id]);
    }

    public function alterarTitulo($id, $novoNome, $novaThumb, $novoPreview, $novoCatId) {
        $sql = "UPDATE titulos SET nome = ?, thumb = ?, preview = ?, catId = ? WHERE id = ?";
        return $this->executarQuery($sql, [$novoNome, $novaThumb, $novoPreview, $novoCatId, $id]);
    }

    public function contarTitulos() {
        $sql = "SELECT COUNT(*) FROM titulos";
        return $this->executarQuery($sql)->fetchColumn();
    }

    public function mostrarTitulos() {
        $sql = "SELECT * FROM titulos";
        return $this->executarQuery($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function mostrarTitulosCategorias($catId) {
        $sql = "SELECT t.*, c.nome AS nome_categoria FROM titulos t
                INNER JOIN categorias c ON t.catId = c.id
                WHERE t.catId = ?";
        return $this->executarQuery($sql, [$catId])->fetchAll(PDO::FETCH_ASSOC);
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

    public function extrairThumbTitulo($tituloId, $duracao, $nomeArquivo) {
        $inputFile = './vids/' . $nomeArquivo;
        $uploadsFolder = 'titulos/thumbs/';
    
        //echo "Input File: $inputFile<br>";
        //echo "Uploads Folder: $uploadsFolder<br>";
    
        if (!file_exists($uploadsFolder)) {
            mkdir($uploadsFolder, 0777, true);
        }
    
        $thumbnailFile = $uploadsFolder . pathinfo($inputFile, PATHINFO_FILENAME) . '-thumbnail.png';
        $command = "C:\\xampp\\htdocs\\apollo\\ffmpeg\\bin\\ffmpeg -i \"$inputFile\" -ss $duracao -vframes 1 -q:v 2 \"$thumbnailFile\"";
       // echo "Command: $command<br>";
    
        exec($command, $output, $returnCode);
    
        if ($returnCode !== 0) {
            $mensagem = 'Error: ' . implode("\n", $output) . $inputFile . " " . $uploadsFolder;
        } else {
          $mensagem = "Thumb carregado com sucesso para o título $nomeArquivo com ID: $tituloId e duração: $duracao.";
            // header('Location: gerar_titulo.php');
           // exit;
            // echo 'Thumbnail gerado com sucesso: ' . $thumbnailFile;
        }
        return $mensagem;
    }
    

    public function extrairPreviewTitulo($tituloId, $inicio, $nomeArquivo) {
      
        $inputFile = './vids/' . $nomeArquivo;

        // Specify the path for the "uploads" folder
        $uploadsFolder = './titulos/previews/';
    
        // Create the uploads folder if it doesn't exist
        if (!file_exists($uploadsFolder)) {
            mkdir($uploadsFolder, 0777, true);
        }
    
        // Generate the output file path inside the "uploads" folder
        $outputFile = $uploadsFolder . pathinfo($inputFile, PATHINFO_FILENAME) . '-preview.mp4';
    
        // Execute the FFmpeg command to generate a 30-second preview and redirect output to a log file
        $command = "C:\\xampp\\htdocs\\apollo\\ffmpeg\\bin\\ffmpeg -i \"$inputFile\" -ss $inicio -t 15 -c:v libx265 -c:a aac -strict experimental -movflags faststart \"$outputFile\" > output.log 2>&1";
        exec($command, $output, $returnCode);
    
        if ($returnCode !== 0) {
            $mensagem = 'Error: ' . implode("\n", $output) . $inputFile . " " . $uploadsFolder;
        } else {
          $mensagem = "Thumb carregado com sucesso para o título $nomeArquivo com ID: $tituloId e duração: $inicio.";
           /* header('Location: videos.php');
            exit;*/
            // echo 'Thumbnail gerado com sucesso: ' . $thumbnailFile;
        }
        return $mensagem;
    }
    
    public function alterarThumb($id, $novaThumb) {
        $sql = "UPDATE titulos SET thumb = ? WHERE id = ?";
        return $this->executarQuery($sql, [$novaThumb,$id]);
    }

    public function alterarPreview($id, $novoPreview) {
        $sql = "UPDATE titulos SET preview = ? WHERE id = ?";
        return $this->executarQuery($sql, [$novoPreview,$id]);
    }

    public function pegarIdTitulo($nome) {
        $sql = "SELECT id FROM titulos WHERE nome = ?";
        $stmt = $this->executarQuery($sql, [$nome]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if ($result) {
            return $result[0]['id'];  // Retorna o ID se existir
        } else {
            return null;
        }
    }
    
    
   

}

?>
