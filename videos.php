<script src="./assets/js/videos.js"></script>
    
<style>
    .rotate-90 {
      writing-mode: vertical-rl;
      text-orientation: mixed;
      transform: rotate(180deg);
      position: absolute;
      top: 2%;
      left: 2%;
      transform-origin: bottom left;
      transform: translate(-50%, -50%) rotate(180deg);
    }
  </style>

    <?php 
    include 'header.php'; 

    require_once 'classes/categoriasClass.php';
    require_once 'classes/titulosClass.php';
    require_once 'classes/midiasClass.php';
    require_once 'classes/arquivosClass.php';
    require_once 'classes/videosClass.php';

    $categoriasClass = new Categorias();
    $titulosClass = new Titulos();
    $midiasClass = new Midias();
    $Arquivos = new Arquivos();
    $Videos = new Videos();

    $categoriesList = $categoriasClass->mostrarCategorias();
    $titulosList = $titulosClass->mostrarTitulos(); 

    // Passa o :: tipo :: pelo form e depois checa o valor para saber o que fazer quando recebe o posts
    //print_r($_POST);
    if (isset($_POST['tipo'])){
        if ($_POST['tipo'] == "anime"){
            $filename = $_POST['filename_anime'];
            $titulo = $_POST['titulo_anime'];
            $nome_episodio = $_POST['nome_episodio_anime'];
            $extensao = $_POST['extensao_anime'];
            $episodio = $_POST['episodio_anime'];
            $temporada = $_POST['temporada_anime'];
            $duracao = $_POST['duracao_anime'];
            $categoria = $_POST['categoria_anime'];
            $thumbnail_preview = $_POST['thumb_preview_anime'];

            $momento_thumb = '0:02';
            $momento_preview = '0:05';
          /*  echo "É anime";
            echo $titulo;*/
            $id = $titulosClass->pegarIdTitulo($titulo);    
           // echo $id;
            
        } 

        if ($_POST['tipo'] == "curso"){
            $filename = $_POST['filenamefull'];
            $nome_episodio = $_POST['filename'];
            $titulo = $_POST['titulo'];
            $temporada = $_POST['temporada'];
            $episodio = $_POST['episodio'];
            $duracao = $_POST['duracao'];
            $filenamealt = $_POST['filename'];
            $momento_thumb = '0:15';
            $momento_preview = '0:10';
            $thumbnail_preview = $_POST['thumb_preview'];

            $id = $titulosClass->pegarIdTitulo($titulo);
        }



      if (!isset($id)){
            echo "Não setado!" . $id;
            // Não possui título
            $titulosClass->criarTitulo($titulo,null,null, $categoria);

            if (isset($thumbnail_preview)){
                if ($thumbnail_preview == "Sim"){
                    $titulosClass->extrairThumbTitulo(null, $momento_thumb, $filename);
                    $titulosClass->extrairPreviewTitulo(null, $momento_preview, $filename);
                }
            }
          
            $id_titulo_anime = $titulosClass->pegarIdTitulo($titulo);
            $midiasClass->criarMidia($nome_episodio, null, null, null, null, null, $duracao, $temporada, $episodio, $id_titulo_anime);
            $midiasClass->extrairThumbMidia($filename);
            $midiasClass->extrairPreviewMidia($filename);
        } else {
            $titulosClass->extrairThumbTitulo(null, $momento_thumb, $filename);
            $titulosClass->extrairPreviewTitulo(null, $momento_preview, $filename);
            $midiasClass->criarMidia($nome_episodio, null, null, null, null, null, $duracao, $temporada, $episodio, $id);
            $midiasClass->extrairThumbMidia($filename);
            $midiasClass->extrairPreviewMidia($filename);
        }
         echo '<script>movimentarArquivos(\'' . $nome_episodio . '\', \'' . $filename . '\');</script>';
    }

    if (isset($_POST['cadastrar_titulo'])){
        $titulo = $_POST['novoTitulo'];
        $catId = $_POST['novaCategoria'];
        $titulosClass->criarTitulo($titulo,null,null, $catId);
        header('Location: videos.php');
    }
?>
<div class="container mt-4">
    <h2 class="mb-4">Informações de Arquivos</h2>

    <?php
    $directory = './vids'; 
    $files = scandir($directory);
    if (sizeof($files) < 3) {
        echo "Nenhum vídeo encontrado";
    }
    foreach ($files as $file) {
        if ($file != '.' && $file != '..' && !strpos($file, '-preview') && (pathinfo($file, PATHINFO_EXTENSION) == 'mkv' || pathinfo($file, PATHINFO_EXTENSION) == 'mp4')) {
            $info = $Arquivos->extrairDadosArquivo($file);
            $curso_serie = $Arquivos->verificarNome($info['filename']);
            if ($curso_serie == true){
                $Videos->renderizarAnime($info, $categoriesList, $titulosList);
            } else {
                $Videos->renderizarCurso($info, $categoriesList, $titulosList);

            }
        }

        if ($file != '.' && $file != '..' && (pathinfo($file, PATHINFO_EXTENSION) == 'pdf')){
            echo "Arquivo pdf";
        }
    }
?>

<?php include './assets/modal/videos_novo_titulo.php' ?>
<?php //include './assets/modal/videos_thumbnail_titulo.php' ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>

<?php include 'footer.php'; ?>
