   
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
    require_once 'classes/livrosClass.php';


    $categoriasClass = new Categorias();
    $titulosClass = new Titulos();
    $midiasClass = new Midias();
    $Livros = new Livros();


    $categoriesList = $categoriasClass->mostrarCategorias();
    $titulosList = $titulosClass->mostrarTitulos(); 

    // Passa o :: tipo :: pelo form e depois checa o valor para saber o que fazer quando recebe o posts
    //print_r($_POST);
    if (isset($_POST['tipo'])){
    

        if ($_POST['tipo'] == "livro"){
            $nome_arquivo = $_POST['nome_arquivo'];
            $titulo = $_POST['titulo'];
            $autor = $_POST['autor'];
            $paginas = $Livros->contarPaginas($nome_arquivo);
          //  $descricao = $_POST['descricao'];
           // $paginas = $_POST['paginas'];
           // $ano = $_POST['ano'];

            $id = $Livros->criarLivro($nome_arquivo, $titulo, $autor, null, $paginas, null);
           // print_r($id);
        }

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
        echo "Nenhum livro ou quadrinho encontrado";
    }
    foreach ($files as $file) {
             if ($file != '.' && $file != '..' && (pathinfo($file, PATHINFO_EXTENSION) == 'pdf')){
           // echo "Arquivo pdf";
            $info = $Livros->extrairDadosLivro($file);
            $Livros->renderizarLivro($info, $categoriesList, $titulosList);
            //print_r($info);
        }
    }
?>

<?php include './assets/modal/videos_novo_titulo.php' ?>
<?php //include './assets/modal/videos_thumbnail_titulo.php' ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>

<?php include 'footer.php'; ?>
