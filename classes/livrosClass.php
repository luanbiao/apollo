<?php

require_once 'conexaoClass.php';

class Livros {
    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
    }

    public function extrairDadosLivro($livro){
        $content = [];
        if (strpos($livro, '-') !== false) {
            // Se houver hífen, dividir o título e o autor
            list($titulo, $autor) = explode('-', $livro, 2);
            
            // Remover "_" do título
            $titulo = str_replace('_', ' ', $titulo);
    
            // Remover espaços em branco adicionais
            $titulo = trim($titulo);
            $autor = trim($autor);
            $autor = str_replace('.pdf', '', $autor);
        } else {
            // Se não houver hífen, considerar tudo como o título
            $titulo = str_replace('_', ' ', $livro);
            $autor = "Autor Desconhecido";
        }
    
        $content = ['nome_arquivo' => $livro, 'titulo' => $titulo, 'autor' => $autor];
    
        return $content;
    }

    public function extrairDadosLivroUpload($livro){
        $content = [];
        if (strpos($livro, '-') !== false) {
            // Se houver hífen, dividir o título e o autor
            list($titulo, $autor) = explode('-', $livro, 2);
            
            // Remover "_" do título
            $titulo = str_replace('_', ' ', $titulo);
    
            // Remover espaços em branco adicionais
            $titulo = trim($titulo);
            $autor = trim($autor);
            $autor = str_replace('.pdf', '', $autor);
        } else {
            // Se não houver hífen, considerar tudo como o título
            $titulo = str_replace('_', ' ', $livro);
            $autor = "Autor Desconhecido";
        }
    
        $content = ['nome_arquivo' => $livro, 'titulo' => $titulo, 'autor' => $autor];
    
        return $content;
    }

    
    public function renderizarLivro($livro, $categoriesList, $titulosList){
        //print_r($info);
        $Livros = new Livros();
        echo '<div class="position-relative">';
        echo '<div class="card mb-3 bg-dark text-white">';
        echo '<div class="card-body">';
        echo $Livros->criarFormularioLivro($livro);
       // $nomeArquivo = $Arquivos->ajustarNome($info['filename']);
       // echo $Arquivos->criarFormularioCurso($info['filename'], $duracao, $titulosList);
        echo "</div></div>";
        echo '<div class="rotate-90 bg-primary text-white p-1">
        Livro';
        echo "</div></div>";
    }
    
    public function criarFormularioLivro($livro) {
  
    $nome_arquivo = $livro['nome_arquivo'];
    $titulo = $livro['titulo'];
    $autor =  $livro['autor'];
   // $paginas = $this->contarPaginas($nome_arquivo);
    $tipo_arquivo = substr($nome_arquivo, -4);

    

    // Generate the form HTML with Bootstrap classes
    $form = '<form action="leituras.php" method="post">

        <input type="hidden" name="tipo" value="livro" class="form-control">

        <div class="mb-3 row">
            <label for="nome_arquivo" class="form-label col-sm-2">Nome do Arquivo:</label>
            <div class="col-sm-10">
                <input type="text" name="nome_arquivo" value="' . $nome_arquivo . '" class="form-control  input-bloqueado" required readonly>
            </div>
        </div>


        <div class="mb-3 row">
            <label for="titulo" class="form-label col-sm-2">Título:</label>
            <div class="col-sm-4">
                <input type="text" name="titulo" value="' . $titulo . '" class="form-control" required>
            </div>

            <label for="autor" class="form-label col-sm-2">Autor:</label>
            <div class="col-sm-4">
                <input type="text" name="autor" value="' . $autor . '" class="form-control" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar Mídia</button>
    </form>';

    // Return the generated form HTML
    return $form;
    }
    
    public function consultarLivro($titulo) {
        try {
            // Consultar o livro pelo título
            $consultarLivroSql = "SELECT * FROM livros WHERE titulo = ?";
            $resultado = $this->executarQuery($consultarLivroSql, [$titulo]);
    
            // Verificar se encontrou algum resultado
            if ($resultado->rowCount() > 0) {
                // Retornar os dados do livro
                return ['success' => true, 'livro' => $resultado->fetch(PDO::FETCH_ASSOC)];
            } else {
                return ['success' => false, 'message' => 'Livro não encontrado.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro ao consultar o livro: ' . $e->getMessage()];
        }
    }

    
    public function criarLivro($nome_arquivo, $titulo, $autor, $descricao, $paginas, $ano) {
        try {
            // Verificar se o livro já existe
            $livroExistente = $this->consultarLivro($titulo);
    
            if ($livroExistente['success']) {
                return ['success' => false, 'message' => 'Um livro com esse título já está cadastrado'];
            } else {
    

            // Se o livro não existe, inserir na tabela
            $inserirLivroSql = "INSERT INTO livros (titulo, autor, descricao, paginas, ano) VALUES (?, ?, ?, ?, ?)";
            $result = $this->executarQuery($inserirLivroSql, [$titulo, $autor, $descricao, $paginas, $ano]);
            $lastInsertId = $this->conexao->getConexao()->lastInsertId();
            if ($result !== false) {
                $this->gerarCapa($nome_arquivo, $lastInsertId);
                $this->movimentarLivro($nome_arquivo, $lastInsertId);
                return ['success' => true, 'message' => 'Livro inserido com sucesso', 'lastInsertId' => $lastInsertId];
            } else {
                return ['success' => false, 'message' => 'Erro ao inserir o livro. Detalhes: ' . print_r($this->conexao->getConexao()->errorInfo(), true)];
            }
        }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro ao inserir o livro: ' . $e->getMessage()];
        }
    }

    public function criarLivroUpload($arquivo, $titulo, $autor, $descricao, $paginas, $ano) {
        try {
            // Verificar se o livro já existe
            $livroExistente = $this->consultarLivro($titulo);
    
            if ($livroExistente['success']) {
                return ['success' => false, 'message' => 'Um livro com esse título já está cadastrado'];
            } else {
    

            // Se o livro não existe, inserir na tabela
            $inserirLivroSql = "INSERT INTO livros (titulo, autor, descricao, paginas, ano) VALUES (?, ?, ?, ?, ?)";
            $result = $this->executarQuery($inserirLivroSql, [$titulo, $autor, $descricao, $paginas, $ano]);
            $lastInsertId = $this->conexao->getConexao()->lastInsertId();
            if ($result !== false) {
                $this->gerarCapaUpload($arquivo, $lastInsertId);
                $this->gravarLivroUpload($arquivo, $lastInsertId);
                return ['success' => true, 'message' => 'Livro inserido com sucesso', 'lastInsertId' => $lastInsertId];
            } else {
                return ['success' => false, 'message' => 'Erro ao inserir o livro. Detalhes: ' . print_r($this->conexao->getConexao()->errorInfo(), true)];
            }
        }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro ao inserir o livro: ' . $e->getMessage()];
        }
    }
    
    public function movimentarLivro($nome_arquivo, $id){
        try {
            // Move o arquivo para o diretório correto
            $sourcePath = "./vids/$nome_arquivo";
            $destinationPath = "./titulos/livros/$id.pdf";
    
            if (rename($sourcePath, $destinationPath)) {
                return ['success' => true, 'message' => 'Livro movido com sucesso'];
            } else {
                return ['success' => false, 'message' => 'Erro ao mover o livro'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erro ao mover o livro: ' . $e->getMessage()];
        }
    }

    public function gravarLivroUpload($arquivo, $id){
        try {
            // Obtém o nome original do arquivo
        //    $nome_arquivo = $arquivo['name'];
    
            // Define o caminho de destino
            $destinationPath = "./titulos/livros/$id.pdf";
    
            // Move o arquivo para o destino
            if (move_uploaded_file($arquivo['tmp_name'], $destinationPath)) {
                return ['success' => true, 'message' => 'Livro gravado com sucesso'];
            } else {
                return ['success' => false, 'message' => 'Erro ao gravar o livro'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erro ao gravar o livro: ' . $e->getMessage()];
        }
    }
    

    public function gerarCapa($nome_arquivo, $id){
        // Path to the PDF file
        $pdfFilePath = 'C:/xampp/htdocs/apollo/vids/';
        $pdfFilePath = $pdfFilePath . $nome_arquivo;
        // Output path for the PNG image
        $imageFilePath = 'C:/xampp/htdocs/apollo/titulos/livros/thumbs/'; // Different file name and PNG extension
        $imageFilePath = $imageFilePath . $id . ".png";

        // Create Imagick object
        $pdf = new Imagick();
        $pdf->readImage($pdfFilePath);

        // Select the first page of the PDF
        $pdf->setIteratorIndex(0);

        // Convert the first page to PNG
        $pdf->setImageFormat('png');
        $pdf->setImageCompressionQuality(100);

        // Save the PNG image
        $pdf->writeImage($imageFilePath);

        // Clear resources
        $pdf->clear();
        $pdf->destroy();
    }

    public function gerarCapaUpload($arquivo, $id){
        // Path to the PDF file
       // $pdfFilePath = 'C:/xampp/htdocs/apollo/vids/';
       // $pdfFilePath = $pdfFilePath . $nome_arquivo;
        // Output path for the PNG image
        $imageFilePath = 'C:/xampp/htdocs/apollo/titulos/livros/thumbs/'; // Different file name and PNG extension
        $imageFilePath = $imageFilePath . $id . ".png";

        // Create Imagick object
        $pdf = new Imagick();
        $pdf->readImage($arquivo['tmp_name']);

        // Select the first page of the PDF
        $pdf->setIteratorIndex(0);

        // Convert the first page to PNG
        $pdf->setImageFormat('png');
        $pdf->setImageCompressionQuality(100);

        // Save the PNG image
        $pdf->writeImage($imageFilePath);

        // Clear resources
        $pdf->clear();
        $pdf->destroy();
    }

    public function contarPaginas($nome_arquivo){
        $pdfFilePath = 'C:/xampp/htdocs/apollo/vids/';
        $pdfFilePath = $pdfFilePath . $nome_arquivo;

        try {
            // Cria uma nova instância do Imagick
            $imagick = new \Imagick();
        
            // Lê o arquivo PDF
            $imagick->readImage($pdfFilePath);
        
            // Obtém o número de páginas
            $numPages = $imagick->getNumberImages();
        
            // Exibe o número de páginas
            return $numPages;
        } catch (\ImagickException $e) {
            // Trate exceções, se ocorrerem
            echo "Erro: " . $e->getMessage();
        }

    }

    public function contarPaginasUpload($arquivo){
        try {
            // Cria uma nova instância do Imagick
            $imagick = new \Imagick();
        
            // Lê o arquivo PDF
            $imagick->readImage($arquivo);
        
            // Obtém o número de páginas
            $numPages = $imagick->getNumberImages();
        
            // Exibe o número de páginas
            return $numPages;
        } catch (\ImagickException $e) {
            // Trate exceções, se ocorrerem
            echo "Erro: " . $e->getMessage();
        }

    }


    public function consultarLivros(){
        $sql = "SELECT * FROM livros";
        $resultado = $this->executarQuery($sql);

        // Verificar se encontrou algum resultado
        if ($resultado->rowCount() > 0) {
            // Retornar os dados do livro
            return ['success' => true, 'livro' => $resultado->fetchAll(PDO::FETCH_ASSOC)];
        } else {
            return ['success' => false, 'message' => 'Livro não encontrado.'];
        }
    }
    
    public function salvarPagina($pagina, $livro_id, $usuario_id){
        try {
            // Verificar se já existe um registro com o mesmo livro_id e usuario_id
            $checkSql = "SELECT id FROM livros_usuarios WHERE livrosId = ? AND usuariosId = ?";
            $checkResult = $this->executarQuery($checkSql, [$livro_id, $usuario_id]);
    
            if ($checkResult !== false && $checkResult->rowCount() > 0) {
                // Se o registro já existir, faça um UPDATE
                $updateSql = "UPDATE livros_usuarios SET pagina = ? WHERE livrosId = ? AND usuariosId = ?";
                $updateResult = $this->executarQuery($updateSql, [$pagina, $livro_id, $usuario_id]);
    
                if ($updateResult !== false) {
                    return ['success' => true, 'message' => 'Página atualizada com sucesso'];
                } else {
                    return ['success' => false, 'message' => 'Erro ao atualizar a página de leitura: ' . print_r($this->conexao->getConexao()->errorInfo(), true)];
                }
            } else {
                // Se o registro não existir, faça um INSERT
                $insertSql = "INSERT INTO livros_usuarios (pagina, livrosId, usuariosId) VALUES (?, ?, ?)";
                $insertResult = $this->executarQuery($insertSql, [$pagina, $livro_id, $usuario_id]);
                $lastInsertId = $this->conexao->getConexao()->lastInsertId();
    
                if ($insertResult !== false) {
                    return ['success' => true, 'message' => 'Página inserida com sucesso', 'lastInsertId' => $lastInsertId];
                } else {
                    
                    return ['success' => false, 'message' => 'Erro ao inserir a página de leitura: ' . print_r($this->conexao->getConexao()->errorInfo(), true)];
                }
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erro geral: ' . $e->getMessage()];
        }
    }
    
    public function consultarPagina($livro_id, $usuario_id){
        $sql = "SELECT pagina FROM livros_usuarios WHERE livrosId = ? and usuariosId = ?";
        $resultado = $this->executarQuery($sql, [$livro_id, $usuario_id]);
    
        // Verificar se encontrou algum resultado
        if ($resultado->rowCount() > 0) {
            // Retornar a numeração da página
            $pagina = $resultado->fetch(PDO::FETCH_ASSOC)['pagina'];
            return ['success' => true, 'pagina' => $pagina];
        } else {
            // Retornar 1 caso não haja resultado
            return ['success' => false, 'pagina' => 1, 'message' => 'Livro não encontrado.'];
        }
    }

    public function paginasLivro($livro_id){
        $sql = "SELECT paginas FROM livros WHERE id = ?";
        $resultado = $this->executarQuery($sql, [$livro_id]);
        if ($resultado->rowCount() > 0) {
            $paginas = $resultado->fetch(PDO::FETCH_ASSOC)['paginas'];
            return ['success' => true, 'paginas' => $paginas];
        } else {

            return ['success' => false, 'paginas' => 1, 'message' => 'Livro não encontrado.'];
        }
    }

    public function nomeLivro($livro_id){
        $sql = "SELECT titulo FROM livros WHERE id = ?";
        $resultado = $this->executarQuery($sql, [$livro_id]);
        if ($resultado->rowCount() > 0) {
            $titulo = $resultado->fetch(PDO::FETCH_ASSOC)['titulo'];
            return ['success' => true, 'titulo' => $titulo];
        } else {

            return ['success' => false, 'message' => 'Livro não encontrado.'];
        }
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
