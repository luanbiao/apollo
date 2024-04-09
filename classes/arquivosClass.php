<?php

require_once 'conexaoClass.php';
require_once 'categoriasClass.php';




class Arquivos {
    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
    }

   public function verificarNome($filename){
        
    // Verifica se é uma Série ou Curso == Se possui S{n} ou E{n}

        $pattern = '/S\d+E\d+/';
    
        if (preg_match($pattern, $filename)) {
        //    echo "A mídia é um série:" . $filename;
            return true;
        } else {
          //  echo "A mídia é um curso:" . $filename;
            return false;
        }
    }
    
    public function extrairDadosArquivo($filename){

    $info = [];
    $info['filename'] = $filename;

    // Extrair informações específicas para .mp4 e .mkv
    if (preg_match('/\.(mp4|mkv)$/i', $filename)) {
        $matches = [];
        // Padrão para nome da mídia, temporada, episódio, e título do episódio
        $pattern = '/^([^\d]+)S(\d+)E(\d+).+?(\S.*?)(?=\.\d)/i';

        if (preg_match($pattern, $filename, $matches)) {
            $info['media_name'] = str_replace('.', ' ', trim($matches[1]));
            $info['season'] = $matches[2];
            $info['episode'] = $matches[3];
            $info['catId'] = isset($matches[4]) ? $matches[4] : null;
            //   $info['episode_title'] = trim($matches[4]);
            $info['filetype'] = pathinfo($filename, PATHINFO_EXTENSION);
        }
    }

    return $info;
    }

    public function criarFormularioCurso($nomedoarquivo, $duracao, $titulosList) {
            // Define a pattern to match the components
            $pattern = '/^(\d+)\s*[\.\-]?\s*(.+)\.(mp4)$/';

            if (preg_match($pattern, $nomedoarquivo, $matches)) {
           
                $aula = $matches[1];      // Aula
                $nome = $matches[2];      // Nome
                $filetype = $matches[3];  // Extensão

            }        
        
        $filetype = substr($nomedoarquivo, -4);
    
        // Generate the form HTML with Bootstrap classes
        $form = '<form action="videos.php" method="post">

        <input type="hidden" name="tipo" value="curso" class="form-control">
        <input type="hidden" name="filenamefull" value="' . $nomedoarquivo . '" class="form-control" required>

        <div class="mb-3 row">
            <label for="filename" class="form-label col-sm-2">Nome do Arquivo:</label>
            <div class="col-sm-10">
                <input type="text" name="filename" value="' . $nome . '" class="form-control  input-bloqueado" required readonly>
            </div>
        </div>
    
        <div class="mb-3 row">
            <label for="filetype" class="form-label col-sm-2">Extensão:</label>
            <div class="col-sm-4">
                <input type="text" name="filetype" value="' . $filetype . '" class="form-control input-bloqueado" readonly>
            </div>
            <label for="duracao" class="form-label col-sm-2">Duração:</label>
            <div class="col-sm-4">
                <input type="text" name="duracao" value="' . $duracao . '" class="form-control input-bloqueado" readonly>
            </div>
        </div>
        
        <div class="mb-3 row">
            <label for="titulo" class="form-label col-sm-2">Título:</label>
            <div class="col-sm-3">
                <select name="titulo" class="form-select" required>';
            
                // Loop through $titulosList to create options for the select
                foreach ($titulosList as $titulo) {
                    $form .= '<option value="' . $titulo['nome'] . '">' . $titulo['nome'] . '</option>';
                }
    
            $form .= '</select>
            </div>
            <div class="col-sm-1">
            <button class="btn btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#novoItemModal">
                    <i class="mdi mdi-plus"></i>
        </button>
        
            </div>
            <label for="thumb_preview" class="form-label col-sm-2">Gerar Thumbnail:</label>
                <div class="col-sm-4">
                    <select name="thumb_preview" class="form-control" required>
                        <option value="Não">Não</option>
                        <option value="Sim">Sim</option>
                    </select>
                </div>
        </div>
    
        <div class="mb-3 row">
            <label for="temporada" class="form-label col-sm-2">Capítulo:</label>
            <div class="col-sm-4">
                <input type="text" name="temporada" class="form-control" required>
            </div>

            <label for="episodio" class="form-label col-sm-2">Aula:</label>
            <div class="col-sm-4">
                <input type="text" name="episodio" value="' . $aula . '" class="form-control" required>
            </div>
        </div>
    
        
    
        <button type="submit" class="btn btn-success">Cadastrar Mídia</button>
    </form>';
    
    // Return the generated form HTML
    return $form;
            }

    public function criarFormularioAnime($nomedoarquivo, $duracao){
        $Categorias = new Categorias();
        $categorias = $Categorias->mostrarCategorias();
        // Anime tem: Temporada (SXX), Episódio (EXX), Filetype (extract), Nome (before SXX), Categoria (Select), Nome do Episódio (Inputar/Procurar no arquivo?)

        $form = '<form action="videos.php" method="post">
        <input type="hidden" name="tipo" value="anime" class="form-control" required>
        <div class="mb-3 row">
            <label for="filename_anime" class="form-label col-sm-2">Nome do Arquivo:</label>
            <div class="col-sm-10">
            <input type="text" name="filename_anime" value="' . $nomedoarquivo . '" class="form-control input-bloqueado" required readonly>
            </div>
        </div>

        <div class="mb-3 row">
        <label for="duracao_anime" class="form-label col-sm-2">Duração:</label>
        <div class="col-sm-4">
            <input type="text" name="duracao_anime" value="' . $this->pegarDuracao($nomedoarquivo) . '" class="form-control input-bloqueado" required readonly>
        </div>
        <label for="extensao_anime" class="form-label col-sm-2">Extensão:</label>
            <div class="col-sm-4">
                <input type="text" name="extensao_anime" value="' . $this->pegarTipo($nomedoarquivo) . '" class="form-control input-bloqueado" required readonly>
            </div>
         </div>

        <div class="mb-3 row">
            <label for="titulo_anime" class="form-label col-sm-2">Título:</label>
            <div class="col-sm-10">
                <input type="text" name="titulo_anime" value="' . $this->pontoEspaco($this->pegarTitulo($nomedoarquivo)) . '" class="form-control" required>
            </div>
           
            
        </div>

        <div class="mb-3 row">
            <label for="nome_episodio_anime" class="form-label col-sm-2">Nome do Episódio:</label>
            <div class="col-sm-10">
                <input type="text" name="nome_episodio_anime" value="' . $this->pontoEspaco($this->pegarNome($nomedoarquivo)) . '" class="form-control" required>
            </div>
        </div>



        <div class="mb-3 row">
            <label for="temporada_anime" class="form-label col-sm-2">Temporada:</label>
            <div class="col-sm-4">
                <input type="text" name="temporada_anime" value="' . $this->pegarTemporada($nomedoarquivo) . '" class="form-control" required>
            </div>
            <label for="episodio_anime" class="form-label col-sm-2">Episódio:</label>
            <div class="col-sm-4">
            <input type="text" name="episodio_anime" value="' . $this->pegarEpisodio($nomedoarquivo) . '" class="form-control" required>
            </div>
        </div>


    

        <div class="mb-3 row">
        <label for="categoria_anime" class="form-label col-sm-2">Categoria:</label>
            <div class="col-sm-4">
                <select class="form-control mb-3" id="categoria_anime" name="categoria_anime" required>';

                foreach ($categorias as $categoria) {
                    $form .= "<option value='{$categoria['id']}'>{$categoria['nome']}</option>";
                }

                $form .= '</select></div>';
                $form .= ' <label for="thumb_preview_anime" class="form-label col-sm-2">Gerar Thumbnail:</label>
                <div class="col-sm-4">
                    <select name="thumb_preview_anime" class="form-control" required>
                        <option value="Não">Não</option>
                        <option value="Sim">Sim</option>
                    </select>
                </div>';
                
                $form .= '</div>';

                $form .= '<button type="submit" class="btn btn-warning">Cadastrar Mídia</button>
        </form>';

        return $form;
    }

    
    public function pegarTemporada($nomedoarquivo) {
        preg_match('/S(\d{2})/', $nomedoarquivo, $matches);
        if (!empty($matches[1])) {
            return $matches[1];
        }
        return null;
    }

    public  function pegarEpisodio($nomedoarquivo) {
        preg_match('/E(\d{2})/', $nomedoarquivo, $matches);
        if (!empty($matches[1])) {
            return $matches[1];
        }
        return null;
    }

    public function pegarTitulo($nomedoarquivo){
        preg_match('/(.*)S(\d{2})/', $nomedoarquivo, $matches);
           if (!empty($matches[1])) {
            return $matches[1];
        }
        return null;
    }

    public function pegarNome($nomedoarquivo){
        preg_match('/E01\.(.*?)(\d{3})/', $nomedoarquivo, $matches);
           if (!empty($matches[1])) {
            return $matches[1];
        }

        preg_match('/E(\d{2})/', $nomedoarquivo, $matches);
        if (!empty($matches[1])) {
            return "Episódio " . $matches[1];
        }

        return "Insira um nome";
    }

    public function pontoEspaco($texto){
        return rtrim(str_replace('.', ' ', $texto));
    }

    public function pegarTipo($nomedoarquivo){
        return substr($nomedoarquivo, -4);
    }
    
    
    public function pegarDuracao($filename){
        $inputFile = 'vids/' . $filename;
        $ffprobeCommand = "C:\\xampp\\htdocs\\apollo\\ffmpeg\\bin\\ffprobe -i \"$inputFile\" -show_entries format=duration -v quiet -of csv=\"p=0\"";
        $durationSeconds = exec($ffprobeCommand);
    
        // Convert duration to mm:ss format
        $minutes = floor($durationSeconds / 60);
        $seconds = $durationSeconds % 60;
        $formattedDuration = sprintf('%02d:%02d', $minutes, $seconds);
    
        return $formattedDuration;
    }
    
    public function checarThumb($nomeArquivo) {
        $thumbsFolder = './titulos/midias/thumbs/';
        $thumbFileName = pathinfo($nomeArquivo, PATHINFO_FILENAME) . '-thumbnail.png';
        $thumbFilePath = $thumbsFolder . $thumbFileName;
        return file_exists($thumbFilePath);
    }
    
    public function checarPreview($nomeArquivo) {
        $previewsFolder = './titulos/midias/previews/';
    
        $previewFileName = pathinfo($nomeArquivo, PATHINFO_FILENAME) . '-preview.mp4';
    
        $previewFilePath = $previewsFolder . $previewFileName;
    
        return file_exists($previewFilePath);
    }

    public function movimentar($filename){

    }
    
    public function ajustarNome($filename){
        $pattern = '/^(\d+)\s*[\.\-]?\s*(.+)\.(mp4)$/';

        if (preg_match($pattern, $filename, $matches)) {
            $aula = $matches[1];      // Aula
            $nome = $matches[2];      // Nome
            $filetype = $matches[3];  // Extensão

        }        
        return $nome;
    }

 

    public function extrairDadosLivro($livro){

  
        $content = [];
    
        // Verificar se há um hífen "-"
        if (strpos($livro, '-') !== false) {
            // Se houver hífen, dividir o título e o autor
            list($titulo, $autor) = explode('-', $livro, 2);
            
            // Remover "_" do título
            $titulo = str_replace('_', ' ', $titulo);
    
            // Remover espaços em branco adicionais
            $titulo = trim($titulo);
            $autor = trim($autor);
        } else {
            // Se não houver hífen, considerar tudo como o título
            $titulo = str_replace('_', ' ', $livro);
            $autor = "Autor Desconhecido";
        }
    
        $content = ['titulo' => $titulo, 'autor' => $autor];
    
        return $content;
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
