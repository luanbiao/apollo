<style>
body{
    height: 800px;
}
</style>
<?php 

include 'header.php'; 
require_once 'classes/livrosClass.php';

if ($_FILES) {
    $Livros = new Livros();
    $arquivo = $_FILES['arquivo'];
    $info = $Livros->extrairDadosLivroUpload($_FILES['arquivo']['name']);
    $titulo = $info['titulo'];
    $autor = $info['autor'];
    $paginas = $Livros->contarPaginasUpload($_FILES['arquivo']['tmp_name']);
    $resultado = $Livros->criarLivroUpload($arquivo, $titulo, $autor, null, $paginas, null);
       if (isset($resultado)){
            if ($resultado > 0){
                $resultado = $resultado['message'];/* . ": " . $resultado['lastInsertId'];*/
            }
        }
}

?>

<body class="d-flex align-items-center">
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center " style="min-height: 90vh;">
            <div class="col-10 col-xl-3 text-center text-white p-4 rounded fundo">
                <h1 class="mb-4">Envie seu arquivo pdf</h1>
                <form class="form" method="POST" enctype="multipart/form-data">
                    <input class="form-control" name="arquivo" type="file">
                    <input type="submit" class="btn btn-success mt-2 w-100">
                </form>
                <div>
                    <?php if (isset($resultado)) echo($resultado) ?>
                </div>
            </div>
        </div>
    </div>
</body>

